<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 01/03/2557
 * Time: 16:00 น.
 * To change this template use File | Settings | File Templates.
 */

class Issue_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    private $tableName = "ics_issue";
    function issueList($id = 0, $type = "")
    {
        $strAnd = $id == 0 ? "" : " AND id = $id";
        $sql = "
            SELECT
              *
            FROM $this->tableName
            WHERE 1
            AND publish = 1
            $strAnd
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return (object)array();
        }
    }

    function issueAdd($post)
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

    function issueEdit($id, $post)
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