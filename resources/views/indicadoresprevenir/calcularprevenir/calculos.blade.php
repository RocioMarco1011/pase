@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                RESULTADOS DE CALCULO
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mt-4 mb-4"> <!-- Añadí mb-4 para el espacio debajo del botón -->
                            <a href="{{ route('indicadoresprevenir.calcularprevenir.calcular', ['indicadorprevenir' => $indicadorprevenir->id]) }}"
                               class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                NUEVO CÁLCULO
                            </a>
                        </div>

                        @if($calculo->count() > 0)
                            @foreach($calculo as $calculo)
                                <div class="card">
                                    <div class="card-body"
                                         style="background-color: {{ $calculo->resultado > 0 ? 'green' : ($calculo->resultado == 0 ? 'yellow' : 'red') }};">
                                        <p><strong>Fórmula:</strong> {{ $calculo->formula }}</p>
                                        <p><strong>Resultado:</strong> {{ $calculo->resultado }}</p>
                                        <p><strong>Fecha de Creación:</strong> {{ $calculo->created_at }}</p>
                                        <p><strong>Usuario:</strong> {{ Auth::user()->name }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No hay resultados de cálculos disponibles.</p>
                        @endif
                    </div>
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
