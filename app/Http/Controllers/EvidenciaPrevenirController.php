<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EvidenciaPrevenir;
use App\Models\AccionPrevenir;
use App\Models\EstrategiasPrevenir;
use Illuminate\Support\Facades\Storage;

class EvidenciaPrevenirController extends Controller
{
    public function index($estrategiaId, $accionPrevenirId)
    {
        $accionPrevenir = AccionPrevenir::find($accionPrevenirId);
        $evidencias = EvidenciaPrevenir::where('accion_prevenir_id', $accionPrevenirId)->get();
        $estrategia = EstrategiasPrevenir::find($estrategiaId);

        return view('estrategiasprevenir.accionprevenir.evidenciaprevenir.index', compact('evidencias', 'accionPrevenir', 'estrategia'));
    }

    public function create($estrategiaId, $accionPrevenirId)
    {
        $accionPrevenir = AccionPrevenir::find($accionPrevenirId);
        $evidencias = EvidenciaPrevenir::where('accion_prevenir_id', $accionPrevenirId)->get();
        $estrategia = EstrategiasPrevenir::find($estrategiaId);

        return view('estrategiasprevenir.accionprevenir.evidenciaprevenir.create', compact('evidencias', 'accionPrevenir', 'estrategia'));
    }


    public function store(Request $request, $estrategiaId, $accionPrevenirId)
{
    $evidencia = new EvidenciaPrevenir();
    $evidencia->nombre = $request->input('nombre');
    $evidencia->mensaje = $request->input('mensaje');

    // Verificar si se ha cargado un archivo
    if ($request->hasFile('archivo')) {
        $archivo = $request->file('archivo'); // Define la variable $archivo
        $nombreArchivo = $archivo->getClientOriginalName();

        try {
            $archivo->storeAs('', $nombreArchivo, 'evidencias');
            $evidencia->archivo = $nombreArchivo;
        } catch (\Exception $e) {
            // Manejar cualquier error relacionado con el almacenamiento del archivo
            return back()->with('error', 'Error al guardar el archivo');
        }
    } else {
        $evidencia->archivo = null; // No se adjuntó ningún archivo
    }

    $evidencia->accion_prevenir_id = $accionPrevenirId;

    try {
        $evidencia->save();
        return redirect()->route('evidenciaprevenir.index', ['estrategiaId' => $estrategiaId, 'accionPrevenirId' => $accionPrevenirId])
            ->with('success', 'Evidencia guardada exitosamente');
    } catch (\Exception $e) {
        // Manejar cualquier error relacionado con la base de datos
        return back()->with('error', 'Error al guardar la evidencia en la base de datos');
    }
}

    
    public function edit($estrategiaId, $accionPrevenirId, $evidenciaId)
{
    $estrategia = EstrategiasPrevenir::find($estrategiaId);
    $accionPrevenir = AccionPrevenir::find($accionPrevenirId);
    $evidencia = EvidenciaPrevenir::findOrFail($evidenciaId);

    return view('estrategiasprevenir.accionprevenir.evidenciaprevenir.edit', compact('estrategia', 'accionPrevenir', 'evidencia'));
}


    public function update(Request $request, $estrategiaId, $accionPrevenirId, $evidenciaId)
    {
        $evidencia = EvidenciaPrevenir::findOrFail($evidenciaId);
        $evidencia->nombre = $request->input('nombre');
        $evidencia->mensaje = $request->input('mensaje');
    
        $evidencia->save();
        return redirect()->route('evidenciaprevenir.index', ['estrategiaId' => $estrategiaId, 'accionPrevenirId' => $accionPrevenirId]);
    }

    public function destroy($estrategiaId, $accionPrevenirId, $evidenciaId)
    {

        $evidencia = EvidenciaPrevenir::findOrFail($evidenciaId);
        $evidencia->delete();

        return redirect()->route('evidenciaprevenir.index', ['estrategiaId' => $estrategiaId, 'accionPrevenirId' => $accionPrevenirId]);
    }
}
