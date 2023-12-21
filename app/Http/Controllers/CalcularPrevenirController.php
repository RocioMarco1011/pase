<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalcularPrevenir;
use Illuminate\Support\Facades\DB;
use App\Models\IndicadorPrevenir;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class CalcularPrevenirController extends Controller
{
    public function index(IndicadorPrevenir $indicadorprevenir)
    {
        $calculos = CalcularPrevenir::where('indicador_prevenir_id', $indicadorprevenir->id)->get();

        return view('indicadoresprevenir.calcularprevenir.index', compact('indicadorprevenir', 'calculos'));
    }

    public function create($indicadorprevenirId)
{
    $indicadorprevenir = IndicadorPrevenir::findOrFail($indicadorprevenirId);
    $calculoExistente = $indicadorprevenir->calcularprevenir;

    if ($calculoExistente) {
        // Si ya hay una fórmula guardada, muestra un mensaje de error
        Alert::error('Error', 'Existe ya una fórmula guardada para este indicador.');
        return redirect()->route('indicadoresprevenir.calcularprevenir.index', ['indicadorprevenir' => $indicadorprevenir->id]);
    }

    return view('indicadoresprevenir.calcularprevenir.create', compact('indicadorprevenir'));
}

    public function store(Request $request, IndicadorPrevenir $indicadorprevenir)
    {
        try {
            $calculoExistente = $indicadorprevenir->calcularprevenir;

            if ($calculoExistente) {
                $calculoExistente->update([
                    'formula' => $request->input('formula'),
                    // Otros campos según tus necesidades
                ]);
            } else {
                $indicadorprevenir->calcularprevenir()->create([
                    'formula' => $request->input('formula'),
                    // Otros campos según tus necesidades
                ]);
            }

            Alert::success('Éxito', 'Fórmula guardada exitosamente.');
        } catch (\Exception $e) {
            Alert::error('Error', 'Error al guardar la fórmula: ' . $e->getMessage());
        }

        return redirect()->route('indicadoresprevenir.calcularprevenir.index', ['indicadorprevenir' => $indicadorprevenir->id]);
    }

    public function show(IndicadorPrevenir $indicadorprevenir, CalcularPrevenir $calculo)
    {
        return view('indicadoresprevenir.calcularprevenir.show', compact('indicadorprevenir', 'calculo'));
    }
}