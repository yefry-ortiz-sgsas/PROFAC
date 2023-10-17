
DROP PROCEDURE IF EXISTS `sp_aplicacion_pagos`;
DELIMITER $$
CREATE PROCEDURE `sp_aplicacion_pagos` (IN `accion` INT ,IN `pfactura_id` INT)
BEGIN
   /*Validando existencia de la factura en cuestión, en la tabla pivote*/
    SELECT @existenciaFactura := COUNT(*) FROM aplicacion_pagos WHERE factura_id = pfactura_id;

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
                NOW()
            FROM factura
            WHERE id = pfactura_id;
         END IF;
      END IF;

      IF accion = 2 THEN
         ###se registro una nueva nota de credito
         SELECT * FROM factura;
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
