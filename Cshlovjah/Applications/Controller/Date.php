<?php
/**
 * Created by PhpStorm.
 * User: cshlovjah
 * Date: 26.04.16
 * Time: 15:03
 */


class Date
{
    public static function getCurrentDateShift()
    {
        $currentDate = date("Y-m-d");
        $date = new DateTime($currentDate . " " . '07:30:00');
        $day = DateInterval::createFromDateString('30 minutes');
        $a = 0;
        $iterations = 30;

        while ($a <= $iterations) {
            $currentShift['shiftDateTime'][$a] = $date->add($day)->format('Y-m-d H:i:s');
            $a++;
        }

        $index = 0;
        foreach ($currentShift['shiftDateTime'] as $value) {
            $currentShift['shiftDate'][$index] = explode(" ", $value);
            $index++;
        }

        return $currentShift['shiftDate'];
    }

    public static function getCurrentDate()
    {
        $currentDate = date("Y-m-d H:m:s");
        return $currentDate;
    }

    public static function getCurrentDateTime()
    {
        $currentDate = date("Y-m-d");
        return $currentDate;
    }

    public static function getCurrentYearAndMonth()
    {
        $YearAndMonth = date("Y-m");
        return $YearAndMonth;
    }

    public static function getCurrentMonth()
    {
        $Month = date("m");
        return $Month;
    }


    public static function getCurrentYear()
    {
        $Year = date("Y");
        return $Year;
    }
}