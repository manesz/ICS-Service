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
        $this->tableNameMember = $this->Constant_model->tbMember;
        $this->tableNameDepartment = $this->Constant_model->tbDepartment;
        $this->tableNamePosition = $this->Constant_model->tbPosition;
    }

    private $tableNameMember = "";
    private $tableNameDepartment = "";
    private $tableNamePosition = "";


    function memberList($id = 0, $orderBy = "")
    {
        $strAnd = $id == 0 ? " AND a.username NOT LIKE '%admin%'" : " AND a.id = $id";
        $strOrder = $orderBy ? " ORDER BY $orderBy" : " ORDER BY a.id DESC";
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
            'company_id' => intval($company_id),
            'department_id' => intval($department_id),
            'position_id' => intval($position_id),
            'user_group' => @$user_group,
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );
        $this->db->insert($this->tableNameMember, $data);
        $id = $this->db->insert_id($this->tableNameMember);
        if (!$id) return false;
        $data['id'] = $id;
        $this->Log_model->logAdd('add member', $this->tableNameMember, __LINE__, $data);
        return $id;
    }

    function memberEdit($id, $post)
    {
        $memberId = @$this->session->userdata['id'];
        $usernameLogin = @$this->session->userdata['username'];
        $companyIDLogin = @$this->session->userdata['company_id'];
        $checkEditUser = false;
        if ($usernameLogin == 'admin' || $companyIDLogin == 1) {
            $checkEditUser = true;
        }

        extract($post);
        $imagePath = $this->Upload_model->uploadBase64($post);
        $imagePath = empty($imagePath) ? $image_path : $imagePath;
        if (!empty($imagePath)) {
            $this->Upload_model->loadImage($imagePath);
            $this->Upload_model->resizeToWidth(300);
            $this->Upload_model->save($imagePath);
        }
        if ($password == "") { //ไม่เปลี่ยพาส
            if ($checkEditUser) {
                $data = array(
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
                    'company_id' => intval($company_id),
                    'department_id' => intval($department_id),
                    'position_id' => intval($position_id),
                    'user_group' => @$user_group,
                    'update_datetime' => date('Y-m-d H:i:s'),
                    'publish' => 1,
                );
            } else { //ไม่เป็น admin
                $data = array(
                    'employee_number' => ($employee_number),
                    //'username' => trim($username),
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
//            'company_id' => intval($company_id),
//            'department_id' => intval($department_id),
//            'position_id' => intval($position_id),
                    'user_group' => @$user_group,
                    'update_datetime' => date('Y-m-d H:i:s'),
                    'publish' => 1,
                );
            }
        } else { //เปลี่ยนพาส
            if ($checkEditUser) { //เป็น admin
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
                    'company_id' => intval($company_id),
                    'department_id' => intval($department_id),
                    'position_id' => intval($position_id),
                    'user_group' => @$user_group,
                    'update_datetime' => date('Y-m-d H:i:s'),
                    'publish' => 1,
                );
            } else { //ไม่เป็น admin
                $data = array(
                    'employee_number' => ($employee_number),
//            'username' => trim($username),
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
//            'company_id' => intval($company_id),
//            'department_id' => intval($department_id),
//            'position_id' => intval($position_id),
                    'user_group' => @$user_group,
                    'update_datetime' => date('Y-m-d H:i:s'),
                    'publish' => 1,
                );
            }
        }
        $data['id'] = $id;
        $this->Log_model->logAdd('edit member', $this->tableNameMember, __LINE__, $data);
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