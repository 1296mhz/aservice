<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 26.04.16
 * Time: 15:35
 */




class Mysql
{

    public static function SettingConnectMysql()
    {
        $mysqlConnection['host'] = '127.0.0.1';
        $mysqlConnection['user'] = 'root';
        $mysqlConnection['password'] = 'P@$$word';
        $mysqlConnection['database'] = 'aservice';
        return $mysqlConnection;
    }
    
    public static function Connection()
    {

        $ConnectionSetting = self::SettingConnectMysql();
        $host = $ConnectionSetting['host'];
        $user = $ConnectionSetting['user'];
        $password = $ConnectionSetting['password'];
        $database = $ConnectionSetting['database'];
        $mysqli = new mysqli($host, $user, $password, $database);
        if ($mysqli->connect_errno) {
            echo "Не удалось подключиться к MySQL: " . $mysqli->connect_error;
            die('Connect Error (' . $mysqli->connect_errno() . ') ' . $mysqli->connect_error());
        }


        $mysqli->query("SET NAMES utf8");
        $mysqli->query("SET character_set_results = 'utf8'");
        return $mysqli;

    }


    public static function executeSearch($search, $table, $field)
    {
        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM `$table` WHERE `$field` LIKE ('%$search%');");
        $index = 0;

        $output = [];

        while ($row = $res->fetch_assoc()) {
            $output[$index]['label'] = $row[$field];
            $index++;
        }

        return $output;
    }



}