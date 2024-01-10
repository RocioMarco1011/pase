<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalcularErradicar;
use App\Models\IndicadorErradicar;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Exception;
use PDF;

class CalcularErradicarController extends Controller
{
    public function index(IndicadorErradicar $indicadorerradicar)
    {
        $calculo = CalcularErradicar::where('indicador_erradicar_id', $indicadorerradicar->id)->first();

        if ($calculo) {
            return $this->mostrarCalculo($indicadorerradicar);
        }

        return view('indicadoreserradicar.calcularerradicar.index', compact('indicadorerradicar'));
    }
    
    public function guardarFormula(Request $request, IndicadorErradicar $indicadorerradicar)
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

            $calculo = new CalcularErradicar;
            $calculo->formula = $formula;
            $calculo->variables = $valores;
            $calculo->indicador_erradicar_id = $indicadorerradicar->id;
            $calculo->resultado = $resultado;
            $calculo->user_id = auth()->id();
            $calculo->save();

            Alert::success('Éxito', 'La fórmula se guardó correctamente.');

            return redirect()->route('indicadoreserradicar.calcularerradicar.calculos', ['indicadorerradicar' => $indicadorerradicar->id]);

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

    public function mostrarCalculo(IndicadorErradicar $indicadorerradicar)
    {
        $calculo = CalcularErradicar::where('indicador_erradicar_id', $indicadorerradicar->id)->get();

        return view('indicadoreserradicar.calcularerradicar.calculos', [
            'indicadorerradicar' => $indicadorerradicar,
            'calculo' => $calculo,
        ]);
    }

    public function calcularNuevo(IndicadorErradicar $indicadorerradicar)
    {
        $calculo = CalcularErradicar::where('indicador_erradicar_id', $indicadorerradicar->id)->first();
        $variables = $calculo ? self::obtenerVariables($calculo->formula) : [];

        return view('indicadoreserradicar.calcularerradicar.calcular', [
            'indicadorerradicar' => $indicadorerradicar,
            'variables' => $variables,
            'formula' => $calculo->formula,
        ]);
    }

    public function guardarNuevoCalculo(Request $request, IndicadorErradicar $indicadorerradicar)
    {
        try {
            $calculo = CalcularErradicar::where('indicador_erradicar_id', $indicadorerradicar->id)->first();

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

            $nuevoCalculo = CalcularErradicar::create([
                'formula' => $calculo->formula,
                'indicador_erradicar_id' => $indicadorerradicar->id,
                'resultado' => $resultado,
                'user_id' => auth()->id(),
                'variables' => $valores,
            ]);

            Alert::success('Éxito', 'Nuevo cálculo realizado correctamente.');

            return redirect()->route('indicadoreserradicar.calcularerradicar.calculos', ['indicadorerradicar' => $indicadorerradicar->id, 'calculo' => $nuevoCalculo->id]);

        } catch (\Exception $e) {
            Alert::error('Error', 'No se puede calcular la fórmula. Revise e intente de nuevo.');
            return redirect()->back();
        } catch (\Throwable $t) {
            Alert::error('Error', 'No se puede calcular la fórmula. Revise e intente de nuevo.');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $calculo = CalcularErradicar::find($id);

        if (!$calculo) {
            return redirect()->back()->with('alert', [
                'title' => 'Error',
                'text' => 'La fórmula no existe.',
                'icon' => 'error',
            ]);
        }

        return view('indicadoreserradicar.calcularerradicar.show', compact('calculo'));
    }

    public function edit(CalcularErradicar $calculo)
    {
        return view('indicadoreserradicar.calcularerradicar.edit', compact('calculo'));
    }

    public function destroy(CalcularErradicar $calculo)
    {
        $indicadorerradicarId = $calculo->indicador_erradicar_id;

        $calculo->delete();

        Alert::success('Éxito', 'Fórmula eliminada correctamente.')->showConfirmButton('Aceptar');

        return redirect()->route('indicadoreserradicar.index', ['indicadorerradicar' => $indicadorerradicarId]);
    }

    public function update(Request $request, CalcularErradicar $calculo)
    {
        try {
            $calculo->update($request->all());

            Alert::success('Éxito', 'Fórmula editada correctamente.')->showConfirmButton('Aceptar');

            return redirect()->route('indicadoreserradicar.calcularerradicar.calculos', ['indicadorerradicar' => $calculo->indicador_erradicar_id]);

        } catch (\Exception $e) {
            Alert::error('Error', 'Error al editar la fórmula: ' . $e->getMessage())->showConfirmButton('Aceptar');

            return redirect()->back();
        }
    }

    public function descargarPDF(IndicadorErradicar $indicadorerradicar)
    {
        $calculo = CalcularErradicar::where('indicador_erradicar_id', $indicadorerradicar->id)->get();

        if ($calculo->count() === 0) {
            return redirect()->back()->with('error', 'No hay cálculos disponibles para generar el PDF.');
        }

        $pdf = PDF::loadView('indicadoreserradicar.calcularerradicar.pdf', compact('calculo', 'indicadorerradicar'));

        return $pdf->download('resultados_de_indicador_' . $indicadorerradicar->id . '.pdf');
    }
}
