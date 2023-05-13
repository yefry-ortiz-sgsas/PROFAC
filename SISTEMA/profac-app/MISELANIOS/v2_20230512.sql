-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 13-05-2023 a las 01:57:15
-- Versión del servidor: 5.7.33
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `profac_app`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `obtrCardex` (IN `bdega` INT, IN `prodct` INT)   BEGIN

select * from (

   select
A.created_at as 'fechaIngreso',
D.nombre as 'producto',
D.id as 'codigoProducto',
B.id as 'factura',
B.numero_factura as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (-)') as 'descripcion',
concat (bodega.nombre,' ',seccion.descripcion) as 'origen',
'' as 'destino',
(select sum(cantidad_s) from venta_has_producto where factura_id = A.factura_id and producto_id = prodct) as cantidad,
users.name as  'usuario'
from log_translado A
inner join factura B
on B.id = A.factura_id
inner join recibido_bodega C
on A.origen = C.id
inner join producto D
on D.id = C.producto_id
inner join seccion on seccion.id = C.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where A.destino is null  and A.descripcion not in ('Vale de producto','Venta de producto - vale')
and bodega.id = bdega and D.id = prodct

union

/* ---------------------------------- FACTURAS ANULADAS --------------------------------------- */
select
A.created_at as 'fechaIngreso',
D.nombre as 'producto',
D.id as 'codigoProducto',
B.id as 'factura',
B.numero_factura as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (+)') as 'descripcion',
'' as 'origen',
concat (bodega.nombre,' ',seccion.descripcion) as 'destino',
A.cantidad,
users.name as  'usuario'
from log_translado A
inner join factura B
on B.id = A.factura_id
inner join recibido_bodega C
on A.destino = C.id
inner join producto D
on D.id = C.producto_id
inner join seccion on seccion.id = C.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where A.destino is not null
and bodega.id = bdega and D.id = prodct


UNION

/*------------------------------------- AJUSTES ----------------------------------------- */
select
D.created_at as 'fechaIngreso',
E.nombre as 'producto',
E.id as 'codigoProducto',
'' as 'factura',
'' as 'factura_cod',
D.id as 'ajuste',
D.numero_ajuste as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
if(C.tipo_aritmetica = 1 ,concat(B.descripcion,' (+)'), concat(B.descripcion,' (-)') ) as 'descripcion',
concat (bodega.nombre,' ',seccion.descripcion) as 'origen',
'' as 'destino',
B.cantidad,
users.name as  'usuario'
from recibido_bodega A
inner join log_translado B
on A.id = B.origen
inner join ajuste_has_producto C
on (B.ajuste_id = C.ajuste_id) AND  (A.producto_id = C.producto_id)
inner join ajuste D
on C.ajuste_id = D.id
inner join producto E
on E.id = A.producto_id
inner join seccion on seccion.id = A.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = B.users_id
where bodega.id = bdega and E.id = prodct

UNION

/*------------------------------------- INGRESO POR COMPRA ----------------------------------------- */
select 
A.created_at as 'fechaIngreso',
C.nombre as 'producto',
C.id as 'codigoProducto',
'' as 'factura',
'' as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
D.id as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (+)') as 'descripcion',
'' as 'origen',
concat (bodega.nombre,' ',seccion.descripcion) as 'destino',
A.cantidad,
users.name as  'usuario'
from log_translado A
inner join recibido_bodega B
on A.origen = B.id
inner join producto C
on B.producto_id = C.id
inner join compra D
on A.compra_id = D.id
inner join seccion on seccion.id = B.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where D.estado_compra_id = 1 and bodega.id = bdega and C.id = prodct

UNION
/*---------------------------Comprobante de entrega  ----------------------------------------------*/
select 
A.created_at as 'fechaIngreso',
D.nombre as 'producto',
D.id as 'codigoProducto',
'' as 'factura',
'' as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
E.id as 'comprobante',
E.numero_comprovante as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (-)') as 'descripcion',
concat (bodega.nombre,' ',seccion.descripcion) as 'origen',
'' as 'destino',
A.cantidad,
users.name as  'usuario'
from log_translado A
inner join comprovante_has_producto B
on A.comprovante_entrega_id = B.comprovante_id and A.origen = B.lote_id
inner join recibido_bodega C
on A.origen = C.id
inner join producto D
on C.producto_id = D.id
inner join comprovante_entrega E
on A.comprovante_entrega_id = E.id
inner join seccion on seccion.id = C.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where A.descripcion = 'Orden de Entrega'
and bodega.id = bdega and D.id = prodct

 
UNION

/*---------------------------Comprobante de entrega anulado ----------------------------------------------*/

select 
A.created_at as 'fechaIngreso',
D.nombre as 'producto',
D.id as 'codigoProducto',
'' as 'factura',
'' as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
E.id as 'comprobante',
E.numero_comprovante as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (+)') as 'descripcion',
'' as 'origen',
concat (bodega.nombre,' ',seccion.descripcion) as 'destino',
A.cantidad,
users.name as  'usuario'
from log_translado A
inner join comprovante_has_producto B
on A.comprovante_entrega_id = B.comprovante_id and A.destino = B.lote_id
inner join recibido_bodega C
on A.origen = C.id
inner join producto D
on C.producto_id = D.id
inner join comprovante_entrega E
on A.comprovante_entrega_id = E.id
inner join seccion on seccion.id = C.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where A.descripcion = 'Orden de Entrega - Anulado'
and bodega.id = bdega and D.id = prodct

union

/*-----------------------------------------Vale Tipo 1 - Agenda de entrega---------------------------------------------------------------*/
select 
A.created_at as 'fechaIngreso',
E.nombre as 'producto',
E.id as 'codigoProducto',
F.id as 'factura',
F.numero_factura as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
C.id as 'vale_tipo_1',
C.numero_vale as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (-)') as 'descripcion',
concat (bodega.nombre,' ',seccion.descripcion) as 'origen',
'' as 'destino',
A.cantidad,
users.name as  'usuario' 
from log_translado A
inner join vale_has_producto B
on A.vale_id = B.vale_id and A.origen = B.lote_id
inner join vale C
on B.vale_id = C.id
inner join recibido_bodega D
on A.origen = D.id
inner join producto E
on E.id = D.producto_id
inner join factura F
on A.factura_id = F.id
inner join seccion on seccion.id = D.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where bodega.id = bdega and E.id = prodct

union 

/*----------------------------------------------------------Vale Tipo 2 - Lista de espera ----------------------------------------------------------------------------------------------*/

select
A.created_at as 'fechaIngreso',
D.nombre as 'producto',
D.id as 'codigoProducto',
B.id as 'factura',
B.numero_factura as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
E.id as 'vale_tipo_2',
E.numero_vale as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (-)') as 'descripcion',
concat (bodega.nombre,' ',seccion.descripcion) as 'origen',
'' as 'destino',
A.cantidad,
users.name as  'usuario'
from log_translado A
inner join factura B
on B.id = A.factura_id
inner join recibido_bodega C
on A.origen = C.id
inner join producto D
on D.id = C.producto_id
inner join vale E
on B.id = E.factura_id
inner join seccion on seccion.id = C.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where A.destino is null  and A.descripcion = 'Venta de producto - vale'
and bodega.id = bdega and D.id =prodct

UNION
/*---------------------------------------------------------------NOTA DE CREDITO--------------------------------------------------------------------------------------------------------*/
select 
A.created_at as 'fechaIngreso',
D.nombre as 'producto',
D.id as 'codigoProducto',
E.id as 'factura',
E.numero_factura as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
B.id as 'nota_credito',
B.numero_nota as 'nota_credito_cod',
concat(A.descripcion,' (+)') as 'descripcion',
'' as 'origen',
concat (bodega.nombre,' ',seccion.descripcion) as 'destino',
sum(A.cantidad) as cantidad,
users.name as  'usuario'
from log_translado A
inner join nota_credito B
on A.nota_credito_id = B.id
inner join recibido_bodega C
on A.destino = C.id
inner join producto D
on C.producto_id = D.id
inner join factura E
on E.id = B.factura_id
inner join seccion on seccion.id = C.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where bodega.id = bdega and D.id =prodct
group by B.id, D.id, A.created_at, D.nombre, D.id, E.id, E.numero_factura,B.id,B.numero_nota,A.descripcion,bodega.nombre,seccion.descripcion,users.name

union
/*--------------------------------------------------------Translados provicional--------------------------------------------------------------------------*/


select
A.created_at as 'fechaIngreso',
C.nombre as 'producto',
C.id as 'codigoProducto',
'' as 'factura',
'' as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
(A.descripcion) as 'descripcion',
concat (bodega.nombre,' ',seccion.descripcion) as 'origen',
(
select
concat (bodega.nombre,' ',seccion.descripcion)
from recibido_bodega
inner join seccion  on recibido_bodega.seccion_id = seccion.id 
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
where recibido_bodega.id = A.destino


) as 'destino',
A.cantidad,
users.name as  'usuario'
from log_translado A
inner join recibido_bodega B
on A.origen = B.id
inner join producto C
on B.producto_id = C.id
inner join seccion on seccion.id = B.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where A.descripcion = 'Translado de bodega'
and bodega.id = bdega and C.id =prodct

union 

select
A.created_at as 'fechaIngreso',
C.nombre as 'producto',
C.id as 'codigoProducto',
'' as 'factura',
'' as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
(A.descripcion) as 'descripcion',


(
select
concat (bodega.nombre,' ',seccion.descripcion)
from recibido_bodega
inner join seccion  on recibido_bodega.seccion_id = seccion.id 
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
where recibido_bodega.id = A.origen


) as 'origen',
concat (bodega.nombre,' ',seccion.descripcion) as 'destino',

A.cantidad,
users.name as  'usuario'
from log_translado A
inner join recibido_bodega B
on A.destino = B.id
inner join producto C
on B.producto_id = C.id
inner join seccion on seccion.id = B.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where A.descripcion = 'Translado de bodega'
and bodega.id = bdega and C.id =prodct

) as kardex order by fechaIngreso desc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `obtrCardexGeneral` (IN `fecha_inicio` DATE, IN `fecha_final` DATE)   BEGIN

select * from (
   (select
A.created_at as 'fechaIngreso',
D.nombre as 'producto',
D.id as 'codigoProducto',
B.id as 'factura',
B.numero_factura as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (-)') as 'descripcion',
concat (bodega.nombre,' ',seccion.descripcion) as 'origen',
'' as 'destino',
(select sum(cantidad_s) from venta_has_producto where factura_id = A.factura_id and producto_id = C.producto_id) as cantidad,
users.name as  'usuario'
from log_translado A
inner join factura B
on B.id = A.factura_id
inner join recibido_bodega C
on A.origen = C.id
inner join producto D
on D.id = C.producto_id
inner join seccion on seccion.id = C.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where A.destino is null  and A.descripcion not in ('Vale de producto','Venta de producto - vale')
and A.created_at  BETWEEN fecha_inicio AND fecha_final
limit 100)


union

/* ---------------------------------- FACTURAS ANULADAS --------------------------------------- */
(select
A.created_at as 'fechaIngreso',
D.nombre as 'producto',
D.id as 'codigoProducto',
B.id as 'factura',
B.numero_factura as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (+)') as 'descripcion',
'' as 'origen',
concat (bodega.nombre,' ',seccion.descripcion) as 'destino',
A.cantidad,
users.name as  'usuario'
from log_translado A
inner join factura B
on B.id = A.factura_id
inner join recibido_bodega C
on A.destino = C.id
inner join producto D
on D.id = C.producto_id
inner join seccion on seccion.id = C.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where A.destino is not null
and DATE(A.created_at)  BETWEEN fecha_inicio AND fecha_final
limit 100)


UNION

/*------------------------------------- AJUSTES ----------------------------------------- */
(select
A.created_at as 'fechaIngreso',
E.nombre as 'producto',
E.id as 'codigoProducto',
'' as 'factura',
'' as 'factura_cod',
D.id as 'ajuste',
D.numero_ajuste as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
if(C.tipo_aritmetica = 1 ,concat(B.descripcion,' (+)'), concat(B.descripcion,' (-)') ) as 'descripcion',
concat (bodega.nombre,' ',seccion.descripcion) as 'origen',
'' as 'destino',
B.cantidad,
users.name as  'usuario'
from recibido_bodega A
inner join log_translado B
on A.id = B.origen
inner join ajuste_has_producto C
on (B.ajuste_id = C.ajuste_id) AND  (A.producto_id = C.producto_id)
inner join ajuste D
on C.ajuste_id = D.id
inner join producto E
on E.id = A.producto_id
inner join seccion on seccion.id = A.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = B.users_id
where  DATE(A.created_at)  BETWEEN fecha_inicio AND fecha_final
limit 100)

UNION

/*------------------------------------- INGRESO POR COMPRA ----------------------------------------- */
(select 
A.created_at as 'fechaIngreso',
C.nombre as 'producto',
C.id as 'codigoProducto',
'' as 'factura',
'' as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
D.id as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (+)') as 'descripcion',
'' as 'origen',
concat (bodega.nombre,' ',seccion.descripcion) as 'destino',
A.cantidad,
users.name as  'usuario'
from log_translado A
inner join recibido_bodega B
on A.origen = B.id
inner join producto C
on B.producto_id = C.id
inner join compra D
on A.compra_id = D.id
inner join seccion on seccion.id = B.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where D.estado_compra_id = 1 
and DATE(A.created_at)  BETWEEN fecha_inicio AND fecha_final
limit 100)

UNION
/*---------------------------Comprobante de entrega  ----------------------------------------------*/
(select 
A.created_at as 'fechaIngreso',
D.nombre as 'producto',
D.id as 'codigoProducto',
'' as 'factura',
'' as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
E.id as 'comprobante',
E.numero_comprovante as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (-)') as 'descripcion',
concat (bodega.nombre,' ',seccion.descripcion) as 'origen',
'' as 'destino',
A.cantidad,
users.name as  'usuario'
from log_translado A
inner join comprovante_has_producto B
on A.comprovante_entrega_id = B.comprovante_id and A.origen = B.lote_id
inner join recibido_bodega C
on A.origen = C.id
inner join producto D
on C.producto_id = D.id
inner join comprovante_entrega E
on A.comprovante_entrega_id = E.id
inner join seccion on seccion.id = C.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where A.descripcion = 'Orden de Entrega'
and DATE(A.created_at)  BETWEEN fecha_inicio AND fecha_final
limit 100)

 
UNION

/*---------------------------Comprobante de entrega anulado ----------------------------------------------*/

(select 
A.created_at as 'fechaIngreso',
D.nombre as 'producto',
D.id as 'codigoProducto',
'' as 'factura',
'' as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
E.id as 'comprobante',
E.numero_comprovante as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (+)') as 'descripcion',
'' as 'origen',
concat (bodega.nombre,' ',seccion.descripcion) as 'destino',
A.cantidad,
users.name as  'usuario'
from log_translado A
inner join comprovante_has_producto B
on A.comprovante_entrega_id = B.comprovante_id and A.destino = B.lote_id
inner join recibido_bodega C
on A.origen = C.id
inner join producto D
on C.producto_id = D.id
inner join comprovante_entrega E
on A.comprovante_entrega_id = E.id
inner join seccion on seccion.id = C.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where A.descripcion = 'Orden de Entrega - Anulado'
and DATE(A.created_at)  BETWEEN fecha_inicio AND fecha_final
limit 100)

union

/*-----------------------------------------Vale Tipo 1 - Agenda de entrega---------------------------------------------------------------*/
(select 
A.created_at as 'fechaIngreso',
E.nombre as 'producto',
E.id as 'codigoProducto',
F.id as 'factura',
F.numero_factura as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
C.id as 'vale_tipo_1',
C.numero_vale as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (-)') as 'descripcion',
concat (bodega.nombre,' ',seccion.descripcion) as 'origen',
'' as 'destino',
A.cantidad,
users.name as  'usuario' 
from log_translado A
inner join vale_has_producto B
on A.vale_id = B.vale_id and A.origen = B.lote_id
inner join vale C
on B.vale_id = C.id
inner join recibido_bodega D
on A.origen = D.id
inner join producto E
on E.id = D.producto_id
inner join factura F
on A.factura_id = F.id
inner join seccion on seccion.id = D.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where DATE(A.created_at)  BETWEEN fecha_inicio AND fecha_final
limit 100)

union 

/*----------------------------------------------------------Vale Tipo 2 - Lista de espera ----------------------------------------------------------------------------------------------*/

(select
A.created_at as 'fechaIngreso',
D.nombre as 'producto',
D.id as 'codigoProducto',
B.id as 'factura',
B.numero_factura as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
E.id as 'vale_tipo_2',
E.numero_vale as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
concat(A.descripcion,' (-)') as 'descripcion',
concat (bodega.nombre,' ',seccion.descripcion) as 'origen',
'' as 'destino',
A.cantidad,
users.name as  'usuario'
from log_translado A
inner join factura B
on B.id = A.factura_id
inner join recibido_bodega C
on A.origen = C.id
inner join producto D
on D.id = C.producto_id
inner join vale E
on B.id = E.factura_id
inner join seccion on seccion.id = C.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where A.destino is null  and A.descripcion = 'Venta de producto - vale'
and DATE(A.created_at)  BETWEEN fecha_inicio AND fecha_final
limit 100)

UNION
/*---------------------------------------------------------------NOTA DE CREDITO--------------------------------------------------------------------------------------------------------*/
(select 
A.created_at as 'fechaIngreso',
D.nombre as 'producto',
D.id as 'codigoProducto',
E.id as 'factura',
E.numero_factura as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
B.id as 'nota_credito',
B.numero_nota as 'nota_credito_cod',
concat(A.descripcion,' (+)') as 'descripcion',
'' as 'origen',
concat (bodega.nombre,' ',seccion.descripcion) as 'destino',
sum(A.cantidad) as cantidad,
users.name as  'usuario'
from log_translado A
inner join nota_credito B
on A.nota_credito_id = B.id
inner join recibido_bodega C
on A.destino = C.id
inner join producto D
on C.producto_id = D.id
inner join factura E
on E.id = B.factura_id
inner join seccion on seccion.id = C.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where DATE(A.created_at)  BETWEEN fecha_inicio AND fecha_final
group by B.id, D.id, A.created_at, D.nombre, D.id, E.id, E.numero_factura,B.id,B.numero_nota,A.descripcion,bodega.nombre,seccion.descripcion,users.name
limit 100)

union
/*--------------------------------------------------------Translados provicional--------------------------------------------------------------------------*/


(select
A.created_at as 'fechaIngreso',
C.nombre as 'producto',
C.id as 'codigoProducto',
'' as 'factura',
'' as 'factura_cod',
'' as 'ajuste',
'' as 'ajuste_cod',
'' as 'detalleCompra',
'' as 'comprobante',
'' as 'comprobante_cod',
'' as 'vale_tipo_1',
'' as 'vale_tipo_1_cod',
'' as 'vale_tipo_2',
'' as 'vale_tipo_2_cod',
'' as 'nota_credito',
'' as 'nota_credito_cod',
(A.descripcion) as 'descripcion',
concat (bodega.nombre,' ',seccion.descripcion) as 'origen',
(
select
concat (bodega.nombre,' ',seccion.descripcion)
from recibido_bodega
inner join seccion  on recibido_bodega.seccion_id = seccion.id 
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
where recibido_bodega.id = A.destino


) as 'destino',
A.cantidad,
users.name as  'usuario'
from log_translado A
inner join recibido_bodega B
on A.origen = B.id
inner join producto C
on B.producto_id = C.id
inner join seccion on seccion.id = B.seccion_id
inner join segmento on segmento.id = seccion.segmento_id
inner join bodega on bodega.id = segmento.bodega_id
inner join users on users.id = A.users_id
where A.descripcion = 'Translado de bodega'
and DATE(A.created_at)  BETWEEN fecha_inicio AND fecha_final
limit 100)
) as kardex order by fechaIngreso desc;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajuste`
--

CREATE TABLE `ajuste` (
  `id` int(11) NOT NULL,
  `numero_ajuste` varchar(45) NOT NULL,
  `comentario` text NOT NULL,
  `tipo_ajuste_id` int(11) NOT NULL,
  `solicitado_por` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajuste_has_producto`
--

CREATE TABLE `ajuste_has_producto` (
  `ajuste_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `recibido_bodega_id` int(11) NOT NULL,
  `tipo_aritmetica` varchar(45) NOT NULL,
  `precio_producto` double NOT NULL,
  `cantidad_inicial` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cantidad_total` int(11) NOT NULL,
  `unidad_medida_venta_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `banco`
--

CREATE TABLE `banco` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `cuenta` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `banco`
--

INSERT INTO `banco` (`id`, `nombre`, `cuenta`, `created_at`, `updated_at`, `users_id`) VALUES
(1, 'BAC', '7777777', '2022-09-16 16:27:15', '2022-09-16 22:27:15', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

CREATE TABLE `bodega` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(500) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `municipio_id` int(11) NOT NULL,
  `encargado_bodega` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `latitud` varchar(45) DEFAULT NULL,
  `longitud` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bodega`
--

INSERT INTO `bodega` (`id`, `nombre`, `direccion`, `estado_id`, `municipio_id`, `encargado_bodega`, `created_at`, `updated_at`, `latitud`, `longitud`) VALUES
(1, 'BODEGA INICIAL', 'Comayagua', 1, 110, 20, '2022-10-01 09:30:14', '2022-10-01 09:30:14', NULL, NULL),
(2, 'Anexo 1 comayagua', 'comayagua', 2, 19, 20, '2023-01-16 10:38:07', '2023-01-16 10:38:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cai`
--

CREATE TABLE `cai` (
  `id` int(11) NOT NULL,
  `cai` varchar(37) NOT NULL,
  `punto_de_emision` varchar(45) NOT NULL,
  `cantidad_solicitada` int(11) NOT NULL,
  `cantidad_otorgada` int(11) NOT NULL,
  `numero_actual` int(11) NOT NULL,
  `serie` int(11) NOT NULL,
  `cantidad_no_utilizada` int(11) NOT NULL,
  `numero_inicial` varchar(19) NOT NULL,
  `numero_final` varchar(19) NOT NULL,
  `numero_base` varchar(19) NOT NULL,
  `fecha_limite_emision` date NOT NULL,
  `tipo_documento_fiscal_id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cai`
--

INSERT INTO `cai` (`id`, `cai`, `punto_de_emision`, `cantidad_solicitada`, `cantidad_otorgada`, `numero_actual`, `serie`, `cantidad_no_utilizada`, `numero_inicial`, `numero_final`, `numero_base`, `fecha_limite_emision`, `tipo_documento_fiscal_id`, `estado_id`, `users_id`, `created_at`, `updated_at`) VALUES
(2, 'D6770A-8749A6-1144AA-3AB6DB-D37832-0B', '001 SFC Independiente Fijo', 1000, 1000, 4, 1, 997, '000-001-01-00000001', '000-001-01-00001000', '000-001-01', '2023-09-29', 1, 2, 3, '2022-10-20 11:33:10', '2022-10-20 11:33:10'),
(3, 'D6770A-8749A6-1144AA-3AB6DB-D37832-0B', '001 SFC Independiente Fijo', 1000, 1000, 3, 1, 998, '000-001-01-00000001', '000-001-01-00005000', '000-001-01', '2023-10-29', 1, 2, 3, '2022-10-21 11:37:04', '2022-10-21 11:37:04'),
(4, 'D6770A-8749A6-1144AA-3AB6DB-D37832-0B', '001 SFC Independiente Fijo', 1000, 1000, 4, 1, 997, '000-001-01-00000001', '000-001-01-00001000', '000-001-01', '2023-09-29', 1, 2, 20, '2022-11-03 10:57:03', '2022-11-03 10:57:03'),
(5, 'D6770A-8749A6-1144AA-3AB6DB-D37832-0B', '001 SFC Independiente Fijo', 1000, 1000, 4, 1, 997, '000-001-01-00000001', '000-001-01-00001000', '000-001-01', '2023-09-09', 1, 2, 3, '2022-11-03 23:12:59', '2022-11-03 23:12:59'),
(6, 'D6770A-8749A6-1144AA-3AB6DB-D37832-0B', '001 SFC Independiente Fijo', 1000, 1000, 2, 1, 999, '000-001-01-00000001', '000-001-01-00001000', '000-001-01', '2023-09-09', 1, 2, 3, '2022-11-03 23:27:21', '2022-11-03 23:27:21'),
(7, 'D6770A-8749A6-1144AA-3AB6DB-D37832-0B', '001 SFC Independiente Fijo', 1000, 1000, 50, 1, 951, '000-001-01-00000001', '000-001-01-00001000', '000-001-01', '2023-09-29', 1, 1, 3, '2023-04-20 17:15:21', '2023-04-20 11:45:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Mayorista Nacional ', '2022-09-06 11:55:09', NULL),
(2, 'Mayorista Inscrito', '2022-09-06 11:55:29', NULL),
(3, 'Exportador', '2022-09-06 11:55:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria_producto`
--

CREATE TABLE `categoria_producto` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria_producto`
--

INSERT INTO `categoria_producto` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'INSTITUCIONAL', '2022-09-16 17:28:04', '2022-09-16 23:28:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(500) NOT NULL,
  `direccion` text NOT NULL,
  `telefono_empresa` varchar(15) NOT NULL,
  `rtn` varchar(14) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `latitud` varchar(45) DEFAULT NULL,
  `longitud` varchar(45) DEFAULT NULL,
  `url_imagen` varchar(250) DEFAULT NULL,
  `credito_inicial` double NOT NULL,
  `credito` double NOT NULL,
  `dias_credito` int(11) NOT NULL,
  `tipo_cliente_id` int(11) NOT NULL,
  `tipo_personalidad_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `vendedor` bigint(20) UNSIGNED NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `estado_cliente_id` int(11) NOT NULL,
  `municipio_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`id`, `nombre`, `direccion`, `telefono_empresa`, `rtn`, `correo`, `latitud`, `longitud`, `url_imagen`, `credito_inicial`, `credito`, `dias_credito`, `tipo_cliente_id`, `tipo_personalidad_id`, `categoria_id`, `vendedor`, `users_id`, `estado_cliente_id`, `municipio_id`, `created_at`, `updated_at`) VALUES
(1, 'CLIENTE GENERICO', 'Cliente ysado inicialmente para pruebas.', '00000000', '00000000000000', 'N/A', 'N/A', 'N/A', NULL, 0, 0, 0, 1, 1, 1, 2, 3, 1, 110, '2022-09-16 16:26:44', '2022-09-16 22:26:44'),
(2, 'Distribuciones Valencia', 'Colonia Godoy, Frente a Fuerza Área, Calle hacia el FHIS, Lote No.5', '22349877', '08011986138652', 'dvalenciahonduras@yahoo.com', '', '', NULL, 0, 100000, 90, 1, 1, 1, 2, 20, 1, 110, '2022-10-19 05:20:25', '2022-10-19 11:20:25'),
(3, 'Distribuciones Exclusivas S. de R.L. de C.V.', 'Colonia Palmira, Avenida República de Perú, Casa No.2001, Tegucigalpa', '22000000', '08019015779322', 'distribuciones exclusivas@yahoo.com', '', '', NULL, 0, 500000, 90, 1, 2, 1, 20, 20, 1, 110, '2022-10-24 05:27:07', '2022-10-24 11:27:07'),
(4, 'Grand Hotel Kennedy', 'Calle Escuela John F. Kennedy, frente a la escuela JFK, Colonia Kennedy', '3172-7922', '08011989000985', 'grandhotelkennedy@gmail.com', '', '', NULL, 0, 100000, 60, 1, 2, 1, 20, 20, 1, 110, '2022-12-12 04:31:04', '2022-12-12 10:31:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_autorizacion`
--

CREATE TABLE `codigo_autorizacion` (
  `id` int(11) NOT NULL,
  `codigo` bigint(20) NOT NULL,
  `users_id` bigint(20) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `codigo_exoneracion`
--

CREATE TABLE `codigo_exoneracion` (
  `id` int(11) NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `corrOrd` varchar(45) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comision`
--

CREATE TABLE `comision` (
  `id` int(11) NOT NULL,
  `comision_techo_id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `vendedor_id` bigint(20) UNSIGNED NOT NULL,
  `gananciaTotal` double DEFAULT NULL,
  `porcentaje` int(11) DEFAULT NULL,
  `monto_comison` double DEFAULT NULL,
  `estado_id` int(11) NOT NULL,
  `users_registro_id` bigint(20) UNSIGNED NOT NULL,
  `pagado` int(11) DEFAULT '0' COMMENT '0: NO PAGADO\n1: SI PAGADO',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comision_techo`
--

CREATE TABLE `comision_techo` (
  `id` int(11) NOT NULL,
  `monto_techo` double DEFAULT NULL,
  `vendedor_id` bigint(20) UNSIGNED NOT NULL,
  `meses_id` int(11) NOT NULL,
  `userRegistro` int(11) DEFAULT NULL,
  `estado_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comision_temp`
--

CREATE TABLE `comision_temp` (
  `id` int(11) NOT NULL,
  `comision_techo_id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `vendedor_id` bigint(20) UNSIGNED NOT NULL,
  `gananciaTotal` double DEFAULT NULL,
  `porcentaje` int(11) DEFAULT NULL,
  `monto_comison` double DEFAULT NULL,
  `estado_id` int(11) NOT NULL,
  `users_registro_id` bigint(20) UNSIGNED NOT NULL,
  `pagado` int(11) DEFAULT '0' COMMENT '0: NO PAGADO\n1: SI PAGADO',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `cai_retencion` varchar(45) DEFAULT NULL,
  `numero_secuencia_retencion` int(11) DEFAULT NULL,
  `numero_factura` varchar(90) NOT NULL,
  `codigo_cai` varchar(45) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `fecha_emision` date NOT NULL DEFAULT '2022-04-21',
  `fecha_recepcion` date NOT NULL DEFAULT '2022-04-21',
  `isv_compra` double NOT NULL,
  `sub_total` double NOT NULL,
  `total` double NOT NULL,
  `debito` double NOT NULL,
  `cai_id` int(11) DEFAULT NULL,
  `proveedores_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `tipo_compra_id` int(11) NOT NULL,
  `estado_compra_id` int(11) NOT NULL,
  `numero_orden` varchar(45) NOT NULL,
  `monto_retencion` double NOT NULL,
  `retenciones_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `cai_retencion`, `numero_secuencia_retencion`, `numero_factura`, `codigo_cai`, `fecha_vencimiento`, `fecha_emision`, `fecha_recepcion`, `isv_compra`, `sub_total`, `total`, `debito`, `cai_id`, `proveedores_id`, `users_id`, `tipo_compra_id`, `estado_compra_id`, `numero_orden`, `monto_retencion`, `retenciones_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, '0001', '0001', '2022-09-16', '2022-09-16', '2022-09-17', 60000, 400000, 460000, 460000, NULL, 1, 3, 2, 1, '2022-1', 0, 2, '2022-09-16 17:34:36', '2022-09-16 23:34:36'),
(2, NULL, NULL, '0010', 'NO APLICA', '2022-10-20', '2022-10-20', '2022-10-20', 0, 20000, 20000, 20000, NULL, 1, 20, 2, 1, '2022-2', 0, 2, '2022-10-20 05:14:40', '2022-10-20 11:14:40'),
(3, NULL, NULL, '0010', 'NO APLICA', '2022-10-21', '2022-10-21', '2022-10-21', 0, 24000, 24000, 24000, NULL, 1, 20, 2, 1, '2022-3', 0, 2, '2022-10-21 05:21:54', '2022-10-21 11:21:54'),
(4, NULL, NULL, '0010', 'NO APLICA', '2022-10-24', '2022-10-24', '2022-10-24', 0, 166286.64, 166286.64, 166286.64, NULL, 2, 20, 2, 1, '2022-4', 0, 2, '2022-10-24 05:06:24', '2022-10-24 11:06:24'),
(5, NULL, NULL, '0010', 'NO APLICA', '2022-10-24', '2022-10-24', '2022-10-24', 0, 16022.4, 16022.4, 16022.4, NULL, 2, 20, 2, 1, '2022-5', 0, 2, '2022-10-24 05:08:25', '2022-10-24 11:08:25'),
(6, NULL, NULL, '0010', 'NO APLICA', '2022-10-24', '2022-10-24', '2022-10-24', 0, 158906.88, 158906.88, 158906.88, NULL, 2, 20, 2, 1, '2022-6', 0, 2, '2022-10-24 05:12:47', '2022-10-24 11:12:47'),
(7, NULL, NULL, '0010', 'NO APLICA', '2022-11-29', '2022-11-29', '2022-11-29', 0, 100140, 100140, 100140, NULL, 2, 20, 2, 1, '2022-7', 0, 2, '2022-11-29 08:18:02', '2022-11-29 14:18:02'),
(8, NULL, NULL, '0010', 'NO APLICA', '2022-11-29', '2022-11-29', '2022-11-29', 0, 93210, 93210, 93210, NULL, 2, 20, 2, 1, '2022-8', 0, 2, '2022-11-29 08:19:31', '2022-11-29 14:19:31'),
(9, NULL, NULL, '0010', 'NO APLICA', '2022-11-29', '2022-11-29', '2022-11-29', 0, 68970, 68970, 68970, NULL, 2, 20, 2, 1, '2022-9', 0, 2, '2022-11-29 08:20:51', '2022-11-29 14:20:51'),
(10, NULL, NULL, '0010', 'NO APLICA', '2022-12-13', '2022-12-13', '2022-12-13', 0, 120000, 120000, 120000, NULL, 2, 20, 2, 1, '2022-10', 0, 2, '2022-12-13 10:57:56', '2022-12-13 16:57:56'),
(11, NULL, NULL, '0010', 'NO APLICA', '2022-12-19', '2022-12-19', '2022-12-19', 0, 68970, 68970, 68970, NULL, 2, 20, 2, 1, '2022-11', 0, 2, '2022-12-19 14:15:15', '2022-12-19 20:15:15'),
(12, NULL, NULL, '0010', 'NO APLICA', '2023-01-04', '2023-01-04', '2023-01-04', 0, 150000, 150000, 150000, NULL, 2, 20, 2, 1, '2023-12', 0, 2, '2023-01-04 05:12:08', '2023-01-04 11:12:08'),
(13, NULL, NULL, '0010', 'NO APLICA', '2023-01-19', '2023-01-19', '2023-01-19', 0, 111852, 111852, 111852, NULL, 2, 20, 2, 1, '2023-13', 0, 2, '2023-01-19 09:58:19', '2023-01-19 15:58:19'),
(14, NULL, NULL, '0010', 'NO APLICA', '2023-02-15', '2023-02-15', '2023-02-15', 0, 107200, 107200, 107200, NULL, 2, 20, 2, 1, '2023-14', 0, 2, '2023-02-15 05:09:40', '2023-02-15 11:09:40'),
(15, NULL, NULL, '0010', 'NO APLICA', '2023-02-15', '2023-02-15', '2023-02-15', 0, 174356.16, 174356.16, 174356.16, NULL, 2, 20, 2, 1, '2023-15', 0, 2, '2023-02-15 05:19:16', '2023-02-15 11:19:16'),
(16, NULL, NULL, '0010', 'NO APLICA', '2023-03-28', '2023-03-28', '2023-03-28', 0, 180000, 180000, 180000, NULL, 2, 20, 2, 1, '2023-16', 0, 2, '2023-03-27 23:25:20', '2023-03-28 05:25:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_has_producto`
--

CREATE TABLE `compra_has_producto` (
  `compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `precio_unidad` double NOT NULL,
  `cantidad_ingresada` int(11) NOT NULL,
  `cantidad_sin_asignar` int(11) DEFAULT NULL,
  `fecha_expiracion` date DEFAULT NULL,
  `sub_total_producto` double NOT NULL,
  `isv` double NOT NULL,
  `precio_total` double NOT NULL,
  `cantidad_disponible` int(11) NOT NULL,
  `unidad_compra_id` int(11) NOT NULL,
  `unidades_compra` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `compra_has_producto`
--

INSERT INTO `compra_has_producto` (`compra_id`, `producto_id`, `precio_unidad`, `cantidad_ingresada`, `cantidad_sin_asignar`, `fecha_expiracion`, `sub_total_producto`, `isv`, `precio_total`, `cantidad_disponible`, `unidad_compra_id`, `unidades_compra`, `updated_at`, `created_at`) VALUES
(1, 1, 400, 50, 0, '2022-09-17', 400000, 60000, 460000, 50, 23, 20, '2022-09-16 23:34:36', '2022-09-16 17:34:36'),
(2, 1, 40, 25, 0, '2022-02-21', 20000, 0, 20000, 25, 23, 20, '2022-10-20 11:14:40', '2022-10-20 05:14:40'),
(3, 1, 40, 30, 0, '2022-10-21', 24000, 0, 24000, 30, 23, 20, '2022-10-21 11:21:54', '2022-10-21 05:21:54'),
(4, 3, 186.42, 892, 0, '2022-10-24', 166286.64, 0, 166286.64, 892, 7, 1, '2022-10-24 11:06:24', '2022-10-24 05:06:24'),
(5, 2, 200.28, 80, 0, '2022-10-24', 16022.4, 0, 16022.4, 80, 7, 1, '2022-10-24 11:08:25', '2022-10-24 05:08:25'),
(6, 4, 137.94, 1152, 0, '2022-10-24', 158906.88, 0, 158906.88, 1152, 7, 1, '2022-10-24 11:12:47', '2022-10-24 05:12:47'),
(7, 5, 100.14, 1000, 0, '2022-11-29', 100140, 0, 100140, 1000, 7, 1, '2022-11-29 14:18:02', '2022-11-29 08:18:02'),
(8, 6, 93.21, 1000, 0, '2922-11-29', 93210, 0, 93210, 1000, 7, 1, '2022-11-29 14:19:31', '2022-11-29 08:19:31'),
(9, 7, 68.97, 1000, 0, '2022-11-29', 68970, 0, 68970, 1000, 7, 1, '2022-11-29 14:20:51', '2022-11-29 08:20:51'),
(10, 8, 120, 1000, 0, '2022-12-13', 120000, 0, 120000, 1000, 7, 1, '2022-12-13 16:57:56', '2022-12-13 10:57:56'),
(11, 7, 68.97, 1000, 0, '2022-12-19', 68970, 0, 68970, 1000, 7, 1, '2022-12-19 20:15:15', '2022-12-19 14:15:15'),
(12, 5, 100, 1500, 0, '2023-01-04', 150000, 0, 150000, 1500, 7, 1, '2023-01-04 11:12:08', '2023-01-04 05:12:08'),
(13, 6, 93.21, 1200, 0, '2023-01-19', 111852, 0, 111852, 1200, 7, 1, '2023-01-19 15:58:19', '2023-01-19 09:58:19'),
(14, 5, 100, 1072, 0, '2023-02-15', 107200, 0, 107200, 1072, 7, 1, '2023-02-15 11:09:40', '2023-02-15 05:09:40'),
(15, 7, 68.97, 2528, 0, '2023-02-15', 174356.16, 0, 174356.16, 2528, 7, 1, '2023-02-15 11:19:16', '2023-02-15 05:19:16'),
(16, 6, 90, 2000, 0, '2023-03-28', 180000, 0, 180000, 2000, 7, 1, '2023-03-28 05:25:20', '2023-03-27 23:25:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprovante_entrega`
--

CREATE TABLE `comprovante_entrega` (
  `id` int(11) NOT NULL,
  `comentario` text,
  `numero_comprovante` varchar(45) NOT NULL,
  `nombre_cliente` varchar(500) NOT NULL,
  `RTN` varchar(45) DEFAULT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_vencimineto` date NOT NULL,
  `sub_total` double NOT NULL,
  `sub_total_grabado` double NOT NULL,
  `sub_total_excento` double NOT NULL,
  `isv` double NOT NULL,
  `total` double NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `tipo_venta_id` int(11) NOT NULL,
  `vendedor` int(11) DEFAULT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `arregloIdInputs` text NOT NULL,
  `numeroInputs` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL COMMENT '1 : Activo\n2: Anulado',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprovante_has_producto`
--

CREATE TABLE `comprovante_has_producto` (
  `comprovante_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `lote_id` int(11) NOT NULL,
  `seccion_id` int(11) NOT NULL,
  `numero_unidades_resta_inventario` int(11) NOT NULL,
  `resta_inventario_total` int(11) NOT NULL,
  `unidad_medida_venta_id` int(11) NOT NULL,
  `precio_unidad` double NOT NULL,
  `cantidad` double NOT NULL,
  `cantidad_s` double NOT NULL,
  `cantidad_para_entregar` double NOT NULL,
  `sub_total` double NOT NULL,
  `isv` double NOT NULL,
  `total` double NOT NULL,
  `sub_total_s` double NOT NULL,
  `isv_s` double NOT NULL,
  `total_s` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `telefono` varchar(45) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`id`, `nombre`, `telefono`, `cliente_id`, `estado_id`, `created_at`, `updated_at`) VALUES
(1, 'N/A', '00000000', 1, 1, '2022-09-16 16:26:44', '2022-09-16 22:26:44'),
(2, 'N/A', '00000000', 1, 1, '2022-09-16 16:26:44', '2022-09-16 22:26:44'),
(3, 'Wilman Danilo Morales Zelaya', '31799945', 2, 1, '2022-10-19 05:20:25', '2022-10-19 11:20:25'),
(4, 'David Israel Gálvez Zelaya', '32088166', 2, 1, '2022-10-19 05:20:25', '2022-10-19 11:20:25'),
(5, 'Hilda Aracely Pacheco Montero', '99900000', 3, 1, '2022-10-24 05:27:07', '2022-10-24 11:27:07'),
(6, 'Karla Mariela Díaz Figueroa', '33344411', 4, 1, '2022-12-12 04:31:04', '2022-12-12 10:31:04');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion`
--

CREATE TABLE `cotizacion` (
  `id` int(11) NOT NULL,
  `nombre_cliente` varchar(500) NOT NULL,
  `RTN` varchar(45) DEFAULT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `sub_total` double NOT NULL,
  `sub_total_grabado` double NOT NULL DEFAULT '0',
  `sub_total_excento` double NOT NULL DEFAULT '0',
  `isv` double NOT NULL,
  `total` double NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `tipo_venta_id` int(11) NOT NULL,
  `vendedor` int(11) DEFAULT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `arregloIdInputs` text NOT NULL,
  `numeroInputs` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cotizacion`
--

INSERT INTO `cotizacion` (`id`, `nombre_cliente`, `RTN`, `fecha_emision`, `fecha_vencimiento`, `sub_total`, `sub_total_grabado`, `sub_total_excento`, `isv`, `total`, `cliente_id`, `tipo_venta_id`, `vendedor`, `users_id`, `arregloIdInputs`, `numeroInputs`, `created_at`, `updated_at`) VALUES
(1, 'CLIENTE 1', '00000000000000', '2022-09-16', '2022-09-16', 920, 0, 0, 138, 1058, 1, 1, NULL, 3, '[\"1\"]', 1, '2022-09-16 17:43:42', '2022-09-16 23:43:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion_has_producto`
--

CREATE TABLE `cotizacion_has_producto` (
  `cotizacion_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `indice` int(11) NOT NULL,
  `nombre_producto` varchar(200) NOT NULL,
  `nombre_bodega` varchar(45) NOT NULL,
  `precio_unidad` double NOT NULL,
  `cantidad` int(11) NOT NULL,
  `sub_total` double NOT NULL,
  `isv` double NOT NULL,
  `total` double NOT NULL,
  `bodega_id` int(11) NOT NULL,
  `seccion_id` int(11) NOT NULL,
  `resta_inventario` int(11) NOT NULL,
  `isv_producto` double NOT NULL,
  `unidad_medida_venta_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cotizacion_has_producto`
--

INSERT INTO `cotizacion_has_producto` (`cotizacion_id`, `producto_id`, `indice`, `nombre_producto`, `nombre_bodega`, `precio_unidad`, `cantidad`, `sub_total`, `isv`, `total`, `bodega_id`, `seccion_id`, `resta_inventario`, `isv_producto`, `unidad_medida_venta_id`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'PAPEL HIGIENICO - 00000', 'BODEGA INICIAL PRUEBA A 1', 460, 2, 920, 138, 1058, 1, 1, 2, 15, 1, '2022-09-16 17:43:42', '2022-09-16 23:43:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cvdolar`
--

CREATE TABLE `cvdolar` (
  `id` int(11) NOT NULL,
  `valor` double DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cvdolar`
--

INSERT INTO `cvdolar` (`id`, `valor`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 24.8098, 3, '2022-11-03 09:43:56', '2022-11-03 09:43:56'),
(2, 26.75, 3, '2022-11-03 09:54:41', '2022-11-03 09:54:41'),
(3, 24.8098, 3, '2022-11-03 11:03:56', '2022-11-03 11:03:56'),
(4, 24.8073, 20, '2022-11-04 10:29:02', '2022-11-04 10:29:02'),
(5, 24.7582, 20, '2022-11-29 14:13:15', '2022-11-29 14:13:15'),
(6, 24.7437, 20, '2022-12-07 10:22:50', '2022-12-07 10:22:50'),
(7, 24.7393, 20, '2022-12-12 10:31:57', '2022-12-12 10:31:57'),
(8, 24.7373, 20, '2022-12-13 16:34:07', '2022-12-13 16:34:07'),
(9, 24.7329, 20, '2022-12-15 11:20:15', '2022-12-15 11:20:15'),
(10, 24.7295, 20, '2022-12-19 20:09:59', '2022-12-19 20:09:59'),
(11, 24.7286, 20, '2022-12-20 10:58:11', '2022-12-20 10:58:11'),
(12, 24.7208, 20, '2023-01-02 12:55:33', '2023-01-02 12:55:33'),
(13, 24.7195, 20, '2023-01-04 10:34:01', '2023-01-04 10:34:01'),
(14, 24.7184, 20, '2023-01-06 12:27:24', '2023-01-06 12:27:24'),
(15, 24.7178, 20, '2023-01-09 21:51:29', '2023-01-09 21:51:29'),
(16, 24.717, 20, '2023-01-10 12:30:32', '2023-01-10 12:30:32'),
(17, 24.7157, 20, '2023-01-12 13:04:58', '2023-01-12 13:04:58'),
(18, 24.7101, 20, '2023-01-19 15:47:54', '2023-01-19 15:47:54'),
(19, 24.6783, 20, '2023-02-01 08:51:55', '2023-02-01 08:51:55'),
(20, 24.6759, 20, '2023-02-06 16:12:00', '2023-02-06 16:12:00'),
(21, 24.6747, 20, '2023-02-07 16:31:30', '2023-02-07 16:31:30'),
(22, 24.6726, 20, '2023-02-15 10:39:28', '2023-02-15 10:39:28'),
(23, 24.6741, 23, '2023-02-16 15:12:13', '2023-02-16 15:12:13'),
(24, 24.6771, 23, '2023-02-20 12:34:44', '2023-02-20 12:34:44'),
(25, 24.6803, 23, '2023-02-21 15:07:15', '2023-02-21 15:07:15'),
(26, 24.6836, 23, '2023-02-22 15:32:28', '2023-02-22 15:32:28'),
(27, 24.5645, 23, '2023-02-24 10:21:57', '2023-02-24 10:21:57'),
(28, 24.6892, 23, '2023-02-27 08:33:43', '2023-02-27 08:33:43'),
(29, 24.6912, 23, '2023-02-28 09:46:06', '2023-02-28 09:46:06'),
(30, 24.6962, 23, '2023-03-08 08:47:54', '2023-03-08 08:47:54'),
(31, 24.6972, 23, '2023-03-09 10:38:07', '2023-03-09 10:38:07'),
(32, 24.7006, 23, '2023-03-23 09:04:14', '2023-03-23 09:04:14'),
(33, 24.7016, 23, '2023-03-24 03:36:54', '2023-03-24 03:36:54'),
(34, 24.7025, 23, '2023-03-27 02:56:57', '2023-03-27 02:56:57'),
(35, 24.7031, 23, '2023-03-28 03:17:10', '2023-03-28 03:17:10'),
(36, 24.7037, 23, '2023-03-29 02:57:07', '2023-03-29 02:57:07'),
(37, 24.7035, 23, '2023-03-30 04:12:30', '2023-03-30 04:12:30'),
(38, 24.7034, 23, '2023-03-31 08:36:31', '2023-03-31 08:36:31'),
(39, 24.6979, 23, '2023-04-11 03:02:10', '2023-04-11 03:02:10'),
(40, 24.6961, 23, '2023-04-12 06:24:58', '2023-04-12 06:24:58'),
(41, 24.6915, 23, '2023-04-14 06:25:38', '2023-04-14 06:25:38'),
(42, 24.6885, 23, '2023-04-18 03:33:00', '2023-04-18 03:33:00'),
(43, 24.687, 23, '2023-04-19 11:23:00', '2023-04-19 11:23:00'),
(44, 24.6855, 23, '2023-04-20 11:43:28', '2023-04-20 11:43:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pais_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id`, `nombre`, `created_at`, `updated_at`, `pais_id`) VALUES
(1, 'ATLÁNTIDA', '2021-01-11 04:56:47', NULL, 1),
(2, 'COLÓN', '2021-01-11 04:56:55', NULL, 1),
(3, 'COMAYAGUA', '2021-01-11 03:57:53', NULL, 1),
(4, 'COPÁN', '2021-01-11 04:57:06', NULL, 1),
(5, 'CORTÉS', '2021-01-11 04:57:16', NULL, 1),
(6, 'CHOLUTECA', '2021-01-11 03:57:53', NULL, 1),
(7, 'EL PARAÍSO', '2021-01-11 04:57:34', NULL, 1),
(8, 'FRANCISCO MORAZÁN', '2021-01-11 04:57:47', NULL, 1),
(9, 'GRACIAS A DIOS', '2021-01-11 03:57:53', NULL, 1),
(10, 'INTIBUCÁ', '2021-01-11 04:58:01', NULL, 1),
(11, 'ISLAS DE LA BAHÍA', '2021-01-11 04:58:17', NULL, 1),
(12, 'LA PAZ', '2021-01-11 03:57:53', NULL, 1),
(13, 'LEMPIRA', '2021-01-11 03:57:53', NULL, 1),
(14, 'OCOTEPEQUE', '2021-01-11 03:57:53', NULL, 1),
(15, 'OLANCHO', '2021-01-11 03:57:53', NULL, 1),
(16, 'SANTA BÁRBARA', '2021-01-11 04:58:41', NULL, 1),
(17, 'VALLE', '2021-01-11 03:57:53', NULL, 1),
(18, 'YORO', '2021-01-11 03:57:53', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desglose`
--

CREATE TABLE `desglose` (
  `id` int(11) NOT NULL,
  `idFactura` int(11) NOT NULL,
  `numero_factura` varchar(45) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `producto` varchar(145) DEFAULT NULL,
  `precio_base` double DEFAULT NULL,
  `ultimo_costo_compra` double DEFAULT NULL,
  `unidad_venta` varchar(45) DEFAULT NULL,
  `cantidad` double DEFAULT NULL,
  `precio_unidad` double DEFAULT NULL,
  `gananciaUnidad` double DEFAULT NULL,
  `gananciatotal` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `sub_total` double DEFAULT NULL,
  `isv` double DEFAULT NULL,
  `seccion_id` double DEFAULT NULL,
  `seccion` varchar(45) DEFAULT NULL,
  `bodega` varchar(45) DEFAULT NULL,
  `vendedor_id` bigint(20) UNSIGNED NOT NULL,
  `estadoComisionado` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desglose_temp`
--

CREATE TABLE `desglose_temp` (
  `id` int(11) NOT NULL,
  `idFactura` int(11) NOT NULL,
  `numero_factura` varchar(45) DEFAULT NULL,
  `idProducto` int(11) DEFAULT NULL,
  `producto` varchar(145) DEFAULT NULL,
  `precio_base` double DEFAULT NULL,
  `ultimo_costo_compra` double DEFAULT NULL,
  `unidad_venta` varchar(45) DEFAULT NULL,
  `cantidad` double DEFAULT NULL,
  `precio_unidad` double DEFAULT NULL,
  `gananciaUnidad` double DEFAULT NULL,
  `gananciatotal` double DEFAULT NULL,
  `total` double DEFAULT NULL,
  `sub_total` double DEFAULT NULL,
  `isv` double DEFAULT NULL,
  `seccion_id` double DEFAULT NULL,
  `seccion` varchar(45) DEFAULT NULL,
  `bodega` varchar(45) DEFAULT NULL,
  `vendedor_id` bigint(20) UNSIGNED NOT NULL,
  `estadoComisionado` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega_programada`
--

CREATE TABLE `entrega_programada` (
  `id` int(11) NOT NULL,
  `fecha_entrega` date NOT NULL,
  `cantidad_entrega` int(11) NOT NULL,
  `cantidad_pendiente` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `factura_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `lote` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `enumeracion`
--

CREATE TABLE `enumeracion` (
  `id` int(11) NOT NULL,
  `numero` varchar(45) NOT NULL,
  `secuencia` int(11) NOT NULL,
  `numero_inicial` varchar(45) NOT NULL,
  `numero_final` varchar(45) NOT NULL,
  `cantidad_otorgada` varchar(45) NOT NULL,
  `cai_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `eliminado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `espera_has_producto`
--

CREATE TABLE `espera_has_producto` (
  `vale_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `index` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `cantidad_pendiente` int(11) NOT NULL,
  `precio` double NOT NULL,
  `unidad_medida_venta_id` int(11) NOT NULL,
  `sub_total` double NOT NULL,
  `isv` double NOT NULL,
  `total` double NOT NULL,
  `resta_inventario_total` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'activo', '2022-03-10 17:55:11', '2022-03-10 23:54:42'),
(2, 'inactivo', '2022-03-10 17:55:11', '2022-03-10 23:54:42'),
(3, 'pendiente de recibir', '2022-04-21 00:00:00', '2022-04-21 06:00:00'),
(4, 'recibido', '2022-04-21 00:00:00', '2022-04-21 06:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_cliente`
--

CREATE TABLE `estado_cliente` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_cliente`
--

INSERT INTO `estado_cliente` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Activo', '2022-05-16 18:44:02', '2022-05-17 00:43:36'),
(2, 'Inactivo', '2022-05-16 18:44:02', '2022-05-17 00:43:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_compra`
--

CREATE TABLE `estado_compra` (
  `id` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_compra`
--

INSERT INTO `estado_compra` (`id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'activo', '2022-05-10 00:00:00', '2022-05-10 06:00:00'),
(2, 'anulado', '2022-05-10 00:00:00', '2022-05-10 06:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_editar`
--

CREATE TABLE `estado_editar` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_editar`
--

INSERT INTO `estado_editar` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'DISPONIBLE PARA EDITAR', '2022-08-29 00:00:00', '2022-08-29 06:00:00'),
(2, 'NO DISPONIBLE PARA EDITAR', '2022-08-29 00:00:00', '2022-08-22 06:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_factura`
--

CREATE TABLE `estado_factura` (
  `id` int(11) NOT NULL,
  `estado` tinyint(4) NOT NULL COMMENT '1 se presenta\n2 no se presenta',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_factura`
--

INSERT INTO `estado_factura` (`id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 1, '2022-05-23 14:45:12', '2022-05-23 20:44:47'),
(2, 0, '2022-05-23 14:45:12', '2022-05-23 20:44:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_nota`
--

CREATE TABLE `estado_nota` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_producto`
--

CREATE TABLE `estado_producto` (
  `id` int(11) NOT NULL,
  `estado` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_producto`
--

INSERT INTO `estado_producto` (`id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Activado', '2022-05-10 20:18:52', '2022-05-11 02:18:11'),
(2, 'Inactivo', '2022-05-10 20:18:52', '2022-05-11 02:18:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_venta`
--

CREATE TABLE `estado_venta` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estado_venta`
--

INSERT INTO `estado_venta` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'activo', '2022-05-20 13:23:08', '2022-05-20 19:22:11'),
(2, 'anulado', '2022-05-20 13:23:08', '2022-05-20 19:22:11'),
(3, 'devolucion', '2022-05-20 13:23:08', '2022-05-20 19:22:11'),
(4, 'vencido', '2022-07-13 00:00:00', '2022-07-13 06:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id` int(11) NOT NULL,
  `numero_factura` varchar(45) NOT NULL,
  `cai` varchar(19) NOT NULL,
  `numero_secuencia_cai` int(11) NOT NULL,
  `nombre_cliente` varchar(500) NOT NULL,
  `rtn` varchar(45) DEFAULT NULL,
  `sub_total` double NOT NULL,
  `sub_total_grabado` double NOT NULL,
  `sub_total_excento` double NOT NULL DEFAULT '0',
  `isv` double NOT NULL,
  `total` double NOT NULL,
  `pendiente_cobro` double NOT NULL,
  `credito` double NOT NULL,
  `dias_credito` int(11) NOT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `tipo_pago_id` int(11) NOT NULL,
  `cai_id` int(11) NOT NULL,
  `estado_venta_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `vendedor` bigint(20) UNSIGNED NOT NULL,
  `monto_comision` double NOT NULL,
  `tipo_venta_id` int(11) NOT NULL,
  `estado_factura_id` int(11) NOT NULL,
  `comision_estado_pagado` tinyint(4) NOT NULL COMMENT '0: no hasido pagado al vendedor\n1: pagado al vendedor',
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `estado_editar` int(11) NOT NULL,
  `numero_orden_compra_id` int(11) DEFAULT NULL,
  `codigo_exoneracion_id` int(11) DEFAULT NULL,
  `codigo_autorizacion_id` int(11) DEFAULT NULL,
  `comprovante_entrega_id` int(11) DEFAULT NULL,
  `precio_dolar` double NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id`, `numero_factura`, `cai`, `numero_secuencia_cai`, `nombre_cliente`, `rtn`, `sub_total`, `sub_total_grabado`, `sub_total_excento`, `isv`, `total`, `pendiente_cobro`, `credito`, `dias_credito`, `fecha_emision`, `fecha_vencimiento`, `tipo_pago_id`, `cai_id`, `estado_venta_id`, `cliente_id`, `vendedor`, `monto_comision`, `tipo_venta_id`, `estado_factura_id`, `comision_estado_pagado`, `users_id`, `estado_editar`, `numero_orden_compra_id`, `codigo_exoneracion_id`, `codigo_autorizacion_id`, `comprovante_entrega_id`, `precio_dolar`, `created_at`, `updated_at`) VALUES
(1, '2022-1', '000-001-01-00000001', 1, 'Distribuciones Valencia', '08011986138652', 16132, 0, 0, 0, 16132, 16132, 16132, 0, '2022-11-04', '2022-11-04', 1, 7, 1, 2, 20, 8066, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.8073, '2022-11-04 04:36:01', '2022-11-04 10:36:01'),
(2, '2022-2', '000-001-01-00000002', 2, 'Distribuciones Valencia', '08011986138652', 23737.6, 0, 0, 0, 23737.6, 23737.6, 23737.6, 0, '2022-11-29', '2022-11-29', 1, 7, 1, 2, 20, 11868.8, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7582, '2022-11-29 08:28:02', '2022-11-29 14:28:02'),
(3, '2022-3', '000-001-01-00000003', 3, 'Distribuciones Valencia', '08011986138652', 22267.2, 0, 0, 0, 22267.2, 22267.2, 22267.2, 0, '2022-12-07', '2022-12-07', 1, 7, 2, 2, 20, 11133.6, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7437, '2022-12-07 16:25:18', '2022-12-07 16:25:18'),
(4, '2022-4', '000-001-01-00000004', 4, 'Distribuciones Valencia', '08011986138652', 23817.6, 0, 0, 0, 23817.6, 23817.6, 23817.6, 0, '2022-12-12', '2022-12-12', 1, 7, 1, 2, 20, 11908.8, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7393, '2022-12-12 04:44:29', '2022-12-12 10:44:29'),
(5, '2022-5', '000-001-01-00000005', 5, 'Grand Hotel Kennedy', '08011989000985', 24277.5, 0, 0, 0, 24277.5, 24277.5, 24277.5, 0, '2022-12-12', '2022-12-12', 1, 7, 1, 4, 20, 12138.75, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7393, '2022-12-12 06:27:39', '2022-12-12 12:27:39'),
(6, '2022-6', '000-001-01-00000006', 6, 'Distribuciones Valencia', '08011986138652', 24396.5, 0, 0, 0, 24396.5, 24396.5, 24396.5, 0, '2022-12-13', '2022-12-13', 1, 7, 1, 2, 20, 12198.25, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7373, '2022-12-13 10:37:21', '2022-12-13 16:37:21'),
(7, '2022-7', '000-001-01-00000007', 7, 'Grand Hotel Kennedy', '08011989000985', 23359.6, 0, 0, 0, 23359.6, 23359.6, 23359.6, 0, '2022-12-13', '2022-12-13', 1, 7, 1, 4, 20, 11679.8, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7373, '2022-12-13 11:01:55', '2022-12-13 17:01:55'),
(8, '2022-8', '000-001-01-00000008', 8, 'Distribuciones Valencia', '08011986138652', 22091.4, 0, 0, 0, 22091.4, 22091.4, 22091.4, 0, '2022-12-14', '2022-12-14', 1, 7, 1, 2, 20, 11045.7, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7373, '2022-12-14 10:29:49', '2022-12-14 16:29:49'),
(9, '2022-9', '000-001-01-00000009', 9, 'Distribuciones Valencia', '08011986138652', 23321.4, 0, 0, 0, 23321.4, 23321.4, 23321.4, 0, '2022-12-15', '2022-12-15', 1, 7, 1, 2, 20, 11660.7, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7329, '2022-12-15 05:22:55', '2022-12-15 11:22:55'),
(10, '2022-10', '000-001-01-00000010', 10, 'Distribuciones Valencia', '08011986138652', 22742.5, 0, 0, 0, 22742.5, 22742.5, 22742.5, 0, '2022-12-19', '2022-12-19', 1, 7, 1, 2, 20, 11371.25, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7295, '2022-12-19 14:18:18', '2022-12-19 20:18:18'),
(11, '2022-11', '000-001-01-00000011', 11, 'Distribuciones Valencia', '08011986138652', 23817.6, 0, 0, 0, 23817.6, 23817.6, 23817.6, 0, '2022-12-20', '2022-12-20', 1, 7, 1, 2, 20, 11908.8, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7286, '2022-12-20 09:17:41', '2022-12-20 15:17:41'),
(12, '2023-12', '000-001-01-00000012', 12, 'Distribuciones Valencia', '08011986138652', 23198.5, 0, 0, 0, 23198.5, 23198.5, 23198.5, 0, '2023-01-02', '2023-01-02', 1, 7, 1, 2, 20, 11599.25, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7208, '2023-01-02 07:04:25', '2023-01-02 13:04:25'),
(13, '2023-13', '000-001-01-00000013', 13, 'Distribuciones Valencia', '08011986138652', 21580, 0, 0, 0, 21580, 21580, 21580, 0, '2023-01-04', '2023-01-04', 1, 7, 1, 2, 20, 10790, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7195, '2023-01-04 04:35:21', '2023-01-04 10:35:21'),
(14, '2023-14', '000-001-01-00000014', 14, 'Grand Hotel Kennedy', '08011989000985', 23738, 0, 0, 0, 23738, 23738, 23738, 0, '2023-01-04', '2023-01-04', 1, 7, 1, 4, 20, 11869, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7195, '2023-01-04 05:14:50', '2023-01-04 11:14:50'),
(15, '2023-15', '000-001-01-00000015', 15, 'Distribuciones Valencia', '08011986138652', 23738, 0, 0, 0, 23738, 23738, 23738, 0, '2023-01-06', '2023-01-06', 1, 7, 1, 2, 20, 11869, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7184, '2023-01-06 06:30:24', '2023-01-06 12:30:24'),
(16, '2023-16', '000-001-01-00000016', 16, 'Distribuciones Valencia', '08011986138652', 24600, 0, 0, 0, 24600, 24600, 24600, 0, '2023-01-09', '2023-01-09', 1, 7, 1, 2, 20, 12300, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7178, '2023-01-09 15:53:06', '2023-01-09 21:53:06'),
(17, '2023-17', '000-001-01-00000017', 17, 'Grand Hotel Kennedy', '08011989000985', 22037.5, 0, 0, 0, 22037.5, 22037.5, 22037.5, 0, '2023-01-09', '2023-01-09', 1, 7, 1, 4, 20, 11018.75, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7178, '2023-01-09 15:55:30', '2023-01-09 21:55:30'),
(18, '2023-18', '000-001-01-00000018', 18, 'Distribuciones Valencia', '08011986138652', 24600, 0, 0, 0, 24600, 24600, 24600, 0, '2023-01-10', '2023-01-10', 1, 7, 1, 2, 20, 12300, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.717, '2023-01-10 06:31:35', '2023-01-10 12:31:35'),
(19, '2023-19', '000-001-01-00000019', 19, 'Grand Hotel Kennedy', '08011989000985', 21525, 0, 0, 0, 21525, 21525, 21525, 0, '2023-01-10', '2023-01-10', 1, 7, 1, 4, 20, 10762.5, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.717, '2023-01-10 06:35:55', '2023-01-10 12:35:55'),
(20, '2023-20', '000-001-01-00000020', 20, 'Distribuciones Valencia', '08011986138652', 23817.6, 0, 0, 0, 23817.6, 23817.6, 23817.6, 0, '2023-01-12', '2023-01-12', 1, 7, 1, 2, 20, 11908.8, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7157, '2023-01-12 07:05:47', '2023-01-12 13:05:47'),
(21, '2023-21', '000-001-01-00000021', 21, 'Distribuciones Valencia', '08011986138652', 22550, 0, 0, 0, 22550, 22550, 22550, 0, '2023-01-19', '2023-01-19', 1, 7, 1, 2, 20, 11275, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.7101, '2023-01-19 10:01:17', '2023-01-19 16:01:17'),
(22, '2023-22', '000-001-01-00000022', 22, 'Distribuciones Valencia', '08011986138652', 1654, 0, 0, 0, 1654, 1654, 1654, 0, '2023-02-01', '2023-02-01', 1, 7, 1, 2, 20, 827, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.6783, '2023-02-01 02:53:38', '2023-02-01 08:53:38'),
(23, '2023-23', '000-001-01-00000023', 23, 'Distribuciones Valencia', '08011986138652', 18450, 0, 0, 0, 18450, 18450, 18450, 0, '2023-02-06', '2023-02-06', 1, 7, 1, 2, 20, 9225, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.6759, '2023-02-06 10:16:22', '2023-02-06 16:16:22'),
(24, '2023-24', '000-001-01-00000024', 24, 'Distribuciones Valencia', '08011986138652', 15375, 0, 0, 0, 15375, 15375, 15375, 0, '2023-02-07', '2023-02-07', 1, 7, 1, 2, 20, 7687.5, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.6747, '2023-02-07 10:33:16', '2023-02-07 16:33:16'),
(25, '2023-25', '000-001-01-00000025', 25, 'Distribuciones Valencia', '08011986138652', 23062.5, 0, 0, 0, 23062.5, 23062.5, 23062.5, 0, '2023-02-15', '2023-02-15', 1, 7, 1, 2, 20, 11531.25, 1, 1, 0, 20, 1, NULL, NULL, NULL, NULL, 24.6726, '2023-02-15 05:44:43', '2023-02-15 11:44:43'),
(26, '2023-26', '000-001-01-00000026', 26, 'Distribuciones Valencia', '08011986138652', 19577.5, 0, 0, 0, 19577.5, 19577.5, 19577.5, 0, '2023-02-16', '2023-02-16', 1, 7, 1, 2, 20, 9788.75, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.6741, '2023-02-16 09:46:56', '2023-02-16 15:46:56'),
(27, '2023-27', '000-001-01-00000027', 27, 'Distribuciones Valencia', '08011986138652', 23238.7, 0, 0, 0, 23238.7, 23238.7, 23238.7, 0, '2023-02-20', '2023-02-20', 1, 7, 1, 2, 20, 11619.35, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.6771, '2023-02-20 06:36:39', '2023-02-20 12:36:39'),
(28, '2023-28', '000-001-01-00000028', 28, 'Distribuciones Valencia', '08011986138652', 20757.7, 0, 0, 0, 20757.7, 20757.7, 20757.7, 0, '2023-02-21', '2023-02-21', 1, 7, 1, 2, 23, 10378.85, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.6803, '2023-02-21 09:13:11', '2023-02-21 15:13:11'),
(29, '2023-29', '000-001-01-00000029', 29, 'Distribuciones Valencia', '08011986138652', 23983, 0, 0, 0, 23983, 23983, 23983, 0, '2023-02-22', '2023-02-22', 1, 7, 1, 2, 23, 11991.5, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.6836, '2023-02-22 09:34:29', '2023-02-22 15:34:29'),
(30, '2023-30', '000-001-01-00000030', 30, 'Distribuciones Valencia', '08011986138652', 23630.1, 0, 0, 0, 23630.1, 23630.1, 23630.1, 0, '2023-02-24', '2023-02-24', 1, 7, 1, 2, 23, 11815.05, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.5645, '2023-02-24 05:02:47', '2023-02-24 11:02:47'),
(31, '2023-31', '000-001-01-00000031', 31, 'Distribuciones Valencia', '08011986138652', 22011.6, 0, 0, 0, 22011.6, 22011.6, 22011.6, 0, '2023-02-27', '2023-02-27', 1, 7, 1, 2, 23, 11005.8, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.6892, '2023-02-27 02:37:24', '2023-02-27 08:37:24'),
(32, '2023-32', '000-001-01-00000032', 32, 'Distribuciones Valencia', '08011986138652', 20501, 0, 0, 0, 20501, 20501, 20501, 0, '2023-02-28', '2023-02-28', 1, 7, 1, 2, 23, 10250.5, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.6912, '2023-02-28 03:49:26', '2023-02-28 09:49:26'),
(33, '2023-33', '000-001-01-00000033', 33, 'Distribuciones Valencia', '08011986138652', 20501, 0, 0, 0, 20501, 20501, 20501, 0, '2023-03-08', '2023-03-08', 1, 7, 1, 2, 23, 10250.5, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.6962, '2023-03-08 02:49:11', '2023-03-08 08:49:11'),
(34, '2023-34', '000-001-01-00000034', 34, 'Distribuciones Valencia', '08011986138652', 23306.4, 0, 0, 0, 23306.4, 23306.4, 23306.4, 0, '2023-03-09', '2023-03-09', 1, 7, 1, 2, 23, 11653.2, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.6972, '2023-03-09 04:49:19', '2023-03-09 10:49:19'),
(35, '2023-35', '000-001-01-00000035', 35, 'Distribuciones Valencia', '08011986138652', 24601.2, 0, 0, 0, 24601.2, 24601.2, 24601.2, 0, '2023-03-23', '2023-03-23', 1, 7, 1, 2, 23, 12300.6, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.7006, '2023-03-23 03:13:20', '2023-03-23 09:13:20'),
(36, '2023-36', '000-001-01-00000036', 36, 'Distribuciones Valencia', '08011986138652', 23198.5, 0, 0, 0, 23198.5, 23198.5, 23198.5, 0, '2023-03-24', '2023-03-24', 1, 7, 1, 2, 23, 11599.25, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.7016, '2023-03-23 22:04:28', '2023-03-24 04:04:28'),
(37, '2023-37', '000-001-01-00000037', 37, 'Distribuciones Valencia', '08011986138652', 21525, 0, 0, 0, 21525, 21525, 21525, 0, '2023-03-27', '2023-03-27', 1, 7, 1, 2, 23, 10762.5, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.7025, '2023-03-26 21:01:04', '2023-03-27 03:01:04'),
(38, '2023-38', '000-001-01-00000038', 38, 'Distribuciones Valencia', '08011986138652', 22329, 0, 0, 0, 22329, 22329, 22329, 0, '2023-03-28', '2023-03-28', 1, 7, 2, 2, 23, 11164.5, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.7031, '2023-03-28 10:02:24', '2023-03-28 04:32:24'),
(39, '2023-39', '000-001-01-00000039', 39, 'Distribuciones Valencia', '08011986138652', 23306.4, 0, 0, 0, 23306.4, 23306.4, 23306.4, 0, '2023-03-28', '2023-03-28', 1, 7, 2, 2, 23, 11653.2, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.7031, '2023-03-28 11:57:43', '2023-03-28 06:27:43'),
(40, '2023-40', '000-001-01-00000040', 40, 'Distribuciones Valencia', '08011986138652', 23958, 0, 0, 0, 23958, 23958, 23958, 0, '2023-03-28', '2023-03-28', 1, 7, 1, 2, 23, 11979, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.7031, '2023-03-28 00:24:45', '2023-03-28 06:24:45'),
(41, '2023-41', '000-001-01-00000041', 41, 'Distribuciones Valencia', '08011986138652', 20790, 0, 0, 0, 20790, 20790, 20790, 0, '2023-03-29', '2023-03-29', 1, 7, 1, 2, 23, 10395, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.7037, '2023-03-28 21:01:21', '2023-03-29 03:01:21'),
(42, '2023-42', '000-001-01-00000042', 42, 'Distribuciones Valencia', '08011986138652', 22572, 0, 0, 0, 22572, 22572, 22572, 0, '2023-03-30', '2023-03-30', 1, 7, 1, 2, 23, 11286, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.7035, '2023-03-29 22:23:36', '2023-03-30 04:23:36'),
(43, '2023-43', '000-001-01-00000043', 43, 'Distribuciones Valencia', '08011986138652', 22869, 0, 0, 0, 22869, 22869, 22869, 0, '2023-03-31', '2023-03-31', 1, 7, 1, 2, 23, 11434.5, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.7034, '2023-03-31 02:39:22', '2023-03-31 08:39:22'),
(44, '2023-44', '000-001-01-00000044', 44, 'Distribuciones Valencia', '08011986138652', 24255, 0, 0, 0, 24255, 24255, 24255, 0, '2023-04-11', '2023-04-11', 1, 7, 1, 2, 23, 12127.5, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.6979, '2023-04-10 21:05:52', '2023-04-11 03:05:52'),
(45, '2023-45', '000-001-01-00000045', 45, 'Distribuciones Valencia', '08011986138652', 24057, 0, 0, 0, 24057, 24057, 24057, 0, '2023-04-12', '2023-04-12', 1, 7, 1, 2, 23, 12028.5, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.6961, '2023-04-12 00:32:24', '2023-04-12 06:32:24'),
(46, '2023-46', '000-001-01-00000046', 46, 'Distribuciones Valencia', '08011986138652', 23265, 0, 0, 0, 23265, 23265, 23265, 0, '2023-04-14', '2023-04-14', 1, 7, 1, 2, 23, 11632.5, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.6915, '2023-04-14 00:26:54', '2023-04-14 06:26:54'),
(47, '2023-47', '000-001-01-00000047', 47, 'Distribuciones Valencia', '08011986138652', 24061.7, 0, 0, 0, 24061.7, 24061.7, 24061.7, 0, '2023-04-18', '2023-04-18', 1, 7, 1, 2, 23, 12030.85, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.6885, '2023-04-17 22:38:08', '2023-04-18 04:38:08'),
(48, '2023-48', '000-001-01-00000048', 48, 'Distribuciones Valencia', '08011986138652', 23738, 0, 0, 0, 23738, 23738, 23738, 0, '2023-04-19', '2023-04-19', 1, 7, 1, 2, 23, 11869, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.687, '2023-04-19 05:50:21', '2023-04-19 11:50:21'),
(49, '2023-49', '000-001-01-00000049', 49, 'Distribuciones Valencia', '08011986138652', 21580, 0, 0, 0, 21580, 21580, 21580, 0, '2023-04-20', '2023-04-20', 1, 7, 1, 2, 23, 10790, 1, 1, 0, 23, 1, NULL, NULL, NULL, NULL, 24.6855, '2023-04-20 05:45:21', '2023-04-20 11:45:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas_pagadas`
--

CREATE TABLE `facturas_pagadas` (
  `id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `comision_id` int(11) NOT NULL,
  `estado_pagado` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `img_producto`
--

CREATE TABLE `img_producto` (
  `id` int(11) NOT NULL,
  `url_img` varchar(250) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `producto_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `img_producto`
--

INSERT INTO `img_producto` (`id`, `url_img`, `created_at`, `updated_at`, `producto_id`, `users_id`) VALUES
(1, 'IMG_1663392728-1.jpg', '2022-09-16 17:32:08', NULL, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia`
--

CREATE TABLE `incidencia` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `url_img` varchar(250) DEFAULT NULL,
  `recibido_bodega_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `incidencia_compra`
--

CREATE TABLE `incidencia_compra` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `url_img` varchar(250) DEFAULT NULL,
  `compra_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interes`
--

CREATE TABLE `interes` (
  `id` int(11) NOT NULL,
  `monto` double NOT NULL,
  `fecha` date NOT NULL,
  `estado_venta_id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_anulado` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listado`
--

CREATE TABLE `listado` (
  `id` int(11) NOT NULL,
  `numero` varchar(45) NOT NULL,
  `secuencia` int(11) NOT NULL,
  `numero_inicial` varchar(45) NOT NULL,
  `numero_final` varchar(45) NOT NULL,
  `cantidad_otorgada` varchar(45) NOT NULL,
  `cai_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `eliminado` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_credito`
--

CREATE TABLE `log_credito` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(200) NOT NULL,
  `monto` double NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `factura_id` int(11) DEFAULT NULL,
  `cliente_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_estado`
--

CREATE TABLE `log_estado` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) NOT NULL,
  `estado_anterior_compra` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_estado_factura`
--

CREATE TABLE `log_estado_factura` (
  `id` int(11) NOT NULL,
  `motivo` text NOT NULL,
  `factura_id` int(11) NOT NULL,
  `estado_venta_id_anterior` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `log_estado_factura`
--

INSERT INTO `log_estado_factura` (`id`, `motivo`, `factura_id`, `estado_venta_id_anterior`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 'Anular por instrucción de aduana.', 3, 1, 3, '2022-12-07 10:25:18', '2022-12-07 16:25:18'),
(2, 'Producto erroneo en factura. Debe ser papel higienico. Error de codigo al momento de facturar', 38, 1, 23, '2023-03-27 22:32:24', '2023-03-28 04:32:24'),
(3, 'Debe ser de 400m', 39, 1, 23, '2023-03-28 00:27:43', '2023-03-28 06:27:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_translado`
--

CREATE TABLE `log_translado` (
  `id` int(11) NOT NULL,
  `origen` int(11) NOT NULL,
  `destino` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL COMMENT 'la cantidad, realmente es el numero de unidades restadas o devueltas al inventario unidad base 1.',
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `factura_id` int(11) DEFAULT NULL,
  `ajuste_id` int(11) DEFAULT NULL,
  `compra_id` int(11) DEFAULT NULL,
  `unidad_medida_venta_id` int(11) DEFAULT NULL,
  `comprovante_entrega_id` int(11) DEFAULT NULL,
  `vale_id` int(11) DEFAULT NULL,
  `nota_credito_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `log_translado`
--

INSERT INTO `log_translado` (`id`, `origen`, `destino`, `cantidad`, `users_id`, `descripcion`, `factura_id`, `ajuste_id`, `compra_id`, `unidad_medida_venta_id`, `comprovante_entrega_id`, `vale_id`, `nota_credito_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 600, 3, 'Ingreso de producto por compra', NULL, NULL, 1, NULL, NULL, NULL, NULL, '2022-09-16 17:35:41', '2022-09-16 23:35:41'),
(2, 2, NULL, 400, 3, 'Ingreso de producto por compra', NULL, NULL, 1, NULL, NULL, NULL, NULL, '2022-09-16 17:36:04', '2022-09-16 23:36:04'),
(3, 1, 3, 300, 3, 'Translado de bodega', NULL, NULL, NULL, 2, NULL, NULL, NULL, '2022-09-16 17:38:32', '2022-09-16 23:38:32'),
(4, 3, NULL, 2, 3, 'Venta de producto', 1, NULL, NULL, 1, NULL, NULL, NULL, '2022-09-16 17:53:09', '2022-09-16 23:53:09'),
(5, 2, NULL, 350, 3, 'Venta de producto', 2, NULL, NULL, 1, NULL, NULL, NULL, '2022-09-16 17:56:26', '2022-09-16 23:56:26'),
(6, 1, NULL, 2, 3, 'Venta de producto', 3, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-01 04:03:03', '2022-10-01 10:03:03'),
(7, 3, NULL, 298, 20, 'Venta de producto', 2, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-18 07:32:13', '2022-10-18 13:32:13'),
(8, 1, NULL, 2, 20, 'Venta de producto', 2, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-18 07:32:13', '2022-10-18 13:32:13'),
(9, 1, NULL, 296, 20, 'Venta de producto', 4, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-18 07:44:05', '2022-10-18 13:44:05'),
(10, 4, NULL, 500, 20, 'Ingreso de producto por compra', NULL, NULL, 2, NULL, NULL, NULL, NULL, '2022-10-20 05:22:34', '2022-10-20 11:22:34'),
(11, 2, NULL, 50, 20, 'Venta de producto', 5, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-20 05:23:32', '2022-10-20 11:23:32'),
(12, 4, NULL, 246, 20, 'Venta de producto', 5, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-20 05:23:32', '2022-10-20 11:23:32'),
(13, 5, NULL, 600, 20, 'Ingreso de producto por compra', NULL, NULL, 3, NULL, NULL, NULL, NULL, '2022-10-21 05:22:39', '2022-10-21 11:22:39'),
(14, 4, NULL, 254, 20, 'Venta de producto', 6, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-21 05:23:17', '2022-10-21 11:23:17'),
(15, 5, NULL, 42, 20, 'Venta de producto', 6, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-21 05:23:17', '2022-10-21 11:23:17'),
(16, 5, NULL, 6, 3, 'Venta de producto', 7, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-21 05:35:09', '2022-10-21 11:35:09'),
(17, 5, NULL, 296, 20, 'Venta de producto', 8, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-21 05:57:01', '2022-10-21 11:57:01'),
(18, 6, NULL, 892, 20, 'Ingreso de producto por compra', NULL, NULL, 4, NULL, NULL, NULL, NULL, '2022-10-24 05:18:16', '2022-10-24 11:18:16'),
(19, 7, NULL, 80, 20, 'Ingreso de producto por compra', NULL, NULL, 5, NULL, NULL, NULL, NULL, '2022-10-24 05:19:07', '2022-10-24 11:19:07'),
(20, 8, NULL, 1152, 20, 'Ingreso de producto por compra', NULL, NULL, 6, NULL, NULL, NULL, NULL, '2022-10-24 05:19:39', '2022-10-24 11:19:39'),
(21, 8, NULL, 150, 3, 'Venta de producto', 9, NULL, NULL, 5, NULL, NULL, NULL, '2022-10-25 04:56:17', '2022-10-25 10:56:17'),
(22, 5, NULL, 100, 3, 'Venta de producto', 10, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-25 04:58:41', '2022-10-25 10:58:41'),
(23, 6, NULL, 100, 3, 'Venta de producto', 10, NULL, NULL, 4, NULL, NULL, NULL, '2022-10-25 04:58:41', '2022-10-25 10:58:41'),
(24, 6, NULL, 150, 3, 'Venta de producto', 11, NULL, NULL, 4, NULL, NULL, NULL, '2022-10-25 14:04:11', '2022-10-25 20:04:11'),
(25, 5, NULL, 50, 3, 'Venta de producto', 11, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-25 14:04:11', '2022-10-25 20:04:11'),
(26, 8, NULL, 100, 3, 'Venta de producto', 11, NULL, NULL, 5, NULL, NULL, NULL, '2022-10-25 14:04:11', '2022-10-25 20:04:11'),
(27, 5, NULL, 296, 20, 'Venta de producto', 12, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-27 03:38:18', '2022-10-27 09:38:18'),
(28, 5, NULL, 296, 20, 'Venta de producto', 13, NULL, NULL, 1, NULL, NULL, NULL, '2022-10-27 03:43:59', '2022-10-27 09:43:59'),
(29, 5, NULL, 1, 3, 'Venta de producto', 14, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-03 04:03:17', '2022-11-03 10:03:17'),
(30, 5, NULL, 5, 3, 'Venta de producto', 15, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-03 04:08:16', '2022-11-03 10:08:16'),
(31, 5, NULL, 296, 20, 'Venta de producto', 1, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-03 05:20:59', '2022-11-03 11:20:59'),
(32, 5, NULL, 1, 3, 'Venta de producto', 2, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-03 05:26:10', '2022-11-03 11:26:10'),
(33, 5, NULL, 5, 3, 'Venta de producto', 3, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-03 08:21:00', '2022-11-03 14:21:00'),
(34, 5, NULL, 5, 3, 'Venta de producto', 1, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-03 17:25:41', '2022-11-03 23:25:41'),
(35, 5, NULL, 296, 20, 'Venta de producto', 1, NULL, NULL, 1, NULL, NULL, NULL, '2022-11-04 04:36:01', '2022-11-04 10:36:01'),
(36, 9, NULL, 1000, 20, 'Ingreso de producto por compra', NULL, NULL, 7, NULL, NULL, NULL, NULL, '2022-11-29 08:23:11', '2022-11-29 14:23:11'),
(37, 10, NULL, 1000, 20, 'Ingreso de producto por compra', NULL, NULL, 8, NULL, NULL, NULL, NULL, '2022-11-29 08:24:28', '2022-11-29 14:24:28'),
(38, 11, NULL, 1000, 20, 'Ingreso de producto por compra', NULL, NULL, 9, NULL, NULL, NULL, NULL, '2022-11-29 08:25:04', '2022-11-29 14:25:04'),
(39, 9, NULL, 144, 20, 'Venta de producto', 2, NULL, NULL, 6, NULL, NULL, NULL, '2022-11-29 08:28:02', '2022-11-29 14:28:02'),
(40, 10, NULL, 80, 20, 'Venta de producto', 2, NULL, NULL, 7, NULL, NULL, NULL, '2022-11-29 08:28:02', '2022-11-29 14:28:02'),
(41, 11, NULL, 144, 20, 'Venta de producto', 3, NULL, NULL, 8, NULL, NULL, NULL, '2022-12-07 04:26:57', '2022-12-07 10:26:57'),
(42, 9, NULL, 96, 20, 'Venta de producto', 3, NULL, NULL, 6, NULL, NULL, NULL, '2022-12-07 04:26:57', '2022-12-07 10:26:57'),
(43, 9, 9, 96, 3, 'Factura Anulada', 3, NULL, NULL, 6, NULL, NULL, NULL, '2022-12-07 10:25:18', '2022-12-07 16:25:18'),
(44, 11, 11, 144, 3, 'Factura Anulada', 3, NULL, NULL, 8, NULL, NULL, NULL, '2022-12-07 10:25:18', '2022-12-07 16:25:18'),
(45, 11, NULL, 288, 20, 'Venta de producto', 4, NULL, NULL, 8, NULL, NULL, NULL, '2022-12-12 04:44:29', '2022-12-12 10:44:29'),
(46, 9, NULL, 225, 20, 'Venta de producto', 5, NULL, NULL, 6, NULL, NULL, NULL, '2022-12-12 06:27:39', '2022-12-12 12:27:39'),
(47, 11, NULL, 295, 20, 'Venta de producto', 6, NULL, NULL, 8, NULL, NULL, NULL, '2022-12-13 10:37:21', '2022-12-13 16:37:21'),
(48, 12, NULL, 1000, 20, 'Ingreso de producto por compra', NULL, NULL, 10, NULL, NULL, NULL, NULL, '2022-12-13 11:00:25', '2022-12-13 17:00:25'),
(49, 12, NULL, 120, 20, 'Venta de producto', 7, NULL, NULL, 9, NULL, NULL, NULL, '2022-12-13 11:01:55', '2022-12-13 17:01:55'),
(50, 9, NULL, 80, 20, 'Venta de producto', 7, NULL, NULL, 6, NULL, NULL, NULL, '2022-12-13 11:01:55', '2022-12-13 17:01:55'),
(51, 12, NULL, 180, 20, 'Venta de producto', 8, NULL, NULL, 9, NULL, NULL, NULL, '2022-12-14 10:29:49', '2022-12-14 16:29:49'),
(52, 11, NULL, 282, 20, 'Venta de producto', 9, NULL, NULL, 8, NULL, NULL, NULL, '2022-12-15 05:22:55', '2022-12-15 11:22:55'),
(53, 13, NULL, 1000, 20, 'Ingreso de producto por compra', NULL, NULL, 11, NULL, NULL, NULL, NULL, '2022-12-19 14:16:14', '2022-12-19 20:16:14'),
(54, 11, NULL, 135, 20, 'Venta de producto', 10, NULL, NULL, 8, NULL, NULL, NULL, '2022-12-19 14:18:18', '2022-12-19 20:18:18'),
(55, 13, NULL, 140, 20, 'Venta de producto', 10, NULL, NULL, 8, NULL, NULL, NULL, '2022-12-19 14:18:18', '2022-12-19 20:18:18'),
(56, 13, NULL, 288, 20, 'Venta de producto', 11, NULL, NULL, 8, NULL, NULL, NULL, '2022-12-20 09:17:41', '2022-12-20 15:17:41'),
(57, 9, NULL, 215, 20, 'Venta de producto', 12, NULL, NULL, 6, NULL, NULL, NULL, '2023-01-02 07:04:25', '2023-01-02 13:04:25'),
(58, 9, NULL, 200, 20, 'Venta de producto', 13, NULL, NULL, 6, NULL, NULL, NULL, '2023-01-04 04:35:21', '2023-01-04 10:35:21'),
(59, 14, NULL, 1500, 20, 'Ingreso de producto por compra', NULL, NULL, 12, NULL, NULL, NULL, NULL, '2023-01-04 05:13:27', '2023-01-04 11:13:27'),
(60, 14, NULL, 220, 20, 'Venta de producto', 14, NULL, NULL, 6, NULL, NULL, NULL, '2023-01-04 05:14:50', '2023-01-04 11:14:50'),
(61, 9, NULL, 136, 20, 'Venta de producto', 15, NULL, NULL, 6, NULL, NULL, NULL, '2023-01-06 06:30:24', '2023-01-06 12:30:24'),
(62, 14, NULL, 84, 20, 'Venta de producto', 15, NULL, NULL, 6, NULL, NULL, NULL, '2023-01-06 06:30:24', '2023-01-06 12:30:24'),
(63, 10, NULL, 240, 20, 'Venta de producto', 16, NULL, NULL, 7, NULL, NULL, NULL, '2023-01-09 15:53:06', '2023-01-09 21:53:06'),
(64, 10, NULL, 215, 20, 'Venta de producto', 17, NULL, NULL, 7, NULL, NULL, NULL, '2023-01-09 15:55:30', '2023-01-09 21:55:30'),
(65, 10, NULL, 240, 20, 'Venta de producto', 18, NULL, NULL, 7, NULL, NULL, NULL, '2023-01-10 06:31:35', '2023-01-10 12:31:35'),
(66, 10, NULL, 210, 20, 'Venta de producto', 19, NULL, NULL, 7, NULL, NULL, NULL, '2023-01-10 06:35:55', '2023-01-10 12:35:55'),
(67, 13, NULL, 288, 20, 'Venta de producto', 20, NULL, NULL, 8, NULL, NULL, NULL, '2023-01-12 07:05:47', '2023-01-12 13:05:47'),
(68, 15, NULL, 1200, 20, 'Ingreso de producto por compra', NULL, NULL, 13, NULL, NULL, NULL, NULL, '2023-01-19 09:59:02', '2023-01-19 15:59:02'),
(69, 10, NULL, 15, 20, 'Venta de producto', 21, NULL, NULL, 7, NULL, NULL, NULL, '2023-01-19 10:01:17', '2023-01-19 16:01:17'),
(70, 15, NULL, 205, 20, 'Venta de producto', 21, NULL, NULL, 7, NULL, NULL, NULL, '2023-01-19 10:01:17', '2023-01-19 16:01:17'),
(71, 13, NULL, 20, 20, 'Venta de producto', 22, NULL, NULL, 8, NULL, NULL, NULL, '2023-02-01 02:53:38', '2023-02-01 08:53:38'),
(72, 15, NULL, 180, 20, 'Venta de producto', 23, NULL, NULL, 7, NULL, NULL, NULL, '2023-02-06 10:16:22', '2023-02-06 16:16:22'),
(73, 15, NULL, 150, 20, 'Venta de producto', 24, NULL, NULL, 7, NULL, NULL, NULL, '2023-02-07 10:33:16', '2023-02-07 16:33:16'),
(74, 16, NULL, 1072, 20, 'Ingreso de producto por compra', NULL, NULL, 14, NULL, NULL, NULL, NULL, '2023-02-15 05:12:19', '2023-02-15 11:12:19'),
(75, 17, NULL, 2528, 20, 'Ingreso de producto por compra', NULL, NULL, 15, NULL, NULL, NULL, NULL, '2023-02-15 05:19:56', '2023-02-15 11:19:56'),
(76, 15, NULL, 225, 20, 'Venta de producto', 25, NULL, NULL, 7, NULL, NULL, NULL, '2023-02-15 05:44:43', '2023-02-15 11:44:43'),
(77, 15, NULL, 191, 23, 'Venta de producto', 26, NULL, NULL, 7, NULL, NULL, NULL, '2023-02-16 09:46:56', '2023-02-16 15:46:56'),
(78, 13, NULL, 264, 23, 'Venta de producto', 27, NULL, NULL, 8, NULL, NULL, NULL, '2023-02-20 06:36:39', '2023-02-20 12:36:39'),
(79, 17, NULL, 17, 23, 'Venta de producto', 27, NULL, NULL, 8, NULL, NULL, NULL, '2023-02-20 06:36:39', '2023-02-20 12:36:39'),
(80, 17, NULL, 251, 23, 'Venta de producto', 28, NULL, NULL, 8, NULL, NULL, NULL, '2023-02-21 09:13:11', '2023-02-21 15:13:11'),
(81, 17, NULL, 290, 23, 'Venta de producto', 29, NULL, NULL, 8, NULL, NULL, NULL, '2023-02-22 09:34:29', '2023-02-22 15:34:29'),
(82, 14, NULL, 219, 23, 'Venta de producto', 30, NULL, NULL, 6, NULL, NULL, NULL, '2023-02-24 05:02:47', '2023-02-24 11:02:47'),
(83, 16, NULL, 204, 23, 'Venta de producto', 31, NULL, NULL, 6, NULL, NULL, NULL, '2023-02-27 02:37:24', '2023-02-27 08:37:24'),
(84, 14, NULL, 190, 23, 'Venta de producto', 32, NULL, NULL, 6, NULL, NULL, NULL, '2023-02-28 03:49:26', '2023-02-28 09:49:26'),
(85, 16, NULL, 190, 23, 'Venta de producto', 33, NULL, NULL, 6, NULL, NULL, NULL, '2023-03-08 02:49:11', '2023-03-08 08:49:11'),
(86, 14, NULL, 216, 23, 'Venta de producto', 34, NULL, NULL, 6, NULL, NULL, NULL, '2023-03-09 04:49:19', '2023-03-09 10:49:19'),
(87, 16, NULL, 228, 23, 'Venta de producto', 35, NULL, NULL, 6, NULL, NULL, NULL, '2023-03-23 03:13:20', '2023-03-23 09:13:20'),
(88, 14, NULL, 215, 23, 'Venta de producto', 36, NULL, NULL, 6, NULL, NULL, NULL, '2023-03-23 22:04:28', '2023-03-24 04:04:28'),
(89, 15, NULL, 210, 23, 'Venta de producto', 37, NULL, NULL, 7, NULL, NULL, NULL, '2023-03-26 21:01:04', '2023-03-27 03:01:04'),
(90, 17, NULL, 270, 23, 'Venta de producto', 38, NULL, NULL, 8, NULL, NULL, NULL, '2023-03-27 22:13:58', '2023-03-28 04:13:58'),
(91, 17, 17, 270, 23, 'Factura Anulada', 38, NULL, NULL, 8, NULL, NULL, NULL, '2023-03-27 22:32:24', '2023-03-28 04:32:24'),
(92, 18, NULL, 2000, 20, 'Ingreso de producto por compra', NULL, NULL, 16, NULL, NULL, NULL, NULL, '2023-03-27 23:26:41', '2023-03-28 05:26:41'),
(93, 16, NULL, 216, 23, 'Venta de producto', 39, NULL, NULL, 6, NULL, NULL, NULL, '2023-03-27 23:38:53', '2023-03-28 05:38:53'),
(94, 15, NULL, 39, 23, 'Venta de producto', 40, NULL, NULL, 7, NULL, NULL, NULL, '2023-03-28 00:24:45', '2023-03-28 06:24:45'),
(95, 18, NULL, 203, 23, 'Venta de producto', 40, NULL, NULL, 7, NULL, NULL, NULL, '2023-03-28 00:24:45', '2023-03-28 06:24:45'),
(96, 16, 16, 216, 23, 'Factura Anulada', 39, NULL, NULL, 6, NULL, NULL, NULL, '2023-03-28 00:27:43', '2023-03-28 06:27:43'),
(97, 18, NULL, 210, 23, 'Venta de producto', 41, NULL, NULL, 7, NULL, NULL, NULL, '2023-03-28 21:01:21', '2023-03-29 03:01:21'),
(98, 18, NULL, 228, 23, 'Venta de producto', 42, NULL, NULL, 7, NULL, NULL, NULL, '2023-03-29 22:23:36', '2023-03-30 04:23:36'),
(99, 18, NULL, 231, 23, 'Venta de producto', 43, NULL, NULL, 7, NULL, NULL, NULL, '2023-03-31 02:39:22', '2023-03-31 08:39:22'),
(100, 18, NULL, 245, 23, 'Venta de producto', 44, NULL, NULL, 7, NULL, NULL, NULL, '2023-04-10 21:05:52', '2023-04-11 03:05:52'),
(101, 18, NULL, 243, 23, 'Venta de producto', 45, NULL, NULL, 7, NULL, NULL, NULL, '2023-04-12 00:32:24', '2023-04-12 06:32:24'),
(102, 18, NULL, 235, 23, 'Venta de producto', 46, NULL, NULL, 7, NULL, NULL, NULL, '2023-04-14 00:26:54', '2023-04-14 06:26:54'),
(103, 14, NULL, 223, 23, 'Venta de producto', 47, NULL, NULL, 6, NULL, NULL, NULL, '2023-04-17 22:38:08', '2023-04-18 04:38:08'),
(104, 16, NULL, 220, 23, 'Venta de producto', 48, NULL, NULL, 6, NULL, NULL, NULL, '2023-04-19 05:50:21', '2023-04-19 11:50:21'),
(105, 14, NULL, 133, 23, 'Venta de producto', 49, NULL, NULL, 6, NULL, NULL, NULL, '2023-04-20 05:45:21', '2023-04-20 11:45:21'),
(106, 16, NULL, 67, 23, 'Venta de producto', 49, NULL, NULL, 6, NULL, NULL, NULL, '2023-04-20 05:45:21', '2023-04-20 11:45:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `url_img` varchar(45) DEFAULT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id`, `nombre`, `url_img`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 'COLA BLANCA', NULL, 3, '2022-09-16 17:25:50', '2022-09-16 23:25:50'),
(2, 'GENERICO', 'IMG_1664638378.jpg', 3, '2022-10-01 03:32:58', '2022-10-01 09:32:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `icon` varchar(45) NOT NULL,
  `nombre_menu` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `meses`
--

CREATE TABLE `meses` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `montonotadebito`
--

CREATE TABLE `montonotadebito` (
  `id` int(11) NOT NULL,
  `monto` double DEFAULT NULL,
  `descripcion` varchar(250) DEFAULT NULL,
  `estado_id` int(11) NOT NULL,
  `users_registra_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `motivo_nota_credito`
--

CREATE TABLE `motivo_nota_credito` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

CREATE TABLE `municipio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `departamento_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`id`, `nombre`, `created_at`, `updated_at`, `departamento_id`) VALUES
(1, 'La Ceiba', '2021-01-11 04:08:15', NULL, 1),
(2, 'Tela', '2021-01-11 04:08:15', NULL, 1),
(3, 'Jutiapa', '2021-01-11 04:08:15', NULL, 1),
(4, 'La Masica', '2021-01-11 04:08:16', NULL, 1),
(5, 'San Francisco', '2021-01-11 04:08:16', NULL, 1),
(6, 'Arizona', '2021-01-11 04:08:16', NULL, 1),
(7, 'Esparta', '2021-01-11 04:08:16', NULL, 1),
(8, 'El Porvenir', '2021-01-11 04:08:16', NULL, 1),
(9, 'TRUJILLO', '2021-01-11 04:12:40', NULL, 2),
(10, 'BALFATE', '2021-01-11 04:12:40', NULL, 2),
(11, 'IRIONA', '2021-01-11 04:12:40', NULL, 2),
(12, 'LIMÓN', '2021-01-11 04:31:02', NULL, 2),
(13, 'SABÁ', '2021-01-11 04:31:36', NULL, 2),
(14, 'SANTA FE', '2021-01-11 04:12:40', NULL, 2),
(15, 'SANTA ROSA DE AGUÁN', '2021-01-11 04:12:40', NULL, 2),
(16, 'SONAGUERA', '2021-01-11 04:12:40', NULL, 2),
(17, 'TOCOA', '2021-01-11 04:12:41', NULL, 2),
(18, 'BONITO ORIENTAL', '2021-01-11 04:12:41', NULL, 2),
(19, 'COMAYAGUA', '2021-01-11 04:21:27', NULL, 3),
(20, 'AJUTERIQUE', '2021-01-11 04:21:27', NULL, 3),
(21, 'EL ROSARIO', '2021-01-11 04:21:27', NULL, 3),
(22, 'ESQUÍAS', '2021-01-11 04:21:27', NULL, 3),
(23, 'HUMUYA', '2021-01-11 04:21:27', NULL, 3),
(24, 'LA LIBERTAD', '2021-01-11 04:21:27', NULL, 3),
(25, 'LAMANÍ', '2021-01-11 04:21:27', NULL, 3),
(26, 'LA TRINIDAD', '2021-01-11 04:21:27', NULL, 3),
(27, 'LEJAMANI', '2021-01-11 04:21:27', NULL, 3),
(28, 'MEAMBAR', '2021-01-11 04:21:27', NULL, 3),
(29, 'MINAS DE ORO', '2021-01-11 04:21:27', NULL, 3),
(30, 'OJOS DE AGUA', '2021-01-11 04:21:27', NULL, 3),
(31, 'SAN JERÓNIMO (HONDURAS)', '2021-01-11 04:21:27', NULL, 3),
(32, 'SAN JOSÉ DE COMAYAGUA', '2021-01-11 04:21:27', NULL, 3),
(33, 'SAN JOSÉ DEL POTRERO', '2021-01-11 04:21:27', NULL, 3),
(34, 'SAN LUIS', '2021-01-11 04:21:27', NULL, 3),
(35, 'SAN SEBASTIÁN', '2021-01-11 04:21:27', NULL, 3),
(36, 'SIGUATEPEQUE', '2021-01-11 04:21:27', NULL, 3),
(37, 'VILLA DE SAN ANTONIO', '2021-01-11 04:21:27', NULL, 3),
(38, 'LAS LAJAS', '2021-01-11 04:21:27', NULL, 3),
(39, 'TAULABÉ', '2021-01-11 04:21:27', NULL, 3),
(40, 'SANTA ROSA DE COPÁN', '2021-01-11 04:24:20', NULL, 4),
(41, 'CABAÑAS', '2021-01-11 04:24:20', NULL, 4),
(42, 'CONCEPCIÓN', '2021-01-11 04:24:20', NULL, 4),
(43, 'COPÁN RUINAS', '2021-01-11 04:24:20', NULL, 4),
(44, 'CORQUÍN', '2021-01-11 04:24:20', NULL, 4),
(45, 'CUCUYAGUA', '2021-01-11 04:24:20', NULL, 4),
(46, 'DOLORES', '2021-01-11 04:24:21', NULL, 4),
(47, 'DULCE NOMBRE', '2021-01-11 04:24:21', NULL, 4),
(48, 'EL PARAÍSO', '2021-01-11 04:24:21', NULL, 4),
(49, 'FLORIDA', '2021-01-11 04:24:21', NULL, 4),
(50, 'LA JIGUA', '2021-01-11 04:24:21', NULL, 4),
(51, 'LA UNIÓN', '2021-01-11 04:24:21', NULL, 4),
(52, 'NUEVA ARCADIA', '2021-01-11 04:24:21', NULL, 4),
(53, 'SAN AGUSTÍN', '2021-01-11 04:24:21', NULL, 4),
(54, 'SAN ANTONIO', '2021-01-11 04:24:21', NULL, 4),
(55, 'SAN JERÓNIMO', '2021-01-11 04:24:21', NULL, 4),
(56, 'SAN JOSÉ', '2021-01-11 04:24:21', NULL, 4),
(57, 'SAN JUAN DE OPOA', '2021-01-11 04:24:21', NULL, 4),
(58, 'SAN NICOLÁS', '2021-01-11 04:24:21', NULL, 4),
(59, 'SAN PEDRO', '2021-01-11 04:24:21', NULL, 4),
(60, 'SANTA RITA', '2021-01-11 04:24:21', NULL, 4),
(61, 'TRINIDAD DE COPÁN', '2021-01-11 04:24:21', NULL, 4),
(62, 'VERACRUZ', '2021-01-11 04:24:21', NULL, 4),
(63, 'SAN PEDRO SULA', '2021-01-11 04:26:38', NULL, 5),
(64, 'CHOLOMA', '2021-01-11 04:26:38', NULL, 5),
(65, 'OMOA', '2021-01-11 04:26:38', NULL, 5),
(66, 'PIMIENTA', '2021-01-11 04:26:38', NULL, 5),
(67, 'POTRERILLOS', '2021-01-11 04:26:38', NULL, 5),
(68, 'PUERTO CORTÉS', '2021-01-11 04:26:38', NULL, 5),
(69, 'SAN ANTONIO DE CORTÉS', '2021-01-11 04:26:38', NULL, 5),
(70, 'SAN FRANCISCO DE YOJOA', '2021-01-11 04:26:38', NULL, 5),
(71, 'SAN MANUEL', '2021-01-11 04:26:38', NULL, 5),
(72, 'SANTA CRUZ DE YOJOA', '2021-01-11 04:26:38', NULL, 5),
(73, 'VILLANUEVA', '2021-01-11 04:26:38', NULL, 5),
(74, 'LA LIMA', '2021-01-11 04:26:38', NULL, 5),
(75, 'CHOLUTECA', '2021-01-11 04:29:31', NULL, 6),
(76, 'APACILAGUA', '2021-01-11 04:29:31', NULL, 6),
(77, 'CONCEPCIÓN DE MARÍA', '2021-01-11 04:29:31', NULL, 6),
(78, 'DUYURE', '2021-01-11 04:29:31', NULL, 6),
(79, 'EL CORPUS', '2021-01-11 04:29:31', NULL, 6),
(80, 'EL TRIUNFO', '2021-01-11 04:29:31', NULL, 6),
(81, 'MARCOVIA', '2021-01-11 04:29:32', NULL, 6),
(82, 'MOROLICA', '2021-01-11 04:29:32', NULL, 6),
(83, 'NAMASIGUE', '2021-01-11 04:29:32', NULL, 6),
(84, 'OROCUINA', '2021-01-11 04:29:32', NULL, 6),
(85, 'PESPIRE', '2021-01-11 04:29:32', NULL, 6),
(86, 'SAN ANTONIO DE FLORES', '2021-01-11 04:29:32', NULL, 6),
(87, 'SAN ISIDRO', '2021-01-11 04:29:32', NULL, 6),
(88, 'SAN JOSÉ', '2021-01-11 04:29:32', NULL, 6),
(89, 'SAN MARCOS DE COLÓN', '2021-01-11 04:29:32', NULL, 6),
(90, 'SANTA ANA DE YUSGUARE', '2021-01-11 04:29:32', NULL, 6),
(91, 'YUSCARÁN', '2021-01-11 04:35:04', NULL, 7),
(92, 'ALAUCA', '2021-01-11 04:35:04', NULL, 7),
(93, 'DANLÍ', '2021-01-11 04:35:04', NULL, 7),
(94, 'EL PARAÍSO', '2021-01-11 04:35:04', NULL, 7),
(95, 'GÜINOPE', '2021-01-11 04:35:04', NULL, 7),
(96, 'JACALEAPA', '2021-01-11 04:35:04', NULL, 7),
(97, 'LIURE', '2021-01-11 04:35:04', NULL, 7),
(98, 'MOROCELÍ', '2021-01-11 04:35:04', NULL, 7),
(99, 'OROPOLÍ', '2021-01-11 04:35:04', NULL, 7),
(100, 'POTRERILLOS', '2021-01-11 04:35:04', NULL, 7),
(101, 'SAN ANTONIO DE FLORES', '2021-01-11 04:35:04', NULL, 7),
(102, 'SAN LUCAS', '2021-01-11 04:35:04', NULL, 7),
(103, 'SAN MATÍAS', '2021-01-11 04:35:05', NULL, 7),
(104, 'SOLEDAD', '2021-01-11 04:35:05', NULL, 7),
(105, 'TEUPASENTI', '2021-01-11 04:35:05', NULL, 7),
(106, 'TEXIGUAT', '2021-01-11 04:35:05', NULL, 7),
(107, 'VADO ANCHO', '2021-01-11 04:35:05', NULL, 7),
(108, 'YAUYUPE', '2021-01-11 04:35:05', NULL, 7),
(109, 'TROJES', '2021-01-11 04:35:05', NULL, 7),
(110, 'DISTRITO CENTRAL', '2021-01-11 04:37:39', NULL, 8),
(111, 'ALUBARÉN', '2021-01-11 04:37:39', NULL, 8),
(112, 'CEDROS', '2021-01-11 04:37:39', NULL, 8),
(113, 'CURARÉN', '2021-01-11 04:37:39', NULL, 8),
(114, 'EL PORVENIR', '2021-01-11 04:37:39', NULL, 8),
(115, 'GUAIMACA', '2021-01-11 04:37:39', NULL, 8),
(116, 'LA LIBERTAD', '2021-01-11 04:37:39', NULL, 8),
(117, 'LA VENTA', '2021-01-11 04:37:39', NULL, 8),
(118, 'LEPATERIQUE', '2021-01-11 04:37:39', NULL, 8),
(119, 'MARAITA', '2021-01-11 04:37:39', NULL, 8),
(120, 'MARALE', '2021-01-11 04:37:39', NULL, 8),
(121, 'NUEVA ARMENIA', '2021-01-11 04:37:39', NULL, 8),
(122, 'OJOJONA', '2021-01-11 04:37:39', NULL, 8),
(123, 'ORICA', '2021-01-11 04:37:39', NULL, 8),
(124, 'REITOCA', '2021-01-11 04:37:39', NULL, 8),
(125, 'SABANAGRANDE', '2021-01-11 04:37:39', NULL, 8),
(126, 'SAN ANTONIO DE ORIENTE', '2021-01-11 04:37:39', NULL, 8),
(127, 'SAN BUENAVENTURA', '2021-01-11 04:37:39', NULL, 8),
(128, 'SAN IGNACIO', '2021-01-11 04:37:39', NULL, 8),
(129, 'SAN JUAN DE FLORES', '2021-01-11 04:37:39', NULL, 8),
(130, 'SAN MIGUELITO', '2021-01-11 04:37:39', NULL, 8),
(131, 'SANTA ANA', '2021-01-11 04:37:39', NULL, 8),
(132, 'SANTA LUCÍA', '2021-01-11 04:37:39', NULL, 8),
(133, 'TALANGA', '2021-01-11 04:37:39', NULL, 8),
(134, 'TATUMBLA', '2021-01-11 04:37:39', NULL, 8),
(135, 'VALLE DE ÁNGELES', '2021-01-11 04:37:39', NULL, 8),
(136, 'VILLA DE SAN FRANCISCO', '2021-01-11 04:37:39', NULL, 8),
(137, 'VALLECILLO', '2021-01-11 04:37:39', NULL, 8),
(138, 'PUERTO LEMPIRA', '2021-01-11 04:40:22', NULL, 9),
(139, 'BRUS LAGUNA', '2021-01-11 04:40:22', NULL, 9),
(140, 'AHUAS', '2021-01-11 04:40:22', NULL, 9),
(141, 'JUAN FRANCISCO BULNES', '2021-01-11 04:40:22', NULL, 9),
(142, 'RAMÓN VILLEDA MORALES', '2021-01-11 04:40:22', NULL, 9),
(143, 'WAMPUSIRPE', '2021-01-11 04:40:22', NULL, 9),
(144, 'LA ESPERANZA', '2021-01-11 04:42:37', NULL, 10),
(145, 'CAMASCA', '2021-01-11 04:42:37', NULL, 10),
(146, 'COLOMONCAGUA', '2021-01-11 04:42:37', NULL, 10),
(147, 'CONCEPCIÓN', '2021-01-11 04:42:37', NULL, 10),
(148, 'DOLORES', '2021-01-11 04:42:37', NULL, 10),
(149, 'INTIBUCÁ', '2021-01-11 04:42:37', NULL, 10),
(150, 'JESÚS DE OTORO', '2021-01-11 04:42:37', NULL, 10),
(151, 'MAGDALENA', '2021-01-11 04:42:37', NULL, 10),
(152, 'MASAGUARA', '2021-01-11 04:42:37', NULL, 10),
(153, 'SAN ANTONIO', '2021-01-11 04:42:37', NULL, 10),
(154, 'SAN ISIDRO', '2021-01-11 04:42:37', NULL, 10),
(155, 'SAN JUAN', '2021-01-11 04:42:37', NULL, 10),
(156, 'SAN MARCOS DE LA SIERRA', '2021-01-11 04:42:37', NULL, 10),
(157, 'SAN MIGUEL GUANCAPLA', '2021-01-11 04:42:37', NULL, 10),
(158, 'SANTA LUCÍA', '2021-01-11 04:42:37', NULL, 10),
(159, 'YAMARANGUILA', '2021-01-11 04:42:38', NULL, 10),
(160, 'SAN FRANCISCO DE OPALACA', '2021-01-11 04:42:38', NULL, 10),
(161, 'ROATÁN', '2021-01-11 04:43:50', NULL, 11),
(162, 'GUANAJA', '2021-01-11 04:43:50', NULL, 11),
(163, 'JOSÉ SANTOS GUARDIOLA', '2021-01-11 04:43:50', NULL, 11),
(164, 'UTILA', '2021-01-11 04:43:50', NULL, 11),
(165, 'LA PAZ', '2021-01-11 04:45:32', NULL, 12),
(166, 'AGUANQUETERIQUE', '2021-01-11 04:45:32', NULL, 12),
(167, 'CABAÑAS', '2021-01-11 04:45:32', NULL, 12),
(168, 'CANE', '2021-01-11 04:45:32', NULL, 12),
(169, 'CHINACLA', '2021-01-11 04:45:32', NULL, 12),
(170, 'GUAJIQUIRO', '2021-01-11 04:45:32', NULL, 12),
(171, 'LAUTERIQUE', '2021-01-11 04:45:32', NULL, 12),
(172, 'MARCALA', '2021-01-11 04:45:32', NULL, 12),
(173, 'MERCEDES DE ORIENTE', '2021-01-11 04:45:32', NULL, 12),
(174, 'OPATORO', '2021-01-11 04:45:32', NULL, 12),
(175, 'SAN ANTONIO DEL NORTE', '2021-01-11 04:45:32', NULL, 12),
(176, 'SAN JOSÉ', '2021-01-11 04:45:32', NULL, 12),
(177, 'SAN JUAN', '2021-01-11 04:45:32', NULL, 12),
(178, 'SAN PEDRO DE TUTULE', '2021-01-11 04:45:32', NULL, 12),
(179, 'SANTA ANA', '2021-01-11 04:45:33', NULL, 12),
(180, 'SANTA ELENA', '2021-01-11 04:45:33', NULL, 12),
(181, 'SANTA MARÍA', '2021-01-11 04:45:33', NULL, 12),
(182, 'SANTIAGO DE PURINGLA', '2021-01-11 04:45:33', NULL, 12),
(183, 'YARULA', '2021-01-11 04:45:33', NULL, 12),
(184, 'GRACIAS', '2021-01-11 04:47:09', NULL, 13),
(185, 'BELÉN', '2021-01-11 04:47:09', NULL, 13),
(186, 'CANDELARIA', '2021-01-11 04:47:09', NULL, 13),
(187, 'COLOLACA', '2021-01-11 04:47:09', NULL, 13),
(188, 'ERANDIQUE', '2021-01-11 04:47:10', NULL, 13),
(189, 'GUALCINCE', '2021-01-11 04:47:10', NULL, 13),
(190, 'GUARITA', '2021-01-11 04:47:10', NULL, 13),
(191, 'LA CAMPA', '2021-01-11 04:47:10', NULL, 13),
(192, 'LA IGUALA', '2021-01-11 04:47:10', NULL, 13),
(193, 'LAS FLORES', '2021-01-11 04:47:10', NULL, 13),
(194, 'LA UNIÓN', '2021-01-11 04:47:10', NULL, 13),
(195, 'LA VIRTUD', '2021-01-11 04:47:10', NULL, 13),
(196, 'LEPAERA', '2021-01-11 04:47:10', NULL, 13),
(197, 'MAPULACA', '2021-01-11 04:47:10', NULL, 13),
(198, 'PIRAERA', '2021-01-11 04:47:10', NULL, 13),
(199, 'SAN ANDRÉS', '2021-01-11 04:47:10', NULL, 13),
(200, 'SAN FRANCISCO', '2021-01-11 04:47:10', NULL, 13),
(201, 'SAN JUAN GUARITA', '2021-01-11 04:47:10', NULL, 13),
(202, 'SAN MANUEL COLOHETE', '2021-01-11 04:47:10', NULL, 13),
(203, 'SAN RAFAEL', '2021-01-11 04:47:10', NULL, 13),
(204, 'SAN SEBASTIÁN', '2021-01-11 04:47:10', NULL, 13),
(205, 'SANTA CRUZ', '2021-01-11 04:47:10', NULL, 13),
(206, 'TALGUA', '2021-01-11 04:47:10', NULL, 13),
(207, 'TAMBLA', '2021-01-11 04:47:10', NULL, 13),
(208, 'TOMALÁ', '2021-01-11 04:47:10', NULL, 13),
(209, 'VALLADOLID', '2021-01-11 04:47:10', NULL, 13),
(210, 'VIRGINIA', '2021-01-11 04:47:10', NULL, 13),
(211, 'SAN MARCOS DE CAIQUÍN', '2021-01-11 04:47:10', NULL, 13),
(212, 'OCOTEPEQUE', '2021-01-11 04:48:46', NULL, 14),
(213, 'BELÉN GUALCHO', '2021-01-11 04:48:46', NULL, 14),
(214, 'CONCEPCIÓN', '2021-01-11 04:48:46', NULL, 14),
(215, 'DOLORES MERENDÓN', '2021-01-11 04:48:46', NULL, 14),
(216, 'FRATERNIDAD', '2021-01-11 04:48:46', NULL, 14),
(217, 'LA ENCARNACIÓN', '2021-01-11 04:48:46', NULL, 14),
(218, 'LA LABOR', '2021-01-11 04:48:46', NULL, 14),
(219, 'LUCERNA', '2021-01-11 04:48:46', NULL, 14),
(220, 'MERCEDES', '2021-01-11 04:48:46', NULL, 14),
(221, 'SAN FERNANDO', '2021-01-11 04:48:46', NULL, 14),
(222, 'SAN FRANCISCO DEL VALLE', '2021-01-11 04:48:46', NULL, 14),
(223, 'SAN JORGE', '2021-01-11 04:48:46', NULL, 14),
(224, 'SAN MARCOS', '2021-01-11 04:48:46', NULL, 14),
(225, 'SANTA FE', '2021-01-11 04:48:46', NULL, 14),
(226, 'SENSENTI', '2021-01-11 04:48:46', NULL, 14),
(227, 'SINUAPA', '2021-01-11 04:48:46', NULL, 14),
(228, 'JUTICALPA', '2021-01-11 04:50:30', NULL, 15),
(229, 'CAMPAMENTO', '2021-01-11 04:50:30', NULL, 15),
(230, 'CATACAMAS', '2021-01-11 04:50:30', NULL, 15),
(231, 'CONCORDIA', '2021-01-11 04:50:30', NULL, 15),
(232, 'DULCE NOMBRE DE CULMÍ', '2021-01-11 04:50:30', NULL, 15),
(233, 'EL ROSARIO', '2021-01-11 04:50:30', NULL, 15),
(234, 'ESQUIPULAS DEL NORTE', '2021-01-11 04:50:30', NULL, 15),
(235, 'GUALACO', '2021-01-11 04:50:30', NULL, 15),
(236, 'GUARIZAMA', '2021-01-11 04:50:30', NULL, 15),
(237, 'GUATA', '2021-01-11 04:50:30', NULL, 15),
(238, 'GUAYAPE', '2021-01-11 04:50:30', NULL, 15),
(239, 'JANO', '2021-01-11 04:50:30', NULL, 15),
(240, 'LA UNIÓN', '2021-01-11 04:50:30', NULL, 15),
(241, 'MANGULILE', '2021-01-11 04:50:30', NULL, 15),
(242, 'MANTO', '2021-01-11 04:50:30', NULL, 15),
(243, 'SALAMÁ', '2021-01-11 04:50:30', NULL, 15),
(244, 'SAN ESTEBAN', '2021-01-11 04:50:30', NULL, 15),
(245, 'SAN FRANCISCO DE BECERRA', '2021-01-11 04:50:30', NULL, 15),
(246, 'SAN FRANCISCO DE LA PAZ', '2021-01-11 04:50:31', NULL, 15),
(247, 'SANTA MARÍA DEL REAL', '2021-01-11 04:50:31', NULL, 15),
(248, 'SILCA', '2021-01-11 04:50:31', NULL, 15),
(249, 'YOCÓN', '2021-01-11 04:50:31', NULL, 15),
(250, 'PATUCA', '2021-01-11 04:50:31', NULL, 15),
(251, 'SANTA BÁRBARA', '2021-01-11 04:53:10', NULL, 16),
(252, 'ARADA', '2021-01-11 04:53:10', NULL, 16),
(253, 'ATIMA', '2021-01-11 04:53:10', NULL, 16),
(254, 'AZACUALPA', '2021-01-11 04:53:10', NULL, 16),
(255, 'CEGUACA', '2021-01-11 04:53:10', NULL, 16),
(256, 'CONCEPCIÓN DEL NORTE', '2021-01-11 04:53:10', NULL, 16),
(257, 'CONCEPCIÓN DEL SUR', '2021-01-11 04:53:10', NULL, 16),
(258, 'CHINDA', '2021-01-11 04:53:10', NULL, 16),
(259, 'EL NÍSPERO', '2021-01-11 04:53:10', NULL, 16),
(260, 'GUALALA', '2021-01-11 04:53:10', NULL, 16),
(261, 'ILAMA', '2021-01-11 04:53:10', NULL, 16),
(262, 'LAS VEGAS', '2021-01-11 04:53:10', NULL, 16),
(263, 'MACUELIZO', '2021-01-11 04:53:10', NULL, 16),
(264, 'NARANJITO', '2021-01-11 04:53:10', NULL, 16),
(265, 'NUEVO CELILAC', '2021-01-11 04:53:11', NULL, 16),
(266, 'NUEVA FRONTERA', '2021-01-11 04:53:11', NULL, 16),
(267, 'PETOA', '2021-01-11 04:53:11', NULL, 16),
(268, 'PROTECCIÓN', '2021-01-11 04:53:11', NULL, 16),
(269, 'QUIMISTÁN', '2021-01-11 04:53:11', NULL, 16),
(270, 'SAN FRANCISCO DE OJUERA', '2021-01-11 04:53:11', NULL, 16),
(271, 'SAN JOSÉ DE LAS COLINAS', '2021-01-11 04:53:11', NULL, 16),
(272, 'SAN LUIS', '2021-01-11 04:53:11', NULL, 16),
(273, 'SAN MARCOS', '2021-01-11 04:53:11', NULL, 16),
(274, 'SAN NICOLÁS', '2021-01-11 04:53:11', NULL, 16),
(275, 'SAN PEDRO ZACAPA', '2021-01-11 04:53:11', NULL, 16),
(276, 'SAN VICENTE CENTENARIO', '2021-01-11 04:53:11', NULL, 16),
(277, 'SANTA RITA', '2021-01-11 04:53:11', NULL, 16),
(278, 'TRINIDAD', '2021-01-11 04:53:11', NULL, 16),
(279, 'NACAOME', '2021-01-11 04:54:24', NULL, 17),
(280, 'ALIANZA', '2021-01-11 04:54:24', NULL, 17),
(281, 'AMAPALA', '2021-01-11 04:54:24', NULL, 17),
(282, 'ARAMECINA', '2021-01-11 04:54:24', NULL, 17),
(283, 'CARIDAD', '2021-01-11 04:54:24', NULL, 17),
(284, 'GOASCORÁN', '2021-01-11 04:54:24', NULL, 17),
(285, 'LANGUE', '2021-01-11 04:54:24', NULL, 17),
(286, 'SAN FRANCISCO DE CORAY', '2021-01-11 04:54:24', NULL, 17),
(287, 'SAN LORENZO', '2021-01-11 04:54:24', NULL, 17),
(288, 'YORO', '2021-01-11 04:55:56', NULL, 18),
(289, 'ARENAL', '2021-01-11 04:55:56', NULL, 18),
(290, 'EL NEGRITO', '2021-01-11 04:55:56', NULL, 18),
(291, 'EL PROGRESO', '2021-01-11 04:55:56', NULL, 18),
(292, 'JOCÓN', '2021-01-11 04:55:56', NULL, 18),
(293, 'MORAZÁN', '2021-01-11 04:55:56', NULL, 18),
(294, 'OLANCHITO', '2021-01-11 04:55:56', NULL, 18),
(295, 'SANTA RITA', '2021-01-11 04:55:56', NULL, 18),
(296, 'SULACO', '2021-01-11 04:55:56', NULL, 18),
(297, 'VICTORIA', '2021-01-11 04:55:56', NULL, 18),
(298, 'YORITO', '2021-01-11 04:55:56', NULL, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notadebito`
--

CREATE TABLE `notadebito` (
  `id` int(11) NOT NULL,
  `factura_id` int(11) NOT NULL,
  `montoNotaDebito_id` int(11) NOT NULL,
  `monto_asignado` double DEFAULT NULL,
  `fechaEmision` date DEFAULT NULL,
  `motivoDescripcion` varchar(500) DEFAULT NULL,
  `cai_ndebito` varchar(150) DEFAULT NULL,
  `numeroCai` varchar(150) DEFAULT NULL,
  `correlativoND` varchar(45) DEFAULT NULL,
  `estado_id` int(11) NOT NULL,
  `estado_nota_dec` int(11) NOT NULL,
  `users_registra_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_credito`
--

CREATE TABLE `nota_credito` (
  `id` int(11) NOT NULL,
  `numero_nota` varchar(45) NOT NULL,
  `comentario` text NOT NULL,
  `cai` varchar(19) NOT NULL,
  `numero_secuencia_cai` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `sub_total` double NOT NULL,
  `sub_total_grabado` double NOT NULL,
  `sub_total_excento` double NOT NULL,
  `isv` double NOT NULL,
  `total` double NOT NULL,
  `factura_id` int(11) NOT NULL,
  `cai_id` int(11) NOT NULL,
  `motivo_nota_credito_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `estado_nota_id` int(11) NOT NULL,
  `estado_nota_dec` int(11) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_credito_has_producto`
--

CREATE TABLE `nota_credito_has_producto` (
  `nota_credito_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `seccion_id` int(11) NOT NULL,
  `indice` int(11) NOT NULL,
  `cantidad` double NOT NULL,
  `precio_unidad` double NOT NULL,
  `sub_total` double NOT NULL,
  `isv` double NOT NULL,
  `total` double NOT NULL,
  `unidad_medida_venta_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `numero_orden_compra`
--

CREATE TABLE `numero_orden_compra` (
  `id` int(11) NOT NULL,
  `numero_orden` varchar(45) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_comision`
--

CREATE TABLE `pago_comision` (
  `id` int(11) NOT NULL,
  `vendedor_id` bigint(20) UNSIGNED NOT NULL,
  `nombre_vendedor` varchar(150) DEFAULT NULL,
  `mes_comision` varchar(45) DEFAULT NULL,
  `meses_id` int(11) NOT NULL,
  `cantidad_facturas` int(11) DEFAULT NULL,
  `techo_asignado` double DEFAULT NULL,
  `ganancia_total` double DEFAULT NULL,
  `monto_asignado` double DEFAULT NULL,
  `estado_pago` int(11) DEFAULT '0' COMMENT '0: no pagado\n1: pagado',
  `url_comprobante` varchar(250) DEFAULT NULL,
  `users_registra_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_compra`
--

CREATE TABLE `pago_compra` (
  `id` int(11) NOT NULL,
  `monto` double NOT NULL,
  `url_img` varchar(250) NOT NULL,
  `fecha` date NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `compra_id` int(11) NOT NULL,
  `users_id_elimina` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_eliminado` timestamp NULL DEFAULT NULL,
  `estado_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago_venta`
--

CREATE TABLE `pago_venta` (
  `id` int(11) NOT NULL,
  `monto` double NOT NULL,
  `url_img` varchar(45) DEFAULT NULL,
  `fecha` date NOT NULL,
  `factura_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `estado_venta_id` int(11) NOT NULL,
  `users_id_elimina` bigint(20) UNSIGNED DEFAULT NULL,
  `fecha_eliminado` date DEFAULT NULL,
  `banco_id` int(11) DEFAULT NULL,
  `tipo_pago_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE `pais` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `pais`
--

INSERT INTO `pais` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Honduras', '2022-03-14 15:56:05', '2022-03-14 21:55:48'),
(2, 'Guatemala', '2022-09-07 11:18:17', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parametro`
--

CREATE TABLE `parametro` (
  `id` int(11) NOT NULL,
  `metodo` int(11) NOT NULL,
  `estado_encendido` tinyint(4) NOT NULL,
  `turno` int(11) NOT NULL,
  `igualdad` varchar(45) NOT NULL,
  `monto` double NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `parametro`
--

INSERT INTO `parametro` (`id`, `metodo`, `estado_encendido`, `turno`, `igualdad`, `monto`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '>', 1000, 2, '2022-09-16 22:31:26', '2022-09-16 22:31:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('alba.rodas@grupoalca.hn', '$2y$10$Yfb5mnPA5QX75pURGasNxuIACsh32M.OQ3YmQSDObLmS4s4hDKEle', '2023-03-22 12:36:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios_venta`
--

CREATE TABLE `precios_venta` (
  `id` int(11) NOT NULL,
  `precio` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `producto_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` varchar(1000) NOT NULL,
  `isv` int(11) NOT NULL,
  `precio_base` double NOT NULL,
  `ultimo_costo_compra` double NOT NULL,
  `costo_promedio` double NOT NULL,
  `codigo_barra` varchar(100) DEFAULT NULL,
  `codigo_estatal` varchar(45) DEFAULT NULL,
  `marca_id` int(11) NOT NULL,
  `unidad_medida_compra_id` int(11) NOT NULL,
  `unidadad_compra` double NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `estado_producto_id` int(11) NOT NULL,
  `sub_categoria_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `isv`, `precio_base`, `ultimo_costo_compra`, `costo_promedio`, `codigo_barra`, `codigo_estatal`, `marca_id`, `unidad_medida_compra_id`, `unidadad_compra`, `users_id`, `estado_producto_id`, `sub_categoria_id`, `created_at`, `updated_at`) VALUES
(1, 'PAPEL HIGIENICO', 'Papel', 0, 54.5, 40, 220, '00000', '0000', 1, 23, 20, 20, 1, 1, '2022-10-20 11:14:40', '2022-10-20 11:14:40'),
(2, 'Papel Higiénico Institucional 250m', 'Papel higiénico institucional doble hoja de 250m', 0, 215.9, 200.28, 200.28, '0', '', 1, 7, 1, 20, 1, 1, '2022-10-24 11:08:25', '2022-10-24 11:08:25'),
(3, 'Papel Higiénico Institucional 400m', 'Papel Higiénico Institucional 400m', 0, 205, 186.42, 186.42, '', '', 1, 7, 1, 20, 1, 1, '2022-10-20 04:58:15', '2022-10-20 10:58:15'),
(4, 'Papel Toalla Institucional 240m', 'Papel Toalla Institucional 240m', 0, 165.5, 137.94, 137.94, '', '', 1, 7, 1, 20, 1, 2, '2022-10-24 11:10:46', '2022-10-24 11:10:46'),
(5, 'Papel Higiénico Institucional 250m S', 'Papel higiénico institucional doble hoja de 250m S', 0, 107.9, 100, 100, '0', '', 1, 7, 1, 20, 1, 1, '2023-01-04 11:12:08', '2023-01-04 11:12:08'),
(6, 'Papel Higiénico Institucional 400m S', 'Papel Higiénico Institucional de 400m S', 0, 99, 90, 91.61, '0', '', 1, 7, 1, 20, 1, 1, '2023-03-28 10:58:20', '2023-03-28 05:28:20'),
(7, 'Papel Toalla Institucional 240m S', 'Papel Toalla Institucional de 240m S', 0, 82.7, 68.97, 68.97, '0', '', 1, 7, 1, 20, 1, 2, '2022-11-29 08:07:02', '2022-11-29 14:07:02'),
(8, 'Papel Higiénico Institucional 500m S', 'Papel Higiénico Institucional de 500m S', 0, 122.73, 120, 120, '0', '', 1, 7, 1, 20, 1, 1, '2022-12-13 10:54:57', '2022-12-13 16:54:57'),
(9, 'Desperdicio Papel Higiénico/Toalla', 'Desperdicio de Papel Higiénico y Toalla derivado del Proceso de Producción', 0, 18, 18, 18, '', '', 2, 23, 1, 20, 1, 3, '2023-02-07 10:30:56', '2023-02-07 16:30:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` text NOT NULL,
  `contacto` varchar(45) NOT NULL,
  `telefono_1` varchar(45) NOT NULL,
  `telefono_2` varchar(45) DEFAULT NULL,
  `correo_1` varchar(45) NOT NULL,
  `correo_2` varchar(45) DEFAULT NULL,
  `rtn` varchar(45) NOT NULL,
  `registrado_por` bigint(20) UNSIGNED NOT NULL,
  `estado_id` int(11) NOT NULL,
  `municipio_id` int(11) DEFAULT NULL,
  `tipo_personalidad_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `codigo`, `nombre`, `direccion`, `contacto`, `telefono_1`, `telefono_2`, `correo_1`, `correo_2`, `rtn`, `registrado_por`, `estado_id`, `municipio_id`, `tipo_personalidad_id`, `categoria_id`, `created_at`, `updated_at`) VALUES
(1, '00000', 'PROVEEDOR INICIAL', 'Proveedor inicial para pruebas.', 'N/A', '00000000', '00000000', 'N/A', 'N/A', 'N/A', 3, 1, 110, 1, 1, '2022-10-01 09:30:54', '2022-10-01 09:30:54'),
(2, 'HND22001', 'Fábrica GA', 'Villa de San Antonio, Comayagua', 'Alexis Arias', '98440529', '', 'alexis.arias@grupoalca.hn', '', '05011987038758', 20, 1, 37, 1, 2, '2022-10-24 04:55:28', '2022-10-24 10:55:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibido_bodega`
--

CREATE TABLE `recibido_bodega` (
  `id` int(11) NOT NULL,
  `compra_id` int(11) DEFAULT NULL,
  `producto_id` int(11) NOT NULL,
  `seccion_id` int(11) NOT NULL,
  `cantidad_compra_lote` int(11) NOT NULL,
  `cantidad_inicial_seccion` int(11) NOT NULL,
  `cantidad_disponible` int(11) NOT NULL,
  `fecha_recibido` date NOT NULL,
  `fecha_expiracion` date DEFAULT NULL,
  `estado_recibido` int(11) NOT NULL,
  `recibido_por` bigint(20) UNSIGNED NOT NULL,
  `comentario` varchar(45) DEFAULT NULL,
  `unidad_compra_id` int(11) DEFAULT NULL,
  `unidades_compra` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `recibido_bodega`
--

INSERT INTO `recibido_bodega` (`id`, `compra_id`, `producto_id`, `seccion_id`, `cantidad_compra_lote`, `cantidad_inicial_seccion`, `cantidad_disponible`, `fecha_recibido`, `fecha_expiracion`, `estado_recibido`, `recibido_por`, `comentario`, `unidad_compra_id`, `unidades_compra`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1000, 600, 0, '2022-09-16', '2022-09-17', 4, 3, NULL, 23, 20, '2022-10-18 13:44:05', '2022-10-18 13:44:05'),
(2, 1, 1, 7, 1000, 400, 0, '2022-09-16', '2022-09-17', 4, 3, NULL, 23, 20, '2022-10-20 11:23:32', '2022-10-20 11:23:32'),
(3, 1, 1, 1, 1000, 300, 0, '2022-09-16', '2022-09-17', 4, 3, NULL, 23, 20, '2022-10-18 13:32:13', '2022-10-18 13:32:13'),
(4, 2, 1, 7, 500, 500, 0, '2022-10-20', '2022-02-21', 4, 20, NULL, 23, 20, '2022-10-21 11:23:17', '2022-10-21 11:23:17'),
(5, 3, 1, 7, 1000, 1000, 704, '2022-10-21', '2022-10-21', 4, 20, NULL, 23, 20, '2022-11-04 10:36:01', '2022-11-04 10:36:01'),
(6, 4, 3, 1, 0, 0, 0, '2022-10-24', '2022-10-24', 4, 20, NULL, 7, 1, '2022-10-26 10:19:07', '2022-10-25 20:04:11'),
(7, 5, 2, 1, 0, 0, 0, '2022-10-24', '2022-10-24', 4, 20, NULL, 7, 1, '2022-10-26 10:19:02', '2022-10-24 11:19:07'),
(8, 6, 4, 1, 0, 0, 0, '2022-10-24', '2022-10-24', 4, 20, NULL, 7, 1, '2022-10-26 10:18:58', '2022-10-25 20:04:11'),
(9, 7, 5, 8, 1000, 1000, 0, '2022-11-29', '2022-11-29', 4, 20, NULL, 7, 1, '2023-01-06 12:30:24', '2023-01-06 12:30:24'),
(10, 8, 6, 8, 1000, 1000, 0, '2022-11-29', '2922-11-29', 4, 20, NULL, 7, 1, '2023-01-19 16:01:17', '2023-01-19 16:01:17'),
(11, 9, 7, 8, 1000, 1000, 0, '2022-11-29', '2022-11-29', 4, 20, NULL, 7, 1, '2022-12-19 20:18:18', '2022-12-19 20:18:18'),
(12, 10, 8, 8, 1000, 1000, 700, '2022-12-13', '2022-12-13', 4, 20, NULL, 7, 1, '2022-12-14 16:29:49', '2022-12-14 16:29:49'),
(13, 11, 7, 8, 1000, 1000, 0, '2022-12-19', '2022-12-19', 4, 20, NULL, 7, 1, '2023-02-20 12:36:39', '2023-02-20 12:36:39'),
(14, 12, 5, 8, 1500, 1500, 0, '2023-01-04', '2023-01-04', 4, 20, NULL, 7, 1, '2023-04-20 17:15:21', '2023-04-20 11:45:21'),
(15, 13, 6, 8, 1200, 1200, 0, '2023-01-19', '2023-01-19', 4, 20, NULL, 7, 1, '2023-03-28 11:54:45', '2023-03-28 06:24:45'),
(16, 14, 5, 8, 1072, 1072, 163, '2023-02-15', '2023-02-15', 4, 20, NULL, 7, 1, '2023-04-20 17:15:21', '2023-04-20 11:45:21'),
(17, 15, 7, 8, 2528, 2528, 1970, '2023-02-15', '2023-02-15', 4, 20, NULL, 7, 1, '2023-03-28 10:02:24', '2023-03-28 04:32:24'),
(18, 16, 6, 8, 2000, 2000, 405, '2023-03-28', '2023-03-28', 4, 20, NULL, 7, 1, '2023-04-14 11:56:54', '2023-04-14 06:26:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retenciones`
--

CREATE TABLE `retenciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `valor` double DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo_retencion_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `retenciones`
--

INSERT INTO `retenciones` (`id`, `nombre`, `valor`, `created_at`, `updated_at`, `tipo_retencion_id`, `users_id`) VALUES
(1, 'No aplica a retencion', 0, '2022-03-28 22:47:17', '2022-03-15 03:20:28', 2, 2),
(2, 'Retencion del 1%', 1, '2022-03-28 22:47:22', '2022-03-15 00:49:57', 2, 2),
(3, 'prueba de registro', 18, '2022-03-30 01:35:36', '2022-03-30 07:35:36', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retenciones_has_proveedores`
--

CREATE TABLE `retenciones_has_proveedores` (
  `retenciones_id` int(11) NOT NULL,
  `proveedores_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', '2022-05-16 17:57:39', '2022-05-16 23:57:06'),
(2, 'Vendedor', '2022-05-16 17:57:39', '2022-05-16 23:57:06'),
(3, 'Facturador', '2022-06-07 00:00:00', '2022-06-07 06:00:00'),
(4, 'Contabilidad', '2022-07-12 00:00:00', '2022-07-12 06:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seccion`
--

CREATE TABLE `seccion` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `numeracion` int(11) DEFAULT NULL,
  `estado_id` int(11) NOT NULL,
  `segmento_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `seccion`
--

INSERT INTO `seccion` (`id`, `descripcion`, `numeracion`, `estado_id`, `segmento_id`, `created_at`, `updated_at`) VALUES
(1, 'Seccion A 1', 1, 1, 1, '2022-10-01 09:30:14', '2022-10-01 09:30:14'),
(2, 'Seccion A 2', 2, 2, 1, '2022-10-01 09:30:14', '2022-09-16 23:24:20'),
(3, 'Seccion A 3', 3, 2, 1, '2022-10-01 09:30:14', '2022-09-16 23:24:20'),
(4, 'Seccion A 4', 4, 2, 1, '2022-10-01 09:30:14', '2022-09-16 23:24:20'),
(5, 'Seccion A 5', 5, 2, 1, '2022-10-01 09:30:14', '2022-09-16 23:24:20'),
(6, 'Seccion B 1', 1, 2, 2, '2022-10-01 09:30:14', '2022-09-16 23:24:20'),
(7, 'Seccion B 2', 2, 2, 2, '2022-10-01 09:30:14', '2022-09-16 23:24:20'),
(8, 'Seccion C1', 1, 2, 3, '2022-10-01 09:30:14', '2022-09-16 23:24:52'),
(9, 'Seccion C2', 2, 2, 3, '2022-10-01 09:30:14', '2022-09-16 23:25:04'),
(10, 'Seccion H 1', 1, 1, 4, '2023-01-16 04:36:48', '2023-01-16 10:36:48'),
(11, 'Seccion H 2', 2, 1, 4, '2023-01-16 04:36:48', '2023-01-16 10:36:48'),
(12, 'Seccion H 3', 3, 1, 4, '2023-01-16 04:36:48', '2023-01-16 10:36:48'),
(13, 'Seccion H 4', 4, 1, 4, '2023-01-16 04:36:48', '2023-01-16 10:36:48'),
(14, 'Seccion H5', 5, 1, 4, '2023-01-16 04:37:33', '2023-01-16 10:37:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `segmento`
--

CREATE TABLE `segmento` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `bodega_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `segmento`
--

INSERT INTO `segmento` (`id`, `descripcion`, `bodega_id`, `created_at`, `updated_at`) VALUES
(1, 'A', 1, '2022-09-16 17:24:20', '2022-09-16 23:24:20'),
(2, 'B', 1, '2022-09-16 17:24:20', '2022-09-16 23:24:20'),
(3, 'C', 1, '2022-09-16 17:24:40', '2022-09-16 23:24:40'),
(4, 'H', 2, '2023-01-16 04:36:48', '2023-01-16 10:36:48'),
(5, 'I', 2, '2023-01-16 04:37:45', '2023-01-16 10:37:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BtpdlXLMNLcummXThLoprkKiRXyKhEw4TSgvRtDk', 3, '190.242.26.40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiekFyVk5LYVRqSWdtaXJuS1pldnd1cERRcXBUWUcxTXM4aHZTVW4xaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHA6Ly9zeXNwcm9kLmdydXBvYWxjYS5obi9mYWN0dXJhL2Nvb3BvcmF0aXZvLzQ5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MztzOjIxOiJwYXNzd29yZF9oYXNoX3NhbmN0dW0iO3M6NjA6IiQyeSQxMCRzTFJsSmgxZW1OMDhaaXZMRHdrR1J1Y1R0TUVzOEdiM01JLmxSYURWZm96LngvcHFtdENCQyI7fQ==', 1683763525),
('zYfWqXn9ptJd1vedTh7I9wdumiNgv3kML4ET1D1Y', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiMTBuTzE0eUgxcWtsVnVTMUhhc1VEZkF5SVFuczRwbHFmYkFHbmZjaCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ0OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvZmFjdHVyYS9jb29wb3JhdGl2by80OSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkc0xSbEpoMWVtTjA4Wml2TER3a0dSdWNUdE1FczhHYjNNSS5sUmFEVmZvei54L3BxbXRDQkMiO30=', 1683912058);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_categoria`
--

CREATE TABLE `sub_categoria` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `categoria_producto_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sub_categoria`
--

INSERT INTO `sub_categoria` (`id`, `descripcion`, `categoria_producto_id`, `created_at`, `updated_at`) VALUES
(1, 'PAPEL HIGIENICO', 1, '2022-09-16 17:28:27', '2022-09-16 23:28:27'),
(2, 'PAPEL TOALLA', 1, '2022-10-20 11:03:13', '2022-10-20 11:03:13'),
(3, 'Desperdicio', 1, '2023-02-07 10:28:44', '2023-02-07 16:28:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_menu`
--

CREATE TABLE `sub_menu` (
  `id` int(11) NOT NULL,
  `url` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `teams`
--

CREATE TABLE `teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `personal_team` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `teams`
--

INSERT INTO `teams` (`id`, `user_id`, `name`, `personal_team`, `created_at`, `updated_at`) VALUES
(1, 2, 'Yefry\'s Team', 1, '2022-03-02 03:05:40', '2022-03-02 09:05:40'),
(2, 3, 'Luis\'s Team', 1, '2022-03-07 06:42:26', '2022-03-07 12:42:26'),
(3, 4, 'Usuario\'s Team', 1, '2022-03-15 19:01:19', '2022-03-16 01:01:19'),
(4, 5, 'Selenia\'s Team', 1, '2022-05-03 20:30:19', '2022-05-04 02:30:19'),
(5, 6, 'Josseline\'s Team', 1, '2022-07-09 00:38:24', '2022-07-09 06:38:24'),
(6, 7, 'Graylin\'s Team', 1, '2022-07-09 00:39:48', '2022-07-09 06:39:48'),
(7, 8, 'Francis\'s Team', 1, '2022-07-09 00:41:42', '2022-07-09 06:41:42'),
(8, 9, 'Claudia\'s Team', 1, '2022-07-25 05:39:35', '2022-07-25 11:39:35'),
(9, 10, 'Cristian\'s Team', 1, '2022-07-30 05:06:20', '2022-07-30 11:06:20'),
(10, 11, 'Michael\'s Team', 1, '2022-08-08 08:35:16', '2022-08-08 14:35:16'),
(11, 12, 'Williams\'s Team', 1, '2022-08-31 03:53:21', '2022-08-31 09:53:21'),
(12, 13, 'Belinda\'s Team', 1, '2022-08-31 04:12:48', '2022-08-31 10:12:48'),
(13, 14, 'Sulay\'s Team', 1, '2022-08-31 04:15:38', '2022-08-31 10:15:38'),
(14, 15, 'Oficina\'s Team', 1, '2022-08-31 04:16:14', '2022-08-31 10:16:14'),
(15, 16, 'David\'s Team', 1, '2022-09-01 08:45:23', '2022-09-01 14:45:23'),
(16, 17, 'Edwin\'s Team', 1, '2022-09-01 08:48:55', '2022-09-01 14:48:55'),
(17, 18, 'Jose\'s Team', 1, '2022-09-06 03:20:06', '2022-09-06 09:20:06'),
(18, 19, 'Juan\'s Team', 1, '2022-09-08 09:38:51', '2022-09-08 15:38:51'),
(19, 20, 'Alexis\'s Team', 1, '2022-09-19 03:54:56', '2022-09-19 09:54:56'),
(20, 21, 'Guillermo\'s Team', 1, '2022-09-19 03:57:13', '2022-09-19 09:57:13'),
(21, 22, 'Cristian\'s Team', 1, '2023-01-16 04:07:45', '2023-01-16 10:07:45'),
(22, 23, 'Alba\'s Team', 1, '2023-01-16 04:08:36', '2023-01-16 10:08:36'),
(23, 24, 'Zully\'s Team', 1, '2023-02-10 02:03:53', '2023-02-10 08:03:53'),
(24, 25, 'Olga\'s Team', 1, '2023-03-22 02:06:36', '2023-03-22 08:06:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `team_invitations`
--

CREATE TABLE `team_invitations` (
  `id` int(10) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `team_user`
--

CREATE TABLE `team_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_ajuste`
--

CREATE TABLE `tipo_ajuste` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_ajuste`
--

INSERT INTO `tipo_ajuste` (`id`, `nombre`, `users_id`, `created_at`, `updated_at`) VALUES
(1, 'Prueba de ajuste', 7, '2022-07-29 18:57:20', '2022-07-30 00:57:20'),
(2, 'Pérdidas', 2, '2022-08-02 13:46:03', '2022-08-02 19:46:03'),
(3, 'REGALIA', 5, '2022-08-08 08:11:49', '2022-08-08 14:11:49'),
(4, 'INGRESO DE PRODUCTO SIN FACTURA', 5, '2022-08-19 10:48:32', '2022-08-19 16:48:32'),
(5, 'AJUSTE INVENTARIO INICIAL', 5, '2022-09-03 09:05:19', '2022-09-03 15:05:19'),
(6, 'ORDEN DE ENTREGA', 5, '2022-09-06 07:33:05', '2022-09-06 13:33:05'),
(7, 'REAJUSTE EXISTENCIAS INVENTARIO', 5, '2022-09-09 06:54:23', '2022-09-09 12:54:23'),
(8, 'REQUISICION PARA USO DE OFICINA', 5, '2022-09-10 04:44:18', '2022-09-10 10:44:18'),
(9, 'REQUISICION PARA USO DE BODEGA', 5, '2022-09-10 04:44:37', '2022-09-10 10:44:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_cliente`
--

CREATE TABLE `tipo_cliente` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_cliente`
--

INSERT INTO `tipo_cliente` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Corporativo', '2022-07-20 10:33:41', '2022-05-16 23:52:11'),
(2, 'Estatal', '2022-05-16 17:53:19', '2022-05-16 23:52:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_compra`
--

CREATE TABLE `tipo_compra` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_compra`
--

INSERT INTO `tipo_compra` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Credito', '2022-03-23 19:03:40', NULL),
(2, 'Contado', '2022-03-23 19:03:40', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento_fiscal`
--

CREATE TABLE `tipo_documento_fiscal` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_documento_fiscal`
--

INSERT INTO `tipo_documento_fiscal` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'FACTURACION CAI', '2022-05-25 19:40:36', '2022-05-26 01:40:16'),
(2, 'RETENCION DEL 1%', '2022-06-07 17:54:06', '2022-06-07 23:53:46'),
(3, 'Documento 3', '2022-07-29 19:04:15', '2022-07-30 01:03:35'),
(4, 'Documento 4', '2022-07-29 19:04:15', '2022-07-30 01:03:35'),
(5, 'Documento 5', '2022-07-29 19:04:15', '2022-07-30 01:03:35'),
(6, 'Documento 6', '2022-07-29 19:04:15', '2022-07-30 01:03:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago_cobro`
--

CREATE TABLE `tipo_pago_cobro` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_pago_cobro`
--

INSERT INTO `tipo_pago_cobro` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Efectivo', '2022-07-05 21:43:57', '2022-07-06 03:43:28'),
(2, 'Transferencia Bancaria', '2022-07-05 21:43:57', '2022-07-06 03:43:28'),
(3, 'CHEQUE', '2022-07-29 06:26:23', '2022-07-29 12:26:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_pago_venta`
--

CREATE TABLE `tipo_pago_venta` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_pago_venta`
--

INSERT INTO `tipo_pago_venta` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'contado', '2022-05-20 13:26:10', '2022-05-20 19:25:49'),
(2, 'credito', '2022-05-20 13:26:10', '2022-05-20 19:25:49');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_personalidad`
--

CREATE TABLE `tipo_personalidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_personalidad`
--

INSERT INTO `tipo_personalidad` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Persona Natural', '2022-03-14 18:54:28', NULL),
(2, 'Persona Jurídica', '2022-03-14 18:54:28', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_retencion`
--

CREATE TABLE `tipo_retencion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_retencion`
--

INSERT INTO `tipo_retencion` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Valor real', '2022-03-14 19:02:46', '2022-03-15 01:02:46'),
(2, 'Porcentaje', '2022-03-14 19:02:46', '2022-03-15 01:02:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_venta`
--

CREATE TABLE `tipo_venta` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_venta`
--

INSERT INTO `tipo_venta` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'corporativo', '2022-05-20 13:26:53', '2022-05-20 19:23:23'),
(2, 'estatal', '2022-05-20 13:24:01', '2022-05-20 19:23:23'),
(3, 'exenta de impuesto', '2022-07-20 10:34:12', '2022-07-15 06:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida`
--

CREATE TABLE `unidad_medida` (
  `id` int(11) NOT NULL,
  `unidad` int(11) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `simbolo` varchar(45) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidad_medida`
--

INSERT INTO `unidad_medida` (`id`, `unidad`, `nombre`, `simbolo`, `created_at`, `updated_at`) VALUES
(1, 1, 'UNIDAD', 'UN', '2022-03-23 19:16:22', '2022-03-24 01:08:57'),
(2, 1, 'YARDA', 'YD', '2022-03-23 19:15:54', '2022-03-24 01:08:57'),
(3, 1, ' RESMA', ' RESMA', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(4, 1, ' UNIDAD', ' UNIDAD', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(5, 1, ' GALON', ' GALON', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(6, 1, ' BARRIL', ' BARRIL', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(7, 1, ' FARDO', ' FARDO', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(8, 1, ' DOCENA', ' DOCENA', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(9, 1, ' CUBETA', ' CUBETA', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(10, 1, ' CUARTO', ' CUARTO', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(11, 1, ' CAJA', ' CAJA', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(12, 1, ' BOTE', ' BOTE', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(13, 1, ' BOLSA', ' BOLSA', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(14, 1, ' BLOCK', ' BLOCK', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(15, 1, ' CUBO', ' CUBO', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(16, 1, ' JUEGO', ' JUEGO', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(17, 1, ' KILO', ' KILO', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(18, 1, ' KIT', ' KIT', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(19, 1, ' LANCE', ' LANCE', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(20, 1, ' LATA', ' LATA', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(21, 1, ' LIBRA', ' LIBRA', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(22, 1, ' LITRO', ' LITRO', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(23, 1, ' PAQUETE', ' PAQUETE', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(24, 1, ' PAR', ' PAR', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(25, 1, ' PIEZA', ' PIEZA', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(26, 1, ' PLIEGO', ' PLIEGO', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(27, 1, ' ROLLO', ' ROLLO', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(28, 1, ' SET', ' SET', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(29, 1, ' TONELADA', ' TONELADA', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(30, 1, ' YARDA', ' YARDA', '2022-04-25 00:00:00', '2022-04-25 06:00:00'),
(31, 1, 'BOTE', 'BO', '2022-08-08 07:52:39', '2022-08-08 13:52:39'),
(32, 1, 'POR DEFECTO', 'DF', '2022-08-31 00:45:31', '2022-08-31 06:45:31'),
(33, 1, 'POR DEFECTO DOS', 'PR2', '2022-08-31 01:34:51', '2022-08-31 07:34:51'),
(34, 1, 'GALON', 'GA', '2022-09-06 01:57:35', '2022-09-06 07:57:35');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad_medida_venta`
--

CREATE TABLE `unidad_medida_venta` (
  `id` int(11) NOT NULL,
  `unidad_venta` double NOT NULL,
  `unidad_medida_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `estado_id` int(11) NOT NULL,
  `unidad_venta_defecto` tinyint(4) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `unidad_medida_venta`
--

INSERT INTO `unidad_medida_venta` (`id`, `unidad_venta`, `unidad_medida_id`, `producto_id`, `estado_id`, `unidad_venta_defecto`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, '2022-09-16 17:32:08', '2022-09-16 23:32:08'),
(2, 20, 23, 1, 1, 0, '2022-09-16 17:32:08', '2022-09-16 23:32:08'),
(3, 1, 7, 2, 1, 1, '2022-10-18 06:42:09', '2022-10-18 12:42:09'),
(4, 1, 7, 3, 1, 1, '2022-10-20 04:58:15', '2022-10-20 10:58:15'),
(5, 1, 7, 4, 1, 1, '2022-10-20 05:01:28', '2022-10-20 11:01:28'),
(6, 1, 7, 5, 1, 1, '2022-11-29 08:02:25', '2022-11-29 14:02:25'),
(7, 1, 7, 6, 1, 1, '2022-11-29 08:05:11', '2022-11-29 14:05:11'),
(8, 1, 7, 7, 1, 1, '2022-11-29 08:07:02', '2022-11-29 14:07:02'),
(9, 1, 7, 8, 1, 1, '2022-12-13 10:54:57', '2022-12-13 16:54:57'),
(10, 1, 23, 9, 1, 1, '2023-02-07 10:30:56', '2023-02-07 16:30:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identidad` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci,
  `fecha_nacimiento` date DEFAULT NULL,
  `telefono` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `identidad`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `fecha_nacimiento`, `telefono`, `rol_id`, `created_at`, `updated_at`) VALUES
(2, '0801199612356', 'Yefry Ortiz', 'yefryyo@gmail.com', NULL, '$2y$10$QIB4PVDOvAcvTSyB7gdg1ehQTcA.7HB77n.281AfYumVqlpk4iNqW', NULL, NULL, 'DeMxuWaIKJSAu3U3z6sXewMj2NVgmpm3eFR2werDAqzMgP3AHOwmLwFqzaMk', 1, NULL, '1996-04-01', '22336699', 2, '2022-03-02 03:05:40', '2023-03-20 13:03:59'),
(3, '0822199887008', 'Admin', 'admin@gmail.com', NULL, '$2y$10$sLRlJh1emN08ZivLDwkGRucTtMEs8Gb3MI.lRaDVfoz.x/pqmtCBC', NULL, NULL, 'qJDXnaT06ogGGuV45hfUxHmKEOzrV8FZ1FgxlyY859E1mvROxXqDEp8Ur9Q8', 2, 'profile-photos/VAHc8JdbH4B2Im1jxRgnSMnROaz7Gp2QaUi138zI.jpg', '1995-03-16', '89282146', 1, '2022-03-07 06:42:26', '2022-09-19 10:06:27'),
(20, NULL, 'Alexis Arias', 'alexis.arias@grupoalca.hn', NULL, '$2y$10$eQXJiJ66xkUehV9oLlZT0ehSVEbxKxWy09lhHNPWHChEDOcOX9zJO', NULL, NULL, 'V8KNQ566co9nTicNvAUtX1vHzeykRwR7ZtS7HUm5dCu7lHyJ7MaBG667AHpZ', NULL, NULL, NULL, NULL, 2, '2022-09-19 03:54:56', '2022-09-19 09:54:56'),
(21, NULL, 'Guillermo Arias', 'guillermo.arias@grupoalca.hn', NULL, '$2y$10$CXECaeqH6e9Nz/q2rq2sEOBoWOXoZ1nP2jljYYHF/dfcsHbyQhPWe', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2022-09-19 03:57:13', '2022-09-19 09:57:13'),
(22, NULL, 'Cristian Zelaya', 'cristian.zelaya@grupoalca.hn', NULL, '$2y$10$4/2ozTPTSFp5mwcPeoSaCOljk/c8J0j0LXd3VYENXgChlQK7XMNpG', NULL, NULL, 'QWP23tZoSqCNF4MeoOcaOepIhYUAyxvXPvXJGN7m9empL68kZIkwI4tFiUbD', NULL, 'profile-photos/AZUlp2lazl0NGeKtB32BDb2FVETSOjRFPgcPnBfn.jpg', NULL, NULL, 1, '2023-01-16 04:07:45', '2023-01-16 13:50:39'),
(23, NULL, 'Alba Rodas', 'alba.rodas@grupoalca.hn', NULL, '$2y$10$iz/dxWQRyI.EWtTxlQXhDuepDlwTGFS93.F01yVVFoWIjZYcViwtK', NULL, NULL, 'VZuvhMMPxAutOuWDMFvlc1Q7g9FKiiB87b3qpzTrB5CjRi1egXadD2lEC0I6', NULL, NULL, NULL, NULL, 2, '2023-01-16 04:08:36', '2023-01-16 10:08:36'),
(24, NULL, 'Zully Garcia', 'zully.garcia@grupoalca.hn', NULL, '$2y$10$t97a8d951aQ/e84Bgj3f5./Dg1equ3by1ErvfgnLAYkhaUgHVx6T2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2023-02-10 02:03:53', '2023-02-10 08:03:53'),
(25, NULL, 'Olga Oseguera', 'olgaoseguera@grupoalca.hn', NULL, '$2y$10$n9tbwZaUX9p9lBKFaWFoxu5b3wa6m8KyrL/tYr1r3U8KpsJetc7u.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, '2023-03-22 02:06:36', '2023-03-22 08:06:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vale`
--

CREATE TABLE `vale` (
  `id` int(11) NOT NULL,
  `numero_vale` varchar(45) NOT NULL,
  `sub_total` decimal(10,0) NOT NULL,
  `sub_total_grabado` decimal(10,0) NOT NULL,
  `sub_total_excento` decimal(10,0) NOT NULL,
  `isv` double NOT NULL,
  `total` double NOT NULL,
  `factura_id` int(11) NOT NULL,
  `users_id` bigint(20) UNSIGNED NOT NULL,
  `notas` text,
  `comentario_anular` text,
  `comentario_eliminar` text,
  `estado_id` int(11) NOT NULL COMMENT 'estado de activo o inactivo',
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vale_has_producto`
--

CREATE TABLE `vale_has_producto` (
  `vale_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `lote_id` int(11) NOT NULL,
  `seccion_id` int(11) NOT NULL,
  `unidad_medida_venta_id` int(11) NOT NULL,
  `precio_unidad` double NOT NULL,
  `sub_total` double NOT NULL,
  `isv` double NOT NULL,
  `total` double NOT NULL,
  `sub_total_s` double NOT NULL,
  `isv_s` double NOT NULL,
  `total_s` double NOT NULL,
  `cantidad_para_entregar` double NOT NULL COMMENT 'la cantidad convertidad a unidad minima',
  `cantidad_s` double NOT NULL,
  `resta_inventario_total` double NOT NULL,
  `resta_inventario_unidades` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_has_producto`
--

CREATE TABLE `venta_has_producto` (
  `factura_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `lote` int(11) NOT NULL,
  `indice` int(11) NOT NULL DEFAULT '0',
  `seccion_id` int(11) NOT NULL,
  `numero_unidades_resta_inventario` int(11) NOT NULL,
  `unidades_nota_credito_resta_inventario` int(11) NOT NULL DEFAULT '0',
  `cantidad_nota_credito` int(11) NOT NULL DEFAULT '0',
  `resta_inventario_total` int(11) NOT NULL COMMENT 'el total de unidades que se resto al inventario',
  `unidad_medida_venta_id` int(11) NOT NULL,
  `precio_unidad` double NOT NULL,
  `cantidad` double NOT NULL COMMENT 'cantidad ingresada por usuario',
  `cantidad_s` double NOT NULL,
  `cantidad_para_entregar` double NOT NULL,
  `sub_total` double NOT NULL,
  `isv` double NOT NULL,
  `total` double NOT NULL,
  `sub_total_s` double NOT NULL,
  `isv_s` double NOT NULL,
  `total_s` double NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `venta_has_producto`
--

INSERT INTO `venta_has_producto` (`factura_id`, `producto_id`, `lote`, `indice`, `seccion_id`, `numero_unidades_resta_inventario`, `unidades_nota_credito_resta_inventario`, `cantidad_nota_credito`, `resta_inventario_total`, `unidad_medida_venta_id`, `precio_unidad`, `cantidad`, `cantidad_s`, `cantidad_para_entregar`, `sub_total`, `isv`, `total`, `sub_total_s`, `isv_s`, `total_s`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 0, 7, 296, 0, 0, 296, 1, 54.5, 296, 296, 0, 16132, 0, 16132, 16132, 0, 16132, '2022-11-04 04:36:01', '2022-11-04 10:36:01'),
(2, 5, 9, 0, 8, 144, 0, 0, 144, 6, 107.9, 144, 144, 0, 15537.6, 0, 15537.6, 15537.6, 0, 15537.6, '2022-11-29 08:28:02', '2022-11-29 14:28:02'),
(2, 6, 10, 0, 8, 80, 0, 0, 80, 7, 102.5, 80, 80, 0, 8200, 0, 8200, 8200, 0, 8200, '2022-11-29 08:28:02', '2022-11-29 14:28:02'),
(3, 5, 9, 0, 8, 96, 0, 0, 96, 6, 107.9, 96, 96, 0, 10358.4, 0, 10358.4, 10358.4, 0, 10358.4, '2022-12-07 04:26:57', '2022-12-07 10:26:57'),
(3, 7, 11, 0, 8, 144, 0, 0, 144, 8, 82.7, 144, 144, 0, 11908.8, 0, 11908.8, 11908.8, 0, 11908.8, '2022-12-07 04:26:57', '2022-12-07 10:26:57'),
(4, 7, 11, 0, 8, 288, 0, 0, 288, 8, 82.7, 288, 288, 0, 23817.6, 0, 23817.6, 23817.6, 0, 23817.6, '2022-12-12 04:44:29', '2022-12-12 10:44:29'),
(5, 5, 9, 0, 8, 225, 0, 0, 225, 6, 107.9, 225, 225, 0, 24277.5, 0, 24277.5, 24277.5, 0, 24277.5, '2022-12-12 06:27:39', '2022-12-12 12:27:39'),
(6, 7, 11, 0, 8, 295, 0, 0, 295, 8, 82.7, 295, 295, 0, 24396.5, 0, 24396.5, 24396.5, 0, 24396.5, '2022-12-13 10:37:21', '2022-12-13 16:37:21'),
(7, 5, 9, 0, 8, 80, 0, 0, 80, 6, 107.9, 80, 80, 0, 8632, 0, 8632, 8632, 0, 8632, '2022-12-13 11:01:55', '2022-12-13 17:01:55'),
(7, 8, 12, 0, 8, 120, 0, 0, 120, 9, 122.73, 120, 120, 0, 14727.6, 0, 14727.6, 14727.6, 0, 14727.6, '2022-12-13 11:01:55', '2022-12-13 17:01:55'),
(8, 8, 12, 0, 8, 180, 0, 0, 180, 9, 122.73, 180, 180, 0, 22091.4, 0, 22091.4, 22091.4, 0, 22091.4, '2022-12-14 10:29:49', '2022-12-14 16:29:49'),
(9, 7, 11, 0, 8, 282, 0, 0, 282, 8, 82.7, 282, 282, 0, 23321.4, 0, 23321.4, 23321.4, 0, 23321.4, '2022-12-15 05:22:55', '2022-12-15 11:22:55'),
(10, 7, 11, 0, 8, 135, 0, 0, 275, 8, 82.7, 275, 135, 0, 22742.5, 0, 22742.5, 11164.5, 0, 11164.5, '2022-12-19 14:18:18', '2022-12-19 20:18:18'),
(10, 7, 13, 0, 8, 140, 0, 0, 275, 8, 82.7, 275, 140, 0, 22742.5, 0, 22742.5, 11578, 0, 11578, '2022-12-19 14:18:18', '2022-12-19 20:18:18'),
(11, 7, 13, 0, 8, 288, 0, 0, 288, 8, 82.7, 288, 288, 0, 23817.6, 0, 23817.6, 23817.6, 0, 23817.6, '2022-12-20 09:17:41', '2022-12-20 15:17:41'),
(12, 5, 9, 0, 8, 215, 0, 0, 215, 6, 107.9, 215, 215, 0, 23198.5, 0, 23198.5, 23198.5, 0, 23198.5, '2023-01-02 07:04:25', '2023-01-02 13:04:25'),
(13, 5, 9, 0, 8, 200, 0, 0, 200, 6, 107.9, 200, 200, 0, 21580, 0, 21580, 21580, 0, 21580, '2023-01-04 04:35:21', '2023-01-04 10:35:21'),
(14, 5, 14, 0, 8, 220, 0, 0, 220, 6, 107.9, 220, 220, 0, 23738, 0, 23738, 23738, 0, 23738, '2023-01-04 05:14:50', '2023-01-04 11:14:50'),
(15, 5, 9, 0, 8, 136, 0, 0, 220, 6, 107.9, 220, 136, 0, 23738, 0, 23738, 14674.4, 0, 14674.4, '2023-01-06 06:30:24', '2023-01-06 12:30:24'),
(15, 5, 14, 0, 8, 84, 0, 0, 220, 6, 107.9, 220, 84, 0, 23738, 0, 23738, 9063.6, 0, 9063.6, '2023-01-06 06:30:24', '2023-01-06 12:30:24'),
(16, 6, 10, 0, 8, 240, 0, 0, 240, 7, 102.5, 240, 240, 0, 24600, 0, 24600, 24600, 0, 24600, '2023-01-09 15:53:06', '2023-01-09 21:53:06'),
(17, 6, 10, 0, 8, 215, 0, 0, 215, 7, 102.5, 215, 215, 0, 22037.5, 0, 22037.5, 22037.5, 0, 22037.5, '2023-01-09 15:55:30', '2023-01-09 21:55:30'),
(18, 6, 10, 0, 8, 240, 0, 0, 240, 7, 102.5, 240, 240, 0, 24600, 0, 24600, 24600, 0, 24600, '2023-01-10 06:31:35', '2023-01-10 12:31:35'),
(19, 6, 10, 0, 8, 210, 0, 0, 210, 7, 102.5, 210, 210, 0, 21525, 0, 21525, 21525, 0, 21525, '2023-01-10 06:35:55', '2023-01-10 12:35:55'),
(20, 7, 13, 0, 8, 288, 0, 0, 288, 8, 82.7, 288, 288, 0, 23817.6, 0, 23817.6, 23817.6, 0, 23817.6, '2023-01-12 07:05:47', '2023-01-12 13:05:47'),
(21, 6, 10, 0, 8, 15, 0, 0, 220, 7, 102.5, 220, 15, 0, 22550, 0, 22550, 1537.5, 0, 1537.5, '2023-01-19 10:01:17', '2023-01-19 16:01:17'),
(21, 6, 15, 0, 8, 205, 0, 0, 220, 7, 102.5, 220, 205, 0, 22550, 0, 22550, 21012.5, 0, 21012.5, '2023-01-19 10:01:17', '2023-01-19 16:01:17'),
(22, 7, 13, 0, 8, 20, 0, 0, 20, 8, 82.7, 20, 20, 0, 1654, 0, 1654, 1654, 0, 1654, '2023-02-01 02:53:38', '2023-02-01 08:53:38'),
(23, 6, 15, 0, 8, 180, 0, 0, 180, 7, 102.5, 180, 180, 0, 18450, 0, 18450, 18450, 0, 18450, '2023-02-06 10:16:22', '2023-02-06 16:16:22'),
(24, 6, 15, 0, 8, 150, 0, 0, 150, 7, 102.5, 150, 150, 0, 15375, 0, 15375, 15375, 0, 15375, '2023-02-07 10:33:16', '2023-02-07 16:33:16'),
(25, 6, 15, 0, 8, 225, 0, 0, 225, 7, 102.5, 225, 225, 0, 23062.5, 0, 23062.5, 23062.5, 0, 23062.5, '2023-02-15 05:44:43', '2023-02-15 11:44:43'),
(26, 6, 15, 0, 8, 191, 0, 0, 191, 7, 102.5, 191, 191, 0, 19577.5, 0, 19577.5, 19577.5, 0, 19577.5, '2023-02-16 09:46:56', '2023-02-16 15:46:56'),
(27, 7, 13, 0, 8, 264, 0, 0, 281, 8, 82.7, 281, 264, 0, 23238.7, 0, 23238.7, 21832.8, 0, 21832.8, '2023-02-20 06:36:39', '2023-02-20 12:36:39'),
(27, 7, 17, 0, 8, 17, 0, 0, 281, 8, 82.7, 281, 17, 0, 23238.7, 0, 23238.7, 1405.9, 0, 1405.9, '2023-02-20 06:36:39', '2023-02-20 12:36:39'),
(28, 7, 17, 0, 8, 251, 0, 0, 251, 8, 82.7, 251, 251, 0, 20757.7, 0, 20757.7, 20757.7, 0, 20757.7, '2023-02-21 09:13:11', '2023-02-21 15:13:11'),
(29, 7, 17, 0, 8, 290, 0, 0, 290, 8, 82.7, 290, 290, 0, 23983, 0, 23983, 23983, 0, 23983, '2023-02-22 09:34:29', '2023-02-22 15:34:29'),
(30, 5, 14, 0, 8, 219, 0, 0, 219, 6, 107.9, 219, 219, 0, 23630.1, 0, 23630.1, 23630.1, 0, 23630.1, '2023-02-24 05:02:47', '2023-02-24 11:02:47'),
(31, 5, 16, 0, 8, 204, 0, 0, 204, 6, 107.9, 204, 204, 0, 22011.6, 0, 22011.6, 22011.6, 0, 22011.6, '2023-02-27 02:37:24', '2023-02-27 08:37:24'),
(32, 5, 14, 0, 8, 190, 0, 0, 190, 6, 107.9, 190, 190, 0, 20501, 0, 20501, 20501, 0, 20501, '2023-02-28 03:49:26', '2023-02-28 09:49:26'),
(33, 5, 16, 0, 8, 190, 0, 0, 190, 6, 107.9, 190, 190, 0, 20501, 0, 20501, 20501, 0, 20501, '2023-03-08 02:49:11', '2023-03-08 08:49:11'),
(34, 5, 14, 0, 8, 216, 0, 0, 216, 6, 107.9, 216, 216, 0, 23306.4, 0, 23306.4, 23306.4, 0, 23306.4, '2023-03-09 04:49:19', '2023-03-09 10:49:19'),
(35, 5, 16, 0, 8, 228, 0, 0, 228, 6, 107.9, 228, 228, 0, 24601.2, 0, 24601.2, 24601.2, 0, 24601.2, '2023-03-23 03:13:20', '2023-03-23 09:13:20'),
(36, 5, 14, 0, 8, 215, 0, 0, 215, 6, 107.9, 215, 215, 0, 23198.5, 0, 23198.5, 23198.5, 0, 23198.5, '2023-03-23 22:04:28', '2023-03-24 04:04:28'),
(37, 6, 15, 0, 8, 210, 0, 0, 210, 7, 102.5, 210, 210, 0, 21525, 0, 21525, 21525, 0, 21525, '2023-03-26 21:01:04', '2023-03-27 03:01:04'),
(38, 7, 17, 0, 8, 270, 0, 0, 270, 8, 82.7, 270, 270, 0, 22329, 0, 22329, 22329, 0, 22329, '2023-03-27 22:13:58', '2023-03-28 04:13:58'),
(39, 5, 16, 0, 8, 216, 0, 0, 216, 6, 107.9, 216, 216, 0, 23306.4, 0, 23306.4, 23306.4, 0, 23306.4, '2023-03-27 23:38:53', '2023-03-28 05:38:53'),
(40, 6, 15, 0, 8, 39, 0, 0, 242, 7, 99, 242, 39, 0, 23958, 0, 23958, 3861, 0, 3861, '2023-03-28 00:24:45', '2023-03-28 06:24:45'),
(40, 6, 18, 0, 8, 203, 0, 0, 242, 7, 99, 242, 203, 0, 23958, 0, 23958, 20097, 0, 20097, '2023-03-28 00:24:45', '2023-03-28 06:24:45'),
(41, 6, 18, 0, 8, 210, 0, 0, 210, 7, 99, 210, 210, 0, 20790, 0, 20790, 20790, 0, 20790, '2023-03-28 21:01:21', '2023-03-29 03:01:21'),
(42, 6, 18, 0, 8, 228, 0, 0, 228, 7, 99, 228, 228, 0, 22572, 0, 22572, 22572, 0, 22572, '2023-03-29 22:23:36', '2023-03-30 04:23:36'),
(43, 6, 18, 0, 8, 231, 0, 0, 231, 7, 99, 231, 231, 0, 22869, 0, 22869, 22869, 0, 22869, '2023-03-31 02:39:22', '2023-03-31 08:39:22'),
(44, 6, 18, 0, 8, 245, 0, 0, 245, 7, 99, 245, 245, 0, 24255, 0, 24255, 24255, 0, 24255, '2023-04-10 21:05:52', '2023-04-11 03:05:52'),
(45, 6, 18, 0, 8, 243, 0, 0, 243, 7, 99, 243, 243, 0, 24057, 0, 24057, 24057, 0, 24057, '2023-04-12 00:32:24', '2023-04-12 06:32:24'),
(46, 6, 18, 0, 8, 235, 0, 0, 235, 7, 99, 235, 235, 0, 23265, 0, 23265, 23265, 0, 23265, '2023-04-14 00:26:54', '2023-04-14 06:26:54'),
(47, 5, 14, 0, 8, 223, 0, 0, 223, 6, 107.9, 223, 223, 0, 24061.7, 0, 24061.7, 24061.7, 0, 24061.7, '2023-04-17 22:38:08', '2023-04-18 04:38:08'),
(48, 5, 16, 0, 8, 220, 0, 0, 220, 6, 107.9, 220, 220, 0, 23738, 0, 23738, 23738, 0, 23738, '2023-04-19 05:50:21', '2023-04-19 11:50:21'),
(49, 5, 14, 0, 8, 133, 0, 0, 200, 6, 107.9, 200, 133, 0, 21580, 0, 21580, 14350.7, 0, 14350.7, '2023-04-20 05:45:21', '2023-04-20 11:45:21'),
(49, 5, 16, 0, 8, 67, 0, 0, 200, 6, 107.9, 200, 67, 0, 21580, 0, 21580, 7229.3, 0, 7229.3, '2023-04-20 05:45:21', '2023-04-20 11:45:21');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ajuste`
--
ALTER TABLE `ajuste`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ajuste_tipo_ajuste1_idx` (`tipo_ajuste_id`),
  ADD KEY `fk_ajuste_users1_idx` (`solicitado_por`),
  ADD KEY `fk_ajuste_users2_idx` (`users_id`);

--
-- Indices de la tabla `ajuste_has_producto`
--
ALTER TABLE `ajuste_has_producto`
  ADD PRIMARY KEY (`ajuste_id`,`producto_id`,`recibido_bodega_id`),
  ADD KEY `fk_ajuste_has_producto_producto1_idx` (`producto_id`),
  ADD KEY `fk_ajuste_has_producto_ajuste1_idx` (`ajuste_id`),
  ADD KEY `fk_ajuste_has_producto_recibido_bodega1_idx` (`recibido_bodega_id`),
  ADD KEY `fk_ajuste_has_producto_unidad_medida_venta1_idx` (`unidad_medida_venta_id`);

--
-- Indices de la tabla `banco`
--
ALTER TABLE `banco`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_banco_users1_idx` (`users_id`);

--
-- Indices de la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bodega_estado1_idx` (`estado_id`),
  ADD KEY `fk_bodega_municipio1_idx` (`municipio_id`),
  ADD KEY `fk_bodega_users1_idx` (`encargado_bodega`);

--
-- Indices de la tabla `cai`
--
ALTER TABLE `cai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_CAI_tipo_documento_fiscal1_idx` (`tipo_documento_fiscal_id`),
  ADD KEY `fk_CAI_estado1_idx` (`estado_id`),
  ADD KEY `fk_cai_users1_idx` (`users_id`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url_imagen_UNIQUE` (`url_imagen`),
  ADD KEY `fk_cliente_tipo_cliente1_idx` (`tipo_cliente_id`),
  ADD KEY `fk_cliente_tipo_personalidad1_idx` (`tipo_personalidad_id`),
  ADD KEY `fk_cliente_categoria1_idx` (`categoria_id`),
  ADD KEY `fk_cliente_users1_idx` (`users_id`),
  ADD KEY `fk_cliente_users2_idx` (`vendedor`),
  ADD KEY `fk_cliente_estado_cliente1_idx` (`estado_cliente_id`),
  ADD KEY `fk_cliente_municipio1_idx` (`municipio_id`);

--
-- Indices de la tabla `codigo_autorizacion`
--
ALTER TABLE `codigo_autorizacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_codigo_autorizacion_estado1_idx` (`estado_id`);

--
-- Indices de la tabla `codigo_exoneracion`
--
ALTER TABLE `codigo_exoneracion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_codigo_exoneracion_cliente1_idx` (`cliente_id`),
  ADD KEY `fk_codigo_exoneracion_estado1_idx` (`estado_id`);

--
-- Indices de la tabla `comision`
--
ALTER TABLE `comision`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comision_comision_techo1_idx` (`comision_techo_id`),
  ADD KEY `fk_comision_factura1_idx` (`factura_id`),
  ADD KEY `fk_comision_users2_idx` (`vendedor_id`),
  ADD KEY `fk_comision_estado2_idx` (`estado_id`),
  ADD KEY `fk_comision_users3_idx` (`users_registro_id`);

--
-- Indices de la tabla `comision_techo`
--
ALTER TABLE `comision_techo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comision_users1_idx` (`vendedor_id`),
  ADD KEY `fk_comision_estado1_idx` (`estado_id`),
  ADD KEY `fk_comision_techo_meses1_idx` (`meses_id`);

--
-- Indices de la tabla `comision_temp`
--
ALTER TABLE `comision_temp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comision_comision_techo1_idx` (`comision_techo_id`),
  ADD KEY `fk_comision_factura1_idx` (`factura_id`),
  ADD KEY `fk_comision_users2_idx` (`vendedor_id`),
  ADD KEY `fk_comision_estado2_idx` (`estado_id`),
  ADD KEY `fk_comision_users3_idx` (`users_registro_id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compra_proveedores1_idx` (`proveedores_id`),
  ADD KEY `fk_compra_users1_idx` (`users_id`),
  ADD KEY `fk_compra_tipo_compra1_idx` (`tipo_compra_id`),
  ADD KEY `fk_compra_retenciones1_idx` (`retenciones_id`),
  ADD KEY `fk_compra_estado_compra1_idx` (`estado_compra_id`),
  ADD KEY `fk_compra_cai1_idx` (`cai_id`);

--
-- Indices de la tabla `compra_has_producto`
--
ALTER TABLE `compra_has_producto`
  ADD PRIMARY KEY (`compra_id`,`producto_id`),
  ADD KEY `fk_compra_has_producto_producto1_idx` (`producto_id`),
  ADD KEY `fk_compra_has_producto_compra1_idx` (`compra_id`),
  ADD KEY `fk_compra_has_producto_unidad_medida1_idx` (`unidad_compra_id`);

--
-- Indices de la tabla `comprovante_entrega`
--
ALTER TABLE `comprovante_entrega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comprovante_entrega_cliente1_idx` (`cliente_id`),
  ADD KEY `fk_comprovante_entrega_tipo_venta1_idx` (`tipo_venta_id`),
  ADD KEY `fk_comprovante_entrega_users1_idx` (`users_id`),
  ADD KEY `fk_comprovante_entrega_estado1_idx` (`estado_id`);

--
-- Indices de la tabla `comprovante_has_producto`
--
ALTER TABLE `comprovante_has_producto`
  ADD PRIMARY KEY (`comprovante_id`,`producto_id`,`lote_id`),
  ADD KEY `fk_comprovante_entrega_has_producto_producto1_idx` (`producto_id`),
  ADD KEY `fk_comprovante_entrega_has_producto_comprovante_entrega1_idx` (`comprovante_id`),
  ADD KEY `fk_comprovante_has_producto_recibido_bodega1_idx` (`lote_id`),
  ADD KEY `fk_comprovante_has_producto_unidad_medida_venta1_idx` (`unidad_medida_venta_id`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contacto_cliente1_idx` (`cliente_id`),
  ADD KEY `fk_contacto_estado1_idx` (`estado_id`);

--
-- Indices de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cotizacion_cliente1_idx` (`cliente_id`),
  ADD KEY `fk_cotizacion_tipo_venta1_idx` (`tipo_venta_id`),
  ADD KEY `fk_cotizacion_users1_idx` (`users_id`);

--
-- Indices de la tabla `cotizacion_has_producto`
--
ALTER TABLE `cotizacion_has_producto`
  ADD PRIMARY KEY (`cotizacion_id`,`producto_id`),
  ADD KEY `fk_cotizacion_has_producto_producto1_idx` (`producto_id`),
  ADD KEY `fk_cotizacion_has_producto_cotizacion1_idx` (`cotizacion_id`),
  ADD KEY `fk_cotizacion_has_producto_seccion1_idx` (`seccion_id`),
  ADD KEY `fk_cotizacion_has_producto_unidad_medida_venta1_idx` (`unidad_medida_venta_id`);

--
-- Indices de la tabla `cvdolar`
--
ALTER TABLE `cvdolar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_departamento_pais1_idx` (`pais_id`);

--
-- Indices de la tabla `desglose`
--
ALTER TABLE `desglose`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_desglose_factura1_idx` (`idFactura`),
  ADD KEY `fk_desglose_users1_idx` (`vendedor_id`);

--
-- Indices de la tabla `desglose_temp`
--
ALTER TABLE `desglose_temp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_desglose_factura1_idx` (`idFactura`),
  ADD KEY `fk_desglose_users1_idx` (`vendedor_id`);

--
-- Indices de la tabla `entrega_programada`
--
ALTER TABLE `entrega_programada`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_entrega_programada_users1_idx` (`users_id`),
  ADD KEY `fk_entrega_programada_venta_has_producto1_idx` (`factura_id`,`producto_id`,`lote`);

--
-- Indices de la tabla `enumeracion`
--
ALTER TABLE `enumeracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `espera_has_producto`
--
ALTER TABLE `espera_has_producto`
  ADD PRIMARY KEY (`vale_id`,`producto_id`),
  ADD KEY `fk_vale_has_producto1_producto1_idx` (`producto_id`),
  ADD KEY `fk_vale_has_producto1_vale1_idx` (`vale_id`),
  ADD KEY `fk_espera_has_producto_unidad_medida_venta1_idx` (`unidad_medida_venta_id`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_cliente`
--
ALTER TABLE `estado_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_compra`
--
ALTER TABLE `estado_compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_editar`
--
ALTER TABLE `estado_editar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_factura`
--
ALTER TABLE `estado_factura`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_nota`
--
ALTER TABLE `estado_nota`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_producto`
--
ALTER TABLE `estado_producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estado_venta`
--
ALTER TABLE `estado_venta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_venta_estado_venta1_idx` (`estado_venta_id`),
  ADD KEY `fk_venta_cliente1_idx` (`cliente_id`),
  ADD KEY `fk_venta_users1_idx` (`vendedor`),
  ADD KEY `fk_venta_tipo_venta1_idx` (`tipo_venta_id`),
  ADD KEY `fk_venta_cai1_idx` (`cai_id`),
  ADD KEY `fk_factura_tipo_pago1_idx` (`tipo_pago_id`),
  ADD KEY `fk_factura_estado_factura1_idx` (`estado_factura_id`),
  ADD KEY `fk_factura_users1_idx` (`users_id`),
  ADD KEY `fk_factura_estado_editar1_idx` (`estado_editar`),
  ADD KEY `fk_factura_codigo_exoneracion1_idx` (`codigo_exoneracion_id`),
  ADD KEY `fk_factura_numero_orden_compra1_idx` (`numero_orden_compra_id`),
  ADD KEY `fk_factura_codigo_autorizacion1_idx` (`codigo_autorizacion_id`),
  ADD KEY `fk_factura_comprovante_entrega1_idx` (`comprovante_entrega_id`);

--
-- Indices de la tabla `facturas_pagadas`
--
ALTER TABLE `facturas_pagadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_facturas_pagadas_factura1_idx` (`factura_id`),
  ADD KEY `fk_facturas_pagadas_comision1_idx` (`comision_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `img_producto`
--
ALTER TABLE `img_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_img_producto_producto1_idx` (`producto_id`),
  ADD KEY `fk_img_producto_users1_idx` (`users_id`);

--
-- Indices de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url_img_UNIQUE` (`url_img`),
  ADD KEY `fk_incidencia_recibido_bodega1_idx` (`recibido_bodega_id`),
  ADD KEY `fk_incidencia_users1_idx` (`users_id`);

--
-- Indices de la tabla `incidencia_compra`
--
ALTER TABLE `incidencia_compra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url_img_UNIQUE` (`url_img`),
  ADD KEY `fk_incidencia_compra_compra_has_producto1_idx` (`compra_id`,`producto_id`),
  ADD KEY `fk_incidencia_compra_users1_idx` (`users_id`);

--
-- Indices de la tabla `interes`
--
ALTER TABLE `interes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_intereses_estado_venta1_idx` (`estado_venta_id`),
  ADD KEY `fk_intereses_factura1_idx` (`factura_id`),
  ADD KEY `fk_intereses_users1_idx` (`users_id`);

--
-- Indices de la tabla `listado`
--
ALTER TABLE `listado`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `log_credito`
--
ALTER TABLE `log_credito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_credito_cliente1_idx` (`cliente_id`);

--
-- Indices de la tabla `log_estado`
--
ALTER TABLE `log_estado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_estado_compra1_idx` (`compra_id`),
  ADD KEY `fk_log_estado_estado_compra1_idx` (`estado_anterior_compra`),
  ADD KEY `fk_log_estado_users1_idx` (`users_id`);

--
-- Indices de la tabla `log_estado_factura`
--
ALTER TABLE `log_estado_factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_estado_factura_factura1_idx` (`factura_id`),
  ADD KEY `fk_log_estado_factura_estado_venta1_idx` (`estado_venta_id_anterior`),
  ADD KEY `fk_log_estado_factura_users1_idx` (`users_id`);

--
-- Indices de la tabla `log_translado`
--
ALTER TABLE `log_translado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_translado_recibido_bodega1_idx` (`origen`),
  ADD KEY `fk_log_translado_recibido_bodega2_idx` (`destino`),
  ADD KEY `fk_log_translado_users1_idx` (`users_id`),
  ADD KEY `fk_log_translado_ajuste1_idx` (`ajuste_id`),
  ADD KEY `fk_log_translado_factura1_idx` (`factura_id`),
  ADD KEY `fk_log_translado_compra1_idx` (`compra_id`),
  ADD KEY `fk_log_translado_unidad_medida_venta1_idx` (`unidad_medida_venta_id`),
  ADD KEY `fk_log_translado_comprovante_entrega1_idx` (`comprovante_entrega_id`),
  ADD KEY `fk_log_translado_vale1_idx` (`vale_id`),
  ADD KEY `fk_log_translado_nota_credito1_idx` (`nota_credito_id`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_marca_users1_idx` (`users_id`);

--
-- Indices de la tabla `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_menu_rol1_idx` (`rol_id`);

--
-- Indices de la tabla `meses`
--
ALTER TABLE `meses`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `montonotadebito`
--
ALTER TABLE `montonotadebito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_montoNotaDebito_estado1_idx` (`estado_id`),
  ADD KEY `fk_montoNotaDebito_users1_idx` (`users_registra_id`);

--
-- Indices de la tabla `motivo_nota_credito`
--
ALTER TABLE `motivo_nota_credito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_motivo_nota_credito_users1_idx` (`users_id`);

--
-- Indices de la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_municipio_departamento1_idx` (`departamento_id`);

--
-- Indices de la tabla `notadebito`
--
ALTER TABLE `notadebito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notaDebito_factura1_idx` (`factura_id`),
  ADD KEY `fk_notaDebito_montoNotaDebito1_idx` (`montoNotaDebito_id`),
  ADD KEY `fk_notaDebito_estado1_idx` (`estado_id`),
  ADD KEY `fk_notaDebito_users1_idx` (`users_registra_id`);

--
-- Indices de la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nota_credito_factura1_idx` (`factura_id`),
  ADD KEY `fk_nota_credito_motivo_nota_credito1_idx` (`motivo_nota_credito_id`),
  ADD KEY `fk_nota_credito_cai1_idx` (`cai_id`),
  ADD KEY `fk_nota_credito_users1_idx` (`users_id`),
  ADD KEY `fk_nota_credito_estado_nota1_idx` (`estado_nota_id`);

--
-- Indices de la tabla `nota_credito_has_producto`
--
ALTER TABLE `nota_credito_has_producto`
  ADD PRIMARY KEY (`nota_credito_id`,`producto_id`,`seccion_id`),
  ADD KEY `fk_nota_credito_has_producto_producto1_idx` (`producto_id`),
  ADD KEY `fk_nota_credito_has_producto_nota_credito1_idx` (`nota_credito_id`),
  ADD KEY `fk_nota_credito_has_producto_seccion1_idx` (`seccion_id`),
  ADD KEY `fk_nota_credito_has_producto_unidad_medida_venta1_idx` (`unidad_medida_venta_id`);

--
-- Indices de la tabla `numero_orden_compra`
--
ALTER TABLE `numero_orden_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_numero_orden_compra_cliente1_idx` (`cliente_id`),
  ADD KEY `fk_numero_orden_compra_estado1_idx` (`estado_id`),
  ADD KEY `fk_numero_orden_compra_users1_idx` (`users_id`);

--
-- Indices de la tabla `pago_comision`
--
ALTER TABLE `pago_comision`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pago_comision_users1_idx` (`vendedor_id`),
  ADD KEY `fk_pago_comision_meses1_idx` (`meses_id`),
  ADD KEY `fk_pago_comision_users2_idx` (`users_registra_id`);

--
-- Indices de la tabla `pago_compra`
--
ALTER TABLE `pago_compra`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `url_img_UNIQUE` (`url_img`),
  ADD KEY `fk_pagos_compra_users1_idx` (`users_id`),
  ADD KEY `fk_pagos_compra_compra1_idx` (`compra_id`),
  ADD KEY `fk_pago_compra_users1_idx` (`users_id_elimina`),
  ADD KEY `fk_pago_compra_estado1_idx` (`estado_id`);

--
-- Indices de la tabla `pago_venta`
--
ALTER TABLE `pago_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pago_venta_factura1_idx` (`factura_id`),
  ADD KEY `fk_pago_venta_users1_idx` (`users_id`),
  ADD KEY `fk_pago_venta_estado_venta1_idx` (`estado_venta_id`),
  ADD KEY `fk_pago_venta_users2_idx` (`users_id_elimina`),
  ADD KEY `fk_pago_venta_banco1_idx` (`banco_id`),
  ADD KEY `fk_pago_venta_tipo_pago1_idx` (`tipo_pago_id`);

--
-- Indices de la tabla `pais`
--
ALTER TABLE `pais`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `parametro`
--
ALTER TABLE `parametro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_parametro_users1_idx` (`users_id`);

--
-- Indices de la tabla `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `precios_venta`
--
ALTER TABLE `precios_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_precios_producto1_idx` (`producto_id`),
  ADD KEY `fk_precios_venta_users1_idx` (`users_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_producto_unidad_medida1_idx` (`unidad_medida_compra_id`),
  ADD KEY `fk_producto_users1_idx` (`users_id`),
  ADD KEY `fk_producto_estado_producto1_idx` (`estado_producto_id`),
  ADD KEY `fk_producto_marca1_idx` (`marca_id`),
  ADD KEY `fk_producto_sub_categoria1_idx` (`sub_categoria_id`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_proveedores_users1_idx` (`registrado_por`),
  ADD KEY `fk_proveedores_estado1_idx` (`estado_id`),
  ADD KEY `fk_proveedores_municipio1_idx` (`municipio_id`),
  ADD KEY `fk_proveedores_tipo_personalidad1_idx` (`tipo_personalidad_id`),
  ADD KEY `fk_proveedores_categoria1_idx` (`categoria_id`);

--
-- Indices de la tabla `recibido_bodega`
--
ALTER TABLE `recibido_bodega`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recibido_bodega_compra_has_producto1_idx` (`compra_id`,`producto_id`),
  ADD KEY `fk_recibido_bodega_seccion1_idx` (`seccion_id`),
  ADD KEY `fk_recibido_bodega_estado1_idx` (`estado_recibido`),
  ADD KEY `fk_recibido_bodega_users1_idx` (`recibido_por`),
  ADD KEY `fk_recibido_bodega_unidad_medida1_idx` (`unidad_compra_id`);

--
-- Indices de la tabla `retenciones`
--
ALTER TABLE `retenciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_retenciones_tipo_retencion1_idx` (`tipo_retencion_id`),
  ADD KEY `fk_retenciones_users1_idx` (`users_id`);

--
-- Indices de la tabla `retenciones_has_proveedores`
--
ALTER TABLE `retenciones_has_proveedores`
  ADD PRIMARY KEY (`retenciones_id`,`proveedores_id`),
  ADD KEY `fk_retenciones_proveedor_has_proveedores_proveedores1_idx` (`proveedores_id`),
  ADD KEY `fk_retenciones_proveedor_has_proveedores_retenciones_provee_idx` (`retenciones_id`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_estante_estado1_idx` (`estado_id`),
  ADD KEY `fk_seccion_segmento1_idx` (`segmento_id`);

--
-- Indices de la tabla `segmento`
--
ALTER TABLE `segmento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_segmento_bodega1_idx` (`bodega_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sub_categoria`
--
ALTER TABLE `sub_categoria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sub_categoria_categoria_producto1_idx` (`categoria_producto_id`);

--
-- Indices de la tabla `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sub_menu_menu1_idx` (`menu_id`);

--
-- Indices de la tabla `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `team_invitations`
--
ALTER TABLE `team_invitations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `team_user`
--
ALTER TABLE `team_user`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_ajuste`
--
ALTER TABLE `tipo_ajuste`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tipo_ajuste_users1_idx` (`users_id`);

--
-- Indices de la tabla `tipo_cliente`
--
ALTER TABLE `tipo_cliente`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_compra`
--
ALTER TABLE `tipo_compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_documento_fiscal`
--
ALTER TABLE `tipo_documento_fiscal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_pago_cobro`
--
ALTER TABLE `tipo_pago_cobro`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_pago_venta`
--
ALTER TABLE `tipo_pago_venta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_personalidad`
--
ALTER TABLE `tipo_personalidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_retencion`
--
ALTER TABLE `tipo_retencion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_venta`
--
ALTER TABLE `tipo_venta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidad_medida_venta`
--
ALTER TABLE `unidad_medida_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_unidad_medida_venta_producto1_idx` (`producto_id`),
  ADD KEY `fk_unidad_medida_venta_unidad_medida1_idx` (`unidad_medida_id`),
  ADD KEY `fk_unidad_medida_venta_estado1_idx` (`estado_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_rol1_idx` (`rol_id`);

--
-- Indices de la tabla `vale`
--
ALTER TABLE `vale`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vale_factura1_idx` (`factura_id`),
  ADD KEY `fk_vale_users1_idx` (`users_id`),
  ADD KEY `fk_vale_estado1_idx` (`estado_id`);

--
-- Indices de la tabla `vale_has_producto`
--
ALTER TABLE `vale_has_producto`
  ADD PRIMARY KEY (`vale_id`,`producto_id`,`lote_id`),
  ADD KEY `fk_vale_has_producto_producto1_idx` (`producto_id`),
  ADD KEY `fk_vale_has_producto_vale1_idx` (`vale_id`),
  ADD KEY `fk_vale_has_producto_unidad_medida_venta1_idx` (`unidad_medida_venta_id`),
  ADD KEY `fk_vale_has_producto_recibido_bodega1_idx` (`lote_id`);

--
-- Indices de la tabla `venta_has_producto`
--
ALTER TABLE `venta_has_producto`
  ADD PRIMARY KEY (`factura_id`,`producto_id`,`lote`),
  ADD KEY `fk_venta_has_producto_recibido_bodega1_idx` (`lote`),
  ADD KEY `fk_venta_has_producto_factura1_idx` (`factura_id`),
  ADD KEY `fk_venta_has_producto_producto1_idx` (`producto_id`),
  ADD KEY `fk_venta_has_producto_unidad_medida_venta1_idx` (`unidad_medida_venta_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ajuste`
--
ALTER TABLE `ajuste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `banco`
--
ALTER TABLE `banco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `bodega`
--
ALTER TABLE `bodega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cai`
--
ALTER TABLE `cai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categoria_producto`
--
ALTER TABLE `categoria_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cliente`
--
ALTER TABLE `cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `codigo_autorizacion`
--
ALTER TABLE `codigo_autorizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `codigo_exoneracion`
--
ALTER TABLE `codigo_exoneracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comision`
--
ALTER TABLE `comision`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comision_techo`
--
ALTER TABLE `comision_techo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comision_temp`
--
ALTER TABLE `comision_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `comprovante_entrega`
--
ALTER TABLE `comprovante_entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cvdolar`
--
ALTER TABLE `cvdolar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `desglose`
--
ALTER TABLE `desglose`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `desglose_temp`
--
ALTER TABLE `desglose_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `entrega_programada`
--
ALTER TABLE `entrega_programada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `enumeracion`
--
ALTER TABLE `enumeracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estado_cliente`
--
ALTER TABLE `estado_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_compra`
--
ALTER TABLE `estado_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_factura`
--
ALTER TABLE `estado_factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_nota`
--
ALTER TABLE `estado_nota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado_producto`
--
ALTER TABLE `estado_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_venta`
--
ALTER TABLE `estado_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `facturas_pagadas`
--
ALTER TABLE `facturas_pagadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `img_producto`
--
ALTER TABLE `img_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `incidencia`
--
ALTER TABLE `incidencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `incidencia_compra`
--
ALTER TABLE `incidencia_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `interes`
--
ALTER TABLE `interes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `listado`
--
ALTER TABLE `listado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `log_credito`
--
ALTER TABLE `log_credito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `log_estado`
--
ALTER TABLE `log_estado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `log_estado_factura`
--
ALTER TABLE `log_estado_factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `log_translado`
--
ALTER TABLE `log_translado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `meses`
--
ALTER TABLE `meses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `montonotadebito`
--
ALTER TABLE `montonotadebito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `motivo_nota_credito`
--
ALTER TABLE `motivo_nota_credito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `municipio`
--
ALTER TABLE `municipio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299;

--
-- AUTO_INCREMENT de la tabla `notadebito`
--
ALTER TABLE `notadebito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `numero_orden_compra`
--
ALTER TABLE `numero_orden_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago_comision`
--
ALTER TABLE `pago_comision`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago_compra`
--
ALTER TABLE `pago_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pago_venta`
--
ALTER TABLE `pago_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pais`
--
ALTER TABLE `pais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `precios_venta`
--
ALTER TABLE `precios_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `recibido_bodega`
--
ALTER TABLE `recibido_bodega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `retenciones`
--
ALTER TABLE `retenciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seccion`
--
ALTER TABLE `seccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `segmento`
--
ALTER TABLE `segmento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sub_categoria`
--
ALTER TABLE `sub_categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `teams`
--
ALTER TABLE `teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `tipo_ajuste`
--
ALTER TABLE `tipo_ajuste`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tipo_cliente`
--
ALTER TABLE `tipo_cliente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_compra`
--
ALTER TABLE `tipo_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_pago_cobro`
--
ALTER TABLE `tipo_pago_cobro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_pago_venta`
--
ALTER TABLE `tipo_pago_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_personalidad`
--
ALTER TABLE `tipo_personalidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_retencion`
--
ALTER TABLE `tipo_retencion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_venta`
--
ALTER TABLE `tipo_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `unidad_medida`
--
ALTER TABLE `unidad_medida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `unidad_medida_venta`
--
ALTER TABLE `unidad_medida_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `vale`
--
ALTER TABLE `vale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `ajuste`
--
ALTER TABLE `ajuste`
  ADD CONSTRAINT `fk_ajuste_tipo_ajuste1` FOREIGN KEY (`tipo_ajuste_id`) REFERENCES `tipo_ajuste` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ajuste_users1` FOREIGN KEY (`solicitado_por`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ajuste_users2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `ajuste_has_producto`
--
ALTER TABLE `ajuste_has_producto`
  ADD CONSTRAINT `fk_ajuste_has_producto_ajuste1` FOREIGN KEY (`ajuste_id`) REFERENCES `ajuste` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ajuste_has_producto_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ajuste_has_producto_recibido_bodega1` FOREIGN KEY (`recibido_bodega_id`) REFERENCES `recibido_bodega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ajuste_has_producto_unidad_medida_venta1` FOREIGN KEY (`unidad_medida_venta_id`) REFERENCES `unidad_medida_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `banco`
--
ALTER TABLE `banco`
  ADD CONSTRAINT `fk_banco_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD CONSTRAINT `fk_bodega_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bodega_municipio1` FOREIGN KEY (`municipio_id`) REFERENCES `municipio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_bodega_users1` FOREIGN KEY (`encargado_bodega`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cai`
--
ALTER TABLE `cai`
  ADD CONSTRAINT `fk_CAI_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_CAI_tipo_documento_fiscal1` FOREIGN KEY (`tipo_documento_fiscal_id`) REFERENCES `tipo_documento_fiscal` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cai_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_cliente_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_estado_cliente1` FOREIGN KEY (`estado_cliente_id`) REFERENCES `estado_cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_municipio1` FOREIGN KEY (`municipio_id`) REFERENCES `municipio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_tipo_cliente1` FOREIGN KEY (`tipo_cliente_id`) REFERENCES `tipo_cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_tipo_personalidad1` FOREIGN KEY (`tipo_personalidad_id`) REFERENCES `tipo_personalidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cliente_users2` FOREIGN KEY (`vendedor`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `codigo_autorizacion`
--
ALTER TABLE `codigo_autorizacion`
  ADD CONSTRAINT `fk_codigo_autorizacion_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `codigo_exoneracion`
--
ALTER TABLE `codigo_exoneracion`
  ADD CONSTRAINT `fk_codigo_exoneracion_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_codigo_exoneracion_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `comision`
--
ALTER TABLE `comision`
  ADD CONSTRAINT `fk_comision_comision_techo1` FOREIGN KEY (`comision_techo_id`) REFERENCES `comision_techo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comision_estado2` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comision_factura1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comision_users2` FOREIGN KEY (`vendedor_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comision_users3` FOREIGN KEY (`users_registro_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `comision_techo`
--
ALTER TABLE `comision_techo`
  ADD CONSTRAINT `fk_comision_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comision_techo_meses1` FOREIGN KEY (`meses_id`) REFERENCES `meses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comision_users1` FOREIGN KEY (`vendedor_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `comision_temp`
--
ALTER TABLE `comision_temp`
  ADD CONSTRAINT `fk_comision_comision_techo10` FOREIGN KEY (`comision_techo_id`) REFERENCES `comision_techo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comision_estado20` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comision_factura10` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comision_users20` FOREIGN KEY (`vendedor_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comision_users30` FOREIGN KEY (`users_registro_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compra`
--
ALTER TABLE `compra`
  ADD CONSTRAINT `fk_compra_cai1` FOREIGN KEY (`cai_id`) REFERENCES `cai` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_estado_compra1` FOREIGN KEY (`estado_compra_id`) REFERENCES `estado_compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_proveedores1` FOREIGN KEY (`proveedores_id`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_retenciones1` FOREIGN KEY (`retenciones_id`) REFERENCES `retenciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_tipo_compra1` FOREIGN KEY (`tipo_compra_id`) REFERENCES `tipo_compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compra_has_producto`
--
ALTER TABLE `compra_has_producto`
  ADD CONSTRAINT `fk_compra_has_producto_compra1` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_has_producto_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compra_has_producto_unidad_medida1` FOREIGN KEY (`unidad_compra_id`) REFERENCES `unidad_medida` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `comprovante_entrega`
--
ALTER TABLE `comprovante_entrega`
  ADD CONSTRAINT `fk_comprovante_entrega_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comprovante_entrega_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comprovante_entrega_tipo_venta1` FOREIGN KEY (`tipo_venta_id`) REFERENCES `tipo_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comprovante_entrega_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `comprovante_has_producto`
--
ALTER TABLE `comprovante_has_producto`
  ADD CONSTRAINT `fk_comprovante_entrega_has_producto_comprovante_entrega1` FOREIGN KEY (`comprovante_id`) REFERENCES `comprovante_entrega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comprovante_entrega_has_producto_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comprovante_has_producto_recibido_bodega1` FOREIGN KEY (`lote_id`) REFERENCES `recibido_bodega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comprovante_has_producto_unidad_medida_venta1` FOREIGN KEY (`unidad_medida_venta_id`) REFERENCES `unidad_medida_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD CONSTRAINT `fk_contacto_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_contacto_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cotizacion`
--
ALTER TABLE `cotizacion`
  ADD CONSTRAINT `fk_cotizacion_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cotizacion_tipo_venta1` FOREIGN KEY (`tipo_venta_id`) REFERENCES `tipo_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cotizacion_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `cotizacion_has_producto`
--
ALTER TABLE `cotizacion_has_producto`
  ADD CONSTRAINT `fk_cotizacion_has_producto_cotizacion1` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cotizacion_has_producto_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cotizacion_has_producto_seccion1` FOREIGN KEY (`seccion_id`) REFERENCES `seccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_cotizacion_has_producto_unidad_medida_venta1` FOREIGN KEY (`unidad_medida_venta_id`) REFERENCES `unidad_medida_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `fk_departamento_pais1` FOREIGN KEY (`pais_id`) REFERENCES `pais` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `desglose`
--
ALTER TABLE `desglose`
  ADD CONSTRAINT `fk_desglose_factura1` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_desglose_users1` FOREIGN KEY (`vendedor_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `desglose_temp`
--
ALTER TABLE `desglose_temp`
  ADD CONSTRAINT `fk_desglose_factura10` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_desglose_users10` FOREIGN KEY (`vendedor_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `entrega_programada`
--
ALTER TABLE `entrega_programada`
  ADD CONSTRAINT `fk_entrega_programada_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_entrega_programada_venta_has_producto1` FOREIGN KEY (`factura_id`,`producto_id`,`lote`) REFERENCES `venta_has_producto` (`factura_id`, `producto_id`, `lote`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `espera_has_producto`
--
ALTER TABLE `espera_has_producto`
  ADD CONSTRAINT `fk_espera_has_producto_unidad_medida_venta1` FOREIGN KEY (`unidad_medida_venta_id`) REFERENCES `unidad_medida_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vale_has_producto1_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vale_has_producto1_vale1` FOREIGN KEY (`vale_id`) REFERENCES `vale` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_factura_codigo_autorizacion1` FOREIGN KEY (`codigo_autorizacion_id`) REFERENCES `codigo_autorizacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_codigo_exoneracion1` FOREIGN KEY (`codigo_exoneracion_id`) REFERENCES `codigo_exoneracion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_comprovante_entrega1` FOREIGN KEY (`comprovante_entrega_id`) REFERENCES `comprovante_entrega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_estado_editar1` FOREIGN KEY (`estado_editar`) REFERENCES `estado_editar` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_estado_factura1` FOREIGN KEY (`estado_factura_id`) REFERENCES `estado_factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_numero_orden_compra1` FOREIGN KEY (`numero_orden_compra_id`) REFERENCES `numero_orden_compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_tipo_pago1` FOREIGN KEY (`tipo_pago_id`) REFERENCES `tipo_pago_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_factura_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_cai1` FOREIGN KEY (`cai_id`) REFERENCES `cai` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_estado_venta1` FOREIGN KEY (`estado_venta_id`) REFERENCES `estado_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_tipo_venta1` FOREIGN KEY (`tipo_venta_id`) REFERENCES `tipo_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_users1` FOREIGN KEY (`vendedor`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `facturas_pagadas`
--
ALTER TABLE `facturas_pagadas`
  ADD CONSTRAINT `fk_facturas_pagadas_comision1` FOREIGN KEY (`comision_id`) REFERENCES `comision` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_facturas_pagadas_factura1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `img_producto`
--
ALTER TABLE `img_producto`
  ADD CONSTRAINT `fk_img_producto_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_img_producto_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `incidencia`
--
ALTER TABLE `incidencia`
  ADD CONSTRAINT `fk_incidencia_recibido_bodega1` FOREIGN KEY (`recibido_bodega_id`) REFERENCES `recibido_bodega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_incidencia_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `incidencia_compra`
--
ALTER TABLE `incidencia_compra`
  ADD CONSTRAINT `fk_incidencia_compra_compra_has_producto1` FOREIGN KEY (`compra_id`,`producto_id`) REFERENCES `compra_has_producto` (`compra_id`, `producto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_incidencia_compra_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `interes`
--
ALTER TABLE `interes`
  ADD CONSTRAINT `fk_intereses_estado_venta1` FOREIGN KEY (`estado_venta_id`) REFERENCES `estado_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_intereses_factura1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_intereses_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `log_credito`
--
ALTER TABLE `log_credito`
  ADD CONSTRAINT `fk_log_credito_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `log_estado`
--
ALTER TABLE `log_estado`
  ADD CONSTRAINT `fk_log_estado_compra1` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_estado_estado_compra1` FOREIGN KEY (`estado_anterior_compra`) REFERENCES `estado_compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_estado_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `log_estado_factura`
--
ALTER TABLE `log_estado_factura`
  ADD CONSTRAINT `fk_log_estado_factura_estado_venta1` FOREIGN KEY (`estado_venta_id_anterior`) REFERENCES `estado_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_estado_factura_factura1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_estado_factura_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `log_translado`
--
ALTER TABLE `log_translado`
  ADD CONSTRAINT `fk_log_translado_ajuste1` FOREIGN KEY (`ajuste_id`) REFERENCES `ajuste` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_translado_compra1` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_translado_comprovante_entrega1` FOREIGN KEY (`comprovante_entrega_id`) REFERENCES `comprovante_entrega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_translado_factura1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_translado_nota_credito1` FOREIGN KEY (`nota_credito_id`) REFERENCES `nota_credito` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_translado_recibido_bodega1` FOREIGN KEY (`origen`) REFERENCES `recibido_bodega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_translado_recibido_bodega2` FOREIGN KEY (`destino`) REFERENCES `recibido_bodega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_translado_unidad_medida_venta1` FOREIGN KEY (`unidad_medida_venta_id`) REFERENCES `unidad_medida_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_translado_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_log_translado_vale1` FOREIGN KEY (`vale_id`) REFERENCES `vale` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `marca`
--
ALTER TABLE `marca`
  ADD CONSTRAINT `fk_marca_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_menu_rol1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `montonotadebito`
--
ALTER TABLE `montonotadebito`
  ADD CONSTRAINT `fk_montoNotaDebito_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_montoNotaDebito_users1` FOREIGN KEY (`users_registra_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `motivo_nota_credito`
--
ALTER TABLE `motivo_nota_credito`
  ADD CONSTRAINT `fk_motivo_nota_credito_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `fk_municipio_departamento1` FOREIGN KEY (`departamento_id`) REFERENCES `departamento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `notadebito`
--
ALTER TABLE `notadebito`
  ADD CONSTRAINT `fk_notaDebito_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_notaDebito_factura1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_notaDebito_montoNotaDebito1` FOREIGN KEY (`montoNotaDebito_id`) REFERENCES `montonotadebito` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_notaDebito_users1` FOREIGN KEY (`users_registra_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `nota_credito`
--
ALTER TABLE `nota_credito`
  ADD CONSTRAINT `fk_nota_credito_cai1` FOREIGN KEY (`cai_id`) REFERENCES `cai` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nota_credito_estado_nota1` FOREIGN KEY (`estado_nota_id`) REFERENCES `estado_nota` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nota_credito_factura1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nota_credito_motivo_nota_credito1` FOREIGN KEY (`motivo_nota_credito_id`) REFERENCES `motivo_nota_credito` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nota_credito_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `nota_credito_has_producto`
--
ALTER TABLE `nota_credito_has_producto`
  ADD CONSTRAINT `fk_nota_credito_has_producto_nota_credito1` FOREIGN KEY (`nota_credito_id`) REFERENCES `nota_credito` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nota_credito_has_producto_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nota_credito_has_producto_seccion1` FOREIGN KEY (`seccion_id`) REFERENCES `seccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_nota_credito_has_producto_unidad_medida_venta1` FOREIGN KEY (`unidad_medida_venta_id`) REFERENCES `unidad_medida_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `numero_orden_compra`
--
ALTER TABLE `numero_orden_compra`
  ADD CONSTRAINT `fk_numero_orden_compra_cliente1` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_numero_orden_compra_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_numero_orden_compra_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pago_comision`
--
ALTER TABLE `pago_comision`
  ADD CONSTRAINT `fk_pago_comision_meses1` FOREIGN KEY (`meses_id`) REFERENCES `meses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pago_comision_users1` FOREIGN KEY (`vendedor_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pago_comision_users2` FOREIGN KEY (`users_registra_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pago_compra`
--
ALTER TABLE `pago_compra`
  ADD CONSTRAINT `fk_pago_compra_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pago_compra_users1` FOREIGN KEY (`users_id_elimina`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pagos_compra_compra1` FOREIGN KEY (`compra_id`) REFERENCES `compra` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pagos_compra_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pago_venta`
--
ALTER TABLE `pago_venta`
  ADD CONSTRAINT `fk_pago_venta_banco1` FOREIGN KEY (`banco_id`) REFERENCES `banco` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pago_venta_estado_venta1` FOREIGN KEY (`estado_venta_id`) REFERENCES `estado_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pago_venta_factura1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pago_venta_tipo_pago1` FOREIGN KEY (`tipo_pago_id`) REFERENCES `tipo_pago_cobro` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pago_venta_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_pago_venta_users2` FOREIGN KEY (`users_id_elimina`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `parametro`
--
ALTER TABLE `parametro`
  ADD CONSTRAINT `fk_parametro_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `precios_venta`
--
ALTER TABLE `precios_venta`
  ADD CONSTRAINT `fk_precios_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_precios_venta_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_producto_estado_producto1` FOREIGN KEY (`estado_producto_id`) REFERENCES `estado_producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_marca1` FOREIGN KEY (`marca_id`) REFERENCES `marca` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_sub_categoria1` FOREIGN KEY (`sub_categoria_id`) REFERENCES `sub_categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_unidad_medida1` FOREIGN KEY (`unidad_medida_compra_id`) REFERENCES `unidad_medida` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_producto_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `fk_proveedores_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedores_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedores_municipio1` FOREIGN KEY (`municipio_id`) REFERENCES `municipio` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedores_tipo_personalidad1` FOREIGN KEY (`tipo_personalidad_id`) REFERENCES `tipo_personalidad` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_proveedores_users1` FOREIGN KEY (`registrado_por`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `recibido_bodega`
--
ALTER TABLE `recibido_bodega`
  ADD CONSTRAINT `fk_recibido_bodega_compra_has_producto1` FOREIGN KEY (`compra_id`,`producto_id`) REFERENCES `compra_has_producto` (`compra_id`, `producto_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_recibido_bodega_estado1` FOREIGN KEY (`estado_recibido`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_recibido_bodega_seccion1` FOREIGN KEY (`seccion_id`) REFERENCES `seccion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_recibido_bodega_unidad_medida1` FOREIGN KEY (`unidad_compra_id`) REFERENCES `unidad_medida` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_recibido_bodega_users1` FOREIGN KEY (`recibido_por`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `retenciones`
--
ALTER TABLE `retenciones`
  ADD CONSTRAINT `fk_retenciones_tipo_retencion1` FOREIGN KEY (`tipo_retencion_id`) REFERENCES `tipo_retencion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_retenciones_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `retenciones_has_proveedores`
--
ALTER TABLE `retenciones_has_proveedores`
  ADD CONSTRAINT `fk_retenciones_proveedor_has_proveedores_proveedores1` FOREIGN KEY (`proveedores_id`) REFERENCES `proveedores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_retenciones_proveedor_has_proveedores_retenciones_proveedor1` FOREIGN KEY (`retenciones_id`) REFERENCES `retenciones` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `seccion`
--
ALTER TABLE `seccion`
  ADD CONSTRAINT `fk_estante_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_seccion_segmento1` FOREIGN KEY (`segmento_id`) REFERENCES `segmento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `segmento`
--
ALTER TABLE `segmento`
  ADD CONSTRAINT `fk_segmento_bodega1` FOREIGN KEY (`bodega_id`) REFERENCES `bodega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sub_categoria`
--
ALTER TABLE `sub_categoria`
  ADD CONSTRAINT `fk_sub_categoria_categoria_producto1` FOREIGN KEY (`categoria_producto_id`) REFERENCES `categoria_producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD CONSTRAINT `fk_sub_menu_menu1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `tipo_ajuste`
--
ALTER TABLE `tipo_ajuste`
  ADD CONSTRAINT `fk_tipo_ajuste_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `unidad_medida_venta`
--
ALTER TABLE `unidad_medida_venta`
  ADD CONSTRAINT `fk_unidad_medida_venta_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_unidad_medida_venta_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_unidad_medida_venta_unidad_medida1` FOREIGN KEY (`unidad_medida_id`) REFERENCES `unidad_medida` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_rol1` FOREIGN KEY (`rol_id`) REFERENCES `rol` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `vale`
--
ALTER TABLE `vale`
  ADD CONSTRAINT `fk_vale_estado1` FOREIGN KEY (`estado_id`) REFERENCES `estado` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vale_factura1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vale_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `vale_has_producto`
--
ALTER TABLE `vale_has_producto`
  ADD CONSTRAINT `fk_vale_has_producto_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vale_has_producto_recibido_bodega1` FOREIGN KEY (`lote_id`) REFERENCES `recibido_bodega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vale_has_producto_unidad_medida_venta1` FOREIGN KEY (`unidad_medida_venta_id`) REFERENCES `unidad_medida_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_vale_has_producto_vale1` FOREIGN KEY (`vale_id`) REFERENCES `vale` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `venta_has_producto`
--
ALTER TABLE `venta_has_producto`
  ADD CONSTRAINT `fk_venta_has_producto_factura1` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_has_producto_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_has_producto_recibido_bodega1` FOREIGN KEY (`lote`) REFERENCES `recibido_bodega` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_venta_has_producto_unidad_medida_venta1` FOREIGN KEY (`unidad_medida_venta_id`) REFERENCES `unidad_medida_venta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
