//*****comandos utiles****

1. crear modelo -> php artisan make:model <directory_name>/<model_name>

2. crear componente -> php artisan make:livewire ShowPosts 

3. crear componente en sub carpeta -> php artisan make:livewire Post/Show

4. composer require yajra/laravel-datatables-buttons -W



---Consulta para actualizar facturas vencidas---
update factura set estado_venta_id=4
where  estado_venta_id=1 and fecha_vencimiento < curdate() and pendiente_cobro >0






//////////////////////////////////////////////////////////////////////////////////////////
para configurar la hora de forma global independiente de la hora del sistema.
configurar:
Paso1)
En el archivo .env agregar la variable
APP_TIMEZONE='America/Tegucigalpa'

paso2)
config/app.php

 'timezone' => env('APP_TIMEZONE', 'America/Tegucigalpa'),

 paso3)
\vendor\laravel\framework\src\Illuminate\Foundation\helpers.php

reemplazar la funcion now($tz)
    function now($tz = 'America/Tegucigalpa')
    {
        $timezone = $_ENV['APP_TIMEZONE'];
        return Date::now($timezone);
    }


SEGUNDO METODO NO PROBADO

En la ruta profac-app\app\Providers\AppServiceProvider.php

Reemplazar el motodo boot
    public function boot()
    {
        Schema::defaultStringLength(191);
        date_default_timezone_set('America/Tegucigalpa');
        
    }
/////////////////////////////////////////////////////////////////////////////////////////