<?php

namespace App\Http\Controllers;

use App\Models\EstrategiasAtender;
use App\Models\AccionAtender;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class EstrategiasAtenderController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user_name = $user->name;

        if ($user->hasRole('Administrador')) {
            $estrategias = EstrategiasAtender::with('accionAtender')->get();
        } else {
            $estrategias = EstrategiasAtender::whereHas('accionAtender', function ($query) use ($user_name) {
                $query->whereRaw("FIND_IN_SET('{$user_name}', REPLACE(accion_atender.dependencias_responsables, ', ', ',')) > 0")
                    ->orWhereRaw("FIND_IN_SET('{$user_name}', REPLACE(accion_atender.dependencias_coordinadoras, ', ', ',')) > 0");
            })->get();
        }
        return view('estrategiasatender.index', compact('estrategias'));
    }

    public function create()
    {
        return view('estrategiasatender.create');
    }

    public function store(Request $request)
    {
        $estrategiaExistente = EstrategiasAtender::where('nombre', $request->input('nombre'))->first();

        if ($estrategiaExistente) {
            Alert::error('Error', 'La estrategia ya existe.');
            return redirect()->back();
        }

        $estrategia = new EstrategiasAtender();
        $estrategia->nombre = $request->input('nombre');
        $estrategia->save();

        Alert::success('Éxito', 'Estrategia creada exitosamente.');
        return redirect()->route('estrategiasatender.index');
    }

    public function show($id)
    {
        $estrategia = EstrategiasAtender::find($id);
        $accionAtender = $estrategia->accionAtender;
        return view('estrategiasatender.show', compact('estrategia', 'accionAtender'));
    }

    public function edit($id)
    {
        $estrategia = EstrategiasAtender::find($id);
        return view('estrategiasatender.edit', ['estrategia' => $estrategia]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:255',
        ]);

        $estrategiaExistente = EstrategiasAtender::where('nombre', $request->nombre)
            ->where('id', '<>', $id)
            ->first();

        if ($estrategiaExistente) {
            Alert::error('Error', 'Ya existe una estrategia con ese nombre.');
            return redirect()->back();
        }

        $estrategia = EstrategiasAtender::find($id);

        if (!$estrategia) {
            Alert::error('Error', 'Estrategia no encontrada.');
            return redirect()->route('estrategiasatender.index');
        }

        $estrategia->nombre = $request->nombre;
        $estrategia->save();

        Alert::success('Éxito', 'Estrategia editada exitosamente.');
        return redirect()->route('estrategiasatender.show', ['estrategia' => $estrategia->id]);
    }

    public function destroy($id)
    {
        $estrategia = EstrategiasAtender::findOrFail($id);

        try {
            $estrategia->delete();
            Alert::success('Éxito', 'Estrategia eliminada exitosamente.');
        } catch (QueryException $e) {
            if (Str::contains($e->getMessage(), 'constraint `accion_atender_estrategia_id_foreign`')) {
                Alert::error('Error', 'No se puede eliminar la estrategia porque tiene acciones relacionadas.');
            } else {
                Alert::error('Error', 'No se puede eliminar la estrategia porque tiene acciones relacionadas.');
            }
        }

        return redirect()->route('estrategiasatender.index');
    }
}
