<?php

require_once dirname(__FILE__) . '/init.php';

use lib\Session;
session_name('listaUsuarios');
session_start();

$session = Session::getInstance();

$app->run();