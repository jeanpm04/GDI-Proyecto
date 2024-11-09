<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';
    
    // Recibir datos del formulario
    $codReg = $_POST['codReg'];
    $can = $_POST['can'];
    $des = $_POST['des'];

    // Ejecutar procedimiento almacenado
    $sql = "CALL sp_actualizar_registro_transaccion(?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$codReg, $can, $des]);
    
    echo "Transacción actualizada exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Transacción</title>
</head>
<body>
    <h1>Actualizar Transacción</h1>
    <form method="POST" action="actualizar.php">
        <label for="codReg">Código Registro a actualizar:</label>
        <input type="text" name="codReg" required><br>
        
        <label for="can">Nueva cantidad:</label>
        <input type="number" name="can" required><br>
        
        <label for="des">Nueva descripción:</label>
        <input type="text" name="des" required><br>
        
        <input type="submit" value="Actualizar Transacción">
    </form>
</body>
</html>
