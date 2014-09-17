<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 19/12/2556
 * Time: 10:52 น.
 * To change this template use File | Settings | File Templates.
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Device extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //check สถานะ login
        $this->Authentication_model->checkSignIn();
    }
    private $selectMenu = "device";
    private $moduleName = "Device";

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
        $this->load->view("device/list", $data);
    }

    function deviceAdd()
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Device_model->deviceAdd($post);
            if ($result){
                echo "add success";
            } else {
                echo 'add fail';
            }
            exit();
        }
        $id = $this->Device_model->deviceAdd(array());
        $data = array(
            "selectMenu" => $this->selectMenu,
            "id" => $id,
            'permission' => $this->checkPermission(1)
        );
        $this->load->view("device/add", $data);
    }

    function deviceEdit($id)
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Device_model->deviceEdit($id, $post);
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
        $this->load->view("device/add", $data);
    }

    function deviceView($id)
    {
        $data = array(
            'id' => $id,
            "selectMenu" => $this->selectMenu,
            'view' => true
        );
        $this->load->view("device/add", $data);
    }

    function deviceDelete($id)
    {
        $result = $this->Constant_model->setPublish($id, $this->Constant_model->tbDevice);
        if (!$result)
        {
            echo "delete fail";
            exit;
        }
        echo "Delete Success!";
    }
}