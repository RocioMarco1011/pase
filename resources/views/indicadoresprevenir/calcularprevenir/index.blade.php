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
                        <div>
                            <label for="formula" class="block text-sm font-medium text-gray-700">Fórmula:</label>
                            <input type="text" id="formula" name="formula" class="mt-1 p-2 border rounded-md w-full mb-2">
                            <button onclick="siguientePaso()" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Siguiente
                            </button>
                        </div>

                        <!-- Sección de ingreso de valores de variables -->
                        <div id="variablesForm" style="display:none;" class="mt-4">
                            <!-- Aquí puedes mostrar dinámicamente los campos de entrada de las variables -->
                            <div id="valoresVariables"></div>

                            <button onclick="calcularResultado()" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Calcular Resultado
                            </button>
                        </div>

                        <!-- Resultado -->
                        <div id="resultado" style="display:none;" class="mt-4">
                            <h2 class="text-lg font-semibold text-gray-800">Resultado:</h2>
                            <p id="resultadoValor" class="mt-2 text-gray-600"></p>
                            <div id="semaforo" class="mt-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            #semaforo div {
                display: inline-block;
                margin-right: 5px;
                width: 20px;
                height: 20px;
                border-radius: 50%;
            }
        </style>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/9.4.4/math.min.js"></script>
        <script>
            function siguientePaso() {
                var formula = document.getElementById('formula').value;
                var variables = obtenerVariables(formula);

                if (variables.length > 0) {
                    // Mostrar el formulario de ingreso de valores de variables
                    mostrarFormularioVariables(variables);
                } else {
                    alert('La fórmula no contiene variables.');
                }
            }

            function obtenerVariables(formula) {
                var matches = formula.match(/[a-zA-Z]+/g);
                return matches ? [...new Set(matches)] : [];
            }

            function mostrarFormularioVariables(variables) {
                var valoresVariables = document.getElementById('valoresVariables');
                valoresVariables.innerHTML = '';

                variables.forEach(function (variable) {
                    var label = document.createElement('label');
                    label.innerHTML = 'Valor de ' + variable + ':';

                    var input = document.createElement('input');
                    input.type = 'text';
                    input.id = variable.toLowerCase(); // Usa minúsculas para los IDs
                    input.name = variable.toLowerCase(); // Usa minúsculas para los nombres
                    input.classList.add('mt-1', 'p-2', 'border', 'rounded-md', 'w-full', 'mb-2');

                    valoresVariables.appendChild(label);
                    valoresVariables.appendChild(input);
                });

                // Mostrar el formulario de ingreso de valores de variables
                document.getElementById('variablesForm').style.display = 'block';
            }

            function calcularResultado() {
                var formula = document.getElementById('formula').value;
                var variables = obtenerVariables(formula);

                var valores = {};
                variables.forEach(function (variable) {
                    var valorInput = document.getElementById(variable.toLowerCase()).value;
                    valores[variable] = parseFloat(valorInput);
                });

                try {
                    var resultado = math.evaluate(formula, valores);
                    
                    // Mostrar el resultado
                    document.getElementById('resultado').style.display = 'block';
                    document.getElementById('resultadoValor').innerText = resultado;

                    // Mostrar el semáforo
                    var semaforo = document.getElementById('semaforo');
                    semaforo.innerHTML = '';

                    if (resultado < 0) {
                        // Semáforo rojo
                        semaforo.innerHTML = '<div class="bg-red-500"></div>';
                    } else if (resultado === 0) {
                        // Semáforo amarillo
                        semaforo.innerHTML = '<div class="bg-yellow-500"></div>';
                    } else {
                        // Semáforo verde
                        semaforo.innerHTML = '<div class="bg-green-500"></div>';
                    }
                } catch (error) {
                    alert('Error al evaluar la fórmula: ' + error.message);
                }
            }
        </script>
    </x-app-layout>
@stop
