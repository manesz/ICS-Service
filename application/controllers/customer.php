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
            if ($result) {
                echo "add success";
            } else {
                echo 'add fail';
            }
            exit();
        }
        $id = $this->Customer_model->customerAdd(array(), 0);
        $data = array(
            'id' => $id,
            "selectMenu" => $this->selectMenu,
            'permission' => $this->checkPermission(1),
            'page' => "Add",
        );
        $this->load->view("customer/add", $data);
    }

    function customerEdit($id)
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Customer_model->customerEdit($id, $post);
            if ($result) {
                extract($post);
                if (@$contact_name_th || @$contact_name_en)
                    if (@$contact_id) {
                        $result = $this->Contact_model->contactEdit($contact_id, $post);
                        if ($result) {
                            echo "edit success";
                        }
                    } else {
                        $result = $this->Contact_model->contactAdd($post);
                        if ($result) {
                            echo "edit success";
                        }
                    }
            } else {
                echo "edit fail";
            }
            exit();
        }
        $data = array(
            'id' => $id,
            "selectMenu" => $this->selectMenu,
            'permission' => $this->checkPermission(2),
            'page' => "Edit",
        );
        $this->load->view("customer/add", $data);
    }

    function customerView($id)
    {
        $data = array(
            'id' => $id,
            "selectMenu" => $this->selectMenu,
            'page' => "View",
        );
        $this->load->view("customer/add", $data);
    }

    function customerDelete($id)
    {
        $result = $this->Constant_model->setPublish($id, $this->Constant_model->tbCustomer);
        if (!$result) {
            echo "delete fail";
            exit;
        }
        echo "Delete Success!";
    }
}