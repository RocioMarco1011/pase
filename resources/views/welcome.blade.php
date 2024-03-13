<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('{{ asset('images/fondo1.jpg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        .jumbotron-transparent {
            background-color: rgba(255, 255, 255, 0.5);
            text-align: center;
            padding: 2rem;
            margin-top: 0;
        }

        .jumbotron-transparent h1 {
            color: #000;
        }

        .btn-guinda {
            color: #fff;
            background-color: #A52A2A; /* Color guinda (puedes ajustar este código de color según tus preferencias) */
            border-color: #A52A2A;
        }

        .info-box {
            background-color: #000;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-top: 350px;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="jumbotron jumbotron-transparent">
            <h1>Programa Estatal para Prevenir, Atender, Sancionar y
                Erradicar la Violencia contra las Mujeres del Estado de Zacatecas</h1>
            <a class="btn btn-guinda btn-lg" href="{{ url('/login') }}" role="button">Iniciar sesión</a>
        </div>

        <!-- Cuadro negro con información debajo de la imagen -->
        <div class="info-box">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>Dirección:</strong><br>Institutos, Acceso de And. Principal al Edificio A, 98160 Zacatecas, Zac.</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Teléfono:</strong><br>492 491 5085</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Horario:</strong><br>
                            Lunes: 8:30 a.m.–5 p.m.<br>
                            Martes: 8:30 a.m.–5 p.m.<br>
                            Miércoles: 8:30 a.m.–5 p.m.<br>
                            Jueves: 8:30 a.m.–5 p.m.<br>
                            Viernes: 8:30 a.m.–5 p.m.<br>
                            Sábado: Cerrado<br>
                            Domingo: Cerrado<br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
