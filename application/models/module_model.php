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
    }

    function moduleList($id = 0)
    {
        $strSql = $id == 0 ? "" : " AND id = $id";
        $sql = "
            SELECT
              *
            FROM `module`
            WHERE 1
            AND publish = 1
            $strSql
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
        $this->db->insert('module', $data);
        return $id = $this->db->insert_id('module');
    }

    function moduleEdit($id, $post)
    {
        extract($post);
        $data = array(
            'title' => trim(@$title),
            'description' => trim(@$description),
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 1,
        );
        return $this->db->update('module', $data, array('id' => $id));
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
}