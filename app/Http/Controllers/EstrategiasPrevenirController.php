<?php

namespace App\Http\Controllers;

use App\Models\EstrategiasPrevenir;
use App\Models\AccionPrevenir;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class EstrategiasPrevenirController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user_name = $user->name;

        if ($user->hasRole('Administrador')) {
            $estrategias = EstrategiasPrevenir::with('accionPrevenir')->get();
        } else {
            $estrategias = EstrategiasPrevenir::whereHas('accionPrevenir', function ($query) use ($user_name) {
                $query->whereRaw("FIND_IN_SET('{$user_name}', REPLACE(accion_prevenir.dependencias_responsables, ', ', ',')) > 0")
                    ->orWhereRaw("FIND_IN_SET('{$user_name}', REPLACE(accion_prevenir.dependencias_coordinadoras, ', ', ',')) > 0");
            })->get();
        }
        return view('estrategiasprevenir.index', compact('estrategias'));
    }

    public function create()
    {
        return view('estrategiasprevenir.create');
    }

    public function store(Request $request)
{
    // Validar que no exista una estrategia con el mismo nombre
    $estrategiaExistente = EstrategiasPrevenir::where('nombre', $request->input('nombre'))->first();

    if ($estrategiaExistente) {
        Alert::error('Error', 'La estrategia ya existe.');
        return redirect()->back();
    }

    // Si no hay una estrategia con el mismo nombre, crea y guarda la nueva estrategia
    $estrategia = new EstrategiasPrevenir();
    $estrategia->nombre = $request->input('nombre');
    $estrategia->save();

    Alert::success('Éxito', 'Estrategia creada exitosamente.');
    return redirect()->route('estrategiasprevenir.index');
}

    public function show($id)
    {
        $estrategia = EstrategiasPrevenir::find($id);
        $accionPrevenir = $estrategia->accionPrevenir;
        return view('estrategiasprevenir.show', compact('estrategia', 'accionPrevenir'));
    }

    public function edit($id) 
    {
        $estrategia = EstrategiasPrevenir::find($id);
        return view('estrategiasprevenir.edit', ['estrategia' => $estrategia]);
    }
    
    public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|max:255', 
    ]);

    // Verificar si ya existe una estrategia con el mismo nombre (excluyendo la estrategia actual)
    $estrategiaExistente = EstrategiasPrevenir::where('nombre', $request->nombre)
        ->where('id', '<>', $id)
        ->first();

    if ($estrategiaExistente) {
        Alert::error('Error', 'Ya existe una estrategia con ese nombre.');
        return redirect()->back();
    }

    // Si no hay una estrategia con el mismo nombre, actualizar la estrategia
    $estrategia = EstrategiasPrevenir::find($id);
    
    if (!$estrategia) {
        // Manejar el caso en el que no se encuentra la estrategia
        Alert::error('Error', 'Estrategia no encontrada.');
        return redirect()->route('estrategiasprevenir.index');
    }

    $estrategia->nombre = $request->nombre;
    $estrategia->save();

    Alert::success('Éxito', 'Estrategia editada exitosamente.');
    return redirect()->route('estrategiasprevenir.show', ['estrategia' => $estrategia->id]);
}


    public function destroy($id)
{
    $estrategia = EstrategiasPrevenir::findOrFail($id);

    try {
        $estrategia->delete();
        Alert::success('Éxito', 'Estrategia eliminada exitosamente.');
    } catch (QueryException $e) {
        if (Str::contains($e->getMessage(), 'constraint `accion_prevenir_estrategia_id_foreign`')) {
            Alert::error('Error', 'No se puede eliminar la estrategia porque tiene acciones relacionadas.');
        } else {
            Alert::error('Error', 'No se puede eliminar la estrategia porque tiene acciones relacionadas.');
        }
    }

    return redirect()->route('estrategiasprevenir.index');
}
}