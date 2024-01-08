@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
@stop

@section('content')
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                EDITAR ACCIÓN DE ATENCIÓN EN ESTRATEGIA
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form method="POST" action="{{ route('estrategiasatender.accionatender.update', ['estrategiaId' => $estrategia->id, 'accionAtenderId' => $accionAtender->id]) }}">
                            @csrf
                            @method('PUT') 
                            <input type="hidden" name="estrategia_id" value="{{ $estrategia->id }}">
                            
                            <div class="mb-4">
                                <label for="accion" class="block text-lg font-medium text-gray-700">Acción:</label>
                                <input type="text" name="accion" id="accion" class="mt-1 p-2 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" value="{{ $accionAtender->accion }}">
                            </div>
                            
                            <div class="mb-4">
                                <label for="tipo" class="block text-lg font-medium text-gray-700">Tipo de Acción:</label>
                                <select name="tipo" id="tipo" class="mt-1 p-2 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                                    <option value="General" {{ $accionAtender->tipo === 'General' ? 'selected' : '' }}>General</option>
                                    <option value="Especifica" {{ $accionAtender->tipo === 'Especifica' ? 'selected' : '' }}>Específica</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="dependencias_responsables" class="block text-lg font-medium text-gray-700">Dependencia Responsable:</label>
                                <select name="dependencias_responsables[]" id="dependencias_responsables" class="js-example-basic-multiple" multiple>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ in_array($user->id, $dependencias_responsables ?? []) ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label for="dependencias_coordinadoras" class="block text-lg font-medium text-gray-700">Dependencia Coordinadora:</label>
                                <select name="dependencias_coordinadoras[]" id="dependencias_coordinadoras" class="js-example-basic-multiple" multiple>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ in_array($user->id, $dependencias_coordinadoras ?? []) ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    Guardar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({theme: "classic"});
        });
    </script>
@stop
