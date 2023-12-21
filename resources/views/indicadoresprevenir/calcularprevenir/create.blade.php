@extends('adminlte::page')

@section('title', 'Crear Fórmula')

@section('content_header')
    <h1>Crear Fórmula</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('indicadoresprevenir.calcularprevenir.store', ['indicadorprevenir' => $indicadorprevenir->id]) }}" method="post">
                @csrf

                <div class="mb-3">
                    <label for="formula" class="form-label">Fórmula:</label>
                    <input type="text" class="form-control" id="formula" name="formula" required>
                </div>

                <!-- Otros campos del formulario según tus necesidades -->

                <button type="submit" class="btn btn-primary">Guardar Fórmula</button>
            </form>
        </div>
    </div>
@stop

@section('js')
    <!-- Aquí puedes incluir scripts adicionales si los necesitas -->
@stop
