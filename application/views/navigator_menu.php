<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$id = @$this->session->userdata['id'];
$arrMember = $this->Member_model->memberList($id);
extract((array)$arrMember[0]);
?>
<div id="navigation">
    <div class="container-fluid">
        <a href="#" id="brand">ICS-Services</a>
        <a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i
                class="icon-reorder"></i></a>

        <ul class='main-nav'>
            <!-- #### Dashbaord #### -->
            <li class="<?php echo $selectMenu == "dashboard" ? "active" : ""; ?>">
                <a class="link" href="<?php echo $webUrl; ?>dashboard"><span>Dashboard</span></a>
            </li>
            <!-- #### Company #### -->
            <li class="<?php echo $selectMenu == "company" ? "active" : ""; ?>">
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Company</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="link" href="<?php echo $webUrl; ?>company">Company List</a></li>
                    <li><a class="link" href="<?php echo $webUrl; ?>company/companyAdd">Company Add</a></li>
                    <li><a class="link" href="#">Report 1</a></li>
                    <li><a class="link" href="#">Report 2</a></li>
                    <li><a class="link" href="#">Report 3</a></li>
                </ul>
            </li>
            <!-- #### Device #### -->
            <li class="<?php echo $selectMenu == "device" ? "active" : ""; ?>">
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Device</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="link" href="<?php echo $webUrl; ?>device">Device List</a></li>
                    <li><a class="link" href="<?php echo $webUrl; ?>device/deviceAdd">Device Add</a></li>
                    <li><a class="link" href="#">Report 1</a></li>
                    <li><a class="link" href="#">Report 2</a></li>
                    <li><a class="link" href="#">Report 3</a></li>
                </ul>
            </li>
            <!-- #### Settings #### -->
            <li class="<?php echo $selectMenu == "settings" ? "active" : ""; ?>">
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Settings</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="link" href="<?php echo $webUrl; ?>member">Users</a></li>
                    <li><a class="link" href="#">Logs</a></li>
                    <!--            <li><a href="#">Calendars</a></li>-->
                    <!--            <li><a href="#">Tasks</a></li>-->
                    <!--            <li><a href="#">News</a></li>-->
                </ul>
            </li>
        </ul>

        <div class="user">
            <div class="dropdown">
                <a href="#" class='dropdown-toggle' data-toggle="dropdown" style="height: 24px; min-width: 140px;">
                    <span style="float: left; margin-right: 5px;">Welcome : <?php echo @$firs_tname; ?></span>

                    <div style="width: 24px; height: 24px;margin: 0 auto; overflow:hidden; position: relative; float: right;">
                        <img src="<?php
                        if (file_exists($baseUrl . @$image)) {
                            echo $baseUrl . $image;
                        } else {
                            echo $baseUrl . "assets/img/no_avatar.jpg";
                        }
                        ?>" alt="">
                    </div>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a class="link" href="<?php echo $webUrl; ?>member/memberEdit/<?php echo $id; ?>">Edit profile</a>
                    </li>
                    <li>
                        <a class="link" href="<?php echo $webUrl; ?>signout">Sign out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>