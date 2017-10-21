<?php
namespace Service;

use Dao\UsuarioDao;
use Exceptions\LoginInvalidException;

class UsuarioService
{
    private $usuarioDao;

    /**
     * UsuarioService constructor.
     * @param $usuarioDao
     */
    public function __construct()
    {
        $this->usuarioDao = new UsuarioDao();
    }

    public function getAll() {
        $this->usuarioDao->findAll();
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