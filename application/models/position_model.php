<?php

class Position_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    private $tableName = "ics_position";
    function positionList($id = 0, $orderBy = "")
    {
        $strAnd = $id == 0 ? "" : " AND id = $id";
        $strOrder = $orderBy ? " ORDER BY $orderBy" : " ORDER BY id DESC";
        $sql = "
            SELECT
              *
            FROM
              `$this->tableName`
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

    function positionAdd($post)
    {
        extract($post);
        $data = array(
            'title' => trim(@$title),
            'description' => trim(@$description),
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );
        $this->db->insert($this->tableName, $data);
        return $id = $this->db->insert_id($this->tableName);
    }

    function positionEdit($id, $post)
    {
        extract($post);
        $data = array(
            'title' => trim(@$title),
            'description' => trim(@$description),
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 1,
        );
        return $this->db->update($this->tableName, $data, array('id' => $id));
    }
}