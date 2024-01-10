<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\IndicadorAtender; 
use RealRashid\SweetAlert\Facades\Alert;

class IndicadoresAtenderController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $user_name = $user->name;

        if ($user->hasRole('Administrador')) {
            $indicadores = IndicadorAtender::all(); 
        } else {
            $indicadores = IndicadorAtender::where(function ($query) use ($user_name) {
                    $query->whereRaw("FIND_IN_SET('{$user_name}', REPLACE(medios_verificacion, ', ', ',')) > 0");
                })
                ->get();
        }

        return view('indicadoresatender.index', compact('indicadores')); 
    }

    public function create()
    {
        $users = User::all();
        return view('indicadoresatender.create', compact('users')); 
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

        IndicadorAtender::create([ 
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

        return redirect()->route('indicadoresatender.index') 
            ->with('success', 'Indicador creado exitosamente.');
    }

    public function show($id)
    {
        $indicador = IndicadorAtender::findOrFail($id); 
        return view('indicadoresatender.show', compact('indicador')); 
    }

    public function edit($id)
    {
        $indicador = IndicadorAtender::findOrFail($id); 
        $users = User::all();
        return view('indicadoresatender.edit', compact('indicador', 'users')); 
    }

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
        ]);

        $indicador = IndicadorAtender::findOrFail($id); 

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

        return redirect()->route('indicadoresatender.show', ['indicadoratender' => $indicador->id]);
 
    }

    public function destroy($id)
    {
        $indicador = IndicadorAtender::findOrFail($id); 

        try {
            $indicador->delete();
            Alert::success('Éxito', 'Indicador eliminado exitosamente.')->autoClose(3500);
        } catch (\Exception $e) {
            Alert::error('Error', 'No se pudo eliminar el indicador porque contiene fórmula relacionada.')->autoClose(3500);
        }

        return redirect()->route('indicadoresatender.index'); 
    }
}
