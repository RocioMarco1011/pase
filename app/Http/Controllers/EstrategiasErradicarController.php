<?php

namespace App\Http\Controllers;

use App\Models\EstrategiasErradicar;
use App\Models\AccionErradicar;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class EstrategiasErradicarController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user_name = $user->name;

        if ($user->hasRole('Administrador')) {
            $estrategias = EstrategiasErradicar::with('accionErradicar')->get();
        } else {
            $estrategias = EstrategiasErradicar::whereHas('accionErradicar', function ($query) use ($user_name) {
                $query->whereRaw("FIND_IN_SET('{$user_name}', REPLACE(accion_erradicar.dependencias_responsables, ', ', ',')) > 0")
                    ->orWhereRaw("FIND_IN_SET('{$user_name}', REPLACE(accion_erradicar.dependencias_coordinadoras, ', ', ',')) > 0");
            })->get();
        }
        return view('estrategiaserradicar.index', compact('estrategias'));
    }

    public function create()
    {
        return view('estrategiaserradicar.create');
    }

    public function store(Request $request)
    {
        $estrategiaExistente = EstrategiasErradicar::where('nombre', $request->input('nombre'))->first();

        if ($estrategiaExistente) {
            Alert::error('Error', 'La estrategia ya existe.');
            return redirect()->back();
        }

        $estrategia = new EstrategiasErradicar();
        $estrategia->nombre = $request->input('nombre');
        $estrategia->save();

        Alert::success('Éxito', 'Estrategia creada exitosamente.');
        return redirect()->route('estrategiaserradicar.index');
    }

    public function show($id)
    {
        $estrategia = EstrategiasErradicar::find($id);
        $accionErradicar = $estrategia->accionErradicar;
        return view('estrategiaserradicar.show', compact('estrategia', 'accionErradicar'));
    }

    public function edit($id)
    {
        $estrategia = EstrategiasErradicar::find($id);
        return view('estrategiaserradicar.edit', ['estrategia' => $estrategia]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
        ]);

        $estrategiaExistente = EstrategiasErradicar::where('nombre', $request->nombre)
            ->where('id', '<>', $id)
            ->first();

        if ($estrategiaExistente) {
            Alert::error('Error', 'Ya existe una estrategia con ese nombre.');
            return redirect()->back();
        }

        $estrategia = EstrategiasErradicar::find($id);

        if (!$estrategia) {
            Alert::error('Error', 'Estrategia no encontrada.');
            return redirect()->route('estrategiaserradicar.index');
        }

        $estrategia->nombre = $request->nombre;
        $estrategia->save();

        Alert::success('Éxito', 'Estrategia editada exitosamente.');
        return redirect()->route('estrategiaserradicar.show', ['estrategia' => $estrategia->id]);
    }

    public function destroy($id)
    {
        $estrategia = EstrategiasErradicar::findOrFail($id);

        try {
            $estrategia->delete();
            Alert::success('Éxito', 'Estrategia eliminada exitosamente.');
        } catch (QueryException $e) {
            if (Str::contains($e->getMessage(), 'constraint `accion_erradicar_estrategia_id_foreign`')) {
                Alert::error('Error', 'No se puede eliminar la estrategia porque tiene acciones relacionadas.');
            } else {
                Alert::error('Error', 'No se puede eliminar la estrategia porque tiene acciones relacionadas.');
            }
        }

        return redirect()->route('estrategiaserradicar.index');
    }
}
