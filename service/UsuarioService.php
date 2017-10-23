<?php
namespace Service;

use Dao\UsuarioDao;
use Exception;
use Exceptions\LoginInvalidException;
use lib\Session;
use model\Usuario;

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
            $session->set('id', $usuario[0]->getUsuarioId());
            return true;
        } else {
            return false;
        }
    }

    public function insertNewUser(Usuario $usuario) {
        try{
            $this->usuarioDao->insertUser($usuario);
        } catch (Exception $e) {
            die($e);
        }
    }

    public function getById($id) {
        try {
            return $this->usuarioDao->findById($id);
        } catch (Exception $e) {
            die($e);
        }
    }
}