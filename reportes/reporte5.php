<?php
include('../config/conexion.php');

$query = "CALL sp_obtener_productos_por_vencer()";
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
    <title>Reporte de Productos por Vencer</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos-reportes.css">
</head>
<body>

<div class="container">
    <h1 class="text-center">Reporte 5: de Productos por Vencer</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Precio Venta</th>
                <th>Fecha de Vencimiento</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Recorrer los resultados y mostrarlos en la tabla
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['codigo']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td>S/<?php echo number_format($row['precio_venta'], 2); ?></td>
                    <td><?php echo htmlspecialchars($row['fecha_vencimiento']); ?></td>
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
    echo "<p>No se encontraron productos que estén por vencer dentro de los próximos 30 días.</p>";
}

$conn = null;
?>
