<?php
include 'conexion.php';

// Llamada al procedimiento almacenado para listar las transacciones
$stmt = $conn->prepare("CALL SP_ListarTransacciones()");
$stmt->execute();
$transacciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Transacciones - Universe Arcade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Listado de Transacciones</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Código de Registro</th>
                    <th>Tipo de Transacción</th>
                    <th>Día</th>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>DNI Empleado</th>
                    <th>Código Producto</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($transacciones)): ?>
                    <?php foreach ($transacciones as $transaccion): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($transaccion['codReg']); ?></td>
                            <td><?php echo htmlspecialchars($transaccion['tipTra']); ?></td>
                            <td><?php echo htmlspecialchars($transaccion['dia']); ?></td>
                            <td><?php echo htmlspecialchars($transaccion['mes']); ?></td>
                            <td><?php echo htmlspecialchars($transaccion['año']); ?></td>
                            <td><?php echo htmlspecialchars($transaccion['can']); ?></td>
                            <td><?php echo htmlspecialchars($transaccion['des']); ?></td>
                            <td><?php echo htmlspecialchars($transaccion['dni']); ?></td>
                            <td><?php echo htmlspecialchars($transaccion['cod']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">No hay transacciones registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
