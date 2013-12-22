<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
?>
<div id="navigation">
    <div class="container-fluid">
        <a href="#" id="brand">ICS-Services</a>
        <a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i
                class="icon-reorder"></i></a>

        <ul class='main-nav'>
            <!-- #### Dashbaord #### -->
            <li class="<?php echo $selectMenu == "dashboard" ? "active" : ""; ?>">
                <a href="<?php echo $webUrl; ?>dashboard"><span>Dashboard</span></a>
            </li>
            <!-- #### Company #### -->
            <li class="<?php echo $selectMenu == "company" ? "active" : ""; ?>">
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Company</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo $webUrl; ?>company">Company List</a></li>
                    <li><a href="<?php echo $webUrl; ?>company?page=add">Company Add</a></li>
                    <li><a href="#">Report 1</a></li>
                    <li><a href="#">Report 2</a></li>
                    <li><a href="#">Report 3</a></li>
                </ul>
            </li>
            <!-- #### Device #### -->
            <li class="<?php echo $selectMenu == "device" ? "active" : ""; ?>">
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Device</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo $webUrl; ?>device">Device List</a></li>
                    <li><a href="<?php echo $webUrl; ?>device?page=add">Device Add</a></li>
                    <li><a href="#">Report 1</a></li>
                    <li><a href="#">Report 2</a></li>
                    <li><a href="#">Report 3</a></li>
                </ul>
            </li>
            <!-- #### Settings #### -->
            <li class="<?php echo $selectMenu == "settings" ? "active" : ""; ?>">
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Settings</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo $webUrl; ?>member">Users</a></li>
                    <li><a href="#">Logs</a></li>
                    <!--            <li><a href="#">Calendars</a></li>-->
                    <!--            <li><a href="#">Tasks</a></li>-->
                    <!--            <li><a href="#">News</a></li>-->
                </ul>
            </li>
        </ul>

        <div class="user">
            <div class="dropdown">
                <a href="#" class='dropdown-toggle' data-toggle="dropdown">
                    <?php echo @$this->session->userdata['firstname']; ?>
                    <img src="<?php echo $baseUrl . @$this->session->userdata['image_path']; ?>" alt="">
                </a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="#">Edit profile</a>
                    </li>
                    <li>
                        <a href="#">Account settings</a>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl; ?>signout">Sign out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>