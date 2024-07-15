<?php

$sv = $_SERVER['REQUEST_URI'];
$request = explode("?", $_SERVER['REQUEST_URI']);
$phats = explode("/", $request[0]);

//vendor
require_once __DIR__ . '/../vendor/autoload.php';

include_once(dirname(__FILE__) . '/config/config.php');

$error = false;
$ERROR_REQ_URI = false;

if ($sv === '/' || count($phats)  <= 1) {
    $error = true;
    $ERROR_REQ_URI = true;
}


if ($error === true) {
    // Encabezados CORS
    //header('Access-Control-Allow-Origin: ' . ACCESS_ORIGIN_URL);
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With, Origin, Accept');

    if ($ERROR_REQ_URI) {
        // Generar un error 400
        header('HTTP/1.1 400 Bad Request');
        // Opcional: Mostrar una página de error personalizada
        echo "Error 400 - Solicitud Incorrecta";
        return;
    }
}



include_once(dirname(__FILE__) . '/app.php');
