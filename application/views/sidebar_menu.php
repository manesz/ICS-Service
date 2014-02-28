<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
?>
<div id="left">
    <form action="search-results.html" method="GET" class='search-form'>
        <div class="search-pane">
            <input type="text" name="search" placeholder="Search here...">
            <button type="submit"><i class="icon-search"></i></button>
        </div>
    </form>
    <!-- #### Dashboard #### -->
    <div class="subnav subnav-hidden">
        <div class="subnav-title">
            <a class="link" href="<?php echo $webUrl; ?>dashboard" class='toggle-subnav'><i class=""></i><span>Dashboard</span></a>
        </div>
    </div>
    <!-- #### iSpot #### -->
    <div class="subnav subnav-hidden">
        <div class="subnav-title">
            <a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>iSpot</span></a>
        </div>

        <ul class="subnav-menu">
            <li class='dropdown'>
                <a href="#" data-toggle="dropdown">Company</a>
                <ul class="dropdown-menu">
                    <li><a class="link" href="<?php echo $webUrl; ?>company">List</a></li>
                    <li><a class="link" href="<?php echo $webUrl; ?>company/companyAdd">Add new</a></li>
                    <li><a class="link" href="#">Report-1</a></li>
                    <li><a class="link" href="#">Report-2</a></li>
                </ul>
            </li>
        </ul>

        <ul class="subnav-menu">
            <li class='dropdown'>
                <a href="#" data-toggle="dropdown">Device</a>
                <ul class="dropdown-menu">
                    <li><a class="link" href="<?php echo $webUrl; ?>device">List</a></li>
                    <li><a class="link" href="<?php echo $webUrl; ?>device/deviceAdd">Add new</a></li>
                    <li><a class="link" href="#">Report-1</a></li>
                    <li><a class="link" href="#">Report-2</a></li>
                </ul>
            </li>
        </ul>

    </div>

    <!-- #### Settings #### -->
    <div class="subnav subnav-hidden">
        <div class="subnav-title">
            <a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Settings</span></a>
        </div>

        <ul class="subnav-menu">
            <li class='dropdown'>
                <a href="#" data-toggle="dropdown">Users</a>
                <ul class="dropdown-menu">
                    <li><a class="link" href="<?php echo $webUrl; ?>member">List</a></li>
                    <li><a class="link" href="<?php echo $webUrl; ?>member/memberAdd">Add new</a></li>
                </ul>
            </li>
        </ul>
        <ul class="subnav-menu">
            <li class='dropdown'>
                <a href="#" data-toggle="dropdown">Departments</a>
                <ul class="dropdown-menu">
                    <li><a class="link" href="<?php echo $webUrl; ?>setting/departmentList">List</a></li>
                    <li><a class="link" href="<?php echo $webUrl; ?>setting/departmentAdd">Add new</a></li>
                </ul>
            </li>
        </ul>
        <ul class="subnav-menu">
            <li class='dropdown'>
                <a href="#" data-toggle="dropdown">Position</a>
                <ul class="dropdown-menu">
                    <li><a class="link" href="<?php echo $webUrl; ?>setting/positionList">List</a></li>
                    <li><a class="link" href="<?php echo $webUrl; ?>setting/positionAdd">Add new</a></li>
                </ul>
            </li>
        </ul>
        <ul class="subnav-menu">
            <li class='dropdown'>
                <a href="#" data-toggle="dropdown">Modules</a>
                <ul class="dropdown-menu">
                    <li><a class="link" href="<?php echo $webUrl; ?>setting">List</a></li>
                    <li><a class="link" href="<?php echo $webUrl; ?>setting/moduleAdd">Add new</a></li>
                </ul>
            </li>
        </ul>
        <ul class="subnav-menu">
            <li class=''>
                <a class="link" href="#" data-toggle="dropdown">Log</a>
            </li>
        </ul>
    </div>

    <!-- #### Singout #### -->
    <div class="subnav subnav-hidden">
        <div class="subnav-title">
            <a class="link" href="<?php echo $webUrl; ?>signout" id="signOut" class='toggle-subnav'><span>SIGNOUT</span></a>
        </div>
    </div>
</div>