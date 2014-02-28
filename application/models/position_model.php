<?php

class Position_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function positionList($id = 0)
    {
        $strSql = $id == 0 ? "" : " AND id = $id";
        $sql = "
            SELECT
              *
            FROM
              `ics_position`
            WHERE 1
            $strSql
            AND publish = 1
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
        $this->db->insert('ics_position', $data);
        return $id = $this->db->insert_id('ics_position');
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
        return $this->db->update('ics_position', $data, array('id' => $id));
    }
}