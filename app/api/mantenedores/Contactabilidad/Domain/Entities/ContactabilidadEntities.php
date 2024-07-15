<?php
namespace Mnt\mantenedores\Contactabilidad\Domain\Entities;

use App\Utils\Service\NewError;

class ContactabilidadEntities
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

     public function modelRequestBody()
    {
        return json_decode($this->request->body(), true);
    }

    public function validateParamsLista()
    {
        $this->model->validateParam('docType',"se require paramerto de documento");
        $this->model->validateParam('docNumber',"se require paramerto de documento");
    }

    public function validateTypeDoc($tipoDocumento, $numeroDocumento)
    {
        if(!preg_match("/^[A-Za-z]+$/", $tipoDocumento)){
            $err = NewError::__Log('El tipo de documento debe contener solo letras.', 202);
            $this->response->json($err);
            exit;
        }
        if (!preg_match("/^[A-Za-z0-9]+$/", $numeroDocumento)) {
            $err = NewError::__Log('El número de documento debe contener letras y números.', 202);
            $this->response->json($err);
            exit;
        }
    }


    public function validateParamsCrear($data)
    {
        if(isset($data["nombre"])&&isset($data["apellidos"])&&isset($data["correo"])&&
        isset($data["tipo_documento"])&&isset($data["numero_documento"])&&isset($data["telefono1"])
        ){
            if($data["tipo_documento"]!=='RUC'){
                if (!preg_match("/^[A-Za-z\s]+$/", $data["nombre"])) {
                    $err = NewError::__Log('El nombre debe contener solo letras.', 202);
                    $this->response->json($err);
                    exit;
                }
            }
            if (!preg_match("/^[A-Za-z\s]+$/", $data["apellidos"])) {
                $err = NewError::__Log('El apellido debe contener solo letras.', 202);
                $this->response->json($err);
                exit;
            }
            if (!preg_match("/^[A-Za-z]+$/", $data["tipo_documento"])) {
                $err = NewError::__Log('El tipo de documento debe contener solo letras.', 202);
                $this->response->json($err);
                exit;
            }
            if (!preg_match("/^[A-Za-z0-9]+$/", $data["numero_documento"])) {
                $err = NewError::__Log('El número de documento debe contener letras o números.', 202);
                $this->response->json($err);
                exit;
            }
            if (!preg_match("/^[A-Za-z0-9]+$/", $data["telefono1"])) {
                $err = NewError::__Log('El número de telefono debe contener  números.', 202);
                $this->response->json($err);
                exit;
            }
            if ( $data["telefono1"]!==null&&!preg_match("/^[A-Za-z0-9]+$/", $data["telefono1"])) {
                $err = NewError::__Log('El número de telefono 2 debe contener  números.', 202);
                $this->response->json($err);
                exit;
            }
            if ( $data["telefono1"]!==null&&!preg_match("/^[A-Za-z0-9]+$/", $data["telefono1"])) {
                $err = NewError::__Log('El número de telefono 3 debe contener  números.', 202);
                $this->response->json($err);
                exit;
            }
            return;
        }
        $err = NewError::__Log('Not Acceptable', 406, 406);
        $this->response->json($err);
        exit;
    }
    
}
