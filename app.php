<?php

require_once dirname(__FILE__) . '/init.php';

use lib\Session;
use Service\UsuarioService;
use Model\Usuario;
use lib\RequestHandler;


$session = Session::getInstance();
$session->startSession();

$usuarioService = UsuarioService::getInstance();

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

$app->post('/novo-usuario', function ($request, $response) use ($usuarioService) {

    $usuario = new Usuario();
    $dataCriacao = new DateTime();

    $usuario->setNome($request->getParsedBody()['nome']);
    $usuario->setCargo($request->getParsedBody()['cargo']);
    $usuario->setEmail($request->getParsedBody()['email']);
    $usuario->setLogin($request->getParsedBody()['login']);
    $usuario->setSenha(md5($request->getParsedBody()['senha']));
    $usuario->setDataCriacao($dataCriacao->format('Y-m-d H:i:s'));
    $usuarioService->insertNewUser($usuario);
    return $response->withRedirect($this->router->pathFor('home'));
});

$app->group('/usuarios', function () use ($app, $session, $usuarioService, $auth){

    $app->get('/', function ($request, $response) use ($session, $usuarioService){

        return $this->view->render($response,'lista-usuarios.twig', [
            'usuarios' => $usuarioService->getAll(),
            'nomeUsuario' => $session->get('nome')
        ]);
    })->setName('listaUsuarios');

    $app->get('/usuario-logado', function ($request, $response) use ($session, $usuarioService){

        return $this->view->render($response,'usuario-logado.twig', [
            'usuario' => $usuarioService->getById($session->get('id'))[0],
            'nomeUsuario' => $session->get('nome')
        ]);
    })->setName('usuarioLogado');
})->add($auth);

$app->group('/nasa', function () use ($app, $session, $auth){


    $app->map(['GET','POST'],'/apod', function ($request, $response) use ($session){

        if(isset($request->getParsedBody()['date'])) {
            $dataFormatada = DateTime::createFromFormat('d/m/Y', $request->getParsedBody()['date']);
            $date = $dataFormatada->format('Y-m-d');

        } else {
            $date = '';
        }

        $requestHandler = new RequestHandler('https://api.nasa.gov/');

        $data = json_decode($requestHandler->get(
            "planetary/apod?date=".$date."&api_key=2BW9iPUD88k6Po3N2fsmAaM8vbFFh09uVOoHuc5t")->getBody());

        return $this->view->render($response,'apod.twig', [
            'nomeUsuario' => $session->get('nome'),
            'data' => $data
        ]);

    })->setName('apod');

    $app->get('/patentes', function ($request, $response) use ($session){

        $requestHandler = new RequestHandler('https://api.nasa.gov/');

        $data = json_decode($requestHandler->get(
            "patents/content?query=temperature&limit=5&api_key=2BW9iPUD88k6Po3N2fsmAaM8vbFFh09uVOoHuc5t")->getBody());

        return $this->view->render($response,'patentes.twig', [
            'nomeUsuario' => $session->get('nome'),
            'data' => $data
        ]);

    })->setName('patentes');

    $app->get('/asteroides/[{page}]', function ($request, $response, $args) use ($session){

        $requestHandler = new RequestHandler('https://api.nasa.gov/');

        $data = json_decode($requestHandler->get(
            "neo/rest/v1/neo/browse?page=".$args['page']."&size=20&api_key=2BW9iPUD88k6Po3N2fsmAaM8vbFFh09uVOoHuc5t")->getBody());

        return $this->view->render($response,'asteroides.twig', [
            'nomeUsuario' => $session->get('nome'),
            'data' => $data
        ]);

    })->setName('asteroides');

})->add($auth);

$app->run();