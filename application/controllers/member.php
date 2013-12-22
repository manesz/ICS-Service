<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 29/10/2556
 * Time: 13:52 น.
 * To change this template use File | Settings | File Templates.
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //check สถานะ login
        $this->Authentication_model->checkSignIn();
    }

    private $selectMenu = "settings";
    function index()
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Member_model->memberAdd($post);
            if ($result){
                echo $result;
            } else {
                echo 'add fail';
            }
            exit();
        }
        $data = array(
            'selectMenu' => $this->selectMenu,
            'selectSubMenu' => "users"
        );
        $this->load->view("member/view", $data);
    }

    function memberList()
    {
        $this->load->view("member/list");
    }

    function memberAdd()
    {
        $data = array(
            'message' => "",
            'selectMenu' => $this->selectMenu,
            'selectSubMenu' => "users"
        );
        $this->load->view('member/add', $data);
    }

    function memberEdit($id)
    {
        $post = $this->input->post();
        if ($post) {//var_dump($post);exit;
            $result = $this->Member_model->memberEdit($id, $post);
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
            'selectSubMenu' => "users"
        );
        $this->load->view('member/edit', $data);
    }

    function memberDelete($id)
    {
        $result = $this->Constant_model->setPublish($id, 'member');
        if (!$result)
        {
            echo "delete fail";
            exit;
        }
        echo "Delete Success!";
    }

    function memberSetModule($id)
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Module_model->moduleSet($id, $post);
            if ($result) {
                echo "edit success";
            } else {
                echo "edit fail";
            }
        }
        exit();
    }
}