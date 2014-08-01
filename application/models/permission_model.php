<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 03/12/2556
 * Time: 15:00 น.
 * To change this template use File | Settings | File Templates.
 */


class Permission_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->tableName = $this->Constant_model->tbPermission;
        $this->tbUserGroup = $this->Constant_model->tbUserGroup;
    }


    private $tableName = "";
    private $tbUserGroup = "";
    /**
     * @param $id | member id
     * @param $moduleID | module id
     * @return bool
     */
    function checkPermission($id, $moduleID)
    {
        $sql ="
            SELECT
              a.id AS user_group_id,
              b.id AS permission_id,
              b.permission
            FROM
              `$this->tbUserGroup` a
              INNER JOIN `$this->tableName` b
                ON (
                  a.`permission_id` = b.`id`
                  AND b.`publish` = 1
                )
            WHERE 1
              AND a.`publish` = 1
              AND a.`user_id` = $id
              AND b.`module_id` = $moduleID
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }

    function permissionNew($moduleID, $permission)
    {
        $data = array(
            'title' => @$title,
            'description' => @$description,
            'module_id' => intval($moduleID),
            'permission' => $permission,
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );//var_dump($data);exit;
        $this->db->insert($this->tableName, $data);
        $id = $this->db->insert_id($this->tableName);
        if (!$id) return false;
        $data['id'] = $id;
        $this->Log_model->logAdd('add permission', $this->tableName, __LINE__, $data);
        return $id;
    }

    function permissionEdit($id, $moduleID, $permission)
    {
        $data = array(
            'id' => $id,
            'module_id  ' => intval($moduleID),
            'permission  ' => $permission,
            'update_datetime' => date('Y-m-d H:i:s'),
        );
        $this->Log_model->logAdd('edit permission', $this->tableName, __LINE__, $data);
        return $this->db->update($this->tableName, $data, array('id' => $id));
    }

    function userGroupNew($userID, $permissionID)
    {
        $data = array(
            'user_id' => intval($userID),
            'permission_id  ' => intval($permissionID),
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );
        $this->Log_model->logAdd('add user group', $this->tbUserGroup, __LINE__, $data);
        $this->db->insert($this->tbUserGroup, $data);
        return $id = $this->db->insert_id($this->tbUserGroup);
    }
}