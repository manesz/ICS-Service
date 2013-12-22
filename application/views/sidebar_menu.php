<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
?>

<form action="search-results.html" method="GET" class='search-form'>
    <div class="search-pane">
        <input type="text" name="search" placeholder="Search here...">
        <button type="submit"><i class="icon-search"></i></button>
    </div>
</form>
<!-- #### Dashboard #### -->
<div class="subnav subnav-hidden">
    <div class="subnav-title">
        <a href="<?php echo $webUrl; ?>dashboard" class='toggle-subnav'><i class=""></i><span>Dashboard</span></a>
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
                <li><a href="<?php echo $webUrl; ?>company">List</a> </li>
                <li><a href="<?php echo $webUrl; ?>company?page=add">Add new</a> </li>
                <li><a href="#">Report-1</a> </li>
                <li><a href="#">Report-2</a> </li>
            </ul>
        </li>
    </ul>

    <ul class="subnav-menu">
        <li class='dropdown'>
            <a href="#" data-toggle="dropdown">Device</a>
            <ul class="dropdown-menu">
                <li><a href="<?php echo $webUrl; ?>device">List</a> </li>
                <li><a href="<?php echo $webUrl; ?>device?page=add">Add new</a> </li>
                <li><a href="#">Report-1</a> </li>
                <li><a href="#">Report-2</a> </li>
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
                <li><a href="<?php echo $webUrl; ?>member">List</a> </li>
                <li><a href="<?php echo $webUrl; ?>member?page=add">Add new</a> </li>
            </ul>
        </li>
    </ul>
    <ul class="subnav-menu">
        <li class='dropdown'>
            <a href="#" data-toggle="dropdown">Departments</a>
            <ul class="dropdown-menu">
                <li><a href="#">List</a> </li>
                <li><a href="#">Add new</a> </li>
            </ul>
        </li>
    </ul>
    <ul class="subnav-menu">
        <li class='dropdown'>
            <a href="#" data-toggle="dropdown">Modules</a>
            <ul class="dropdown-menu">
                <li><a href="#">List</a> </li>
                <li><a href="#">Add new</a> </li>
            </ul>
        </li>
    </ul>
    <ul class="subnav-menu">
        <li class=''>
            <a href="#" data-toggle="dropdown">Log</a>
        </li>
    </ul>
</div>

<!-- #### Singout #### -->
<div class="subnav subnav-hidden">
    <div class="subnav-title">
        <a href="<?php echo $webUrl; ?>signout" id="signOut" class='toggle-subnav'><span>SIGNOUT</span></a>
    </div>
</div>