<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();

$this->load->view("header");
$this->load->view("navigator_menu");
?>
    <script>

        var url_post_data = "<?php echo $webUrl; ?>customer/add";
        var url_list = "<?php echo $webUrl; ?>customer";
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
                        imagePatch: 'uploads/customer/',
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
                    <h1>New Customer</h1>
                </div>
            </div>
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="<?php echo $webUrl; ?>dashboard">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl; ?>customer">Customer</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a class="" href="<?php echo $webUrl; ?>customer/add">New Customer</a>
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
                                <i class="icon-list"></i> Customer
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
                                            <label for="image" class="control-label">Image</label>

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
                                        <div class="control-group">
                                            <label for="email" class="control-label">Email :</label>

                                            <div class="controls">
                                                <input type="text" name="email" id="email" placeholder="Text input"
                                                       class="input-xlarge" data-rule-email="true"
                                                       data-rule-required="true">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="fax" class="control-label">Fax :</label>

                                            <div class="controls">
                                                <input type="text" name="fax" id="fax" placeholder="Text input"
                                                       class="input-xlarge">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="taxpayer_number" class="control-label">เลขที่ผู้เสียภาษี :</label>

                                            <div class="controls">
                                                <input type="text" name="taxpayer_number" id="taxpayer_number" placeholder="Text input"
                                                       class="input-xlarge">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="name_th" class="control-label">ชื่อภาษาไทย :</label>

                                            <div class="controls">
                                                <input type="text" name="name_th" id="name_th" placeholder="Text input"
                                                       class="input-xlarge" data-rule-required="true">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="address_th" class="control-label">ที่อยู่ภาษาไทย :</label>

                                            <div class="controls">
                                                <textarea id="address_th" name="address_th"
                                                          class="input-xlarge"></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="name_en" class="control-label">ชื่อภาษาอังกฤษ :</label>

                                            <div class="controls">
                                                <input type="text" name="name_en" id="name_en" placeholder="Text input"
                                                       class="input-xlarge" data-rule-required="true">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="address_en" class="control-label">ที่อยู่อังกฤษ :</label>

                                            <div class="controls">
                                                <textarea id="address_en" name="address_en"
                                                          class="input-xlarge"></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="telephone" class="control-label">Telephone :</label>

                                            <div class="controls">
                                                <input type="text" name="telephone" id="telephone"
                                                       placeholder="Text input"
                                                       class="input-xlarge" data-rule-required="true">
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="remark" class="control-label">รายละเอียด :</label>

                                            <div class="controls">
                                                <textarea id="remark" name="remark"
                                                          class="input-xlarge"></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="location" class="control-label">Location :</label>

                                            <div class="controls">
                                                <input type="text" name="location" id="location"
                                                       class="input-xlarge">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span12">
                                        <script type="text/javascript">
                                            var geocoder = new google.maps.Geocoder();

                                            function geocodePosition(pos) {
                                                geocoder.geocode({
                                                    latLng: pos
                                                }, function(responses) {
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
                                                var latLng = new google.maps.LatLng(0, 0);
                                                var map = new google.maps.Map(document.getElementById('mapCanvas'), {
                                                    zoom: 8,
                                                    center: latLng,
                                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                                });
                                                var marker = new google.maps.Marker({
                                                    position: latLng,
                                                    title: 'Point A',
                                                    map: map,
                                                    draggable: true
                                                });

                                                // Update current position info.
                                                updateMarkerPosition(latLng);
                                                geocodePosition(latLng);

                                                // Add dragging event listeners.
                                                google.maps.event.addListener(marker, 'dragstart', function() {
                                                    updateMarkerAddress('Dragging...');
                                                });

                                                google.maps.event.addListener(marker, 'drag', function() {
                                                    updateMarkerStatus('Dragging...');
                                                    updateMarkerPosition(marker.getPosition());
                                                });

                                                google.maps.event.addListener(marker, 'dragend', function() {
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