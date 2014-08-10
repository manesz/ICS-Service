<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 29/10/2556
 * Time: 22:55 น.
 * To change this template use File | Settings | File Templates.
 */


class Constant_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function webUrl()
    {
        if (strstr($_SERVER['HTTP_HOST'], 'localhost') > -1) {
            $webUrl = base_url() . 'index.php/';
        } else {
            $webUrl = base_url();
        }
        return $webUrl;
    }

    /**
     * @param $id
     * @param $table
     * @return bool
     */
    function setPublish($id, $table)
    {
        $data = array(
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 0
        );
        return $this->db->update($table, $data, array('id' => $id));
    }

    /**
     * @param $index
     * @return array
     */
    function getShipMode($index = -1)
    {
        $arrData = array(
            "Air Freight",
            "Sea Freight",
            "CLRN",
        );
        if ($index >= 0) {
            return $arrData[$index];
        } else {
            return $arrData;
        }
    }

    /**
     * @param $index
     * @return array
     */
    function getShipper($index = -1)
    {
        $arrData = array(
            1 => "A",
            2 => "B",
            3 => "C",
        );
        if ($index >= 0) {
            return $arrData[$index];
        } else {
            return $arrData;
        }
    }

    /**
     * @param $index
     * @return array
     */
    function getConsignee($index = -1)
    {
        $arrData = array(
            1 => "A",
            2 => "B",
            3 => "C",
        );
        if ($index >= 0) {
            return $arrData[$index];
        } else {
            return $arrData;
        }
    }

    /**
     * @param $index
     * @return array
     */
    function getFreightType($index = -1)
    {
        $arrData = array(
            "Ocean Freight",
            "AMS",
            "IFS",
            "B/L Fee",
            "Surrander B/L Fee",
            "Terminal Charge",
            "Document Fee",
            "Customs Expoer Clearnace",
            "Port Security Charge",
            "Collection",
            "D/O Free",
        );
        if ($index >= 0) {
            return $arrData[$index];
        } else {
            return $arrData;
        }
    }

    /**
     * @param $index
     * @return array
     */
    function getFreightBasic($index = -1)
    {
        $arrData = array(
            'W/M',
            'CBM',
            'Shipment',
            'Truck',
            'Trip',
        );
        if ($index >= 0) {
            return $arrData[$index];
        } else {
            return $arrData;
        }
    }
    /**
     * เวลาเรียกใช้ให้เรียก ThaiBahtConversion(1234020.25); ประมาณนี้
     * @param numberic $amount_number
     * @return string
     */
    function ThaiBahtConversion($amount_number)
    {
        $amount_number = number_format($amount_number, 2, ".","");
        //echo "<br/>amount = " . $amount_number . "<br/>";
        $pt = strpos($amount_number , ".");
        $number = $fraction = "";
        if ($pt === false)
            $number = $amount_number;
        else
        {
            $number = substr($amount_number, 0, $pt);
            $fraction = substr($amount_number, $pt + 1);
        }

        //list($number, $fraction) = explode(".", $number);
        $ret = "";
        $baht = $this->ReadNumber ($number);
        if ($baht != "")
            $ret .= $baht . "บาท";

        $satang = $this->ReadNumber($fraction);
        if ($satang != "")
            $ret .=  $satang . "สตางค์";
        else
            $ret .= "ถ้วน";
        //return iconv("UTF-8", "TIS-620", $ret);
        return $ret;
    }

    function ReadNumber($number)
    {
        $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
        $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
        $number = $number + 0;
        $ret = "";
        if ($number == 0) return $ret;
        if ($number > 1000000)
        {
            $ret .= $this->ReadNumber(intval($number / 1000000)) . "ล้าน";
            $number = intval(fmod($number, 1000000));
        }

        $divider = 100000;
        $pos = 0;
        while($number > 0)
        {
            $d = intval($number / $divider);
            $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" :
                ((($divider == 10) && ($d == 1)) ? "" :
                    ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
            $ret .= ($d ? $position_call[$pos] : "");
            $number = $number % $divider;
            $divider = $divider / 10;
            $pos++;
        }
        return $ret;
    }
    //---------------------------------Table name--------------------------------//
    public $sessionName = "ics_session_url";
    public $tbLog = "ics_log";
    public $tbCompany = "ics_company";
    public $tbCustomer = "ics_customer";
    public $tbDevice = "ics_device";
    public $tbProject = "ics_project";
    public $tbMember = "ics_member";
    public $tbIssue = "ics_issue";
    public $tbImage = "ics_image";
    public $tbMapImageIssue = "ics_map_image_issue";
    public $tbDepartment = "ics_department";
    public $tbPosition = "ics_position";
    public $tbModule = "ics_module";
    public $tbPermission = "ics_permission";
    public $tbUserGroup = "ics_user_group";
    public $tbQuotation = "ics_quotation";
    public $tbQuotationItem = "ics_quotation_item";

    //---------------------------------End Table name--------------------------------//

}