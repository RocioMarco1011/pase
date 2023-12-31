@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Resultados del Cálculo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="card">
                        <div class="card-body">
                            <p><strong>Fórmula:</strong> {{ $calculo->formula }}</p>
                            <p><strong>Resultado:</strong> {{ $calculo->resultado }}</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('indicadoresprevenir.calcularprevenir.calcular', ['indicadorprevenir' => $indicadorprevenir->id]) }}" class="btn btn-primary">
                            Nuevo Cálculo
                        </a>
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
@stop

@section('content')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
