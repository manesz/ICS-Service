<?php
$this->load->view("header");
$this->load->view("navigator_menu");
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();


$memberId = @$this->session->userdata['id'];
$usernameLogin = @$this->session->userdata['username'];
$companyIDLogin = @$this->session->userdata['company_id'];

$arrDepartment = $this->Department_model->departmentList();
$arrPosition = $this->Position_model->positionList();
$arrCompany = $this->Company_model->companyList();

$arrMember = $this->Member_model->memberList($id);
extract((array)$arrMember[0]);

$objModule = $this->Module_model->moduleList();

$permissionUpdate = $this->Module_model->checkModuleByPermission("Users", 2);

$checkEditUser = false;
if ($usernameLogin == 'admin' || $companyIDLogin == 1) {
    $checkEditUser = true;
}
?>

    <script>
        var url_post_data = "<?php echo $webUrl; ?>member/edit/<?php echo $id; ?>";
        var url_list = "<?php echo $webUrl; ?>member";
        var url_edit_module = "<?php echo $webUrl; ?>member/memberSetModule/<?php echo $id; ?>";
        var url_check_duplicate = "<?php echo $webUrl; ?>member/memberCheckDuplicate/";
        var old_username = "<?php echo @$username; ?>";
        $(document).ready(function () {
            $("#btnCancel1").click(function () {
                openUrl(url_list);
                return false;
            });

            $("#btnFinish").click(function () {
                openUrl(url_list);
                return false;
            });

            $("#formPost").submit(function () {
                disableID("btnSave1");
                var checkPost = checkValidateForm("#formPost");
                if (checkPost) {
                    postData();
                } else {
                    enableID("btnSave1");
                }
                return false;
            });

            $("#username").focus();
            $("#username").keyup(function () {
                checkUsername();
            });
            $("#username").change(function () {
                checkUsername();
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
            showWaitImage();
            $.post(url_post_data, data,
                function (result) {
                    if (result == "edit fail") {
                        clickNotifyError('เกิดข้อผิดพลาด**');
                        enableID("btnSave1");
                        hideWaitImage();
                    } else {
                        clickNotifyUpdate();
                        enableID("btnSave1");
                        <?php if (@$id == $memberId):?>
                        openUrl(window.location.href);
                        <?php else: ?>
                        openUrl(url_list);
                        <?php endif;?>
                    }
                }
            )
                .done(function () {
                    //alert("second success");
                })
                .fail(function () {
                    clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
                    hideWaitImage();
                })
                .always(function () {
                    //alert("finished");
                });
        }

        function setValueModuleAll(id) {
            var checkValue = true;
            var checkAll = document.getElementById('cbModuleAll_' + id).checked;
            if (!checkAll) {
                checkValue = false;
            }
            var rows = document.getElementsByClassName('cbModule_' + id);
            for (var i = 0, l = rows.length; i < l; i++) {
                rows[i].checked = checkValue;
            }
            postDataSetPermission(id);
            return true;
        }

        function setValueModule(id) {
            postDataSetPermission(id);
            return true;
        }

        function postDataSetPermission(id) {
            disableID("btnFinish");
            var rows = document.getElementsByClassName('cbModule_' + id);
            var permission = [];
            for (var i = 0, l = rows.length; i < l; i++) {
                if (rows[i].checked) {
                    permission.push(1);
                } else {
                    permission.push(0);
                }
            }
            var strPermission = "" + permission;
            $.post(url_edit_module, {
                module_id: id,
                permission: strPermission
            }, function (result) {
                if (result == "edit fail") {
                    clickNotifyError('เกิดข้อผิดพลาด**');
                } else {
                    clickNotifyUpdate();
                }
                enableID("btnFinish");

            })
                .done(function () {
                    //alert("second success");
                })
                .fail(function () {
                    clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
                    enableID("btnFinish");
                })
                .always(function () {
                    //alert("finished");
                });
        }
        function checkUsername() {
            var uValue = $("#username").val().toLowerCase();
            $("#controlUsername .controls .help-block").remove();
            $("#controlUsername .controls").append(
                '<span class="help-block"><i class="icon-spinner icon-spin"></i> Checking availability...</span>'
            );
            if (uValue.length < 4) {
                $("#controlUsername .controls .help-block").remove();
                $("#controlUsername").removeClass("success");
                $("#controlUsername").addClass("error");
                $("#controlUsername .controls").append(
                    '<span for="username" class="help-block error">Please enter at least 4 characters.</span>'
                );
                $("#username").focus();
            } else if (uValue.indexOf("admin") > -1 && old_username != $("#username").val()) {
                $("#controlUsername .controls .help-block").remove();
                $("#controlUsername").removeClass("success");
                $("#controlUsername").addClass("error");
                $("#controlUsername .controls").append(
                    '<span class="help-block"><i class="icon-remove"></i> Username not available!</span>'
                );
                $("#username").focus();
                return false;
            }
            else {
                $.post(url_check_duplicate, {
                    username: $("#username").val()
                }, function (result1) {
                    $("#controlUsername .controls .help-block").remove();
                    if (result1 == "false" && old_username != $("#username").val()) {
                        $("#controlUsername").removeClass("success");
                        $("#controlUsername").addClass("error");
                        $("#controlUsername .controls").append(
                            '<span class="help-block"><i class="icon-remove"></i> Username not available!</span>'
                        );
                        $("#username").focus();
                    } else {
                        $("#controlUsername").removeClass("error");
                        $("#controlUsername").addClass("success");
                        $("#controlUsername .controls").append(
                            '<span class="help-block"><i class="icon-ok"></i> Username is available!</span>'
                        );
                    }
                })
                    .done(function () {
                        //alert("second success");
                    })
                    .fail(function () {
                        clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
                    })
                    .always(function () {
                        //alert("finished");
                    });
            }
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
                <a href="<?php echo $webUrl; ?>Dashboard">Home</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="<?php echo $webUrl; ?>member">Member</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="<?php echo $webUrl; ?>member/edit/<?php echo $id; ?>">Edit Member</a>
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

    <?php if (@$permission || $memberId == $id || $usernameLogin == "admin"): ?>

    <div class="box-content nopadding">
    <ul class="tabs tabs-inline tabs-top">
        <li class='active' id="liPorfile">
            <a href="#profile" data-toggle='tab'><i class="icon-user"></i> Profile</a>
        </li>
        <?php if ($permissionUpdate || $usernameLogin == 'admin'): ?>
            <li id="liModulePermission">
                <a href="#module_permission" data-toggle='tab'><i class="icon-lock"></i> Module Permission</a>
            </li>
        <?php endif; ?>
    </ul>
    <div class="tab-content tab-content-top tab-content-inline tab-content-bottom nopadding"
         style="margin-top: 20px !important;">
    <div class="tab-pane active" id="profile">
    <form action="#" method="POST" autocomplete="off"
          class='form-horizontal form-column form-bordered form-validate'
          id="formPost" name="formPost">
    <input type="hidden" name="employee_number" id="employee_number" value="<?php echo $employee_number; ?>">
    <input type="hidden" name="user_group" id="user_group" value="<?php echo $user_group; ?>">

    <div class="span6">
        <div class="control-group">
            <input type="hidden" id="image_path" name="image_path"
                   value="<?php echo !file_exists(@$image_path) ? "" : $image_path; ?>"/>
            <label for="image" class="control-label">Image</label>

            <div class="controls">
                <div class="fileupload fileupload-new" id="image" data-provides="fileupload">
                    <div id="imgThumbnail" class="fileupload-new thumbnail"
                         style="width: 200px; height: 150px;">
                        <img src="<?php
                        echo !file_exists(@$image_path) ? $baseUrl . "assets/img/no_img.gif" :
                            $baseUrl . $image_path;
                        ?>"/>
                    </div>
                    <div class="fileupload-preview fileupload-exists thumbnail"
                         style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                    <div>
                                            <span id="groupBtn"
                                                  class="btn btn-file <?php echo !file_exists(@$image_path) ? "" : 'hide'; ?>">
                                                <span class="fileupload-new">Select image</span>
                                                <span class="fileupload-exists">Change</span>
                                                <input type="file" name='imagefile' id="imagefile"/>
                                            </span>
                        <?php if (file_exists(@$image_path)): ?>
                            <input type="button" id="btnDeleteImage"
                                   onclick="removeImage('<?php echo $image_path; ?>');" class="btn"
                                   value="Remove">
                        <?php endif; ?>
                        <a href="#" class="btn fileupload-exists"
                           data-dismiss="fileupload">Remove</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="control-group" id="controlUsername">
            <label for="textfield" class="control-label">Username</label>

            <div class="controls">
                <?php if ($checkEditUser): ?>
                    <div class="input-append">
                        <input type="text" id="username" name="username" autocomplete="off"
                               value="<?php echo $username; ?>">
                        <a href="javascript:checkUsername();" class="btn add-on"><i class="icon-refresh"></i></a>

                    </div>
                    <span class="help-block">
                            Please enter a username
                        </span>
                <?php else : ?>
                    <?php echo $username; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="control-group">
            <label for="password" class="control-label">Password</label>

            <div class="controls">
                <div class="input-xlarge">
                    <input type="password" class='complexify-me input-block-level'
                           name="password" id="password"
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
            <label for="firstname" class="control-label">First name</label>

            <div class="controls">
                <input type="text" name="firstname" id="firstname" placeholder="First name"
                       class="input-xlarge" value="<?php echo $firstname; ?>"
                       data-rule-required="true" data-rule-minlength="2">
            </div>
        </div>
        <div class="control-group">
            <label for="lastname" class="control-label">Last name</label>

            <div class="controls">
                <input type="text" name="lastname" id="lastname" placeholder="Last name"
                       class="input-xlarge" value="<?php echo $lastname; ?>"
                       data-rule-required="true" data-rule-minlength="2">
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="prefix" class="control-label">Prefix</label>

            <div class="controls">
                <select name="prefix" id="prefix" data-rule-required="true">
                    <option value=""></option>
                    <option <?php echo $prefix == 'Mr.' ? "selected" : ""; ?> value="Mr.">Mr.</option>
                    <option <?php echo $prefix == 'Ms.' ? "selected" : ""; ?> value="Ms.">Ms.</option>
                    <option <?php echo $prefix == 'Miss' ? "selected" : ""; ?> value="Miss">Miss</option>
                    <option <?php echo $prefix == 'Mrs.' ? "selected" : ""; ?> value="Mrs.">Mrs.</option>
                </select>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">Gender</label>

            <div class="controls">
                <label for="gender1" class="radio">
                    <input id="gender1" name="gender" type="radio" value=""
                           onclick="$('#gender').val('0');"
                        <?php echo $gender == 0 ? "checked" : ""; ?>
                           data-rule-required="true"/>Man</label>
                <label for="gender2" class="radio">
                    <input id="gender2" name="gender" type="radio" value=""
                           onclick="$('#gender').val('1');"
                        <?php echo $gender == 1 ? "checked" : ""; ?>
                           data-rule-required="true"/>Women</label>

                <input type="hidden" value="" id="gender">
            </div>
        </div>
        <div class="control-group">
            <label for="age" class="control-label">Age</label>

            <div class="controls">
                <input type="text" name="age" id="age" placeholder="Age"
                       class="input-xlarge" value="<?php echo $age; ?>"
                       data-rule-number="true" data-rule-required="true"/>
            </div>
        </div>
        <div class="control-group">
            <label for="company_id" class="control-label">Company</label>

            <div class="controls">
                <?php if ($checkEditUser): ?>
                    <select name="company_id" id="company_id" data-rule-required="true">
                        <option value=""></option>
                        <?php foreach ($arrCompany as $key => $value): ?>
                            <option value="<?php echo $value->id; ?>"
                                <?php echo @$company_id == $value->id ? 'selected' : '' ?>><?php echo $value->name_th; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <?php foreach ($arrCompany as $key => $value): ?>
                        <?php echo @$company_id == $value->id ? $value->name_th : ""; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="control-group">
            <label for="department_id" class="control-label">Department</label>

            <div class="controls">
                <?php if ($checkEditUser): ?>
                    <select name="department_id" id="department_id" data-rule-required="true">
                        <option value=""></option>
                        <option value="0" <?php echo $department_id == 0 ? 'selected' : '' ?>>-</option>
                        <?php foreach ($arrDepartment as $key => $value): ?>
                            <option value="<?php echo $value->id; ?>"
                                <?php echo @$department_id == $value->id ? 'selected' : '' ?>
                                ><?php echo $value->title; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <?php echo $department_id == 0 ? '-' : '' ?>
                    <?php foreach ($arrDepartment as $key => $value): ?>
                        <?php echo @$department_id == $value->id ? $value->name_th : ""; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="control-group">
            <label for="phone" class="control-label">Phone</label>

            <div class="controls">
                <input type="text" name="phone" id="phone" placeholder="Phone"
                       class="input-xlarge" value="<?php echo $phone; ?>">
            </div>
        </div>
        <div class="control-group">
            <label for="position_id" class="control-label">Position</label>

            <div class="controls">
                <?php if ($checkEditUser): ?>
                    <select name="position_id" id="position_id" data-rule-required="true">
                        <option value=""></option>
                        <option value="0" <?php echo $position_id == 0 ? 'selected' : '' ?>>-</option>
                        <?php foreach ($arrPosition as $key => $value): ?>
                            <option value="<?php echo $value->id; ?>"
                                <?php echo $position_id == $value->id ? 'selected' : '' ?>><?php echo $value->title; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <?php echo @$position_id == 0 ? '-' : '' ?>
                    <?php foreach ($arrPosition as $key => $value): ?>
                        <?php echo @$position_id == $value->id ? $value->name_th : ""; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="control-group">
            <label for="mobile" class="control-label">Mobile</label>

            <div class="controls">
                <input type="text" name="mobile" id="mobile" placeholder="Mobile"
                       class="input-xlarge" value="<?php echo $mobile; ?>">
            </div>
        </div>
        <div class="control-group">
            <label for="email" class="control-label">Email</label>

            <div class="controls">
                <input type="text" name="email" id="email" placeholder="Email"
                       class="input-xlarge" value="<?php echo $email; ?>"
                       data-rule-required="true">
            </div>
        </div>
    </div>
    <div class="span12">
        <div class="control-group">
            <label for="address" class="control-label">Address</label>

            <div class="controls">
                <textarea name="address" id="address" rows="5"
                          class="input-block-level"><?php echo $address; ?></textarea>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" id="btnSave1" class="btn btn-primary">Save</button>
            <button type="button" id="btnCancel1" class="btn">Cancel</button>
        </div>
    </div>
    </form>
    </div>

    <div class="tab-pane" id="module_permission">
        <form id="formPost2" name="formPost2" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
            <div class="row-fluid">
                <style>
                    .cbInLine {
                        display: inline-block;
                        margin-left: 5px;
                    }
                </style>
                <div class="span12">
                    <?php foreach ($objModule as $key => $value): ?>
                        <?php
                        $dataPermission = $this->Permission_model->checkPermission($id, $value->id);
                        $dataPermission = $dataPermission[0];
                        $arrCheck = explode(',', @$dataPermission->permission);
                        if (@$dataPermission->permission == @$this->Module_model->getStrCheckAll()) {
                            $checkBoxAll = "checked";
                        } else {
                            $checkBoxAll = "";
                        }
                        ?>
                        <fieldset>
                            <div class="box box-color orange box-small box-bordered span11">
                                <div class="box-title">
                                    <h3>
                                        <i class="glyphicon-keys"></i>
                                        Module : <?php echo $value->title; ?>
                                    </h3>
                                </div>
                            </div>
                            <!--                            <legend>Module : --><?php //echo $value->title; ?>
                            <!--                            </legend>-->
                            <!--หน้าสลับลำดับ-->
                            <div class="span12">
                                <input type="checkbox" id="cbModuleAll_<?php echo $value->id; ?>"
                                    <?php echo $checkBoxAll; ?>
                                       onclick="return setValueModuleAll(<?php echo $value->id; ?>);">
                                <label class="cbInLine" for="cbModuleAll_<?php echo $value->id; ?>">All</label>
                            </div>
                            <div class="span12">
                                <div class="span2">
                                    <input id="list_<?php echo $value->id; ?>" type="checkbox"
                                           class="cbModule_<?php echo $value->id; ?>"
                                        <?php echo @$arrCheck[0] == "1" ? "checked" : ""; ?>
                                           onclick="return setValueModule(<?php echo $value->id; ?>);">
                                    <label class="cbInLine" for="list_<?php echo $value->id; ?>">list</label>
                                </div>
                                <div class="span2">
                                    <input id="insert_<?php echo $value->id; ?>" type="checkbox"
                                           class="cbModule_<?php echo $value->id; ?>"
                                        <?php echo @$arrCheck[1] == "1" ? "checked" : ""; ?>
                                           onclick="return setValueModule(<?php echo $value->id; ?>);">
                                    <label class="cbInLine" for="insert_<?php echo $value->id; ?>">insert</label>
                                </div>
                                <div class="span2">
                                    <input id="update_<?php echo $value->id; ?>" type="checkbox"
                                           class="cbModule_<?php echo $value->id; ?>"
                                        <?php echo @$arrCheck[2] == "1" ? "checked" : ""; ?>
                                           onclick="return setValueModule(<?php echo $value->id; ?>);">
                                    <label class="cbInLine" for="update_<?php echo $value->id; ?>">update</label>
                                </div>
                            </div>
                            <div class="span12">
                                <div class="span2">
                                    <input id="delete_<?php echo $value->id; ?>" type="checkbox"
                                           class="cbModule_<?php echo $value->id; ?>"
                                        <?php echo @$arrCheck[3] == "1" ? "checked" : ""; ?>
                                           onclick="return setValueModule(<?php echo $value->id; ?>);">
                                    <label class="cbInLine" for="delete_<?php echo $value->id; ?>">delete</label>
                                </div>
                                <div class="span2">
                                    <input id="report1_<?php echo $value->id; ?>" type="checkbox"
                                           class="cbModule_<?php echo $value->id; ?>"
                                        <?php echo @$arrCheck[4] == "1" ? "checked" : ""; ?>
                                           onclick="return setValueModule(<?php echo $value->id; ?>);">
                                    <label class="cbInLine" for="report1_<?php echo $value->id; ?>">report 1</label>
                                </div>
                                <div class="span2">
                                    <input id="report2_<?php echo $value->id; ?>" type="checkbox"
                                           class="cbModule_<?php echo $value->id; ?>"
                                        <?php echo @$arrCheck[5] == "1" ? "checked" : ""; ?>
                                           onclick="return setValueModule(<?php echo $value->id; ?>);">
                                    <label class="cbInLine" for="report2_<?php echo $value->id; ?>">report 2</label>
                                </div>
                            </div>
                            <div class="span12">
                                <div class="span2">
                                    <input id="report3_<?php echo $value->id; ?>" type="checkbox"
                                           class="cbModule_<?php echo $value->id; ?>"
                                        <?php echo @$arrCheck[6] == "1" ? "checked" : ""; ?>
                                           onclick="return setValueModule(<?php echo $value->id; ?>);">
                                    <label class="cbInLine" for="report3_<?php echo $value->id; ?>">report 3</label>
                                </div>
                            </div>
                        </fieldset>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="span12">
                <div class="form-actions">
                    <button type="button" class="btn btn-primary" id="btnFinish">Finish</button>
                </div>
            </div>
        </form>
    </div>
    </div>
    </div>
    </div>
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