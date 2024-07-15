<?php
namespace App\config\UnidadMedida\Domain\Repository;

use App\config\UnidadMedida\Domain\Response\UnidadMedidaResponse;
use App\config\UnidadMedida\Persistence\UnidadMedidaPersistence;
use App\Utils\Utils;

class UnidadMedidaRepository
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

    public function Buscar($start, $length, $search, $order)
    {
        $data = UnidadMedidaPersistence::Buscar($start, $length, $search, $order);

        $rs = new UnidadMedidaResponse($this->service);
        $data = $rs->ListaResponse($data);

        return  $data;
    }

    public function Listar($start, $length, $search, $order)
    {
        $data = UnidadMedidaPersistence::Listar($start, $length, $search, $order);

        $rs = new UnidadMedidaResponse($this->service);
        $data = $rs->ListaResponse($data);

        return  $data;
    }

    public function Crear($body)
    {
        // validators
        $res = UnidadMedidaPersistence::Crear($body);

        //$rs = new UnidadMedidaResponse($this->service);
        
        return $res;
    }

    public function BuscarPorId($id)
    {
        $res = UnidadMedidaPersistence::BuscarPorId($id);
        if (isset($res['error']) && isset($res['code'])) {
            return  $res;
        }

        $rs = new UnidadMedidaResponse($this->service);
        $data = $rs->ListaResponse($res);

        return  $data[0];
    }

    public function Actualizar($id, $body)
    {
        // validators
        $data = UnidadMedidaPersistence::Actualizar($id, $body);
        
        //$rs = new UnidadMedidaResponse($this->service);
        $res = Utils::responseParamsUpdate($data, $id);
        return  $res;
    }

    public function Eliminar($id)
    {
        $res = UnidadMedidaPersistence::Eliminar($id);

        return  $res;
    }

    public function HabilitarDeshabilitar($id, $status)
    {
        return UnidadMedidaPersistence::HabilitarDeshabilitar($id, $status);
    }

    public function Codigo($codigo)
    {
        $res = UnidadMedidaPersistence::Codigo($codigo);

        if ($res === 1) {
            return true;
        }

        return false;
    }

}
