<?php


class Db {
    //put your code here
    public static function getConnection(){
        
        $paramPath = ROOT . '/config/db_params.php';
        $params = include $paramPath;
        
        
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn,$params['user'],$params['password']);
        $db -> exec("set names utf8");//какую кодировку использовать для БД
        return $db;
    }
}
