<?php
include('../config/conexion.php');

// Verificar si se ha enviado el DNI a través del formulario
if (isset($_POST['dni'])) {
    // Recibir el DNI del formulario
    $dni_empleado = $_POST['dni'];

    // Ejecutar el procedimiento almacenado con el DNI ingresado
    $query = "CALL sp_obtener_contactos_empleado(?)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $dni_empleado, PDO::PARAM_STR);
    $stmt->execute();

    // Verificar si se obtuvieron resultados
    if ($stmt->rowCount() > 0) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Contactos del Empleado</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos-reportes.css">
</head>
<body>

<div class="container">
    <h2>Reporte de Contactos del Empleado</h2>

    <!-- Tabla de resultados -->
    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Teléfono</th>
                <th>Correo Electrónico</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Recorrer los resultados y mostrarlos en la tabla
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['nom']); ?></td>
                    <td><?php echo htmlspecialchars($row['apePat']); ?></td>
                    <td><?php echo htmlspecialchars($row['tel']); ?></td>
                    <td><?php echo htmlspecialchars($row['ema']); ?></td>
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
        echo "<p>No se encontraron contactos para el empleado con DNI $dni_empleado.</p>";
    }
}
?>

<!-- Formulario para ingresar el DNI del empleado -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Contactos de Empleado</title>
    <link rel="stylesheet" type="text/css" href="../css/estilos-formulario.css">
</head>
<body>

<div class="form-container">
    <h1>Consultar Contactos del Empleado</h1>

    <!-- Formulario de ingreso de DNI -->
    <form action="reporte9.php" method="POST">
        <label for="dni">Ingrese el DNI del empleado:</label>
        <input type="text" id="dni" name="dni" required>
        <button type="submit">Consultar</button>
    </form>
</div>

</body>
</html>
