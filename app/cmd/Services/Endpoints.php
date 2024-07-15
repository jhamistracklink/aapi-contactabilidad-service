<?php

namespace Cmd\Services;

use Throwable;
use App\Auth\AuthApp;
use Mnt\mantenedores\Contactabilidad\ContactabilidadMnt;

class Endpoints
{
    /**
     * @endpoints... 
     * @param Throwable
     * validar si hay referencia de classname y no hay archivo
     * */
    public static function initEndpoints($router)
    {
        AuthApp::Create($router);
        ContactabilidadMnt::Create($router);
    }
}
