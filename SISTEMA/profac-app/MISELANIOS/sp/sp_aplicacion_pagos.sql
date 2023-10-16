CREATE PROCEDURE `sp_aplicacion_pagos` (
                                          IN `accion` INT,
                                          IN `pfactura_id` INT,

                                       )   
   BEGIN

      ### VALIDANDO EXISTENCIA DE ID DE FACTURA EN TBL APLICACION PAGOS

       SELECT COUNT(*) FROM aplicacion_pagos WHERE factura_id = pfactura_id;

       SET @existeFactura = 0;


      IF (SELECT COUNT(*) FROM aplicacion_pagos WHERE factura_id = pfactura_id) > 0 THEN
         @existeFactura := 1;
      END IF;

      IF accion == 1 THEN 
         ###se registro una nueva factura
         statements;
      END IF;

      IF accion == 2 THEN 
         ###se registro una nueva nota de credito
         statements;
      END IF;

      IF accion == 3 THEN 
         ###se registro una nueva nota de debito
         statements;
      END IF;

      IF accion == 4 THEN 
         ###se registro un nuevo abono al credito de la factura
         statements;
      END IF;

      IF accion == 5 THEN 
         ###se registro otro movimiento
         statements;
      END IF;



   END$$