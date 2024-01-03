@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                EDITAR FÓRMULA
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h2 style="text-align: center; font-weight: bold; color: black; font-size: 20px;">
                            <strong>FAVOR DE PONER LA FÓRMULA EN MINÚSCULAS. EJEMPLO: '((ctn/ctb)-1)*100'</strong>
                        </h2>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                            &nbsp;
                        </h2>
                        <form action="{{ route('indicadoresprevenir.calcularprevenir.update', ['calculo' => $calculo->id]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="formula" class="block text-sm font-medium text-gray-700">Fórmula:</label>
                                <input type="text" id="formula" name="formula" value="{{ $calculo->formula }}" class="mt-1 p-2 border rounded-md w-full mb-2">
                            </div>
                            <!-- Agregar otros campos según sea necesario -->

                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Guardar Cambios
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@stop
