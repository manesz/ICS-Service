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

    function memberList($id = 0)
    {
        $strSql = $id == 0 ? "" : " AND a.id = $id";
        $sql = "
            SELECT
              a.*
            FROM
              `member` a
              #LEFT JOIN `position` b
              #  ON (a.`position_id` = b.`id` AND b.publish = 1)
              #LEFT JOIN `department` c
              #  ON (a.`department_id` = c.`id` AND c.publish = 1)
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
            'first_name' => trim($first_name),
            'last_name' => trim($last_name),
            'telephone' => trim($telephone),
            'mobile' => trim($mobile),
            'email' => trim($email),
            'username' => trim($username),
            'password' => md5($password),
            'image' => $imagePath,
            'permission' => @$permission,
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );
        $this->db->insert('member', $data);
        return $id = $this->db->insert_id('member');
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
            'first_name' => trim($first_name),
            'last_name' => trim($last_name),
            'telephone' => trim($telephone),
            'mobile' => trim($mobile),
            'email' => trim($email),
            'username' => trim($username),
            //'password' => md5($password),
            'image' => $imagePath,
            'permission' => @$permission,
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 1,
        ) : array(
            'first_name' => trim($first_name),
            'last_name' => trim($last_name),
            'telephone' => trim($telephone),
            'mobile' => trim($mobile),
            'email' => trim($email),
            'username' => trim($username),
            'password' => md5($password),
            'image' => $imagePath,
            'permission' => @$permission,
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 1,
        );
        return $this->db->update('member', $data, array('id' => $id));
    }

    function setModule($id, $post)
    {
        extract($post);
        $data = array();
        return $this->db->update('member', $data, array('id' => $id));
    }
}