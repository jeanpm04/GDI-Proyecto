-- Eliminamos la base de datos si existe
DROP DATABASE IF EXISTS universe_arcade_db;

-- Creamos la base de datos
CREATE DATABASE universe_arcade_db;

-- Seleccionamos la base de datos
USE universe_arcade_db;

-- Eliminamos las tablas si existen
DROP TABLE IF EXISTS T_RegPro;
DROP TABLE IF EXISTS M_Pro;
DROP TABLE IF EXISTS M_Emp;
DROP TABLE IF EXISTS M_Prov;
DROP TABLE IF EXISTS M_Cat;
DROP TABLE IF EXISTS M_Rol;

-- Creación de las tablas con InnoDB

-- Tabla M_Rol (Roles del personal)
CREATE TABLE M_Rol (
    idRol CHAR(2) PRIMARY KEY,
    des VARCHAR(20) NOT NULL
) ENGINE=InnoDB;

-- Tabla M_Cat (Categorías de productos)
CREATE TABLE M_Cat (
    codCat CHAR(3) PRIMARY KEY,
    nom VARCHAR(30) NOT NULL,
    des VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- Tabla M_Prov (Proveedores)
CREATE TABLE M_Prov (
    codPro CHAR(2) PRIMARY KEY,
    nom VARCHAR(30) NOT NULL,
    con VARCHAR(30) NOT NULL,
    tel CHAR(9) NOT NULL,
    dir VARCHAR(40) NOT NULL
) ENGINE=InnoDB;

-- Tabla M_Emp (Empleados)
CREATE TABLE M_Emp (
    dni CHAR(8) PRIMARY KEY,
    nom VARCHAR(30) NOT NULL,
    apePat VARCHAR(30) NOT NULL,
    apeMat VARCHAR(30) NOT NULL,
    id_Rol CHAR(2),
    FOREIGN KEY (id_Rol) REFERENCES M_Rol(idRol)
) ENGINE=InnoDB;

-- Tabla M_Con (Contacto del empleado)
CREATE TABLE M_Con (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dni CHAR(8),
    tel CHAR(9) NOT NULL,
    ema VARCHAR(40),
    FOREIGN KEY (dni) REFERENCES M_Emp(dni) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla M_Pro (Insumos/Productos)
CREATE TABLE M_Pro (
    cod CHAR(4) PRIMARY KEY,
    nom VARCHAR(30) NOT NULL,
    preCom DECIMAL(10,2) NOT NULL,
    preVen DECIMAL(10,2) NOT NULL,
    fecVen DATE NOT NULL,
    sto INT NOT NULL,
    cod_Pro CHAR(2),
    cod_Cat CHAR(3),
    FOREIGN KEY (cod_Pro) REFERENCES M_Prov(codPro),
    FOREIGN KEY (cod_Cat) REFERENCES M_Cat(codCat)
) ENGINE=InnoDB;

-- Tabla T_RegPro (Registros de transacciones)
CREATE TABLE T_RegPro (
    codReg CHAR(8) PRIMARY KEY,
    tipTra CHAR(1) NOT NULL,
    dia CHAR(2) NOT NULL,
    mes CHAR(2) NOT NULL,
    año CHAR(4) NOT NULL,
    can INT NOT NULL,
    des VARCHAR(50) NOT NULL,
    dni CHAR(8),
    cod CHAR(4),
    FOREIGN KEY (dni) REFERENCES M_Emp(dni),
    FOREIGN KEY (cod) REFERENCES M_Pro(cod)
) ENGINE=InnoDB;

-- Inserción en la tabla M_Rol
INSERT INTO M_Rol (idRol, des) VALUES 
('01', 'Gerente'),
('02', 'Cocinero'),
('03', 'Mesero');

-- Inserción en la tabla M_Emp
INSERT INTO M_Emp (dni, nom, apePat, apeMat, id_Rol) VALUES 
('12345678', 'Juan', 'Pérez', 'García', '01'),
('23456789', 'Ana', 'López', 'Martínez', '02'),
('34567890', 'Pedro', 'Gómez', 'Ruiz', '03'),
('45678901', 'Laura', 'Hernández', 'Santos', '01');

-- Inserción en la tabla M_Con (Contactos)
INSERT INTO M_Con (dni, tel, ema) VALUES 
('12345678', '987654321', 'juan.perez@gmail.com'),
('12345678', '912345678', 'juan.perez.sec@gmail.com'),
('23456789', '998877665', 'ana.lopez@gmail.com'),
('23456789', '976543210', 'ana.lopez.sec@gmail.com'),
('34567890', '945678123', 'pedro.gomez@gmail.com'),
('34567890', '912345678', 'pedro.gomez.sec@gmail.com'),
('45678901', '987654321', 'laura.hernandez@gmail.com'),
('45678901', '876543210', 'laura.hernandez.sec@gmail.com');

-- Inserción en la tabla M_Cat
INSERT INTO M_Cat (codCat, nom, des) VALUES 
('001', 'Entrantes', 'Entrantes y aperitivos'),
('002', 'Platos principales', 'Platos principales del menú'),
('003', 'Bebidas', 'Bebidas alcohólicas y no alcohólicas'),
('004', 'Postres', 'Deliciosos postres'),
('005', 'Snacks', 'Snacks');

-- Inserción en la tabla M_Prov
INSERT INTO M_Prov (codPro, nom, con, tel, dir) VALUES 
('01', 'Distribuidora Inca S.A.', 'contacto@dinca.com', '987654321', 'Av. Ejército 1234, Arequipa'),
('02', 'Proveedora Nacional SAC', 'ventas@provnacional.com', '876543210', 'Av. Alfonso Ugarte 456, Arequipa');

-- Inserción en la tabla M_Pro
INSERT INTO M_Pro (cod, nom, preCom, preVen, fecVen, sto, cod_Pro, cod_Cat) VALUES 
('0001', 'Tomate', 1.00, 1.50, '2025-12-31', 100, '01', '001'),
('0002', 'Lechuga', 0.50, 0.80, '2025-12-31', 50, '01', '001'),
('0003', 'Pollo', 5.00, 8.00, '2025-12-31', 30, '01', '002'),
('0004', 'Cerveza', 2.00, 3.00, '2025-12-31', 200, '02', '003'),
('0005', 'Tarta de chocolate', 3.00, 5.00, '2025-12-31', 20, '02', '004'),
('0006', 'Papitas', 0.80, 1.20, '2025-12-31', 150, '01', '005'),
('0007', 'Pasta', 1.50, 2.50, '2025-12-31', 40, '01', '002'),
('0008', 'Refresco', 0.90, 1.50, '2025-12-31', 100, '02', '003'),
('0009', 'Helado', 1.50, 2.00, '2025-12-31', 30, '02', '004'),
('0010', 'Popcorn', 3.00, 4.50, '2025-12-31', 80, '01', '005'),
('0011', 'Arroz', 2.00, 3.00, '2025-12-31', 120, '01', '002'),
('0012', 'Frijoles', 1.50, 2.50, '2025-12-31', 70, '01', '002'),
('0013', 'Jugo de naranja', 1.00, 1.80, '2025-12-31', 60, '02', '003'),
('0014', 'Salchichas', 2.50, 4.00, '2025-12-31', 40, '01', '002'),
('0015', 'Pan', 0.40, 0.70, '2025-12-31', 200, '01', '001'),
('0016', 'Yogur', 1.20, 2.00, '2025-12-31', 90, '02', '004'),
('0017', 'Salsa de tomate', 1.50, 2.50, '2025-12-31', 75, '01', '001'),
('0018', 'Galletas', 0.80, 1.50, '2025-12-31', 100, '02', '005'),
('0019', 'Té helado', 1.00, 1.80, '2025-12-31', 50, '02', '003'),
('0020', 'Sopa', 0.75, 1.20, '2025-12-31', 85, '01', '002');

-- Insertar un nuevo producto con fecha de vencimiento
INSERT INTO M_Pro (cod, nom, preCom, preVen, fecVen, sto, cod_Pro, cod_Cat) 
VALUES ('0021', 'Sopa Instantánea', 0.75, 1.20, '2024-12-20', 85, '01', '002');

-- Insertar un nuevo producto con fecha de vencimiento y 3 de stock
INSERT INTO M_Pro (cod, nom, preCom, preVen, fecVen, sto, cod_Pro, cod_Cat) 
VALUES ('0022', 'Fideos Ramen', 1.00, 1.50, '2024-12-25', 3, '02', '003');

INSERT INTO T_RegPro (codReg, tipTra, dia, mes, año, can, des, dni, cod) VALUES
('00000001', 'A', '01', '10', '2024', 10, 'Registro de 10 Salchipapas', '12345678', '0001'),
('00000002', 'A', '02', '10', '2024', 5, 'Registro de 5 Alitas de pollo', '12345678', '0002'),
('00000003', 'A', '03', '10', '2024', 8, 'Registro de 8 Ceviches', '12345678', '0003'),
('00000004', 'A', '04', '10', '2024', 20, 'Registro de 20 Hamburguesas', '12345678', '0005'),
('00000005', 'A', '05', '10', '2024', 15, 'Registro de 15 Papas a la francesa', '12345678', '0006'),
('00000006', 'M', '06', '10', '2024', 5, 'Modificación de precio de Ensalada César', '12345678', '0007'),
('00000007', 'E', '07', '10', '2024', 3, 'Eliminación de 3 Quesadillas', '12345678', '0008'),
('00000008', 'A', '08', '10', '2024', 12, 'Registro de 12 Tacos al pastor', '12345678', '0009'),
('00000009', 'M', '09', '10', '2024', 6, 'Modificación de stock de Sangría', '12345678', '0010'),
('00000010', 'A', '10', '10', '2024', 4, 'Registro de 4 Pisco Sour', '12345678', '0011'),
('00000011', 'A', '11', '10', '2024', 9, 'Registro de 9 Mojitos', '12345678', '0012'),
('00000012', 'E', '12', '10', '2024', 2, 'Eliminación de 2 Causas rellenas', '12345678', '0013'),
('00000013', 'A', '13', '10', '2024', 11, 'Registro de 11 Anticuchos', '12345678', '0014'),
('00000014', 'M', '14', '10', '2024', 7, 'Modificación de stock de Piqueo variado', '12345678', '0015'),
('00000015', 'A', '15', '10', '2024', 18, 'Registro de 18 Chichas moradas', '12345678', '0016'),
('00000016', 'E', '16', '10', '2024', 5, 'Eliminación de 5 Lomos saltados', '12345678', '0017'),
('00000017', 'A', '17', '10', '2024', 13, 'Registro de 13 Tiraditos', '12345678', '0018'),
('00000018', 'M', '18', '10', '2024', 10, 'Modificación de precio de Sopa criolla', '12345678', '0019'),
('00000019', 'A', '19', '10', '2024', 14, 'Registro de 14 Arroz chaufa', '12345678', '0020'),
('00000020', 'A', '20', '10', '2024', 10, 'Registro de 10 Salchipapas', '12345678', '0001'),
('00000021', 'A', '21', '10', '2024', 5, 'Registro de 5 Alitas de pollo', '12345678', '0002'),
('00000022', 'A', '22', '10', '2024', 8, 'Registro de 8 Ceviches', '12345678', '0003'),
('00000023', 'A', '23', '10', '2024', 20, 'Registro de 20 Hamburguesas', '12345678', '0005'),
('00000024', 'A', '24', '10', '2024', 15, 'Registro de 15 Papas a la francesa', '12345678', '0006'),
('00000025', 'M', '25', '10', '2024', 5, 'Modificación de precio de Ensalada César', '12345678', '0007'),
('00000026', 'E', '26', '10', '2024', 3, 'Eliminación de 3 Quesadillas', '12345678', '0008'),
('00000027', 'A', '27', '10', '2024', 12, 'Registro de 12 Tacos al pastor', '12345678', '0009'),
('00000028', 'M', '28', '10', '2024', 6, 'Modificación de stock de Sangría', '12345678', '0010'),
('00000029', 'A', '29', '10', '2024', 4, 'Registro de 4 Pisco Sour', '12345678', '0011'),
('00000030', 'A', '30', '10', '2024', 9, 'Registro de 9 Mojitos', '12345678', '0012'),
('00000031', 'E', '01', '11', '2024', 2, 'Eliminación de 2 Causas rellenas', '12345678', '0013'),
('00000032', 'A', '02', '11', '2024', 11, 'Registro de 11 Anticuchos', '12345678', '0014'),
('00000033', 'M', '03', '11', '2024', 7, 'Modificación de stock de Piqueo variado', '12345678', '0015'),
('00000034', 'A', '04', '11', '2024', 18, 'Registro de 18 Chichas moradas', '12345678', '0016'),
('00000035', 'E', '05', '11', '2024', 5, 'Eliminación de 5 Lomos saltados', '12345678', '0017'),
('00000036', 'A', '06', '11', '2024', 13, 'Registro de 13 Tiraditos', '12345678', '0018'),
('00000037', 'M', '07', '11', '2024', 10, 'Modificación de precio de Sopa criolla', '12345678', '0019'),
('00000038', 'A', '08', '11', '2024', 14, 'Registro de 14 Arroz chaufa', '12345678', '0020'),
('00000039', 'A', '09', '11', '2024', 10, 'Registro de 10 Salchipapas', '12345678', '0001'),
('00000040', 'A', '10', '11', '2024', 5, 'Registro de 5 Alitas de pollo', '12345678', '0002'),
('00000041', 'A', '11', '11', '2024', 8, 'Registro de 8 Ceviches', '12345678', '0003'),
('00000042', 'A', '12', '11', '2024', 20, 'Registro de 20 Hamburguesas', '12345678', '0005'),
('00000043', 'A', '13', '11', '2024', 15, 'Registro de 15 Papas a la francesa', '12345678', '0006'),
('00000044', 'M', '14', '11', '2024', 5, 'Modificación de precio de Ensalada César', '12345678', '0007'),
('00000045', 'E', '15', '11', '2024', 3, 'Eliminación de 3 Quesadillas', '12345678', '0008'),
('00000046', 'A', '16', '11', '2024', 12, 'Registro de 12 Tacos al pastor', '12345678', '0009'),
('00000047', 'M', '17', '11', '2024', 6, 'Modificación de stock de Sangría', '12345678', '0010'),
('00000048', 'A', '18', '11', '2024', 4, 'Registro de 4 Pisco Sour', '12345678', '0011'),
('00000049', 'A', '19', '11', '2024', 9, 'Registro de 9 Mojitos', '12345678', '0012'),
('00000050', 'E', '20', '11', '2024', 2, 'Eliminación de 2 Causas rellenas', '12345678', '0013');

-- 1. Obtener todos los productos junto con su categoría y proveedor
SELECT M_Pro.cod, M_Pro.nom AS producto, M_Cat.nom AS categoria, M_Prov.nom AS proveedor
FROM M_Pro
JOIN M_Cat ON M_Pro.cod_Cat = M_Cat.codCat
JOIN M_Prov ON M_Pro.cod_Pro = M_Prov.codPro;

-- 2. Listar todos los empleados junto con su rol
SELECT M_Emp.dni, M_Emp.nom, M_Emp.apePat, M_Emp.apeMat, M_Rol.des AS rol
FROM M_Emp
JOIN M_Rol ON M_Emp.id_Rol = M_Rol.idRol;

-- 3. Contar el número de productos por categoría
SELECT M_Cat.nom AS categoria, COUNT(M_Pro.cod) AS cantidad_productos
FROM M_Cat
LEFT JOIN M_Pro ON M_Cat.codCat = M_Pro.cod_Cat
GROUP BY M_Cat.nom;

-- 4. Obtener los registros de transacciones realizadas por un empleado específico
SELECT T_RegPro.codReg, T_RegPro.tipTra, T_RegPro.can, T_RegPro.des AS descripcion, M_Pro.nom AS producto
FROM T_RegPro
JOIN M_Emp ON T_RegPro.dni = M_Emp.dni
JOIN M_Pro ON T_RegPro.cod = M_Pro.cod
WHERE M_Emp.dni = '12345678';

-- 5. Obtener los productos que están por vencer
SELECT cod, nom, preVen, fecVen
FROM M_Pro
WHERE fecVen < CURDATE() + INTERVAL 30 DAY;

-- 6. Obtener un resumen de ingresos y salidas de productos por fecha
SELECT dia, mes, año,
       SUM(CASE WHEN tipTra = 'A' THEN can ELSE 0 END) AS total_ingresos,
       SUM(CASE WHEN tipTra = 'E' THEN can ELSE 0 END) AS total_salidas
FROM T_RegPro
GROUP BY año, mes, dia
ORDER BY año, mes, dia;

-- 7. Obtener la lista de productos con bajo stock (menos de 10 unidades)
SELECT cod, nom, sto
FROM M_Pro
WHERE sto < 10;

-- 8. Listar todos los proveedores y el número de productos que proveen
SELECT M_Prov.nom AS proveedor, COUNT(M_Pro.cod) AS cantidad_productos
FROM M_Prov
LEFT JOIN M_Pro ON M_Prov.codPro = M_Pro.cod_Pro
GROUP BY M_Prov.nom;

-- 9. Obtener los Contactos de un Empleado Específico
SELECT M_Emp.nom, M_Emp.apePat, M_Con.tel, M_Con.ema
FROM M_Emp
JOIN M_Con ON M_Emp.dni = M_Con.dni
WHERE M_Emp.dni = '12345678';

-- 10. Obtener el historial de transacciones de un producto específico
SELECT T_RegPro.codReg, T_RegPro.tipTra, T_RegPro.can, T_RegPro.des AS descripcion,
       T_RegPro.dia, T_RegPro.mes, T_RegPro.año
FROM T_RegPro
WHERE T_RegPro.cod = '0001';

-- Reporte 1
DELIMITER $$

CREATE PROCEDURE sp_reporte_productos()
BEGIN
    -- Obtener todos los productos junto con su categoría y proveedor
    SELECT M_Pro.cod, 
           M_Pro.nom AS producto, 
           M_Cat.nom AS categoria, 
           M_Prov.nom AS proveedor
    FROM M_Pro
    JOIN M_Cat ON M_Pro.cod_Cat = M_Cat.codCat
    JOIN M_Prov ON M_Pro.cod_Pro = M_Prov.codPro;
END $$

DELIMITER ;

-- Reporte 2
DELIMITER $$

CREATE PROCEDURE sp_reporte_empleados()
BEGIN
    -- Listar todos los empleados junto con su rol
    SELECT M_Emp.dni, 
           M_Emp.nom, 
           M_Emp.apePat, 
           M_Emp.apeMat, 
           M_Rol.des AS rol
    FROM M_Emp
    JOIN M_Rol ON M_Emp.id_Rol = M_Rol.idRol;
END $$

DELIMITER ;

-- Reporte 3
DELIMITER $$

CREATE PROCEDURE sp_contar_productos_categoria()
BEGIN
    -- Contar el número de productos por categoría
    SELECT M_Cat.nom AS categoria, 
           COUNT(M_Pro.cod) AS cantidad_productos
    FROM M_Cat
    LEFT JOIN M_Pro ON M_Cat.codCat = M_Pro.cod_Cat
    GROUP BY M_Cat.nom;
END $$

DELIMITER ;

-- Reporte 4
DELIMITER $$

CREATE PROCEDURE sp_obtener_transacciones_empleado(
    IN p_dni CHAR(8) -- Parámetro para filtrar por el DNI del empleado
)
BEGIN
    -- Consultar registros de transacciones realizadas por un empleado específico
    SELECT T_RegPro.codReg AS codigo_registro,
           T_RegPro.tipTra AS tipo_transaccion,
           T_RegPro.can AS cantidad,
           T_RegPro.des AS descripcion,
           M_Pro.nom AS producto
    FROM T_RegPro
    JOIN M_Emp ON T_RegPro.dni = M_Emp.dni
    JOIN M_Pro ON T_RegPro.cod = M_Pro.cod
    WHERE M_Emp.dni = p_dni;
END $$

DELIMITER ;

-- Reporte 5
DELIMITER $$

CREATE PROCEDURE sp_obtener_productos_por_vencer()
BEGIN
    -- Consultar productos cuya fecha de vencimiento está dentro de los próximos 30 días
    SELECT cod AS codigo,
           nom AS nombre,
           preVen AS precio_venta,
           fecVen AS fecha_vencimiento
    FROM M_Pro
    WHERE fecVen < CURDATE() + INTERVAL 30 DAY;
END $$

DELIMITER ;

-- Reporte 6
DELIMITER $$

CREATE PROCEDURE sp_resumen_ingresos_salidas()
BEGIN
    -- Resumen de ingresos y salidas de productos agrupados por fecha
    SELECT dia,
           mes,
           año,
           SUM(CASE WHEN tipTra = 'A' THEN can ELSE 0 END) AS total_ingresos,
           SUM(CASE WHEN tipTra = 'E' THEN can ELSE 0 END) AS total_salidas
    FROM T_RegPro
    GROUP BY año, mes, dia
    ORDER BY año, mes, dia;
END $$

DELIMITER ;

-- Reporte 7
DELIMITER $$

CREATE PROCEDURE sp_productos_bajo_stock()
BEGIN
    -- Lista de productos con stock menor a 10
    SELECT cod, 
           nom AS producto, 
           sto AS stock
    FROM M_Pro
    WHERE sto < 10;
END $$

DELIMITER ;

-- Reporte 8
DELIMITER //

CREATE PROCEDURE sp_lista_proveedores_y_productos()
BEGIN
    SELECT M_Prov.nom AS proveedor, COUNT(M_Pro.cod) AS cantidad_productos
    FROM M_Prov
    LEFT JOIN M_Pro ON M_Prov.codPro = M_Pro.cod_Pro
    GROUP BY M_Prov.nom;
END //

DELIMITER ;

-- Reporte 9
DELIMITER //

CREATE PROCEDURE sp_obtener_contactos_empleado(IN p_dni VARCHAR(20))
BEGIN
    SELECT M_Emp.nom, M_Emp.apePat, M_Con.tel, M_Con.ema
    FROM M_Emp
    JOIN M_Con ON M_Emp.dni = M_Con.dni
    WHERE M_Emp.dni = p_dni;
END //

DELIMITER ;

-- Reporte 10
DELIMITER $$

CREATE PROCEDURE obtener_historial_transacciones(IN cod_producto VARCHAR(20))
BEGIN
    SELECT T_RegPro.codReg, T_RegPro.tipTra, T_RegPro.can, T_RegPro.des AS descripcion,
           T_RegPro.dia, T_RegPro.mes, T_RegPro.año
    FROM T_RegPro
    WHERE T_RegPro.cod = cod_producto;
END $$

DELIMITER ;

-- Empleados
DELIMITER $$

-- Listar Empleados
CREATE PROCEDURE ListarEmpleados()
BEGIN
    SELECT e.dni, e.nom, e.apePat, e.apeMat, r.des AS rol
    FROM M_Emp e
    LEFT JOIN M_Rol r ON e.id_Rol = r.idRol;
END $$

-- Agregar Empleado
CREATE PROCEDURE AgregarEmpleado(
    IN p_dni CHAR(8),
    IN p_nom VARCHAR(30),
    IN p_apePat VARCHAR(30),
    IN p_apeMat VARCHAR(30),
    IN p_id_Rol CHAR(2)
)
BEGIN
    INSERT INTO M_Emp (dni, nom, apePat, apeMat, id_Rol)
    VALUES (p_dni, p_nom, p_apePat, p_apeMat, p_id_Rol);
END $$

-- Modificar Empleado
CREATE PROCEDURE ModificarEmpleado(
    IN p_dni CHAR(8),
    IN p_nom VARCHAR(30),
    IN p_apePat VARCHAR(30),
    IN p_apeMat VARCHAR(30),
    IN p_id_Rol CHAR(2)
)
BEGIN
    UPDATE M_Emp
    SET nom = p_nom, apePat = p_apePat, apeMat = p_apeMat, id_Rol = p_id_Rol
    WHERE dni = p_dni;
END $$

-- Eliminar Empleado
CREATE PROCEDURE EliminarEmpleado(
    IN p_dni CHAR(8)
)
BEGIN
    DELETE FROM M_Emp
    WHERE dni = p_dni;
END $$

DELIMITER ;

-- Roles
DELIMITER $$

-- Listar Roles
CREATE PROCEDURE ListarRoles()
BEGIN
    SELECT idRol, des FROM M_Rol;
END $$

-- Agregar Rol
CREATE PROCEDURE AgregarRol(
    IN p_idRol CHAR(2),
    IN p_des VARCHAR(20)
)
BEGIN
    INSERT INTO M_Rol (idRol, des)
    VALUES (p_idRol, p_des);
END $$

-- Modificar Rol
CREATE PROCEDURE ModificarRol(
    IN p_idRol CHAR(2),
    IN p_des VARCHAR(20)
)
BEGIN
    UPDATE M_Rol
    SET des = p_des
    WHERE idRol = p_idRol;
END $$

-- Eliminar Rol
CREATE PROCEDURE EliminarRol(
    IN p_idRol CHAR(2)
)
BEGIN
    DELETE FROM M_Rol
    WHERE idRol = p_idRol;
END $$

DELIMITER ;

-- Proveedores
DELIMITER $$

-- Agregar Proveedor
CREATE PROCEDURE AddProveedor(
    IN p_codPro CHAR(2),
    IN p_nom VARCHAR(30),
    IN p_con VARCHAR(30),
    IN p_tel CHAR(9),
    IN p_dir VARCHAR(40)
)
BEGIN
    INSERT INTO M_Prov (codPro, nom, con, tel, dir)
    VALUES (p_codPro, p_nom, p_con, p_tel, p_dir);
END $$

DELIMITER ;

-- Listar Proveedores
DELIMITER $$

CREATE PROCEDURE ListarProveedores()
BEGIN
    SELECT codPro, nom, con, tel, dir FROM M_Prov;
END $$

DELIMITER ;

-- Modificar Proveedor
DELIMITER $$

CREATE PROCEDURE ModificarProveedor(
    IN p_codPro CHAR(2),
    IN p_nom VARCHAR(30),
    IN p_con VARCHAR(30),
    IN p_tel CHAR(9),
    IN p_dir VARCHAR(40)
)
BEGIN
    UPDATE M_Prov
    SET nom = p_nom,
        con = p_con,
        tel = p_tel,
        dir = p_dir
    WHERE codPro = p_codPro;
END $$

DELIMITER ;

-- Eliminar Proveedor
DELIMITER $$

CREATE PROCEDURE EliminarProveedor(
    IN p_codPro CHAR(2)
)
BEGIN
    DELETE FROM M_Prov WHERE codPro = p_codPro;
END $$

DELIMITER ;

-- Categoría

-- Listar Categorías
DELIMITER $$

CREATE PROCEDURE ListarCategorias()
BEGIN
    SELECT codCat, nom, des
    FROM M_Cat;
END $$
DELIMITER ;

-- Agregar Categoría
DELIMITER $$

CREATE PROCEDURE AgregarCategoria(
    IN p_codCat CHAR(3),
    IN p_nom VARCHAR(30),
    IN p_des VARCHAR(50)
)
BEGIN
    INSERT INTO M_Cat (codCat, nom, des)
    VALUES (p_codCat, p_nom, p_des);
END $$
DELIMITER ;

-- Modificar Categoría
DELIMITER $$
CREATE PROCEDURE ModificarCategoria(
    IN p_codCat CHAR(3),
    IN p_nom VARCHAR(30),
    IN p_des VARCHAR(50)
)
BEGIN
    UPDATE M_Cat
    SET nom = p_nom, des = p_des
    WHERE codCat = p_codCat;
END $$
DELIMITER ;

-- Eliminar Categoría
DELIMITER $$
CREATE PROCEDURE EliminarCategoria(
    IN p_codCat CHAR(3)
)
BEGIN
    DELETE FROM M_Cat
    WHERE codCat = p_codCat;
END $$
DELIMITER ;

-- Contacto
DELIMITER $$

-- Agregar Contacto
CREATE PROCEDURE AgregarContacto (
    IN p_dni CHAR(8), 
    IN p_tel VARCHAR(15), 
    IN p_ema VARCHAR(50)
)
BEGIN
    INSERT INTO M_Con (dni, tel, ema)
    VALUES (p_dni, p_tel, p_ema);
END$$

DELIMITER $$

-- Eliminar Contacto
CREATE PROCEDURE EliminarContacto (
    IN p_id INT
)
BEGIN
    DELETE FROM M_Con
    WHERE id = p_id;
END$$

DELIMITER $$

-- Listar Contactos
CREATE PROCEDURE ListarContactos ()
BEGIN
    SELECT c.id, c.dni, c.tel, c.ema, e.nom AS nombre, e.apePat AS apellido_paterno
    FROM M_Con c
    INNER JOIN M_Emp e ON c.dni = e.dni;
END$$

DELIMITER $$

-- Modificar Contactos
CREATE PROCEDURE ModificarContacto (
    IN p_id INT,
    IN p_tel VARCHAR(15),
    IN p_ema VARCHAR(50)
)
BEGIN
    UPDATE M_Con
    SET tel = p_tel, ema = p_ema
    WHERE id = p_id;
END$$

DELIMITER ;

-- Registrar Transacción y Producto
DELIMITER $$

CREATE PROCEDURE sp_insertar_registro_transaccion1(
    IN p_codReg CHAR(8),
    IN p_tipTra CHAR(1),
    IN p_dia CHAR(2),
    IN p_mes CHAR(2),
    IN p_año CHAR(4),
    IN p_can INT,
    IN p_des VARCHAR(50),
    IN p_dni CHAR(8),
    IN p_cod CHAR(4),
    IN p_nom VARCHAR(30),
    IN p_preCom DECIMAL(5,2),
    IN p_preVen DECIMAL(5,2),
    IN p_fecVen DATE,
    IN p_sto INT,
    IN p_cod_Pro CHAR(2),
    IN p_cod_Cat CHAR(3)
)
BEGIN
    -- Verificar si el producto ya existe en M_Pro
    IF NOT EXISTS (SELECT 1 FROM M_Pro WHERE cod = p_cod) THEN
        -- Si el producto no existe, insertarlo en M_Pro
        INSERT INTO M_Pro (cod, nom, preCom, preVen, fecVen, sto, cod_Pro, cod_Cat)
        VALUES (p_cod, p_nom, p_preCom, p_preVen, p_fecVen, p_sto, p_cod_Pro, p_cod_Cat);
    END IF;

    -- Registrar la transacción en T_RegPro
    INSERT INTO T_RegPro (codReg, tipTra, dia, mes, año, can, des, dni, cod)
    VALUES (p_codReg, p_tipTra, p_dia, p_mes, p_año, p_can, p_des, p_dni, p_cod);
    
END $$

DELIMITER ;

DELIMITER //

CREATE PROCEDURE SP_ListarTransacciones()
BEGIN
    SELECT 
        codReg,
        tipTra,
        dia,
        mes,
        año,
        can,
        des,
        dni,
        cod
    FROM 
        T_RegPro;
END //

DELIMITER ;