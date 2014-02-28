<?php
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- Apple devices fullscreen -->
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <!-- Apple devices fullscreen -->
    <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent"/>

    <title>ICS Service</title>
    <script>
        var baseUrl = "<?php echo $baseUrl; ?>";
        var webUrl = "<?php echo $webUrl; ?>";
    </script>
    <!-- ####################################### css ################################################################## -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/bootstrap.min.css">
    <!-- Bootstrap responsive -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/bootstrap-responsive.min.css">
    <!-- jQuery UI -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/jquery-ui/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
    <!-- Notify -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/gritter/jquery.gritter.css">
    <!-- PageGuide -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/pageguide/pageguide.css">
    <!-- Fullcalendar -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/fullcalendar/fullcalendar.css">
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/fullcalendar/fullcalendar.print.css"
          media="print">
    <!-- chosen -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/chosen/chosen.css">
    <!-- select2 -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/select2/select2.css">
    <!-- icheck -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/icheck/all.css">
    <!-- Theme CSS -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/style.css">
    <!-- Color CSS -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/themes.css">
    <!-- Datepicker -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/datepicker/datepicker.css">
    <!-- Daterangepicker -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/daterangepicker/daterangepicker.css">
    <!-- dataTables -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/datatable/TableTools.css">
    <!-- Tagsinput -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/tagsinput/jquery.tagsinput.css">
    <!-- multi select -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/multiselect/multi-select.css">
    <!-- timepicker -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- colorpicker -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/colorpicker/colorpicker.css">
    <!-- Plupload -->
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>assets/css/plugins/plupload/jquery.plupload.queue.css">


    <!-- ####################################### js ################################################################## -->
    <!-- jQuery -->
    <script src="<?php echo $baseUrl; ?>assets/js/jquery.min.js"></script>


    <!-- Nice Scroll -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- imagesLoaded -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
    <!-- jQuery UI -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/jquery-ui/jquery.ui.core.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/jquery-ui/jquery.ui.widget.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/jquery-ui/jquery.ui.mouse.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/jquery-ui/jquery.ui.draggable.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/jquery-ui/jquery.ui.resizable.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/jquery-ui/jquery.ui.sortable.min.js"></script>
    <!-- Touch enable for jquery UI -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/touch-punch/jquery.touch-punch.min.js"></script>
    <!-- slimScroll -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo $baseUrl; ?>assets/js/bootstrap.min.js"></script>
    <!-- vmap -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/vmap/jquery.vmap.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/vmap/jquery.vmap.world.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/vmap/jquery.vmap.sampledata.js"></script>
    <!-- Bootbox -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/bootbox/jquery.bootbox.js"></script>
    <!-- Notify -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/gritter/jquery.gritter.min.js"></script>
    <!-- Masked inputs -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/maskedinput/jquery.maskedinput.min.js"></script>
    <!-- Flot -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/flot/jquery.flot.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/flot/jquery.flot.bar.order.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/flot/jquery.flot.pie.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/flot/jquery.flot.resize.min.js"></script>
    <!-- imagesLoaded -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/imagesLoaded/jquery.imagesloaded.min.js"></script>
    <!-- PageGuide -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/pageguide/jquery.pageguide.js"></script>
    <!-- FullCalendar -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>
    <!-- Chosen -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/chosen/chosen.jquery.min.js"></script>
    <!-- select2 -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/select2/select2.min.js"></script>
    <!-- icheck -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/icheck/jquery.icheck.min.js"></script>

    <!-- Theme framework -->
    <script src="<?php echo $baseUrl; ?>assets/js/eakroko.js"></script>
    <!-- Theme scripts -->
    <script src="<?php echo $baseUrl; ?>assets/js/application.min.js"></script>
    <!-- Just for demonstration -->
    <script src="<?php echo $baseUrl; ?>assets/js/demonstration.min.js"></script>
    <!-- Datepicker -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Daterangepicker -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/daterangepicker/moment.min.js"></script>
    <!-- dataTables -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/datatable/jquery.dataTables.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/datatable/TableTools.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/datatable/ColReorderWithResize.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/datatable/ColVis.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/datatable/jquery.dataTables.columnFilter.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/datatable/jquery.dataTables.grouping.js"></script>

    <!-- ############### custom ################## -->
    <!-- TagsInput -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/tagsinput/jquery.tagsinput.min.js"></script>
    <!-- Timepicker -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- Colorpicker -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/colorpicker/bootstrap-colorpicker.js"></script>
    <!-- Chosen -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/chosen/chosen.jquery.min.js"></script>
    <!-- MultiSelect -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/multiselect/jquery.multi-select.js"></script>
    <!-- CKEditor -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/ckeditor/ckeditor.js"></script>
    <!-- PLUpload -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/plupload/plupload.full.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/plupload/jquery.plupload.queue.js"></script>
    <!-- Custom file upload -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/fileupload/bootstrap-fileupload.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/mockjax/jquery.mockjax.js"></script>
    <!-- select2 -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/select2/select2.min.js"></script>
    <!-- icheck -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/icheck/jquery.icheck.min.js"></script>
    <!-- complexify -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/complexify/jquery.complexify-banlist.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/complexify/jquery.complexify.min.js"></script>
    <!-- Mockjax -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/mockjax/jquery.mockjax.js"></script>


    <!-- Validation -->
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/validation/jquery.validate.min.js"></script>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/validation/additional-methods.min.js"></script>
    <!--[if lte IE 9]>
    <script src="<?php echo $baseUrl; ?>assets/js/plugins/placeholder/jquery.placeholder.min.js"></script>
    <script>
        $(document).ready(function () {
            $('input, textarea').placeholder();
        });
    </script>
    <![endif]-->

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo $baseUrl; ?>assets/img/logo.ico"/>
    <!-- Apple devices Homescreen icon -->
    <link rel="apple-touch-icon-precomposed" href="<?php echo $baseUrl; ?>assets/img/apple-touch-icon-precomposed.png"/>

    <script src="<?php echo $baseUrl; ?>assets/js/ics_service.js"></script>
</head>

<body>

<!--Confirm delete data-->
<div id="messageDeleteData" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-header">
        <!--        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
        <h3 id="myModalLabel">Delete Data</h3>
    </div>
    <div class="modal-body">
        <p>คุณต้องการลบข้อมูล ใช่หรือไม่</p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
        <a href="#" class="btn btn-primary notify" data-notify-title="Delete Success!"
           data-notify-message="The user has been successfully deleted." role="button"
           data-dismiss="modal" onclick="deleteData();">Yes</a>
    </div>
</div>
<!--End confirm-->

<!--Update success-->
<a href="#" role="button" class="notify" data-notify-time="2000" data-notify-title="Success!"
   data-notify-message="The user has been successfully edited." id="btnNotifyUpdate"></a>

<!--Message error-->
<a href="#" role="button" class="notify" data-notify-time="2000" data-notify-title="WARNING!"
   data-notify-message="Please refresh the cache!" id="btnNotifyError"></a>