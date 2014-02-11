<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 29/10/2556
 * Time: 13:52 น.
 * To change this template use File | Settings | File Templates.
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Company extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //check สถานะ login
        $this->Authentication_model->checkSignIn();
    }

    private $selectMenu = "company";
    function index()
    {
        $data = array(
            "selectMenu" => $this->selectMenu
        );
        $this->load->view("company/list", $data);
    }

    function companyAdd()
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Company_model->companyAdd($post);
            if ($result){
                echo "add success";
            } else {
                echo 'add fail';
            }
            exit();
        }
        $data = array(
            "selectMenu" => $this->selectMenu
        );
        $this->load->view("company/add", $data);
    }

    function companyEdit($id)
    {
        $post = $this->input->post();
        if ($post) {//var_dump($post);exit;
            $result = $this->Company_model->companyEdit($id, $post);
            if ($result) {
                echo "edit success";
            } else {
                echo "edit fail";
            }
            exit();
        }
        $data = array(
            'id' => $id,
            "selectMenu" => $this->selectMenu
        );
        $this->load->view("company/edit", $data);
    }

    function companyDelete($id)
    {
        $result = $this->Constant_model->setPublish($id, 'company');
        if (!$result)
        {
            echo "delete fail";
            exit;
        }
        echo "Delete Success!";
    }
}