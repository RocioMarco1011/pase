@extends('adminlte::page')

@section('title', 'Detalles del Cálculo y Prevenir')

@section('content_header')
    <h1>Detalles del Cálculo y Prevenir</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h3>Fórmula:</h3>
            <p>{{ $calculo->formula }}</p>
            {{-- Otras secciones y detalles según tus necesidades --}}
        </div>
    </div>
@stop
