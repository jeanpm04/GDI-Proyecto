<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';

    $codReg = $_POST['codReg'];

    // Ejecutar procedimiento almacenado
    $sql = "CALL sp_eliminar_registro_transaccion(?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$codReg]);

    echo "Transacción eliminada exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Transacción</title>
</head>
<body>
    <h1>Eliminar Transacción</h1>
    <form method="POST" action="eliminar.php">
        <label for="codReg">Código Registro a eliminar:</label>
        <input type="text" name="codReg" required><br>
        
        <input type="submit" value="Eliminar Transacción">
    </form>
</body>
</html>
