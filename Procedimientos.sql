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

DELIMITER $$

CREATE PROCEDURE sp_consultar_registro_transaccion(
    IN p_codReg CHAR(8)
)
BEGIN
    SELECT * FROM T_RegPro WHERE codReg = p_codReg;
END$$

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