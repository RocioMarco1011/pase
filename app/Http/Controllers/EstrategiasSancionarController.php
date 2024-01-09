<?php

namespace App\Http\Controllers;

use App\Models\EstrategiasSancionar;
use App\Models\AccionSancionar;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class EstrategiasSancionarController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user_name = $user->name;

        if ($user->hasRole('Administrador')) {
            $estrategias = EstrategiasSancionar::with('accionSancionar')->get();
        } else {
            $estrategias = EstrategiasSancionar::whereHas('accionSancionar', function ($query) use ($user_name) {
                $query->whereRaw("FIND_IN_SET('{$user_name}', REPLACE(accion_sancionar.dependencias_responsables, ', ', ',')) > 0")
                    ->orWhereRaw("FIND_IN_SET('{$user_name}', REPLACE(accion_sancionar.dependencias_coordinadoras, ', ', ',')) > 0");
            })->get();
        }
        return view('estrategiassancionar.index', compact('estrategias'));
    }

    public function create()
    {
        return view('estrategiassancionar.create');
    }

    public function store(Request $request)
    {
        $estrategiaExistente = EstrategiasSancionar::where('nombre', $request->input('nombre'))->first();

        if ($estrategiaExistente) {
            Alert::error('Error', 'La estrategia ya existe.');
            return redirect()->back();
        }

        $estrategia = new EstrategiasSancionar();
        $estrategia->nombre = $request->input('nombre');
        $estrategia->save();

        Alert::success('Éxito', 'Estrategia creada exitosamente.');
        return redirect()->route('estrategiassancionar.index');
    }

    public function show($id)
    {
        $estrategia = EstrategiasSancionar::find($id);
        $accionSancionar = $estrategia->accionSancionar;
        return view('estrategiassancionar.show', compact('estrategia', 'accionSancionar'));
    }

    public function edit($id)
    {
        $estrategia = EstrategiasSancionar::find($id);
        return view('estrategiassancionar.edit', ['estrategia' => $estrategia]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
        ]);

        $estrategiaExistente = EstrategiasSancionar::where('nombre', $request->nombre)
            ->where('id', '<>', $id)
            ->first();

        if ($estrategiaExistente) {
            Alert::error('Error', 'Ya existe una estrategia con ese nombre.');
            return redirect()->back();
        }

        $estrategia = EstrategiasSancionar::find($id);

        if (!$estrategia) {
            Alert::error('Error', 'Estrategia no encontrada.');
            return redirect()->route('estrategiassancionar.index');
        }

        $estrategia->nombre = $request->nombre;
        $estrategia->save();

        Alert::success('Éxito', 'Estrategia editada exitosamente.');
        return redirect()->route('estrategiassancionar.show', ['estrategia' => $estrategia->id]);
    }

    public function destroy($id)
    {
        $estrategia = EstrategiasSancionar::findOrFail($id);

        try {
            $estrategia->delete();
            Alert::success('Éxito', 'Estrategia eliminada exitosamente.');
        } catch (QueryException $e) {
            if (Str::contains($e->getMessage(), 'constraint `accion_sancionar_estrategia_id_foreign`')) {
                Alert::error('Error', 'No se puede eliminar la estrategia porque tiene acciones relacionadas.');
            } else {
                Alert::error('Error', 'No se puede eliminar la estrategia porque tiene acciones relacionadas.');
            }
        }

        return redirect()->route('estrategiassancionar.index');
    }
}
