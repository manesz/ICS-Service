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
    private $tableImageName = "ics_image";
    private $tableMapImageName = "ics_map_image_issue";

    function issueList($id = 0)
    {
        $memberID = @$this->session->userdata['id'];
        $objMember = $this->Member_model->memberList($memberID);
        $companyID = $objMember[0]->company_id;

        $strAnd = $id == 0 ? "" : " AND id = $id";
        if ($companyID != 1) {
            $strAnd .= " AND company_id = $companyID";
        }

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
        $memberID = @$this->session->userdata['id'];
        $objMember = $this->Member_model->memberList($memberID);
        $companyID = $objMember[0]->company_id;
        $data = array(
            'title' => trim(@$title),
            'description' => @$description,
            'status' => "create",
            'company_id' => @$companyID,
            'member_id' => @$memberID,
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );
        $this->db->insert($this->tableName, $data);
        $issueID = $this->db->insert_id($this->tableName);
        if (!$issueID) return false;

        //Add Image
        if (!empty($array_image)) {
            foreach ($array_image as $value) {
                $image_name = @$value[0];
                $image_data = @$value[1];
                $image_title = @$value[2];
                $image_description = @$value[3];
                $imagePath = $this->Upload_model->convertImageName($image_data, $image_name, @$imagePatch, @$fileType);
                if ($imagePath) {
                    $this->Upload_model->loadImage($imagePath);
                    //$this->Upload_model->resizeToWidth(300);
                    $this->Upload_model->save($imagePath);
                } else {
                    $imagePath = '';
                }

                //add table image
                $data = array(
                    'title' => trim($image_title),
                    'description' => $image_description,
                    'image' => $imagePath,
                    'create_datetime' => date('Y-m-d H:i:s'),
                    'update_datetime' => "0000-00-00 00:00:00",
                    'publish' => 1,
                );
                $this->db->insert($this->tableImageName, $data);
                $imageID = $this->db->insert_id($this->tableImageName);
                if (!$imageID) return false;

                //add table map
                $data = array(
                    'image_id' => $imageID,
                    'issue_id' => $issueID,
                    'create_datetime' => date('Y-m-d H:i:s'),
                    'update_datetime' => "0000-00-00 00:00:00",
                    'publish' => 1,
                );
                $this->db->insert($this->tableMapImageName, $data);
                $mapID = $this->db->insert_id($this->tableMapImageName);
                if (!$mapID) return false;
            }

        }else {

        }
        return $issueID;
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

    function getImageByIssueID($issueID = 0) {
        $strAnd = $issueID == 0?"" :" AND a.issue_id = $issueID ";
        $sql = "
            SELECT
              b.*,
              a.id AS map_id
            FROM $this->tableMapImageName a
            INNER JOIN $this->tableImageName b ON (
              a.image_id = b.id AND b.publish = 1
            )
            WHERE 1
            AND a.publish = 1
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
}