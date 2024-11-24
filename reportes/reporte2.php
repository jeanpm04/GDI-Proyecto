<?php
include('../config/conexion.php');

try {
    // Ejecutar el procedimiento almacenado
    $query = "CALL sp_reporte_empleados()";
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
    <title>Reporte 2 - Empleados y Roles</title>
    <link href="../css/estilos-reportes.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Reporte 2: Empleados y Roles</h1>
        
        <!-- Verificar si hay resultados -->
        <?php if (count($resultados) > 0): ?>
            <!-- Tabla de resultados -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultados as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['dni']) ?></td>
                                <td><?= htmlspecialchars($row['nom']) ?></td>
                                <td><?= htmlspecialchars($row['apePat']) ?></td>
                                <td><?= htmlspecialchars($row['apeMat']) ?></td>
                                <td><?= htmlspecialchars($row['rol']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="no-data">No se encontraron empleados.</p>
        <?php endif; ?>

        <!-- Botón para regresar -->
        <div class="button-container">
            <a href="../reportes.html" class="btn">Regresar al Inicio</a>
        </div>
    </div>
</body>
</html>
