@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                DETALLES DE LA FÓRMULA
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        @if($calculo)
                            <p><strong>Fórmula:</strong> {{ $calculo->formula }}</p>

                            <!-- Botones para editar y eliminar fórmula -->
                            <div class="mt-4">
                                <a href="{{ route('indicadoreserradicar.calcularerradicar.edit', ['calculo' => $calculo->id]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">Editar Fórmula</a>
                            </div>
                        @else
                            <p>No se encontró la fórmula.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@stop
