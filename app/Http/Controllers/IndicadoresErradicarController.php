<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\IndicadorErradicar;
use RealRashid\SweetAlert\Facades\Alert;

class IndicadoresErradicarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $user_name = $user->name;

        if ($user->hasRole('Administrador')) {
            $indicadores = IndicadorErradicar::all();
        } else {
            $indicadores = IndicadorErradicar::where(function ($query) use ($user_name) {
                $query->whereRaw("FIND_IN_SET('{$user_name}', REPLACE(medios_verificacion, ', ', ',')) > 0");
            })->get();
        }

        return view('indicadoreserradicar.index', compact('indicadores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('indicadoreserradicar.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

        IndicadorErradicar::create([
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

        return redirect()->route('indicadoreserradicar.index')
            ->with('success', 'Indicador creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $indicador = IndicadorErradicar::findOrFail($id);
        return view('indicadoreserradicar.show', compact('indicador'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $indicador = IndicadorErradicar::findOrFail($id);
        $users = User::all();
        return view('indicadoreserradicar.edit', compact('indicador', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
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
    

        $indicador = IndicadorErradicar::findOrFail($id);

        $mediosVerificacionIds = $request->input('medios_verificacion', []);
        $mediosVerificacionUsers = User::whereIn('id', $mediosVerificacionIds)->pluck('name')->implode(', ');

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
        ]);

        Alert::success('Éxito', 'Indicador editado exitosamente.');

        return redirect()->route('indicadoreserradicar.show', ['indicadoreserradicar' => $indicador->id])
            ->with('success', 'Indicador actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $indicador = IndicadorErradicar::findOrFail($id);

        try {
            $indicador->delete();
            Alert::success('Éxito', 'Indicador eliminado exitosamente.')->autoClose(3500);
        } catch (\Exception $e) {
            Alert::error('Error', 'No se pudo eliminar el indicador porque contiene fórmula relacionada.')->autoClose(3500);
        }

        return redirect()->route('indicadoreserradicar.index');
    }
}
