<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CalcularPrevenir;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Illuminate\Support\Facades\DB;
use App\Models\IndicadorPrevenir;
use Illuminate\Http\JsonResponse;

class CalcularPrevenirController extends Controller
{
    public function index($indicadorPrevenirId)
{
    // Obtener el indicador_prevenir por su ID (ajusta esto según tu lógica)
    $indicadorPrevenir = IndicadorPrevenir::findOrFail($indicadorPrevenirId);

    // Obtener todas las fórmulas asociadas a este indicador
    $calculos = CalcularPrevenir::where('indicador_prevenir_id', $indicadorPrevenirId)->get();

    // Pasar las variables a la vista
    return view('indicadoresprevenir.calcularprevenir.index', compact('indicadorPrevenir', 'calculos'));
}


    public function edit($id)
    {
        $calculo = CalcularPrevenir::findOrFail($id);

        return view('calcularprevenir.edit', compact('calculo'));
    }

    // Puedes agregar otras funciones según tus necesidades

    // Ejemplo de función para actualizar un cálculo

    public function store(Request $request, $indicadorPrevenirId)
    {
        // Validar la entrada del formulario
        $request->validate([
            'formula' => 'required|string',
        ]);
    
        try {
            // Guardar la fórmula con el ID del indicador_prevenir
            CalcularPrevenir::create([
                'indicador_prevenir_id' => $indicadorPrevenirId,
                'formula' => $request->input('formula'),
            ]);
    
            // Redireccionar con un mensaje de éxito
            return redirect()->route('indicadoresprevenir.calcularprevenir.index', ['indicadorprevenir' => $indicadorPrevenirId])
                ->with('success', 'Fórmula guardada exitosamente');
        } catch (\Exception $e) {
            // Manejar cualquier error que pueda ocurrir durante el proceso de guardado
            return redirect()->route('indicadoresprevenir.calcularprevenir.index', ['indicadorprevenir' => $indicadorPrevenirId])
                ->with('error', 'Error al guardar la fórmula. Detalles: ' . $e->getMessage());
        }
    }
    

public function guardarVariables(Request $request, $id)
    {
        // Obtener el cálculo por su ID
        $calculo = CalcularPrevenir::findOrFail($id);

        // Validar y guardar las variables
        $request->validate([
            'variable1' => 'required',
            'variable2' => 'required',
            // Agrega más reglas de validación según sea necesario
        ]);

        // Guardar las variables en el modelo
        $calculo->variables = $request->only(['variable1', 'variable2']);
        $calculo->save();

        // Puedes redirigir a la vista de resultados o realizar otras acciones según tus necesidades
        return redirect()->route('indicadoresprevenir.calcularprevenir.index')->with('success', 'Variables guardadas exitosamente');
    }

}