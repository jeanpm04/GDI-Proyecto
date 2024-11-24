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

// Función para agregar un proveedor
if (isset($_POST['add'])) {
    $codPro = $_POST['codPro'];
    $nom = $_POST['nom'];
    $con = $_POST['con'];
    $tel = $_POST['tel'];
    $dir = $_POST['dir'];

    $stmt = $pdo->prepare("CALL AddProveedor(?, ?, ?, ?, ?)");
    $stmt->execute([$codPro, $nom, $con, $tel, $dir]);
    echo "<script>alert('Proveedor agregado exitosamente.');</script>";
}

// Función para modificar un proveedor
if (isset($_POST['update'])) {
    $codPro = $_POST['codPro'];
    $nom = $_POST['nom'];
    $con = $_POST['con'];
    $tel = $_POST['tel'];
    $dir = $_POST['dir'];

    $stmt = $pdo->prepare("CALL ModificarProveedor(?, ?, ?, ?, ?)");
    $stmt->execute([$codPro, $nom, $con, $tel, $dir]);
    echo "<script>alert('Proveedor modificado exitosamente.');</script>";
}

// Función para eliminar un proveedor
if (isset($_POST['delete'])) {
    $codPro = $_POST['codPro'];

    $stmt = $pdo->prepare("CALL EliminarProveedor(?)");
    $stmt->execute([$codPro]);
    echo "<script>alert('Proveedor eliminado exitosamente.');</script>";
}

// Obtener lista de proveedores
$stmt = $pdo->query("CALL ListarProveedores()");
$proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Proveedores - Universe Arcade</title>
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
        <h2>Gestionar Proveedores</h2>

        <!-- Formulario para agregar/modificar proveedor -->
        <form method="POST">
            <h4>Agregar/Modificar Proveedor</h4>
            <div class="mb-3">
                <label for="codPro" class="form-label">Código de Proveedor</label>
                <input type="text" class="form-control" id="codPro" name="codPro" required>
            </div>
            <div class="mb-3">
                <label for="nom" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="con" class="form-label">Contacto</label>
                <input type="text" class="form-control" id="con" name="con" required>
            </div>
            <div class="mb-3">
                <label for="tel" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="tel" name="tel" required>
            </div>
            <div class="mb-3">
                <label for="dir" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="dir" name="dir" required>
            </div>
            <button type="submit" name="add" class="btn btn-primary">Agregar Proveedor</button>
            <button type="submit" name="update" class="btn btn-warning">Modificar Proveedor</button>
        </form>

        <h4 class="mt-5">Lista de Proveedores</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proveedores as $proveedor): ?>
                    <tr>
                        <td><?php echo $proveedor['codPro']; ?></td>
                        <td><?php echo $proveedor['nom']; ?></td>
                        <td><?php echo $proveedor['con']; ?></td>
                        <td><?php echo $proveedor['tel']; ?></td>
                        <td><?php echo $proveedor['dir']; ?></td>
                        <td>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="codPro" value="<?php echo $proveedor['codPro']; ?>">
                                <button type="submit" name="delete" class="btn btn-danger">Eliminar</button>
                            </form>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="codPro" value="<?php echo $proveedor['codPro']; ?>">
                                <button type="submit" name="update" class="btn btn-warning">Modificar</button>
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
