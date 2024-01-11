<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EvidenciaSancionar;
use App\Models\AccionSancionar;
use App\Models\EstrategiasSancionar;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class EvidenciaSancionarController extends Controller
{
    public function index($estrategiaId, $accionSancionarId)
    {
        $accionSancionar = AccionSancionar::find($accionSancionarId);
        $evidencias = EvidenciaSancionar::where('accion_sancionar_id', $accionSancionarId)->get();
        $estrategia = EstrategiasSancionar::find($estrategiaId);

        return view('evidenciasancionar.index', compact('evidencias', 'accionSancionar', 'estrategia'));
    }

    public function create($estrategiaId, $accionSancionarId)
    {
        $accionSancionar = AccionSancionar::find($accionSancionarId);
        $evidencias = EvidenciaSancionar::where('accion_sancionar_id', $accionSancionarId)->get();
        $estrategia = EstrategiasSancionar::find($estrategiaId);

        return view('evidenciasancionar.create', compact('evidencias', 'accionSancionar', 'estrategia'));
    }

    public function store(Request $request, $estrategiaId, $accionSancionarId)
    {
        $evidencia = new EvidenciaSancionar();
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

        $evidencia->accion_sancionar_id = $accionSancionarId;

        try {
            $evidencia->save();
            Alert::success('Éxito', 'Evidencia creada exitosamente.');
            return redirect()->route('evidenciasancionar.index', ['estrategiaId' => $estrategiaId, 'accionSancionarId' => $accionSancionarId])
                ->with('success', 'Evidencia guardada exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar la evidencia en la base de datos');
        }
    }

    public function edit($estrategiaId, $accionSancionarId, $evidenciaId)
    {
        $estrategia = EstrategiasSancionar::find($estrategiaId);
        $accionSancionar = AccionSancionar::find($accionSancionarId);
        $evidencia = EvidenciaSancionar::findOrFail($evidenciaId);

        return view('evidenciasancionar.edit', compact('estrategia', 'accionSancionar', 'evidencia'));
    }

    public function update(Request $request, $estrategiaId, $accionSancionarId, $evidenciaId)
    {
        $evidencia = EvidenciaSancionar::findOrFail($evidenciaId);
        $evidencia->nombre = $request->input('nombre');
        $evidencia->mensaje = $request->input('mensaje');
        $evidencia->user_id = auth()->id();

        $evidencia->save();
        Alert::success('Éxito', 'Evidencia editada exitosamente.');
        return redirect()->route('evidenciasancionar.index', ['estrategiaId' => $estrategiaId, 'accionSancionarId' => $accionSancionarId]);
    }

    public function destroy($estrategiaId, $accionSancionarId, $evidenciaId)
    {
        $evidencia = EvidenciaSancionar::findOrFail($evidenciaId);

        try {
            $evidencia->delete();
            Alert::success('Éxito', 'Evidencia eliminada exitosamente.');
        } catch (\Exception $e) {
            Alert::error('Error', 'Error al eliminar la evidencia.');
        }

        return redirect()->route('evidenciasancionar.index', ['estrategiaId' => $estrategiaId, 'accionSancionarId' => $accionSancionarId]);
    }

    public function downloadFile($filename, $nombreArchivo)
    {
        $archivo = public_path('path_to_evidencias_folder/' . $filename);
        $headers = array(
            'Content-Type: application/pdf',
        );
        return response()->download($archivo, $nombreArchivo, $headers);
    }
}
