<?php

namespace App\Http\Controllers;

use App\Models\AccionErradicar;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\UsersController;
use App\Models\EstrategiasErradicar;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AccionErradicarController extends Controller
{
    public function index(Request $request, $estrategiaId)
    {
        $user = auth()->user();
        $user_name = $user->name;

        if ($user->hasRole('Administrador')) {
            $accionesErradicar = AccionErradicar::where('estrategia_id', $estrategiaId)->get();
        } else {
            $accionesErradicar = AccionErradicar::where('estrategia_id', $estrategiaId)
                ->where(function ($query) use ($user_name) {
                    $query->whereRaw("FIND_IN_SET('{$user_name}', REPLACE(dependencias_responsables, ', ', ',')) > 0")
                        ->orWhereRaw("FIND_IN_SET('{$user_name}', REPLACE(dependencias_coordinadoras, ', ', ',')) > 0");
                })
                ->get();
            }

        $estrategia = EstrategiasErradicar::find($estrategiaId);

        return view('estrategiaserradicar.accionerradicar.index', compact('accionesErradicar', 'estrategia'));
    }

    public function create($estrategiaId)
    {
        $users = User::all();
        $estrategia = EstrategiasErradicar::find($estrategiaId);
        return view('estrategiaserradicar.accionerradicar.create', compact('users', 'estrategia'));
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
        $accionExistente = AccionErradicar::where('accion', $request->accion)
            ->where('estrategia_id', $request->estrategia_id)
            ->first();

        if ($accionExistente) {
            Alert::error('Error', 'Ya existe una acción con ese nombre para la estrategia seleccionada.');
            return redirect()->back();
        }

        // Si no hay una acción con el mismo nombre, proceder con la creación
        $accionErradicar = new AccionErradicar();
        $accionErradicar->accion = $request->input('accion');
        $accionErradicar->tipo = $request->input('tipo');
        $accionErradicar->estrategia_id = $request->input('estrategia_id');

        $dependenciasResponsablesIds = $request->input('dependencias_responsables', []);
        $dependenciasCoordinadorasIds = $request->input('dependencias_coordinadoras', []);

        $dependenciasResponsables = User::whereIn('id', $dependenciasResponsablesIds)->pluck('name')->implode(', ');
        $dependenciasCoordinadoras = User::whereIn('id', $dependenciasCoordinadorasIds)->pluck('name')->implode(', ');

        $accionErradicar->dependencias_responsables = $dependenciasResponsables;
        $accionErradicar->dependencias_coordinadoras = $dependenciasCoordinadoras;

        $accionErradicar->save();
        Alert::success('Éxito', 'Acción creada exitosamente.');

        return redirect()->route('estrategiaserradicar.accionerradicar.index', ['estrategia' => $request->estrategia_id]);
    }

    public function show($estrategiaId, $accion)
    {
        $accionErradicar = AccionErradicar::where('estrategia_id', $estrategiaId)->find($accion);

        return view('estrategiaserradicar.accionerradicar.show', ['accionErradicar' => $accionErradicar, 'estrategiaId' => $estrategiaId]);
    }

    public function edit($estrategiaId, $accionErradicarId)
    {
        $accionErradicar = AccionErradicar::where('estrategia_id', $estrategiaId)->findOrFail($accionErradicarId);
        $estrategia = EstrategiasErradicar::findOrFail($estrategiaId); // Obtén la estrategia correspondiente

        $users = User::all();
        $dependencias_responsables = json_decode($accionErradicar->dependencia_responsable, true);
        $dependencias_coordinadoras = json_decode($accionErradicar->dependencia_coordinadora, true);

        return view('estrategiaserradicar.accionerradicar.edit', compact('accionErradicar', 'users', 'dependencias_responsables', 'dependencias_coordinadoras', 'estrategia'));
    }

    public function update(Request $request, $estrategiaId, $accionErradicarId)
    {
        $request->validate([
            'accion' => 'required|max:255',
            'tipo' => 'required',
            // Puedes agregar más validaciones según tus necesidades
        ]);

        // Obtener la acción de erradicar existente
        $accionErradicar = AccionErradicar::find($accionErradicarId);

        if (!$accionErradicar) {
            return back()->with('error', 'La acción de erradicar no se pudo encontrar.');
        }

        // Verificar si ya existe otra acción con el mismo nombre dentro de la misma estrategia
        $otraAccionConMismoNombre = AccionErradicar::where('accion', $request->accion)
            ->where('estrategia_id', $estrategiaId)
            ->where('id', '<>', $accionErradicarId)
            ->first();

        if ($otraAccionConMismoNombre) {
            Alert::error('Error', 'Ya existe otra acción con ese nombre para la estrategia seleccionada.');
            return redirect()->back();
        }

        // Actualizar los campos de la acción de erradicar
        $accionErradicar->accion = $request->input('accion');
        $accionErradicar->tipo = $request->input('tipo');

        $dependenciasResponsablesIds = $request->input('dependencias_responsables', []);
        $dependenciasCoordinadorasIds = $request->input('dependencias_coordinadoras', []);

        $dependenciasResponsables = User::whereIn('id', $dependenciasResponsablesIds)->pluck('name')->implode(', ');
        $dependenciasCoordinadoras = User::whereIn('id', $dependenciasCoordinadorasIds)->pluck('name')->implode(', ');

        $accionErradicar->dependencias_responsables = $dependenciasResponsables;
        $accionErradicar->dependencias_coordinadoras = $dependenciasCoordinadoras;

        // Guardar los cambios en la base de datos
        $accionErradicar->save();
        Alert::success('Éxito', 'Acción editada exitosamente.');

        // Redirigir a la vista de detalle de la estrategia con la acción actualizada
        return redirect()->route('estrategiaserradicar.accionerradicar.show', ['estrategia' => $estrategiaId, 'accion' => $accionErradicar->id])
            ->with('success', 'Acción de erradicar actualizada exitosamente.');
    }

    public function destroy($estrategiaId, $accionErradicarId)
    {
        $accionErradicar = AccionErradicar::where('estrategia_id', $estrategiaId)->findOrFail($accionErradicarId);

        try {
            $accionErradicar->delete();
            Alert::success('Éxito', 'Acción de erradicar eliminada exitosamente');
        } catch (QueryException $e) {
            if (Str::contains($e->getMessage(), 'constraint `accion_erradicar_estrategia_id_foreign`')) {
                Alert::error('Error', 'No se puede eliminar la acción de erradicar porque tiene evidencias relacionadas.');
            } else {
                Alert::error('Error', 'No se puede eliminar la acción de erradicar porque tiene evidencias relacionadas.');
            }
        }

        return redirect()->route('estrategiaserradicar.accionerradicar.index', ['estrategia' => $accionErradicar->estrategia_id]);
    }
}
