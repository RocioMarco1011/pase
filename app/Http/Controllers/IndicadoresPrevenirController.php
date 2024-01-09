<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\UsersController;
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
        $users = User::all();
        return view('indicadoresprevenir.create', compact('users'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required',
        'objetivo' => 'required',
        'definicion' => 'required',
        'variables' => 'required',
        'observaciones' => 'nullable',
        'medios_verificacion' => 'required|array',
        'parametro_meta' => 'required|in:Parametro,Meta',
        'unidad_medida' => 'required|in:Porcentaje,Promedio,Proporcion',
        'nivel_desagregacion' => 'required|in:Estatal,Otra',
        'acumulado_periodico' => 'required|in:Acumulado,Periodico',
        'tendencia_esperada' => 'required|in:Ascendente,Descendente',
        'frecuencia_medicion' => 'required|in:Anual,Mensual,Semestral',
        'semaforo' => 'required|in:Verde > 0 - Amarillo = 0 - Rojo < 0,Verde < 0 - Amarillo = 0 - Rojo > 0',
    ]);

    $mediosVerificacionIds = $request->input('medios_verificacion', []);
    $mediosVerificacionUsers = User::whereIn('id', $mediosVerificacionIds)->pluck('name')->implode(', ');

    IndicadorPrevenir::create([
        'nombre' => $request->input('nombre'),
        'objetivo' => $request->input('objetivo'),
        'definicion' => $request->input('definicion'),
        'variables' => $request->input('variables'),
        'observaciones' => $request->input('observaciones'),
        'medios_verificacion' => $mediosVerificacionUsers,
        'parametro_meta' => $request->input('parametro_meta'),
        'unidad_medida' => $request->input('unidad_medida'),
        'nivel_desagregacion' => $request->input('nivel_desagregacion'),
        'acumulado_periodico' => $request->input('acumulado_periodico'),
        'tendencia_esperada' => $request->input('tendencia_esperada'),
        'frecuencia_medicion' => $request->input('frecuencia_medicion'),
        'semaforo' => $request->input('semaforo'),
    ]);

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
        $users = User::all();
        return view('indicadoresprevenir.edit', compact('indicador', 'users'));
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
        'medios_verificacion' => 'nullable|array',
        'parametro_meta' => 'required|string',
        'unidad_medida' => 'required|string',
        'nivel_desagregacion' => 'required|string',
        'acumulado_periodico' => 'required|string',
        'tendencia_esperada' => 'required|string',
        'frecuencia_medicion' => 'required|string',
        'semaforo' => 'required|string',
        // Agrega más reglas de validación según tus necesidades
    ]);

    // Encuentra el indicador por su ID
    $indicador = IndicadorPrevenir::findOrFail($id);

    // Obtiene los IDs de los usuarios seleccionados para los medios de verificación
    $mediosVerificacionIds = $request->input('medios_verificacion', []);

    // Consulta la tabla de usuarios para obtener los nombres de los usuarios correspondientes a esos IDs
    $mediosVerificacionUsers = User::whereIn('id', $mediosVerificacionIds)->pluck('name')->implode(', ');

    // Actualiza los datos del indicador con los nuevos datos del formulario
    $indicador->update([
        'nombre' => $request->input('nombre'),
        'objetivo' => $request->input('objetivo'),
        'definicion' => $request->input('definicion'),
        'variables' => $request->input('variables'),
        'observaciones' => $request->input('observaciones'),
        'medios_verificacion' => $mediosVerificacionUsers,
        'parametro_meta' => $request->input('parametro_meta'),
        'unidad_medida' => $request->input('unidad_medida'),
        'nivel_desagregacion' => $request->input('nivel_desagregacion'),
        'acumulado_periodico' => $request->input('acumulado_periodico'),
        'tendencia_esperada' => $request->input('tendencia_esperada'),
        'frecuencia_medicion' => $request->input('frecuencia_medicion'),
        'semaforo' => $request->input('semaforo'),
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
        Alert::error('Error', 'No se pudo eliminar el indicador porque contiene fórmula relacionada.')->autoClose(3500);
    }

    return redirect()->route('indicadoresprevenir.index');
}
}