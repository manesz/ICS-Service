<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 18/12/2556
 * Time: 11:31 น.
 * To change this template use File | Settings | File Templates.
 */

$webUrl = $this->Constant_model->webUrl();
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

    <div id="main">
    <div class="container-fluid">
    <div class="page-header">
        <div class="pull-left">
            <h1>Dashboard</h1>
        </div>
    </div>
    <!-- END: .page-header -->

    <div class="breadcrumbs">
        <ul>
            <li>
                <a href="#">Home</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="#">Dashboard</a>
            </li>
        </ul>
        <div class="close-bread">
            <a href="#"><i class="icon-remove"></i></a>
        </div>
    </div>
    <!-- END: ,breadcrumbs -->

    <?php if (@$permission): ?>
    <script>
        var max_feed = <?php echo @$max_feed; ?>;
        $(document).ready(function () {
            logFeed();
        });
    </script>
    <div class="row-fluid">
        <div class="span6-fluid">
            <div class="box box-color box-bordered green">
                <div class="box-title">
                    <h3><i class="icon-bullhorn"></i>Log Feeds</h3>

                    <div class="actions">
                        <a href="#" class="btn btn-mini custom-checkbox checkbox-active">Automatic refresh<i
                                class="icon-check-empty"></i></a>
                    </div>
                </div>
                <div class="box-content nopadding scrollable" data-height="300" data-visible="true">
                    <table class="table table-nohead" id="log_feed">
                        <tbody>
                        <?php if ($objFeed) foreach ($objFeed as $key => $value): ?>
                            <tr>
                                <?php
                                $strClass = "";
                                $strTextShow = "$value->title";
                                $strTextShow .= " &nbsp;<i style='color: brown;'>$value->create_datetime</i>";
                                $arrayDesc = (array)json_decode($value->description);
                                if (strstr($value->title, 'add')) {
                                    $strClass = "icon-plus";
                                    if (!strstr($value->title, 'image'))
                                        $strTextShow .= " &nbsp;<a href='$webUrl" .
                                            str_replace('add ', '', $value->title) . "/edit/" . @$arrayDesc['id'] .
                                                "'>#Link</a>";
                                } else if (strstr($value->title, 'edit')) {
                                    $strClass = "icon-edit";
                                    if (!strstr($value->title, 'image'))
                                        $strTextShow .= " &nbsp;<a href='$webUrl" .
                                            str_replace('edit ', '', $value->title) . "/edit/" . @$arrayDesc['id'] .
                                                "'>#Link</a>";
                                } else if (strstr($value->title, 'delete')) {
                                    $strClass = "icon-edit";
                                } else if (strstr($value->title, 'Sign in')) {
                                    $strClass = "icon-signin";
                                } else if (strstr($value->title, 'Sign out')) {
                                    $strClass = "icon-signout";
                                }
                                $strLink = $webUrl . "member/edit/" . $value->member_id;
                                ?>
                                <td><span class="label"><i class="<?php echo $strClass; ?>"></i></span>
                                    <a href="<?php echo $strLink; ?>"><?php echo $value->name; ?></a>
                                    <?php echo $strTextShow; ?>
                                </td>
                                <?php ?>
                            </tr>
                        <?php endforeach; ?>
                        <!--                        <tr>-->
                        <!--                            <td>1.<span class="label"><i class="icon-plus"></i></span> <a href="#">John Doe</a> added a-->
                        <!--                                new photo-->
                        <!--                            </td>-->
                        <!--                        </tr>-->
                        <!--                        <tr>-->
                        <!--                            <td>2.<span class="label label-success"><i class="icon-user"></i></span> New user registered-->
                        <!--                            </td>-->
                        <!--                        </tr>-->
                        <!--                        <tr>-->
                        <!--                            <td>3.<span class="label label-info"><i class="icon-shopping-cart"></i></span> New order-->
                        <!--                                received-->
                        <!--                            </td>-->
                        <!--                        </tr>-->
                        <!--                        <tr>-->
                        <!--                            <td>4.<span class="label label-warning"><i class="icon-comment"></i></span> <a href="#">John-->
                        <!--                                    Doe</a> commented on <a href="#">News #123</a></td>-->
                        <!--                        </tr>-->
                        <!--                        <tr>-->
                        <!--                            <td>5.<span class="label label-success"><i class="icon-user"></i></span> New user registered-->
                        <!--                            </td>-->
                        <!--                        </tr>-->
                        <!--                        <tr>-->
                        <!--                            <td>6.<span class="label label-info"><i class="icon-shopping-cart"></i></span> New order-->
                        <!--                                received-->
                        <!--                            </td>-->
                        <!--                        </tr>-->
                        <!--                        <tr>-->
                        <!--                            <td>7.<span class="label label-warning"><i class="icon-comment"></i></span> <a href="#">John-->
                        <!--                                    Doe</a> commented on <a href="#">News #123</a></td>-->
                        <!--                        </tr>-->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="span6-fluid">
            <div class="box">
                <div class="box-title">
                    <h3><i class="icon-calendar"></i>My calendar</h3>
                </div>
                <div class="box-content nopadding">
                    <div class="calendar"></div>
                </div>
            </div>
        </div>
        <div class="span6-fluid">
            <div class="box box-color box-bordered lightgrey">
                <div class="box-title">
                    <h3><i class="icon-ok"></i> Tasks</h3>

                    <div class="actions">
                        <a href="#new-task" data-toggle="modal" class='btn'><i class="icon-plus-sign"></i> Add Task</a>
                    </div>
                </div>
                <div class="box-content nopadding">
                    <ul class="tasklist">
                        <li class='bookmarked'>
                            <div class="check">
                                <input type="checkbox" class='icheck-me' data-skin="square" data-color="blue">
                            </div>
                            <span class="task"><i class="icon-ok"></i><span>Approve new users</span></span>
                                                            <span class="task-actions">
                                                                <a href="#" class='task-delete' rel="tooltip"
                                                                   title="Delete that task"><i class="icon-remove"></i></a>
                                                                <a href="#" class='task-bookmark' rel="tooltip"
                                                                   title="Mark as important"><i
                                                                        class="icon-bookmark-empty"></i></a>
                                                            </span>
                        </li>
                        <li>
                            <div class="check">
                                <input type="checkbox" class='icheck-me' data-skin="square" data-color="blue">
                            </div>
                            <span class="task"><i class="icon-bar-chart"></i><span>Check statistics</span></span>
                                                            <span class="task-actions">
                                                                <a href="#" class='task-delete' rel="tooltip"
                                                                   title="Delete that task"><i class="icon-remove"></i></a>
                                                                <a href="#" class='task-bookmark' rel="tooltip"
                                                                   title="Mark as important"><i
                                                                        class="icon-bookmark-empty"></i></a>
                                                            </span>
                        </li>
                        <li class='done'>
                            <div class="check">
                                <input type="checkbox" class='icheck-me' data-skin="square" data-color="blue"
                                       checked>
                            </div>
                            <span class="task"><i class="icon-envelope"></i><span>Check for new mails</span></span>
                                                            <span class="task-actions">
                                                                <a href="#" class='task-delete' rel="tooltip"
                                                                   title="Delete that task"><i class="icon-remove"></i></a>
                                                                <a href="#" class='task-bookmark' rel="tooltip"
                                                                   title="Mark as important"><i
                                                                        class="icon-bookmark-empty"></i></a>
                                                            </span>
                        </li>
                        <li>
                            <div class="check">
                                <input type="checkbox" class='icheck-me' data-skin="square" data-color="blue">
                            </div>
                            <span class="task"><i class="icon-comment"></i><span>Chat with John Doe</span></span>
                                                            <span class="task-actions">
                                                                <a href="#" class='task-delete' rel="tooltip"
                                                                   title="Delete that task"><i class="icon-remove"></i></a>
                                                                <a href="#" class='task-bookmark' rel="tooltip"
                                                                   title="Mark as important"><i
                                                                        class="icon-bookmark-empty"></i></a>
                                                            </span>
                        </li>
                        <li>
                            <div class="check">
                                <input type="checkbox" class='icheck-me' data-skin="square" data-color="blue">
                            </div>
                                <span class="task"><i
                                        class="icon-retweet"></i><span>Go and tweet some stuff</span></span>
                                                            <span class="task-actions">
                                                                <a href="#" class='task-delete' rel="tooltip"
                                                                   title="Delete that task"><i class="icon-remove"></i></a>
                                                                <a href="#" class='task-bookmark' rel="tooltip"
                                                                   title="Mark as important"><i
                                                                        class="icon-bookmark-empty"></i></a>
                                                            </span>
                        </li>
                        <li>
                            <div class="check">
                                <input type="checkbox" class='icheck-me' data-skin="square" data-color="blue">
                            </div>
                            <span class="task"><i class="icon-edit"></i><span>Write an article</span></span>
                                                            <span class="task-actions">
                                                                <a href="#" class='task-delete' rel="tooltip"
                                                                   title="Delete that task"><i class="icon-remove"></i></a>
                                                                <a href="#" class='task-bookmark' rel="tooltip"
                                                                   title="Mark as important"><i
                                                                        class="icon-bookmark-empty"></i></a>
                                                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row-fluid">

        <div class="span6">
            <div class="box box-color box-bordered">
                <div class="box-title">
                    <h3><i class="icon-user"></i>Address Book</h3>

                    <div class="actions">
                        <a href="#" class="btn btn-mini content-refresh"><i class="icon-refresh"></i></a>
                        <a href="#" class="btn btn-mini content-remove"><i class="icon-remove"></i></a>
                        <a href="#" class="btn btn-mini content-slideUp"><i class="icon-angle-down"></i></a>
                    </div>
                </div>
                <div class="box-content nopadding scrollable" data-height="300" data-visible="true">
                    <table class="table table-user table-nohead">
                        <tbody>
                        <tr class="alpha">
                            <td class="alpha-val">
                                <span>B</span>
                            </td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-1.jpg" alt=""></td>
                            <td class='user'>Bi Doe</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-2.jpg" alt=""></td>
                            <td class='user'>Boo Doe</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr class="alpha">
                            <td class="alpha-val">
                                <span>D</span>
                            </td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-3.jpg" alt=""></td>
                            <td class='user'>Dan Doe</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-4.jpg" alt=""></td>
                            <td class='user'>Dane Doe</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr class="alpha">
                            <td class="alpha-val">
                                <span>H</span>
                            </td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-3.jpg" alt=""></td>
                            <td class='user'>Hilda N. Ervin</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr class="alpha">
                            <td class="alpha-val">
                                <span>J</span>
                            </td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-5.jpg" alt=""></td>
                            <td class='user'>John Doe</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-6.jpg" alt=""></td>
                            <td class='user'>John Doe</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr class="alpha">
                            <td class="alpha-val">
                                <span>L</span>
                            </td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-5.jpg" alt=""></td>
                            <td class='user'>Laura J. Brown</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-6.jpg" alt=""></td>
                            <td class='user'>Lilly J. Tooley</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr class="alpha">
                            <td class="alpha-val">
                                <span>M</span>
                            </td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-1.jpg" alt=""></td>
                            <td class='user'>Maxi Doe</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-2.jpg" alt=""></td>
                            <td class='user'>Max Doe</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr class="alpha">
                            <td class="alpha-val">
                                <span>O</span>
                            </td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-1.jpg" alt=""></td>
                            <td class='user'>Oxx Doe</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-2.jpg" alt=""></td>
                            <td class='user'>Osam Doe</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr class="alpha">
                            <td class="alpha-val">
                                <span>P</span>
                            </td>
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-1.jpg" alt=""></td>
                            <td class='user'>Petra Doe</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        <tr>
                            <td class='img'><img src="<?php echo $baseUrl; ?>assets/img/demo/user-2.jpg" alt=""></td>
                            <td class='user'>Per Doe</td>
                            <td class='icon'><a href="#" class='btn'><i class="icon-search"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- END: container-fluid -->
    <?php else:
        $this->load->view("permission_page");
    endif;
    ?>
    </div>


    </div><!-- END: #content -->

<?php
$this->load->view("footer");
?>