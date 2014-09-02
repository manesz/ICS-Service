<?php

$this->load->view("header");
$this->load->view("navigator_menu");
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();

$objCustomer = $this->Customer_model->customerList();
if (@$id) {
    $objData = $this->Contact_model->contactList($id);
    extract((array)$objData[0]);
} else {
    $id = 0;
}
?>
    <script>

        var url_post_data = "<?php echo $webUrl; ?>contact/<?php echo $id?"edit/$id":"add"; ?>";
        var url_list = "<?php echo $webUrl; ?>contact";
        $(document).ready(function () {
            $('#btnCancel').click(function () {
                openUrl(url_list);
                return false;
            });

            $("#form_post_contact").submit(function () {
                disableID("btnSave");
                var checkPost = checkValidateForm("#form_post_contact");
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
                        imagePatch: 'uploads/contact/',
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
                    <h1><?php echo $id ? "Edit" : "Add" ?> Contact</h1>
                </div>
            </div>
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="<?php echo $webUrl; ?>Dashboard">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl; ?>contact">Contact</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl; ?>contact/<?php echo $id ? "edit/$id" : "add"; ?>"
                            ><?php echo $id ? "Edit" : "Add" ?> Contact</a>
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
                                <i class="icon-list"></i> <?php echo $id ? "Edit" : "Add" ?> Contact
                            </h3>
                        </div>
                        <!-- END: .box-title -->
                        <?php if (@$permission): ?>
                            <div class="box-content nopadding">
                                <form action="" method="POST" autocomplete="off"
                                      class='form-horizontal form-column form-bordered form-validate'
                                      id="form_post_contact" name="form_post_contact">

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
                                            <label for="customer_id" class="control-label">Customer</label>

                                            <div class="controls">
                                                <div class="input-xlarge">
                                                    <select name="customer_id" id="customer_id" class='chosen-select'>
                                                        <option value=""></option>
                                                        <?php foreach ($objCustomer as $key => $value): ?>
                                                            <option value="<?php echo $value->id; ?>"
                                                                <?php echo $value->id == @$customer_id ? 'selected' : ''; ?>
                                                                ><?php if ($value->name_th != "" && $value->name_th != "-") {
                                                                    echo $value->name_th;
                                                                } else echo $value->name_en ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="name_th" class="control-label">ชื่อภาษาไทย :</label>

                                            <div class="controls">
                                                <input type="text" name="name_th" id="name_th" placeholder="Text input"
                                                       class="input-xlarge" value="<?php echo @$name_th; ?>"
                                                    >
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="name_en" class="control-label">ชื่อภาษาอังกฤษ :</label>

                                            <div class="controls">
                                                <input type="text" name="name_en" id="name_en" placeholder="Text input"
                                                       class="input-xlarge" value="<?php echo @$name_en; ?>"
                                                    >
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="email" class="control-label">Email :</label>

                                            <div class="controls">
                                                <input type="text" name="email" id="email" placeholder="Text input"
                                                       class="input-xlarge" value="<?php echo @$email; ?>"
                                                       data-rule-email="true"></div>
                                        </div>
                                        <div class="control-group">
                                            <label for="mobile" class="control-label">Mobile :</label>

                                            <div class="controls">
                                                <input type="text" name="mobile" id="mobile"
                                                       placeholder="Text input"
                                                       class="input-xlarge"
                                                       value="<?php echo @$mobile; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="position" class="control-label">ตำแหน่ง :</label>

                                            <div class="controls">
                                                <input type="text" name="position" id="position"
                                                       placeholder="Text input"
                                                       class="input-xlarge"
                                                       maxlength="120"
                                                       value="<?php echo @$position; ?>">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="description" class="control-label">รายละเอียด :</label>

                                            <div class="controls">
                                                <textarea id="description" name="description"
                                                          class="input-xlarge"><?php echo @$description; ?></textarea>
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
?>