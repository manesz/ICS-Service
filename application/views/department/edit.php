<?php
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$this->load->view("header");
$this->load->view("navigator_menu");


$arrData = $this->Department_model->DepartmentList($id);
$arrData = (array)$arrData[0];
extract($arrData);
?>
    <script>
        var url_post_data = "<?php echo $webUrl; ?>department/edit/<?php echo $id; ?>";
        var url_list = "<?php echo $webUrl; ?>department";
        $(document).ready(function () {
            $('#btnCancel').click(function () {
                openUrl(url_list);
                return false;
            });

            $("#formPost").submit(function () {
                disableID("btnSave");
                var checkPost = checkValidateForm("#formPost");
                if (checkPost) {
                    postData(url_post_data, $(this).serialize(), url_list);
                } else {
                    enableID("btnSave");
                }
                return false;
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
                    <h1>Edit Department</h1>
                </div>
            </div>
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="<?php echo $webUrl; ?>Dashboard">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl; ?>department">Department</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl; ?>department/edit/<?php echo $id; ?>">Edit Department</a>
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
                        <?php if (@$permission): ?>
                            <div class="box-content nopadding">
                                <form action="" method="POST" autocomplete="off"
                                      class='form-horizontal form-column form-bordered form-validate'
                                      id="formPost" name="formPost">
                                    <div class="span12">
                                        <div class="span6">
                                            <div class="control-group">
                                                <label for="title" class="control-label">Title :</label>

                                                <div class="controls">
                                                    <input type="text" name="title" id="title"
                                                           placeholder="Text input" class="input-block-level"
                                                           data-rule-required="true" value="<?php echo @$title; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span6">

                                            <div class="control-group">
                                                <label for="description" class="control-label">Description :</label>

                                                <div class="controls">
                                                    <textarea name="description" id="description" rows="5"
                                                              class="input-block-level"><?php echo @$description; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary" id="btnSave">Save changes
                                            </button>
                                            <button type="button" class="btn" id="btnCancel">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- END: .box-content nopadding -->
                        <?php else:
                            $this->load->view("permission_page");
                        endif;?>
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
$this->load->view("footer");