<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 26.04.16
 * Time: 13:54
 */


print_r(\Cshlovjah\Applications\Controller\Forms::load(ADD_EVENT_FORM));


// autoload function
function __autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require __DIR__ ."/" . $fileName;
}
?>



