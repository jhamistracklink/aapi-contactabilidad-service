<?php
namespace Mnt\mantenedores\Contactabilidad\Domain\Repository;

use App\Utils\Utils;
use App\Utils\Service\NewError;
use Mnt\mantenedores\Contactabilidad\Domain\Response\ContactabilidadResponse;
use Mnt\mantenedores\Contactabilidad\Persistence\ContactabilidadPersistence;

class ContactabilidadRepository
{
    private $request;
    private $response;
    private $service;

    public function __construct($request = null, $response = null, $service = null)
    {
        $this->request = $request;
        $this->response = $response;
        $this->service = $service;
    }


    public function Buscar($tipo_doc, $numero_doc)
    {
        $data = ContactabilidadPersistence::Buscar($tipo_doc, $numero_doc);

        $rs = new ContactabilidadResponse($this->service);
        $data = $rs->ListaResponse($data);

        return  $data;
    }

    public function Guardar($body)
    {
        // validators
        $res = ContactabilidadPersistence::Guardar($body);
        if($res==='1' || $res === 1|| (int)$res > 1){
            $u=ContactabilidadPersistence::Actualizar($body);
            if($u === '0'|| $u === 0 ||$u > '0' || $u > 0){
                return NewError::__Log("Datos guardados.", 200);
            }
            return NewError::__Log("Error al actualizar datos.", 202);
        }
        
        return $res;
    }

}
