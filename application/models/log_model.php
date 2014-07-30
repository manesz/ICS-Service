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
        $this->tableMember = $this->Constant_model->tbMember;
    }

    private $tableName = "";
    private $tableMember = "";

    function logList($id = 0, $orderBy, $limit)
    {
        $strAnd = $id == 0 ? "" : " AND id = $id";
        $strOrder = $orderBy ? " ORDER BY $orderBy" : " ORDER BY id DESC";
        $limit = $limit ? " LIMIT $limit" : " LIMIT 50";
        $sql = "
            SELECT
              *
            FROM $this->tableName
            WHERE 1
            $strAnd
            $strOrder
            $limit
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return (object)array();
        }
    }

    function feedList($max_feed = 0)
    {
        $strAND = $max_feed ? " AND a.id = $max_feed" : "";
        $sql = "
            SELECT
              a.*,
              CONCAT(b.prefix,
              b.firstname, ' ',
              b.lastname) AS name
            FROM $this->tableName a
            INNER JOIN $this->tableMember b
            ON (a.member_id = b.id)
            WHERE 1
            $strAND
            ORDER BY a.id DESC
            LIMIT 50
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return null;
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
                'id' => $memberId,
                'username' => $username,
                'line' => $line,
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