<?php

$this->load->view("header");
$this->load->view("navigator_menu");
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
if (!@$id) {
    $id = 0;
}
$objData = $this->Customer_model->customerList($id);
$objContact = $this->Contact_model->contactList(0, $id);
extract((array)$objData[0]);

?>
    <script>
        var url_list = "<?php echo $webUrl; ?>customer";
        $(document).ready(function () {
            $('#btnBack').click(function () {
                openUrl(url_list);
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
            <h1>View Customer</h1>
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
                <a href="<?php echo $webUrl; ?>customer/view/<?php echo $id; ?>">View Customer</a>
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
            <i class="icon-list"></i> View Customer
        </h3>
    </div>
    <!-- END: .box-title -->
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
                        <div id="imgThumbnail" class="fileupload-new thumbnail"
                             style="width: 200px; height: 150px;">
                            <img src="<?php
                            echo !file_exists(@$image) ? $baseUrl . "assets/img/no_img.gif" :
                                $baseUrl . $image;
                            ?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label for="email" class="control-label">Email :</label>

                <div class="controls">
                    <input disabled type="text" name="email" id="email" placeholder="Text input"
                           class="input-xlarge" value="<?php echo @$email; ?>"
                           data-rule-email="true">
                </div>
            </div>
            <div class="control-group">
                <label for="taxpayer_number" class="control-label">เลขที่ผู้เสียภาษี :</label>

                <div class="controls">
                    <input disabled type="text" name="taxpayer_number" id="taxpayer_number" placeholder="Text input"
                           class="input-xlarge"
                           value="<?php echo @$taxpayer_number; ?>">
                </div>
            </div>
            <div class="control-group">
                <label for="name_th" class="control-label">ชื่อภาษาไทย :</label>

                <div class="controls">
                    <input disabled type="text" name="name_th" id="name_th" placeholder="Text input"
                           class="input-xlarge" value="<?php echo @$name_th; ?>"
                           data-rule-required="true">
                </div>
            </div>
            <div class="control-group">
                <label for="address_th" class="control-label">ที่อยู่ภาษาไทย :</label>

                <div class="controls">
                    <textarea disabled id="address_th" name="address_th"
                              class="input-xlarge"><?php echo @$address_th; ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label for="name_en" class="control-label">ชื่อภาษาอังกฤษ :</label>

                <div class="controls">
                    <input disabled type="text" name="name_en" id="name_en" placeholder="Text input"
                           class="input-xlarge"
                           value="<?php echo @$name_en; ?>">
                </div>
            </div>
            <div class="control-group">
                <label for="address_en" class="control-label">ที่อยู่อังกฤษ :</label>

                <div class="controls">
                    <textarea disabled id="address_en" name="address_en"
                              class="input-xlarge"><?php echo @$address_en; ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label for="telephone" class="control-label">Telephone :</label>

                <div class="controls">
                    <input disabled type="text" name="telephone" id="telephone"
                           placeholder="Text input"
                           class="input-xlarge"
                           value="<?php echo @$telephone; ?>">
                </div>
            </div>
            <div class="control-group">
                <label for="fax" class="control-label">Fax :</label>

                <div class="controls">
                    <input disabled type="text" name="fax" id="fax" placeholder="Text input"
                           class="input-xlarge" value="<?php echo @$fax; ?>">
                </div>
            </div>
            <div class="control-group">
                <label for="remark" class="control-label">รายละเอียด :</label>

                <div class="controls">
                    <textarea disabled id="remark" name="remark"
                              class="input-xlarge"><?php echo @$remark; ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label for="location" class="control-label">Location :</label>

                <div class="controls">
                    <input disabled type="text" name="location" id="location"
                           class="input-xlarge"
                           value="<?php echo @$location; ?>">
                </div>
            </div>
        </div>
        <!--END:span6 -->

        </form>
        <div class="box" id="contact">
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
                </tr>
                </thead>
                <tbody>
                <?php
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
                    </tr>

                <?php
                endforeach;
                ?>
                </tbody>
            </table>
            <div class="span12">
                <div class="form-actions">
                    <button type="button" class="btn btn-primary" id="btnBack">Back</button>
                </div>
            </div>
        </div>
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