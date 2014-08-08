<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 8/8/2557
 * Time: 8:35 น.
 */

class Quotation_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->tbQuotation = $this->Constant_model->tbQuotation;
    }

    private $tbQuotation = "";
    function quotationList($id = 0, $orderBy = "")
    {
        $strAnd = $id == 0 ? "" : " AND id = $id";
        $strOrder = $orderBy ? " ORDER BY $orderBy" : " ORDER BY id DESC";
        $sql = "
            SELECT
              *
            FROM
              `$this->tbQuotation`
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

    function quotationAdd($post)
    {
        extract($post);
        $data = array(
            'title' => trim(@$title),
            'description' => trim(@$description),
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );
        $this->db->insert($this->tbQuotation, $data);
        $id = $this->db->insert_id($this->tbQuotation);
        if (!$id) return false;
        $data['id'] = $id;
        $this->Log_model->logAdd('add quotation', $this->tbQuotation, __LINE__, $data);
        return $id;
    }

    function quotationEdit($id, $post)
    {
        extract($post);
        $data = array(
            'id' => $id,
            'title' => trim(@$title),
            'description' => trim(@$description),
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 1,
        );
        $this->Log_model->logAdd('edit quotation', $this->tbQuotation, __LINE__, $data);
        return $this->db->update($this->tbQuotation, $data, array('id' => $id));
    }
}