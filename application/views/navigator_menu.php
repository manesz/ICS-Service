<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$id = @$this->session->userdata['id'];
$arrMember = $this->Member_model->memberList($id);
extract((array)$arrMember[0]);
$objCheckModule = $this->Module_model->checkModuleByName();
?>
<div id="navigation">
    <div class="container-fluid">
        <a href="#" id="brand">ICS-Services</a>
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
                    case   "Company":
                        ?><?php if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]):?>
                        <!-- #### Company #### -->
                        <li class="<?php echo $selectMenu == "company" ? "active" : ""; ?>">
                            <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                                <span>Company</span>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (@$expResult[0]): ?>
                                    <li><a href="<?php echo $webUrl; ?>company">List</a></li>
                                <?php endif; ?>
                                <?php if (@$expResult[1]): ?>
                                    <li><a href="<?php echo $webUrl; ?>company/companyAdd">Add new</a></li>
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
                            <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                                <span>Device</span>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (@$expResult[0]): ?>
                                    <li><a href="<?php echo $webUrl; ?>device">List</a></li>
                                <?php endif; ?>
                                <?php if (@$expResult[1]): ?>
                                    <li><a href="<?php echo $webUrl; ?>device/deviceAdd">Add new</a></li>
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
                }
            endforeach;
            ?>

            <!-- #### Settings #### -->
            <li class="<?php echo $selectMenu == "settings" ? "active" : ""; ?>">
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
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
                            case "Log":
                                ?><?php if (@$expResult[0]):?>
                                <li><a href="#">Log</a></li>
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
                        <li class="<?php echo $selectMenu == "Issue" ? "active" : ""; ?>">
                            <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                                <span>Issue</span>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">

                                <?php if (@$expResult[0]): ?>

                                    <li><a href="<?php echo $webUrl; ?>issue">List</a></li>

                                <?php endif; ?>
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
                <a href="#" class='dropdown-toggle' data-toggle="dropdown" style="height: 22px; min-width: 140px;">
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
                        <a href="<?php echo $webUrl; ?>member/memberEdit/<?php echo $id; ?>">Edit
                            profile</a>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl; ?>signout">Sign out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>