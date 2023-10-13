<?php

namespace App\Http\Controllers;

use App\Models\EstrategiasPrevenir;
use App\Models\AccionPrevenir;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;


class EstrategiasPrevenirController extends Controller
{
    public function index()
    {
        $estrategias = EstrategiasPrevenir::all();
        return view('estrategiasprevenir.index', compact('estrategias'));
    }

    public function create()
    {
        return view('estrategiasprevenir.create');
    }

    public function store(Request $request)
    {
        $estrategia = new EstrategiasPrevenir();
        $estrategia->nombre = $request->input('nombre');
        $estrategia->save();
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

        $estrategia = EstrategiasPrevenir::find($id);
        $estrategia->nombre = $request->nombre;
        $estrategia->save();

        return redirect()->route('estrategiasprevenir.show', ['estrategia' => $estrategia->id]);
    }

    public function destroy($id)
    {
        $estrategia = EstrategiasPrevenir::findOrFail($id);

        try {
            $estrategia->delete();
            return redirect()->route('estrategiasprevenir.index')->with('success', 'Estrategia eliminada exitosamente');
        } catch (QueryException $e) {
            if (Str::contains($e->getMessage(), 'constraint `accion_prevenir_estrategia_id_foreign`')) {
                return back()->with('error', 'No se puede eliminar la estrategia porque tiene acciones relacionadas.');
            } else {
                return back()->with('error', 'Error al eliminar la estrategia');
            }
        }
    }
}