<?php
include('../config/conexion.php');

// Ejecutar el procedimiento almacenado para obtener los productos con bajo stock
$query = "CALL sp_productos_bajo_stock()";
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
    <title>Reporte de Productos con Bajo Stock</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos-reportes.css">
</head>
<body>

<div class="container">
    <h2>Reporte de Productos con Bajo Stock</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Recorrer los resultados y mostrarlos en la tabla
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['cod']); ?></td>
                    <td><?php echo htmlspecialchars($row['producto']); ?></td>
                    <td><?php echo htmlspecialchars($row['stock']); ?></td>
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
    echo "<p>No se encontraron productos con bajo stock.</p>";
}

$conn = null;
?>
