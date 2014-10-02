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
        $this->sessionUrl = $this->Constant_model->sessionUrl;
    }

    private $sessionUrl = "";
    function index()
    {
        $post = $this->input->post();
        $message = "";
        $sessionUrl = @$this->session->userdata[$this->sessionUrl];
        if ($post) {
            $resultLogin = $this->Authentication_model->signIn($post);
            if ($resultLogin) {
                if (empty($sessionUrl)) {
                    $urlRedirect = $this->Constant_model->webUrl();
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

    function sessionLock()
    {
        $post = $this->input->post();
        $sessionUrl = @$this->session->userdata['cms_session_url'];
        $message = "";
        if ($post) {
            extract($post);
            $resultLogin = $this->Authentication_model->signIn($post);
            if ($resultLogin) {
                if (empty($sessionUrl)) {
                    redirect($this->Constant_model->webUrl());
                } else {
                    redirect($sessionUrl);
                }
            } else {
                $message = 'login fail';
            }
            exit;
        } else {
            $this->Authentication_model->setSessionLock();//set session lock
        }
        $data = array(
            'message' => $message
        );
        $this->load->view("lock_screen", $data);
    }
}