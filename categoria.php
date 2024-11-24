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
        $codCat = $_POST['codCat'];
        $nom = $_POST['nom'];
        $des = $_POST['des'];

        $stmt = $pdo->prepare("CALL AgregarCategoria(:codCat, :nom, :des)");
        $stmt->bindParam(':codCat', $codCat);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':des', $des);
        $stmt->execute();
    } elseif ($accion === 'actualizar') {
        $codCat = $_POST['codCat'];
        $nom = $_POST['nom'];
        $des = $_POST['des'];

        $stmt = $pdo->prepare("CALL ModificarCategoria(:codCat, :nom, :des)");
        $stmt->bindParam(':codCat', $codCat);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':des', $des);
        $stmt->execute();
    } elseif ($accion === 'eliminar') {
        $codCat = $_POST['codCat'];

        $stmt = $pdo->prepare("CALL EliminarCategoria(:codCat)");
        $stmt->bindParam(':codCat', $codCat);
        $stmt->execute();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Gestión de Categorías</h1>

        <!-- Formulario para agregar o actualizar categoría -->
        <form method="POST" class="mb-5">
            <input type="hidden" name="accion" id="accion" value="agregar">
            <div class="mb-3">
                <label for="codCat" class="form-label">Código</label>
                <input type="text" class="form-control" id="codCat" name="codCat" maxlength="3" required>
            </div>
            <div class="mb-3">
                <label for="nom" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nom" name="nom" maxlength="30" required>
            </div>
            <div class="mb-3">
                <label for="des" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="des" name="des" maxlength="50" required>
            </div>
            <button type="submit" class="btn btn-primary" onclick="document.getElementById('accion').value='agregar'">Agregar</button>
            <button type="submit" class="btn btn-warning" onclick="document.getElementById('accion').value='actualizar'">Actualizar</button>
        </form>

        <!-- Tabla para listar categorías -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("CALL ListarCategorias()");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                        <td>{$row['codCat']}</td>
                        <td>{$row['nom']}</td>
                        <td>{$row['des']}</td>
                        <td>
                            <form method='POST' style='display: inline-block;'>
                                <input type='hidden' name='codCat' value='{$row['codCat']}'>
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
