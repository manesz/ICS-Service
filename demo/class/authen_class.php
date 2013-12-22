<?php
    session_start();
    require_once("connect_class.php");

    $clsConnect = new Database();
    $clsConnect->connectDatabase();

    class Authen {

        public function chkSignIn($username=NULL, $password=NULL){
            $strSqlChkSignIn = "
                SELECT
                  `id`,
                  `first_name`,
                  `last_name`,
                  `telephone`,
                  `mobile`,
                  `email`,
                  `username`,
                  `password`,
                  `permission`,
                  `create_datetime`,
                  `publish`
                FROM `ics_service`.`member`
                WHERE 1
                AND (`username` = '$username' OR `email` = '$username')
                AND `password` = '$password'
                AND `publish` = 1;
            ";
            $objQueryChkSignIn = mysql_query($strSqlChkSignIn) or die (mysql_error());
            $objResultChkSignIn = mysql_fetch_array($objQueryChkSignIn);
            if(!empty($objResultChkSignIn["id"])){
                //var_dump($objResultChkSignIn);//DEBUG
                $this->insertSessionMember($objResultChkSignIn);
            } else {
                $result = "username or password is not correct.";
            }

            return $result;
        }

        public function insertSessionMember($array){
            //echo $array["first_name"];//DEBUG
            $_SESSION["memId"] = $array["id"];
            $_SESSION["memFName"] = $array["first_name"];
            $_SESSION["memLName"] = $array["last_name"];
            $_SESSION["memUserName"] = $array["username"];
            $_SESSION["memPermission"] = $array["permission"];
            echo "<script type='text/javascript'>window.location='dashboard.php'</script>";
            //echo $_SESSION["memFName"];//DEBUG
            //echo "<script>alert('session on.');</script>";//DEBUG
        }

    }
?>