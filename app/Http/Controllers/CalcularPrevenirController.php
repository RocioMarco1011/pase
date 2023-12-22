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
    
    public function guardarFormula(Request $request, IndicadorPrevenir $indicadorprevenir)
    {
        // Verificar si ya existe una fórmula para el indicador actual
        $existeFormula = CalcularPrevenir::where('indicador_prevenir_id', $indicadorprevenir->id)->exists();

        if ($existeFormula) {
            // Mostrar alerta de SweetAlert indicando que ya existe una fórmula
            alert()->error('Error', 'Ya existe una fórmula asociada a este indicador.');

            // Redirigir de nuevo al formulario u otra lógica según tus necesidades
            return redirect()->back();
        }

        // Validación de la solicitud
        $request->validate([
            'formula' => 'required|string',
        ]);

        // Crear un nuevo cálculo y asignar la relación con el indicador actual
        $calculo = new CalcularPrevenir;
        $calculo->formula = $request->input('formula');
        $calculo->indicador_prevenir_id = $indicadorprevenir->id; // Asignar el id del indicador
        $calculo->save();

        // Mostrar alerta de SweetAlert directamente desde el controlador
        alert()->success('Éxito', 'La fórmula se guardó correctamente.');

        // Resto de la lógica o redirección
        return redirect()->route('indicadoresprevenir.calcularprevenir.index', ['indicadorprevenir' => $indicadorprevenir->id]);
    }
}