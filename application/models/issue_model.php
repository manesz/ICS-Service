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
        $this->tableName = $this->Constant_model->tbIssue;
        $this->tableImageName = $this->Constant_model->tbImage;
        $this->tableMapImageName = $this->Constant_model->tbMapImageIssue;
        $this->tableCustomerName = $this->Constant_model->tbCustomer;
    }

    private $tableName = "";
    private $tableImageName = "";
    private $tableMapImageName = "";
    private $tableCustomerName = "";

    function issueList($id = 0, $orderBy = "")
    {
        $memberID = @$this->session->userdata['id'];
        $objMember = $this->Member_model->memberList($memberID);
        $usernameLogin = @$this->session->userdata['username'];
        $customerID = $objMember[0]->customer_id;

        $strAnd = $id == 0 ? "" : " AND a.id = $id";
        if ($usernameLogin != 'admin' && $customerID != 1) {
            $strAnd .= " AND a.customer_id = $customerID";
        }
        $strOrder = $orderBy ? " ORDER BY $orderBy" : " ORDER BY a.id DESC";

        $sql = "
            SELECT
              a.*,
              b.name_th,
              b.name_en
            FROM $this->tableName a
            INNER JOIN $this->tableCustomerName b ON (
              a.customer_id = b.id AND b.publish = 1
            )
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

    function issueAdd($post)
    {
        extract($post);
        $memberID = @$this->session->userdata['id'];
        $objMember = $this->Member_model->memberList($memberID);
        $customerID = $objMember[0]->customer_id;
        $data = array(
            'title' => trim(@$title),
            'description' => @$description,
            'status' => "create",
            'customer_id' => @$customerID,
            'member_id' => @$memberID,
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );
        $this->db->insert($this->tableName, $data);
        $issueID = $this->db->insert_id($this->tableName);
        if (!$issueID) return false;
        $data['id'] = $issueID;
        $this->Log_model->logAdd('add issue', $this->tableName, __LINE__, $data);

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
                $data['id'] = $imageID;
                $this->Log_model->logAdd('add image', $this->tableImageName, __LINE__, $data);

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
                $data['id'] = $mapID;
                $this->Log_model->logAdd('add map image', $this->tableMapImageName, __LINE__, $data);
            }

        } else {

        }
        return $issueID;
    }

    function issueEdit($id, $post)
    {
        extract($post);

        //Add Image
        if (!empty($array_image)) {
            foreach ($array_image as $value) {
                $image_name = @$value[0];
                $image_data = @$value[1];
                $image_title = @$value[2];
                $image_description = @$value[3];
                $old_image_id = @$value[4];
                if ($old_image_id != 0) { //แก้ไขรูปเก่า
                    if ($image_data != "") { //สร้างรูปใหม่
                        //var_dump($image_data);exit;
                        $imagePath = $this->Upload_model->convertImageName($image_data, $image_name, @$imagePatch, @$fileType);
                        if ($imagePath) {
                            $this->Upload_model->loadImage($imagePath);
                            //$this->Upload_model->resizeToWidth(300);
                            $this->Upload_model->save($imagePath);
                        } else {
                            $imagePath = '';
                        }
                        $data = array(
                            'title' => trim($image_title),
                            'description' => $image_description,
                            'image' => $imagePath,
                            'update_datetime' => date('Y-m-d H:i:s'),
                            'publish' => 1,
                        );
                    } else { //ไม่ได้สร้างรูปใหม่
                        $data = array(
                            'id' => $old_image_id,
                            'title' => trim($image_title),
                            'description' => $image_description,
                            'update_datetime' => date('Y-m-d H:i:s'),
                            'publish' => 1,
                        );
                    }
                    //update table image
                    $this->Log_model->logAdd('edit image', $this->tableImageName, __LINE__, $data);
                    $resultUpdate = $this->db->update($this->tableImageName, $data, array('id' => $old_image_id));
                    if (!$resultUpdate) return false;

                } else { //สร้างรูปใหม่
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
                    $data['id'] = $imageID;
                    $this->Log_model->logAdd('add image', $this->tableImageName, __LINE__, $data);

                    //add table map
                    $data = array(
                        'image_id' => $imageID,
                        'issue_id' => $id,
                        'create_datetime' => date('Y-m-d H:i:s'),
                        'update_datetime' => "0000-00-00 00:00:00",
                        'publish' => 1,
                    );

                    $this->db->insert($this->tableMapImageName, $data);
                    $mapID = $this->db->insert_id($this->tableMapImageName);
                    if (!$mapID) return false;
                    $data['id'] = $mapID;
                    $this->Log_model->logAdd('add map image', $this->tableMapImageName, __LINE__, $data);
                }

            }

        }
        $memberID = @$this->session->userdata['id'];
        $objMember = $this->Member_model->memberList($memberID);
        $customerID = $objMember[0]->customer_id;
        $data = array(
            'id' => $id,
            'title' => trim(@$title),
            'description' => @$description,
//            'status' => "create",
//            'customer_id' => @$customerID,
//            'member_id' => @$memberID,
            'update_datetime' => date('Y-m-d H:i:s'),
        );
        $this->Log_model->logAdd('edit issue', $this->tableName, __LINE__, $data);
        $resultUpdate = $this->db->update($this->tableName, $data, array('id' => $id));
        if (!$resultUpdate) return false;
        return true;
    }

    function getImageByIssueID($issueID = 0)
    {
        $strAnd = $issueID == 0 ? "" : " AND a.issue_id = $issueID ";
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

    function removeImage($id)
    {
        $sql = "
            SELECT
              id
            FROM $this->tableMapImageName
            WHERE 1
            AND publish = 1
            AND image_id = $id
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            $map_id = $result[0]->id;
        } else {
            return false;
        }
        $this->Log_model->logAdd('delete map image', $this->tableMapImageName, __LINE__, array('id'=>$map_id));
        $result = $this->Constant_model->setPublish($map_id, $this->tableMapImageName);
        if (!$result) return false;
        $this->Log_model->logAdd('delete image', $this->tableImageName, __LINE__, array('id'=>$id,));
        return $this->Constant_model->setPublish($id, $this->tableImageName);
    }
}