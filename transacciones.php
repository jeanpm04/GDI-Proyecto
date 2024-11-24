<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conexion.php'; // Conexión a la base de datos

    // Recibir datos del formulario
    $codReg = $_POST['codReg'];
    $tipTra = $_POST['tipTra'];
    $dia = $_POST['dia'];
    $mes = $_POST['mes'];
    $año = $_POST['año'];
    $can = $_POST['can'];
    $des = $_POST['des'];
    $dni = $_POST['dni'];
    $cod = $_POST['cod']; // Código del producto

    // Datos del producto
    $nom = $_POST['nom'];
    $preCom = $_POST['preCom'];
    $preVen = $_POST['preVen'];
    $fecVen = $_POST['fecVen'];
    $sto = $_POST['sto'];
    $cod_Pro = $_POST['cod_Pro'];
    $cod_Cat = $_POST['cod_Cat'];

    try {
        // Llamada al procedimiento almacenado
        $sql = "CALL sp_insertar_registro_transaccion1(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $codReg, $tipTra, $dia, $mes, $año, $can, $des, $dni,
            $cod, $nom, $preCom, $preVen, $fecVen, $sto, $cod_Pro, $cod_Cat
        ]);

        echo "Transacción registrada exitosamente.";
    } catch (PDOException $e) {
        echo "Error al registrar: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Transacción y Producto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            width: 100%;
            max-width: 600px;
            margin: auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #457b9d;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #34597a;
        }
    </style>
</head>
<body>
    <h1>Formulario para Insertar Transacción y Producto</h1>
    <form method="POST" action="">
        <h2>Datos de la Transacción</h2>
        <label for="codReg">Código Registro:</label>
        <input type="text" name="codReg" required>
        
        <label for="tipTra">Tipo de Transacción:</label>
        <input type="text" name="tipTra" required>
        
        <label for="dia">Día:</label>
        <input type="number" name="dia" required>
        
        <label for="mes">Mes:</label>
        <input type="number" name="mes" required>
        
        <label for="año">Año:</label>
        <input type="number" name="año" required>
        
        <label for="can">Cantidad:</label>
        <input type="number" name="can" required>
        
        <label for="des">Descripción:</label>
        <input type="text" name="des" required>
        
        <label for="dni">DNI del Empleado:</label>
        <input type="text" name="dni" required>
        
        <label for="cod">Código Producto:</label>
        <input type="text" name="cod" required>

        <h2>Datos del Producto</h2>
        <label for="nom">Nombre del Producto:</label>
        <input type="text" name="nom">

        <label for="preCom">Precio Compra:</label>
        <input type="number" step="0.01" name="preCom">

        <label for="preVen">Precio Venta:</label>
        <input type="number" step="0.01" name="preVen">

        <label for="fecVen">Fecha Vencimiento:</label>
        <input type="date" name="fecVen">

        <label for="sto">Stock:</label>
        <input type="number" name="sto">

        <label for="cod_Pro">Código Proveedor:</label>
        <input type="text" name="cod_Pro">

        <label for="cod_Cat">Código Categoría:</label>
        <input type="text" name="cod_Cat">

        <input type="submit" value="Registrar Transacción y Producto">
    </form>
</body>
</html>
