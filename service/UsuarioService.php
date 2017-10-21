<?php
namespace Service;

use Dao\UsuarioDao;
use Exceptions\LoginInvalidException;

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

    public function verifyLogin($login, $senha) {

        $usuario = $this->usuarioDao->findByLoginAndSenha($login, $senha);

        if ($usuario) {
            return $usuario;
        } else {
            throw new LoginInvalidException('Usuário ou senha inválidos');
        }
    }
}