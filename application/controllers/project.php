<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Rux
 * Date: 09/08/2557
 * Time: 12:57 น.
 * To change this template use File | Settings | File Templates.
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Project extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //check สถานะ login
        $this->Authentication_model->checkSignIn();
    }
    private $selectMenu = "project";
    private $moduleName = "Project";

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
        $this->load->view("project/list", $data);
    }

    function projectAdd()
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Project_model->projectAdd($post);
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
        $this->load->view("project/add", $data);
    }

    function projectEdit($id)
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Project_model->projectEdit($id, $post);
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
        $this->load->view("project/add", $data);
    }

    function projectDelete($id)
    {
        $result = $this->Constant_model->setPublish($id, $this->Constant_model->tbProject);
        if (!$result)
        {
            echo "delete fail";
            exit;
        }
        echo "Delete Success!";
    }
}