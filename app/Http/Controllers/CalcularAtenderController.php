<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalcularAtender; 
use App\Models\IndicadorAtender; 
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Exception;
use PDF;

class CalcularAtenderController extends Controller 
{
    public function index(IndicadorAtender $indicadoratender) 
    {
        $calculo = CalcularAtender::where('indicador_atender_id', $indicadoratender->id)->first(); 

        if ($calculo) {
            return $this->mostrarCalculo($indicadoratender); 
        }

        return view('indicadoresatender.calcularatender.index', compact('indicadoratender'));
    }

    public function guardarFormula(Request $request, IndicadorAtender $indicadoratender) 
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

            $calculo = new CalcularAtender; 
            $calculo->formula = $formula;
            $calculo->variables = $valores;
            $calculo->indicador_atender_id = $indicadoratender->id; 
            $calculo->resultado = $resultado;
            $calculo->user_id = auth()->id();
            $calculo->save();

            Alert::success('Éxito', 'La fórmula se guardó correctamente.');
            return redirect()->route('indicadoresatender.calcularatender.calculos', ['indicadoratender' => $indicadoratender->id]); 

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

    public function mostrarCalculo(IndicadorAtender $indicadoratender) 
    {
        $calculo = CalcularAtender::where('indicador_atender_id', $indicadoratender->id)->get(); 

        return view('indicadoresatender.calcularatender.calculos', [ 
            'indicadoratender' => $indicadoratender,
            'calculo' => $calculo,
        ]);
    }

    public function calcularNuevo(IndicadorAtender $indicadoratender) 
    {
        $calculo = CalcularAtender::where('indicador_atender_id', $indicadoratender->id)->first(); 
        $variables = $calculo ? self::obtenerVariables($calculo->formula) : [];

        return view('indicadoresatender.calcularatender.calcular', [ 
            'indicadoratender' => $indicadoratender,
            'variables' => $variables,
            'formula' => $calculo->formula,
        ]);
    }

    public function guardarNuevoCalculo(Request $request, IndicadorAtender $indicadoratender) 
    {
        try {
            $calculo = CalcularAtender::where('indicador_atender_id', $indicadoratender->id)->first(); 

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

            $nuevoCalculo = CalcularAtender::create([ 
                'formula' => $calculo->formula,
                'indicador_atender_id' => $indicadoratender->id, 
                'resultado' => $resultado,
                'user_id' => auth()->id(),
                'variables' => $valores,
            ]);

            Alert::success('Éxito', 'Nuevo cálculo realizado correctamente.');
            return redirect()->route('indicadoresatender.calcularatender.calculos', ['indicadoratender' => $indicadoratender->id, 'calculo' => $nuevoCalculo->id]); 

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
        $calculo = CalcularAtender::find($id); 

        if (!$calculo) {
            return redirect()->back()->with('alert', [
                'title' => 'Error',
                'text' => 'La fórmula no existe.',
                'icon' => 'error',
            ]);
        }

        return view('indicadoresatender.calcularatender.show', compact('calculo')); 
    }

    public function edit(CalcularAtender $calculo) 
    {
        return view('indicadoresatender.calcularatender.edit', compact('calculo')); 
    }

    public function destroy(CalcularAtender $calculo) 
    {
        $indicadoratenderId = $calculo->indicador_atender_id; 

        $calculo->delete();

        Alert::success('Éxito', 'Fórmula eliminada correctamente.')->showConfirmButton('Aceptar');

        return redirect()->route('indicadoresatender.index', ['indicadoratender' => $indicadoratenderId]); 
    }

    public function update(Request $request, CalcularAtender $calculo) 
    {
        try {
            $calculo->update($request->all());

            Alert::success('Éxito', 'Fórmula editada correctamente.')->showConfirmButton('Aceptar');

            return redirect()->route('indicadoresatender.calcularatender.calculos', ['indicadoratender' => $calculo->indicador_atender_id]); 

        } catch (\Exception $e) {
            Alert::error('Error', 'Error al editar la fórmula: ' . $e->getMessage())->showConfirmButton('Aceptar');
            return redirect()->back();
        }
    }

    public function descargarPDF(IndicadorAtender $indicadoratender) 
    {
        $calculo = CalcularAtender::where('indicador_atender_id', $indicadoratender->id)->get(); 

        if ($calculo->count() === 0) {
            return redirect()->back()->with('error', 'No hay cálculos disponibles para generar el PDF.');
        }

        $pdf = PDF::loadView('indicadoresatender.calcularatender.pdf', compact('calculo', 'indicadoratender')); 

        return $pdf->download('resultados_de_indicador_' . $indicadoratender->id . '.pdf'); 
    }
}
