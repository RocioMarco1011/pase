@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            EVIDENCIAS DE LA ACCIÓN DE ATENCIÓN
        </h2>
        @if(isset($estrategia))
            <p class="font-semibold text-sm text-gray-800 leading-tight text-center">
                Estrategia: {{ $estrategia->nombre }}
            </p>
        @endif
        @if(isset($accionAtender))
            <p class="font-semibold text-sm text-gray-800 leading-tight text-center">
                Acción de Atención: {{ $accionAtender->accion }}
            </p>
        @endif
    </x-slot>
    

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">                  
                    <div class="mb-4">
                        <a href="{{ route('estrategiasatender.accionatender.index', ['estrategia' => $estrategia->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                            Regresar a las Acciones de Atención
                        </a>
                    </div>
                    
                    <div class="mb-4">
                        <a href="{{ route('evidenciaatender.create', ['estrategiaId' => $estrategia->id, 'accionAtenderId' => $accionAtender->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                            Añadir Evidencia
                        </a>
                    </div>
                    <table class="min-w-full border-collapse border-2 border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-lg border-b border-r">No.</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Nombre</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Mensaje</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Usuario</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Archivo</th>
                                <th class="py-2 px-4 text-lg border-b border-r"></th>
                                @can('EliminarEvidenciaAtender')
                                <th class="py-2 px-4 text-lg border-b border-r"></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($evidencias as $evidencia)
                                <tr>
                                    <td class="py-2 px-4 text-lg border-b border-r">{{ $evidencia->id }}</td>
                                    <td class="py-2 px-4 text-lg border-b border-r">{{ $evidencia->nombre }}</td>
                                    <td class="py-2 px-4 text-lg border-b border-r">{{ $evidencia->mensaje }}</td>
                                    <td class="py-2 px-4 text-lg border-b border-r">{{ $evidencia->user->name }}</td>
                                    <td class="py-2 px-4 text-lg border-b border-r">
                                        <a href="{{ route('file.download', ['filename' => $evidencia->archivo, 'nombreArchivo' => $evidencia->nombre]) }}" class="px-2 py-1 bg-indigo-500 text-white rounded-md hover:bg-indigo-600 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-700">
                                            Descargar Archivo
                                        </a>
                                                                              
                                    </td>
                                    
                                    <td class="py-2 px-4 text-lg border-b border-r">
                                        <a href="{{ route('evidenciaatender.edit', ['estrategiaId' => $estrategia->id, 'accionAtenderId' => $accionAtender->id, 'evidenciaId' => $evidencia->id]) }}" class="text-indigo-600 hover:text-indigo-900">
                                            Editar
                                        </a>
                                    </td>
                                    @can('EliminarEvidenciaAtender')
                                    <td class="py-2 px-4 text-lg border-b border-r">
                                        <form action="{{ route('evidenciaatender.destroy', ['estrategiaId' => $estrategia->id, 'accionAtenderId' => $accionAtender->id, 'evidenciaId' => $evidencia->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                    @endcan
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
