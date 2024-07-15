<?php
namespace Mnt\mantenedores\Contactabilidad\Domain\Response;

use App\Utils\Service\NewError;

class ContactabilidadResponse
{
    private $request;
    private $response;
    private $service;
    private $app;
    private $model;

    public function __construct($request = null, $response = null, $service = null, $app = null)
    {
        $this->request = $request;
        $this->response = $response;
        $this->service = $service;
        $this->app = $app;

        $this->model = $request ?? $response ?? $service ?? $app;
    }

     /**
     * @param $data type array
     * @return array
     */
    public function ListaResponse($data)
    {
        if(isset($data['code'])&& $data['code']===202){
            return $data;  
        }
        if (count($data)===0) {
            error_log('no hay eee');
            return NewError::__Log("El numero de documento no existe.", 202);
        }

        return $data[0];
    }

}
