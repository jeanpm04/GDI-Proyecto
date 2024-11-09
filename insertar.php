<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php';
    
    // Recibir datos del formulario
    $codReg = $_POST['codReg'];
    $tipTra = $_POST['tipTra'];
    $dia = $_POST['dia'];
    $mes = $_POST['mes'];
    $año = $_POST['año'];
    $can = $_POST['can'];
    $des = $_POST['des'];
    $dni = $_POST['dni'];
    $cod = $_POST['cod'];

    // Ejecutar procedimiento almacenado
    $sql = "CALL sp_insertar_registro_transaccion(?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$codReg, $tipTra, $dia, $mes, $año, $can, $des, $dni, $cod]);
    
    echo "Transacción registrada exitosamente.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Insertar Transacción</title>
</head>
<body>
    <h1>Formulario para Insertar Transacción</h1>
    <form method="POST" action="insertar.php">
        <label for="codReg">Código Registro:</label>
        <input type="text" name="codReg" required><br>
        
        <label for="tipTra">Tipo de Transacción:</label>
        <input type="text" name="tipTra" required><br>
        
        <label for="dia">Día:</label>
        <input type="text" name="dia" required><br>
        
        <label for="mes">Mes:</label>
        <input type="text" name="mes" required><br>
        
        <label for="año">Año:</label>
        <input type="text" name="año" required><br>
        
        <label for="can">Cantidad:</label>
        <input type="number" name="can" required><br>
        
        <label for="des">Descripción:</label>
        <input type="text" name="des" required><br>
        
        <label for="dni">DNI del Empleado:</label>
        <input type="text" name="dni" required><br>
        
        <label for="cod">Código Producto:</label>
        <input type="text" name="cod" required><br>
        
        <input type="submit" value="Registrar Transacción">
    </form>
</body>
</html>
