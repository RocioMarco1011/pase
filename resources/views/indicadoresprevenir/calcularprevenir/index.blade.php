@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                CALCULADORA DE FÓRMULAS
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <!-- Sección de ingreso de fórmula -->
                        <form action="{{ route('indicadoresprevenir.calcularprevenir.guardarFormula', ['indicadorprevenir' => $indicadorprevenir->id]) }}" method="POST">
                            @csrf
                            <label for="formula" class="block text-sm font-medium text-gray-700">Fórmula:</label>
                            <input type="text" id="formula" name="formula" class="mt-1 p-2 border rounded-md w-full mb-2">
                            <button type="button" onclick="siguientePaso()" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                SIGUIENTE
                            </button>

                            <!-- Significado de las variables -->
                            <div id="significadoVariables" style="display:none;" class="mt-4">
                                <div id="significadoVariablesContenido"></div>
                                <button type="button" onclick="mostrarFormularioVariables()" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    SIGUIENTE
                                </button>
                            </div>

                            <!-- Sección de ingreso de valores de variables -->
                            <div id="variablesForm" style="display:none;" class="mt-4">
                                <!-- Aquí puedes mostrar dinámicamente los campos de entrada de las variables -->
                                <div id="valoresVariables"></div>

                                <button type="button" onclick="calcularResultado()" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    Calcular Resultado
                                </button>
                            </div>

                            <!-- Resultado -->
                            <div id="resultado" style="display:none;" class="mt-4">
                                <h2 class="text-lg font-semibold text-gray-800">Resultado:</h2>
                                <p id="resultadoValor" class="mt-2 text-gray-600"></p>
                                <div id="semaforo" class="mt-2"></div>
                                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    Guardar Calculo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <style>
            #semaforo {
                width: 20px;
                height: 20px;
                border-radius: 50%;
            }

            .semaforo-rojo {
                background-color: red;
            }

            .semaforo-amarillo {
                background-color: yellow;
            }

            .semaforo-verde {
                background-color: green;
            }
        </style>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/9.4.4/math.min.js"></script>
        <script>
           var mathLibrary = Math; // Cambié el nombre a mathLibrary
            var variables; // Variable global para almacenar las variables

            function siguientePaso() {
                var formula = document.getElementById('formula').value;
                variables = obtenerVariables(formula);

                if (variables.length > 0) {
                    // Mostrar el significado de las variables
                    mostrarSignificadoVariables(variables);
                } else {
                    alert('La fórmula no contiene variables.');
                }
            }

            function obtenerVariables(formula) {
                var matches = formula.match(/[a-zA-Z]+/g);
                return matches ? [...new Set(matches)] : [];
            }

            function mostrarSignificadoVariables(variables) {
                var contenidoSignificado = document.getElementById('significadoVariablesContenido');
                contenidoSignificado.innerHTML = '';

                variables.forEach(function (variable) {
                    var label = document.createElement('label');
                    label.innerHTML = 'Significado de ' + variable + ':';

                    var input = document.createElement('input');
                    input.type = 'text';
                    input.id = 'significado_' + variable.toLowerCase();
                    input.name = 'significado_' + variable.toLowerCase();
                    input.classList.add('mt-1', 'p-2', 'border', 'rounded-md', 'w-full', 'mb-2');

                    contenidoSignificado.appendChild(label);
                    contenidoSignificado.appendChild(input);
                });

                // Mostrar el significado de las variables
                document.getElementById('significadoVariables').style.display = 'block';
            }

            function mostrarFormularioVariables() {
                var valoresVariables = document.getElementById('valoresVariables');
                valoresVariables.innerHTML = '';

                variables.forEach(function (variable) {
                    var label = document.createElement('label');
                    label.innerHTML = 'Valor de ' + variable + ':';

                    var input = document.createElement('input');
                    input.type = 'text';
                    input.id = variable.toLowerCase();
                    input.name = variable.toLowerCase();
                    input.classList.add('mt-1', 'p-2', 'border', 'rounded-md', 'w-full', 'mb-2');

                    valoresVariables.appendChild(label);
                    valoresVariables.appendChild(input);
                });

                // Mostrar el formulario de ingreso de valores de variables
                document.getElementById('variablesForm').style.display = 'block';
            }

            function calcularResultado() {
    var valores = {};
    variables.forEach(function (variable) {
        var valorInput = document.getElementById(variable.toLowerCase()).value;
        valores[variable] = parseFloat(valorInput);
    });

    var formula = document.getElementById('formula').value;

    try {
        // Usar directamente math.evaluate para evaluar la fórmula
        var resultado = math.evaluate(formula, valores);

        // Convertir el resultado a un número si es un array
        if (Array.isArray(resultado)) {
            resultado = resultado.length > 0 ? resultado[0] : NaN;
        }

        // Mostrar el resultado
        document.getElementById('resultado').style.display = 'block';
        document.getElementById('resultadoValor').innerText = 'Resultado: ' + resultado;

        // Mostrar el semáforo
        var semaforo = document.getElementById('semaforo');
        semaforo.innerHTML = '<div class="bg-' + obtenerColorSemaforo(resultado) + ' w-4 h-4 rounded-full"></div>';
    } catch (error) {
        alert('Error al evaluar la fórmula: ' + error.message);
    }
}

            function obtenerColorSemaforo(resultado) {
                if (!isNaN(resultado) && Number.isFinite(resultado)) {
                    if (resultado < 0) {
                        return 'red-500';
                    } else if (resultado === 0) {
                        return 'yellow-500';
                    } else {
                        return 'green-500';
                    }
                } else {
                    alert('La fórmula no pudo ser evaluada correctamente. El resultado no es un número válido.\nResultado exacto: ' + resultado);
                    return 'gray-500'; // Color gris por error
                }
            }
        </script>

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
