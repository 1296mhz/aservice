<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 26.04.16
 * Time: 16:23
 */

require_once('Mysql.php');


class Get
{
    public static function getBoxAndPosts()
    {
        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT repair_post.id as post_id, repair_box.id as box_id, repair_box.name box_name, repair_post.name as post_name FROM repair_box, repair_post WHERE repair_box.id = repair_post.box_name_id");

        $output = [];

        while ($row = $res->fetch_assoc()) {
            $box_id = "b" . $row['box_id'];

            if (!isset($output[$box_id])) {
                $output[$box_id] = array(
                    'id' => "b" . $row['box_id'],
                    'box_id' => $row['box_id'],
                    'title' => $row['box_name'],
                    'children' => []
                );
            }

            $output[$box_id]['children'][] = array('id' => "b" . $row['box_id'] . $row['post_id'], 'post-id' => $row['post_id'], 'title' => $row['post_name']);
        }
        return array_values($output);
    }

    public static function getCustomers()
    {

        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM `customer` WHERE 1");
        $output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['id'] = $row['id'];
            $output[$index]['name'] = $row['name'];
            $output[$index]['phone'] = $row['phone'];
            $output[$index]['created_at'] = $row['created_at'];
            $index++;
        }
        return $output;
    }

    public static function getCustomerName($name)
    {

        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM `customer` WHERE `name`='$name'");
        //$output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['customer_id'] = $row['id'];
            $output[$index]['customer_name'] = $row['name'];
            $output[$index]['customer_phone'] = $row['phone'];
            $output[$index]['created_at'] = $row['created_at'];
            $index++;
        }
        return $output;
    }

    public static function getCustomerNameById($id)
    {

        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM `customer` WHERE `id`='$id'");
        //$output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['customer_id'] = $row['id'];
            $output[$index]['customer_name'] = $row['name'];
            $output[$index]['customer_phone'] = $row['phone'];
            $output[$index]['created_at'] = $row['created_at'];
            $index++;
        }
        return $output;
    }

    public static function getCustomerPhone($phone)
    {

        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM `customer` WHERE `phone`='$phone'");
        $output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['customer_id'] = $row['id'];
            $output[$index]['customer_name'] = $row['name'];
            $output[$index]['customer_phone'] = $row['phone'];
            $output[$index]['customer_created_at'] = $row['created_at'];
            $index++;
        }
        return $output;
    }

    public static function getCustomersCars()
    {

        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM `customer_car` WHERE 1");
        $output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['customer_car_id'] = $row['id'];
            $output[$index]['customer_car_name'] = $row['name'];
            $output[$index]['customer_car_mileage'] = $row['mileage'];
            $output[$index]['customer_car_vin'] = $row['vin'];
            $output[$index]['customer_car_gv_number'] = $row['gv_number'];
            $output[$index]['created_at'] = $row['created_at'];
            $index++;
        }
        return $output;
    }

    public static function getCustomerCarVin($data){

        $vin = $data;
        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM `customer_car` WHERE `vin`='$vin'");
        $output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['customer_car_id'] = $row['id'];
            $output[$index]['customer_car_name'] = $row['name'];
            $output[$index]['customer_car_mileage'] = $row['mileage'];
            $output[$index]['customer_car_vin'] = $row['vin'];
            $output[$index]['customer_car_gv_number'] = $row['gv_number'];
            $output[$index]['created_at'] = $row['created_at'];
            $index++;
        }
        return $output;
    }

    public static function getCustomerCarById($data){

        $id = $data;
        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM `customer_car` WHERE `id` = $id");
        $output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['customer_car_id'] = $row['id'];
            $output[$index]['customer_car_name'] = $row['name'];
            $output[$index]['customer_car_mileage'] = $row['mileage'];
            $output[$index]['customer_car_vin'] = $row['vin'];
            $output[$index]['customer_car_gv_number'] = $row['gv_number'];
            $output[$index]['created_at'] = $row['created_at'];
            $index++;
        }
        return $output;
    }

    public static function getMechanicWorks()
    {

        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM `mechanic_work` WHERE 1");
        $output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['id'] = $row['id'];
            $output[$index]['repair_post_id'] = $row['repair_post_id'];
            $output[$index]['repair_type_id'] = $row['repair_type_id'];
            $output[$index]['user_owner_id'] = $row['user_owner_id'];
            $output[$index]['user_target_id'] = $row['user_target_id'];
            $output[$index]['state'] = $row['state'];
            $output[$index]['customer_id'] = $row['customer_id'];
            $output[$index]['customer_car_id'] = $row['customer_car_id'];
            $output[$index]['startdatetime'] = $row['startdatetime'];
            $output[$index]['enddatetime'] = $row['enddatetime'];
            $output[$index]['created_at'] = $row['created_at'];
            $output[$index]['updated_at'] = $row['updated_at'];
            $index++;
        }
        return $output;
    }

    public static function getMechanicWorkData($user_target_id, $role, $start, $end)
    {

        $mysqlConn = Mysql::Connection();

        switch ($role) {
            case 'admin':
                $res = $mysqlConn->query("SELECT * FROM mechanic_work WHERE startdatetime BETWEEN '$start' AND '$end' ORDER BY id");
                break;
            case 'manager':
                $res = $mysqlConn->query("SELECT * FROM mechanic_work WHERE startdatetime BETWEEN '$start' AND '$end' ORDER BY id");
                break;
            case 'mechanic':
                $res = $mysqlConn->query("SELECT * FROM mechanic_work WHERE `user_target_id` = '$user_target_id' AND startdatetime BETWEEN '$start' AND '$end' ORDER BY id ");
                break;

        }
        $output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['id'] = $row['id'];
            $output[$index]['repair_post_id'] = $row['repair_post_id'];
            $output[$index]['repair_type_id'] = $row['repair_type_id'];
            $output[$index]['user_owner_id'] = $row['user_owner_id'];
            $output[$index]['user_target_id'] = $row['user_target_id'];
            $output[$index]['state'] = $row['state'];
            $output[$index]['customer_id'] = $row['customer_id'];
            $output[$index]['customer_car_id'] = $row['customer_car_id'];
            $output[$index]['startdatetime'] = $row['startdatetime'];
            $output[$index]['enddatetime'] = $row['enddatetime'];
            $output[$index]['created_at'] = $row['created_at'];
            $output[$index]['updated_at'] = $row['updated_at'];
            $index++;
        }

        return $output;
    }

    //Получаем боксы
    public static function getBoxResources()
    {

        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM repair_box");
        $output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['id'] = $row['id'];
            $output[$index]['title'] = $row['name'];
            $index++;
        }
        return $output;
    }

    public static function getRepairPosts()
    {

        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM `repair_post` WHERE 1");
        $output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['id'] = $row['id'];
            $output[$index]['name'] = $row['name'];
            $output[$index]['box_name_id'] = $row['box_name_id'];
            $output[$index]['created_at'] = $row['created_at'];
            $output[$index]['updated_at'] = $row['updated_at'];
            $index++;
        }
        return $output;
    }

    //Получаем посты по id бокса
    public static function getPostResourcesForBoxId($box_id)
    {

        $mysqlConn = Mysql::Connection();
        if ($box_id == 'all') {
            $res = $mysqlConn->query("SELECT * FROM repair_post WHERE 1");
        } else {
            $res = $mysqlConn->query("SELECT * FROM repair_post WHERE `box_name_id` = $box_id");
        }

        $output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['id'] = $row['id'];
            $output[$index]['title'] = $row['name'];
            $output[$index]['box_name_id'] = $row['box_name_id'];
            $index++;
        }
        return $output;
    }

    //Получаем посты
    public static function getPostResources()
    {

        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM repair_post");
        $output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['id'] = $row['id'];
            $output[$index]['title'] = $row['name'];
            $output[$index]['box_name_id'] = $row['box_name_id'];
            $index++;
        }
        return $output;
    }

    public static function getRepairTypeByIdBox($box_id)
    {

        $mysqlConn = Mysql::Connection();

        if ($box_id == 'all') {
            $res = $mysqlConn->query("SELECT * FROM `repair_type` WHERE 1");
        } else {
            $res = $mysqlConn->query("SELECT * FROM `repair_type` WHERE `box_id` = $box_id");
        }

        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['id'] = $row['id'];
            $output[$index]['name'] = $row['name'];
            $output[$index]['box_id'] = $row['box_id'];
            $index++;
        }
        return $output;
    }

    public static function getRepairTypeById($id)
    {

        $mysqlConn = Mysql::Connection();

        
            $res = $mysqlConn->query("SELECT * FROM `repair_type` WHERE `id` = '$id'");
       

        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['id'] = $row['id'];
            $output[$index]['name'] = $row['name'];
            $output[$index]['box_id'] = $row['box_id'];
            $index++;
        }
        return $output;
    }

    public static function getAllStatus()
    {

        $mysqlConn = Mysql::Connection();


        $res = $mysqlConn->query("SELECT * FROM `status` WHERE 1");
        $output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['id'] = $row['id'];
            $output[$index]['name'] = $row['name'];

            $index++;
        }
        return $output;
    }

    //Получение всех пользователей
    public static function getAllUsers()
    {

        $mysqlConn = Mysql::Connection();


        $res = $mysqlConn->query("SELECT * FROM `users` WHERE 1");
        $output[] = [];
        $index = 0;
        while ($row = $res->fetch_assoc()) {
            $output[$index]['id'] = $row['id'];
            $output[$index]['name'] = $row['name'];
            $output[$index]['password'] = $row['password'];
            $output[$index]['role'] = $row['role'];
            $output[$index]['repair_box'] = $row['repair_box'];
            $output[$index]['created_at'] = $row['created_at'];
            $output[$index]['updated_at'] = $row['updated_at'];
            $index++;
        }
        return $output;
    }

    //Получение данных пользователя по id
    public static function getUser($id)
    {

        $mysqlConn = Mysql::Connection();


        $res = $mysqlConn->query("SELECT * FROM `users` WHERE `id` = '$id'");
        while ($row = $res->fetch_assoc()) {
            $output['id'] = $row['id'];
            $output['name'] = $row['name'];
            $output['password'] = $row['password'];
            $output['role'] = $row['role'];
            $output['repair_box'] = $row['repair_box'];
            $output['created_at'] = $row['created_at'];
            $output['updated_at'] = $row['updated_at'];
        }
        return $output;
    }

    public static function getUserName($login)
    {

        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM `users` WHERE `name` = '$login'");
        $output[] = [];
        while ($row = $res->fetch_assoc()) {
            $output['id'] = $row['id'];
            $output['name'] = $row['name'];
            $output['password'] = $row['password'];
            $output['role'] = $row['role'];
            $output['created_at'] = $row['created_at'];
            $output['updated_at'] = $row['updated_at'];
        }
        return $output;
    }

    public static function getUserNameForClient($login)
    {

        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("SELECT * FROM `users` WHERE `name` = '$login'");
        $output[] = [];
        while ($row = $res->fetch_assoc()) {
            $output['id'] = $row['id'];
            $output['name'] = $row['name'];
            $output['role'] = $row['role'];
        }
        return $output;
    }

}