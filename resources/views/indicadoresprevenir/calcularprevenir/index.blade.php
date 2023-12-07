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
                            <button onclick="obtenerVariables()" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Siguiente
                            </button>
                        </div>

                        <!-- Sección de ingreso de variables -->
                        <div id="variablesForm" style="display:none;" class="mt-4">
                            <label for="variable1" class="block text-sm font-medium text-gray-700">Valor de CTN:</label>
                            <input type="text" id="variable1" name="variable1" class="mt-1 p-2 border rounded-md w-full mb-2">

                            <label for="variable2" class="block text-sm font-medium text-gray-700">Valor de CTB:</label>
                            <input type="text" id="variable2" name="variable2" class="mt-1 p-2 border rounded-md w-full mb-2">
                    
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
            }
        </style>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/9.4.4/math.min.js"></script>
        <script>
            function obtenerVariables() {
                var formula = document.getElementById('formula').value;
                // Aquí puedes realizar la lógica para obtener las variables de la fórmula, por ejemplo, usando una expresión regular.
                
                // Mostrar el formulario de ingreso de variables
                document.getElementById('variablesForm').style.display = 'block';
            }

            function calcularResultado() {
                var variable1 = parseFloat(document.getElementById('variable1').value);
                var variable2 = parseFloat(document.getElementById('variable2').value);

                var formula = document.getElementById('formula').value;
                // Evaluar la fórmula con las variables
                try {
                    var resultado = math.evaluate(formula, { CTN: variable1, CTB: variable2 });
                    
                    // Mostrar el resultado
                    document.getElementById('resultado').style.display = 'block';
                    document.getElementById('resultadoValor').innerText = resultado;

                    // Mostrar el semáforo
                    var semaforo = document.getElementById('semaforo');
                    semaforo.innerHTML = '';

                    if (resultado < 0) {
                        // Semáforo rojo
                        semaforo.innerHTML = '<div class="bg-red-500 w-6 h-6 rounded-full"></div>';
                    } else if (resultado === 0) {
                        // Semáforo amarillo
                        semaforo.innerHTML = '<div class="bg-yellow-500 w-6 h-6 rounded-full"></div>';
                    } else {
                        // Semáforo verde
                        semaforo.innerHTML = '<div class="bg-green-500 w-6 h-6 rounded-full"></div>';
                    }
                } catch (error) {
                    alert('Error al evaluar la fórmula: ' + error.message);
                }
            }
        </script>
    </x-app-layout>
@stop
