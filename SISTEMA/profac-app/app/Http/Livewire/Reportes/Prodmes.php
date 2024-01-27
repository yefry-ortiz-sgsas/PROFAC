<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use Validator;
use PDF;
use Luecano\NumeroALetras\NumeroALetras;

use App\Models\ModelFactura;
use App\Models\ModelCAI;
use App\Models\ModelRecibirBodega;
use App\Models\ModelVentaProducto;
use App\Models\ModelLogTranslados;
use App\Models\ModelParametro;
use App\Models\ModelLista;
use App\Models\ModelCliente;
use App\Models\logCredito;
use App\Models\User;

class Prodmes extends Component
{
    public function render()
    {
        return view('livewire.reportes.prodmes');
    }

    public function consultaComision($fecha_inicio, $fecha_final){
        try {



            $consulta = DB::SELECT("

                select
                date_format(A.created_at, '%d-%m-%Y') as 'FECHA',
                date_format(A.fecha_vencimiento, '%d-%m-%Y') as 'FECHA VENCIMIENTO',
                UPPER(tpv.descripcion) as 'CRÉDITO/CONTADO',
                (
                    CASE A.estado_factura_id WHEN '1' THEN 'CLIENTE A' WHEN '2' THEN 'CLIENTE B' END
                ) AS 'TIPO CLIENTE (AoB)',
                UPPER(us.name) as 'VENDEDOR',
                (
                    RIGHT(A.cai, 5)
                ) as 'FACTURA',
                cli.nombre as 'CLIENTE',
                C.id as 'CÓDIGO',
                C.nombre as 'PRODUCTO',
                B.precio_unidad as 'PRECIO PRODUCTO',
                B.numero_unidades_resta_inventario as 'CANTIDAD',
                FORMAT(B.sub_total_s, 2) as 'SUB TOTAL PRODUCTO',
                FORMAT(B.isv_s, 2) as 'ISV',
                B.total_s as 'TOTAL PRODUCTO',
                FORMAT(
                    (A.total / 1.15),
                    2
                ) as 'SUB TOTAL FACTURA',
                FORMAT(A.total, 2) as 'TOTAL FACTURA',
                FORMAT(
                    (
                    (A.total / 1.15)- B.sub_total_s
                    ),
                    2
                ) as 'SUB TOTAL DIFERENCIA',
                (
                    CASE tpv.descripcion WHEN 'CREDITO' THEN 'N/A' WHEN 'CONTADO' THEN FORMAT(
                    (B.sub_total_s * 0.0175),
                    2
                    ) END
                ) AS 'CONTADO 1.75%',
                (
                    CASE tpv.descripcion WHEN 'CREDITO' THEN FORMAT(
                    (B.sub_total_s * 0.0150),
                    2
                    ) WHEN 'CONTADO' THEN 'N/A' END
                ) AS 'CREDITO 1.5%',
                (
                    IF(
                    (
                        select
                        count(*)
                        from
                        venta_has_producto
                        where
                        factura_id = A.id
                        and producto_id not in (
                            1006, 1035, 1940, 1942, 1943, 1944, 1945,
                            1946, 1947, 1948, 1949, 1950, 1951,
                            1952, 1953, 1954, 1955, 1956, 1957,
                            1958, 1959, 1960, 1961, 1962, 1963,
                            1964, 1965, 2029, 2030, 2223, 2244,
                            2300, 2301, 2396, 2397, 2404, 2474,
                            2527, 2547, 2699, 2723, 2884, 29012598,
2596,
2595,
2594,
2593,
2592,
2591,
2590,
2587,
2586,
2585,
2583,
2580,
2579,
2578,
2577,
2571,
2570,
2569,
2372,
2371,
1195,
1194,
1192,
1190,
1189,
1188,
1187,
3458,
3414,
3173,
3172,
3171,
3170,
3169,
3168,
3167,
3166,
3165,
3164,
3163,
3162,
3161,
3160,
3159,
3158,
3157,
3156,
3155,
3154,
3153,
3152,
3151,
3150,
3149,
3148,
3147,
3146,
2260,
3706,
3705,
3676,
3675,
3638,
3634,
3633,
3632,
3631,
3630,
3627,
3562,
3507,
3504,
3308,
3263,
3262,
3260,
3259,
3257,
3256,
3254,
3253,
3199,
3196,
3192,
3189,
3185,
3184,
3183,
3179,
3062,
3060,
2937,
2936,
2935,
2911,
2701,
2601,
2464,
2462,
2461,
2460,
2459,
2458,
2455,
2454,
2420,
2419,
2413,
2409,
2408,
2407,
2401,
2384,
2383,
2370,
2369,
2368,
2367,
2366,
2365,
2364,
2349,
2285,
2267,
2266,
2265,
2243,
1703,
1702,
1701,
1700,
1699,
1698,
1697,
1696,
1695,
1694,
1693,
1692,
1691,
1690,
1689,
1688,
1437,
1436,
1435,
1434,
1433,
1432,
1431,
1430,
1429,
1428,
1427,
1426,
1425,
1424,
1423,
1422,
1421,
1420,
1419,
1418,
1417,
1416,
1415,
1414,
1413,
1412,
1411,
1410,
1409,
1408,
1407,
1406,
1405,
1404,
1403,
1402,
1401,
1400,
1399,
1398,
1397,
1396,
1395,
1394,
1393,
1392,
1391,
1390,
1389,
1388,
1387,
1386,
1385,
1384,
1383,
1382,
1381,
1380,
1379,
1378,
1377,
1376,
1375,
1374,
1373,
1372,
1371,
1370,
1369,
1368,
1367,
1366,
1365,
1364,
1363,
1362,
1361,
1360,
1359,
1358,
1357,
1356,
1355,
1354,
1353,
1352,
1351,
1350,
1349,
1348,
1347,
1346,
1345,
1344,
1343,
1342,
1341,
1340,
1339,
1338,
1337,
1336,
1335,
1334,
1333,
1332,
1331,
1330,
1329,
1328,
1327,
1326,
1325,
1324,
1323,
1322,
1321,
1320,
1319,
1318,
1317,
1316,
1315,
1314,
1313,
1312,
1311,
1310,
1309,
1308,
1307,
1306,
1305,
1304,
1303,
1302,
1301,
1300,
1299,
1298,
1297,
1296,
1295,
1294,
1293,
1292,
1008,
1007,
3126,
3125,
3124,
3122,
3073,
2947,
2541,
2509,
2508,
2507,
2506,
2505,
2504,
2503,
2502,
2501,
2500,
2499,
2498,
2497,
2496,
2495,
2494,
2493,
2492,
2491,
2490,
2452,
2410,
2392,
2391,
2390,
2389,
2353,
2303,
2230,
2229,
2228,
1268,
1267,
1266,
1265,
1264,
1263,
1262,
1261,
1260,
1259,
1258,
1257,
1256,
1255,
1254,
1253,
1252,
1251,
1250,
1249,
1248,
1247,
1246,
1245,
1244,
1243,
1242,
1241,
1240,
1239,
1238,
1237,
1236,
1235,
1234,
1233,
1232,
1231,
1230,
1229,
1228,
1227,
1226,
1225,
1224,
1223,
1222,
1221,
1220,
1219,
1218,
1217,
2602,
2224,
1559,
1558,
1557,
1556,
1555,
1554,
1553,
1552,
1551
                        )
                    ) = 0,
                    'N/A',
                    FORMAT(
                        (
                        (A.total - B.sub_total_s)* 0.02
                        ),
                        2
                    )
                    )
                ) AS 'COMISION OTROS PRUEBA'
                from
                factura A
                inner join venta_has_producto B on A.id = B.factura_id
                inner join producto C on B.producto_id = C.id
                inner join unidad_medida_venta D on B.unidad_medida_venta_id = D.id
                inner join unidad_medida E on E.id = D.unidad_medida_id
                inner join sub_categoria sc on sc.id = C.sub_categoria_id
                inner join categoria_producto cp on cp.id = sc.categoria_producto_id
                inner join cliente cli on cli.id = A.cliente_id
                inner join tipo_pago_venta tpv on tpv.id = A.tipo_pago_id
                inner join users us on us.id = A.vendedor
                where
                A.estado_venta_id = 1
                and C.id in (
                    1006, 1035, 1940, 1942, 1943, 1944, 1945,
                    1946, 1947, 1948, 1949, 1950, 1951,
                    1952, 1953, 1954, 1955, 1956, 1957,
                    1958, 1959, 1960, 1961, 1962, 1963,
                    1964, 1965, 2029, 2030, 2223, 2244,
                    2300, 2301, 2396, 2397, 2404, 2474,
                    2527, 2547, 2699, 2723, 2884, 29012598,
2596,
2595,
2594,
2593,
2592,
2591,
2590,
2587,
2586,
2585,
2583,
2580,
2579,
2578,
2577,
2571,
2570,
2569,
2372,
2371,
1195,
1194,
1192,
1190,
1189,
1188,
1187,
3458,
3414,
3173,
3172,
3171,
3170,
3169,
3168,
3167,
3166,
3165,
3164,
3163,
3162,
3161,
3160,
3159,
3158,
3157,
3156,
3155,
3154,
3153,
3152,
3151,
3150,
3149,
3148,
3147,
3146,
2260,
3706,
3705,
3676,
3675,
3638,
3634,
3633,
3632,
3631,
3630,
3627,
3562,
3507,
3504,
3308,
3263,
3262,
3260,
3259,
3257,
3256,
3254,
3253,
3199,
3196,
3192,
3189,
3185,
3184,
3183,
3179,
3062,
3060,
2937,
2936,
2935,
2911,
2701,
2601,
2464,
2462,
2461,
2460,
2459,
2458,
2455,
2454,
2420,
2419,
2413,
2409,
2408,
2407,
2401,
2384,
2383,
2370,
2369,
2368,
2367,
2366,
2365,
2364,
2349,
2285,
2267,
2266,
2265,
2243,
1703,
1702,
1701,
1700,
1699,
1698,
1697,
1696,
1695,
1694,
1693,
1692,
1691,
1690,
1689,
1688,
1437,
1436,
1435,
1434,
1433,
1432,
1431,
1430,
1429,
1428,
1427,
1426,
1425,
1424,
1423,
1422,
1421,
1420,
1419,
1418,
1417,
1416,
1415,
1414,
1413,
1412,
1411,
1410,
1409,
1408,
1407,
1406,
1405,
1404,
1403,
1402,
1401,
1400,
1399,
1398,
1397,
1396,
1395,
1394,
1393,
1392,
1391,
1390,
1389,
1388,
1387,
1386,
1385,
1384,
1383,
1382,
1381,
1380,
1379,
1378,
1377,
1376,
1375,
1374,
1373,
1372,
1371,
1370,
1369,
1368,
1367,
1366,
1365,
1364,
1363,
1362,
1361,
1360,
1359,
1358,
1357,
1356,
1355,
1354,
1353,
1352,
1351,
1350,
1349,
1348,
1347,
1346,
1345,
1344,
1343,
1342,
1341,
1340,
1339,
1338,
1337,
1336,
1335,
1334,
1333,
1332,
1331,
1330,
1329,
1328,
1327,
1326,
1325,
1324,
1323,
1322,
1321,
1320,
1319,
1318,
1317,
1316,
1315,
1314,
1313,
1312,
1311,
1310,
1309,
1308,
1307,
1306,
1305,
1304,
1303,
1302,
1301,
1300,
1299,
1298,
1297,
1296,
1295,
1294,
1293,
1292,
1008,
1007,
3126,
3125,
3124,
3122,
3073,
2947,
2541,
2509,
2508,
2507,
2506,
2505,
2504,
2503,
2502,
2501,
2500,
2499,
2498,
2497,
2496,
2495,
2494,
2493,
2492,
2491,
2490,
2452,
2410,
2392,
2391,
2390,
2389,
2353,
2303,
2230,
2229,
2228,
1268,
1267,
1266,
1265,
1264,
1263,
1262,
1261,
1260,
1259,
1258,
1257,
1256,
1255,
1254,
1253,
1252,
1251,
1250,
1249,
1248,
1247,
1246,
1245,
1244,
1243,
1242,
1241,
1240,
1239,
1238,
1237,
1236,
1235,
1234,
1233,
1232,
1231,
1230,
1229,
1228,
1227,
1226,
1225,
1224,
1223,
1222,
1221,
1220,
1219,
1218,
1217,
2602,
2224,
1559,
1558,
1557,
1556,
1555,
1554,
1553,
1552,
1551
                )
                and DATE(A.created_at) >= DATE_FORMAT('".$fecha_inicio."', '%Y-%m-%d')
                and DATE(A.created_at) <= DATE_FORMAT('".$fecha_final."', '%Y-%m-%d')
                order by
                A.created_at DESC
            ");





            return Datatables::of($consulta)
            ->rawColumns([])
            ->make(true);

        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Ha ocurrido un error al listar el reporte solicitado.',
                'errorTh' => $e,
            ], 402);

        }

    }
}
