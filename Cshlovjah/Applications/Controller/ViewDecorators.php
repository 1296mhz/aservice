<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 26.04.16
 * Time: 15:04
 */



class ViewDecorators
{
    public static $ROLE_NAMES = [
        RoleTypes::ROLE_ADMIN => 'Администратор',
        RoleTypes::ROLE_MANAGER => 'Мастер приемщик',
        RoleTypes::ROLE_MECHANIC => 'Автомеханик',
    ];

    public static function decorateRole( $role )
    {
        return array_key_exists($role, ViewDecorators::$ROLE_NAMES) ? ViewDecorators::$ROLE_NAMES[ $role ] : "Гость";
    }
}