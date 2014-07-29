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
    }

    private $tableName = "ics_device";
    function deviceList($id = 0, $orderBy = "")
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
            'name' => trim($name),
            'model' => trim($model),
            'brand' => trim($brand),
            'type' => @$type,
            'image' => @$imagePath,
            'datesheet' => @$datesheet,
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );
        $this->db->insert($this->tableName, $data);
        return $id = $this->db->insert_id($this->tableName);
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
            'name' => trim($name),
            'model' => trim($model),
            'brand' => trim($brand),
            'type' => @$type,
            'image' => @$imagePath,
            'datesheet' => @$datesheet,
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 1,
        );
        return $this->db->update($this->tableName, $data, array('id' => $id));
    }


}