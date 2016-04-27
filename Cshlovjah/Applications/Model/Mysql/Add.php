<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 26.04.16
 * Time: 16:17
 */

require_once('Mysql.php');

class Add
{
    
    //Вставить в таблицу имя клиента и нормер телефона
    public static function addCustomerNameAndPhone($data){
        $name = $data['customer_name'];
        $phone = $data['customer_phone'];
        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("INSERT INTO `customer` (name, phone) VALUES('$name','$phone')");
        return $res;
    }

    //Добавить авто 
    public static function addCustomerCarVin($data)
    {
        $name = $data['customer_car_name'];
        $mileage = $data['customer_car_mileage'];
        $vin = $data['customer_car_vin'];
        $gv_number = $data['customer_car_gv_number'];
        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("INSERT INTO `customer_car` (name, mileage, vin, gv_number  ) VALUES('$name','$mileage','$vin','$gv_number')");
        return $res;
    }

    public static function addEvent($data)
    {

        $mysqlConn = Mysql::Connection();

        $repair_post_id = str_replace($data['repair_box_id'],'',$data['repair_post_id']);
        $repair_type_id = $data['repair_type_id'];
        $user_owner_id = $data['user_owner_id'];
        $user_target_id = $data['user_target_id'];
        $state = $data['state'];
        $customer_id = $data['customer_id'];
        $customer_car_id = $data['customer_car_id'];
        $startdatetime = $data['startdatetime'];
        $enddatetime = $data['enddatetime'];
        $updated_at = $data['updated_at'];
        file_put_contents('test/addEvent.txt', serialize($data));
        if (!$mysqlConn->query("INSERT INTO mechanic_work(repair_post_id, repair_type_id,user_owner_id,
        user_target_id,state,customer_id,customer_car_id,startdatetime,enddatetime,updated_at)
         VALUES
         ('$repair_post_id',
         '$repair_type_id',
         '$user_owner_id',
         '$user_target_id',
         '$state',
         '$customer_id',
         '$customer_car_id',
         '$startdatetime',
         '$enddatetime',
         '$updated_at')")
        ) {
            echo "Не удалось добавить в таблицу: (" . $mysqlConn->errno . ") " . $mysqlConn->error;
            $output = 'error';
        }

        $output = 'OK';
        return $output;


    }
}