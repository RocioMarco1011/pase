<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EvidenciaErradicar;
use App\Models\AccionErradicar;
use App\Models\EstrategiasErradicar;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class EvidenciaErradicarController extends Controller
{
    public function index($estrategiaId, $accionErradicarId)
    {
        $accionErradicar = AccionErradicar::find($accionErradicarId);
        $evidencias = EvidenciaErradicar::where('accion_erradicar_id', $accionErradicarId)->get();
        $estrategia = EstrategiasErradicar::find($estrategiaId);

        return view('evidenciaerradicar.index', compact('evidencias', 'accionErradicar', 'estrategia'));
    }

    public function create($estrategiaId, $accionErradicarId)
    {
        $accionErradicar = AccionErradicar::find($accionErradicarId);
        $evidencias = EvidenciaErradicar::where('accion_erradicar_id', $accionErradicarId)->get();
        $estrategia = EstrategiasErradicar::find($estrategiaId);

        return view('evidenciaerradicar.create', compact('evidencias', 'accionErradicar', 'estrategia'));
    }

    public function store(Request $request, $estrategiaId, $accionErradicarId)
    {
        $evidencia = new EvidenciaErradicar();
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

        $evidencia->accion_erradicar_id = $accionErradicarId;

        try {
            $evidencia->save();
            Alert::success('Éxito', 'Evidencia creada exitosamente.');
            return redirect()->route('evidenciaerradicar.index', ['estrategiaId' => $estrategiaId, 'accionErradicarId' => $accionErradicarId])
                ->with('success', 'Evidencia guardada exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar la evidencia en la base de datos');
        }
    }

    public function edit($estrategiaId, $accionErradicarId, $evidenciaId)
    {
        $estrategia = EstrategiasErradicar::find($estrategiaId);
        $accionErradicar = AccionErradicar::find($accionErradicarId);
        $evidencia = EvidenciaErradicar::findOrFail($evidenciaId);

        return view('evidenciaerradicar.edit', compact('estrategia', 'accionErradicar', 'evidencia'));
    }

    public function update(Request $request, $estrategiaId, $accionErradicarId, $evidenciaId)
    {
        $evidencia = EvidenciaErradicar::findOrFail($evidenciaId);
        $evidencia->nombre = $request->input('nombre');
        $evidencia->mensaje = $request->input('mensaje');
        $evidencia->user_id = auth()->id();

        $evidencia->save();
        Alert::success('Éxito', 'Evidencia editada exitosamente.');
        return redirect()->route('evidenciaerradicar.index', ['estrategiaId' => $estrategiaId, 'accionErradicarId' => $accionErradicarId]);
    }

    public function destroy($estrategiaId, $accionErradicarId, $evidenciaId)
    {
        $evidencia = EvidenciaErradicar::findOrFail($evidenciaId);

        try {
            $evidencia->delete();
            Alert::success('Éxito', 'Evidencia eliminada exitosamente.');
        } catch (\Exception $e) {
            Alert::error('Error', 'Error al eliminar la evidencia.');
        }

        return redirect()->route('evidenciaerradicar.index', ['estrategiaId' => $estrategiaId, 'accionErradicarId' => $accionErradicarId]);
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
