<?php
    require_once('class/authen_class.php');

    $clsAuthen = new Authen();

    $page = @$_POST['page'];

    switch($page){
        case "signin":

            switch($action){
                case "signIn":
                    $username = @$_POST['username'];
                    $password = @$_POST['password'];
                    $resultChkAuthen = $clsAuthen->chkSignIn($username, $password);
                    if(!empty($resultChkAuthen)){
                        echo $resultChkAuthen;
                    }
                    break;
                case "signOut":
                    session_unset($_SESSION);
                    if(empty($_SESSION)){
                        echo "<script type='text/javascript'>window.location='signin.php'</script>";
                    }
                    break;
            }


            break;
    }
?>