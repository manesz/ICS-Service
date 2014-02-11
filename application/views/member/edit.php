<?php
$this->load->view("header");
$this->load->view("navigator_menu");
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();


$arrMember = $this->Member_model->memberList($id);
extract((array)$arrMember[0]);

$objModule = $this->Module_model->moduleList();
?>

    <script>
        var url_post_data = "<?php echo $webUrl; ?>member/memberEdit/<?php echo @$id; ?>";
        var urlList = "<?php echo $webUrl; ?>member";
        $(document).ready(function () {
            $('#btnCancel').click(function () {
                openUrl(urlList);
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
                imagePatch: 'uploads/member/',
                imageName: imageName
            });
            $.post(url_post_data, data,
                function (result) {
                    if (result == "add fail") {
                        alert('** เกิดข้อผิดพลาด');
                        enableID("btnSave");
                    } else {
                        openUrl(urlList);
                    }
                }
            );
        }
    </script>
<div class="container-fluid" id="content">

<?php
$this->load->view("sidebar_menu");
?>
    <div id="main">
        <div class="container-fluid">
            <div class="page-header">
                <div class="pull-left">
                    <h1>Edit Member</h1>
                </div>
            </div>
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a class="link" href="<?php echo $webUrl; ?>Dashboard">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a class="link" href="<?php echo $webUrl; ?>member">Member</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a class="link" href="#">Edit Member</a>
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
                                <i class="icon-list"></i> Member
                            </h3>
                        </div>
                        <!-- END: .box-title -->
                        <div class="box-content nopadding">
                            <form action="" method="POST"
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
                                    <div class="control-group">
                                        <label for="first_name" class="control-label">First Name :</label>

                                        <div class="controls">
                                            <input type="text" name="first_name" id="first_name"
                                                   placeholder="First Name"
                                                   class="input-block-level" value="<?php echo @$first_name; ?>"
                                                   data-rule-required="true">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="last_name" class="control-label">Last Name :</label>

                                        <div class="controls">
                                            <input type="text" name="last_name" id="last_name" placeholder="Last Name"
                                                   class="input-block-level" value="<?php echo @$last_name; ?>"
                                                   data-rule-required="true">
                                        </div>
                                    </div>
                                </div>
                                <!--END:span6 -->
                                <div class="span6">
                                    <div class="control-group">
                                        <label for="username" class="control-label">Username :</label>

                                        <div class="controls">
                                            <input type="text" name="username" id="username" placeholder="Username"
                                                   class="input-block-level" value="<?php echo @$username; ?>"
                                                   data-rule-required="true">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="password" class="control-label">Password</label>

                                        <div class="controls">
                                            <div class="input-xlarge">
                                                <input type="password" class='complexify-me input-block-level'
                                                       name="password" id="password" data-rule-required="true"
                                                       data-rule-minlength="4">
                                        <span class="help-block">
                                            <div class="progress progress-info">
                                                <div class="bar bar-red" style="width: 0%"></div>
                                            </div>
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="email" class="control-label">Email :</label>

                                        <div class="controls">
                                            <input type="text" name="email" id="email" placeholder="Email"
                                                   class="input-block-level" data-rule-email="true"
                                                   data-rule-required="true"
                                                   value="<?php echo @$email; ?>">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="telephone" class="control-label">Telephone :</label>

                                        <div class="controls">
                                            <input type="text" name="telephone" id="telephone" placeholder="Telephone"
                                                   class="input-block-level" data-rule-required="true"
                                                   value="<?php echo @$telephone; ?>">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="mobile" class="control-label">Mobile :</label>

                                        <div class="controls">
                                            <input type="text" name="mobile" id="mobile" placeholder="Mobile"
                                                   class="input-block-level" data-rule-required="true"
                                                   value="<?php echo @$mobile; ?>">
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
$this->load->view("footer");
?>