<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$id = @$this->session->userdata['id'];
$arrMember = $this->Member_model->memberList($id);
extract((array)$arrMember[0]);
$objCheckModule = $this->Module_model->checkModuleByName();
$checkShowISPOTMenu = false;
$checkShowSettingMenu = false;
$checkShowIssueMenu = false;
foreach ($objCheckModule as $key => $value) {
    $expResult = explode(',', $value->permission);
    switch ($value->title) {
        case "Customer":
            if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]) {
                $checkShowISPOTMenu = true;
            }
            break;
        case "Device":
            if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]) {
                $checkShowISPOTMenu = true;
            }
            break;
        case "Users":
            if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]) {
                $checkShowSettingMenu = true;
            }
            break;
        case "Departments":
            if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]) {
                $checkShowSettingMenu = true;
            }
            break;
        case "Position":
            if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]) {
                $checkShowSettingMenu = true;
            }
            break;
        case "Modules":
            if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]) {
                $checkShowSettingMenu = true;
            }
            break;
        case "Log":
            if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]) {
                $checkShowSettingMenu = true;
            }
            break;
        case "Issue":
            if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]) {
                $checkShowIssueMenu = true;
            }
            break;
    }
}
?>
<div id="navigation">
<div class="container-fluid">
<a href="<?php echo $webUrl; ?>" id="brand">ICS-Services</a>
<a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i
        class="icon-reorder"></i></a>

<ul class='main-nav'>
<?php
foreach ($objCheckModule as $key => $value) :
    $expResult = explode(',', $value->permission);
    switch ($value->title) {
        case "Dashboard":
            ?>
            <?php if (@$expResult[0]): ?>
            <!-- #### Dashbaord #### -->
            <li class="<?php echo $selectMenu == "dashboard" ? "active" : ""; ?>">
                <a href="<?php echo $webUrl; ?>dashboard"><span>Dashboard</span></a>
            </li>
        <?php endif; ?>
            <?php break; ?>

        <?php
        case   "Customer":
            ?><?php if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]):?>
            <!-- #### Customer #### -->
            <li class="<?php echo $selectMenu == "customer" ? "active" : ""; ?>">
                <a href="<?php echo $webUrl; ?>customer" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Customer</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <?php if (@$expResult[1]): ?>
                        <li><a href="<?php echo $webUrl; ?>customer/add">Add new</a></li>
                    <?php endif; ?>
                    <?php if (@$expResult[4]): ?>
                        <li><a href="#">Report-1</a></li>
                    <?php endif; ?>
                    <?php if (@$expResult[5]): ?>
                        <li><a href="#">Report-2</a></li>
                    <?php endif; ?>
                    <?php if (@$expResult[6]): ?>
                        <li><a href="#">Report-3</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
            <?php break; ?>
        <?php
        case   "Device":
            ?><?php if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]):?>
            <!-- #### Device #### -->
            <li class="<?php echo $selectMenu == "device" ? "active" : ""; ?>">
                <a href="<?php echo $webUrl; ?>device" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Device</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <?php if (@$expResult[1]): ?>
                        <li><a href="<?php echo $webUrl; ?>device/add">Add new</a></li>
                    <?php endif; ?>
                    <?php if (@$expResult[4]): ?>
                        <li><a href="#">Report-1</a></li>
                    <?php endif; ?>
                    <?php if (@$expResult[5]): ?>
                        <li><a href="#">Report-2</a></li>
                    <?php endif; ?>
                    <?php if (@$expResult[6]): ?>
                        <li><a href="#">Report-3</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endif; ?>
            <?php break; ?>
        <?php
        case   "Quotation":
            ?><?php if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]):?>
            <!-- #### Device #### -->
            <li class="<?php echo $selectMenu == "quotation" ? "active" : ""; ?>">
                <a href="<?php echo $webUrl; ?>quotation" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Quotation</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <?php if (@$expResult[1]): ?>
                        <li><a href="<?php echo $webUrl; ?>quotation/add">Add new</a></li>
                    <?php endif; ?>
<!--                    --><?php //if (@$expResult[4]): ?>
<!--                        <li><a href="#">Report-1</a></li>-->
<!--                    --><?php //endif; ?>
<!--                    --><?php //if (@$expResult[5]): ?>
<!--                        <li><a href="#">Report-2</a></li>-->
<!--                    --><?php //endif; ?>
<!--                    --><?php //if (@$expResult[6]): ?>
<!--                        <li><a href="#">Report-3</a></li>-->
<!--                    --><?php //endif; ?>
                </ul>
            </li>
        <?php endif; ?>
            <?php break; ?>
        <?php
        case   "Contact":
            ?><?php if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]):?>
            <!-- #### Device #### -->
            <li class="<?php echo $selectMenu == "contact" ? "active" : ""; ?>">
                <a href="<?php echo $webUrl; ?>contact" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Contact</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <?php if (@$expResult[1]): ?>
                        <li><a href="<?php echo $webUrl; ?>contact/add">Add new</a></li>
                    <?php endif; ?>
<!--                    --><?php //if (@$expResult[4]): ?>
<!--                        <li><a href="#">Report-1</a></li>-->
<!--                    --><?php //endif; ?>
<!--                    --><?php //if (@$expResult[5]): ?>
<!--                        <li><a href="#">Report-2</a></li>-->
<!--                    --><?php //endif; ?>
<!--                    --><?php //if (@$expResult[6]): ?>
<!--                        <li><a href="#">Report-3</a></li>-->
<!--                    --><?php //endif; ?>
                </ul>
            </li>
        <?php endif; ?>
            <?php break; ?>
        <?php
        case   "Project":
            ?><?php if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]):?>
            <!-- #### Device #### -->
            <li class="<?php echo $selectMenu == "project" ? "active" : ""; ?>">
                <a href="<?php echo $webUrl; ?>project" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Project</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <?php if (@$expResult[1]): ?>
                        <li><a href="<?php echo $webUrl; ?>project/add">Add new</a></li>
                    <?php endif; ?>
<!--                    --><?php //if (@$expResult[4]): ?>
<!--                        <li><a href="#">Report-1</a></li>-->
<!--                    --><?php //endif; ?>
<!--                    --><?php //if (@$expResult[5]): ?>
<!--                        <li><a href="#">Report-2</a></li>-->
<!--                    --><?php //endif; ?>
<!--                    --><?php //if (@$expResult[6]): ?>
<!--                        <li><a href="#">Report-3</a></li>-->
<!--                    --><?php //endif; ?>
                </ul>
            </li>
        <?php endif; ?>
            <?php break; ?>
        <?php
    }
endforeach;
?>

<!-- #### Settings #### -->
<li class="<?php echo $selectMenu == "settings" ? "active" : ""; ?> <?php echo $checkShowSettingMenu ? "" : 'hidden'; ?>">
    <a href="<?php echo $webUrl; ?>member" data-toggle="dropdown" class='dropdown-toggle'>
        <span>Settings</span>
        <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <?php
        foreach ($objCheckModule as $key => $value) :
            $expResult = explode(',', $value->permission);
            switch ($value->title) {
                case "Users":
                    ?><?php if (@$expResult[0]):?>

                    <li><a href="<?php echo $webUrl; ?>member">Users</a></li>

                <?php endif; ?>
                    <?php break; ?>
                <?php
                case "Departments":
                    ?><?php if (@$expResult[0]):?>
                    <li><a href="<?php echo $webUrl; ?>department">Departments</a></li>
                <?php endif; ?>
                    <?php break; ?>
                <?php
                case "Position":
                    ?><?php if (@$expResult[0]):?>
                    <li><a href="<?php echo $webUrl; ?>position">Position</a></li>
                <?php endif; ?>
                    <?php break; ?>
                <?php
                case "Modules":
                    ?><?php if (@$expResult[0]):?>
                    <li><a href="<?php echo $webUrl; ?>module">Modules</a></li>
                <?php endif; ?>
                    <?php break; ?>
                <?php
                case "Log":
                    ?><?php if (@$expResult[0]):?>
                    <li><a href="<?php echo $webUrl; ?>log">Log</a></li>
                <?php endif; ?>
                    <?php break; ?>

                <?php
            }
        endforeach;
        ?> </ul>
</li>
<?php foreach ($objCheckModule as $key => $value) :
    $expResult = explode(',', $value->permission);
    switch ($value->title) {
        case "Issue":
            ?>
            <!-- #### Issue #### -->
            <li class="<?php echo $selectMenu == "Issue" ? "active" : ""; ?> <?php echo $checkShowIssueMenu ? "" : 'hidden'; ?>">
                <a href="<?php echo $webUrl; ?>issue" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Issue</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <?php if (@$expResult[1]): ?>
                        <li><a href="<?php echo $webUrl; ?>issue/add">Add new</a></li>
                    <?php endif; ?>


                </ul>
            </li>
            <?php break; ?>
        <?php
    }
endforeach;
?>
</ul>

<div class="user">
    <div class="dropdown">
        <a href="<?php echo $webUrl; ?>member/edit/<?php echo $id; ?>" class='dropdown-toggle' data-toggle="dropdown" style="height: 22px; min-width: 140px;">
            <span style="float: left; margin-right: 5px;">Welcome : <?php echo @$username; ?></span>

            <div
                style="width: 24px; height: 24px;margin: 0 auto; overflow:hidden; position: relative; float: right;">
                <img style="margin-left: 0;" src="<?php
                if (file_exists(@$image_path)) {
                    echo $baseUrl . $image_path;
                } else {
                    echo $baseUrl . "assets/img/no_avatar.jpg";
                }
                ?>" alt="">
            </div>
        </a>
        <ul class="dropdown-menu pull-right">
            <li>
                <a href="<?php echo $webUrl; ?>lock">Lock Screen</a>
            </li>
            <li>
                <a href="<?php echo $webUrl; ?>signout">Sign out</a>
            </li>
        </ul>
    </div>
</div>
</div>
</div>