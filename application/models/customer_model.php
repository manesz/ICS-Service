<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 21/11/2556
 * Time: 19:35 น.
 * To change this template use File | Settings | File Templates.
 */
class Customer_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->tableName = $this->Constant_model->tbCustomer;
    }

    private $tableName = "";

    function customerList($id = 0, $type = "", $orderBy = "")
    {
        $strAnd = $id == 0 ? "" : " AND id = $id";
        $strOrder = $orderBy ? " ORDER BY $orderBy" : " ORDER BY id DESC";
        $sql = "
            SELECT
              *
            FROM $this->tableName
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

    function customerAdd($post, $publish = 1)
    {
        extract($post);
        if ($post) {
            $imagePath = $this->Upload_model->uploadBase64($post);
            if (!empty($imagePath)) {
                $this->Upload_model->loadImage($imagePath);
                $this->Upload_model->resizeToWidth(300);
                $this->Upload_model->save($imagePath);
            }
        }

        $data = array(
            'name_th' => @$name_th,
            'name_en' => @$name_en,
            'taxpayer_number' => @$taxpayer_number,
            'address_th' => @$address_th,
            'address_en' => @$address_en,
            'telephone' => @$telephone,
            'fax' => @$fax,
            'email' => @$email,
            'image' => @$imagePath,
            'remark' => @$remark,
            'location' => trim(@$location),
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => $publish,
        );
        $this->db->insert($this->tableName, $data);
        $id = $this->db->insert_id($this->tableName);
        if (!$id) return false;
        $data['id'] = $id;
        $this->Log_model->logAdd('add customer', $this->tableName, __LINE__, $data);
        return $id;
    }

    function customerEdit($id, $post, $publish = 1)
    {
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
            'name_th' => @$name_th,
            'name_en' => @$name_en,
            'taxpayer_number' => @$taxpayer_number,
            'address_th' => @$address_th,
            'address_en' => @$address_en,
            'telephone' => @$telephone,
            'fax' => @$fax,
            'email' => @$email,
            'image' => @$imagePath,
            'remark' => @$remark,
            'location' => trim(@$location),
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => $publish,
        );
        $this->Log_model->logAdd('edit customer', $this->tableName, __LINE__, $data);
        return $this->db->update($this->tableName, $data, array('id' => $id));
    }
}