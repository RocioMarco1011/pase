@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                RESULTADOS
            </h2>
            @if(isset($indicadorerradicar))
                <p class="font-semibold text-sm text-gray-800 leading-tight text-center">
                    Indicador: {{ $indicadorerradicar->nombre }}
                </p>        
            @endif       
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex mb-4">
                            <a href="{{ route('indicadoreserradicar.calcularerradicar.calcular', ['indicadorerradicar' => $indicadorerradicar->id]) }}"
                               class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                NUEVO CÁLCULO
                            </a>
                            @can('VerFormulaErradicar')
                            @if($calculo->count() > 0)
                                <a href="{{ route('indicadoreserradicar.calcularerradicar.show', ['id' => $calculo[0]->id]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                    Ver Fórmula
                                </a>
                            @endif
                            @endcan
                            @if($calculo->count() > 0)
                                <a href="{{ route('descargar.pdf.erradicar', ['indicadorerradicar' => $indicadorerradicar->id]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150" style="margin-left: 10px;">
                                    Descargar PDF
                                </a>
                            @endif
                        </div>

                        @if($calculo->count() > 0)
                            @foreach($calculo->reverse() as $calculo)
                                <div class="card">
                                    <div class="card-body" style="background-color: {{ $indicadorerradicar->semaforo === 'Verde > 0 - Amarillo = 0 - Rojo < 0' ? ($calculo->resultado > 0 ? 'green' : ($calculo->resultado == 0 ? 'yellow' : 'red')) : ($calculo->resultado < 0 ? 'green' : ($calculo->resultado == 0 ? 'yellow' : 'red')) }}">
                                        <p><strong>Fórmula:</strong> {{ $calculo->formula }}</p>
                                        <p><strong>Resultado:</strong> {{ $calculo->resultado }}</p>

                                        @if(is_array($calculo->variables))
                                        <p><strong>Valor de las Variables:</strong></p>
                                        @foreach($calculo->variables as $variable => $valor)
                                        <p>{{ $variable }}: {{ $valor }}</p>
                                        @endforeach
                                        @endif

                                        <p><strong>Fecha de Creación:</strong> {{ $calculo->created_at->format('d-m-Y H:i:s') }}</p>
                                        <p><strong>Usuario:</strong> {{ $calculo->user->name }}</p>
                                        @can('EliminarCalculoErradicar')
                                        <!-- Delete Formula Form -->
                                        <form method="POST" action="{{ route('indicadoreserradicar.calcularerradicar.destroy', ['calculo' => $calculo->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                                Eliminar Cálculo
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No hay resultados de cálculos disponibles.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@stop
