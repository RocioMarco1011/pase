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
                        <div class="flex mb-4">
                            <a href="{{ route('indicadoresprevenir.calcularprevenir.calcular', ['indicadorprevenir' => $indicadorprevenir->id]) }}"
                               class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                NUEVO CÁLCULO
                            </a>

                            @if($calculo->count() > 0)
                                <a href="{{ route('indicadoresprevenir.calcularprevenir.show', ['id' => $calculo[0]->id]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    Ver Fórmula
                                </a>
                            @endif
                        </div>

                        @if($calculo->count() > 0)
                            @foreach($calculo as $calculo)
                                <div class="card">
                                    <div class="card-body" style="background-color: {{ $calculo->resultado > 0 ? 'green' : ($calculo->resultado == 0 ? 'yellow' : 'red') }}">
                                        <p><strong>Fórmula:</strong> {{ $calculo->formula }}</p>
                                        <p><strong>Resultado:</strong> {{ $calculo->resultado }}</p>
                                        <p><strong>Fecha de Creación:</strong> {{ $calculo->created_at }}</p>
                                        <p><strong>Usuario:</strong> {{ $calculo->user->name }}</p>

                                        <!-- Delete Formula Form -->
                                        <form action="{{ route('indicadoresprevenir.calcularprevenir.destroy', ['calculo' => $calculo->id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('¿Estás seguro de que quieres eliminar esta fórmula?')">Eliminar Fórmula</button>
                                        </form>
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
