<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 26.04.16
 * Time: 16:26
 */

require_once('Mysql.php');

class Update
{
    public static function updateCustomerNameAndPhone($data)
    {
        $id = $data['customer_id'];
        $name = $data['customer_name'];
        $phone = $data['customer_phone'];
        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("UPDATE `customer` SET name='$name', phone='$phone' WHERE id=$id");
        return $res;
    }

    public static function updateCustomerCarVin($data)
    {
        $id = $data['customer_car_id'];
        $name = $data['customer_car_name'];
        $vin = $data['customer_car_vin'];
        $mileage = $data['customer_car_mileage'];
        $gv_number = $data['customer_car_gv_number'];
        $mysqlConn = Mysql::Connection();
        $res = $mysqlConn->query("UPDATE `customer_car` SET name='$name', vin='$vin', mileage='$mileage', gv_number='$gv_number' WHERE id=$id");
        return $res;
    }

    public static function updateEvent($data)
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
        
        if (!$mysqlConn->query("UPDATE `mechanic_work` 
                                SET repair_post_id = '$repair_post_id', 
                                repair_type_id = '$repair_type_id', 
                                user_owner_id = $user_owner_id,
                                user_target_id = $user_target_id,
                                state = $state,
                                customer_id = $customer_id,
                                customer_car_id = $customer_car_id,
                                startdatetime = $startdatetime,
                                enddatetime = $enddatetime,
                                updated_at = $updated_at")
        ) {
            echo "Не удалось добавить в таблицу: (" . $mysqlConn->errno . ") " . $mysqlConn->error;
            $output = 'error';
        }

        $output = 'OK';
        return $output;


    }
}