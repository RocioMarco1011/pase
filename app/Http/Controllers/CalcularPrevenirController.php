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
        $calculo = CalcularPrevenir::where('indicador_prevenir_id', $indicadorprevenir->id)->first();

        if ($calculo) {
            // Si ya existe un cálculo, redirigir a la vista 'calculos.blade.php'
            return $this->mostrarCalculo($indicadorprevenir);
        }

        // Si no existe un cálculo, mostrar el formulario en la vista 'index.blade.php'
        return view('indicadoresprevenir.calcularprevenir.index', compact('indicadorprevenir'));
    }
    
    public function guardarFormula(Request $request, IndicadorPrevenir $indicadorprevenir)
{
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
        Alert::success('Éxito', 'La fórmula se guardó correctamente.');

        // Redirigir a la vista 'calculos.blade.php' con la fórmula y el resultado
        return redirect()->route('indicadoresprevenir.calcularprevenir.calculos', ['indicadorprevenir' => $indicadorprevenir->id]);

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

    // Método para mostrar la vista 'calculos.blade.php'
    public function mostrarCalculo(IndicadorPrevenir $indicadorprevenir)
    {
        $calculo = CalcularPrevenir::where('indicador_prevenir_id', $indicadorprevenir->id)->get();

        return view('indicadoresprevenir.calcularprevenir.calculos', [
            'indicadorprevenir' => $indicadorprevenir,
            'calculo' => $calculo,
        ]);
    }

    public function calcularNuevo(IndicadorPrevenir $indicadorprevenir)
{
    // Obtener la fórmula almacenada en la base de datos
    $calculo = CalcularPrevenir::where('indicador_prevenir_id', $indicadorprevenir->id)->first();
    $variables = $calculo ? self::obtenerVariables($calculo->formula) : [];

    return view('indicadoresprevenir.calcularprevenir.calcular', [
        'indicadorprevenir' => $indicadorprevenir,
        'variables' => $variables,
        'formula' => $calculo->formula, // Asegúrate de pasar la fórmula a la vista
    ]);
}

public function guardarNuevoCalculo(Request $request, IndicadorPrevenir $indicadorprevenir)
{
    try {
        // Obtener la fórmula almacenada en la base de datos
        $calculo = CalcularPrevenir::where('indicador_prevenir_id', $indicadorprevenir->id)->first();

        if (!$calculo) {
            // Si no hay fórmula almacenada, mostrar un error o redirigir según tus necesidades
            return redirect()->back()->with('alert', [
                'title' => 'Error',
                'text' => 'No hay fórmula almacenada para este indicador.',
                'icon' => 'error',
            ]);
        }

        // Obtener las variables y realizar la evaluación de la fórmula
        $valores = [];
        foreach ($request->except('_token') as $key => $value) {
            $valores[$key] = floatval($value);
        }

        // Evaluar la fórmula en el lado del servidor (PHP)
        $resultado = $this->evaluarFormula($calculo->formula, $valores);

        // Almacenar el nuevo cálculo en la base de datos
        CalcularPrevenir::create([
            'formula' => $calculo->formula,
            'indicador_prevenir_id' => $indicadorprevenir->id,
            'resultado' => $resultado,
        ]);

        // Mostrar alerta de SweetAlert
        Alert::success('Éxito', 'Nuevo cálculo realizado correctamente.');

        // Redirigir a la ruta 'indicadoresprevenir.calcularprevenir.calculos'
        return redirect()->route('indicadoresprevenir.calcularprevenir.calculos', ['indicadorprevenir' => $indicadorprevenir->id]);

    } catch (\Exception $e) {
        // Mostrar alerta de SweetAlert en caso de error
        alert()->error('Error', 'Error al evaluar la fórmula: ' . $e->getMessage());

        // Redirigir de nuevo al formulario u otra lógica según tus necesidades
        return redirect()->back();
    }
}
}