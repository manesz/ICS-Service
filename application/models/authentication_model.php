<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 4/11/2556
 * Time: 13:25 น.
 * To change this template use File | Settings | File Templates.
 */
class Authentication_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->tableNameMember = $this->Constant_model->tbMember;
        $this->sessionUrl = $this->Constant_model->sessionUrl;
        $this->sessionLock = $this->Constant_model->sessionLock;
    }

    private $tableNameMember = "";
    private $sessionUrl = "";
    private $sessionLock = "";
    private $strCheck = "ics_check";

    function signIn($post)
    {
        extract($post);
        $password = md5($password);
        $sql = "
            SELECT
              *
            FROM `$this->tableNameMember`
            WHERE 1
            AND (
              `username` = '$username'
              OR
              `email` = '$username'
            )
            AND `password` = '$password'
            AND publish = 1
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            $result = (array)$result[0];
            $sessionUrl = @$this->session->userdata[$this->sessionUrl];
            //$this->Log_model->deleteLog();

            $result[$this->sessionUrl] = $sessionUrl;
            $result[$this->sessionLock] = false;
            $result[$this->strCheck] = 'true';
            $this->session->set_userdata($result);

            $this->Log_model->logAdd('Sign in',
                $this->tableNameMember, __LINE__, array('id' => $result['id'], 'username' => $result['username']));
            $id = $result['id'];
            $this->setSessionLogin($id);
//            session_start();
//            $_SESSION['userdata'] = $this->session->userdata;
//            $_SESSION['webUrl'] = $this->Constant_model->webUrl();
            return true;
        } else {
            return false;
        }
    }

    function signOut()
    {
        $this->Log_model->logAdd('Sign out',
            $this->tableNameMember, __LINE__, null);
        $this->session->sess_destroy();
        session_start();
//        unset($_SESSION["userdata"]);
//        $_SESSION['webUrl'] = $this->Constant_model->webUrl();
        return true;
    }

    function checkSignIn()
    {
        $strOldSession = @$this->session->userdata['session_login'];
        $id = @$this->session->userdata['id'];
        if (empty($this->session->userdata[$this->strCheck]) && !$_GET) {
            $webUrl = $this->Constant_model->webUrl();
            if (!$_POST) {
                $setSession = array(
                    $this->sessionUrl => $webUrl . uri_string()
                );
                $this->session->set_userdata($setSession);
            }
            redirect($webUrl . "signin");
        } else if ($strOldSession && $strOldSession != $this->checkSessionLogin($id)) {
//            $webUrl = $this->Constant_model->webUrl();
//            $setSession = array(
//                $this->sessionUrl => $webUrl . uri_string()
//            );
//            $this->session->set_userdata($setSession);
//            redirect($webUrl . "signin");
        }
        return true;
    }

    function checkSessionLogin($id)
    {
        $sql = "
            SELECT
              session_login
            FROM $this->tableNameMember
            WHERE 1
            AND publish = 1
            AND id = $id
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result[0]->session_login;
        } else {
            return false;
        }
    }

    function setSessionLogin($id)
    {
        $strSession = strtotime(date("YmdHis"));
        $data = array(
            'session_login' => $strSession
        );
        return $this->db->update($this->tableNameMember, $data, array('id' => $id));
    }


    function setSessionLock($set = true)
    {
//        $uri = $this->Constant_model->webUrl();
        $setSession = array(
            $this->sessionLock => $set
        );
        $this->session->set_userdata($setSession);
        return true;
    }
}