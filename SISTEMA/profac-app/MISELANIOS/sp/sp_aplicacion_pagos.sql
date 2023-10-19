
DROP PROCEDURE IF EXISTS `sp_aplicacion_pagos`;
DELIMITER $$
CREATE PROCEDURE `sp_aplicacion_pagos` (
    IN `accion` INT ,/*Obligatorio*/
    IN `usr_actual` INT ,/*Obligatorio*/
    IN `pfactura_id` INT,/*Obligatorio*/
    IN `pidGestion` INT,/*idGestion puede ser nota de credito id, nota de debito id, abono_creditos id, otro_movimiento id*/
    IN `pcomentario` VARCHAR(500)
    )
BEGIN
   /*Validando existencia de la factura en cuestión, en la tabla pivote*/
    SELECT @existenciaFactura := COUNT(*) FROM aplicacion_pagos WHERE factura_id = pfactura_id and estado = 1;

      IF accion = 1 THEN
         ###se registro una nueva factura
         /*
            Esta acción se ejecutara solamente al crearse la factura, dónde en este punto solo existe una factura sin más agregados.
            Se ejecuta para la creación del pivote que mantendrá su saldo de aqui en delante.
         */

         IF @existenciaFactura = 0 THEN
            #recuperando datos e insertando en el pivote, lo hará sólo si no existe ese id en el pivote

            INSERT INTO aplicacion_pagos (
                factura_id,
                total_factura_cargo,
                retencion_isv_factura,
                estado_retencion_isv,
                total_notas_credito,
                total_nodas_debito,
                credito_abonos,
                mov_suma,
                mov_resta,
                saldo,
                comentario,
                estado,
                created_at
            )
            SELECT
                pfactura_id,
                factura.total,
                factura.isv,
                1,#se cobra inicialmente la retencion por eso estado 1
                0,#Totales iniciados en 0
                0,#Totales iniciados en 0
                0,#Totales iniciados en 0
                0,
                0,
                0,
                'N/A',
                1,
                NOW()
            FROM factura
            WHERE id = pfactura_id;
         END IF;


      END IF;

      IF accion = 2 THEN
        ###se registro rebaja de nota de crédito
        /*PASO 1: VALIDAR EXISTENCIA DE FACTURA EN TABLA PIVOTE Y CREAR*/

            IF @existenciaFactura = 0 THEN
                #recuperando datos e insertando en el pivote, lo hará sólo si no existe ese id en el pivote

                INSERT INTO aplicacion_pagos (
                    factura_id,
                    total_factura_cargo,
                    retencion_isv_factura,
                    estado_retencion_isv,
                    total_notas_credito,
                    total_nodas_debito,
                    credito_abonos,
                    mov_suma,
                    mov_resta,
                    saldo,
                    comentario,
                    estado,
                    created_at
                )
                SELECT
                    pfactura_id,
                    factura.total,
                    factura.isv,
                    1,#se cobra inicialmente la retencion por eso estado 1
                    0,#Totales iniciados en 0
                    0,#Totales iniciados en 0
                    0,#Totales iniciados en 0
                    0,
                    0,
                    0,
                    'N/A',
                    1,
                    NOW()
                FROM factura
                WHERE id = pfactura_id;
            END IF;

        /*PASO 2: ACTUALIZAR ESTADO DE REBAJA DE NOTA DE CREDITO*/
            UPDATE nota_credito
                SET estado_rebajado = 1,
                    user_registra_rebaja = usr_actual,
                    comentario_rebajado = pcomentario,
                    fecha_rebajado = NOW()
            WHERE id = pidGestion and estado_nota_id = 1;

        /*PASO 3: ACTUALIZAR EL SALDO DE ESTA FACTURA EN EL PIVOTE*/
            SELECT @totalnd := total from nota_credito WHERE id = pidGestion and estado_nota_id = 1;
            UPDATE aplicacion_pagos
                SET estado_rebajado = 1,
                    total_notas_credito = @totalnd,
                    saldo = saldo - @totalnd
            WHERE factura_id = pfactura_id and estado = 1;

      END IF;

      IF accion = 3 THEN
         ###se registro una nueva nota de debito
         SELECT * FROM factura;
      END IF;

      IF accion = 4 THEN
         ###se registro un nuevo abono al credito de la factura
         SELECT * FROM factura;
      END IF;

      IF accion = 5 THEN
         ###se registro otro movimiento
         SELECT * FROM factura;
      END IF;


END$$
DELIMITER ;
