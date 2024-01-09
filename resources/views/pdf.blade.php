<!DOCTYPE html>
<html>
<head>
    <title>Reporte PDF</title>
    <!-- Estilos CSS aquí si es necesario -->
</head>
<body>
    <h1>INFORMACIÓN DEL INDICADOR</h1>

    <p><strong>Nombre:</strong> {{ $indicadorprevenir->nombre }}</p>
    <p><strong>Objetivo:</strong> {{ $indicadorprevenir->objetivo }}</p>
    <p><strong>Definición:</strong> {{ $indicadorprevenir->definicion }}</p>
    <p><strong>Variables:</strong> {{ $indicadorprevenir->variables }}</p>
    <p><strong>Observaciones:</strong> {{ $indicadorprevenir->observaciones }}</p>
    <p><strong>Medios de Verificación:</strong> {{ $indicadorprevenir->medios_verificacion }}</p>
    <p><strong>Parámetro/Meta:</strong> {{ $indicadorprevenir->parametro_meta }}</p>
    <p><strong>Unidad de Medida:</strong> {{ $indicadorprevenir->unidad_medida }}</p>
    <p><strong>Nivel de Desagregación:</strong> {{ $indicadorprevenir->nivel_desagregacion }}</p>
    <p><strong>Acumulado/Periodico:</strong> {{ $indicadorprevenir->acumulado_periodico }}</p>
    <p><strong>Tendencia Esperada:</strong> {{ $indicadorprevenir->tendencia_esperada }}</p>
    <p><strong>Frecuencia de Medición:</strong> {{ $indicadorprevenir->frecuencia_medicion }}</p>
    <p><strong>Semaforo:</strong> {{ $indicadorprevenir->semaforo }}</p>

    <h1>RESULTADOS DE CALCULO</h1>

    @if($calculo->count() > 0)
        @foreach($calculo as $calculo)
        <div class="card-body" style="background-color: {{ $indicadorprevenir->semaforo === 'Verde > 0 - Amarillo = 0 - Rojo < 0' ? ($calculo->resultado > 0 ? 'green' : ($calculo->resultado == 0 ? 'yellow' : 'red')) : ($calculo->resultado < 0 ? 'green' : ($calculo->resultado == 0 ? 'yellow' : 'red')) }}">
                <h2>Fórmula: {{ $calculo->formula }}</h2>
                <p>Resultado: {{ $calculo->resultado }}</p>

                <p>Valor de las Variables:</p>
                @foreach($calculo->variables as $variable => $valor)
                    <p>{{ $variable }}: {{ $valor }}</p>
                @endforeach

                <p>Fecha de Creación: {{ $calculo->created_at->format('d-m-Y H:i:s') }}</p>
                <p>Usuario: {{ $calculo->user->name }}</p>
            </div>
        @endforeach
    @else
        <p>No hay resultados de cálculos disponibles.</p>
    @endif
</body>
</html>
