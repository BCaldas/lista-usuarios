<?php
namespace Service;

use Dao\UsuarioDao;
use Exceptions\LoginInvalidException;
use lib\Session;

class UsuarioService
{
    private $usuarioDao;
    private static $instance;

    /**
     * UsuarioService constructor.
     * @param $usuarioDao
     */
    public function __construct()
    {
        $this->usuarioDao = new UsuarioDao();
    }

    public static function getInstance()
    {
        if (self::$instance = !null) {

            self::$instance = new self;
        }

        return self::$instance;
    }

    public function getAll() {
        return $this->usuarioDao->findAll();
    }

    public function logon($login, $senha) {

        $usuario = $this->usuarioDao->findByLoginAndSenha($login, $senha);

        if ($usuario) {
            $session = Session::getInstance();
            $session->set('logado',true);
            $session->set('nome',$usuario[0]->getNome());
            $session->set('cargo', $usuario[0]->getCargo());
            $session->set('dataCriacao', $usuario[0]->getDataCriacao());
            return true;
        } else {
            return false;
        }
    }
}