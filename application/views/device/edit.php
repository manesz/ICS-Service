<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();

$arrDevice = $this->Device_model->deviceList($id);
extract((array)$arrDevice[0]);
?>
<script>

    var url_post_data = "<?php echo $webUrl; ?>device/deviceEdit/<?php echo @$id; ?>";
    var urlList = "<?php echo $webUrl; ?>device/deviceList";
    $(document).ready(function () {
        $('#btnCancel').click(function () {
            innerHtml('#main', urlList);
            return false;
        });

        $("#formPost").submit(function () {
            disableID("btnSave");
            var checkPost = checkValidateForm("#formPost");
            if (checkPost) {
                postData();
            } else {
                enableID("btnSave");
            }
            return false;
        });
    });

    function postData() {
        var dataImg = "";
        if ($(".fileupload-preview").html() != "") {
            dataImg = $(".fileupload-preview img").attr("src");
        }
        var data = $('#formPost').serialize();
        var imageName = $("#imagefile").val();
        data = data + '&' + $.param({
            data_image: dataImg,
            fileType: "image",
            imagePatch: 'uploads/device/',
            imageName: imageName
        });
        $.post(url_post_data, data,
            function (result) {
                if (result == "add fail") {
                    alert('** เกิดข้อผิดพลาด');
                    enableID("btnSave");
                } else {
                    innerHtml('#main', urlList);
                }
            }
        );
    }
</script>
<div class="container-fluid">
    <div class="page-header">
        <div class="pull-left">
            <h1>DEVICE</h1>
        </div>
    </div>
    <!-- END: .page-header -->
</div>
<!-- END:.container-fluid -->

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="<?php echo $webUrl; ?>dashboard">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl; ?>device">DEVICE</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">EDIT DEVICE</a>
                    </li>
                </ul>
                <div class="close-bread">
                    <a href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <!-- END: ,breadcrumbs -->
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="box box-color box-bordered">
                <div class="box-content nopadding">
                    <form action="" method="POST"
                          class='form-horizontal form-column form-bordered form-validate'
                          id="formPost" name="formPost">
                        <div class="box-title">
                            <h3>
                                <i class="icon-list"></i> EDIT DEVICE
                            </h3>
                        </div>
                        <!-- END: .box-title -->

                        <div class="span6">
                            <div class="control-group">
                                <input type="hidden" id="image_path" name="image_path"
                                       value="<?php echo !file_exists(@$image) ? "" : $image; ?>"/>
                                <label for="image" class="control-label">Image</label>

                                <div class="controls">
                                    <div class="fileupload fileupload-new" id="image" data-provides="fileupload">
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
                                                       onclick="removeImage('<?php echo $image; ?>');" class="btn"
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
                                           class="input-block-level" data-rule-email="true" data-rule-required="true"
                                           value="<?php echo @$name; ?>">
                                </div>
                            </div>
                            <div class="control-group">
                                <label for="model" class="control-label">Model :</label>

                                <div class="controls">
                                    <input type="text" name="model" id="model" placeholder="Model"
                                           class="input-block-level" value="<?php echo @$model; ?>">
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
                                <button type="submit" class="btn btn-primary" id="btnSave">Save changes</button>
                                <button type="button" class="btn" id="btnCancel">Cancel</button>
                            </div>
                        </div>
                        <!--END:span6 -->

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>