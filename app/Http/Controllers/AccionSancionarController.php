<?php

namespace App\Http\Controllers;

use App\Models\AccionSancionar;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\UsersController;
use App\Models\EstrategiasSancionar;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AccionSancionarController extends Controller
{
    public function index(Request $request, $estrategiaId)
    {
        $user = auth()->user();
        $user_name = $user->name;

        if ($user->hasRole('Administrador')) {
            $accionesSancionar = AccionSancionar::where('estrategia_id', $estrategiaId)->get();
        } else {
            $accionesSancionar = AccionSancionar::where('estrategia_id', $estrategiaId)
                ->where(function ($query) use ($user_name) {
                    $query->whereRaw("FIND_IN_SET('{$user_name}', REPLACE(dependencias_responsables, ', ', ',')) > 0")
                        ->orWhereRaw("FIND_IN_SET('{$user_name}', REPLACE(dependencias_coordinadoras, ', ', ',')) > 0");
                })
                ->get();
            }

        $estrategia = EstrategiasSancionar::find($estrategiaId);

        return view('estrategiassancionar.accionsancionar.index', compact('accionesSancionar', 'estrategia'));
    }

    public function create($estrategiaId)
    {
        $users = User::all();
        $estrategia = EstrategiasSancionar::find($estrategiaId);
        return view('estrategiassancionar.accionsancionar.create', compact('users', 'estrategia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'accion' => 'required|max:255',
            'tipo' => 'required',
            'estrategia_id' => 'required',
            // Puedes agregar más validaciones según tus necesidades
        ]);

        // Verificar si ya existe una acción con el mismo nombre dentro de la misma estrategia
        $accionExistente = AccionSancionar::where('accion', $request->accion)
            ->where('estrategia_id', $request->estrategia_id)
            ->first();

        if ($accionExistente) {
            Alert::error('Error', 'Ya existe una acción con ese nombre para la estrategia seleccionada.');
            return redirect()->back();
        }

        // Si no hay una acción con el mismo nombre, proceder con la creación
        $accionSancionar = new AccionSancionar();
        $accionSancionar->accion = $request->input('accion');
        $accionSancionar->tipo = $request->input('tipo');
        $accionSancionar->estrategia_id = $request->input('estrategia_id');

        $dependenciasResponsablesIds = $request->input('dependencias_responsables', []);
        $dependenciasCoordinadorasIds = $request->input('dependencias_coordinadoras', []);

        $dependenciasResponsables = User::whereIn('id', $dependenciasResponsablesIds)->pluck('name')->implode(', ');
        $dependenciasCoordinadoras = User::whereIn('id', $dependenciasCoordinadorasIds)->pluck('name')->implode(', ');

        $accionSancionar->dependencias_responsables = $dependenciasResponsables;
        $accionSancionar->dependencias_coordinadoras = $dependenciasCoordinadoras;

        $accionSancionar->save();
        Alert::success('Éxito', 'Acción creada exitosamente.');

        return redirect()->route('estrategiassancionar.accionsancionar.index', ['estrategia' => $request->estrategia_id]);
    }

    public function show($estrategiaId, $accion)
    {
        $accionSancionar = AccionSancionar::where('estrategia_id', $estrategiaId)->find($accion);

        return view('estrategiassancionar.accionsancionar.show', ['accionSancionar' => $accionSancionar, 'estrategiaId' => $estrategiaId]);
    }

    public function edit($estrategiaId, $accionSancionarId)
    {
        $accionSancionar = AccionSancionar::where('estrategia_id', $estrategiaId)->findOrFail($accionSancionarId);
        $estrategia = EstrategiasSancionar::findOrFail($estrategiaId); // Obtén la estrategia correspondiente

        $users = User::all();
        $dependencias_responsables = json_decode($accionSancionar->dependencia_responsable, true);
        $dependencias_coordinadoras = json_decode($accionSancionar->dependencia_coordinadora, true);

        return view('estrategiassancionar.accionsancionar.edit', compact('accionSancionar', 'users', 'dependencias_responsables', 'dependencias_coordinadoras', 'estrategia'));
    }

    public function update(Request $request, $estrategiaId, $accionSancionarId)
    {
        $request->validate([
            'accion' => 'required|max:255',
            'tipo' => 'required',
            // Puedes agregar más validaciones según tus necesidades
        ]);

        // Obtener la acción de sancionar existente
        $accionSancionar = AccionSancionar::find($accionSancionarId);

        if (!$accionSancionar) {
            return back()->with('error', 'La acción de sancionar no se pudo encontrar.');
        }

        // Verificar si ya existe otra acción con el mismo nombre dentro de la misma estrategia
        $otraAccionConMismoNombre = AccionSancionar::where('accion', $request->accion)
            ->where('estrategia_id', $estrategiaId)
            ->where('id', '<>', $accionSancionarId)
            ->first();

        if ($otraAccionConMismoNombre) {
            Alert::error('Error', 'Ya existe otra acción con ese nombre para la estrategia seleccionada.');
            return redirect()->back();
        }

        // Actualizar los campos de la acción de sancionar
        $accionSancionar->accion = $request->input('accion');
        $accionSancionar->tipo = $request->input('tipo');

        $dependenciasResponsablesIds = $request->input('dependencias_responsables', []);
        $dependenciasCoordinadorasIds = $request->input('dependencias_coordinadoras', []);

        $dependenciasResponsables = User::whereIn('id', $dependenciasResponsablesIds)->pluck('name')->implode(', ');
        $dependenciasCoordinadoras = User::whereIn('id', $dependenciasCoordinadorasIds)->pluck('name')->implode(', ');

        $accionSancionar->dependencias_responsables = $dependenciasResponsables;
        $accionSancionar->dependencias_coordinadoras = $dependenciasCoordinadoras;

        // Guardar los cambios en la base de datos
        $accionSancionar->save();
        Alert::success('Éxito', 'Acción editada exitosamente.');

        // Redirigir a la vista de detalle de la estrategia con la acción actualizada
        return redirect()->route('estrategiassancionar.accionsancionar.show', ['estrategia' => $estrategiaId, 'accion' => $accionSancionar->id])
            ->with('success', 'Acción de sancionar actualizada exitosamente.');
    }

    public function destroy($estrategiaId, $accionSancionarId)
    {
        $accionSancionar = AccionSancionar::where('estrategia_id', $estrategiaId)->findOrFail($accionSancionarId);

        try {
            $accionSancionar->delete();
            Alert::success('Éxito', 'Acción de sancionar eliminada exitosamente');
        } catch (QueryException $e) {
            if (Str::contains($e->getMessage(), 'constraint `accion_sancionar_estrategia_id_foreign`')) {
                Alert::error('Error', 'No se puede eliminar la acción de sancionar porque tiene evidencias relacionadas.');
            } else {
                Alert::error('Error', 'No se puede eliminar la acción de sancionar porque tiene evidencias relacionadas.');
            }
        }

        return redirect()->route('estrategiassancionar.accionsancionar.index', ['estrategia' => $accionSancionar->estrategia_id]);
    }
}
