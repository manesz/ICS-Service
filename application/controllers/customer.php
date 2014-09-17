<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 29/10/2556
 * Time: 13:52 น.
 * To change this template use File | Settings | File Templates.
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //check สถานะ login
        $this->Authentication_model->checkSignIn();
    }

    private $selectMenu = "customer";
    private $moduleName = "Customer";

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
        $this->load->view("customer/list", $data);
    }

    function customerAdd()
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Customer_model->customerAdd($post);
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
        $this->load->view("customer/add", $data);
    }

    function customerEdit($id)
    {
        $post = $this->input->post();
        if ($post) {//var_dump($post);exit;
            $result = $this->Customer_model->customerEdit($id, $post);
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
        $this->load->view("customer/edit", $data);
    }

    function customerView($id)
    {
        $data = array(
            'id' => $id,
            "selectMenu" => $this->selectMenu
        );
        $this->load->view("customer/view", $data);
    }

    function customerDelete($id)
    {
        $result = $this->Constant_model->setPublish($id, $this->Constant_model->tbCustomer);
        if (!$result)
        {
            echo "delete fail";
            exit;
        }
        echo "Delete Success!";
    }
}