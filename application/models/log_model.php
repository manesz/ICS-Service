<?php

/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 7/29/14
 * Time: 5:16 PM
 */
class Log_model extends CI_Model
{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->tableName = $this->Constant_model->tbLog;
    }

    private $tableName = "";

    function logList($id = 0, $type = "")
    {
        $strAnd = $id == 0 ? "" : " AND id = $id";
        $sql = "
            SELECT
              *
            FROM $this->tableName
            WHERE 1
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

    function logAdd($title, $table, $line, $data = array())
    {
        //json_encode($data) //converts an array to JSON string
        //json_decode($jsonString) //converts json string to php array
        $memberId = @$this->session->userdata['id'];
        $username = @$this->session->userdata['username'];
        if (is_array($data)) {
            $data["line"] = $line;
            $data["table"] = $table;
        } else {
            $data = array(
                'id' =>$memberId,
                'username' =>$username,
                'line' =>$line,
                'table' => $table,
            );
        }
        $description = json_encode($data);
//        $title = $this->createTitleLog($type, $table, $line);
        $data = array(
            'title' => $title,
            'description' => $description,
            'member_id' => intval($memberId),
            'create_datetime' => date('Y-m-d H:i:s'),
        );
        $this->db->insert($this->tableName, $data);
        return $id = $this->db->insert_id($this->tableName);
    }

    function createTitleLog($type, $table)
    {
        return "$type;$table";
    }

    function deleteLog()
    {
        $sql = "
          DELETE FROM $this->tableName WHERE create_datetime < DATE_SUB(NOW(), INTERVAL 1 MONTH);
        ";
        $query = $this->db->query($sql);
        $this->logAdd("check delete log", 'log', __LINE__, $query);
        return true;
    }
}