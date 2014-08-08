<?php
$baseUrl = base_url();
$webUrl = $this->Constant_model->webUrl();
$objCheckModule = $this->Module_model->checkModuleByName();

$checkShowISPOTMenu = false;
$checkShowSettingMenu = false;
$checkShowIssueMenu = false;
foreach ($objCheckModule as $key => $value) {
    $expResult = explode(',', $value->permission);
    switch ($value->title) {
        case "Company":
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
<div id="left">
<form action="#" method="GET" class='search-form'>
    <div class="search-pane">
        <input type="text" name="search" placeholder="Search here...">
        <button type="submit"><i class="icon-search"></i></button>
    </div>
</form>
<?php
foreach ($objCheckModule as $key => $value) :
    $expResult = explode(',', $value->permission);
    switch ($value->title) {
        case "Dashboard":
            ?>
            <?php if (@$expResult[0]): ?>
            <!-- #### Dashboard #### -->
            <div class="subnav subnav-hidden">
                <div class="subnav-title">
                    <a href="<?php echo $webUrl; ?>dashboard" class='toggle-subnav'><span>Dashboard</span></a>
                </div>
            </div>
        <?php endif; ?>
            <?php break; ?>
        <?php
    }
endforeach;
?>
<!-- #### iSpot #### -->
<div class="subnav subnav-hidden">
    <div class="subnav-title <?php echo $checkShowISPOTMenu ? "": 'hidden'; ?>">
        <a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>iSpot</span></a>
    </div>
    <?php
    foreach ($objCheckModule as $key => $value) :
        $expResult = explode(',', $value->permission);
        switch ($value->title) {
            case "Company":
                ?><?php if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]):?>
                <ul class="subnav-menu">
                    <li class='dropdown'>
                        <a href="#" data-toggle="dropdown">Company</a>
                        <ul class="dropdown-menu">
                            <?php if (@$expResult[0]): ?>
                                <li><a href="<?php echo $webUrl; ?>company">List</a></li>
                            <?php endif; ?>
                            <?php if (@$expResult[1]): ?>
                                <li><a href="<?php echo $webUrl; ?>company/add">Add new</a></li>
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
                </ul>
            <?php endif; ?>

                <?php break;
            case "Quotation":
                ?><?php if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]):?>
                <ul class="subnav-menu">
                    <li class='dropdown'>
                        <a href="#" data-toggle="dropdown">Quotation</a>
                        <ul class="dropdown-menu">
                            <?php if (@$expResult[0]): ?>
                                <li><a href="<?php echo $webUrl; ?>quotation">List</a></li>
                            <?php endif; ?>
                            <?php if (@$expResult[1]): ?>
                                <li><a href="<?php echo $webUrl; ?>quotation/add">Add new</a></li>
                            <?php endif; ?>
<!--                            --><?php //if (@$expResult[4]): ?>
<!--                                <li><a href="#">Report-1</a></li>-->
<!--                            --><?php //endif; ?>
<!--                            --><?php //if (@$expResult[5]): ?>
<!--                                <li><a href="#">Report-2</a></li>-->
<!--                            --><?php //endif; ?>
<!--                            --><?php //if (@$expResult[6]): ?>
<!--                                <li><a href="#">Report-3</a></li>-->
<!--                            --><?php //endif; ?>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>

                <?php break; ?>
            <?php
            case   "Device":
                ?><?php if (@$expResult[0] || @$expResult[1] || @$expResult[4] || @$expResult[5] || @$expResult[6]):?>
                <ul class="subnav-menu">
                    <li class='dropdown'>
                        <a href="#" data-toggle="dropdown">Device</a>
                        <ul class="dropdown-menu">
                            <?php if (@$expResult[0]): ?>
                                <li><a href="<?php echo $webUrl; ?>device">List</a></li>
                            <?php endif; ?>
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
                </ul>
            <?php endif; ?>
                <?php break; ?>
            <?php
        }
    endforeach;
    ?>
</div>

<!-- #### Settings #### -->
<div class="subnav subnav-hidden">
    <div class="subnav-title <?php echo $checkShowSettingMenu ? "": 'hidden'; ?>">
        <a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Settings</span></a>
    </div>
    <?php
    foreach ($objCheckModule as $key => $value) :
        $expResult = explode(',', $value->permission);
        switch ($value->title) {
            case "Users":
                ?><?php if (@$expResult[0] || @$expResult[1]):?>
                <ul class="subnav-menu">
                    <li class='dropdown'>
                        <a href="#" data-toggle="dropdown">Users</a>
                        <ul class="dropdown-menu">
                            <?php if (@$expResult[0]): ?>
                                <li><a href="<?php echo $webUrl; ?>member">List</a></li>
                            <?php endif; ?>
                            <?php if (@$expResult[1]): ?>
                                <li><a href="<?php echo $webUrl; ?>member/add">Add new</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
                <?php break; ?>
            <?php
            case "Departments":
                ?><?php if (@$expResult[0] || @$expResult[1]):?>
                <ul class="subnav-menu">
                    <li class='dropdown'>
                        <a href="#" data-toggle="dropdown">Departments</a>
                        <ul class="dropdown-menu">
                            <?php if (@$expResult[0]): ?>
                                <li><a href="<?php echo $webUrl; ?>department">List</a>
                                </li>
                            <?php endif; ?>
                            <?php if (@$expResult[1]): ?>
                                <li><a href="<?php echo $webUrl; ?>department/add">Add new</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
                <?php break; ?>
            <?php
            case "Position":
                ?><?php if (@$expResult[0] || @$expResult[1]):?>
                <ul class="subnav-menu">
                    <li class='dropdown'>
                        <a href="#" data-toggle="dropdown">Position</a>
                        <ul class="dropdown-menu">
                            <?php if (@$expResult[0]): ?>
                                <li><a href="<?php echo $webUrl; ?>position">List</a></li>
                            <?php endif; ?>
                            <?php if (@$expResult[1]): ?>
                                <li><a href="<?php echo $webUrl; ?>position/add">Add new</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
                <?php break; ?>
            <?php
            case "Modules":
                ?><?php if (@$expResult[0] || @$expResult[1]):?>
                <ul class="subnav-menu">
                    <li class='dropdown'>
                        <a href="#" data-toggle="dropdown">Modules</a>
                        <ul class="dropdown-menu">
                            <?php if (@$expResult[0]): ?>
                                <li><a href="<?php echo $webUrl; ?>module">List</a></li>
                            <?php endif; ?>
                            <?php if (@$expResult[1]): ?>
                                <li><a href="<?php echo $webUrl; ?>module/add">Add new</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
                <?php break; ?>
            <?php
            case "Log":
                ?>
                <?php if (@$expResult[0]): ?>
                <ul class="subnav-menu">
                    <li class=''>
                        <a href="<?php echo $webUrl; ?>log" data-toggle="dropdown">Log</a>
                    </li>
                </ul>

            <?php endif; ?>
                <?php break; ?>
            <?php
        }
    endforeach;
    ?>
</div>

<!-- #### Issue #### -->
<div class="subnav subnav-hidden">
    <div class="subnav-title <?php echo $checkShowIssueMenu ? "": 'hidden'; ?>">
        <a href="#" class='toggle-subnav'><i class="icon-angle-down"></i><span>Issue</span></a>
    </div>
    <ul class="subnav-menu">
        <li class=''>
            <a href="<?php echo $webUrl; ?>issue">List</a>
        </li>
        <li class=''>
            <a href="<?php echo $webUrl; ?>issue/add" data-toggle="dropdown">Add new</a>
        </li>
    </ul>
</div>

<!-- #### Singout #### -->
<div class="subnav subnav-hidden">
    <div class="subnav-title">
        <a href="<?php echo $webUrl; ?>signout" id="signOut" class='toggle-subnav'><span>SIGNOUT</span></a>
    </div>
</div>
</div>