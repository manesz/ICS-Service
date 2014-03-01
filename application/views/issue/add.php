<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();

$this->load->view("header");
$this->load->view("navigator_menu");
?>
    <script>

        var url_post_data = "<?php echo $webUrl; ?>issue/issueAdd";
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
                    var data = $(this).serialize();
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
        window.CKEDITOR.disableAutoInline = true;
//        window.CKEDITOR.inline('description');
        CKEDITOR.replace('description');
    </script>
<div class="container-fluid" id="content">

<?php
$this->load->view("sidebar_menu");
?>
    <div id="main">
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>New Issue</h1>
                </div>
            </div>
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a class="link" href="<?php echo $webUrl; ?>dashboard">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a class="link" href="<?php echo $webUrl; ?>issue">Issue</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a class="link" href="#">New Issue</a>
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
                                    <div class="span12">
                                        <div class="control-group">
                                            <label for="name" class="control-label">Title :</label>

                                            <div class="controls">
                                                <input type="text" name="title" id="title" placeholder="Title"
                                                       class="input-block-level" data-rule-required="true">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="description" class="control-label">Description :</label>

                                            <div class="controls">
                                                <textarea name="description" id="description" rows="5"
                                                          class="input-block-level"
                                                          data-rule-required="true"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label for="image" class="control-label">Image1: </label>

                                            <div class="controls">
                                                <div class="fileupload fileupload-new" id="image"
                                                     data-provides="fileupload">
                                                    <div class="fileupload-new thumbnail"
                                                         style="width: 200px; height: 150px;">
                                                        <img src="<?php echo $baseUrl; ?>assets/img/no_img.gif"/>
                                                    </div>
                                                    <div class="fileupload-preview fileupload-exists thumbnail"
                                                         style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                    <div>
                                                        <span class="btn btn-file">
                                                            <span class="fileupload-new">Select image</span>
                                                            <span class="fileupload-exists">Change</span>
                                                            <input type="file" id="imagefile" name='imagefile'/>
                                                        </span>
                                                        <a href="#" class="btn fileupload-exists"
                                                           data-dismiss="fileupload">Remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label for="name" class="control-label">Title Image1 :</label>

                                            <div class="controls">
                                                <input type="text" name="title" id="title" placeholder="Title"
                                                       class="input-block-level" data-rule-required="true">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="description" class="control-label">Description1 :</label>

                                            <div class="controls">
                                                <textarea name="description" id="description" rows="5"
                                                          class="input-block-level"></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="span12">
                                        <div class="form-actions">
                                            <button type="button" class="btn btn-inverse" id="btnAddOtherImage">Add
                                                Other Image
                                            </button>
                                        </div>
                                    </div>
                                    <div class="span12">
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary" id="btnSave">Add</button>
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