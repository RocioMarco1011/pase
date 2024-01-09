@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            ESTRATEGIAS DE ERRADICACIÓN
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @can('AñadirEstrategiasErradicar')
                    <div class="mb-4">
                        <a href="{{ route('estrategiaserradicar.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                            Añadir Estrategia
                        </a>
                    </div>
                    @endcan
                    <table class="min-w-full border-collapse border-2 border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-lg border-b border-r">No.</th>
                                <th class="py-2 px-4 text-lg border-b border-r">Estrategias</th>
                                @can('VerEstrategiasErradicar')
                                <th class="py-2 px-4 text-lg border-b border-r"></th>
                                @endcan
                                <th class="py-2 px-4 text-lg border-b border-r"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($estrategias as $estrategia)
                            <tr>
                                <td class="py-2 px-4 text-lg border-b border-r">{{ $estrategia->id }}</td>
                                <td class="py-2 px-4 text-lg border-b border-r">{{ $estrategia->nombre }}</td>
                                @can('VerEstrategiasErradicar')
                                <td class="py-2 px-4 text-lg border-b border-r text-center">
                                    <a href="{{ route('estrategiaserradicar.show', ['estrategia' => $estrategia->id]) }}" class="inline-flex items-center justify-center w-full h-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Ver
                                    </a>                                                                  
                                </td>
                                @endcan
                                <td class="py-2 px-4 text-lg border-b border-r text-center">
                                    <a href="{{ route('estrategiaserradicar.accionerradicar.index', ['estrategia' => $estrategia->id]) }}" class="inline-flex items-center justify-center w-full h-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Acciones
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
@endsection
