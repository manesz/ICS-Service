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

//------------------------------------------Module----------------------------------------------//
    function index()
    {
        $data = array(
            'selectMenu' => $this->selectMenu,
            'selectSubMenu' => "modules"
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
            'selectSubMenu' => "modules"
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
            'selectSubMenu' => "modules"
        );
        $this->load->view('module/edit', $data);
    }

    function moduleDelete($id)
    {
        $result = $this->Constant_model->setPublish($id, 'module');
        if (!$result)
        {
            echo "delete fail";
            exit;
        }
        echo "Delete Success!";
    }

//------------------------------------------Department----------------------------------------------//
    function departmentList()
    {
        $data = array(
            'selectMenu' => $this->selectMenu,
            'selectSubMenu' => "departments"
        );
        $this->load->view("department/list", $data);
    }

    function departmentAdd()
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Department_model->departmentAdd($post);
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
            'selectSubMenu' => "departments"
        );
        $this->load->view('department/add', $data);
    }

    function departmentEdit($id)
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Department_model->departmentEdit($id, $post);
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
            'selectSubMenu' => "departments"
        );
        $this->load->view('department/edit', $data);
    }

    function departmentDelete($id)
    {
        $result = $this->Constant_model->setPublish($id, 'department');
        if (!$result)
        {
            echo "delete fail";
            exit;
        }
        echo "Delete Success!";
    }
}