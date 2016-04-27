<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 26.04.16
 * Time: 15:01
 */

require_once('/var/www/Cshlovjah/Applications/Model/Mysql/Mysql.php');
require_once('/var/www/Cshlovjah/Applications/Model/Mysql/Get.php');
require_once('/var/www/Cshlovjah/Applications/Model/Mysql/Add.php');
require_once('/var/www/Cshlovjah/Applications/Model/Mysql/Update.php');

class Check
{
    public static function checkCustomer($requestToCheck)
    {
        //Из массива формы берем значение customer_name и используем как параметр для проверки,
        // есть он в базе этот customer_name или нет
        $customer_name = $requestToCheck['customer_name'];
        $customer_db_array = Get::getCustomerName($customer_name);
        foreach ($customer_db_array as $value) {
            $customer_db['customer_id'] = $value['customer_id'];
            $customer_db['customer_name'] = $value['customer_name'];
            $customer_db['customer_phone'] = $value['customer_phone'];
        }
        $customer_name_db = $customer_db['customer_name'];
        if ($customer_name_db) {

            $exist['customer_id'] = $customer_db['customer_id'];
            $exist['customer_name'] = $requestToCheck['customer_name'];
            $exist['customer_phone'] = $requestToCheck['customer_phone'];
            $exist['customer_state_exist'] = 'exist';
            $exist['method'] = 'checkCustomer';
            return $exist;
        } else {

            $notexist['customer_name'] = $requestToCheck['customer_name'];
            $notexist['customer_phone'] = $requestToCheck['customer_phone'];
            $notexist['customer_state_exist'] = 'notexist';
            $notexist['method'] = 'checkCustomer';
            return $notexist;
        }
    }

    public static function checkCustomerCar($requestToCheck)
    {

        $customer_car_vin_array = Get::getCustomerCarVin($requestToCheck['customer_car_vin']);

        foreach ($customer_car_vin_array as $value) {
            $customer_car_db['customer_car_id'] = $value['customer_car_id'];
            $customer_car_db['customer_car_name'] = $value['customer_car_name'];
            $customer_car_db['customer_car_mileage'] = $value['customer_car_mileage'];
            $customer_car_db['customer_car_vin'] = $value['customer_car_vin'];
            $customer_car_db['customer_car_gv_number'] = $value['customer_car_gv_number'];

        }
        $customer_vin_db = $customer_car_db['customer_car_vin'];
        //Проверяем существует или нет customer_car
        if ($customer_vin_db) {
            $exist['customer_car_id'] = $customer_car_db['customer_car_id'];
            $exist['customer_car_name'] = $requestToCheck['customer_car_name'];
            $exist['customer_car_mileage'] = $requestToCheck['customer_car_mileage'];
            $exist['customer_car_vin'] = $requestToCheck['customer_car_vin'];
            $exist['customer_car_gv_number'] = $requestToCheck['customer_car_gv_number'];
            $exist['method'] = 'checkCustomerCar';
            $exist['customer_state_exist'] = 'exist';
            return $exist;

        } else {
            $notexist['customer_car_name'] = $requestToCheck['customer_car_name'];
            $notexist['customer_car_mileage'] = $requestToCheck['customer_car_mileage'];
            $notexist['customer_car_vin'] = $requestToCheck['customer_car_vin'];
            $notexist['customer_car_gv_number'] = $requestToCheck['customer_car_gv_number'];
            $notexist['method'] = 'checkCustomerCar';
            $notexist['customer_state_exist'] = 'notexist';

            return $notexist;
        }

    }

    //Хрень - переключатель - в зависимости что на входе, exist - делает update, noexist делает insert
    // Более тонко обрабатывать поля нет желания.

    public static function switcherCheck($data)
    {
        switch ($data['method']) {
            case 'checkCustomer':
                //Результат проверки по имени кустомера
                switch ($data['customer_state_exist']) {
                    case 'exist':
                        Update::updateCustomerNameAndPhone($data);
                        $customer_db_array = Get::getCustomerName($data['customer_name']);
                        foreach ($customer_db_array as $value) {
                            return $value['customer_id'];
                        }

                        break;
                    case 'notexist':
                        Add::addCustomerNameAndPhone($data);
                        $customer_db_array = Get::getCustomerName($data['customer_name']);
                        foreach ($customer_db_array as $value) {
                            return $value['customer_id'];
                        }
                        break;
                }
                break;
            //Результат проверки по вину
            case 'checkCustomerCar':
                switch ($data['customer_state_exist']) {
                    case 'exist':
                        Update::updateCustomerCarVin($data);

                        $customer_car_vin_array = Get::getCustomerCarVin($data['customer_car_vin']);

                        foreach ($customer_car_vin_array as $value) {
                            return $value['customer_car_id'];
                        }

                        break;
                    case 'notexist':
                        Add::addCustomerCarVin($data);
                        $customer_car_vin_array = Get::getCustomerCarVin($data['customer_car_vin']);

                        foreach ($customer_car_vin_array as $value) {
                            return $value['customer_car_id'];
                        }
                        break;
                }
                break;
        }
    }

}