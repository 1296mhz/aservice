<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 27.04.16
 * Time: 3:15
 */

require_once('../Controller/Controller.php');
require_once('../Model/Mysql/Get.php');
require_once('../Model/Mysql/Update.php');


//Тип события получение
//print_r(Get::getRepairTypeById('7'));

//Получение авто по ID
//print_r(Get::getCustomerCarById('23'));

//Получение заявки Модель
//print_r(Get::getMechanicWorkDataById('11','admin','111'));

//Получение заявки Контроллер
print_r(Controller::getEventById('11', 'admin', '111'));

//Получаем Бокс ID по Пост ID
//print_r(Get::getRepairBoxByPosts('3'));