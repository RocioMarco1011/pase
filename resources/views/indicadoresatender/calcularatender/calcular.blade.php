@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                CALCULAR NUEVO RESULTADO
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Mostrar información del indicadoratender -->
                        <h2 style="font-size: 20px;"><strong>VARIABLES:</strong> {{ $indicadoratender->variables }}</h2>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                            &nbsp;
                        </h2>
                        <!-- Formulario para calcular nuevo resultado -->
                        <form action="{{ route('indicadoresatender.calcularatender.guardarNuevoCalculo', ['indicadoratender' => $indicadoratender->id]) }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}"> <!-- Agrega esta línea -->
                        
                            <div class="mb-4">
                                @foreach($variables as $variable)
                                    <div class="mb-2">
                                        <label for="{{ $variable }}">{{ ucfirst($variable) }}:</label>
                                        <input type="text" id="{{ $variable }}" name="{{ strtolower($variable) }}" required>
                                    </div>
                                @endforeach
                            </div>
                        
                            <button type="button" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150" id="calcularResultado" style="margin-bottom: 10px;">
                                Calcular Resultado
                            </button>
                        
                            <div id="resultado" style="display:none; margin-bottom: 10px;"></div>
                            
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150" id="guardarCalculo" style="display:none;">
                                Guardar Cálculo
                            </button>
                        </form>
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/11.1.0/math.js"></script>
        <script>
            // Función para evaluar la fórmula (puedes ajustar según tus necesidades)
            function evaluarFormula(formula, valores) {
                try {
                    // Compilar y evaluar la fórmula
                    var resultado = math.evaluate(formula, valores);

                    return resultado;
                } catch (error) {
                    // Manejar errores en la evaluación de la fórmula
                    throw new Error('Error al evaluar la fórmula: ' + error.message);
                }
            }

            // Captura el evento clic en el botón "Calcular Resultado"
            document.getElementById('calcularResultado').addEventListener('click', function() {
                // Obtén los valores del formulario
                var valores = {};
                @foreach($variables as $variable)
                    valores['{{ strtolower($variable) }}'] = parseFloat(document.getElementById('{{ $variable }}').value) || 0;
                @endforeach

                // Calcula el resultado y muestra el resultado
                var formula = "{{ $formula }}"; // Utiliza la fórmula específica del indicador
                var resultado = evaluarFormula(formula, valores);
                document.getElementById('resultado').innerHTML = "Resultado: " + resultado.toFixed(2);
                document.getElementById('resultado').style.display = 'block';

                // Muestra el botón "Guardar Cálculo"
                document.getElementById('guardarCalculo').style.display = 'block';
            });
        </script>
    </x-app-layout>
@stop

@section('content')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
