<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 29/10/2556
 * Time: 13:52 น.
 * To change this template use File | Settings | File Templates.
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //check สถานะ login
        $this->Authentication_model->checkSignIn();
    }

    private $selectMenu = "dashboard";
    function index()
    {
        $data = array(
            "selectMenu" => $this->selectMenu
        );
        $this->load->view("dashboard/view", $data);
    }
}