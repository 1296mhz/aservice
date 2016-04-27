<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 26.04.16
 * Time: 15:05
 */

class Validate
{
    public static function checking($data)
    {
        //
        $check['customer_name'] = Validate::checkRussianWord($data['customer_name']);
        $check['customer_phone'] = Validate::checkPhone($data['customer_phone']);
        $check['customer_car_vin'] = Validate::checkVinNumber($data['customer_car_vin']);
        $check['customer_car_gv_number'] = Validate::checkGvNumber($data['customer_car_gv_number']);
        $check['customer_car_name'] = Validate::checkModelAuto($data['customer_car_name']);
        $check['customer_car_mileage'] = Validate::checkMileage($data['customer_car_mileage']);
        $check['repair_box_id'] = Validate::checkAll($data['repair_box_id']);
        $check['repair_post_id'] = Validate::checkAll($data['repair_post_id']);
        $check['repair_type_id'] = Validate::checkAll($data['repair_type_id']);
        $check['user_target_name'] = Validate::checkAll($data['user_target_name']);
        $check['state'] = Validate::checkAll($data['state']);


        //Проверяем время
        $startdatetime = Validate::dateTime($data['startdatetime']);
        $enddatetime = Validate::dateTime($data['enddatetime']);
        if ($startdatetime && $enddatetime) {
            if (Validate::dateTimeBetween($data['startdatetime'], $data['enddatetime'])) {
                $check['startdatetime'] = (bool)$data['startdatetime'];
                $check['enddatetime'] = (bool)$data['enddatetime'];
            } else {
                $check['startdatetime'] = false;
                $check['enddatetime'] = false;
                $check['error_datetime'] = 'end_times_longer';
            }
        } else {
            $check['startdatetime'] = false;
            $check['enddatetime'] = false;
            $check['error_datetime'] = 'internal_error_wrong_format';
        }
        return $check;
    }


    public static function clean($value)
    {
        $value = trim($value);
        $value = str_replace("(", "", $value);
        $value = str_replace(")", "", $value);
        $value = str_replace("-", "", $value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);

        return $value;
    }

    public static function cleanAuth($value)
    {
        $value = trim($value);
        $value = stripslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);

        return $value;
    }

    public static function check_length($value, $min, $max)
    {
        $result = (mb_strlen($value, 'UTF-8') < $min || mb_strlen($value, 'UTF-8') > $max);
        return !$result;
    }

    public static function checkPhone($phone)
    {

        if (!empty($phone)) {

            return (bool)preg_match('/^([+][7]|[8])([0-9])/', Validate::clean($phone));
        }

        return (bool)preg_match('/^([+][7]|[8])([0-9])/', Validate::clean($phone));
    }

    public static function checkRussianWord($word)
    {
        return Validate::check_length($word, '5', '40');
    }


    public static function checkVinNumber($vin)
    {
        if (!empty($vin) && (preg_match('/^[A-Z0-9]{17}$/', $vin))) {

            return true;
        }
        return false;
    }

    public static function checkGvNumber($gv_number)
    {
        if (!empty($gv_number) && (preg_match('/^[А-ЯA-Z0-9]/', $gv_number))) {

            return true;
        }
        return false;
    }

    public static function checkModelAuto($model)
    {
        if (!empty($model) && (preg_match('/^[А-ЯA-Z0-9]/', $model))) {

            return true;
        }
        return false;
    }

    public static function checkMileage($mileage)
    {
        if (!empty($mileage) && (preg_match('/^[0-9]/', $mileage))) {

            return true;
        }
        return false;
    }

    public static function checkAll($all)
    {
        return (bool)Validate::clean($all);
    }

    public static function dateTime($dateTime)
    {
        return (bool)preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2})/', $dateTime);
    }

    public static function dateTimeBetween($start, $end)
    {
        if ($start >= $end) {
            return false;
        }
        return true;
    }

}