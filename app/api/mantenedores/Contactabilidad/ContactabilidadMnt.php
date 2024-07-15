<?php
namespace Mnt\mantenedores\Contactabilidad;

use Mnt\mantenedores\Contactabilidad\Http\Routes\ContactabilidadRoutes;

class ContactabilidadMnt
{
    public static function Create($app)
    {
        ContactabilidadRoutes::Routes($app);
    }
}
