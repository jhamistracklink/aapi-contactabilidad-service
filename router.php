<?php
// router.php

// Esta es la ruta al archivo index.php
define('APP_ENTRY_POINT', __DIR__ . '/app/autoload.php');

// Carpeta permitida
$allowed_folder = 'public';

// Si la solicitud es para un archivo existente, ignora la reescritura y sirve el archivo
$blocked_folders = glob('*', GLOB_ONLYDIR);

$request_uri = $_SERVER['REQUEST_URI'];
// Verifica si la solicitud es para una carpeta bloqueada
foreach ($blocked_folders as $folder) {
    if($folder=== $allowed_folder){
        return false;
    }else{
        if (strpos($request_uri, '/' . $folder . '/') === 0 || $request_uri === '/' . $folder) {
            // Devuelve un error 404 y termina el script
            http_response_code(404);
            echo 'Error 404 - Not Found';
            exit();
        }
    }
}

// Si la solicitud no es para un archivo existente, incluye el archivo index.php
require_once APP_ENTRY_POINT;
