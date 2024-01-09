<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalcularPrevenir;
use App\Models\IndicadorPrevenir;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Exception;
use PDF;


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
        // Obtener la fórmula y verificar si está en minúsculas
        $formula = $request->input('formula');

        if ($formula !== strtolower($formula)) {
            // Mostrar alerta de SweetAlert si la fórmula no está en minúsculas
            Alert::error('Error', 'Favor de poner la fórmula en minúsculas.');
            return redirect()->back();
        }

        // Obtener las variables y realizar la primera evaluación de la fórmula
        $valores = $this->obtenerValoresVariables($request, $formula);

        // Evaluar la fórmula en el lado del servidor (PHP)
        $resultado = $this->evaluarFormula($formula, $valores);

        // Verificar si el resultado es NaN
        if (is_nan($resultado)) {
            // Mostrar alerta de SweetAlert si el resultado es NaN
            Alert::error('Error', 'No se puede guardar el cálculo. Revise e intente de nuevo.');
            return redirect()->back();
        }

        // Almacenar la fórmula y el resultado en la base de datos con el user_id
        $calculo = new CalcularPrevenir;
        $calculo->formula = $formula;
        $calculo->variables = $valores; // Asignar el array directamente
        $calculo->indicador_prevenir_id = $indicadorprevenir->id;
        $calculo->resultado = $resultado; // Almacenar el resultado
        $calculo->user_id = auth()->id(); // Establecer el user_id
        $calculo->save();

        // Mostrar alerta de SweetAlert
        Alert::success('Éxito', 'La fórmula se guardó correctamente.');

        // Redirigir a la vista 'calculos.blade.php' con la fórmula y el resultado
        return redirect()->route('indicadoresprevenir.calcularprevenir.calculos', ['indicadorprevenir' => $indicadorprevenir->id]);

    } catch (Exception $e) {
        // Mostrar alerta de SweetAlert en caso de error
        Alert::error('Error', 'No se puede guardar el cálculo. Revise e intente de nuevo.');
    } catch (\Throwable $t) {
        // Mostrar alerta de SweetAlert en caso de cualquier otra excepción
        Alert::error('Error', 'No se puede guardar el cálculo. Revise e intente de nuevo.');
    }

    // Redirigir de nuevo al formulario u otra lógica según tus necesidades
    return redirect()->back();
}

    
    // Nueva función para obtener valores de variables
    private function obtenerValoresVariables(Request $request, $formula)
    {
        $valores = [];
        $variables = self::obtenerVariables($formula);
        foreach ($variables as $variable) {
            $valorInput = $request->input(strtolower($variable));
            $valores[$variable] = floatval($valorInput);
        }
    
        return $valores;
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
        $valores = $request->except('_token');
        unset($valores['user_id']); // Excluir user_id de la lista de variables

        // Convertir los valores a float
        $valores = array_map('floatval', $valores);

        // Evaluar la fórmula en el lado del servidor (PHP)
        $resultado = $this->evaluarFormula($calculo->formula, $valores);

        // Verificar si el resultado es un número válido (no es NaN y no es una división por cero)
        if (!is_numeric($resultado) || is_nan($resultado) || is_infinite($resultado)) {
            // Mostrar alerta de SweetAlert si el resultado no es válido
            Alert::error('Error', 'No se puede calcular la fórmula. Revise e intente de nuevo.');
            return redirect()->back();
        }

        // Almacenar el nuevo cálculo en la base de datos
        $nuevoCalculo = CalcularPrevenir::create([
            'formula' => $calculo->formula,
            'indicador_prevenir_id' => $indicadorprevenir->id,
            'resultado' => $resultado,
            'user_id' => auth()->id(),
            'variables' => $valores, // Almacena las variables en la base de datos
        ]);

        // Mostrar alerta de SweetAlert
        Alert::success('Éxito', 'Nuevo cálculo realizado correctamente.');

        // Redirigir a la ruta 'indicadoresprevenir.calcularprevenir.calculos' con el ID del nuevo cálculo
        return redirect()->route('indicadoresprevenir.calcularprevenir.calculos', ['indicadorprevenir' => $indicadorprevenir->id, 'calculo' => $nuevoCalculo->id]);

    } catch (\Exception $e) {
        // Mostrar alerta de SweetAlert en caso de error
        alert()->error('Error', 'No se puede calcular la fórmula. Revise e intente de nuevo.');

        // Redirigir de nuevo al formulario u otra lógica según tus necesidades
        return redirect()->back();
    } catch (\Throwable $t) {
        // Mostrar alerta de SweetAlert en caso de cualquier otra excepción
        alert()->error('Error', 'No se puede calcular la fórmula. Revise e intente de nuevo.');

        // Redirigir de nuevo al formulario u otra lógica según tus necesidades
        return redirect()->back();
    }
}

public function show($id)
{
    // Obtener la fórmula por su ID
    $calculo = CalcularPrevenir::find($id);

    // Verificar si la fórmula existe
    if (!$calculo) {
        // Si no existe, redirigir o mostrar un mensaje de error según tus necesidades
        return redirect()->back()->with('alert', [
            'title' => 'Error',
            'text' => 'La fórmula no existe.',
            'icon' => 'error',
        ]);
    }

    // Retornar la vista con los detalles de la fórmula
    return view('indicadoresprevenir.calcularprevenir.show', compact('calculo'));
}

public function edit(CalcularPrevenir $calculo)
    {
        return view('indicadoresprevenir.calcularprevenir.edit', compact('calculo'));
    }

    public function destroy(CalcularPrevenir $calculo)
{
    $indicadorprevenirId = $calculo->indicador_prevenir_id;

    $calculo->delete();

    // Mostrar SweetAlert después de eliminar la fórmula
    Alert::success('Éxito', 'Fórmula eliminada correctamente.')->showConfirmButton('Aceptar');

    return redirect()->route('indicadoresprevenir.index', ['indicadorprevenir' => $indicadorprevenirId]);
}

public function update(Request $request, CalcularPrevenir $calculo)
{
    try {
        $calculo->update($request->all());

        // Mostrar SweetAlert después de editar la fórmula
        Alert::success('Éxito', 'Fórmula editada correctamente.')->showConfirmButton('Aceptar');

        // Redirigir según tus necesidades
        return redirect()->route('indicadoresprevenir.calcularprevenir.calculos', ['indicadorprevenir' => $calculo->indicador_prevenir_id]);

    } catch (\Exception $e) {
        // Manejar el error y mostrar un SweetAlert en caso de error
        Alert::error('Error', 'Error al editar la fórmula: ' . $e->getMessage())->showConfirmButton('Aceptar');

        // Redirigir según tus necesidades
        return redirect()->back();
    }
}

public function descargarPDF(IndicadorPrevenir $indicadorprevenir)
{
    $calculo = CalcularPrevenir::where('indicador_prevenir_id', $indicadorprevenir->id)->get();

    if ($calculo->count() === 0) {
        // No hay cálculos para este indicador, puedes manejar esto como prefieras
        return redirect()->back()->with('error', 'No hay cálculos disponibles para generar el PDF.');
    }

    $pdf = PDF::loadView('pdf', compact('calculo', 'indicadorprevenir'));

    return $pdf->download('resultados_de_indicador_' . $indicadorprevenir->id . '.pdf');

}
}