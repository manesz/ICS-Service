<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //check สถานะ login
        $this->Authentication_model->checkSignIn();
    }
    private $selectMenu = "settings";

//------------------------------------------Check Permission----------------------------------------------//

    function checkPermission($module, $index)
    {
        return $this->Module_model->checkModuleByPermission($module, $index);
    }

//------------------------------------------Module----------------------------------------------//
    function index()
    {
        $data = array(
            'selectMenu' => $this->selectMenu,
            'selectSubMenu' => "modules",
            'permission' => $this->checkPermission("Modules", 0),
            'permissionInsert' => $this->checkPermission("Modules", 1),
            'permissionUpdate' => $this->checkPermission("Modules", 2),
            'permissionDelete' => $this->checkPermission("Modules", 3)
        );
        $this->load->view("module/list", $data);
    }

    function moduleAdd()
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Module_model->moduleAdd($post);
            if ($result){
                echo "add success";
            } else {
                echo 'add fail';
            }
            exit();
        }
        $data = array(
            'message' => "",
            'selectMenu' => $this->selectMenu,
            'selectSubMenu' => "modules",
            'permission' => $this->checkPermission("Modules", 1)
        );
        $this->load->view('module/add', $data);
    }

    function moduleEdit($id)
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Module_model->moduleEdit($id, $post);
            if ($result) {
                echo "edit success";
            } else {
                echo "edit fail";
            }
            exit();
        }
        $data = array(
            'message' => "",
            'id' => $id,
            'selectMenu' => $this->selectMenu,
            'selectSubMenu' => "modules",
            'permission' => $this->checkPermission("Modules", 2)
        );
        $this->load->view('module/edit', $data);
    }

    function moduleDelete($id)
    {
        $result = $this->Constant_model->setPublish($id, 'ics_module');
        if (!$result)
        {
            echo "delete fail";
            exit;
        }
        echo "Delete Success!";
    }

//------------------------------------------Position----------------------------------------------//
    function positionList()
    {
        $data = array(
            'selectMenu' => $this->selectMenu,
            'selectSubMenu' => "position",
            'permission' => $this->checkPermission("Position", 0),
            'permissionInsert' => $this->checkPermission("Position", 1),
            'permissionUpdate' => $this->checkPermission("Position", 2),
            'permissionDelete' => $this->checkPermission("Position", 3)
        );
        $this->load->view("position/list", $data);
    }

    function positionAdd()
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Position_model->positionAdd($post);
            if ($result){
                echo "add success";
            } else {
                echo 'add fail';
            }
            exit();
        }
        $data = array(
            'message' => "",
            'selectMenu' => $this->selectMenu,
            'selectSubMenu' => "position",
            'permission' => $this->checkPermission("Position", 1)
        );
        $this->load->view('position/add', $data);
    }

    function positionEdit($id)
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Position_model->positionEdit($id, $post);
            if ($result) {
                echo "edit success";
            } else {
                echo "edit fail";
            }
            exit();
        }
        $data = array(
            'message' => "",
            'id' => $id,
            'selectMenu' => $this->selectMenu,
            'selectSubMenu' => "position",
            'permission' => $this->checkPermission("Position", 2)
        );
        $this->load->view('position/edit', $data);
    }

    function positionDelete($id)
    {
        $result = $this->Constant_model->setPublish($id, 'ics_position');
        if (!$result)
        {
            echo "delete fail";
            exit;
        }
        echo "Delete Success!";
    }
}