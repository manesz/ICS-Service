<?php

$this->load->view("header");
$this->load->view("navigator_menu");
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();

$arrIssue = $this->Issue_model->issueList($id);
extract((array)$arrIssue[0]);
?>
    <script>

        var url_post_data = "<?php echo $webUrl; ?>issue/issueEdit/<?php echo @$id; ?>";
        var url_list = "<?php echo $webUrl; ?>issue";
        $(document).ready(function () {
            $('#btnCancel').click(function () {
                openUrl(url_list);
                return false;
            });

            $("#formPost").submit(function () {
                disableID("btnSave");
                var checkPost = checkValidateForm("#formPost");
                if (checkPost) {
                    var dataImg = "";
                    if ($(".fileupload-preview").html() != "") {
                        dataImg = $(".fileupload-preview img").attr("src");
                    }
                    var data = $('#formPost').serialize();
                    var imageName = $("#imagefile").val();
                    data = data + '&' + $.param({
                        data_image: dataImg,
                        fileType: "image",
                        imagePatch: 'uploads/issue/',
                        imageName: imageName
                    });
                    postData(url_post_data, data, url_list);
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
                    <h1>Edit Issue</h1>
                </div>
            </div>
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a class="link" href="<?php echo $webUrl; ?>Dashboard">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a class="link" href="<?php echo $webUrl; ?>issue">Issue</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a class="link" href="#">Edit Issue</a>
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
                                <i class="icon-list"></i> Issue
                            </h3>
                        </div>
                        <!-- END: .box-title -->
                        <?php if (@$permission): ?>
                            <div class="box-content nopadding">
                                <form action="" method="POST" autocomplete="off"
                                      class='form-horizontal form-column form-bordered form-validate'
                                      id="formPost" name="formPost">

                                    <div class="span6">
                                        <div class="control-group">
                                            <input type="hidden" id="image_path" name="image_path"
                                                   value="<?php echo !file_exists(@$image) ? "" : $image; ?>"/>
                                            <label for="image" class="control-label">Image</label>

                                            <div class="controls">
                                                <div class="fileupload fileupload-new" id="image"
                                                     data-provides="fileupload">
                                                    <div id="imgThumbnail" class="fileupload-new thumbnail"
                                                         style="width: 200px; height: 150px;">
                                                        <img src="<?php
                                                        echo !file_exists(@$image) ? $baseUrl . "assets/img/no_img.gif" :
                                                            $baseUrl . $image;
                                                        ?>"/>
                                                    </div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail"
                                                         style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                    <div>
                                            <span id="groupBtn"
                                                  class="btn btn-file <?php echo !file_exists(@$image) ? "" : 'hide'; ?>">
                                                <span class="fileupload-new">Select image</span>
                                                <span class="fileupload-exists">Change</span>
                                                <input type="file" name='imagefile' id="imagefile"/>
                                            </span>
                                                        <?php if (file_exists(@$image)): ?>
                                                            <input type="button" id="btnDeleteImage"
                                                                   onclick="removeImage('<?php echo $image; ?>');"
                                                                   class="btn"
                                                                   value="Remove">
                                                        <?php endif; ?>
                                                        <a href="#" class="btn fileupload-exists"
                                                           data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--END:span6 -->
                                    <div class="span6">
                                        <div class="control-group">
                                            <label for="name" class="control-label">Name :</label>

                                            <div class="controls">
                                                <input type="text" name="name" id="name" placeholder="Name"
                                                       class="input-block-level" data-rule-required="true"
                                                       value="<?php echo @$name; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="model" class="control-label">Model :</label>

                                            <div class="controls">
                                                <input type="text" name="model" id="model" placeholder="Model"
                                                       class="input-block-level" value="<?php echo @$model; ?>"
                                                       data-rule-required="true">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="brand" class="control-label">Brand :</label>

                                            <div class="controls">
                                                <input type="text" name="brand" id="brand" placeholder="Brand"
                                                       class="input-block-level" data-rule-required="true"
                                                       value="<?php echo @$brand; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="type" class="control-label">Type :</label>

                                            <div class="controls">
                                                <input type="text" name="type" id="type" placeholder="Type"
                                                       class="input-block-level" data-rule-required="true"
                                                       value="<?php echo @$type; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="datesheet" class="control-label">Date Sheet :</label>

                                            <div class="controls">
                                                <input type="text" name="datesheet" id="datesheet"
                                                       placeholder="Date input"
                                                       class="input-block-level datepick" data-rule-required="true"
                                                       data-rule-dateiso="true" value="<?php echo @$datesheet; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span12">
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary" id="btnSave">Save changes
                                            </button>
                                            <button type="button" class="btn" id="btnCancel">Cancel</button>
                                        </div>
                                    </div>
                                    <!--END:span6 -->

                                </form>
                            </div>
                            <!-- END: .box-content nopadding -->
                        <?php else:
                            $this->load->view("permission_page");
                        endif;
                        ?>
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
?>