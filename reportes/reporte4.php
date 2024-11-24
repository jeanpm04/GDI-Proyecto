<?php
include('../config/conexion.php');

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dni = $_POST['dni']; // Capturar el DNI ingresado

    // Validar que el DNI tenga 8 caracteres
    if (strlen($dni) !== 8 || !ctype_digit($dni)) {
        die("Por favor, ingrese un DNI válido de 8 dígitos.");
    }

    // Ejecutar el procedimiento almacenado
    $query = "CALL sp_obtener_transacciones_empleado(:dni)";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':dni', $dni, PDO::PARAM_STR); // Vincular el parámetro DNI
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si se obtuvieron resultados
    if (count($result) > 0) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Transacciones del Empleado</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos-reportes.css">
</head>
<body>

<div class="container">
    <h1 class="text-center">Reporte 4: de Transacciones del Empleado</h1>
    <h2>DNI: <?php echo htmlspecialchars($dni); ?></h2>

    <table>
        <thead>
            <tr>
                <th>Código Registro</th>
                <th>Tipo Transacción</th>
                <th>Cantidad</th>
                <th>Descripción</th>
                <th>Producto</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Recorrer los resultados y mostrarlos
            foreach ($result as $row) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['codigo_registro']); ?></td>
                    <td><?php echo htmlspecialchars($row['tipo_transaccion']); ?></td>
                    <td><?php echo htmlspecialchars($row['cantidad']); ?></td>
                    <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($row['producto']); ?></td>
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
        echo "<div class='container'><p class='no-data'>No se encontraron transacciones para el empleado con DNI: $dni.</p></div>";
    }

    // Cerrar el statement
    $stmt = null;
} else {
    // Mostrar el formulario para ingresar el DNI
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos-formulario.css">
</head>
<body>

<div class="form-container">
    <h1>Generar Reporte de Transacciones</h1>
    <form method="POST" action="">
        <label for="dni">Ingrese el DNI del empleado:</label>
        <input type="text" id="dni" name="dni" maxlength="8" required>
        <button type="submit">Generar Reporte</button>
    </form>
</div>

</body>
</html>
<?php
}
?>
