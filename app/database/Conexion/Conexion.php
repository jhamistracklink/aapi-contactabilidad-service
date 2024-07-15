<?php

namespace DB\Conexion;

use PDO;
use PDOException;
use Throwable;
use Exception;

class Conexion
{
    public static function conectar($db)
    {
        $link = null;
        if ($db === "track") {
            $sgbd_track = "mysql:host=" . TRACK_HOST . ";dbname=" . TRACK_DB_NAME;
            $link = new PDO($sgbd_track, TRACK_DB_USER, TRACK_DB_PASS, [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $link->exec("set names utf8");

            return $link;
        }

        if ($db === "sidi") {
            $sgbd_sidi = "mysql:host=" . SIDI_HOST . ";dbname=" . SIDI_DB_NAME;
            $link = new PDO($sgbd_sidi, SIDI_DB_USER, SIDI_DB_PASS, [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
            $link->exec("set names utf8");

            return $link;
        }
        return $link;
    }

    public static function validar()
    {

        Conexion::conectar("track");

        return  null;
    }


    public static function close(PDO $link)
    {
        $link = null;
    }
}
