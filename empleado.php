<?php

function getPDOConnection() {
    $host = 'localhost';
    $dbname = 'universe_arcade_db';
    $username = 'root';
    $password = '';
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
</head>
<body>
    <h1>Gestión de Empleados</h1>

    <?php if ($error): ?>
        <p style="color: red;">Error: <?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <h2>Agregar/Modificar Empleado</h2>
    <form method="POST">
        <label for="dni">DNI:</label>
        <input type="text" id="dni" name="dni" maxlength="8" required>
        <br>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" maxlength="30" required>
        <br>
        <label for="apePat">Apellido Paterno:</label>
        <input type="text" id="apePat" name="apePat" maxlength="30" required>
        <br>
        <label for="apeMat">Apellido Materno:</label>
        <input type="text" id="apeMat" name="apeMat" maxlength="30" required>
        <br>
        <label for="idRol">Rol:</label>
        <select id="idRol" name="idRol" required>
            <option value="">Seleccione un rol</option>
            <?php foreach ($roles as $rol): ?>
                <option value="<?= htmlspecialchars($rol['idRol']) ?>">
                    <?= htmlspecialchars($rol['des']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <button type="submit" name="agregar">Agregar</button>
        <button type="submit" name="modificar">Modificar</button>
    </form>

    <h2>Lista de Empleados</h2>
    <table border="1">
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
                            <button type="submit" name="eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
