<?php
namespace Dao;
use lib\Db;

abstract class BaseDao
{
    public function __construct()
    {
        Db::getInstance(DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }
}