<?php
namespace Mnt\mantenedores\Contactabilidad\Http\Controller;

use Mnt\mantenedores\Contactabilidad\Domain\Entities\ContactabilidadEntities;
use Mnt\mantenedores\Contactabilidad\Domain\Repository\ContactabilidadRepository;
use App\Utils\Service\NewController;

class ContactabilidadController
{
    
    public function Buscar()
    {
        $ctr = new NewController();

        return $ctr->Controller(function ($request, $response, $service) {
            // validators
            $sv = new ContactabilidadEntities($service);
            $sv->validateParamsLista();
            
            // example request
            $tipo_doc = $request->param('docType');
            $numero_doc = $request->param('docNumber');

            // Validar los parámetros
            $sv->validateTypeDoc($tipo_doc, $numero_doc);
            $repo = new ContactabilidadRepository();
            $data = $repo->Buscar($tipo_doc, $numero_doc);

            return  $data;
        });
    }

    public function Guardar()
    {
        $ctr = new NewController();

        return $ctr->Controller(function ($request, $response, $service) {
            // validators
            $sv = new ContactabilidadEntities($request, $response, $service);
            
            $body = $sv->modelRequestBody();

            $sv->validateParamsCrear((array)$body);

            $repo = new ContactabilidadRepository();
            $res = $repo->Guardar($body);
            if(isset($res['code'])&& $res['code']===202){
                $response->json($res['message']);
                exit;
            }
            return $res;
        });
    }

}
