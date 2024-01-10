<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalcularAtender; // Cambiado de CalcularPrevenir a CalcularAtender
use App\Models\IndicadorAtender; // Cambiado de IndicadorPrevenir a IndicadorAtender
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Exception;
use PDF;

class CalcularAtenderController extends Controller // Cambiado de CalcularPrevenirController a CalcularAtenderController
{
    public function index(IndicadorAtender $indicadoratender) // Cambiado de $indicadorprevenir a $indicadoratender
    {
        $calculo = CalcularAtender::where('indicador_atender_id', $indicadoratender->id)->first(); // Cambiado de CalcularPrevenir a CalcularAtender

        if ($calculo) {
            return $this->mostrarCalculo($indicadoratender); // Cambiado de $indicadorprevenir a $indicadoratender
        }

        return view('indicadoresatender.calcularatender.index', compact('indicadoratender')); // Cambiado de indicadoresprevenir a indicadoresatender
    }

    public function guardarFormula(Request $request, IndicadorAtender $indicadoratender) // Cambiado de $indicadorprevenir a $indicadoratender
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

            $calculo = new CalcularAtender; // Cambiado de CalcularPrevenir a CalcularAtender
            $calculo->formula = $formula;
            $calculo->variables = $valores;
            $calculo->indicador_atender_id = $indicadoratender->id; // Cambiado de indicador_prevenir_id a indicador_atender_id
            $calculo->resultado = $resultado;
            $calculo->user_id = auth()->id();
            $calculo->save();

            Alert::success('Éxito', 'La fórmula se guardó correctamente.');
            return redirect()->route('indicadoresatender.calcularatender.calculos', ['indicadoratender' => $indicadoratender->id]); // Cambiado de indicadoresprevenir a indicadoresatender

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

    public function mostrarCalculo(IndicadorAtender $indicadoratender) // Cambiado de $indicadorprevenir a $indicadoratender
    {
        $calculo = CalcularAtender::where('indicador_atender_id', $indicadoratender->id)->get(); // Cambiado de CalcularPrevenir a CalcularAtender

        return view('indicadoresatender.calcularatender.calculos', [ // Cambiado de indicadoresprevenir a indicadoresatender
            'indicadoratender' => $indicadoratender,
            'calculo' => $calculo,
        ]);
    }

    public function calcularNuevo(IndicadorAtender $indicadoratender) // Cambiado de $indicadorprevenir a $indicadoratender
    {
        $calculo = CalcularAtender::where('indicador_atender_id', $indicadoratender->id)->first(); // Cambiado de CalcularPrevenir a CalcularAtender
        $variables = $calculo ? self::obtenerVariables($calculo->formula) : [];

        return view('indicadoresatender.calcularatender.calcular', [ // Cambiado de indicadoresprevenir a indicadoresatender
            'indicadoratender' => $indicadoratender,
            'variables' => $variables,
            'formula' => $calculo->formula,
        ]);
    }

    public function guardarNuevoCalculo(Request $request, IndicadorAtender $indicadoratender) // Cambiado de $indicadorprevenir a $indicadoratender
    {
        try {
            $calculo = CalcularAtender::where('indicador_atender_id', $indicadoratender->id)->first(); // Cambiado de CalcularPrevenir a CalcularAtender

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

            $nuevoCalculo = CalcularAtender::create([ // Cambiado de CalcularPrevenir a CalcularAtender
                'formula' => $calculo->formula,
                'indicador_atender_id' => $indicadoratender->id, // Cambiado de indicador_prevenir_id a indicador_atender_id
                'resultado' => $resultado,
                'user_id' => auth()->id(),
                'variables' => $valores,
            ]);

            Alert::success('Éxito', 'Nuevo cálculo realizado correctamente.');
            return redirect()->route('indicadoresatender.calcularatender.calculos', ['indicadoratender' => $indicadoratender->id, 'calculo' => $nuevoCalculo->id]); // Cambiado de indicadoresprevenir a indicadoresatender

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
        $calculo = CalcularAtender::find($id); // Cambiado de CalcularPrevenir a CalcularAtender

        if (!$calculo) {
            return redirect()->back()->with('alert', [
                'title' => 'Error',
                'text' => 'La fórmula no existe.',
                'icon' => 'error',
            ]);
        }

        return view('indicadoresatender.calcularatender.show', compact('calculo')); // Cambiado de indicadoresprevenir a indicadoresatender
    }

    public function edit(CalcularAtender $calculo) // Cambiado de CalcularPrevenir a CalcularAtender
    {
        return view('indicadoresatender.calcularatender.edit', compact('calculo')); // Cambiado de indicadoresprevenir a indicadoresatender
    }

    public function destroy(CalcularAtender $calculo) // Cambiado de CalcularPrevenir a CalcularAtender
    {
        $indicadoratenderId = $calculo->indicador_atender_id; // Cambiado de indicador_prevenir_id a indicador_atender_id

        $calculo->delete();

        Alert::success('Éxito', 'Fórmula eliminada correctamente.')->showConfirmButton('Aceptar');

        return redirect()->route('indicadoresatender.index', ['indicadoratender' => $indicadoratenderId]); // Cambiado de indicadoresprevenir a indicadoresatender
    }

    public function update(Request $request, CalcularAtender $calculo) // Cambiado de CalcularPrevenir a CalcularAtender
    {
        try {
            $calculo->update($request->all());

            Alert::success('Éxito', 'Fórmula editada correctamente.')->showConfirmButton('Aceptar');

            return redirect()->route('indicadoresatender.calcularatender.calculos', ['indicadoratender' => $calculo->indicador_atender_id]); // Cambiado de indicadoresprevenir a indicadoresatender

        } catch (\Exception $e) {
            Alert::error('Error', 'Error al editar la fórmula: ' . $e->getMessage())->showConfirmButton('Aceptar');
            return redirect()->back();
        }
    }

    public function descargarPDF(IndicadorAtender $indicadoratender) // Cambiado de $indicadorprevenir a $indicadoratender
    {
        $calculo = CalcularAtender::where('indicador_atender_id', $indicadoratender->id)->get(); // Cambiado de CalcularPrevenir a CalcularAtender

        if ($calculo->count() === 0) {
            return redirect()->back()->with('error', 'No hay cálculos disponibles para generar el PDF.');
        }

        $pdf = PDF::loadView('pdf', compact('calculo', 'indicadoratender')); // Cambiado de indicadoresprevenir a indicadoresatender

        return $pdf->download('resultados_de_indicador_' . $indicadoratender->id . '.pdf'); // Cambiado de indicadoresprevenir a indicadoresatender
    }
}
