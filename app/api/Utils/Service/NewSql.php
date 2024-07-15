<?php

namespace App\Utils\Service;

use Exception;
use PDOException;
use DB\Conexion\Conexion;
use App\Utils\Service\NewError;

class NewSql
{
    private $db;

    /**
     * @param string $db sidi | resh
     * @return any|any[]|error
     */
    function __construct($db = "track")
    {
        $this->db = $db;
    }

    /**
     * @param function exec(func,store_proceduer)
     * @param bool $sp
     * @return $stmt
     */
    function Exec($function, $sp = false)
    {

        // Abrimos la conexión
        $stmt = Conexion::conectar($this->db);

        // Iniciamos la transacción

        $stmt->beginTransaction();
        try {
            // Ejecutamos la función que contiene la consulta preparada
            $result = $function($stmt);

            // Confirmamos la transacción
            if (!$sp) {
                $stmt->commit();
            };

            // Cerramos la conexión
            Conexion::close($stmt);
            // Retornamos el resultado
            return $result;
        } catch (PDOException $ex) {
            // Si hay algún error, deshacemos la transacción
            $stmt->rollBack();

            // Cerramos la conexión
            Conexion::close($stmt);

            // Lanzamos la excepción
            //NewError::__Log($ex->getMessage());

            /**
             * @param $ex->errorInfo = ["23000",1062,"Duplicate entry 'adm1' for key 'username'"]
             */
            $errorInfo = $ex->errorInfo ?? [];
            $errorCode = (int)$errorInfo[1];

            $err  = new NewError();
            error_log("[MYSQL]------->: {$ex->getMessage()}");
            
           // error_log("[errorInfo]------->: {$errorInfo[2]}");

            switch ($errorCode) {
                case 1062:
                    $err->MmsqlError(NewError::__Log("El valor que intenta ingresar ya existe. / {$errorInfo[2]}", 202));
                    break;
                case 1451:
                    $err->MmsqlError(NewError::__Log("No se puede eliminar o actualizar una fila principal: falla una restricción de clave externa. / {$errorInfo[2]}", 202));
                    break;
                
                default:
                    $err->MmsqlError(NewError::__Log($ex->getMessage(), 202));
                    break;
            }

            //return NewError::__Log($ex->getMessage(), 202);
            //return ErrorCode::getCode($ex->getMessage(), 500);


        }

        //validar con base de datos
        if (1) {
        } else {
            echo json_encode("Tipo de DB no soportado");
        }
    }

    /**
     *@param array $params = ["name1","name2"]; 

     * @return string
     **/
    public function like_sql_to_string($params, $search)
    {
        $res = '';
        foreach ($params as $key => $value) {
            $key = $key + 1;
            $or = ($key < count($params)) ? ' OR ' : '';
            $res .=  $value . " LIKE '%$search%'" . $or;
        }
        return $res;
    }
}
