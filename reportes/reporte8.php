<?php
include('../config/conexion.php');

// Ejecutar el procedimiento almacenado
$query = "CALL sp_lista_proveedores_y_productos()";
$stmt = $conn->prepare($query);
$stmt->execute();

// Verificar si se obtuvieron resultados
if ($stmt->rowCount() > 0) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Proveedores y Productos</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos-reportes.css">
</head>
<body>

<div class="container">
    <h2>Reporte de Proveedores y la Cantidad de Productos</h2>
    <table>
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Cantidad de Productos</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Recorrer los resultados y mostrarlos en la tabla
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['proveedor']); ?></td>
                    <td><?php echo htmlspecialchars($row['cantidad_productos']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    
    <div class="button-container">
        <a href="../reportes.html" class="btn">Regresar al Inicio</a>
    </div>

</div>

</body>
</html>
<?php
} else {
    echo "<p>No se encontraron proveedores o productos asociados.</p>";
}

$conn = null;
?>
