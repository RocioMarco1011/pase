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


class AccionPrevenirController extends Controller
{
    public function index(Request $request, $estrategiaId)
    {
        $accionesPrevenir = AccionPrevenir::where('estrategia_id', $estrategiaId)->get();
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
        $accionPrevenir = new AccionPrevenir();
        $accionPrevenir->accion = $request->input('accion');
        $accionPrevenir->tipo = $request->input('tipo');
        $accionPrevenir->dependencias_responsables = $request->input('dependencias_responsables');
        $accionPrevenir->dependencias_coordinadoras = $request->input('dependencias_coordinadoras');
        $accionPrevenir->estrategia_id = $request->input('estrategia_id'); 

        $dependenciasResponsablesIds = $request->input('dependencias_responsables', []);
        $dependenciasCoordinadorasIds = $request->input('dependencias_coordinadoras', []);

        $dependenciasResponsables = User::whereIn('id', $dependenciasResponsablesIds)->pluck('name')->implode(', ');
        $dependenciasCoordinadoras = User::whereIn('id', $dependenciasCoordinadorasIds)->pluck('name')->implode(', ');

        $accionPrevenir->dependencias_responsables = $dependenciasResponsables;
        $accionPrevenir->dependencias_coordinadoras = $dependenciasCoordinadoras;

        $estrategiaId = $request->input('estrategia_id');

        $accionPrevenir->save();

        return redirect()->route('estrategiasprevenir.accionprevenir.index', ['estrategia' => $estrategiaId]);
    }

    public function show($estrategiaId, $accion)
    {
        $accionPrevenir = AccionPrevenir::where('estrategia_id', $estrategiaId)->find($accion);
        
        return view('estrategiasprevenir.accionprevenir.show', ['accionPrevenir' => $accionPrevenir, 'estrategiaId' => $estrategiaId]);
    }

    public function edit($estrategiaId, $accionPrevenirId)
    {
        $estrategia = EstrategiasPrevenir::find($estrategiaId);
        $accionPrevenir = AccionPrevenir::find($accionPrevenirId);
        $users = User::all(); // Esto es un ejemplo, ajusta la obtención de usuarios según tu lógica

        // Asegúrate de que los datos de responsables y coordinadores estén disponibles en $accionPrevenir
        $responsables = json_decode($accionPrevenir->dependencias_responsables, true);
        $coordinadores = json_decode($accionPrevenir->dependencias_coordinadoras, true);

        return view('estrategiasprevenir.accionprevenir.edit', compact('estrategia', 'accionPrevenir', 'users', 'responsables', 'coordinadores'));
    }


    public function update(Request $request, $estrategiaId, $accionPrevenirId)
    {
        $request->validate([
            'accion' => 'required|max:255',
            'tipo' => 'required|in:General,Especifica',
            'dependencias_responsables' => 'nullable|array', // Asegura que sea un arreglo
            'dependencias_coordinadoras' => 'nullable|array', // Asegura que sea un arreglo
        ]);

        $accionPrevenir = AccionPrevenir::find($accionPrevenirId);

        if (!$accionPrevenir) {
            return back()->with('error', 'La acción de prevención no se pudo encontrar.');
        }

        // Actualizar los campos de la acción de prevención
        $accionPrevenir->accion = $request->input('accion');
        $accionPrevenir->tipo = $request->input('tipo');
        $accionPrevenir->dependencias_responsables = $request->input('dependencias_responsables');
        $accionPrevenir->dependencias_coordinadoras = $request->input('dependencias_coordinadoras');

        $accionPrevenir->save();

        return redirect()->route('estrategiasprevenir.accionprevenir.show', ['estrategia' => $estrategiaId, 'accion' => $accionPrevenir->id]);

    }

    public function destroy($estrategiaId, $accionPrevenirId)
    {
        $accionPrevenir = AccionPrevenir::where('estrategia_id', $estrategiaId)->findOrFail($accionPrevenirId);
    
        try {
            $accionPrevenir->delete();
            return redirect()->route('estrategiasprevenir.index')->with('success', 'Acción de prevenir eliminada exitosamente');
        } catch (QueryException $e) {
            if (Str::contains($e->getMessage(), 'constraint `accion_prevenir_estrategia_id_foreign`')) {
                return back()->with('error', 'No se puede eliminar la acción de prevenir porque está relacionada con otros elementos.');
            } else {
                return back()->with('error', 'Error al eliminar la acción de prevenir');
            }
        }
    }    
}
