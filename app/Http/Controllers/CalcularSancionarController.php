<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalcularSancionar;
use App\Models\IndicadorSancionar;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Exception;
use PDF;

class CalcularSancionarController extends Controller
{
    public function index(IndicadorSancionar $indicadorsancionar)
    {
        $calculo = CalcularSancionar::where('indicador_sancionar_id', $indicadorsancionar->id)->first();

        if ($calculo) {
            return $this->mostrarCalculo($indicadorsancionar);
        }

        return view('indicadoressancionar.calcularsancionar.index', compact('indicadorsancionar'));
    }
    
    public function guardarFormula(Request $request, IndicadorSancionar $indicadorsancionar)
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

            $calculo = new CalcularSancionar;
            $calculo->formula = $formula;
            $calculo->variables = $valores;
            $calculo->indicador_sancionar_id = $indicadorsancionar->id;
            $calculo->resultado = $resultado;
            $calculo->user_id = auth()->id();
            $calculo->save();

            Alert::success('Éxito', 'La fórmula se guardó correctamente.');

            return redirect()->route('indicadoressancionar.calcularsancionar.calculos', ['indicadorsancionar' => $indicadorsancionar->id]);

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

    public function mostrarCalculo(IndicadorSancionar $indicadorsancionar)
    {
        $calculo = CalcularSancionar::where('indicador_sancionar_id', $indicadorsancionar->id)->get();

        return view('indicadoressancionar.calcularsancionar.calculos', [
            'indicadorsancionar' => $indicadorsancionar,
            'calculo' => $calculo,
        ]);
    }

    public function calcularNuevo(IndicadorSancionar $indicadorsancionar)
    {
        $calculo = CalcularSancionar::where('indicador_sancionar_id', $indicadorsancionar->id)->first();
        $variables = $calculo ? self::obtenerVariables($calculo->formula) : [];

        return view('indicadoressancionar.calcularsancionar.calcular', [
            'indicadorsancionar' => $indicadorsancionar,
            'variables' => $variables,
            'formula' => $calculo->formula,
        ]);
    }

    public function guardarNuevoCalculo(Request $request, IndicadorSancionar $indicadorsancionar)
    {
        try {
            $calculo = CalcularSancionar::where('indicador_sancionar_id', $indicadorsancionar->id)->first();

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

            $nuevoCalculo = CalcularSancionar::create([
                'formula' => $calculo->formula,
                'indicador_sancionar_id' => $indicadorsancionar->id,
                'resultado' => $resultado,
                'user_id' => auth()->id(),
                'variables' => $valores,
            ]);

            Alert::success('Éxito', 'Nuevo cálculo realizado correctamente.');

            return redirect()->route('indicadoressancionar.calcularsancionar.calculos', ['indicadorsancionar' => $indicadorsancionar->id, 'calculo' => $nuevoCalculo->id]);

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
        $calculo = CalcularSancionar::find($id);

        if (!$calculo) {
            return redirect()->back()->with('alert', [
                'title' => 'Error',
                'text' => 'La fórmula no existe.',
                'icon' => 'error',
            ]);
        }

        return view('indicadoressancionar.calcularsancionar.show', compact('calculo'));
    }

    public function edit(CalcularSancionar $calculo)
    {
        return view('indicadoressancionar.calcularsancionar.edit', compact('calculo'));
    }

    public function destroy(CalcularSancionar $calculo)
    {
        $indicadorsancionarId = $calculo->indicador_sancionar_id;

        $calculo->delete();

        Alert::success('Éxito', 'Fórmula eliminada correctamente.')->showConfirmButton('Aceptar');

        return redirect()->route('indicadoressancionar.index', ['indicadorsancionar' => $indicadorsancionarId]);
    }

    public function update(Request $request, CalcularSancionar $calculo)
    {
        try {
            $calculo->update($request->all());

            Alert::success('Éxito', 'Fórmula editada correctamente.')->showConfirmButton('Aceptar');

            return redirect()->route('indicadoressancionar.calcularsancionar.calculos', ['indicadorsancionar' => $calculo->indicador_sancionar_id]);

        } catch (\Exception $e) {
            Alert::error('Error', 'Error al editar la fórmula: ' . $e->getMessage())->showConfirmButton('Aceptar');

            return redirect()->back();
        }
    }

    public function descargarPDF(IndicadorSancionar $indicadorsancionar)
    {
        $calculo = CalcularSancionar::where('indicador_sancionar_id', $indicadorsancionar->id)->get();

        if ($calculo->count() === 0) {
            return redirect()->back()->with('error', 'No hay cálculos disponibles para generar el PDF.');
        }

        $pdf = PDF::loadView('pdf', compact('calculo', 'indicadorsancionar'));

        return $pdf->download('resultados_de_indicador_' . $indicadorsancionar->id . '.pdf');
    }
}
