<?php

namespace App\Http\Controllers;

use App\Models\AccionPrevenir;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\UsersController;
use App\Models\EstrategiasPrevenir;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AccionPrevenirController extends Controller
{
    public function index(Request $request, $estrategiaId)
    {
        $user = auth()->user();
        $user_name = $user->name;

        if ($user->hasRole('Administrador')) {
            $accionesPrevenir = AccionPrevenir::where('estrategia_id', $estrategiaId)->get();
        } else {
            $accionesPrevenir = AccionPrevenir::where('estrategia_id', $estrategiaId)
                ->where(function ($query) use ($user_name) {
                    $query->whereRaw("FIND_IN_SET('{$user_name}', REPLACE(dependencias_responsables, ', ', ',')) > 0")
                        ->orWhereRaw("FIND_IN_SET('{$user_name}', REPLACE(dependencias_coordinadoras, ', ', ',')) > 0");
                })
                ->get();
            }

        $estrategia = EstrategiasPrevenir::find($estrategiaId);

        return view('estrategiasprevenir.accionprevenir.index', compact('accionesPrevenir', 'estrategia'));
    }

    public function create($estrategiaId)
    {
        $users = User::all();
        $estrategia = EstrategiasPrevenir::find($estrategiaId);
        return view('estrategiasprevenir.accionprevenir.create', compact('users', 'estrategia'));
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
    $accionExistente = AccionPrevenir::where('accion', $request->accion)
        ->where('estrategia_id', $request->estrategia_id)
        ->first();

    if ($accionExistente) {
        Alert::error('Error', 'Ya existe una acción con ese nombre para la estrategia seleccionada.');
        return redirect()->back();
    }

    // Si no hay una acción con el mismo nombre, proceder con la creación
    $accionPrevenir = new AccionPrevenir();
    $accionPrevenir->accion = $request->input('accion');
    $accionPrevenir->tipo = $request->input('tipo');
    $accionPrevenir->estrategia_id = $request->input('estrategia_id'); 

    $dependenciasResponsablesIds = $request->input('dependencias_responsables', []);
    $dependenciasCoordinadorasIds = $request->input('dependencias_coordinadoras', []);

    $dependenciasResponsables = User::whereIn('id', $dependenciasResponsablesIds)->pluck('name')->implode(', ');
    $dependenciasCoordinadoras = User::whereIn('id', $dependenciasCoordinadorasIds)->pluck('name')->implode(', ');

    $accionPrevenir->dependencias_responsables = $dependenciasResponsables;
    $accionPrevenir->dependencias_coordinadoras = $dependenciasCoordinadoras;

    $accionPrevenir->save();
    Alert::success('Éxito', 'Acción creada exitosamente.');

    return redirect()->route('estrategiasprevenir.accionprevenir.index', ['estrategia' => $request->estrategia_id]);
}


    public function show($estrategiaId, $accion)
    {
        $accionPrevenir = AccionPrevenir::where('estrategia_id', $estrategiaId)->find($accion);
        
        return view('estrategiasprevenir.accionprevenir.show', ['accionPrevenir' => $accionPrevenir, 'estrategiaId' => $estrategiaId]);
    }

    public function edit($estrategiaId, $accionPrevenirId)
    {
        $accionPrevenir = AccionPrevenir::where('estrategia_id', $estrategiaId)->findOrFail($accionPrevenirId);
        $estrategia = EstrategiasPrevenir::findOrFail($estrategiaId); // Obtén la estrategia correspondiente

        $users = User::all();
        $dependencias_responsables = json_decode($accionPrevenir->dependencia_responsable, true);
        $dependencias_coordinadoras = json_decode($accionPrevenir->dependencia_coordinadora, true);

        return view('estrategiasprevenir.accionprevenir.edit', compact('accionPrevenir', 'users', 'dependencias_responsables', 'dependencias_coordinadoras', 'estrategia'));
    }

    public function update(Request $request, $estrategiaId, $accionPrevenirId)
{
    $request->validate([
        'accion' => 'required|max:255',
        'tipo' => 'required',
        // Puedes agregar más validaciones según tus necesidades
    ]);

    // Obtener la acción de prevención existente
    $accionPrevenir = AccionPrevenir::find($accionPrevenirId);

    if (!$accionPrevenir) {
        return back()->with('error', 'La acción de prevención no se pudo encontrar.');
    }

    // Verificar si ya existe otra acción con el mismo nombre dentro de la misma estrategia
    $otraAccionConMismoNombre = AccionPrevenir::where('accion', $request->accion)
        ->where('estrategia_id', $estrategiaId)
        ->where('id', '<>', $accionPrevenirId)
        ->first();

    if ($otraAccionConMismoNombre) {
        Alert::error('Error', 'Ya existe otra acción con ese nombre para la estrategia seleccionada.');
        return redirect()->back();
    }

    // Actualizar los campos de la acción de prevención
    $accionPrevenir->accion = $request->input('accion');
    $accionPrevenir->tipo = $request->input('tipo');
    
    $dependenciasResponsablesIds = $request->input('dependencias_responsables', []);
    $dependenciasCoordinadorasIds = $request->input('dependencias_coordinadoras', []);

    $dependenciasResponsables = User::whereIn('id', $dependenciasResponsablesIds)->pluck('name')->implode(', ');
    $dependenciasCoordinadoras = User::whereIn('id', $dependenciasCoordinadorasIds)->pluck('name')->implode(', ');

    $accionPrevenir->dependencias_responsables = $dependenciasResponsables;
    $accionPrevenir->dependencias_coordinadoras = $dependenciasCoordinadoras;

    // Guardar los cambios en la base de datos
    $accionPrevenir->save();
    Alert::success('Éxito', 'Acción editada exitosamente.');

    // Redirigir a la vista de detalle de la estrategia con la acción actualizada
    return redirect()->route('estrategiasprevenir.accionprevenir.show', ['estrategia' => $estrategiaId, 'accion' => $accionPrevenir->id])
        ->with('success', 'Acción de prevención actualizada exitosamente.');
}



    public function destroy($estrategiaId, $accionPrevenirId)
{
    $accionPrevenir = AccionPrevenir::where('estrategia_id', $estrategiaId)->findOrFail($accionPrevenirId);

    try {
        $accionPrevenir->delete();
        Alert::success('Éxito', 'Acción de prevenir eliminada exitosamente');
    } catch (QueryException $e) {
        if (Str::contains($e->getMessage(), 'constraint `accion_prevenir_estrategia_id_foreign`')) {
            Alert::error('Error', 'No se puede eliminar la acción de prevenir porque tiene evidencias relacionadas.');
        } else {
            Alert::error('Error', 'No se puede eliminar la acción de prevenir porque tiene evidencias relacionadas.');
        }
    }

    return redirect()->route('estrategiasprevenir.accionprevenir.index', ['estrategia' => $accionPrevenir->estrategia_id]);
}
}
