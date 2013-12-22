<?php
session_start();
require_once("header.php");
require_once("navigator_menu.php");
?>

<div class="container-fluid" id="content">

    <div id="left">

        <?php require_once("sidebar_menu.php");?>
        <!-- ##################################################################################### -->
        <div id="resultSignOut"></div>
    </div><!-- END:left -->
    <div id="main">
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>COMPANY</h1>
                </div>
            </div><!-- END: .page-header -->
        </div><!-- END:.container-fluid -->

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="breadcrumbs">
                        <ul>
                            <li>
                                <a href="more-login.html">Home</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="index.html">Company</a>
                            </li>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div><!-- END: ,breadcrumbs -->
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div class="box box-color box-bordered">
                        <div class="box-content nopadding">
                            <?php
                                if($_GET['page'] == "list"){
                                    include "views/company/list.php";
                                } else if($_GET['page'] == "add") {
                                    include "views/company/add.php";
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- END:main -->



</div>

<?php require_once("footer.php");?>