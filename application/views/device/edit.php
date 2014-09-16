<?php

$this->load->view("header");
$this->load->view("navigator_menu");
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();

$arrDevice = $this->Device_model->deviceList($id);
extract((array)$arrDevice[0]);
$pathFileManager = "uploads/device/$id/files/";
$this->Helper_model->checkHaveFolder($pathFileManager, true);
$objCustomer = $this->Customer_model->customerList();
?>
    <script>
        var url_post_data = "<?php echo $webUrl; ?>device/edit/<?php echo @$id; ?>";
        var url_list = "<?php echo $webUrl; ?>device";
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
                        imagePatch: 'uploads/device/',
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
                    <h1>Edit Device</h1>
                </div>
            </div>
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="<?php echo $webUrl; ?>Dashboard">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl; ?>device">Device</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl; ?>device/edit/<?php echo $id; ?>">Edit Device</a>
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
                                <i class="icon-list"></i> Device
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
                                        <div class="control-group">
                                            <label for="customer_id" class="control-label">Customer :</label>

                                            <div class="controls">
                                                <div class="input-xlarge">
                                                    <select name="customer_id" id="customer_id"
                                                            class='chosen-select'>
                                                        <option value=""></option>
                                                        <?php foreach ($objCustomer as $key => $value): ?>
                                                            <option <?php echo @$customer_id == $value->id ? 'selected' : ''; ?>
                                                                value="<?php echo $value->id; ?>"><?php echo $value->name_th; ?></option>
                                                        <?php endforeach; ?>
                                                        <option
                                                            <?php echo @$customer_id == 0 ? 'selected' : ''; ?>
                                                            value="0">No Customer</option>
                                                    </select></div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="name" class="control-label">Name :</label>

                                            <div class="controls">
                                                <input type="text" name="name" id="name" placeholder="Name"
                                                       class="input-xlarge" data-rule-required="true"
                                                       value="<?php echo @$name; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="serial" class="control-label">Serial :</label>

                                            <div class="controls">
                                                <input type="text" name="serial" id="serial" placeholder="Serial"
                                                       class="input-xlarge" value="<?php echo @$serial; ?>"
                                                       data-rule-required="true">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="model" class="control-label">Model :</label>

                                            <div class="controls">
                                                <input type="text" name="model" id="model" placeholder="Model"
                                                       class="input-xlarge" value="<?php echo @$model; ?>"
                                                       data-rule-required="true">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="brand" class="control-label">Brand :</label>

                                            <div class="controls">
                                                <input type="text" name="brand" id="brand" placeholder="Brand"
                                                       class="input-xlarge" data-rule-required="true"
                                                       value="<?php echo @$brand; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="type" class="control-label">Type :</label>

                                            <div class="controls">
                                                <input type="text" name="type" id="type" placeholder="Type"
                                                       class="input-xlarge" data-rule-required="true"
                                                       value="<?php echo @$type; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="datesheet" class="control-label">Date Sheet :</label>

                                            <div class="controls">
                                                <input type="text" name="datesheet" id="datesheet"
                                                       placeholder="Date input"
                                                       class="input-xlarge datepick" data-rule-required="true"
                                                       data-rule-dateiso="true" value="<?php echo @$datesheet; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="remark" class="control-label">รายละเอียด :</label>

                                            <div class="controls">
                                                <textarea id="remark" name="remark"
                                                          class="input-xlarge"><?php echo @$remark; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="box">
                                                <div class="box-title">
                                                    <h3><i class="icon-th"></i> Upload Image</h3>
                                                </div>
                                                <div class="box-content nopadding">
                                                    <div class="file-manager" id="status_deliverd"
                                                         data="<?php echo "$pathFileManager"; ?>"></div>
                                                </div>
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
                        <?php
                        else:
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