<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EvidenciaPrevenir;
use App\Models\AccionPrevenir;
use App\Models\EstrategiasPrevenir;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


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
    $nombreArchivo = $request->input('nombre');
    $evidencia->nombre = $nombreArchivo;
    $evidencia->mensaje = $request->input('mensaje');
    $evidencia->user_id = auth()->id();

    if ($request->hasFile('archivo')) {
        $archivo = $request->file('archivo');
        $nombreArchivo = $nombreArchivo . '.' . $archivo->getClientOriginalExtension();

        try {
            $archivo->storeAs('', $nombreArchivo, 'evidencias');
            $evidencia->archivo = $nombreArchivo;
        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar el archivo.');
        }
    } else {
        $evidencia->archivo = null;
    }

    $evidencia->accion_prevenir_id = $accionPrevenirId;

    try {
        $evidencia->save();
        Alert::success('Éxito', 'Evidencia creada exitosamente.');
        return redirect()->route('evidenciaprevenir.index', ['estrategiaId' => $estrategiaId, 'accionPrevenirId' => $accionPrevenirId])
            ->with('success', 'Evidencia guardada exitosamente.');
    } catch (\Exception $e) {
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
        $evidencia->user_id = auth()->id();
    
        $evidencia->save();
        Alert::success('Éxito', 'Evidencia editada exitosamente.');
        return redirect()->route('evidenciaprevenir.index', ['estrategiaId' => $estrategiaId, 'accionPrevenirId' => $accionPrevenirId]);
    }

    public function destroy($estrategiaId, $accionPrevenirId, $evidenciaId)
{
    $evidencia = EvidenciaPrevenir::findOrFail($evidenciaId);

    try {
        $evidencia->delete();
        Alert::success('Éxito', 'Evidencia eliminada exitosamente.');
    } catch (\Exception $e) {
        Alert::error('Error', 'Error al eliminar la evidencia.');
    }

    return redirect()->route('evidenciaprevenir.index', ['estrategiaId' => $estrategiaId, 'accionPrevenirId' => $accionPrevenirId]);
}

    public function downloadFile($filename, $nombreArchivo)
{
    $archivo = public_path('path_to_evidencias_folder/' . $filename);
    $headers = array(
        'Content-Type: application/pdf',
    );
    return Response::download($archivo, $nombreArchivo, $headers);
}

}
