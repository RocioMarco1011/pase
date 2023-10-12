<?php

namespace App\Http\Controllers;

use App\Models\AccionPrevenir;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\UsersController;
use App\Models\EstrategiasPrevenir;

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

    public function show($estrategia, $accion)
    {
        $accionPrevenir = AccionPrevenir::where('estrategia_id', $estrategia)->find($accion);
        
        return view('estrategiasprevenir.accionprevenir.show', ['accionPrevenir' => $accionPrevenir]);
    }

    public function edit($id)
    {
        $accionPrevenir = AccionPrevenir::find($id);

        return view('estrategiasprevenir.accionprevenir.edit', ['accionPrevenir' => $accionPrevenir]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'accion' => 'required|max:255',
            'tipo' => 'required|in:General,Especifica',
            'dependencias_responsables' => 'nullable|max:255',
            'dependencias_coordinadoras' => 'nullable|max:255',
        ]);

        $accionPrevenir = AccionPrevenir::find($id);

        $accionPrevenir->accion = $request->accion;
        $accionPrevenir->tipo = $request->tipo;
        $accionPrevenir->dependencias_responsables = $request->dependencias_responsables;
        $accionPrevenir->dependencias_coordinadoras = $request->dependencias_coordinadoras;
        $accionPrevenir->save();

        return redirect()->route('estrategiasprevenir.accionprevenir.show', ['id' => $accionPrevenir->id]);
    }

    public function destroy($id)
{
    $accionPrevenir = AccionPrevenir::find($id);
    $accionPrevenir->delete();

    return redirect()->route('estrategiasprevenir.accionprevenir.show', ['id' => $accionPrevenir->id]);
}



}
