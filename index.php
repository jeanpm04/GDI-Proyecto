<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universe Arcade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .content {
            flex: 1;
        }
        footer {
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Universe Arcade</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="insertar.php">Registrar Transacción</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="listar.php">Ver Transacciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="actualizar.php">Actualizar Transacción</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="eliminar.php">Eliminar Transacción</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenedor de opciones principales -->
    <div class="container mt-5 content">
        <div class="row text-center">
            <div class="col-md-3">
                <a href="insertar.php" class="btn btn-primary btn-lg w-100 mb-3">Registrar Nueva Transacción</a>
            </div>
            <div class="col-md-3">
                <a href="listar.php" class="btn btn-success btn-lg w-100 mb-3">Ver Transacciones</a>
            </div>
            <div class="col-md-3">
                <a href="actualizar.php" class="btn btn-warning btn-lg w-100 mb-3">Actualizar Transacción</a>
            </div>
            <div class="col-md-3">
                <a href="eliminar.php" class="btn btn-danger btn-lg w-100 mb-3">Eliminar Transacción</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>Universe Arcade &copy; 2024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
