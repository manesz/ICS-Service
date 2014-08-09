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