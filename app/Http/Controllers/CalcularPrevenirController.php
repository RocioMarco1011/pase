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
            return $this->mostrarCalculo($indicadorprevenir);
        }

        return view('indicadoresprevenir.calcularprevenir.index', compact('indicadorprevenir'));
    }

    public function guardarFormula(Request $request, IndicadorPrevenir $indicadorprevenir)
    {
        $request->validate([
            'formula' => 'required|string',
        ]);

        try {
            $formula = $request->input('formula');

            if ($formula !== strtolower($formula)) {
                Alert::error('Error', 'Favor de poner la fórmula en minúsculas.');
                return redirect()->back();
            }

            $valores = $this->obtenerValoresVariables($request, $formula);

            $resultado = $this->evaluarFormula($formula, $valores);

            if (is_nan($resultado)) {
                Alert::error('Error', 'No se puede guardar el cálculo. Revise e intente de nuevo.');
                return redirect()->back();
            }

            $calculo = new CalcularPrevenir;
            $calculo->formula = $formula;
            $calculo->variables = $valores;
            $calculo->indicador_prevenir_id = $indicadorprevenir->id;
            $calculo->resultado = $resultado;
            $calculo->user_id = auth()->id();
            $calculo->save();

            Alert::success('Éxito', 'La fórmula se guardó correctamente.');
            return redirect()->route('indicadoresprevenir.calcularprevenir.calculos', ['indicadorprevenir' => $indicadorprevenir->id]);

        } catch (Exception $e) {
            Alert::error('Error', 'No se puede guardar el cálculo. Revise e intente de nuevo.');
        } catch (\Throwable $t) {
            Alert::error('Error', 'No se puede guardar el cálculo. Revise e intente de nuevo.');
        }

        return redirect()->back();
    }

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

    private static function obtenerVariables($formula)
    {
        $matches = preg_match_all('/[a-zA-Z]+/', $formula, $matchesArray);
        return $matches ? array_unique($matchesArray[0]) : [];
    }

    private function evaluarFormula($formula, $valores)
    {
        try {
            $language = new ExpressionLanguage();
            $resultado = $language->evaluate($formula, $valores);
            return $resultado;
        } catch (Exception $e) {
            throw new Exception('Error al evaluar la fórmula: ' . $e->getMessage());
        }
    }

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
        $calculo = CalcularPrevenir::where('indicador_prevenir_id', $indicadorprevenir->id)->first();
        $variables = $calculo ? self::obtenerVariables($calculo->formula) : [];

        return view('indicadoresprevenir.calcularprevenir.calcular', [
            'indicadorprevenir' => $indicadorprevenir,
            'variables' => $variables,
            'formula' => $calculo->formula,
        ]);
    }

    public function guardarNuevoCalculo(Request $request, IndicadorPrevenir $indicadorprevenir)
    {
        try {
            $calculo = CalcularPrevenir::where('indicador_prevenir_id', $indicadorprevenir->id)->first();

            if (!$calculo) {
                return redirect()->back()->with('alert', [
                    'title' => 'Error',
                    'text' => 'No hay fórmula almacenada para este indicador.',
                    'icon' => 'error',
                ]);
            }

            $valores = $request->except('_token');
            unset($valores['user_id']);

            $valores = array_map('floatval', $valores);

            $resultado = $this->evaluarFormula($calculo->formula, $valores);

            if (!is_numeric($resultado) || is_nan($resultado) || is_infinite($resultado)) {
                Alert::error('Error', 'No se puede calcular la fórmula. Revise e intente de nuevo.');
                return redirect()->back();
            }

            $nuevoCalculo = CalcularPrevenir::create([
                'formula' => $calculo->formula,
                'indicador_prevenir_id' => $indicadorprevenir->id,
                'resultado' => $resultado,
                'user_id' => auth()->id(),
                'variables' => $valores,
            ]);

            Alert::success('Éxito', 'Nuevo cálculo realizado correctamente.');
            return redirect()->route('indicadoresprevenir.calcularprevenir.calculos', ['indicadorprevenir' => $indicadorprevenir->id, 'calculo' => $nuevoCalculo->id]);

        } catch (\Exception $e) {
            alert()->error('Error', 'No se puede calcular la fórmula. Revise e intente de nuevo.');
            return redirect()->back();
        } catch (\Throwable $t) {
            alert()->error('Error', 'No se puede calcular la fórmula. Revise e intente de nuevo.');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $calculo = CalcularPrevenir::find($id);

        if (!$calculo) {
            return redirect()->back()->with('alert', [
                'title' => 'Error',
                'text' => 'La fórmula no existe.',
                'icon' => 'error',
            ]);
        }

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

        Alert::success('Éxito', 'Fórmula eliminada correctamente.')->showConfirmButton('Aceptar');

        return redirect()->route('indicadoresprevenir.index', ['indicadorprevenir' => $indicadorprevenirId]);
    }

    public function update(Request $request, CalcularPrevenir $calculo)
    {
        try {
            $calculo->update($request->all());

            Alert::success('Éxito', 'Fórmula editada correctamente.')->showConfirmButton('Aceptar');

            return redirect()->route('indicadoresprevenir.calcularprevenir.calculos', ['indicadorprevenir' => $calculo->indicador_prevenir_id]);

        } catch (\Exception $e) {
            Alert::error('Error', 'Error al editar la fórmula: ' . $e->getMessage())->showConfirmButton('Aceptar');
            return redirect()->back();
        }
    }

    public function descargarPDF(IndicadorPrevenir $indicadorprevenir)
    {
        $calculo = CalcularPrevenir::where('indicador_prevenir_id', $indicadorprevenir->id)->get();

        if ($calculo->count() === 0) {
            return redirect()->back()->with('error', 'No hay cálculos disponibles para generar el PDF.');
        }

        $pdf = PDF::loadView('indicadoresprevenir.calcularprevenir.pdf', compact('calculo', 'indicadorprevenir'));

        return $pdf->download('resultados_de_indicador_' . $indicadorprevenir->id . '.pdf');
    }
}
