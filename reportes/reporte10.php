<?php
include('../config/conexion.php');

// Verificar si se ha enviado el código del producto a través del formulario
if (isset($_POST['cod'])) {
    // Recibir el código del producto
    $cod_producto = $_POST['cod'];

    // Preparar la llamada al procedimiento almacenado
    $query = "CALL obtener_historial_transacciones(?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $cod_producto, PDO::PARAM_STR);
    $stmt->execute();

    // Verificar si se obtuvieron resultados
    if ($stmt->rowCount() > 0) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Transacciones del Producto</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos-reportes.css">
</head>
<body>

<div class="container">
    <h2>Historial de Transacciones del Producto</h2>

    <!-- Tabla de resultados -->
    <table>
        <thead>
            <tr>
                <th>Código Registro</th>
                <th>Tipo de Transacción</th>
                <th>Cantidad</th>
                <th>Descripción</th>
                <th>Día</th>
                <th>Mes</th>
                <th>Año</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Recorrer los resultados y mostrarlos en la tabla
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['codReg']); ?></td>
                    <td><?php echo htmlspecialchars($row['tipTra']); ?></td>
                    <td><?php echo htmlspecialchars($row['can']); ?></td>
                    <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($row['dia']); ?></td>
                    <td><?php echo htmlspecialchars($row['mes']); ?></td>
                    <td><?php echo htmlspecialchars($row['año']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Botón para regresar al inicio -->
    <div class="button-container">
        <a href="../reportes.html" class="btn">Regresar al Inicio</a>
    </div>
</div>

</body>
</html>
<?php
    } else {
        // Si no se encontraron resultados
        echo "<p>No se encontraron transacciones para el producto con código $cod_producto.</p>";
    }
}
?>

<!-- Formulario para ingresar el código del producto -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Historial de Transacciones</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos-formulario.css">
</head>
<body>

<div class="form-container">
    <h1>Consultar Historial de Transacciones del Producto</h1>

    <!-- Formulario de ingreso de código de producto -->
    <form action="reporte10.php" method="POST">
        <label for="cod">Ingrese el código del producto:</label>
        <input type="text" id="cod" name="cod" required>
        <button type="submit">Consultar</button>
    </form>
</div>

</body>
</html>
