<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalcularPrevenir;
use App\Models\IndicadorPrevenir;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Exception;

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

        try {
            // Obtener las variables y realizar la primera evaluación de la fórmula
            $valores = [];
            $variables = self::obtenerVariables($request->input('formula'));
            foreach ($variables as $variable) {
                $valorInput = $request->input(strtolower($variable));
                $valores[$variable] = floatval($valorInput);
            }

            $formula = $request->input('formula');
            // Evaluar la fórmula en el lado del servidor (PHP)
            $resultado = $this->evaluarFormula($formula, $valores);

            // Almacenar la fórmula y el resultado en la base de datos
            $calculo = new CalcularPrevenir;
            $calculo->formula = $formula;
            $calculo->indicador_prevenir_id = $indicadorprevenir->id;
            $calculo->resultado = $resultado; // Almacenar el resultado
            $calculo->save();

            // Mostrar alerta de SweetAlert
            alert()->success('Éxito', 'La fórmula se guardó correctamente.');

            // Resto de la lógica o redirección
            return redirect()->route('indicadoresprevenir.calcularprevenir.index', ['indicadorprevenir' => $indicadorprevenir->id]);

        } catch (Exception $e) {
            // Mostrar alerta de SweetAlert en caso de error
            alert()->error('Error', 'Error al evaluar la fórmula: ' . $e->getMessage());

            // Redirigir de nuevo al formulario u otra lógica según tus necesidades
            return redirect()->back();
        }
    }

    // Función para obtener las variables de una fórmula
    private static function obtenerVariables($formula)
    {
        $matches = preg_match_all('/[a-zA-Z]+/', $formula, $matchesArray);
        return $matches ? array_unique($matchesArray[0]) : [];
    }

    // Función para evaluar la fórmula con la biblioteca Math.js en el lado del servidor (PHP)
    private function evaluarFormula($formula, $valores)
{
    try {
        // Utilizar una instancia de ExpressionLanguage para evaluar la fórmula en PHP
        $language = new ExpressionLanguage();
        $resultado = $language->evaluate($formula, $valores);

        return $resultado;
    } catch (Exception $e) {
        // Manejar cualquier error que ocurra durante la evaluación
        throw new Exception('Error al evaluar la fórmula: ' . $e->getMessage());
    }
}

    // Función para evaluar la fórmula con Math.js en el lado del cliente (JavaScript)
    private function evaluarFormulaEnJavaScript($formula, $valores)
    {
        // Aquí puedes utilizar JavaScript para evaluar la fórmula en el lado del cliente (JavaScript).
        // Puedes comunicarte con JavaScript desde PHP utilizando variables ocultas en el formulario o mediante solicitudes AJAX.
        // En este ejemplo, se utiliza JavaScript solo para evaluar la fórmula en el navegador.
        
        return null; // Modifica según tus necesidades
    }

    // Resto de los métodos del controlador...
}