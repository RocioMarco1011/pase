<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IndicadorPrevenir;
use RealRashid\SweetAlert\Facades\Alert;

class IndicadoresPrevenirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $indicadores = IndicadorPrevenir::all();
        return view('indicadoresprevenir.index', compact('indicadores'));
    }

    public function create()
    {
        return view('indicadoresprevenir.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'objetivo' => 'required',
            // ... otros campos
        ]);

        IndicadorPrevenir::create($request->all());
        Alert::success('Éxito', 'Indicador creado exitosamente.');

        return redirect()->route('indicadoresprevenir.index')
            ->with('success', 'Indicador creado exitosamente.');
    }

    public function show($id)
    {
        $indicador = IndicadorPrevenir::findOrFail($id);
        return view('indicadoresprevenir.show', compact('indicador'));
    }

    public function edit($id)
    {
        $indicador = IndicadorPrevenir::findOrFail($id);
        return view('indicadoresprevenir.edit', compact('indicador'));
    }

    public function update(Request $request, $id)
    {
        // Validación de los datos del formulario
        $request->validate([
            'nombre' => 'required|string',
            'objetivo' => 'required|string',
            'definicion' => 'required|string',
            'variables' => 'required|string',
            'observaciones' => 'nullable|string',
            'medios_verificacion' => 'nullable|string',
            'parametro_meta' => 'required|string',
            'unidad_medida' => 'required|string',
            'nivel_desagregacion' => 'required|string',
            'acumulado_periodico' => 'required|string',
            'tendencia_esperada' => 'required|string',
            'frecuencia_medicion' => 'required|string',
            // Agrega más reglas de validación según tus necesidades
        ]);

        // Encuentra el indicador por su ID
        $indicador = IndicadorPrevenir::findOrFail($id);

        // Actualiza los datos del indicador con los nuevos datos del formulario
        $indicador->update([
            'nombre' => $request->input('nombre'),
            'objetivo' => $request->input('objetivo'),
            'definicion' => $request->input('definicion'),
            'variables' => $request->input('variables'),
            'observaciones' => $request->input('observaciones'),
            'medios_verificacion' => $request->input('medios_verificacion'),
            'parametro_meta' => $request->input('parametro_meta'),
            'unidad_medida' => $request->input('unidad_medida'),
            'nivel_desagregacion' => $request->input('nivel_desagregacion'),
            'acumulado_periodico' => $request->input('acumulado_periodico'),
            'tendencia_esperada' => $request->input('tendencia_esperada'),
            'frecuencia_medicion' => $request->input('frecuencia_medicion'),
            // Actualiza más campos según tus necesidades
        ]);
        Alert::success('Éxito', 'Indicador editado exitosamente.');
        // Redirecciona a la vista de detalles del indicador o a donde prefieras
        return redirect()->route('indicadoresprevenir.show', ['indicadorprevenir' => $indicador->id])
            ->with('success', 'Indicador actualizado exitosamente.');
    }

    public function destroy($id)
{
    $indicador = IndicadorPrevenir::findOrFail($id);

    try {
        $indicador->delete();
        Alert::success('Éxito', 'Indicador eliminado exitosamente.')->autoClose(3500);
    } catch (\Exception $e) {
        Alert::error('Error', 'No se pudo eliminar el indicador porque contiene una fórmula relacionada.')->autoClose(3500);
    }

    return redirect()->route('indicadoresprevenir.index');
}
}