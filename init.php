<?php
/**
 * Arquivo de Bootstrap para uso com o Slim Framework 3.
 * Aqui estão todas as configurações iniciais necessárias para o funcionamento da aplicação.
 * @author Bruno Caldas <brunopaivacaldas@hotmail.com>
 * @version 0.2
 */
require_once dirname(__FILE__) . '/vendor/autoload.php';

// Carrega um arquivo de configurações do BD.
$configBD = dirname(__FILE__) . '/ConfigBd.php';
if (is_readable($configBD)) {
    require_once $configBD;
}

//seta o timezone
date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_ALL, 'pt_BR');

//seta o Ambiente do Slim: development ou production
$_ENV['SLIM_MODE'] = 'development';

if ($_ENV['SLIM_MODE'] == 'development') {
    ini_set('display_errors', 'On');
    ini_set('display_startup_errors', 'On');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 'Off');
    ini_set('display_startup_errors', 'Off');
    error_reporting(0);
};

// Instancia um container do Slim
$container = new \Slim\Container();

// Registra o Twig no Container do Slim
$container['view'] = function ($container) {
    //Seta o caminho dos Templates como parâmetro construtor do Twig
    $view = new \Slim\Views\Twig('view/',array(
        'debug' => true,
        'auto_reload' => true,
        'cache' => false));

    // Instancia e Adiciona a Extensão do Twig ao Slim
    $view->addExtension(new Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    $view->addExtension(new Twig_Extension_Debug());

    $view->addExtension(new Knlv\Slim\Views\TwigMessages(
        new Slim\Flash\Messages()
    ));
    return $view;
};

// Registra o Flash Service Provider no container do Slim
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

/**
 * @var $config array que recebe todos os dados da $container e mais algumas configurações iniciais
 * do Slim para serem usadas como parâmetro do Construtor da classe Slim\App,
 * uma vez que o mesmo só aceita um array() como parâmetro.
 */
$config = $container;
$config['app'] = array(
    'name' => 'ListaUsuarios',
    'debug' => true,
    'mode' => (!empty($_ENV['SLIM_MODE'])) ? $_ENV['SLIM_MODE'] : 'development'
);
if ($_ENV['SLIM_MODE'] == 'development') {
    $config['settings']['displayErrorDetails'] = true;
} else {
    $config['settings']['displayErrorDetails'] = false;
};
// Cria uma instância da aplicação com as configurações básicas ($config) e as configurações do twig ($container).
$app = new Slim\App($config);