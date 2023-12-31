@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            CREAR INDICADOR DE PREVENCIÓN
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('indicadoresprevenir.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="mt-1 p-2 w-full border rounded-md">
                        </div>

                        <div class="mb-4">
                            <label for="objetivo" class="block text-sm font-medium text-gray-700">Objetivo</label>
                            <textarea name="objetivo" id="objetivo" rows="4" class="mt-1 p-2 w-full border rounded-md"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="definicion" class="block text-sm font-medium text-gray-700">Definición</label>
                            <textarea name="definicion" id="definicion" rows="4" class="mt-1 p-2 w-full border rounded-md"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="variables" class="block text-sm font-medium text-gray-700">Variables</label>
                            <textarea name="variables" id="variables" rows="4" class="mt-1 p-2 w-full border rounded-md"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" rows="4" class="mt-1 p-2 w-full border rounded-md"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="medios_verificacion" class="block text-sm font-medium text-gray-700">Medios de Verificación</label>
                            <textarea name="medios_verificacion" id="medios_verificacion" rows="4" class="mt-1 p-2 w-full border rounded-md"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="parametro_meta" class="block text-sm font-medium text-gray-700">Parámetro/Meta</label>
                            <select name="parametro_meta" id="parametro_meta" class="mt-1 p-2 w-full border rounded-md">
                                <option value="Parametro">Parámetro</option>
                                <option value="Meta">Meta</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="unidad_medida" class="block text-sm font-medium text-gray-700">Unidad de Medida</label>
                            <select name="unidad_medida" id="unidad_medida" class="mt-1 p-2 w-full border rounded-md">
                                <option value="Porcentaje">Porcentaje</option>
                                <option value="Promedio">Promedio</option>
                                <option value="Proporcion">Proporción</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="nivel_desagregacion" class="block text-sm font-medium text-gray-700">Nivel de Desagregación</label>
                            <select name="nivel_desagregacion" id="nivel_desagregacion" class="mt-1 p-2 w-full border rounded-md">
                                <option value="Estatal">Estatal</option>
                                <option value="Otra">Otra</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="acumulado_periodico" class="block text-sm font-medium text-gray-700">Acumulado/Periódico</label>
                            <select name="acumulado_periodico" id="acumulado_periodico" class="mt-1 p-2 w-full border rounded-md">
                                <option value="Acumulado">Acumulado</option>
                                <option value="Periodico">Periódico</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="tendencia_esperada" class="block text-sm font-medium text-gray-700">Tendencia Esperada</label>
                            <select name="tendencia_esperada" id="tendencia_esperada" class="mt-1 p-2 w-full border rounded-md">
                                <option value="Ascendente">Ascendente</option>
                                <option value="Descendente">Descendente</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="frecuencia_medicion" class="block text-sm font-medium text-gray-700">Frecuencia de Medición</label>
                            <select name="frecuencia_medicion" id="frecuencia_medicion" class="mt-1 p-2 w-full border rounded-md">
                                <option value="Anual">Anual</option>
                                <option value="Mensual">Mensual</option>
                                <option value="Semestral">Semestral</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Guardar Indicador
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@stop

@section('content')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop