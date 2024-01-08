<?php

namespace App\Http\Controllers;

use App\Models\AccionAtender;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\UsersController;
use App\Models\EstrategiasAtender;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AccionAtenderController extends Controller
{
    public function index(Request $request, $estrategiaId)
    {
        $user = auth()->user();
        $user_name = $user->name;

        if ($user->hasRole('Administrador')) {
            $accionesAtender = AccionAtender::where('estrategia_id', $estrategiaId)->get();
        } else {
            $accionesAtender = AccionAtender::where('estrategia_id', $estrategiaId)
                ->where(function ($query) use ($user_name) {
                    $query->whereRaw("FIND_IN_SET('{$user_name}', REPLACE(dependencias_responsables, ', ', ',')) > 0")
                        ->orWhereRaw("FIND_IN_SET('{$user_name}', REPLACE(dependencias_coordinadoras, ', ', ',')) > 0");
                })
                ->get();
            }

        $estrategia = EstrategiasAtender::find($estrategiaId);

        return view('estrategiasatender.accionatender.index', compact('accionesAtender', 'estrategia'));
    }

    public function create($estrategiaId)
    {
        $users = User::all();
        $estrategia = EstrategiasAtender::find($estrategiaId);
        return view('estrategiasatender.accionatender.create', compact('users', 'estrategia'));
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
        $accionExistente = AccionAtender::where('accion', $request->accion)
            ->where('estrategia_id', $request->estrategia_id)
            ->first();

        if ($accionExistente) {
            Alert::error('Error', 'Ya existe una acción con ese nombre para la estrategia seleccionada.');
            return redirect()->back();
        }

        // Si no hay una acción con el mismo nombre, proceder con la creación
        $accionAtender = new AccionAtender();
        $accionAtender->accion = $request->input('accion');
        $accionAtender->tipo = $request->input('tipo');
        $accionAtender->estrategia_id = $request->input('estrategia_id');

        $dependenciasResponsablesIds = $request->input('dependencias_responsables', []);
        $dependenciasCoordinadorasIds = $request->input('dependencias_coordinadoras', []);

        $dependenciasResponsables = User::whereIn('id', $dependenciasResponsablesIds)->pluck('name')->implode(', ');
        $dependenciasCoordinadoras = User::whereIn('id', $dependenciasCoordinadorasIds)->pluck('name')->implode(', ');

        $accionAtender->dependencias_responsables = $dependenciasResponsables;
        $accionAtender->dependencias_coordinadoras = $dependenciasCoordinadoras;

        $accionAtender->save();
        Alert::success('Éxito', 'Acción creada exitosamente.');

        return redirect()->route('estrategiasatender.accionatender.index', ['estrategia' => $request->estrategia_id]);
    }

    public function show($estrategiaId, $accion)
    {
        $accionAtender = AccionAtender::where('estrategia_id', $estrategiaId)->find($accion);

        return view('estrategiasatender.accionatender.show', ['accionAtender' => $accionAtender, 'estrategiaId' => $estrategiaId]);
    }

    public function edit($estrategiaId, $accionAtenderId)
    {
        $accionAtender = AccionAtender::where('estrategia_id', $estrategiaId)->findOrFail($accionAtenderId);
        $estrategia = EstrategiasAtender::findOrFail($estrategiaId); // Obtén la estrategia correspondiente

        $users = User::all();
        $dependencias_responsables = json_decode($accionAtender->dependencia_responsable, true);
        $dependencias_coordinadoras = json_decode($accionAtender->dependencia_coordinadora, true);

        return view('estrategiasatender.accionatender.edit', compact('accionAtender', 'users', 'dependencias_responsables', 'dependencias_coordinadoras', 'estrategia'));
    }

    public function update(Request $request, $estrategiaId, $accionAtenderId)
    {
        $request->validate([
            'accion' => 'required|max:255',
            'tipo' => 'required',
            // Puedes agregar más validaciones según tus necesidades
        ]);

        // Obtener la acción de prevención existente
        $accionAtender = AccionAtender::find($accionAtenderId);

        if (!$accionAtender) {
            return back()->with('error', 'La acción de prevención no se pudo encontrar.');
        }

        // Verificar si ya existe otra acción con el mismo nombre dentro de la misma estrategia
        $otraAccionConMismoNombre = AccionAtender::where('accion', $request->accion)
            ->where('estrategia_id', $estrategiaId)
            ->where('id', '<>', $accionAtenderId)
            ->first();

        if ($otraAccionConMismoNombre) {
            Alert::error('Error', 'Ya existe otra acción con ese nombre para la estrategia seleccionada.');
            return redirect()->back();
        }

        // Actualizar los campos de la acción de prevención
        $accionAtender->accion = $request->input('accion');
        $accionAtender->tipo = $request->input('tipo');

        $dependenciasResponsablesIds = $request->input('dependencias_responsables', []);
        $dependenciasCoordinadorasIds = $request->input('dependencias_coordinadoras', []);

        $dependenciasResponsables = User::whereIn('id', $dependenciasResponsablesIds)->pluck('name')->implode(', ');
        $dependenciasCoordinadoras = User::whereIn('id', $dependenciasCoordinadorasIds)->pluck('name')->implode(', ');

        $accionAtender->dependencias_responsables = $dependenciasResponsables;
        $accionAtender->dependencias_coordinadoras = $dependenciasCoordinadoras;

        // Guardar los cambios en la base de datos
        $accionAtender->save();
        Alert::success('Éxito', 'Acción editada exitosamente.');

        // Redirigir a la vista de detalle de la estrategia con la acción actualizada
        return redirect()->route('estrategiasatender.accionatender.show', ['estrategia' => $estrategiaId, 'accion' => $accionAtender->id])
            ->with('success', 'Acción de prevención actualizada exitosamente.');
    }

    public function destroy($estrategiaId, $accionAtenderId)
    {
        $accionAtender = AccionAtender::where('estrategia_id', $estrategiaId)->findOrFail($accionAtenderId);

        try {
            $accionAtender->delete();
            Alert::success('Éxito', 'Acción de atender eliminada exitosamente');
        } catch (QueryException $e) {
            if (Str::contains($e->getMessage(), 'constraint `accion_atender_estrategia_id_foreign`')) {
                Alert::error('Error', 'No se puede eliminar la acción de atender porque tiene evidencias relacionadas.');
            } else {
                Alert::error('Error', 'No se puede eliminar la acción de atender porque tiene evidencias relacionadas.');
            }
        }

        return redirect()->route('estrategiasatender.accionatender.index', ['estrategia' => $accionAtender->estrategia_id]);
    }
}
