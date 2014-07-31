<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$this->load->view("header");
$this->load->view("navigator_menu");

$objData = $this->Log_model->logList();
if ($_GET) {
    $strGet = "?" . $_SERVER['QUERY_STRING'];
} else {
    $strGet = "";
}
?>
    <link rel="stylesheet" type="text/css"
          href="<?php echo $baseUrl; ?>assets/js/plugins/datatable/server_side/css/jquery.dataTables.css">
    <style type="text/css" class="init">
    </style>
    <script type="text/javascript" language="javascript"
            src="<?php echo $baseUrl; ?>assets/js/plugins/datatable/server_side/js/jquery.js"></script>
    <script type="text/javascript" language="javascript"
            src="<?php echo $baseUrl; ?>assets/js/plugins/datatable/server_side/js/jquery.dataTables.js"></script>
    <script>
        jQuery.noConflict()(document).ready(function () {
            jQuery.noConflict()('#dataTable').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": webUrl + "log<?php echo $strGet; ?>",
                "aoColumns": [
                    null,
                    null,
                    null,
                    null
                ], "order": [[ 0, "desc" ]],
//                "iDisplayLength": 50,
                "aLengthMenu": [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ]
            });
        });
    </script>
    <div class="container-fluid" id="content">

        <?php
        $this->load->view("sidebar_menu");
        ?>
        <div id="main">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="pull-left">
                        <h1>Log</h1>
                    </div>
                </div>
                <div class="breadcrumbs">
                    <ul>
                        <li>
                            <a class="link" href="<?php echo $webUrl; ?>dashboard">Home</a>
                            <i class="icon-angle-right"></i>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $webUrl; ?>log">Log</a>
                        </li>
                    </ul>
                    <div class="close-bread">
                        <a href="#"><i class="icon-remove"></i></a>
                    </div>
                </div>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="box box-color box-bordered">
                            <div class="box-title">
                                <h3>
                                    <i class="icon-list"></i>
                                    Log
                                </h3>
                            </div>
                            <?php if (@$permission): ?>
                                <div class="box-content nopadding">
                                    <table id="dataTable" class="stripe" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="span2">#</th>
                                            <th class="span5">Name</th>
                                            <th class="span3">Title</th>
                                            <th class='span2'>Date Create</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            <?php
                            else:
                                $this->load->view("permission_page");
                            endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->load->view("footer");
