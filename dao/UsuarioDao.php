<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 21/10/2017
 * Time: 02:49
 */
namespace Dao;

use lib\Db;
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
}