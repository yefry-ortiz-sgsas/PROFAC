DROP PROCEDURE IF EXISTS `sp_aplicacion_pagos`;
DELIMITER $$
CREATE PROCEDURE `sp_aplicacion_pagos` (
    IN `accion` INT ,/*Obligatorio*/
    IN `pcliente_id` INT ,/*Obligatorio*/
    IN `usr_actual` INT ,/*Obligatorio*/
    IN `pfactura_id` INT,
   	OUT `estado` INT,
    OUT `msjResultado` VARCHAR(500)
)BEGIN
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
				SET estado := -1;
				SET msjResultado := "Se ha hecho rollback";

                select estado,msjResultado;
  END;

  START TRANSACTION;
      /*Accion que se ejecuta para clientes viejos*/
          IF accion = 1 THEN
            INSERT INTO aplicacion_pagos

            (factura_id,
             total_factura_cargo,
             retencion_isv_factura,
             estado_retencion_isv,
             total_notas_credito,
             total_nodas_debito,
             credito_abonos,
             comentario,
             saldo,
             ultimo_usr_actualizo,
             estado,
             estado_cerrado,
             usr_cerro,
             created_at)
            SELECT
                fa.id, fa.total,fa.isv,1,0,0,0,'',fa.total,0,1,0,0,NOW()
            FROM factura fa
              inner join cliente cli on cli.id = fa.cliente_id
            WHERE cli.id = pcliente_id and fa.estado_venta_id <> 2 and fa.pendiente_cobro <> 0;
				SET estado := 1;
				SET msjResultado := "Se ha guardado con exito";

                select estado,msjResultado;
          END IF;
  COMMIT;
END$$
DELIMITER ;
