-- semana11
-- eliminar base de datos existente
DROP DATABASE IF EXISTS universe_arcade_db;

-- creamos la base de datos
CREATE DATABASE universe_arcade_db;

-- seleccionar la base de datos
USE universe_arcade_db;

-- eliminar tablas si existen
DROP TABLE IF EXISTS T_RegPro;
DROP TABLE IF EXISTS M_Pro;
DROP TABLE IF EXISTS M_Emp;
DROP TABLE IF EXISTS M_Prov;
DROP TABLE IF EXISTS M_Cat;
DROP TABLE IF EXISTS M_Rol;


-- tablas maestras
-- m_rol
CREATE TABLE M_Rol (
    idRol CHAR(2) PRIMARY KEY,
    des VARCHAR(20) NOT NULL
) ENGINE=InnoDB;

-- m_cat
CREATE TABLE M_Cat (
    codCat CHAR(3) PRIMARY KEY,
    nom VARCHAR(30) NOT NULL,
    des VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- m_prov
CREATE TABLE M_Prov (
	codPro CHAR (2) PRIMARY KEY,
  nom VARCHAR (30) NOT NULL,
  con VARCHAR (30) NOT NULL,
  tel CHAR (9) NOT NULL,
  dir VARCHAR (40) NOT NULL
) ENGINE=InnoDB;

-- m_emp
CREATE TABLE M_Emp (
    dni CHAR(8) PRIMARY KEY,    
    nom VARCHAR(30) NOT NULL,   
    apePat VARCHAR(30) NOT NULL,
    apeMat VARCHAR(30) NOT NULL,
    id_Rol CHAR(2) NOT NULL, 
    FOREIGN KEY (id_Rol) REFERENCES M_Rol(idRol) ON DELETE CASCADE
) ENGINE=InnoDB;

-- m_con

CREATE TABLE M_Con (
    id INT PRIMARY KEY AUTO_INCREMENT,  -- Clave primaria autoincremental
    dni CHAR(8),
    tel CHAR(9) NOT NULL,
    ema VARCHAR(40),
    FOREIGN KEY (dni) REFERENCES M_Emp(dni) ON DELETE CASCADE
)ENGINE=InnoDB;


-- m_pro
CREATE TABLE M_Pro (
    cod CHAR(4) PRIMARY KEY,        
    nom VARCHAR(30) NOT NULL,       
    preCom DECIMAL(5, 2) NOT NULL,  
    preVen DECIMAL(5, 2) NOT NULL,  
    fecVen DATE NOT NULL,           
    sto INT NOT NULL,               
    cod_Pro CHAR(2) NOT NULL,       
    cod_Cat CHAR(3) NOT NULL,       
    FOREIGN KEY (cod_Pro) REFERENCES M_Prov(codPro) ON DELETE CASCADE,
    FOREIGN KEY (cod_Cat) REFERENCES M_Cat(codCat) ON DELETE CASCADE
) ENGINE=InnoDB;




CREATE TABLE T_RegPro (
    codReg CHAR(8) PRIMARY KEY,     
    tipTra CHAR(1) NOT NULL,        
    dia CHAR(2) NOT NULL,           
    mes CHAR(2) NOT NULL,           
    año CHAR(4) NOT NULL,           
    can INT NOT NULL,               
    des VARCHAR(50) NOT NULL,       
    dni CHAR(8) NOT NULL,           
    cod CHAR(4) NOT NULL,           
    FOREIGN KEY (dni) REFERENCES M_Emp(dni) ON DELETE CASCADE,
    FOREIGN KEY (cod) REFERENCES M_Pro(cod) ON DELETE CASCADE
) ENGINE=InnoDB;


-- Tabla M_Rol (Roles del personal)
INSERT INTO M_Rol (idRol, des) VALUES 
('01', 'Ayudante'),
('02', 'Cocinero'),
('03', 'Administrador');

-- Tabla M_Emp (Empleados)
INSERT INTO M_Emp (dni, nom, apePat, apeMat, id_Rol) VALUES 
('72243153', 'Juan', 'Pérez', 'García', '01'),
('75321456', 'María', 'López', 'Díaz', '01'),
('71456234', 'Carlos', 'Ramos', 'Fernández', '03'),
('71532467', 'Ana', 'Gómez', 'Torres', '02');

-- Tabla M_Cat (Categorías de productos)
INSERT INTO M_Cat (codCat, nom, des) VALUES 
('001', 'Bebidas', 'Bebidas sin alcohol'),
('002', 'Alimentos', 'Entradas y platos principales'),
('003', 'Postres', 'Postres y dulces'),
('004', 'Licores', 'Bebidas alcohólicas'),
('005', 'Snacks', 'Bocadillos rápidos');


-- Tabla M_Prov (Proveedores)
INSERT INTO M_Prov (codPro, nom, con, tel, dir) VALUES 
('01', 'Proveedor Inca', 'pedro.suarez@inca.com', '907254321', 'Av. Marina 123'),
('02', 'Distribuidora Andes', 'laura.martinez@andes.com', '912345678', 'Calle Central 456');

-- Tabla M_Pro (Insumos/Productos)
INSERT INTO M_Pro (cod, nom, preCom, preVen, fecVen, sto, cod_Pro, cod_Cat) VALUES 
('0001', 'Gaseosa Inca 1/2L', 1.50, 2.00, '2024-12-31', 50, '01', '001'),
('0002', 'Gaseosa Inca 1L', 2.50, 3.50, '2024-12-31', 60, '01', '001'),
('0003', 'Gaseosa Inca 2.5L', 4.00, 5.00, '2024-12-31', 40, '01', '001'),
('0004', 'Gaseosa Inca 3L', 5.50, 7.00, '2024-12-31', 30, '01', '001'),
('0005', 'Gaseosa CocaCola 1/2L', 2.00, 3.00, '2024-12-31', 50, '02', '001'),
('0006', 'Gaseosa CocaCola 1L', 3.50, 4.50, '2024-12-31', 40, '02', '001'),
('0007', 'Gaseosa CocaCola 2.5L', 5.00, 6.50, '2024-12-31', 25, '02', '001'),
('0008', 'Gaseosa CocaCola 3L', 6.50, 8.00, '2024-12-31', 20, '02', '001'),
('0009', 'Gaseosa Escocesa 1/2L', 1.20, 1.80, '2024-12-31', 45, '01', '001'),
('0010', 'Agua Cielo 1/2L', 1.00, 1.50, '2024-11-30', 70, '02', '001'),
('0011', 'Agua Cielo 1L', 1.80, 2.50, '2024-11-30', 40, '02', '001'),
('0012', 'Agua Loa 1/2L', 1.20, 1.70, '2024-11-30', 50, '02', '001'),
('0013', 'Agua San Luis 1/2L', 1.00, 1.50, '2024-11-30', 35, '01', '001'),
('0014', 'Agua San Luis 1L', 1.80, 2.30, '2024-11-30', 20, '01', '001'),
('0015', 'Cerveza Pilsen', 5.00, 7.00, '2024-10-15', 50, '02', '004'),
('0016', 'Cerveza Cusqueña', 6.00, 8.00, '2024-10-15', 30, '02', '004'),
('0017', 'Papitas Lays', 2.00, 3.00, '2024-09-15', 80, '01', '005'),
('0018', 'Chisito', 1.00, 1.50, '2024-09-15', 100, '02', '005'),
('0019', 'Té Helado', 3.00, 4.00, '2025-01-01', 40, '01', '001'),
('0020', 'Hamburguesa Clásica', 8.00, 10.00, '2024-12-31', 25, '02', '002'),
('0021', 'Hamburguesa Royal', 10.00, 12.00, '2024-12-31', 20, '02', '002'),
('0022', 'Torta de Chocolate', 4.00, 6.00, '2024-10-30', 25, '01', '003'),
('0023', 'Torta de Zanahoria', 4.00, 6.00, '2024-10-30', 20, '01', '003'),
('0024', 'Russ Kaya', 7.00, 9.00, '2024-11-30', 15, '02', '004'),
('0025', 'Vino Tinto', 12.00, 18.00, '2025-01-01', 30, '01', '004'),
('0026', 'Sopa de Pollo', 8.00, 10.00, '2024-11-30', 40, '01', '002'),
('0027', 'Anticucho de Carne', 6.00, 8.00, '2024-11-30', 25, '02', '002'),
('0028', 'Anticucho de Corazón', 7.00, 9.00, '2024-11-30', 20, '02', '002'),
('0029', 'Sangría', 10.00, 15.00, '2025-01-01', 15, '01', '004'),
('0030', 'Tallarin Rojo', 8.00, 12.00, '2024-11-30', 10, '01', '002'),
('0031', 'Salchipapa', 5.00, 8.00, '2024-11-30', 30, '01', '002'),
('0032', 'Salchipollo', 6.00, 9.00, '2024-11-30', 25, '01', '002'),
('0033', 'Chanchipapa', 7.00, 10.00, '2024-11-30', 20, '01', '002');

-- Entradas para la tabla T_RegPro
INSERT INTO T_RegPro (codReg, tipTra, dia, mes, año, can, des, dni, cod) VALUES 
('00000001', 'A', '01', '10', '2024', 20, 'Ingreso de Gaseosa Inca 1/2L', '72243153', '0001'),
('00000002', 'A', '02', '10', '2024', 15, 'Ingreso de Gaseosa CocaCola 1L', '75321456', '0006'),
('00000003', 'M', '03', '10', '2024', 10, 'Actualización de stock de Agua Cielo 1/2L', '71456234', '0010'),
('00000004', 'E', '04', '10', '2024', 5, 'Eliminación de registro de Papitas Lays', '71532467', '0017'),
('00000005', 'A', '05', '10', '2024', 25, 'Ingreso de Cerveza Pilsen', '72243153', '0015'),
('00000006', 'A', '06', '10', '2024', 18, 'Ingreso de Torta de Chocolate', '75321456', '0022'),
('00000007', 'M', '07', '10', '2024', 12, 'Actualización de stock de Agua San Luis 1L', '71456234', '0014'),
('00000008', 'E', '08', '10', '2024', 10, 'Eliminación de registro de Hamburguesa Clásica', '71532467', '0020'),
('00000009', 'A', '09', '10', '2024', 35, 'Ingreso de Gaseosa Escocesa 1/2L', '72243153', '0009'),
('00000010', 'A', '10', '10', '2024', 50, 'Ingreso de Chisito 1 sol', '75321456', '0018'),
('00000011', 'A', '11', '10', '2024', 20, 'Ingreso de Té Helado', '71456234', '0019'),
('00000012', 'M', '12', '10', '2024', 15, 'Actualización de stock de Anticucho de Carne', '71532467', '0027'),
('00000013', 'A', '13', '10', '2024', 22, 'Ingreso de Tallarín Rojo', '72243153', '0030'),
('00000014', 'E', '14', '10', '2024', 8, 'Eliminación de registro de Vino Tinto', '75321456', '0025'),
('00000015', 'A', '15', '10', '2024', 45, 'Ingreso de Salchipapa', '71456234', '0031'),
('00000016', 'A', '16', '10', '2024', 10, 'Ingreso de Hamburguesa Royal', '71532467', '0021'),
('00000017', 'A', '17', '10', '2024', 40, 'Ingreso de Agua Cielo 1L', '72243153', '0011'),
('00000018', 'M', '18', '10', '2024', 5, 'Actualización de stock de Sopa de Pollo', '75321456', '0026'),
('00000019', 'A', '19', '10', '2024', 28, 'Ingreso de Sangría', '71456234', '0029'),
('00000020', 'A', '20', '10', '2024', 30, 'Ingreso de Cerveza Cusqueña', '71532467', '0016'),
('00000021', 'A', '21', '10', '2024', 25, 'Ingreso de Chanchipapa', '72243153', '0033'),
('00000022', 'A', '22', '10', '2024', 40, 'Ingreso de Salchipollo', '75321456', '0032'),
('00000023', 'M', '23', '10', '2024', 12, 'Actualización de stock de Agua Loa 1/2L', '71456234', '0012'),
('00000024', 'E', '24', '10', '2024', 20, 'Eliminación de registro de Russ Kaya', '71532467', '0024'),
('00000025', 'A', '25', '10', '2024', 25, 'Ingreso de Papitas Lays', '72243153', '0017'),
('00000026', 'A', '26', '10', '2024', 40, 'Ingreso de Gaseosa CocaCola 2.5L', '75321456', '0007'),
('00000027', 'A', '27', '10', '2024', 10, 'Ingreso de Gaseosa Inca 1L', '71456234', '0002'),
('00000028', 'A', '28', '10', '2024', 15, 'Ingreso de Anticucho de Corazón', '71532467', '0028'),
('00000029', 'A', '29', '10', '2024', 20, 'Ingreso de Gaseosa CocaCola 3L', '72243153', '0008'),
('00000030', 'A', '30', '10', '2024', 12, 'Ingreso de Salchipapa', '75321456', '0031'),
('00000031', 'A', '01', '11', '2024', 10, 'Ingreso de Torta de Zanahoria', '71456234', '0023'),
('00000032', 'A', '02', '11', '2024', 25, 'Ingreso de Agua San Luis 1L', '71532467', '0014'),
('00000033', 'M', '03', '11', '2024', 7, 'Actualización de stock de Cerveza Cusqueña', '72243153', '0016'),
('00000034', 'A', '04', '11', '2024', 30, 'Ingreso de Hamburguesa Clásica', '75321456', '0020'),
('00000035', 'A', '05', '11', '2024', 22, 'Ingreso de Hamburguesa Royal', '71456234', '0021'),
('00000036', 'A', '06', '11', '2024', 15, 'Ingreso de Agua Loa 1/2L', '71532467', '0012'),
('00000037', 'E', '07', '11', '2024', 10, 'Eliminación de registro de Sangría', '72243153', '0029'),
('00000038', 'A', '08', '11', '2024', 20, 'Ingreso de Chisito 1 sol', '75321456', '0018'),
('00000039', 'A', '09', '11', '2024', 35, 'Ingreso de Torta de Chocolate', '71456234', '0022'),
('00000040', 'A', '10', '11', '2024', 40, 'Ingreso de Tallarín Rojo', '71532467', '0030'),
('00000041', 'A', '11', '11', '2024', 50, 'Ingreso de Agua Cielo 1/2L', '72243153', '0010'),
('00000042', 'A', '12', '11', '2024', 20, 'Ingreso de Agua San Luis 1/2L', '75321456', '0013'),
('00000043', 'M', '13', '11', '2024', 12, 'Actualización de stock de Té Helado', '71456234', '0019'),
('00000044', 'A', '14', '11', '2024', 18, 'Ingreso de Anticucho de Carne', '71532467', '0027'),
('00000045', 'A', '15', '11', '2024', 15, 'Ingreso de Russ Kaya', '72243153', '0024'),
('00000046', 'A', '16', '11', '2024', 20, 'Ingreso de Cerveza Pilsen', '75321456', '0015'),
('00000047', 'A', '17', '11', '2024', 25, 'Ingreso de Torta de Zanahoria', '71456234', '0023'),
('00000048', 'A', '18', '11', '2024', 35, 'Ingreso de Hamburguesa Clásica', '71532467', '0020'),
('00000049', 'A', '19', '11', '2024', 40, 'Ingreso de Gaseosa Inca 3L', '72243153', '0003'),
('00000050', 'A', '20', '11', '2024', 10, 'Ingreso de Gaseosa Escocesa 2L', '75321456', '0004');

-- Tabla M_Con (Contactos)
INSERT INTO M_Con (dni, tel, ema) VALUES 
('72243153', '987654321', 'juan.perez@example.com'),  -- Contacto para Juan Pérez
('72243153', '912345678', 'juan.perez.secondary@example.com'),  -- Segundo contacto para Juan
('75321456', '998877665', 'maria.lopez@example.com'),  -- Contacto para María López
('71456234', '976543210', 'carlos.ramos@example.com'),  -- Contacto para Carlos Ramos
('71532467', '945678123', 'ana.gomez@example.com');  -- Contacto para Ana Gómez

-- Crear índices para optimizar las consultas

CREATE INDEX  idx_nom_pro ON M_Pro (nom);
CREATE INDEX idx_dia ON T_RegPro (dia);
CREATE INDEX idx_mes ON T_RegPro (mes);
CREATE INDEX idx_año ON T_RegPro (año);
CREATE INDEX idx_fecha_completo ON T_RegPro (año, mes, dia);


DELIMITER $$

CREATE PROCEDURE sp_insertar_registro_transaccion(
    IN p_codReg CHAR(8),
    IN p_tipTra CHAR(1),
    IN p_dia CHAR(2),
    IN p_mes CHAR(2),
    IN p_año CHAR(4),
    IN p_can INT,
    IN p_des VARCHAR(50),
    IN p_dni CHAR(8),
    IN p_cod CHAR(4)
)
BEGIN
    INSERT INTO T_RegPro (codReg, tipTra, dia, mes, año, can, des, dni, cod)
    VALUES (p_codReg, p_tipTra, p_dia, p_mes, p_año, p_can, p_des, p_dni, p_cod);
END$$

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


DELIMITER $$

CREATE PROCEDURE sp_actualizar_registro_transaccion(
    IN p_codReg CHAR(8),
    IN p_can INT,
    IN p_des VARCHAR(50)
)
BEGIN
    UPDATE T_RegPro 
    SET can = p_can, des = p_des 
    WHERE codReg = p_codReg;
END$$

DELIMITER ;


DELIMITER $$

CREATE PROCEDURE sp_eliminar_registro_transaccion(
    IN p_codReg CHAR(8)
)
BEGIN
    DELETE FROM T_RegPro WHERE codReg = p_codReg;
END$$

DELIMITER ;



DELIMITER $$

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

DELIMITER $$

CREATE PROCEDURE ListarProveedores()
BEGIN
    SELECT codPro, nom, con, tel, dir FROM M_Prov;
END $$

DELIMITER ;

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

DELIMITER $$

CREATE PROCEDURE EliminarProveedor(
    IN p_codPro CHAR(2)
)
BEGIN
    DELETE FROM M_Prov WHERE codPro = p_codPro;
END $$

DELIMITER ;


-- categoria

DELIMITER $$
CREATE PROCEDURE ListarCategorias()
BEGIN
    SELECT codCat, nom, des
    FROM M_Cat;
END $$
DELIMITER ;

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

DELIMITER $$
CREATE PROCEDURE EliminarCategoria(
    IN p_codCat CHAR(3)
)
BEGIN
    DELETE FROM M_Cat
    WHERE codCat = p_codCat;
END $$
DELIMITER ;


-- roll

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




-- EMPLEADOS

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
