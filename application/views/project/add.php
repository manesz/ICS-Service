<?php

$this->load->view("header");
$this->load->view("navigator_menu");
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$id = @$id ? $id : 0;
if ($id) {
    $arrProject = $this->Project_model->projectList($id);
    extract((array)$arrProject[0]);
    $pathFileManager = "uploads/project/$id/files/";
    $this->Helper_model->checkHaveFolder($pathFileManager, true);
}
$objCustomer = $this->Customer_model->customerList();
$windowClose = @$_GET['window'];
?>
    <script>
        var url_post_data = "<?php echo $webUrl; ?>project/<?php echo $id?"edit/$id":"add"; ?>";
        var url_list = "<?php echo $webUrl; ?>project";
        $(document).ready(function () {
            $('#btnCancel').click(function () {
                openUrl(<?php echo $windowClose=="close"?"'close'": "url_list"; ?>);
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
                        imagePatch: 'uploads/project/',
                        imageName: imageName
                    });
                    var urlRedirect = <?php echo $windowClose=="close"?"'close'": "url_list"; ?>;
                    postData(url_post_data, data, urlRedirect);
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
                    <h1><?php echo $id ? "Edit" : "Add" ?> Project</h1>
                </div>
            </div>
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="<?php echo $webUrl; ?>Dashboard">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl; ?>project">Project</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl;
                        ?>project/<?php echo $id ? "edit/$id" : "add"; ?>"><?php echo $id ? "Edit" : "Add" ?>
                            Project</a>
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
                                <i class="icon-list"></i> Project
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
                                                <div class="input-xlarge input-append">
                                                    <select name="customer_id" id="customer_id"
                                                            class='chosen-select'>
                                                        <option value=""></option>
                                                        <?php foreach ($objCustomer as $key => $value): ?>
                                                            <option <?php echo @$customer_id == $value->id ? 'selected' : ''; ?>
                                                                value="<?php echo $value->id; ?>"><?php echo $value->name_th; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <a class="btn"
                                                       onclick="openNewTab('<?php echo $webUrl; ?>customer/add?window=close');"
                                                       href="#"> New</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="name_th" class="control-label">Name TH :</label>

                                            <div class="controls">
                                                <input type="text" name="name_th" id="name_th" placeholder="Name"
                                                       class="input-xlarge" data-rule-required="true"
                                                       value="<?php echo @$name_th; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="name_en" class="control-label">Name EN :</label>

                                            <div class="controls">
                                                <input type="text" name="name_en" id="name_en" placeholder="Name"
                                                       class="input-xlarge"
                                                       value="<?php echo @$name_en; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="project_start" class="control-label">Project Start :</label>

                                            <div class="controls">
                                                <input type="text" name="project_start" id="project_start"
                                                       placeholder="Date"
                                                       class="input-xlarge datepick"
                                                       value="<?php echo @$project_start; ?>"
                                                       data-rule-required="true">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="project_end" class="control-label">Project End :</label>

                                            <div class="controls">
                                                <input type="text" name="project_end" id="project_end"
                                                       placeholder="Date"
                                                       class="input-xlarge datepick"
                                                       value="<?php echo @$project_end; ?>"
                                                       data-rule-required="true">
                                            </div>
                                        </div>
                                        <?php if ($id): ?>
                                            <div class="control-group">
                                                <div class="box">
                                                    <div class="box-title">
                                                        <h3><i class="icon-th"></i> Upload Image</h3>
                                                    </div>
                                                    <div class="box-content nopadding">
                                                        <div class="file-manager" id="status_deliverd"
                                                             data="<?php echo @$pathFileManager; ?>"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
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