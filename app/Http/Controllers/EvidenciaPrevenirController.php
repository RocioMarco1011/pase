<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EvidenciaPrevenir;

class EvidenciaPrevenirController extends Controller
{
    public function index()
    {
        $evidencias = EvidenciaPrevenir::all();
        return view('estrategiasprevenir.accionprevenir.evidenciaprevenir.index', compact('evidencias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'evidencia' => 'required|mimes:jpeg,png,pdf', // Ajusta las validaciones según tus necesidades
            'mensaje' => 'nullable|string',
        ]);

        $evidencia = $request->file('evidencia');
        $nombreEvidencia = $evidencia->store('evidencias', 'public');

        EvidenciaPrevenir::create([
            'nombre' => $nombreEvidencia,
            'mensaje' => $request->input('mensaje'),
            'accion_prevenir_id' => $request->input('accion_prevenir_id'), // Asegúrate de enviar el ID de la acción de prevención
        ]);

        return redirect()->route('evidenciaprevenir.index');
    }
}
