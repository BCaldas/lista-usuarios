<?php

require_once dirname(__FILE__) . '/init.php';

use lib\Session;
use Service\UsuarioService;
session_name('listaUsuarios');
session_start();

$session = Session::getInstance();

$app->get('/', function ($request, $response) use ($session){

    return $this->view->render($response,'login.twig');
})->setName('home');

$app->run();