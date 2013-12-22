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
    }

    function signIn($post)
    {
        extract($post);
        $password = md5($password);
        $sql = "
            SELECT
              *
            FROM `member`
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
            $sessionUrl = @$this->session->userdata['ics_session_url'];
            $result['ics_session_url'] = $sessionUrl;
            $result['ics_check'] = 'true';
            $this->session->set_userdata($result);
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
        $this->session->sess_destroy();
        session_start();
//        unset($_SESSION["userdata"]);
//        $_SESSION['webUrl'] = $this->Constant_model->webUrl();
        return true;
    }

    function checkSignIn()
    {
        if (empty($this->session->userdata['ics_check'])) {
            $webUrl = $this->Constant_model->webUrl();
            $setSession = array(
                'ics_session_url' => $webUrl . uri_string()
            );
            $this->session->set_userdata($setSession);
            redirect($this->Constant_model->webUrl() . "signin");
        } else {
            return true;
        }
    }
}