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

            (
             cliente_id,
             factura_id,
             total_factura_cargo,
             retencion_isv_factura,
             estado_retencion_isv,
             total_notas_credito,
             total_nodas_debito,
             credito_abonos,
             movimiento_suma,
             movimiento_resta,
             comentario,
             saldo,
             ultimo_usr_actualizo,
             estado,
             estado_cerrado,
             usr_cerro,
             created_at)
            SELECT
                pcliente_id,     #idCliente
                fa.id,           #factura_id
                fa.total,        #total_factura_cargo
                fa.isv,          #retencion_isv_factura
                1,               #estado_retencion_isv
                0,               #total_notas_credito
                0,               #total_nodas_debito
                0,               #credito_abonos,
                0,               #movimiento_suma
                0,               #movimiento_resta
                '',              #comentario
                fa.total,        #saldo
                0,               #ultimo_usr_actualizo
                1,               #estado
                0,               #estado_cerrado
                0,               #usr_cerro
                NOW()            #created_at
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
