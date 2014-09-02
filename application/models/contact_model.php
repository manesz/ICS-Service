<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Rux
 * Date: 08/08/2557
 * Time: 20:58 น.
 * To change this template use File | Settings | File Templates.
 */

class Contact_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->tableName = $this->Constant_model->tbContact;
        $this->tbCustomer = $this->Constant_model->tbCustomer;
    }

    private $tableName = "";
    private $tbCustomer = "";

    function contactList($id = 0, $customerID = 0, $orderBy = "")
    {
        $strAnd = $id == 0 ? "" : " AND a.id = $id";
        $strAnd .= $customerID ? " AND b.id=$customerID" : "";
        $strOrder = $orderBy ? " ORDER BY $orderBy" : " ORDER BY a.id DESC";
        $sql = "
            SELECT
              a.*,
              b.taxpayer_number,
              b.id AS customer_id,
              b.name_th AS customer_name_th,
              b.name_en AS customer_name_en,
              b.address_th,
              b.address_en,
              b.telephone,
              b.fax
            FROM $this->tableName a
            LEFT JOIN $this->tbCustomer b
            ON (a.customer_id = b.id AND b.publish = 1)
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

    function contactAdd($post)
    {
        if (!$post) return false;
        extract($post);
        $imagePath = $this->Upload_model->uploadBase64($post);
        if (!empty($imagePath)) {
            $this->Upload_model->loadImage($imagePath);
            $this->Upload_model->resizeToWidth(300);
            $this->Upload_model->save($imagePath);
        }

        $data = array(
            'customer_id' => @$customer_id,
            'name_th' => @$name_th,
            'name_en' => @$name_en,
            'mobile' => @$mobile,
            'email' => @$email,
            'image' => @$imagePath,
            'position' => @$position,
            'description' => @$description,
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );
        $this->db->insert($this->tableName, $data);
        $id = $this->db->insert_id($this->tableName);
        if (!$id) return false;
        $data['id'] = $id;
        $this->Log_model->logAdd('add contact', $this->tableName, __LINE__, $data);
        return $id;
    }

    function contactEdit($id, $post)
    {
        if (!$id || !$post) return false;
        extract($post);

        $imagePath = $this->Upload_model->uploadBase64($post);
        $imagePath = empty($imagePath) ? $image_path : $imagePath;
        if (!empty($imagePath)) {
            $this->Upload_model->loadImage($imagePath);
            $this->Upload_model->resizeToWidth(300);
            $this->Upload_model->save($imagePath);
        }

        $data = array(
            'id' => $id,
            'customer_id' => @$customer_id,
            'name_th' => @$name_th,
            'name_en' => @$name_en,
            'mobile' => @$mobile,
            'email' => @$email,
            'image' => @$imagePath,
            'position' => @$position,
            'description' => @$description,
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 1,
        );
        $this->Log_model->logAdd('edit contact', $this->tableName, __LINE__, $data);
        return $this->db->update($this->tableName, $data, array('id' => $id));
    }
}