<?php

use Klein\Klein;
use Cmd\Services\Endpoints;
use Cmd\Middleware\OnError;
use Cmd\Middleware\OnHttpError;
use Cmd\Middleware\CorsMiddleware;

$app = new Klein();
//error_log('Se accedió a la ruta: ');

//| Control de errores CORS
$app->respond(CorsMiddleware::headers());

$app->respond('OPTIONS', '/[*]', function ($request, $response) {

    // Configura los encabezados CORS necesarios para permitir solicitudes de origen cruzado (CORS)
    //$response->header('Access-Control-Allow-Origin', ACCESS_ORIGIN_URL);
    $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    $response->header('Access-Control-Allow-Headers', 'Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With,Origin, Accept');
});

//| Controlrutas
$app->with('', function () use ($app) {
    Endpoints::initEndpoints($app);
});


//| Control de errores
$app->onError(OnError::ValidationException($app));
$app->onHttpError(OnHttpError::errors($app));

//| Ejecutar la aplicación
$app->dispatch();
