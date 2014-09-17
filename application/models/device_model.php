<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 21/11/2556
 * Time: 19:35 น.
 * To change this template use File | Settings | File Templates.
 */


class Device_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->tableName = $this->Constant_model->tbDevice;
        $this->tbCustomer = $this->Constant_model->tbCustomer;
    }

    private $tableName = "";
    private $tbCustomer = "";
    function deviceList($id = 0, $orderBy = "")
    {
        $strAnd = $id == 0 ? "" : " AND a.id = $id";
        $strOrder = $orderBy ? " ORDER BY $orderBy" : " ORDER BY a.id DESC";
        $sql = "
            SELECT
              a.*,
              b.name_th
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

    function deviceAdd($post)
    {
        extract($post);

        $imagePath = $this->Upload_model->uploadBase64($post);
        if (!empty($imagePath)) {
            $this->Upload_model->loadImage($imagePath);
            $this->Upload_model->resizeToWidth(300);
            $this->Upload_model->save($imagePath);
        }

        $data = array(
            'name' => trim(@$name),
            'customer_id' => @$customer_id,
            'serial' => trim(@$serial),
            'model' => trim(@$model),
            'brand' => trim(@$brand),
            'type' => @$type,
            'image' => @$imagePath,
            'datesheet' => @$datesheet,
            'remark' => @$remark,
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );
        $this->db->insert($this->tableName, $data);
        $id = $this->db->insert_id($this->tableName);
        if (!$id) return false;
        $data['id'] = $id;
        $this->Log_model->logAdd('add device', $this->tableName, __LINE__, $data);
        return $id;
    }

    function deviceEdit($id, $post)
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
            'customer_id' => intval(@$customer_id),
            'name' => trim(@$name),
            'serial' => trim(@$serial),
            'model' => trim(@$model),
            'brand' => trim(@$brand),
            'type' => @$type,
            'image' => @$imagePath,
            'datesheet' => @$datesheet,
            'remark' => @$remark,
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 1,
        );
        $this->Log_model->logAdd('edit device', $this->tableName, __LINE__, $data);
        return $this->db->update($this->tableName, $data, array('id' => $id));
    }


}