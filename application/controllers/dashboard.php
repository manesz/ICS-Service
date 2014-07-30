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
    private $moduleName = "Dashboard";

    function checkPermission($index)
    {
        return $this->Module_model->checkModuleByPermission($this->moduleName, $index);
    }

    function index()
    {
        $post = $this->input->post();
        if ($post) {
            $result = $this->Log_model->feedList(@$post['max_feed']);
            if ($result) {
                $webUrl = $this->Constant_model->webUrl();
                foreach ($result as $key => $value) {
                    $strClass = "";
                    $strTextShow = "$value->title";
                    $strTextShow .= " &nbsp;<i style='color: brown;'>$value->create_datetime</i>";
                    $arrayDesc = (array)json_decode($value->description);
                    if (strstr($value->title, 'add')) {
                        $strClass = "icon-plus";
                        if (!strstr($value->title, 'image'))
                            $strTextShow .= " &nbsp;<a href='$webUrl" .
                                str_replace('add ', '', $value->title) . "/edit/" . @$arrayDesc['id'] .
                                    "'>#Link</a>";
                    } else if (strstr($value->title, 'edit')) {
                        $strClass = "icon-edit";
                        if (!strstr($value->title, 'image'))
                            $strTextShow .= " &nbsp;<a href='$webUrl" .
                                str_replace('edit ', '', $value->title) . "/edit/" . @$arrayDesc['id'] .
                                    "'>#Link</a>";
                    } else if (strstr($value->title, 'delete')) {
                        $strClass = "icon-edit";
                    } else if (strstr($value->title, 'Sign in')) {
                        $strClass = "icon-signin";
                    } else if (strstr($value->title, 'Sign out')) {
                        $strClass = "icon-signout";
                    }
                    $strLink = $webUrl . "member/edit/" . $value->member_id;
                    ?>
                    <span class="label"><i class="<?php echo $strClass; ?>"></i></span>
                    <a href="<?php echo $strLink; ?>"><?php echo $value->name; ?></a>
                    <?php echo $strTextShow;
                }
            } else {
                echo 'null';
            }
            exit();
        } else {
            $objFeed = $this->Log_model->feedList();
            $max_feed = $objFeed ? $objFeed[0]->id : 0;
        }
        $data = array(
            "max_feed" => $max_feed,
            "objFeed" => $objFeed,
            "selectMenu" => $this->selectMenu,
            'permission' => $this->checkPermission(0),
            'permissionInsert' => $this->checkPermission(1),
            'permissionUpdate' => $this->checkPermission(2),
            'permissionDelete' => $this->checkPermission(3)
        );
        $this->load->view("dashboard/view", $data);
    }
}