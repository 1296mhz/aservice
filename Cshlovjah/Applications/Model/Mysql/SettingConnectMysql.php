<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 26.04.16
 * Time: 15:38
 */

namespace Cshlovjah\Applications\Model\Mysql;


class SettingConnectMysql
{
    public static function SettingConnectMysql()
    {
        $mysqlConnection['host'] = '127.0.0.1';
        $mysqlConnection['user'] = 'root';
        $mysqlConnection['password'] = 'P@$$word';
        $mysqlConnection['database'] = 'aservice';
        return $mysqlConnection;
    }
}