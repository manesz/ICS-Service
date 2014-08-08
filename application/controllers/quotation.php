<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 8/8/2557
 * Time: 8:34 น.
 */


if (!defined('BASEPATH')) exit('No direct script access allowed');

class Quotation extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //check สถานะ login
        $this->Authentication_model->checkSignIn();
    }
    private $selectMenu = "quotation";
    private $moduleName = "Quotation";

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
        $this->load->view("quotation/list", $data);
    }

    function quotationAdd()
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Quotation_model->quotationAdd($post);
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
        $this->load->view("quotation/add", $data);
    }

    function quotationEdit($id)
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Quotation_model->quotationEdit($id, $post);
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
        $this->load->view("quotation/add", $data);
    }

    function quotationDelete($id)
    {
        $result = $this->Constant_model->setPublish($id, $this->Constant_model->tbQuotation);
        if (!$result)
        {
            echo "delete fail";
            exit;
        }
        echo "Delete Success!";
    }
}