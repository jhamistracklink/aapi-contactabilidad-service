<?php
namespace App\config\UnidadMedida;

use App\config\UnidadMedida\Http\Routes\UnidadMedidaRoutes;

class UnidadMedidaApp
{
    public static function Create($app)
    {
        UnidadMedidaRoutes::Routes($app);
    }
}
