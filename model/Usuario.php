<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 21/10/2017
 * Time: 02:36
 */

namespace model;


class Usuario
{
    private $usuario_id;
    private $nome;
    private $login;
    private $senha;
    private $cargo;
    private $email;
    private $data_criacao;
    private $data_atualizacao;

    public function getUsuarioId()
    {
        return $this->usuario_id;
    }

    public function setUsuarioId($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getCargo()
    {
        return $this->cargo;
    }

    public function setCargo($cargo)
    {
        $this->cargo = $cargo;
    }

    public function getDataCriacao()
    {
        return $this->data_criacao;
    }

    public function setDataCriacao($data_criacao)
    {
        $this->data_criacao = $data_criacao;
    }

    public function getDataAtualizacao()
    {
        return $this->data_atualizacao;
    }

    public function setDataAtualizacao($data_atualizacao)
    {
        $this->data_atualizacao = $data_atualizacao;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
}