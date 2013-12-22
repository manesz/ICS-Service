<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 18/12/2556
 * Time: 20:30 น.
 * To change this template use File | Settings | File Templates.
 */
$webUrl = "";
$baseUrl = base_url();
$this->load->view("header");
$this->load->view("navigator_menu");
?>

    <div class="container-fluid" id="content">

        <div id="left">

            <?php
            $this->load->view("sidebar_menu");
            ?>
            <!-- ##################################################################################### -->
            <div id="resultSignOut"></div>
        </div>
        <!-- END:left -->
        <div id="main">
            <?php
            if (@$_GET['page'] == "add") {
                $this->load->view("member/add");
            } else if (@$_GET['page'] == "edit") {
                $this->load->view("member/edit");
            } else {
                $this->load->view("member/list");
            }
            ?>
        </div>
        <!-- END:main -->
    </div>
<?php
$this->load->view("footer");
?>