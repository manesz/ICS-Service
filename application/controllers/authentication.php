<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 29/10/2556
 * Time: 13:52 น.
 * To change this template use File | Settings | File Templates.
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        $post = $this->input->post();
        $message = "";
        $sessionUrl = @$this->session->userdata['ics_session_url'];
        if ($post) {
            $resultLogin = $this->Authentication_model->signIn($post);
            if ($resultLogin) {
                if (empty($sessionUrl)) {
                    $urlRedirect = $this->Constant_model->webUrl() . "dashboard";
                }else {
                    $urlRedirect = $sessionUrl;
                }
                echo "<script type='text/javascript'>window.location='$urlRedirect'</script>";
            } else {
                echo 'username or password is not correct.';
            }
            exit();
        }
        $data = array(
            'message' => $message
        );
        if (empty($this->session->userdata['ics_check'])) {
            $this->load->view("signin", $data);
        } else {
            redirect($this->Constant_model->webUrl() . "dashboard");
        }
    }

    function signOut()
    {
        $resultLogout = $this->Authentication_model->signOut();
        if ($resultLogout) {
            redirect($this->Constant_model->webUrl() . 'signin');
        }
    }
}