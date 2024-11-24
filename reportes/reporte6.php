<?php
include('../config/conexion.php');

// Ejecutar el procedimiento almacenado para obtener el resumen de ingresos y salidas
$query = "CALL sp_resumen_ingresos_salidas()";
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
    <title>Resumen de Ingresos y Salidas</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos-reportes.css">
</head>
<body>

<div class="container">
    <h1 class="text-center">Reporte 6: Resumen de Ingresos y Salidas de Productos</h2>
    <table>
        <thead>
            <tr>
                <th>Día</th>
                <th>Mes</th>
                <th>Año</th>
                <th>Total Ingresos</th>
                <th>Total Salidas</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Recorrer los resultados y mostrarlos en la tabla
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['dia']); ?></td>
                    <td><?php echo htmlspecialchars($row['mes']); ?></td>
                    <td><?php echo htmlspecialchars($row['año']); ?></td>
                    <td><?php echo number_format($row['total_ingresos'], 2); ?></td>
                    <td><?php echo number_format($row['total_salidas'], 2); ?></td>
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
    echo "<p>No se encontraron registros de ingresos y salidas.</p>";
}

$conn = null;
?>
