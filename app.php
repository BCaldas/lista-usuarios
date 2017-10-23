<?php

require_once dirname(__FILE__) . '/init.php';

use lib\Session;
use Service\UsuarioService;

$session = Session::getInstance();
$session->startSession();

$auth = (function($request, $response, $next) use ($session){
    if ($session->verify('logado'))
    {
        return $response = $next($request, $response);
    } else{
        $url = $this->router->pathFor('home');
        $this->flash->addMessage('erro','Você precisa estar logado para acessar essa página.');
        return $response->withRedirect($url);
    }
});

$usuarioService = UsuarioService::getInstance();

$app->get('/', function ($request, $response) use ($session){
    if ($session->verify('logado')) {
        return $response->withRedirect($this->router->pathFor('listaUsuarios'));
    } else {

        return $this->view->render($response,'login.twig', [
            'flash' => $this->flash->getMessages()
        ]);
    }
})->setName('home');

$app->post('/', function ($request, $response) use ($session, $usuarioService){
    if ($usuarioService->logon($request->getParsedBody()['login'], md5($request->getParsedBody()['senha']))) {

        return $response->withRedirect($this->router->pathFor('listaUsuarios'));
    } else {
        $url = $this->router->pathFor('home');
        $this->flash->addMessage('erro','Usuário ou Senha inválidos!');
        return $response->withRedirect($url);
    }
});

$app->get('/logout', function ($request, $response) use ($session){

    $session->destroy();
    $url = $this->router->pathFor('home');
    return $response->withRedirect($url);
})->setName('logout');

$app->get('/novo-usuario', function ($request, $response) {

    return $this->view->render($response,'novo-usuario.twig');
})->setName('novoUsuario');

$app->group('/usuarios', function () use ($app, $session, $usuarioService, $auth){

    $app->get('/', function ($request, $response) use ($session, $usuarioService){

        return $this->view->render($response,'lista-usuarios.twig', [
            'usuarios' => $usuarioService->getAll()
        ]);
    })->setName('listaUsuarios')->add($auth);
});

$app->run();