<?php
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();

$this->load->view("header");
$this->load->view("navigator_menu");

$objDepartment = $this->Department_model->departmentList();
$objPosition = $this->Position_model->positionList();
$objCompany = $this->Company_model->companyList();

$objModule = $this->Module_model->moduleList();
$permissionUpdate = $this->Module_model->checkModuleByPermission("Users", 2);
?>

    <script>
    var url_post_data = "<?php echo $webUrl; ?>member/add";
    var url_list = "<?php echo $webUrl; ?>member";
    var url_edit_module = "<?php echo $webUrl; ?>member/memberSetModule/";
    var url_check_duplicate = "<?php echo $webUrl; ?>member/memberCheckDuplicate/";
    var memberID = 0;
    var bCheckMember = false;
    $(document).ready(function () {
        $("#btnCancel1").click(function () {
            openUrl(url_list);
            return false;
        });

        $("#btnSave2").click(function () {
            if (memberID == 0) {
                clickNotifyError("กรุณาสร้าง Profile ก่อน");
                $("#liPorfile").addClass("active");
                $("#liModulePermission").removeClass("active");

                $("#profile").addClass("active");
                $("#module_permission").removeClass("active");
            } else {
                openUrl(url_list);
            }
            return false;
        });

        $("#btnCancel2").click(function () {
            openUrl(url_list);
            return false;
        });

        $("#formPost").submit(function () {
            disableID("btnSave1");
            disableID("btnCancel1");
            var checkPost = checkValidateForm("#formPost");
            if (checkPost) {
                postNewData();
            } else {
                enableID("btnSave1");
                enableID("btnCancel1");
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
        } else if (uValue.indexOf("admin") > -1) {
            $("#controlUsername .controls .help-block").remove();
            $("#controlUsername").removeClass("success");
            $("#controlUsername").addClass("error");
            $("#controlUsername .controls").append(
                '<span class="help-block"><i class="icon-remove"></i> Username not have keyword "admin"!</span>'
            );
            $("#username").focus();
            return false;
        }
        else {
            $.post(url_check_duplicate, {
                username: $("#username").val()
            },function (result1) {
                $("#controlUsername .controls .help-block").remove();
                if (result1 == "false") {
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
            }).done(function () {
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
    }

    function postNewData() {
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
                if (result == "add fail") {
                    clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
                    hideWaitImage();
                } else {
                    hideWaitImage();
                    <?php if(@$permissionUpdate):?>
                    clickNotifyUpdate();
                    memberID = result;
                    $("#liPorfile").removeClass("active");
                    $("#liModulePermission").addClass("active");

                    $("#profile").removeClass("active");
                    $("#module_permission").addClass("active");

                    $("#btnSave1").hide();
                    $("#btnCancel1").hide();
                    scrollTop();
                    <?php else:?>

                    openUrl(url_list);
                    <?php endif;?>
                }
            }).done(function () {
                //alert("second success");
            })
            .fail(function () {
                clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
                enableID("btnFinish");
                hideWaitImage();
            })
            .always(function () {
                //alert("finished");
            });
    }
    function checkUserID() {
        if (memberID == 0) {
            clickNotifyError('กรุณาสร้าง Profile ก่อน');
            $("#liPorfile").addClass("active");
            $("#liModulePermission").removeClass("active");

            $("#profile").addClass("active");
            $("#module_permission").removeClass("active");
            return false;
        }
        return true;
    }
    function setValueModuleAll(id) {
        if (!checkUserID()) {
            return false;
        }
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
        if (!checkUserID()) {
            return false;
        }
        postDataSetPermission(id);
        return true;
    }

    function postDataSetPermission(id) {
        disableID("btnSave2");
        disableID("btnCancel2");
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
        $.post(url_edit_module + memberID, {
            module_id: id,
            permission: strPermission
        }, function (result) {
            if (result == "edit fail") {
                clickNotifyError('เกิดข้อผิดพลาด**');
            } else {
                clickNotifyUpdate();
            }
            enableID("btnSave2");
            enableID("btnCancel2");

        })
            .done(function () {
                //alert("second success");
            })
            .fail(function () {
                clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
                enableID("btnSave2");
                enableID("btnCancel2");
            })
            .always(function () {
                //alert("finished");
            });
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
            <h1>New Member</h1>
        </div>
    </div>
    <div class="breadcrumbs">
        <ul>
            <li>
                <a href="<?php echo $webUrl; ?>dashboard">Home</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="<?php echo $webUrl; ?>member">Member</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="<?php echo $webUrl; ?>member/add">New Member</a>
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
    <?php if (@$permission): ?>
        <div class="box-content nopadding">
        <ul class="tabs tabs-inline tabs-top">
            <li class='active' id="liPorfile">
                <a href="#profile" data-toggle='tab'><i class="icon-user"></i> Profile</a>
            </li>
            <li id="liModulePermission">
                <a href="#module_permission" data-toggle='tab'><i class="icon-lock"></i> Module Permission</a>
            </li>
        </ul>
        <div class="tab-content tab-content-top tab-content-inline tab-content-bottom nopadding"
             style="margin-top: 20px !important;">
        <div class="tab-pane active" id="profile">
            <form action="" method="POST" autocomplete="off"
                  class='form-horizontal form-column form-bordered form-validate'
                  id="formPost" name="formPost">
                <input type="hidden" name="employee_number" id="employee_number"
                       value="<?php echo strtotime(date("Y-m-d H:i:s")); ?>">
                <input type="hidden" name="user_group" id="user_group" value="0"/>

                <div class="span6">
                    <div class="control-group">
                        <label for="image" class="control-label">Image</label>

                        <div class="controls">
                            <div class="fileupload fileupload-new" id="image" data-provides="fileupload">
                                <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
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
                                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="control-group" id="controlUsername">
                        <label for="textfield" class="control-label">Username</label>

                        <div class="controls">
                            <div class="input-append">
                                <input type="text" id="username" name="username" autocomplete="off">
                                <a href="javascript:checkUsername();" class="btn add-on"><i
                                        class="icon-refresh"></i></a>
                            </div>
                        <span class="help-block">
                            Please enter a username
                        </span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="password" class="control-label">Password</label>

                        <div class="controls">
                            <div class="input-xlarge">
                                <input type="password" class='complexify-me input-block-level'
                                       name="password" id="password" data-rule-required="true" data-rule-minlength="4">
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
                                   class="input-xlarge" data-rule-required="true" data-rule-minlength="2">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="lastname" class="control-label">Last name</label>

                        <div class="controls">
                            <input type="text" name="lastname" id="lastname" placeholder="Last name"
                                   class="input-xlarge" data-rule-required="true" data-rule-minlength="2">
                        </div>
                    </div>
                </div>
                <div class="span6">
                    <div class="control-group">
                        <label for="prefix" class="control-label">Prefix</label>

                        <div class="controls">
                            <select name="prefix" id="prefix" data-rule-required="true">
                                <option value=""></option>
                                <option value="Mr.">Mr.</option>
                                <option value="Ms.">Ms.</option>
                                <option value="Miss">Miss</option>
                                <option value="Mrs.">Mrs.</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Gender</label>

                        <div class="controls">
                            <label for="gender1" class="radio">
                                <input id="gender1" name="gender" type="radio" value=""
                                       onclick="$('#gender').val('0');" data-rule-required="true"/>Man</label>
                            <label for="gender2" class="radio">
                                <input id="gender2" name="gender" type="radio" value=""
                                       onclick="$('#gender').val('1');" data-rule-required="true"/>Women</label>

                            <input type="hidden" value="" id="gender">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="age" class="control-label">Age</label>

                        <div class="controls">
                            <input type="text" name="age" id="age" placeholder="Age"
                                   class="input-xlarge" data-rule-number="true" data-rule-required="true">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="company_id" class="control-label">Company</label>

                        <div class="controls">
                            <select name="company_id" id="company_id" data-rule-required="true">
                                <option value=""></option>
                                <?php foreach ($objCompany as $key => $value): ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->name_th; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="department_id" class="control-label">Department</label>

                        <div class="controls">
                            <select name="department_id" id="department_id" data-rule-required="true">
                                <option value=""></option>
                                <option value="0">-</option>
                                <?php foreach ($objDepartment as $key => $value): ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="position_id" class="control-label">Position</label>

                        <div class="controls">
                            <select name="position_id" id="position_id" data-rule-required="true">
                                <option value=""></option>
                                <option value="0">-</option>
                                <?php foreach ($objPosition as $key => $value): ?>
                                    <option value="<?php echo $value->id; ?>"><?php echo $value->title; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="phone" class="control-label">Phone</label>

                        <div class="controls">
                            <input type="text" name="phone" id="phone" placeholder="Phone"
                                   class="input-xlarge">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="mobile" class="control-label">Mobile</label>

                        <div class="controls">
                            <input type="text" name="mobile" id="mobile" placeholder="Mobile"
                                   class="input-xlarge">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="fax" class="control-label">Fax</label>

                        <div class="controls">
                            <input type="text" name="fax" id="fax" placeholder="Fax"
                                   class="input-xlarge">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="email" class="control-label">Email</label>

                        <div class="controls">
                            <input type="text" name="email" id="email" placeholder="Email"
                                   class="input-xlarge" data-rule-required="true">
                        </div>
                    </div>
                </div>
                <div class="span12">
                    <div class="control-group">
                        <label for="address" class="control-label">Address</label>

                        <div class="controls">
                            <textarea name="address" id="address" rows="5" class="input-block-level"></textarea>
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
                                <!--หน้าสลับลำดับ-->
                                <div class="span6">
                                    <input type="checkbox" id="cbModuleAll_<?php echo $value->id; ?>"
                                           onclick="return setValueModuleAll(<?php echo $value->id; ?>);">
                                    <label class="cbInLine" for="cbModuleAll_<?php echo $value->id; ?>">All</label>
                                </div>
                                <div class="span6">

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
                                <div class="span6">
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
                                <div class="span6">
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
                        <button type="submit" class="btn btn-primary" id="btnSave2">Save changes</button>
                        <button type="button" class="btn" id="btnCancel2">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
        </div>
        </div>
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