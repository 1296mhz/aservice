<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 26.04.16
 * Time: 13:57
 */
require_once('/var/www/Cshlovjah/Applications/Model/Mysql/Mysql.php');
require_once('/var/www/Cshlovjah/Applications/Model/Mysql/Get.php');
require_once('/var/www/Cshlovjah/Applications/Model/Mysql/Update.php');
require_once('Date.php');
require_once('RoleTypes.php');
require_once('ViewDecorators.php');
require_once('Validate.php');
require_once('Check.php');

class Controller
{


    public static function getCurrentDate()
    {
        $index = 0;
        $shiftTime = Date::getCurrentDateShift();
        foreach ($shiftTime as $key => $value) {
            $timeShift['time'][$index] = $value[1];

            $index++;
        }
        return $timeShift;
    }

    public static function getCurrentDateJson()
    {
        $index = 0;
        $shiftTime = Date::getCurrentDateShift();
    }

    public static function sendJsonString($json)
    {
        header('Content-Type: application/json');
        echo $json;
        exit();
    }

    public static function sendJson($data)
    {
        Controller::sendJsonString(json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    public static function sendHTMLString($html)
    {
        echo $html;
        exit();
    }

    public static function template($file, $options)
    {
        ob_start();
        extract($options);
        include_once($file);
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    public static function createNewEvent($data)
    {
        $insertArray['repair_post_id'] = '6';
        $insertArray['repair_type_id'] = '908';
        $insertArray['user_owner_id'] = '1';
        $insertArray['user_target_id'] = '7';
        $insertArray['state'] = '0';
        $insertArray['customer_id'] = '5';
        $insertArray['customer_car_id'] = '2';
        $insertArray['startdatetime'] = $data['startdatetime'];
        $insertArray['enddatetime'] = $data['enddatetime'];
        $insertArray['updated_at'] = Date::getCurrentDate();;
        $mysqlConnect = Mysql::insertMechanicWork($insertArray);
    }

    public static function getInitData($username)
    {
        $initArray['currentDateTime'] = Date::getCurrentDateTime();
        $initArray['userInfo'] = Get::getUserNameForClient($username);
        $initArray['userInfo']['nameRole'] = ViewDecorators::decorateRole($initArray['userInfo']['role']);
        return $initArray;
    }

    //Получение Тип работы в зависимости от пользователя (пользователь -> пост)
    public static function getRepairTypes($user_id)
    {
        $user = Get::getUser($user_id);
        return $initArray['repairTypes'] = Get::getRepairTypeByIdBox($user['repair_box']);
    }

    public static function getRepairType($box_id)
    {
        $box_id = str_replace("b", "", $box_id);
        return $initArray['repairType'] = Get::getRepairTypeByIdBox($box_id);
    }

    public static function getPostsLists()
    {
        $posts = Get::getPostResources();
        $indexBoxs = 0;
        foreach ($posts as $postvalues) {

            $postArray[$indexBoxs]['id'] = $postvalues['id'];
            $postArray[$indexBoxs]['title'] = $postvalues['title'];
            $indexBoxs++;
        }
        return $postArray;

    }

    public static function getBOX($post_id)
    {
        $boxAndPosts = Get::getBoxAndPosts();
        foreach ($boxAndPosts as $value) {
            foreach ($value['children'] as $val) {
                if ($val['post-id'] == $post_id) {
                    return $val['id'];
                }
            }
        }
    }

    public static function getEvents($user_id, $role, $start, $end)
    {

        if ($role == 'admin' || $role = 'manager') {

            $output = Get::getMechanicWorkData($user_id, $role, $start, $end);
            $index = 0;

            foreach ($output as $row) {
                $result[$index]['id'] = $row['id'];
                $result[$index]['resourceId'] = Controller::getBOX($row['repair_post_id']);
                $result[$index]['start'] = str_replace(' ', 'T', $row['startdatetime']);
                $result[$index]['end'] = str_replace(' ', 'T', $row['enddatetime']);
                //Типа работы
                $repair_types = Get::getRepairTypeById($row['repair_type_id']);
                foreach ($repair_types as $value) {
                    $event_name = $value['name'];
                }
                //Заказчик
                $customer_name = Get::getCustomerNameById($row['customer_id']);
                foreach ($customer_name as $value) {
                    $customer_name = $value['customer_name'];
                }
                //Исполнитель
                $mechanic = Get::getUser($row['user_target_id']);

                //Авто
                $customer_car = Get::getCustomerCarById($row['customer_car_id']);

                foreach ($customer_car as $value) {
                    $customer_car_vin = $value['customer_car_vin'];
                    $customer_car_name = $value['customer_car_name'];
                    $customer_car_mileage = $value['customer_car_mileage'];
                    $customer_car_gv_number = $value['customer_car_gv_number'];
                }
                $result[$index]['customer_car_vin'] = $customer_car_vin;
                $result[$index]['customer_car_name'] = $customer_car_name;
                $result[$index]['customer_car_mileage'] = $customer_car_mileage;
                $result[$index]['customer_car_gv_number'] = $customer_car_gv_number;

                //  $result[$index]['test'] = $row['customer_car_id'];

                $result[$index]['title'] = "Заказ номер: " . $row['id'];
                $result[$index]['event_name'] = $event_name;
                $result[$index]['customer_name'] = $customer_name;
                $result[$index]['mechanic'] = $mechanic['name'];
                $index++;
            }

        } else {

            $output = Get::getMechanicWorkData($user_id, $role, $start, $end);
        }
        return $result;
    }

    public static function getHumanResources($user_id, $role)
    {
        switch ($role) {
            case 'admin':
                $resultMysql = Get::getAllUsers();
                $index = 0;
                foreach ($resultMysql as $value) {
                    $result[$index]['id'] = $value['id'];
                    $result[$index]['name'] = $value['name'];
                    $result[$index]['role'] = $value['role'];
                    $result[$index]['repair_box'] = $value['repair_box'];
                    $index++;
                }
                break;
            case 'manager':
                $resultMysql = Get::getAllUsers();
                $index = 0;
                foreach ($resultMysql as $value) {
                    $result[$index]['id'] = $value['id'];
                    $result[$index]['name'] = $value['name'];
                    $result[$index]['role'] = $value['role'];
                    $result[$index]['repair_box'] = $value['repair_box'];
                    $index++;
                }
                break;
            case 'mechanic':
                $resultMysql = Get::getUser($user_id);
                $result[0]['id'] = $resultMysql['id'];
                $result[0]['name'] = $resultMysql['name'];
                $result[0]['role'] = $resultMysql['role'];
                $result[0]['repair_box'] = $resultMysql['repair_box'];

                break;
        }
        return $result;
    }

    //Получить ресурсы Боксы посты
    public static function getResources($user_id, $role)
    {

        switch ($role) {
            case 'admin':
                $result = Get::getBoxAndPosts();
                break;
            case 'manager':
                $result = Get::getBoxAndPosts();
                break;
            case 'mechanic':
                $boxAndPosts = Get::getBoxAndPosts();
                $search_array = Get::getAllUsers();
                if (array_key_exists($user_id, $search_array)) {
                    $users = Get::getUser($user_id);
                    $box_id = $users['repair_box'];
                    $index = 0;

                    foreach ($boxAndPosts as $value) {
                        if ($value['box_id'] == $box_id) {
                            $result[$index] = $value;
                            $index++;
                        }
                    }
                } else {
                    $result['0']['title'] = 'error';
                }
                break;
        }
        return $result;
    }

    public static function getAllStatus()
    {
        return Get::getAllStatus();
    }


    public static function dummy($data)
    {
        print_r($data);
    }

    public static function search($context, $search)
    {

        $search = addslashes($search);
        $search = htmlspecialchars($search);
        $search = stripslashes($search);

        switch ($context) {
            case 'input#customer_name':
                return Mysql::executeSearch($search, 'customer', 'name');
            case 'input#customer_phone':
                return Mysql::executeSearch($search, 'customer', 'phone');
            case 'input#customer_car_vin':
                return Mysql::executeSearch($search, 'customer_car', 'vin');
            case 'input#customer_car_gv_number':
                return Mysql::executeSearch($search, 'customer_car', 'gv_number');
            case 'input#customer_car_name':
                return Mysql::executeSearch($search, 'customer_car', 'name');
        }

        return [];
    }


    //Хуинская обработка формы добавления события
    public static function addHandlerEvent($user_id, $data)
    {

        // addEvent::insertEvent($request);
        $requestToCheck = $data;
        $requestToCheck['user_owner_id'] = $user_id;

        $data = Validate::checking($data);
        if ($data['customer_name'] &&
            $data['customer_phone'] &&
            $data['customer_car_vin'] &&
            $data['customer_car_gv_number'] &&
            $data['customer_car_name'] &&
            $data['customer_car_mileage'] &&
            $data['repair_box_id'] &&
            $data['repair_post_id'] &&
            $data['repair_type_id'] &&
            $data['user_target_name'] &&
            $data['state'] &&
            $data['startdatetime'] &&
            $data['enddatetime']
        ) {

            $customer_name_id = Check::switcherCheck(Check::checkCustomer($requestToCheck));
            $customerCar_name_id = Check::switcherCheck(Check::checkCustomerCar($requestToCheck));
            $dataSave[] = [];
            $dataSave['repair_box_id'] = $requestToCheck['repair_box_id'];
            $dataSave['repair_post_id'] = $requestToCheck['repair_post_id'];
            $dataSave['repair_type_id'] = $requestToCheck['repair_type_id'];
            $dataSave['user_target_id'] = $requestToCheck['user_target_name'];
            $dataSave['user_owner_id'] = $requestToCheck['user_owner_id'];
            $dataSave['state'] = $requestToCheck['state'];
            $dataSave['startdatetime'] = $requestToCheck['startdatetime'];
            $dataSave['enddatetime'] = $requestToCheck['enddatetime'];
            $dataSave['customer_id'] = $customer_name_id;
            $dataSave['customer_car_id'] = $customerCar_name_id;


            Add::addEvent($dataSave);
            return $data;
        }
        return $data;
    }

    //Хуинская обработка формы обновления события
    public static function updateHandlerEvent($user_id, $data)
    {

        // addEvent::insertEvent($request);
        $requestToCheck = $data;
        $requestToCheck['user_owner_id'] = $user_id;

        $data = Validate::checking($data);
        if ($data['customer_name'] &&
            $data['customer_phone'] &&
            $data['customer_car_vin'] &&
            $data['customer_car_gv_number'] &&
            $data['customer_car_name'] &&
            $data['customer_car_mileage'] &&
            $data['repair_box_id'] &&
            $data['repair_post_id'] &&
            $data['repair_type_id'] &&
            $data['user_target_name'] &&
            $data['state'] &&
            $data['startdatetime'] &&
            $data['enddatetime']
        ) {

            $customer_name_id = Check::switcherCheck(Check::checkCustomer($requestToCheck));
            $customerCar_name_id = Check::switcherCheck(Check::checkCustomerCar($requestToCheck));
            $dataSave[] = [];
            $dataSave['repair_box_id'] = $requestToCheck['repair_box_id'];
            $dataSave['repair_post_id'] = $requestToCheck['repair_post_id'];
            $dataSave['repair_type_id'] = $requestToCheck['repair_type_id'];
            $dataSave['user_target_id'] = $requestToCheck['user_target_name'];
            $dataSave['user_owner_id'] = $requestToCheck['user_owner_id'];
            $dataSave['state'] = $requestToCheck['state'];
            $dataSave['startdatetime'] = $requestToCheck['startdatetime'];
            $dataSave['enddatetime'] = $requestToCheck['enddatetime'];
            $dataSave['customer_id'] = $customer_name_id;
            $dataSave['customer_car_id'] = $customerCar_name_id;


            Update::updateEvent($dataSave);
            return $data;
        }
        return $data;
    }

    public static function getEventById($user_id, $role, $event_id)
    {

        switch ($role) {
            case 'admin':
                $output[] = [];
                $result = Get::getMechanicWorkDataById($user_id, $role, $event_id);
                foreach ($result as $res_value) {
                    $id = $res_value['id'];
                    $repair_post_id = $res_value['repair_post_id'];
                    $repair_type_id = $res_value['repair_type_id'];
                    $user_owner_id = $res_value['user_owner_id'];
                    $user_target_id = $res_value['user_target_id'];
                    $state = $res_value['state'];
                    $customer_id = $res_value['customer_id'];
                    $customer_car_id = $res_value['customer_car_id'];
                    $startdatetime = $res_value['startdatetime'];
                    $enddatetime = $res_value['enddatetime'];
                    $created_at = $res_value['created_at'];
                    $updated_at = $res_value['updated_at'];
                }
                $box_id = Get::getRepairBoxByPosts($repair_post_id);
                foreach ($box_id as $value) {
                    $output[0]['repair_box_id'] = 'b' . $value['box_name_id'];
                    $box_name_id = $value['box_name_id'];
                }

                $customer_info = Get::getCustomerNameById($customer_id);
                foreach ($customer_info as $value) {
                    $customer_id = $value['customer_id'];
                    $customer_name = $value['customer_name'];
                    $customer_phone = $value['customer_phone'];
                }

                $customer_car_info = Get::getCustomerCarById($customer_car_id);
                foreach ($customer_car_info as $value) {
                    $customer_car_id = $value['customer_car_id'];
                    $customer_car_name = $value['customer_car_name'];
                    $customer_car_mileage = $value['customer_car_mileage'];
                    $customer_car_vin = $value['customer_car_vin'];
                    $customer_car_gv_number = $value['customer_car_gv_number'];

                }

                $output[0]['id'] = $id;
                $output[0]['repair_post_id'] = 'b' . $box_name_id . $repair_post_id;
                $output[0]['repair_type_id'] = $repair_type_id;
                $output[0]['user_owner_id'] = $user_owner_id;
                $output[0]['user_target_id'] = $user_target_id;
                $output[0]['state'] = $state;
                $output[0]['customer_name'] = $customer_name;
                $output[0]['customer_phone'] = $customer_phone;
                $output[0]['customer_car_id'] = $customer_car_id;
                $output[0]['startdatetime'] = $startdatetime;
                $output[0]['enddatetime'] = $enddatetime;
                $output[0]['event_created_at'] = $created_at;
                $output[0]['event_created_at'] = $customer_car_id;
                $output[0]['customer_car_name'] = $customer_car_name;
                $output[0]['customer_car_vin'] = $customer_car_vin;
                $output[0]['customer_car_mileage'] = $customer_car_mileage;
                $output[0]['customer_car_gv_number'] = $customer_car_gv_number;

                return $output;
            case 'manager':
                $output[] = [];
                $result = Get::getMechanicWorkDataById($user_id, $role, $event_id);
                foreach ($result as $res_value) {
                    $id = $res_value['id'];
                    $repair_post_id = $res_value['repair_post_id'];
                    $repair_type_id = $res_value['repair_type_id'];
                    $user_owner_id = $res_value['user_owner_id'];
                    $user_target_id = $res_value['user_target_id'];
                    $state = $res_value['state'];
                    $customer_id = $res_value['customer_id'];
                    $customer_car_id = $res_value['customer_car_id'];
                    $startdatetime = $res_value['startdatetime'];
                    $enddatetime = $res_value['enddatetime'];
                    $created_at = $res_value['created_at'];
                    $updated_at = $res_value['updated_at'];
                }
                $box_id = Get::getRepairBoxByPosts($repair_post_id);
                foreach ($box_id as $value) {
                    $output[0]['repair_box_id'] = $value['box_name_id'];
                }

                $output[0]['id'] = $id;
                $output[0]['repair_post_id'] = $repair_post_id;
                $output[0]['repair_type_id'] = $repair_type_id;
                $output[0]['user_owner_id'] = $user_owner_id;
                $output[0]['user_target_id'] = $user_target_id;
                $output[0]['state'] = $state;
                $output[0]['customer_id'] = $customer_id;
                $output[0]['customer_car_id'] = $customer_car_id;
                $output[0]['startdatetime'] = $startdatetime;
                $output[0]['enddatetime'] = $enddatetime;
                $output[0]['created_at'] = $created_at;
                $output[0]['updated_at'] = $updated_at;

                return $output;
            case 'mechanic':
                $output[] = [];
                $result = Get::getMechanicWorkDataById($user_id, $role, $event_id);
                foreach ($result as $res_value) {
                    $id = $res_value['id'];
                    $repair_post_id = $res_value['repair_post_id'];
                    $repair_type_id = $res_value['repair_type_id'];
                    $user_owner_id = $res_value['user_owner_id'];
                    $user_target_id = $res_value['user_target_id'];
                    $state = $res_value['state'];
                    $customer_id = $res_value['customer_id'];
                    $customer_car_id = $res_value['customer_car_id'];
                    $startdatetime = $res_value['startdatetime'];
                    $enddatetime = $res_value['enddatetime'];
                    $created_at = $res_value['created_at'];
                    $updated_at = $res_value['updated_at'];
                }
                $box_id = Get::getRepairBoxByPosts($repair_post_id);
                foreach ($box_id as $value) {
                    $output[0]['repair_box_id'] = $value['box_name_id'];
                }

                $output[0]['id'] = $id;
                $output[0]['repair_post_id'] = $repair_post_id;
                $output[0]['repair_type_id'] = $repair_type_id;
                $output[0]['user_owner_id'] = $user_owner_id;
                $output[0]['user_target_id'] = $user_target_id;
                $output[0]['state'] = $state;
                $output[0]['customer_id'] = $customer_id;
                $output[0]['customer_car_id'] = $customer_car_id;
                $output[0]['startdatetime'] = $startdatetime;
                $output[0]['enddatetime'] = $enddatetime;
                $output[0]['created_at'] = $created_at;
                $output[0]['updated_at'] = $updated_at;

                return $output;
        }

    }

    public static function getUserName($login)
    {
        return Get::getUserName($login);
    }


}