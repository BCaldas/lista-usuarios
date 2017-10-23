<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 21/10/2017
 * Time: 02:49
 */
namespace Dao;

use lib\Db;
use model\Usuario;

class UsuarioDao extends BaseDao
{
    private static $model = 'Model\\Usuario';

    public function findAll() {

        $sql = "SELECT * from usuarios ORDER BY nome ASC";
        $data = Db::query($sql, null, self::$model);

        return $data;
    }

    public function findByLoginAndSenha($login, $senha) {
        $sql = "SELECT * FROM usuarios WHERE login = :login AND senha = :senha";

        return Db::query($sql, array(
            'login' => array($login, \PDO::PARAM_STR),
            'senha' => array($senha, \PDO::PARAM_STR)
        ), self::$model);
    }

    public function insertUser(Usuario $usuario) {

        $sql = "INSERT INTO usuarios (nome, login, senha, cargo, email, data_criacao) 
                VALUES(:nome, :login, :senha, :cargo, :email, :dataCriacao)";

       Db::execute($sql, array(
           'nome' => array($usuario->getNome(), \PDO::PARAM_STR),
           'login' => array($usuario->getLogin(), \PDO::PARAM_STR),
           'senha' => array($usuario->getSenha(), \PDO::PARAM_STR),
           'cargo' => array($usuario->getCargo(), \PDO::PARAM_STR),
           'email' => array($usuario->getEmail(), \PDO::PARAM_STR),
           'dataCriacao' => array($usuario->getDataCriacao(), \PDO::PARAM_STR)
        ));
    }

    public function findById($id) {
        $sql = "SELECT * FROM usuarios WHERE usuario_id = :id";

        return Db::query($sql, array(
            'id' => array($id, \PDO::PARAM_STR)
        ), self::$model);
    }
}