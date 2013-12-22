<?php
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();

$this->load->view("cms/header");
$this->load->view("cms/navigator");

?>
    <script>

        var url_new_data = "<?php echo $webUrl; ?>setting/departmentAdd";
        var urlList = "<?php echo $webUrl; ?>setting/departmentList";
        $(document).ready(function () {
            $('#btnCancel').click(function () {
                window.location.href = urlList;
                return false;
            });

            $("#formPost").submit(function () {
                disableID("btnSave");
                var checkPost = true;
                $("#formPost .error").each(function () {
                    var className = $(this).attr('class');
                    var index = className.indexOf("valid");
                    if (index < 0) {
                        checkPost = false;
                    }
                });
                if (checkPost) {
                    postData($(this).serialize(), false);
                } else {
                    enableID("btnSave");
                }
                return false;
            });
        });

        function postData(data) {
            $.post(url_new_data, data,
                function (result) {
                    if (result == "add fail") {
                        alert('** เกิดข้อผิดพลาด');
                        enableID("btnSave");
                    } else {
                        window.location.href = urlList
                    }
                }
            );
        }
    </script>
<div class="container-fluid" id="content">

<?php
$this->load->view("cms/sidebar");
?>
    <div id="main">
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>New Department</h1>
                </div>
            </div>
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="<?php echo $webUrl; ?>Dashboard">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl; ?>departmentList">Department</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a class="" href="#">New Department</a>
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
                                <i class="icon-list"></i> Department
                            </h3>
                        </div>
                        <!-- END: .box-title -->
                        <div class="box-content nopadding">
                            <form action="" method="POST"
                                  class='form-horizontal form-column form-bordered form-validate'
                                  id="formPost" name="formPost">
                                <div class="span12">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label for="title" class="control-label">Title :</label>

                                            <div class="controls">
                                                <input type="text" name="title" id="title"
                                                       placeholder="Text input" class="input-block-level"
                                                       data-rule-required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">

                                        <div class="control-group">
                                            <label for="description" class="control-label">Description :</label>

                                            <div class="controls">
                                                <textarea name="description" id="description" rows="5"
                                                          class="input-block-level"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary" id="btnSave">Save changes</button>
                                        <button type="button" class="btn" id="btnCancel">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- END: .box-content nopadding -->
                    </div>
                    <!-- END: .box -->
                </div>
                <!-- END: .span12 -->
            </div>
            <!-- END: .row-fluid -->

        </div>
        <!-- END: #main -->
    </div><!-- END: .container-fluid -->
<?php
$this->load->view("cms/footer");
?>