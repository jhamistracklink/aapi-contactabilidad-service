<?php
namespace App\config\UnidadMedida\Http\Routes;

use App\config\UnidadMedida\Http\Controller\UnidadMedidaController;

class UnidadMedidaRoutes
{
    public static function Routes($router)
    {
        $ctr = new UnidadMedidaController();
    
        // Rutas
        $router->get('/unidad-medida-buscar', $ctr->Buscar());
        $router->get('/unidad-medida', $ctr->Listar());
        $router->post('/unidad-medida', $ctr->Crear());
        $router->get('/unidad-medida/[i:id]', $ctr->BuscarPorId());
        $router->put('/unidad-medida/[i:id]', $ctr->Actualizar());
        $router->delete('/unidad-medida/[i:id]', $ctr->Eliminar());
        $router->patch('/unidad-medida/[i:id]/habilitar', $ctr->Habilitar());
        $router->patch('/unidad-medida/[i:id]/deshabilitar', $ctr->Deshabilitar());
        $router->get('/unidad-medida-codigo', $ctr->Codigo());
    }
}
