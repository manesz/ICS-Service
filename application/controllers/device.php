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
    function index()
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
        $data = array(
            "selectMenu" => $this->selectMenu
        );
        $this->load->view("device/view", $data);
    }

    function deviceList()
    {
        $this->load->view("device/list");
    }

    function deviceAdd()
    {
        $this->load->view("device/add");
    }

    function deviceEdit($id)
    {
        $post = $this->input->post();
        if ($post) {//var_dump($post);exit;
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
            "selectMenu" => $this->selectMenu
        );
        $this->load->view("device/edit", $data);
    }

    function deviceDelete($id)
    {
        $result = $this->Constant_model->setPublish($id, 'device');
        if (!$result)
        {
            echo "delete fail";
            exit;
        }
        echo "Delete Success!";
    }
}