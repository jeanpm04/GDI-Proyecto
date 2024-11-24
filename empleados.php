<?php

function getPDOConnection() {
    $host = 'localhost';
    $dbname = 'universe_arcade_db';
    $username = 'root';
    $password = 'root';
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        return new PDO($dsn, $username, $password, $options);
    } catch (PDOException $e) {
        die('Error de conexión: ' . $e->getMessage());
    }
}

$pdo = getPDOConnection();
$error = null;

// Listar empleados
$empleados = [];
try {
    $stmt = $pdo->query('CALL ListarEmpleados()');
    $empleados = $stmt->fetchAll();
    $stmt->closeCursor();
} catch (PDOException $e) {
    $error = 'Error al listar empleados: ' . $e->getMessage();
}

// Obtener roles para el select
$roles = [];
try {
    $stmt = $pdo->query('CALL ListarRoles()');
    $roles = $stmt->fetchAll();
    $stmt->closeCursor();
} catch (PDOException $e) {
    $error = 'Error al obtener roles: ' . $e->getMessage();
}

// Agregar empleado
if (isset($_POST['agregar'])) {
    try {
        $stmt = $pdo->prepare('CALL AgregarEmpleado(:dni, :nom, :apePat, :apeMat, :idRol)');
        $stmt->execute([
            ':dni' => $_POST['dni'],
            ':nom' => $_POST['nombre'],
            ':apePat' => $_POST['apePat'],
            ':apeMat' => $_POST['apeMat'],
            ':idRol' => $_POST['idRol']
        ]);
        header('Location: empleado.php');
        exit;
    } catch (PDOException $e) {
        $error = 'Error al agregar empleado: ' . $e->getMessage();
    }
}

// Modificar empleado
if (isset($_POST['modificar'])) {
    try {
        $stmt = $pdo->prepare('CALL ModificarEmpleado(:dni, :nom, :apePat, :apeMat, :idRol)');
        $stmt->execute([
            ':dni' => $_POST['dni'],
            ':nom' => $_POST['nombre'],
            ':apePat' => $_POST['apePat'],
            ':apeMat' => $_POST['apeMat'],
            ':idRol' => $_POST['idRol']
        ]);
        header('Location: empleado.php');
        exit;
    } catch (PDOException $e) {
        $error = 'Error al modificar empleado: ' . $e->getMessage();
    }
}

// Eliminar empleado
if (isset($_POST['eliminar'])) {
    try {
        $stmt = $pdo->prepare('CALL EliminarEmpleado(:dni)');
        $stmt->execute([':dni' => $_POST['dni']]);
        header('Location: empleado.php');
        exit;
    } catch (PDOException $e) {
        $error = 'Error al eliminar empleado: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Universe Arcade</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Gestión de Empleados</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <h4 class="mt-4">Agregar/Modificar Empleado</h4>
        <form method="POST">
            <div class="mb-3">
                <label for="dni" class="form-label">DNI:</label>
                <input type="text" id="dni" name="dni" maxlength="8" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" maxlength="30" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="apePat" class="form-label">Apellido Paterno:</label>
                <input type="text" id="apePat" name="apePat" maxlength="30" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="apeMat" class="form-label">Apellido Materno:</label>
                <input type="text" id="apeMat" name="apeMat" maxlength="30" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="idRol" class="form-label">Rol:</label>
                <select id="idRol" name="idRol" class="form-control" required>
                    <option value="">Seleccione un rol</option>
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?= htmlspecialchars($rol['idRol']) ?>">
                            <?= htmlspecialchars($rol['des']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="agregar" class="btn btn-primary">Agregar</button>
            <button type="submit" name="modificar" class="btn btn-warning">Modificar</button>
        </form>

        <h4 class="mt-5">Lista de Empleados</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empleados as $empleado): ?>
                    <tr>
                        <td><?= htmlspecialchars($empleado['dni']) ?></td>
                        <td><?= htmlspecialchars($empleado['nom']) ?></td>
                        <td><?= htmlspecialchars($empleado['apePat']) ?></td>
                        <td><?= htmlspecialchars($empleado['apeMat']) ?></td>
                        <td><?= htmlspecialchars($empleado['rol']) ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="dni" value="<?= htmlspecialchars($empleado['dni']) ?>">
                                <button type="submit" name="eliminar" class="btn btn-danger">Eliminar</button>
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="dni" value="<?= htmlspecialchars($empleado['dni']) ?>">
                                <button type="submit" name="modificar" class="btn btn-warning">Modificar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>Universe Arcade &copy; 2024</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
