<?php

$this->load->view("header");
$this->load->view("navigator_menu");
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$id = @$id ? $id : 0;
$view = @$view ? $view : false;
if ($page != "Add") {
    $objData = $this->Customer_model->customerList($id);
    extract((array)$objData[0]);
}
$objContact = $this->Contact_model->contactList(0, $id);

?>
    <script>

        var url_post_data = "<?php echo $webUrl; ?>customer/edit/<?php echo $id; ?>";
        var url_list = "<?php echo $webUrl; ?>customer";
        var url_contact_list = "<?php echo $webUrl; ?>contact";
        var url_post_add_contact = "<?php echo $webUrl; ?>contact/add";
        var url_post_edit_contact = "<?php echo $webUrl; ?>contact/edit/";
        var customer_id = <?php echo $id; ?>;
        var noImgUrl = baseUrl + "assets/img/no_img.gif";
        var contact_image = "";
        $(document).ready(function () {
            <?php if (@$_GET['contact'] == 'add'): ?>
            focusToDiv(".table");
            <?php endif; ?>
            $('#btnCancel').click(function () {
                openUrl(url_list);
                return false;
            });

            <?php if ($page == "View"): ?>
            $("#formPost :input").prop("disabled", true);
            $("#div_contact_post :input").prop("disabled", true);
            <?php else: ?>
            $("#formPost").submit(function () {
                disableID("btnSave");
                var checkPost = checkValidateForm("#formPost");
                if (checkPost) {
                    var dataImg = "";
                    if ($("#customer_image .fileupload-preview").html() != "") {
                        dataImg = $("#customer_image .fileupload-preview img").attr("src");
                    }
                    var dataContactImg = "";
                    if ($("#contact_image .fileupload-preview").html() != "") {
                        dataContactImg = $("#contact_image .fileupload-preview img").attr("src");
                    }
                    var data = $(this).serialize();
                    var imageName = $("#imagefile").val();
                    var imageContactName = $("#imagefileContact").val();
                    data = data + '&' + $.param({
                        data_image: dataImg,
                        contact_data_image: dataContactImg,
                        fileType: "image",
                        imagePatch: 'uploads/customer/',
                        imageContactPatch: 'uploads/contact/',
                        imageName: imageName,
                        imageContactName: imageContactName
                    });
                    if ($("#contact_id").val() != "")
                        postData(url_post_data, data, url_post_data + '?contact=');
                    else
                        postData(url_post_data, data, url_post_data + '?contact=add');
                } else {
                    enableID("btnSave");
                }
                return false;
            });
            /*
             $("#div_contact_post").submit(function () {
             disableID("btnSaveContact");
             var checkPost = checkValidateForm("#div_contact_post");
             if (checkPost) {
             var dataContactImg = "";
             if ($(".fileupload-preview", this).html() != "") {
             dataContactImg = $(".fileupload-preview img", this).attr("src");
             }
             var data = $(this).serialize();
             var imageName = $("#imagefileContact").val();
             data = data + '&' + $.param({
             contact_data_image: dataContactImg,
             fileType: "image",
             imagePatch: 'uploads/contact/',
             imageName: imageName
             });
             var urlPost = "";
             if ($("#contact_id").val() == "") {
             urlPost = url_post_add_contact;
             } else {
             urlPost = url_post_edit_contact + $("#contact_id").val();
             }
             postData(urlPost, data, url_post_data + "?contact=true");
             } else {
             enableID("btnSaveContact");
             }
             return false;
             });*/

            $("#btnClear").click(function () {
                clearFormContact();
                return false;
            });

            $("#btnDeleteImageContact").click(function () {
                if (confirm("ต้องการลบรูปใช่หรือไม่")) {
                    var url = webUrl + "upload/deleteimage";
                    $.post(url, {
                            path: contact_image
                        },
                        function (result) {
                            if (result == "delete fail") {
                                clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
                            } else {
                                $("#div_contact_post .thumbnail img").attr('src', noImgUrl);
                                $("#div_contact_post #image_path_contact").val("");
                                $("#div_contact_post #groupBtnContact").show();
                                $("#btnDeleteImageContact").hide();
                            }
                        }
                    ).done(function () {
                            //alert("second success");
                        })
                        .fail(function () {
                            clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
                        })
                        .always(function () {
                            //alert("finished");
                        });
                }
                return false;
            });
            <?php endif; ?>
        });

        function clearFormContact() {
//            $('#div_contact_post').trigger("reset");
            $('#div_contact_post input[type="text"]').val('');
            $("#contact_description").val('');
            $("#contact_id").val('');
            $("#customer_id").val(customer_id);
            $("#div_contact_post .thumbnail img").attr('src', noImgUrl);
            $("#div_contact_post #image_path_contact").val("");
            $("#div_contact_post #groupBtnContact").show();
            $("#btnDeleteImageContact").hide();
            focusToDiv("#contact_image", "#contact_name_th");
        }

        function loadEditFormContact(id) {
            showWaitImageOnTop();
            $.ajax({
                type: "GET",
                url: url_post_edit_contact + id,
                dataType: 'json',
                crossDomain: true,
                success: function (json) {
                    $("#contact_name_th").val(json['name_th']);
                    $("#contact_name_en").val(json['name_en']);
                    $("#contact_email").val(json['email']);
                    $("#contact_mobile").val(json['mobile']);
                    $("#contact_position").val(json['position']);
                    $("#contact_description").text(json['description']);
                    $("#contact_id").val(json['id']);
                    $("#customer_id").val(json['customer_id']);
                    $("#image_path_contact").val(json['image']);
                    if (json['image']) {
                        $("#div_contact_post .thumbnail img").attr("src", baseUrl + json['image']);
                        $("#btnDeleteImageContact").show();
                        $("#groupBtnContact").hide();
                        contact_image = json['image'];
                    } else {
                        contact_image = "";
                    }
                    focusToDiv("#contact_image", "#contact_name_th");
                    hideWaitImageOnTop();
                }});
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
            <h1><?php echo @$page; ?> Customer</h1>
        </div>
    </div>
    <div class="breadcrumbs">
        <ul>
            <li>
                <a href="<?php echo $webUrl; ?>Dashboard">Home</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="<?php echo $webUrl; ?>customer">Customer</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a href="<?php echo $webUrl; ?>customer/edit/<?php echo $id; ?>"><?php echo @$page; ?> Customer</a>
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
            <i class="icon-list"></i><?php echo @$page; ?> Customer
        </h3>
    </div>
    <!-- END: .box-title -->
    <?php if (@$permission || $page == "View"): ?>
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
                <div class="fileupload fileupload-new" id="customer_image"
                     data-provides="fileupload">
                    <div id="imgThumbnail" class="fileupload-new thumbnail"
                         style="width: 200px; height: 150px;">
                        <img src="<?php
                        echo !file_exists(@$image) ? $baseUrl . "assets/img/no_img.gif" :
                            $baseUrl . $image;
                        ?>"/>
                    </div>
                    <?php if ($page != "View") : ?>
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
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="control-group">
            <label for="taxpayer_number" class="control-label">เลขที่ผู้เสียภาษี :</label>

            <div class="controls">
                <input type="text" name="taxpayer_number"
                       id="taxpayer_number" placeholder="Text input"
                       class="input-xlarge"
                       <?php if (!@$_GET['contact']){?>autofocus=""<?php } ?>
                       value="<?php echo @$taxpayer_number; ?>">
            </div>
        </div>
        <div class="control-group">
            <label for="name_th" class="control-label">ชื่อภาษาไทย :</label>

            <div class="controls">
                <input type="text" name="name_th" id="name_th" placeholder="Text input"
                       class="input-xlarge" value="<?php echo @$name_th; ?>"
                       data-rule-required="true">
            </div>
        </div>
        <div class="control-group">
            <label for="address_th" class="control-label">ที่อยู่ภาษาไทย :</label>

            <div class="controls">
                <textarea id="address_th" name="address_th"
                          class="input-xlarge"><?php echo @$address_th; ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label for="name_en" class="control-label">ชื่อภาษาอังกฤษ :</label>

            <div class="controls">
                <input type="text" name="name_en" id="name_en" placeholder="Text input"
                       class="input-xlarge"
                       value="<?php echo @$name_en; ?>">
            </div>
        </div>
        <div class="control-group">
            <label for="address_en" class="control-label">ที่อยู่อังกฤษ :</label>

            <div class="controls">
                <textarea id="address_en" name="address_en"
                          class="input-xlarge"><?php echo @$address_en; ?></textarea>
            </div>
        </div>
        <div class="control-group">
            <label for="email" class="control-label">Email :</label>

            <div class="controls">
                <input type="text" name="email" id="email" placeholder="Text input"
                       class="input-xlarge" value="<?php echo @$email; ?>"
                       data-rule-email="true">
            </div>
        </div>
        <div class="control-group">
            <label for="telephone" class="control-label">Telephone :</label>

            <div class="controls">
                <input type="text" name="telephone" id="telephone"
                       placeholder="Text input"
                       class="input-xlarge"
                       value="<?php echo @$telephone; ?>">
            </div>
        </div>
        <div class="control-group">
            <label for="fax" class="control-label">Fax :</label>

            <div class="controls">
                <input type="text" name="fax" id="fax" placeholder="Text input"
                       class="input-xlarge" value="<?php echo @$fax; ?>">
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
            <label for="location" class="control-label">Location :</label>

            <div class="controls">
                <input type="text" name="location" id="location"
                       class="input-xlarge"
                       value="<?php echo @$location; ?>">
            </div>
        </div>
    </div>
    <!--        Google Map-->
    <div class="span12">
        <script type="text/javascript">
            var geocoder = new google.maps.Geocoder();

            function geocodePosition(pos) {
                geocoder.geocode({
                    latLng: pos
                }, function (responses) {
                    if (responses && responses.length > 0) {
                        updateMarkerAddress(responses[0].formatted_address);
                    } else {
                        updateMarkerAddress('Cannot determine address at this location.');
                    }
                });
            }

            function updateMarkerStatus(str) {
                document.getElementById('markerStatus').innerHTML = str;
            }

            function updateMarkerPosition(latLng) {
                document.getElementById('info').innerHTML = [
                    latLng.lat(),
                    latLng.lng()
                ].join(', ');
                document.getElementById('location').value = [
                    latLng.lat(),
                    latLng.lng()
                ].join(', ');
            }

            function updateMarkerAddress(str) {
                document.getElementById('address').innerHTML = str;
            }

            function initialize() {
                var latLng = new google.maps.LatLng(<?php echo @$location? $location:'0, 0';?>);
                var map = new google.maps.Map(document.getElementById('mapCanvas'), {
                    zoom: 8,
                    center: latLng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });
                var marker = new google.maps.Marker({
                    position: latLng,
                    title: 'Point A',
                    map: map,
                    draggable: <?php echo $page == "View"?"false":"true";?>
                });

                // Update current position info.
                updateMarkerPosition(latLng);
                geocodePosition(latLng);

                // Add dragging event listeners.
                google.maps.event.addListener(marker, 'dragstart', function () {
                    updateMarkerAddress('Dragging...');
                });

                google.maps.event.addListener(marker, 'drag', function () {
                    updateMarkerStatus('Dragging...');
                    updateMarkerPosition(marker.getPosition());
                });

                google.maps.event.addListener(marker, 'dragend', function () {
                    updateMarkerStatus('Drag ended');
                    geocodePosition(marker.getPosition());
                });
            }

            // Onload handler to fire off the app.
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
        <style>
            #mapCanvas {
                width: 500px;
                height: 400px;
                float: left;
            }

            #infoPanel {
                float: left;
                margin-left: 10px;
            }

            #infoPanel div {
                margin-bottom: 5px;
            }
        </style>
        <div class="box">
            <div class="box-title">
                <h3>
                    <i class="icon-map-marker"></i>
                    Map
                </h3>
            </div>
            <div class="box-content">
                <div id="mapCanvas"></div>
                <div id="infoPanel">
                    <b>Marker status:</b>

                    <div id="markerStatus"><i>Click and drag the marker.</i></div>
                    <b>Current position:</b>

                    <div id="info"></div>
                    <b>Closest matching address:</b>

                    <div id="address"></div>
                </div>
            </div>
        </div>
    </div>
    <!--        End Google Map-->
    <!--END:span6 -->

    <div class="box" id="div_contact">
        <div class="box-title">
            <h3>
                <i class="icon-user"></i>
                Contact
            </h3>
        </div>
        <table
            class="table table-hover table-nomargin dataTable table-bordered display dataTable-scroll-x">
            <thead>
            <tr>
                <th>#</th>
                <th>Name TH</th>
                <th>Name EN</th>
                <th>Position</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Update Time</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($objContact)
                foreach ($objContact as $key => $value):
                    ?>
                    <tr>
                        <td class="center"><?php echo $key + 1; ?></td>
                        <td><?php echo $value->name_th; ?></td>
                        <td><?php echo $value->name_en; ?></td>
                        <td><?php echo $value->position; ?></td>
                        <td><?php echo "$value->mobile"; ?></td>
                        <td><?php echo $value->email; ?></td>
                        <td><?php echo $value->update_datetime; ?></td>
                        <td class="hidden-400">
                            <a href="#" onclick="loadEditFormContact(<?php echo @$value->id; ?>);return false;"
                               class="btn" rel="tooltip" title=""
                               data-original-title="<?php echo $page == "View" ? "View" : "Edit"; ?>"><i
                                    class="<?php echo $page == "View" ? "icon-search" : "icon-edit"; ?>"></i></a>
                            <?php if ($page != "View") : ?>
                                <a href="#messageDeleteData" class="btn" rel="tooltip" title=""
                                   data-original-title="Delete"
                                   onclick="urlDelete='<?php echo $webUrl; ?>contact/delete/<?php echo $value->id; ?>';"
                                   role="button" data-toggle="modal">
                                    <i class="icon-remove"></i>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>

                <?php
                endforeach;
            ?>
            </tbody>
        </table>
        <div class="span12" id="div_contact_post">
            <div class="control-group">
                <input type="hidden" id="customer_id" name="customer_id"
                       value="<?php echo @$id; ?>"/>
                <input type="hidden" id="contact_id" name="contact_id"
                       value=""/>
                <input type="hidden" id="contact_image_path" name="contact_image_path"
                       value="<?php echo !file_exists(@$image) ? "" : $image; ?>"/>
                <label for="contact_image" class="control-label">Image</label>

                <div class="controls">
                    <div class="fileupload fileupload-new" id="contact_image"
                         data-provides="fileupload">
                        <div class="fileupload-new thumbnail"
                             style="width: 200px; height: 150px;">
                            <img src="<?php echo $baseUrl; ?>assets/img/no_img.gif"/>
                        </div>
                        <?php if ($page != "View"): ?>
                            <div class="fileupload-preview fileupload-exists thumbnail"
                                 style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                            <div>
                                    <span id="groupBtnContact" class="btn btn-file">
                                        <span class="fileupload-new">Select image</span>
                                        <span class="fileupload-exists">Change</span>
                                        <input type="file" id="imagefileContact" name='imagefile'/>
                                    </span>
                                <input type="button" id="btnDeleteImageContact"
                                       class="btn hide"
                                       value="Remove">
                                <a href="#" class="btn fileupload-exists"
                                   data-dismiss="fileupload">Remove</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label for="contact_name_th" class="control-label">ชื่อภาษาไทย :</label>

                <div class="controls">
                    <input type="text" name="contact_name_th" id="contact_name_th"
                           placeholder="Text input"
                           class="input-xlarge" value=""
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="contact_name_en" class="control-label">ชื่อภาษาอังกฤษ :</label>

                <div class="controls">
                    <input type="text" name="contact_name_en" id="contact_name_en" placeholder="Text input"
                           class="input-xlarge" value=""
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="contact_email" class="control-label">Email :</label>

                <div class="controls">
                    <input type="text" name="contact_email" id="contact_email" placeholder="Text input"
                           class="input-xlarge" value=""
                           data-rule-email="true"></div>
            </div>
            <div class="control-group">
                <label for="contact_mobile" class="control-label">Mobile :</label>

                <div class="controls">
                    <input type="text" name="contact_mobile" id="contact_mobile"
                           placeholder="Text input"
                           class="input-xlarge"
                           value="">
                </div>
            </div>
            <div class="control-group">
                <label for="contact_position" class="control-label">ตำแหน่ง :</label>

                <div class="controls">
                    <input type="text" name="contact_position" id="contact_position"
                           placeholder="Text input"
                           class="input-xlarge"
                           maxlength="120"
                           value="">
                </div>
            </div>
            <div class="control-group">
                <label for="contact_description" class="control-label">รายละเอียด :</label>

                <div class="controls">
                    <textarea id="contact_description" name="contact_description"
                              class="input-xlarge"></textarea>
                </div>
            </div>
            <?php if ($page != "View") : ?>
                <div class="form-actions">
                    <button type="button" class="btn btn-blue" id="btnClear">Clear</button>

                </div>
            <?php endif; ?>
        </div>
        <div class="span12">
            <div class="form-actions">
                <?php if ($page != "View") : ?>
                    <button type="submit" class="btn btn-primary"
                            id="btnSave">Save changes
                    </button>
                    <button type="button" class="btn"
                            id="btnCancel">Finish
                    </button>
                <?php else : ?>
                    <a type="button" class="btn btn-primary" id="btnCancel">Back</a>
                <?php endif; ?>
            </div>
        </div>
        <!--END:span6 -->

    </form>

    </div>
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