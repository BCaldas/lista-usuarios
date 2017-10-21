<?php

require_once dirname(__FILE__) . '/init.php';

use lib\Session;
use Service\UsuarioService;

$session = Session::getInstance();

//$auth = (function($request, $response, $next) use ($session){
//    if ($session->verify('logado'))
//    {
//        return $response = $next($request, $response);
//    } else{
//        $url = $this->router->pathFor('home');
//        return $response->withRedirect($url);
//    }
//});

$usuarioService = UsuarioService::getInstance();

$app->get('/', function ($request, $response) use ($session){

    return $this->view->render($response,'login.twig');
})->setName('home');

$app->group('/usuarios', function () use ($app, $session, $usuarioService){

    $app->get('/', function ($request, $response) use ($session, $usuarioService){

        return $this->view->render($response,'lista-usuarios.twig', [
            'usuarios' => $usuarioService->getAll()
        ]);
    })->setName('listausuarios');
});

$app->run();