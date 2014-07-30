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
        $this->sessionName = $this->Constant_model->sessionName;
    }

    private $tableNameMember = "";
    private $sessionName = "";
    private $strCheck = "ics_check";
    function signIn($post)
    {
        extract($post);
        $password = md5($password);
        $sql = "
            SELECT
              *
            FROM `ics_member`
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
            $sessionUrl = @$this->session->userdata[$this->sessionName];
            //$this->Log_model->deleteLog();

            $result[$this->sessionName] = $sessionUrl;
            $result[$this->strCheck] = 'true';
            $this->session->set_userdata($result);

            $this->Log_model->logAdd('Sign in',
                $this->tableNameMember, __LINE__, array('id'=> $result['id'], 'username' => $result['username']));
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
        if (empty($this->session->userdata[$this->strCheck]) && !$_GET) {
            $webUrl = $this->Constant_model->webUrl();
            $setSession = array(
                $this->sessionName => $webUrl . uri_string()
            );
            $this->session->set_userdata($setSession);
            redirect($this->Constant_model->webUrl() . "signin");
        } else {
            return true;
        }
    }
}