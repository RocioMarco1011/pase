<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EvidenciaAtender; 
use App\Models\AccionAtender; 
use App\Models\EstrategiasAtender; 
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class EvidenciaAtenderController extends Controller
{
    public function index($estrategiaId, $accionAtenderId)
    {
        $accionAtender = AccionAtender::find($accionAtenderId);
        $evidencias = EvidenciaAtender::where('accion_atender_id', $accionAtenderId)->get();
        $estrategia = EstrategiasAtender::find($estrategiaId);

        return view('evidenciaatender.index', compact('evidencias', 'accionAtender', 'estrategia'));
    }

    public function create($estrategiaId, $accionAtenderId)
    {
        $accionAtender = AccionAtender::find($accionAtenderId);
        $evidencias = EvidenciaAtender::where('accion_atender_id', $accionAtenderId)->get();
        $estrategia = EstrategiasAtender::find($estrategiaId);

        return view('evidenciaatender.create', compact('evidencias', 'accionAtender', 'estrategia'));
    }

    public function store(Request $request, $estrategiaId, $accionAtenderId)
    {
        $evidencia = new EvidenciaAtender();
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

        $evidencia->accion_atender_id = $accionAtenderId;

        try {
            $evidencia->save();
            Alert::success('Éxito', 'Evidencia creada exitosamente.');
            return redirect()->route('evidenciaatender.index', ['estrategiaId' => $estrategiaId, 'accionAtenderId' => $accionAtenderId])
                ->with('success', 'Evidencia guardada exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar la evidencia en la base de datos');
        }
    }

    public function edit($estrategiaId, $accionAtenderId, $evidenciaId)
    {
        $estrategia = EstrategiasAtender::find($estrategiaId);
        $accionAtender = AccionAtender::find($accionAtenderId);
        $evidencia = EvidenciaAtender::findOrFail($evidenciaId);

        return view('evidenciaatender.edit', compact('estrategia', 'accionAtender', 'evidencia'));
    }

    public function update(Request $request, $estrategiaId, $accionAtenderId, $evidenciaId)
    {
        $evidencia = EvidenciaAtender::findOrFail($evidenciaId);
        $evidencia->nombre = $request->input('nombre');
        $evidencia->mensaje = $request->input('mensaje');
        $evidencia->user_id = auth()->id();

        $evidencia->save();
        Alert::success('Éxito', 'Evidencia editada exitosamente.');
        return redirect()->route('evidenciaatender.index', ['estrategiaId' => $estrategiaId, 'accionAtenderId' => $accionAtenderId]);
    }

    public function destroy($estrategiaId, $accionAtenderId, $evidenciaId)
    {
        $evidencia = EvidenciaAtender::findOrFail($evidenciaId);

        try {
            $evidencia->delete();
            Alert::success('Éxito', 'Evidencia eliminada exitosamente.');
        } catch (\Exception $e) {
            Alert::error('Error', 'Error al eliminar la evidencia.');
        }

        return redirect()->route('evidenciaatender.index', ['estrategiaId' => $estrategiaId, 'accionAtenderId' => $accionAtenderId]);
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
