<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 26.04.16
 * Time: 15:06
 */



define("TEST", "app/view/forms/test.html");

define("ADD_EVENT_FORM", "../Cshlovjah/Applications/View/addEventForm.html");
define("EDIT_EVENT_FORM", "../Cshlovjah/Applications/View/editEventForm.html");

class Forms
{
    public static function load($pathToForm)
    {
        return file_get_contents($pathToForm);
    }
}