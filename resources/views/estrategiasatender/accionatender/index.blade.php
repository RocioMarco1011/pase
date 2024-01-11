@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            ACCIONES DE ATENCIÓN
        </h2>
        @if(isset($estrategia))
        <p class="font-semibold text-sm text-gray-800 leading-tight text-center">
            Estrategia: {{ $estrategia->nombre }}
        </p>        
        @endif
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <button onclick="window.location='{{ route('estrategiasatender.index') }}'" class="inline-flex items-center px-4 py-2 mb-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        Regresar a estrategias de atención
                    </button>                    
                    @can('AñadirAccionesAtender')
                    <div class="mb-4">
                        <a href="{{ route('estrategiasatender.accionatender.create', ['estrategia' => $estrategia->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                            Añadir Acción
                        </a>               
                    </div>
                    @endcan
                    <table class="min-w-full border-collapse border-2 border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-lg border-b border-r">No.</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Acción</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Tipo</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Dependencias Responsables</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Dependencias Coordinadoras</th>
                                @can('VerAccionesAtender')
                                <th class="py-2 px-4 text-lg border-b border-r"></th>
                                @endcan
                                <th class="py-2 px-4 text-lg border-b border-r"></th>   
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accionesAtender as $accion)
                            <tr>
                                <td class="py-2 px-4 text-lg border-b border-r">{{ $accion->id }}</td>
                                <td class="py-2 px-4 text-lg border-b border-r">{{ $accion->accion }}</td>
                                <td class="py-2 px-4 text-lg border-b border-r">{{ ucfirst(strtolower($accion->tipo)) }}</td>
                                <td class="py-2 px-4 text-lg border-b border-r">{{ $accion->dependencias_responsables }}</td>
                                <td class="py-2 px-4 text-lg border-b border-r">{{ $accion->dependencias_coordinadoras }}</td>
                                @can('VerAccionesAtender')
                                <td class="py-2 px-4 text-lg border-b border-r text-center">
                                    <a href="{{ route('estrategiasatender.accionatender.show', ['estrategia' => $estrategia->id, 'accion' => $accion->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Ver
                                    </a>                                                                                             
                                </td>
                                @endcan
                                <td class="py-2 px-4 text-lg border-b border-r text-center">
                                    <a href="{{ route('evidenciaatender.index', ['estrategiaId' => $estrategia->id, 'accionAtenderId' => $accion->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Evidencias
                                    </a>                                    
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
