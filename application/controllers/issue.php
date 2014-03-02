<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 01/03/2557
 * Time: 16:00 น.
 * To change this template use File | Settings | File Templates.
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Issue extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //check สถานะ login
        $this->Authentication_model->checkSignIn();
    }
    private $selectMenu = "Issue";
    private $moduleName = "Issue";

    function checkPermission($index)
    {
        return $this->Module_model->checkModuleByPermission($this->moduleName, $index);
    }

    function index()
    {
        $data = array(
            "selectMenu" => $this->selectMenu,
            'permission' => $this->checkPermission(0),
            'permissionInsert' => $this->checkPermission(1),
            'permissionUpdate' => $this->checkPermission(2),
            'permissionDelete' => $this->checkPermission(3)
        );
        $this->load->view("issue/list", $data);
    }

    function issueAdd()
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Issue_model->issueAdd($post);
            if ($result){
                echo "add success";
            } else {
                echo 'add fail';
            }
            exit();
        }
        $data = array(
            "selectMenu" => $this->selectMenu,
            'permission' => $this->checkPermission(1)
        );
        $this->load->view("issue/add", $data);
    }

    function issueEdit($id)
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Issue_model->issueEdit($id, $post);
            if ($result) {
                echo "edit success";
            } else {
                echo "edit fail";
            }
            exit();
        }
        $data = array(
            'id' => $id,
            "selectMenu" => $this->selectMenu,
            'permission' => $this->checkPermission(2)
        );
        $this->load->view("issue/edit", $data);
    }

    function issueDelete($id)
    {
        $result = $this->Constant_model->setPublish($id, "ics_issue");
        if (!$result)
        {
            echo "delete fail";
            exit;
        }
        echo "Delete Success!";
    }
}