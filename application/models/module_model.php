<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 02/12/2556
 * Time: 10:00 น.
 * To change this template use File | Settings | File Templates.
 */


class Module_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->tableName = $this->Constant_model->tbModule;
        $this->tbPermission = $this->Constant_model->tbPermission;
        $this->tbUserGroup = $this->Constant_model->tbUserGroup;
    }

    public $arrModule = array("list", "insert", "update", "delete", "report1", "report2", "report3");
    public $strCheckNon = "0,0,0,0,0,0,0";
    public $strCheckAll = "1,1,1,1,1,1,1";
    private $tableName = "";
    private $tbPermission = "";
    private $tbUserGroup = "";
    function moduleList($id = 0, $orderBy = "")
    {
        $strAnd = $id == 0 ? "" : " AND id = $id";
        $strOrder = $orderBy ? " ORDER BY $orderBy" : " ORDER BY id DESC";
        $sql = "
            SELECT
              *
            FROM `$this->tableName`
            WHERE 1
            AND publish = 1
            $strAnd
            $strOrder
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return (object)array();
        }
    }

    function moduleAdd($post)
    {
        extract($post);
        $data = array(
            'title' => trim(@$title),
            'description' => trim(@$description),
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );
        $this->db->insert($this->tableName, $data);
        $id = $this->db->insert_id($this->tableName);
        if (!$id) return false;
        $data['id'] = $id;
        $this->Log_model->logAdd('add module', $this->tableName, __LINE__, $data);
        return $id;
    }

    function moduleEdit($id, $post)
    {
        extract($post);
        $data = array(
            'id' => $id,
            'title' => trim(@$title),
            'description' => trim(@$description),
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 1,
        );
        $this->Log_model->logAdd('edit module', $this->tableName, __LINE__, $data);
        return $this->db->update($this->tableName, $data, array('id' => $id));
    }

    function moduleSet($id, $post)
    {
        extract($post);
        $resultCheck = $this->Permission_model->checkPermission($id, $module_id);
        if (!$resultCheck) {
            $resultID = $this->Permission_model->permissionNew($module_id, $permission);
            if (!$resultID) {
                return false;
            } else {
                $resultNew = $this->Permission_model->userGroupNew($id, $resultID);
                if (!$resultNew) {
                    return false;
                }
            }
        } else {
            $resultEdit = $this->Permission_model->permissionEdit($resultCheck[0]->permission_id, $module_id, $permission);
            if (!$resultEdit) {
                return false;
            }
        }
        return true;
    }


    function checkModuleByName($module = "")
    {
        $id = @$this->session->userdata['id'];
        $strAnd = " AND c.`user_id` = $id";
        $strAnd .= $module == "" ? "" : " AND a.title = '$module'";
        $sql = "
            SELECT
              a.*
              ,b.`permission`
            FROM
              `$this->tableName` a
              INNER JOIN `$this->tbPermission` b
                ON (
                  a.`id` = b.`module_id`
                  AND b.`publish` = 1
                )
              INNER JOIN `$this->tbUserGroup` c
                ON (
                  c.`permission_id` = b.`id`
                  AND c.`publish` = 1
                )
            WHERE 1
              AND a.`publish` = 1
              AND b.permission != '$this->strCheckNon'
              $strAnd
              ORDER BY a.sort, a.id
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return (object)array();
        }
    }

    function checkModuleByPermission($module = "", $index = "")
    {
        $id = @$this->session->userdata['id'];
        $strAnd = " AND c.`user_id` = $id";
        $strAnd .= $module == "" ? "" : " AND a.title = '$module'";
        $sql = "
            SELECT
              a.*
              ,b.`permission`
            FROM
              `$this->tableName` a
              INNER JOIN `$this->tbPermission` b
                ON (
                  a.`id` = b.`module_id`
                  AND b.`publish` = 1
                )
              INNER JOIN `$this->tbUserGroup` c
                ON (
                  c.`permission_id` = b.`id`
                  AND c.`publish` = 1
                )
            WHERE 1
              AND a.`publish` = 1
              $strAnd
              ORDER BY a.sort, a.id
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            $strPermission = $result[0]->permission;
            $expPermission = explode(',', $strPermission);
            $permission = $this->arrModule[$index];
            switch ($permission) {
                case $this->arrModule[0]:
                    $result = $expPermission[0] == 1 ? true : false;
                    break;
                case $this->arrModule[1]:
                    $result = $expPermission[1] == 1 ? true : false;
                    break;
                case $this->arrModule[2]:
                    $result = $expPermission[2] == 1 ? true : false;
                    break;
                case $this->arrModule[3]:
                    $result = $expPermission[3] == 1 ? true : false;
                    break;
                case $this->arrModule[4]:
                    $result = $expPermission[4] == 1 ? true : false;
                    break;
                case $this->arrModule[5]:
                    $result = $expPermission[5] == 1 ? true : false;
                    break;
                case $this->arrModule[6]:
                    $result = $expPermission[6] == 1 ? true : false;
                    break;
                default:
                    $result = false;
            }
            return $result;
        } else {
            return false;
        }
    }

    function getStrCheckAll()
    {
        return $this->strCheckAll;
    }
}