<?php
include('../config/conexion.php');

try {
    // Ejecutar el procedimiento almacenado
    $query = "CALL sp_reporte_productos()";
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Obtener los resultados
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte 1 - Productos</title>
    <link href="../css/estilos-reportes.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Reporte 1: Productos, Categorías y Proveedores</h1>
        
        <!-- Verificar si hay resultados -->
        <?php if (count($resultados) > 0): ?>
            <!-- Tabla de resultados -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Proveedor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['cod']) ?></td>
                                <td><?= htmlspecialchars($row['producto']) ?></td>
                                <td><?= htmlspecialchars($row['categoria']) ?></td>
                                <td><?= htmlspecialchars($row['proveedor']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-data">No se encontraron productos.</p>
        <?php endif; ?>

        <!-- Botón para regresar -->
        <div class="button-container">
            <a href="../reportes.html" class="btn">Regresar al Inicio</a>
        </div>
    </div>
</body>
</html>
