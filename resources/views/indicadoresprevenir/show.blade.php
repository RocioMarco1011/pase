@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            DETALLES DEL INDICADOR DE PREVENCIÓN
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <button onclick="window.location='{{ route('indicadoresprevenir.index') }}'" class="inline-flex items-center px-4 py-2 mb-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        Regresar a Indicadores de Prevención
                    </button>                    
                    <table class="min-w-full">
                        <tbody>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">No.:</th>
                                <td class="py-2 px-4 text-lg">{{ $indicador->id }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Nombre:</th>
                                <td class="py-2 px-4 text-lg">{{ $indicador->nombre }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Objetivo:</th>
                                <td class="py-2 px-4 text-lg">{{ $indicador->objetivo }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Definición:</th>
                                <td class="py-2 px-4 text-lg">{{ $indicador->definicion }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Observaciones:</th>
                                <td class="py-2 px-4 text-lg">{{ $indicador->observaciones }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Medios de Verificación:</th>
                                <td class="py-2 px-4 text-lg">{{ $indicador->medios_verificacion }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Parámetro/Meta:</th>
                                <td class="py-2 px-4 text-lg">{{ $indicador->parametro_meta }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Unidad de Medida:</th>
                                <td class="py-2 px-4 text-lg">{{ $indicador->unidad_medida }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Nivel de Desagregación:</th>
                                <td class="py-2 px-4 text-lg">{{ $indicador->nivel_desagregacion }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Acumulado/Periódico:</th>
                                <td class="py-2 px-4 text-lg">{{ $indicador->acumulado_periodico }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Tendencia Esperada:</th>
                                <td class="py-2 px-4 text-lg">{{ $indicador->tendencia_esperada }}</td>
                            </tr>
                            <tr>
                                <th class="w-1/4 py-2 px-4 text-lg font-semibold">Frecuencia de Medición:</th>
                                <td class="py-2 px-4 text-lg">{{ $indicador->frecuencia_medicion }}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="mt-4 text-center">
                        <div class="flex justify-center space-x-8">
                            <a href="{{ route('indicadoresprevenir.edit', ['id' => $indicador->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Editar Indicador
                            </a>                            
                            <form method="POST" action="{{ route('indicadoresprevenir.destroy', ['id' => $indicador->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    Eliminar Indicador
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(session('alert'))
    <script>
        swal({
            title: "{{ session('alert.title') }}",
            text: "{{ session('alert.text') }}",
            icon: "{{ session('alert.icon') }}",
            button: "Aceptar",
        });
    </script>
@endif
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