<div id="navigation">
    <div class="container-fluid">
        <a href="#" id="brand">ICS-Services</a>
        <a href="#" class="toggle-nav" rel="tooltip" data-placement="bottom" title="Toggle navigation"><i class="icon-reorder"></i></a>

        <ul class='main-nav'>
            <!-- #### Dashbaord #### -->
            <li class='active'>
                <a href="#"><span>Dashboard</span></a>
            </li>
            <!-- #### Company #### -->
            <li>
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Company</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">Company List</a></li>
                    <li><a href="#">Company Add</a></li>
                    <li><a href="#">Report 1</a></li>
                    <li><a href="#">Report 2</a></li>
                    <li><a href="#">Report 3</a></li>
                </ul>
            </li>
            <!-- #### Device #### -->
            <li>
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Device</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">Device List</a></li>
                    <li><a href="#">Device Add</a></li>
                    <li><a href="#">Report 1</a></li>
                    <li><a href="#">Report 2</a></li>
                    <li><a href="#">Report 3</a></li>
                </ul>
            </li>
            <!-- #### Settings #### -->
            <li>
                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                    <span>Settings</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#">Users</a></li>
                    <li><a href="#">Logs</a></li>
                    <!--            <li><a href="#">Calendars</a></li>-->
                    <!--            <li><a href="#">Tasks</a></li>-->
                    <!--            <li><a href="#">News</a></li>-->
                </ul>
            </li>
        </ul>

        <div class="user">
            <div class="dropdown">
                <a href="#" class='dropdown-toggle' data-toggle="dropdown"><?php echo $_SESSION["memFName"];?> <img src="img/demo/user-avatar.jpg" alt=""></a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a href="more-userprofile.html">Edit profile</a>
                    </li>
                    <li>
                        <a href="#">Account settings</a>
                    </li>
                    <li>
                        <a href="more-login.html">Sign out</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>