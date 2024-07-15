<?php
namespace Mnt\mantenedores\Contactabilidad\Http\Routes;

use Mnt\mantenedores\Contactabilidad\Http\Controller\ContactabilidadController;

class ContactabilidadRoutes
{
    public static function Routes($router)
    {
        $ctr = new ContactabilidadController();
    
        // Rutas
        $router->get('/contactabilidad-search-client', $ctr->Buscar());
        $router->post('/contactabilidad', $ctr->Guardar());
    }
}
