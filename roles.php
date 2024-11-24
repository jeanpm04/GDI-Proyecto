<?php
$host = 'localhost';
$dbname = 'universe_arcade_db';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    if ($accion === 'agregar') {
        $idRol = $_POST['idRol'];
        $des = $_POST['des'];

        $stmt = $pdo->prepare("CALL AgregarRol(:idRol, :des)");
        $stmt->bindParam(':idRol', $idRol);
        $stmt->bindParam(':des', $des);
        $stmt->execute();
    } elseif ($accion === 'actualizar') {
        $idRol = $_POST['idRol'];
        $des = $_POST['des'];

        $stmt = $pdo->prepare("CALL ModificarRol(:idRol, :des)");
        $stmt->bindParam(':idRol', $idRol);
        $stmt->bindParam(':des', $des);
        $stmt->execute();
    } elseif ($accion === 'eliminar') {
        $idRol = $_POST['idRol'];

        $stmt = $pdo->prepare("CALL EliminarRol(:idRol)");
        $stmt->bindParam(':idRol', $idRol);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Roles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Barra de navegación con botón de inicio -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Universe Arcade</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Inicio</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Gestión de Roles</h1>

        <!-- Formulario para agregar o actualizar roles -->
        <form method="POST" class="mb-5">
            <input type="hidden" name="accion" id="accion" value="agregar">
            <div class="mb-3">
                <label for="idRol" class="form-label">ID Rol</label>
                <input type="text" class="form-control" id="idRol" name="idRol" maxlength="2" required>
            </div>
            <div class="mb-3">
                <label for="des" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="des" name="des" maxlength="20" required>
            </div>
            <button type="submit" class="btn btn-primary" onclick="document.getElementById('accion').value='agregar'">Agregar</button>
            <button type="submit" class="btn btn-warning" onclick="document.getElementById('accion').value='actualizar'">Actualizar</button>
        </form>

        <!-- Tabla para listar roles -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Rol</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("CALL ListarRoles()");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['idRol']}</td>
                        <td>{$row['des']}</td>
                        <td>
                            <form method='POST' style='display: inline-block;'>
                                <input type='hidden' name='idRol' value='{$row['idRol']}'>
                                <input type='hidden' name='accion' value='eliminar'>
                                <button type='submit' class='btn btn-danger btn-sm'>Eliminar</button>
                            </form>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
