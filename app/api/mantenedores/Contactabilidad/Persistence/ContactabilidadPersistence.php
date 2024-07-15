<?php

namespace Mnt\mantenedores\Contactabilidad\Persistence;

use App\Utils\Service\NewError;
use App\Utils\Service\NewSql;
use App\Utils\Utils;
use PDO;

class ContactabilidadPersistence
{

    public static function Buscar($tipo_doc, $numero_doc)
    {
        // Ejemplo de uso
        $sql = new NewSql("sidi");
        return $sql->Exec(function ($con) use ($tipo_doc, $numero_doc) {

            if ($tipo_doc === "DNI" || $tipo_doc === "RUC") {
                // $where = $tipo_doc === "DNI" ? "dni= '$numero_doc'" : "ruc= '$numero_doc'";
                // $query = "SELECT * FROM clientes where $where";
                // $stmt = $con->prepare($query);
                // $stmt->bindParam(":id_empresa", 1, PDO::PARAM_INT);

                $query = "SELECT * FROM sid_customer where identdoc=:identdoc";
                $stmt = $con->prepare($query);
                $stmt->bindParam(":identdoc", $numero_doc, PDO::PARAM_INT);

                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return NewError::__Log("El tipo de documento no existe", 202);
        });
    }

    public static function Guardar($data)
    {
        // Ejemplo de uso
        $sql = new NewSql();
        return $sql->Exec(function ($con) use ($data) {

            error_log("idcliente {$data['idcliente']}");
            $time = Utils::Now();
            $select = "SELECT * FROM data_from_web where doc_type=:doc_type and doc_number=:doc_number";
            $stmt = $con->prepare($select);
            $stmt->bindParam(":doc_type", $data["tipo_documento"], PDO::PARAM_STR);
            $stmt->bindParam(":doc_number", $data["numero_documento"], PDO::PARAM_STR);
            $stmt->execute();

            $selected = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($selected) > 0) {
                $cliente = $selected[0];
                $put = "UPDATE 
                            data_from_web
                        SET 
                            name=:name,lastname=:lastname,email=:email,doc_type=:doc_type,
                            doc_number=:doc_number,main_phone=:main_phone,sec_phone=:sec_phone,third_phone=:third_phone,updated_at=:updated_at,
                            idcustomer=:idcustomer
                        WHERE id=:id and doc_number=:numero_documento";
                $stmt = $con->prepare($put);
                $stmt->bindParam(":name", $data["nombre"], PDO::PARAM_STR);
                $stmt->bindParam(":lastname", $data["apellidos"], PDO::PARAM_STR);
                $stmt->bindParam(":email", $data["correo"], PDO::PARAM_STR);
                $stmt->bindParam(":doc_type", $data["tipo_documento"], PDO::PARAM_STR);
                $stmt->bindParam(":doc_number", $data["numero_documento"], PDO::PARAM_STR);
                $stmt->bindParam(":main_phone", $data["telefono1"], PDO::PARAM_STR);
                $stmt->bindParam(":sec_phone", $data["telefono2"], PDO::PARAM_STR);
                $stmt->bindParam(":third_phone", $data["telefono3"], PDO::PARAM_STR);
                $stmt->bindParam(":updated_at", $time, PDO::PARAM_STR);
                $stmt->bindParam(":idcustomer", $data["idcliente"], PDO::PARAM_STR);

                $stmt->bindParam(":id", $cliente["id"], PDO::PARAM_INT);
                $stmt->bindParam(":numero_documento", $cliente["doc_number"], PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->rowCount();
            }

            if (count($selected) === 0) {
                $query = "INSERT INTO data_from_web
                (name, lastname, email, doc_type, doc_number, main_phone, sec_phone,third_phone,created_at,idcustomer)
                VALUES (:name,:lastname,:email,:doc_type,:doc_number,:main_phone,:sec_phone,:third_phone,:created_at,:idcustomer)";
                $stmt = $con->prepare($query);
                $stmt->bindParam(":name", $data["nombre"], PDO::PARAM_STR);
                $stmt->bindParam(":lastname", $data["apellidos"], PDO::PARAM_STR);
                $stmt->bindParam(":email", $data["correo"], PDO::PARAM_STR);
                $stmt->bindParam(":doc_type", $data["tipo_documento"], PDO::PARAM_STR);
                $stmt->bindParam(":doc_number", $data["numero_documento"], PDO::PARAM_STR);
                $stmt->bindParam(":main_phone", $data["telefono1"], PDO::PARAM_STR);
                $stmt->bindParam(":sec_phone", $data["telefono2"], PDO::PARAM_STR);
                $stmt->bindParam(":third_phone", $data["telefono3"], PDO::PARAM_STR);
                $stmt->bindParam(":created_at", $time, PDO::PARAM_STR);
                $stmt->bindParam(":idcustomer", $data["idcliente"], PDO::PARAM_STR);
                $stmt->execute();
                return $con->lastInsertId();
            }
        });
    }

    public static function Actualizar($data)
    {
        // Ejemplo de uso
        $sql = new NewSql("sidi");
        return $sql->Exec(
            function ($con) use ($data) {

                $sql = "UPDATE 
                            sid_customer
                        SET
                        firstname=:nombre,
                        lastname=:apellidos,
                        mail=:correo,
                        phonemain=:telefono1,
                        phonecell=:telefono2,
                        phonework=:telefono3
                        where idcustomer=:idcliente
                ";

                $stmt = $con->prepare($sql);
                $stmt->bindParam(":nombre", $data["nombre"], PDO::PARAM_STR);
                $stmt->bindParam(":apellidos", $data["apellidos"], PDO::PARAM_STR);
                $stmt->bindParam(":correo", $data["correo"], PDO::PARAM_STR);
                $stmt->bindParam(":telefono1", $data["telefono1"], PDO::PARAM_STR);
                $stmt->bindParam(":telefono2", $data["telefono2"], PDO::PARAM_STR);
                $stmt->bindParam(":telefono3", $data["telefono3"], PDO::PARAM_STR);
                $stmt->bindParam(":idcliente", $data["idcliente"], PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->rowCount();
            }
        );
    }
}
