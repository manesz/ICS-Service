<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 29/10/2556
 * Time: 22:55 น.
 * To change this template use File | Settings | File Templates.
 */


class Member_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    private $tableNameMember = "ics_member";
    private $tableNameDepartment = "ics_department";
    private $tableNamePosition = "ics_position";


    function memberList($id = 0)
    {
        $strSql = $id == 0 ? " AND a.username NOT LIKE '%admin%'" : " AND a.id = $id";
        $sql = "
            SELECT
              a.*,
              b.`title` AS position_name,
              c.`title` AS department_name
            FROM
              `$this->tableNameMember` a
              LEFT JOIN `$this->tableNamePosition` b
                ON (a.`position_id` = b.`id` AND b.publish = 1)
              LEFT JOIN `$this->tableNameDepartment` c
                ON (a.`department_id` = c.`id` AND c.publish = 1)
            WHERE 1
            AND a.publish = 1
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

    function memberAdd($post)
    {
        extract($post);

        $imagePath = $this->Upload_model->uploadBase64($post);
        if (!empty($imagePath)) {
            $this->Upload_model->loadImage($imagePath);
            $this->Upload_model->resizeToWidth(300);
            $this->Upload_model->save($imagePath);
        }
        $data = array(
            'employee_number' => ($employee_number),
            'username' => trim($username),
            'password' => md5($password),
            'prefix' => $prefix,
            'firstname' => trim($firstname),
            'lastname' => trim($lastname),
            'gender' => intval(@$gender),
            'age' => intval($age),
            'email' => trim($email),
            'phone' => trim($phone),
            'mobile' => trim($mobile),
            'address' => trim($address),
            'image_path' => $imagePath,
            'department_id' => intval($department_id),
            'position_id' => intval($position_id),
            'user_group' => @$user_group,
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );
        $this->db->insert($this->tableNameMember, $data);
        return $id = $this->db->insert_id($this->tableNameMember);
    }

    function memberEdit($id, $post)
    {
        extract($post);
        $imagePath = $this->Upload_model->uploadBase64($post);
        $imagePath = empty($imagePath) ? $image_path : $imagePath;
        if (!empty($imagePath)) {
            $this->Upload_model->loadImage($imagePath);
            $this->Upload_model->resizeToWidth(300);
            $this->Upload_model->save($imagePath);
        }

        $data = $password == "" ? array(
            'employee_number' => ($employee_number),
            'username' => trim($username),
            'prefix' => $prefix,
            'firstname' => trim($firstname),
            'lastname' => trim($lastname),
            'gender' => intval(@$gender),
            'age' => intval($age),
            'email' => trim($email),
            'phone' => trim($phone),
            'mobile' => trim($mobile),
            'address' => trim($address),
            'image_path' => $imagePath,
            'department_id' => intval($department_id),
            'position_id' => intval($position_id),
            'user_group' => @$user_group,
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 1,
        ) : array(
            'employee_number' => ($employee_number),
            'username' => trim($username),
            'password' => md5($password),
            'prefix' => $prefix,
            'firstname' => trim($firstname),
            'lastname' => trim($lastname),
            'gender' => intval(@$gender),
            'age' => intval($age),
            'email' => trim($email),
            'phone' => trim($phone),
            'mobile' => trim($mobile),
            'address' => trim($address),
            'image_path' => $imagePath,
            'department_id' => intval($department_id),
            'position_id' => intval($position_id),
            'user_group' => @$user_group,
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 1,
        );
        return $this->db->update($this->tableNameMember, $data, array('id' => $id));
    }

    function setModule($id, $post)
    {
        extract($post);
        $data = array();
        return $this->db->update($this->tableNameMember, $data, array('id' => $id));
    }

    function checkDuplicate($name)
    {
        $strSql = "AND username = '$name'";
        $sql = "
            SELECT
              a.*
            FROM
              `$this->tableNameMember` a
            WHERE 1
            AND a.publish = 1
            $strSql
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            return false;
        } else {
            return true;
        }
    }
}