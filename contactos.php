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

// Listar contactos
$contactos = [];
try {
    $stmt = $pdo->query('CALL ListarContactos()');
    $contactos = $stmt->fetchAll();
    $stmt->closeCursor(); // Cierra el cursor
} catch (PDOException $e) {
    $error = 'Error al listar contactos: ' . $e->getMessage();
}

// Agregar contacto
if (isset($_POST['agregar'])) {
    try {
        $stmt = $pdo->prepare('CALL AgregarContacto(:dni, :tel, :ema)');
        $stmt->execute([
            ':dni' => $_POST['dni'],
            ':tel' => $_POST['tel'],
            ':ema' => $_POST['ema']
        ]);
        header('Location: contacto.php');
        exit;
    } catch (PDOException $e) {
        $error = 'Error al agregar contacto: ' . $e->getMessage();
    }
}

// Modificar contacto
if (isset($_POST['modificar'])) {
    try {
        if (empty($_POST['id'])) {
            throw new Exception('El campo ID es obligatorio para modificar un contacto.');
        }

        $stmt = $pdo->prepare('CALL ModificarContacto(:id, :tel, :ema)');
        $stmt->execute([
            ':id' => $_POST['id'],
            ':tel' => $_POST['tel'],
            ':ema' => $_POST['ema']
        ]);
        header('Location: contacto.php');
        exit;
    } catch (PDOException $e) {
        $error = 'Error al modificar contacto: ' . $e->getMessage();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Eliminar contacto
if (isset($_POST['eliminar'])) {
    try {
        $stmt = $pdo->prepare('CALL EliminarContacto(:id)');
        $stmt->execute([':id' => $_POST['id']]);
        header('Location: contacto.php');
        exit;
    } catch (PDOException $e) {
        $error = 'Error al eliminar contacto: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Contactos</title>
    <style>
        /* Estilos */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        h1, h2 {
            color: #333;
        }
        /* Barra de navegación */
        .navbar {
            background-color: #457b9d;
            padding: 10px;
            text-align: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin: 0 10px;
            font-weight: bold;
        }
        .navbar a:hover {
            background-color: #1d3557;
        }
        /* Contenido */
        .content {
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f9;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

    <!-- Barra de navegación -->
    <div class="navbar">
        <a href="empleados.php">Empleados</a>
        <a href="contacto.php">Contactos</a>
        <a href="index.php">Inicio</a>
    </div>

    <div class="content">
        <h1>Gestión de Contactos</h1>

        <?php if ($error): ?>
            <p class="error">Error: <?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <h2>Agregar/Modificar Contacto</h2>
        <form method="POST">
            <label for="id">ID (Obligatorio para modificar):</label>
            <input type="text" id="id" name="id" maxlength="10">
            <br>
            <label for="dni">DNI (Empleado):</label>
            <input type="text" id="dni" name="dni" maxlength="8" required>
            <br>
            <label for="tel">Teléfono:</label>
            <input type="text" id="tel" name="tel" maxlength="9" required>
            <br>
            <label for="ema">Correo Electrónico:</label>
            <input type="email" id="ema" name="ema" maxlength="40">
            <br>
            <button type="submit" name="agregar">Agregar</button>
            <button type="submit" name="modificar">Modificar</button>
        </form>

        <h2>Lista de Contactos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contactos as $contacto): ?>
                    <tr>
                        <td><?= htmlspecialchars($contacto['id']) ?></td>
                        <td><?= htmlspecialchars($contacto['dni']) ?></td>
                        <td><?= htmlspecialchars($contacto['nombre']) ?></td>
                        <td><?= htmlspecialchars($contacto['apellido_paterno']) ?></td>
                        <td><?= htmlspecialchars($contacto['tel']) ?></td>
                        <td><?= htmlspecialchars($contacto['ema']) ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($contacto['id']) ?>">
                                <button type="submit" name="eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
