<?php
include('../config/conexion.php');

// Ejecutar el procedimiento almacenado
$query = "CALL sp_contar_productos_categoria()";
$result = $conn->query($query);

// Verificar si se obtuvieron resultados
if ($result && $result->rowCount() > 0) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Productos por Categoría</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos-reportes.css"> <!-- Ruta al archivo CSS -->
</head>
<body>
    <div class="container">
        <h1 class="text-center">Reporte 3: de Productos por Categoría</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Cantidad de Productos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Recorrer los resultados y mostrarlos
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['categoria']); ?></td>
                            <td><?php echo htmlspecialchars($row['cantidad_productos']); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <!-- Botón para regresar al menú principal -->
        <div class="button-container">
            <a href="../reportes.html" class="btn">Regresar al Inicio</a>
        </div>
    </div>
</body>
</html>
<?php
} else {
    // Si no se encontraron categorías
    echo "<div class='container'><p class='no-data'>No se encontraron categorías.</p></div>";
}

// Cerrar la conexión
$conn = null; // Cerramos la conexión explícitamente
?>
