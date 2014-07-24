<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 25/06/2557
 * Time: 11:44 น.
 * To change this template use File | Settings | File Templates.
 */
class Helper_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function ThaiIToUTF8($in)
    {
        $out = "";
        for ($i = 0; $i < strlen($in); $i++) {
            if (ord($in[$i]) <= 126)
                $out .= $in[$i];
            else
                $out .= "&#" . (ord($in[$i]) - 161 + 3585) . ";";
        }
        return $out;
    }

    function utf8_to_tis620($string)
    {
        $str = $string;
        $res = "";
        for ($i = 0; $i < strlen($str); $i++) {
            if (ord($str[$i]) == 224) {
                $unicode = ord($str[$i + 2]) & 0x3F;
                $unicode |= (ord($str[$i + 1]) & 0x3F) << 6;
                $unicode |= (ord($str[$i]) & 0x0F) << 12;
                $res .= chr($unicode - 0x0E00 + 0xA0);
                $i += 2;
            } else {
                $res .= $str[$i];
            }
        }
        return $res;
    }

    function formatBytes($size, $precision = 2)
    {
        $base = log($size) / log(1024);
        $suffixes = array('', 'k', 'M', 'G', 'T');

        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    }

    function convertDate($date = null)
    {
        if ($date && $date != '0000-00-00') {
            $date = trim($date);
            $arrDate = explode('/', $date);
            $date = $arrDate[2] . "-" . $arrDate[1] . "-" . $arrDate[0];
            return $date;
        } else {
            return '0000-00-00';
        }
    }

    function dateThai($date = null)
    {
        if ($date && $date != '0000-00-00') {
            $date = trim($date);
            $date = date("d/m/Y", strtotime($date));
            return $date;
        } else {
            return null;
        }
    }

    function calMicroTime($start, $end)
    {
        $duration = $end-$start;
        $hours = (int)($duration/60/60);
        $minutes = (int)($duration/60)-$hours*60;
        $seconds = (int)$duration-$hours*60*60-$minutes*60;
        return "$hours:$minutes:$seconds";
    }


}