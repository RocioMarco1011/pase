@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            EDITAR INDICADOR DE ATENCIÓN
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('indicadoresatender.update', ['indicadoratender' => $indicador->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-semibold text-gray-600">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $indicador->nombre) }}" class="form-input mt-1 block w-full" required />
                        </div>

                        <div class="mb-4">
                            <label for="objetivo" class="block text-sm font-semibold text-gray-600">Objetivo:</label>
                            <textarea name="objetivo" id="objetivo" class="form-input mt-1 block w-full" rows="4">{{ old('objetivo', $indicador->objetivo) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="definicion" class="block text-sm font-semibold text-gray-600">Definición:</label>
                            <textarea name="definicion" id="definicion" class="form-input mt-1 block w-full" rows="4">{{ old('definicion', $indicador->definicion) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="variables" class="block text-sm font-semibold text-gray-600">Variables:</label>
                            <textarea name="variables" id="variables" class="form-input mt-1 block w-full" rows="4">{{ old('variables', $indicador->variables) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="observaciones" class="block text-sm font-semibold text-gray-600">Observaciones:</label>
                            <textarea name="observaciones" id="observaciones" class="form-input mt-1 block w-full" rows="4">{{ old('observaciones', $indicador->observaciones) }}</textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label for="medios_verificacion" class="block text-lg font-medium text-gray-700">Medios de Verificación:</label>
                            <select name="medios_verificacion[]" id="medios_verificacion" class="js-example-basic-multiple" multiple>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ in_array($user->id, $medios_verificacion ?? []) ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="parametro_meta" class="block text-sm font-semibold text-gray-600">Parámetro/Meta:</label>
                            <select name="parametro_meta" id="parametro_meta" class="form-select mt-1 block w-full" required>
                                <option value="Parametro" {{ old('parametro_meta', $indicador->parametro_meta) == 'Parametro' ? 'selected' : '' }}>Parámetro</option>
                                <option value="Meta" {{ old('parametro_meta', $indicador->parametro_meta) == 'Meta' ? 'selected' : '' }}>Meta</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="unidad_medida" class="block text-sm font-semibold text-gray-600">Unidad de Medida:</label>
                            <select name="unidad_medida" id="unidad_medida" class="form-select mt-1 block w-full" required>
                                <option value="Porcentaje" {{ old('unidad_medida', $indicador->unidad_medida) == 'Porcentaje' ? 'selected' : '' }}>Porcentaje</option>
                                <option value="Promedio" {{ old('unidad_medida', $indicador->unidad_medida) == 'Promedio' ? 'selected' : '' }}>Promedio</option>
                                <option value="Proporcion" {{ old('unidad_medida', $indicador->unidad_medida) == 'Proporcion' ? 'selected' : '' }}>Proporción</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="nivel_desagregacion" class="block text-sm font-semibold text-gray-600">Nivel de Desagregación:</label>
                            <select name="nivel_desagregacion" id="nivel_desagregacion" class="form-select mt-1 block w-full" required>
                                <option value="Estatal" {{ old('nivel_desagregacion', $indicador->nivel_desagregacion) == 'Estatal' ? 'selected' : '' }}>Estatal</option>
                                <option value="Otra" {{ old('nivel_desagregacion', $indicador->nivel_desagregacion) == 'Otra' ? 'selected' : '' }}>Otra</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="acumulado_periodico" class="block text-sm font-semibold text-gray-600">Acumulado/Periódico:</label>
                            <select name="acumulado_periodico" id="acumulado_periodico" class="form-select mt-1 block w-full" required>
                                <option value="Acumulado" {{ old('acumulado_periodico', $indicador->acumulado_periodico) == 'Acumulado' ? 'selected' : '' }}>Acumulado</option>
                                <option value="Periodico" {{ old('acumulado_periodico', $indicador->acumulado_periodico) == 'Periodico' ? 'selected' : '' }}>Periódico</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="tendencia_esperada" class="block text-sm font-semibold text-gray-600">Tendencia Esperada:</label>
                            <select name="tendencia_esperada" id="tendencia_esperada" class="form-select mt-1 block w-full" required>
                                <option value="Ascendente" {{ old('tendencia_esperada', $indicador->tendencia_esperada) == 'Ascendente' ? 'selected' : '' }}>Ascendente</option>
                                <option value="Descendente" {{ old('tendencia_esperada', $indicador->tendencia_esperada) == 'Descendente' ? 'selected' : '' }}>Descendente</option>
                                
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="frecuencia_medicion" class="block text-sm font-semibold text-gray-600">Frecuencia de Medición:</label>
                            <select name="frecuencia_medicion" id="frecuencia_medicion" class="form-select mt-1 block w-full" required>
                                <option value="Anual" {{ old('frecuencia_medicion', $indicador->frecuencia_medicion) == 'Anual' ? 'selected' : '' }}>Anual</option>
                                <option value="Mensual" {{ old('frecuencia_medicion', $indicador->frecuencia_medicion) == 'Mensual' ? 'selected' : '' }}>Mensual</option>
                                <option value="Semestral" {{ old('frecuencia_medicion', $indicador->frecuencia_medicion) == 'Semestral' ? 'selected' : '' }}>Semestral</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="semaforo" class="block text-sm font-semibold text-gray-600">Semáforo:</label>
                            <select name="semaforo" id="semaforo" class="form-select mt-1 block w-full" required>
                                <option value="Verde > 0 - Amarillo = 0 - Rojo < 0" {{ old('semaforo', $indicador->semaforo) == 'Verde > 0 - Amarillo = 0 - Rojo < 0' ? 'selected' : '' }}>Verde > 0 - Amarillo = 0 - Rojo < 0</option>
                                <option value="Verde < 0 - Amarillo = 0 - Rojo > 0" {{ old('semaforo', $indicador->semaforo) == 'Verde < 0 - Amarillo = 0 - Rojo > 0' ? 'selected' : '' }}>Verde < 0 - Amarillo = 0 - Rojo > 0</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({theme: "classic"});
        });
    </script>
@stop
