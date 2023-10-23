@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            PROGRAMA PASE
        </h2>
    </x-slot>

    <style>
        /* Estilo para las secciones */
        .custom-section {
            padding: 20px; /* Espaciado interno */
            border: 1px solid #ccc; /* Borde para las secciones */
            text-align: center; /* Alineación del contenido */
        }

        /* Estilo para la tabla invisible */
        .invisible-table {
            width: 100%;
            border-collapse: collapse;
            display: table;
            table-layout: fixed; /* Fijar el ancho de la tabla */
        }

        /* Estilo para las celdas de la tabla invisible */
        .invisible-cell {
            width: 50%; /* Ancho de cada celda (dos celdas en una fila) */
            padding: 16px; /* Espaciado interno de las celdas */
        }
    </style>

    <div class="h-screen flex flex-col justify-center items-center mt-16">
        <!-- Tabla invisible para organizar las secciones -->
        <table class="invisible-table">
            <tr>
                <!-- Sección 1 -->
                <td class="invisible-cell">
                    <x-section title="">
                        <x-slot name="content">
                            <h2 class="text-3xl font-semibold">PREVENIR</h2>
                            <p>Reducir la prevalencia de la violencia contra las mujeres a través de la implementación de acciones específicas de prevención.</p>
                            <div class="mt-4 flex justify-center"> 
                                <a href="{{ route('estrategiasprevenir.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    Estrategias
                                </a>
                                <a href="{{ route('estrategiasprevenir.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                                    Indicadores
                                </a>
                            </div>
                        </x-slot>
                    </x-section>
                </td>
                
                <!-- Sección 2 -->
                <td class="invisible-cell">
                    <x-section title="">
                        <x-slot name="content">
                            <h2 class="text-3xl font-semibold">ATENDER</h2>
                            <p>Implementar modelos, lineamientos y acciones específicas para brindar atención especializada a mujeres víctimas de violencia.</p>
                            <div class="mt-4 flex justify-center"> 
                                <a href="{{ route('estrategiasprevenir.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    Estrategias
                                </a>
                                <a href="{{ route('estrategiasprevenir.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                                    Indicadores
                                </a>
                            </div>
                        </x-slot>
                    </x-section>
                </td>
            </tr>
            <tr>
                <!-- Sección 3 -->
                <td class="invisible-cell">
                    <x-section title="">
                        <x-slot name="content">
                            <h2 class="text-3xl font-semibold">SANCIONAR</h2>
                            <p>Procurar que la impartición de justicia asegure la sanción y reparación del daño, con verdadera perspectiva de género.</p>
                            <div class="mt-4 flex justify-center"> 
                                <a href="{{ route('estrategiasprevenir.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    Estrategias
                                </a>
                                <a href="{{ route('estrategiasprevenir.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                                    Indicadores
                                </a>
                            </div>
                        </x-slot>
                    </x-section>
                </td>

                <!-- Sección 4 -->
                <td class="invisible-cell">
                    <x-section title="">
                        <x-slot name="content">
                            <h2 class="text-3xl font-semibold">ERRADICAR</h2>
                            <p>Promover acciones interinstitucionales para una real erradicación de la violencia contra las mujeres.</p>
                            <div class="mt-4 flex justify-center"> 
                                <a href="{{ route('estrategiasprevenir.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    Estrategias
                                </a>
                                <a href="{{ route('estrategiasprevenir.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ml-4">
                                    Indicadores
                                </a>
                            </div>
                        </x-slot>
                    </x-section>
                </td>
            </tr>
        </table>
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
