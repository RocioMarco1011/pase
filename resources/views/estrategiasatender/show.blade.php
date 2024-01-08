@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                DETALLES DE LA ESTRATEGIA DE ATENCIÓN
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <button type="button" onclick="window.location='{{ route('estrategiasatender.index') }}'" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                            Regresar a estrategias de atención
                        </button>

                        <table class="min-w-full">
                            <tbody>
                                <tr>
                                    <th class="w-1/4 py-2 px-4 text-lg font-semibold">No.:</th>
                                    <td class="py-2 px-4 text-lg">{{ $estrategia->id }}</td>
                                </tr>
                                <tr>
                                    <th class="w-1/4 py-2 px-4 text-lg font-semibold">Estrategia:</th>
                                    <td class="py-2 px-4 text-lg">{{ $estrategia->nombre }}</td>
                                </tr>
                                <!-- Agregar más campos según sea necesario -->
                            </tbody>
                        </table>

                        <!-- Botones de Editar y Eliminar horizontalmente con separación -->
                        <div class="mt-4 text-center">
                            <div class="flex justify-center space-x-8">
                                <a href="{{ route('estrategiasatender.edit', ['id' => $estrategia->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    Editar Estrategia
                                </a>
                                <form method="POST" action="{{ route('estrategiasatender.destroy', ['id' => $estrategia->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Eliminar Estrategia
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
@endsection
