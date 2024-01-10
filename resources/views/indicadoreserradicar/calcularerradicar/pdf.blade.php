<!DOCTYPE html>
<html>
<head>
    <title>REPORTE DE RESULTADOS</title>
    <!-- Estilos CSS aquí si es necesario -->
</head>
<body>
    <img src="{{ public_path('images/logo.jpg') }}" alt="Logo" width="150">
    <span style="margin-left: 10px; font-size: 16px; font-weight: bold;">
        SECRETARIA DE LAS MUJERES DEL ESTADO DE ZACATECAS
    </span>

    <h3>INFORMACIÓN DEL INDICADOR</h3>

    <p><strong>Nombre:</strong> {{ $indicadorerradicar->nombre }}</p>
    <p><strong>Objetivo:</strong> {{ $indicadorerradicar->objetivo }}</p>
    <p><strong>Definición:</strong> {{ $indicadorerradicar->definicion }}</p>
    <p><strong>Variables:</strong> {{ $indicadorerradicar->variables }}</p>
    <p><strong>Observaciones:</strong> {{ $indicadorerradicar->observaciones }}</p>
    <p><strong>Medios de Verificación:</strong> {{ $indicadorerradicar->medios_verificacion }}</p>
    <p><strong>Parámetro/Meta:</strong> {{ $indicadorerradicar->parametro_meta }}</p>
    <p><strong>Unidad de Medida:</strong> {{ $indicadorerradicar->unidad_medida }}</p>
    <p><strong>Nivel de Desagregación:</strong> {{ $indicadorerradicar->nivel_desagregacion }}</p>
    <p><strong>Acumulado/Periodico:</strong> {{ $indicadorerradicar->acumulado_periodico }}</p>
    <p><strong>Tendencia Esperada:</strong> {{ $indicadorerradicar->tendencia_esperada }}</p>
    <p><strong>Frecuencia de Medición:</strong> {{ $indicadorerradicar->frecuencia_medicion }}</p>
    <p><strong>Semaforo:</strong> {{ $indicadorerradicar->semaforo }}</p>

    <h3>RESULTADOS DEL INDICADOR</h3>

    @if($calculo->count() > 0)
        @foreach($calculo as $calculo)
        <div class="card-body" style="background-color: {{ $indicadorerradicar->semaforo === 'Verde > 0 - Amarillo = 0 - Rojo < 0' ? ($calculo->resultado > 0 ? 'green' : ($calculo->resultado == 0 ? 'yellow' : 'red')) : ($calculo->resultado < 0 ? 'green' : ($calculo->resultado == 0 ? 'yellow' : 'red')) }}">
                <p>Fórmula: {{ $calculo->formula }}</p>
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
