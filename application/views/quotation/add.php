<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 8/8/2557
 * Time: 8:33 น.
 */

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();

$this->load->view("header");
$this->load->view("navigator_menu");
$id = @$id ? $id : 0;
if ($id) {
    $objQuotation = $this->Quotation_model->quotationList($id);
    extract((array)$objQuotation[0]);
    $objQuotationItems = $this->Quotation_model->quotationItemList(0, $id);
} else {
    $quotation_no = $this->Quotation_model->genQuotationNo();
    $proposer = @$this->session->userdata['firstname'] . " " . @$this->session->userdata['lastname'];
    $mobile = @$this->session->userdata['mobile'];
    $telephone = @$this->session->userdata['phone'];
    $fax = @$this->session->userdata['fax'];
    $email = @$this->session->userdata['email'];
    $signature_path = @$this->session->userdata['signature_path'];
}
$objProject = $this->Project_model->projectList();
$objCustomer = $this->Customer_model->customerList();

$arrayCustomerName = array();
$arrayCustomerData = array();
$arrayCustomerAddress = array();
$arrayCustomerTelephone = array();
$arrayCustomerFax = array();
$arrayCustomerEmail = array();
foreach ($objCustomer as $key => $value) {
    $name_th = str_replace('"', "'", $value->name_th);
//    if ($value->name_th && $value->name_th != '-') {
//        $arrayCustomerName[] = "&quot;" . str_replace('"', "'", $value->name_th) . "&quot;";
//    } else if ($value->name_en && $value->name_en != '-') {
//        $arrayCustomerName[] = "&quot;" . str_replace('"', "'", $value->name_en) . "&quot;";
//    }
    $arrayCustomerName[] = $name_th;
    $arrayCustomerAddress[] = $value->address_th;
    $arrayCustomerTelephone[] = $value->telephone;
    $arrayCustomerFax[] = $value->fax;
    $arrayCustomerEmail[] = $value->email;
}

$objContact = $this->Contact_model->contactList();
$arrayContactName = array();
$arrayContactData = array();
foreach ($objContact as $key => $value) {
    $name_th = str_replace('"', "'", $value->name_th);
//    if ($value->name_th && $value->name_th != '-') {
//        $arrayContactName[] = "&quot;" . str_replace('"', "'", $value->name_th) . "&quot;";
//    } else if ($value->name_en && $value->name_en != '-') {
//        $arrayContactName[] = "&quot;" . str_replace('"', "'", $value->name_en) . "&quot;";
//    }
    $arrayContactName[] = $name_th;
    $arrayContactData[] = "['$value->customer_name_th', '$value->address_th', '$value->mobile', '$value->telephone', '$value->fax', '$value->email']";
}

?>
    <script>
        var url_post_data = "<?php echo $webUrl; ?>quotation/<?php echo $id?"edit/$id":"add";?>";
        var url_list = "<?php echo $webUrl; ?>quotation";
        var url_post_edit_item = "<?php echo $webUrl; ?>quotation/item/edit/";
        var url_post_delete_item = "<?php echo $webUrl; ?>quotation/item/delete/";

        var array_customer_name = [<?php echo "'". implode("', '", $arrayCustomerName) . "'"; ?>];
        var array_customer_data = [<?php echo implode(',', $arrayCustomerData); ?>];

        var array_contact_name = [<?php echo "'". implode("', '", $arrayContactName) . "'"; ?>];
        var array_contact_data = [<?php echo implode(',', $arrayContactData); ?>];
        var url_get_project_option = "<?php echo $webUrl; ?>project/projectListOption";
        var string_project_option = "";
        var countProject = <?php echo count($objProject); ?>;
        $(document).ready(function () {
            checkLoadOptionValue();
        });
        function checkLoadOptionValue() {
            $.ajax({
                type: "GET",
                url: url_get_project_option,
                dataType: 'json',
                crossDomain: true,
                success: function (json) {
                    var items = [];
                    var countNewProject = 0;
                    items.push("<option value=''>-- Select Project --</option>");
                    $.each(json, function (key, val) {
                        countNewProject++;
                        items.push("<option value='" + val['id'] + "'>" + val['name'] + "</option>");
                    });
                    if (countProject != countNewProject) {
                        countProject = countNewProject;
                        $("#project_id_chzn").remove();
                        var $el = $("#project_id");
                        $el.html(items.join(""));
                        setChosenSelect();
                    }
                    setTimeout('checkLoadOptionValue()', 3000);
                }});
        }
    </script>
    <script src="<?php echo $baseUrl; ?>assets/js/ics_quotation.js"></script>
<div class="container-fluid" id="content">

<?php
$this->load->view("sidebar_menu");
?>
    <div id="main">
    <div class="container-fluid">
    <div class="page-header">
        <div class="pull-left">
            <h1><?php echo $id ? "Edit" : "New"; ?> Quotation</h1>
        </div>
    </div>
    <div class="breadcrumbs">
        <ul>
            <li>
                <a class="link" href="<?php echo $webUrl; ?>dashboard">Home</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a class="link" href="<?php echo $webUrl; ?>quotation">Quotation</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a class="link" href="<?php echo $webUrl; ?>quotation/<?php echo $id ? "edit/$id" : "add" ?>">
                    <?php echo $id ? "Edit" : "New"; ?> Quotation</a>
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
            <i class="icon-list"></i> Quotation
        </h3>
    </div>
    <!-- END: .box-title -->
    <?php if (@$permission): ?>
        <div class="box-content nopadding">
        <form action="" method="POST" autocomplete="off"
              class='form-horizontal form-column form-bordered form-validate'
              id="formPost" name="formPost">
        <input type="hidden" id="quotation_id" name="quotation_id" value="<?php echo $id; ?>"/>
        <input type="hidden" id="quotation_no" name="quotation_no" value="<?php echo @$quotation_no; ?>"/>

        <div class="span12">
            <div class="box-title">
                <h3><i class="icon-user"></i> รายละเอียดลูกค้า</h3>
            </div>
            <div class="control-group">
                <label for="project_id" class="control-label">Project :</label>

                <div class="controls">
                    <div class="input-xlarge input-append" id="project_id_div" data-rule-required="true">
                        <select name="project_id" id="project_id"
                                class="chosen-select" autofocus="">
                            <option value="">-- Select Project --</option>
                            <?php foreach ($objProject as $key => $value): ?>
                                <option <?php echo @$project_id == $value->id ? 'selected' : ''; ?>
                                    value="<?php echo $value->id; ?>"><?php
                                    if ($value->name_th) echo $value->name_th; else $value->name_en; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <a class="btn" onclick="openNewTab('<?php echo $webUrl; ?>project/add?window=close');"
                           href="#"> New</a>
                    </div>
                </div>
            </div>
            <div class="control-group">
                <label for="contact_name" class="control-label">ชื่อลูกค้า / Contact : </label>

                <div class="controls">
                    <input type="text" data-provide="typeahead" id="contact_name" name="contact_name"
                           data-items="4" class="input-xlarge"
                           data-source='[<?php echo "&quot;" . implode('&quot;,&quot;', $arrayContactName) . "&quot;"; ?>]'
                           value="<?php echo @$contact_name; ?>">
                </div>
            </div>
            <div class="control-group">
                <label for="customer_name" class="control-label">ชื่อบริษัท / Crop. Name : </label>

                <div class="controls">
                    <input type="text" data-provide="typeahead" id="customer_name" name="customer_name"
                           data-items="4" class="input-xlarge"
                           data-source='[<?php echo "&quot;" . implode('&quot;,&quot;', $arrayCustomerName) . "&quot;"; ?>]'
                           value="<?php echo @$customer_name; ?>">
                </div>
            </div>

            <div class="control-group">
                <label for="address" class="control-label">ที่อยู่ / Address : </label>

                <div class="controls">
                    <textarea name="address" id="address" rows="4"
                              class="input-xlarge"><?php echo @$address; ?></textarea>
                </div>
            </div>
            <div class="control-group">
                <label for="contact_mobile" class="control-label">เบอร์มือถือ / Mobile : </label>

                <div class="controls">
                    <input type="text" name="contact_mobile" id="contact_mobile"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$contact_mobile; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="contact_tel" class="control-label">เบอร์ติดต่อ / Tel : </label>

                <div class="controls">
                    <input type="text" name="contact_tel" id="contact_tel"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$contact_tel; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="contact_fax" class="control-label">เบอร์แฟ็ก / Fax : </label>

                <div class="controls">
                    <input type="text" name="contact_fax" id="contact_fax"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$contact_fax; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="contact_email" class="control-label">อีเมลล์ / Email : </label>

                <div class="controls">
                    <input type="text" name="contact_email" id="contact_email"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$contact_email; ?>"
                        >
                </div>
            </div>
        </div>
        <div class="span12">
            <div class="box-title">
                <h3><i class="icon-user-md"></i> รายละเอียดผู้เสนอ</h3>
            </div>
            <div class="control-group">
                <label for="quotation_no_show" class="control-label">เลขที่เอกสาร / Quotation No. </label>

                <div class="controls">
                    <input type="text" name="quotation_no_show" id="quotation_no_show"
                           placeholder="Text input" class="input-xlarge"
                           disabled
                           value="<?php echo @$quotation_no; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="quotation_date" class="control-label">วันที่เสนอ / Quotation Date
                </label>

                <div class="controls">
                    <input type="text" name="quotation_date" id="quotation_date"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true"
                           value="<?php echo @$quotation_date ? $quotation_date : date('Y-m-d'); ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="proposer" class="control-label">ผู้ที่เสนอ / Proposer

                </label>

                <div class="controls">
                    <input type="text" name="proposer" id="proposer"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$proposer; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="mobile" class="control-label">เบอร์มือถือ / Mobile
                </label>

                <div class="controls">
                    <input type="text" name="mobile" id="mobile"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$mobile; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="telephone" class="control-label">เบอร์ติดต่อ / Telephone : </label>

                <div class="controls">
                    <input type="text" name="telephone" id="telephone"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$telephone; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="fax" class="control-label">เบอร์แฟ็ก / Fax :</label>

                <div class="controls">
                    <input type="text" name="fax" id="fax"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$fax; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="email" class="control-label">อีเมล / Email :</label>

                <div class="controls">
                    <input type="text" name="email" id="email"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$email; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="signature_path" class="control-label">Signature Path :</label>

                <div class="controls">
                    <input type="text" name="signature_path" id="signature_path"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$signature_path; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="term_of_valid" class="control-label">Term of valid :</label>

                <div class="controls">
                    <input type="text" name="term_of_valid" id="term_of_valid"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$term_of_valid; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="pay_of_valid" class="control-label">การจ่ายเงิน/Pay of Valid :</label>

                <div class="controls">
                    <input type="text" name="pay_of_valid" id="pay_of_valid"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$pay_of_valid; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="term_of_payment" class="control-label">Term of payment :</label>

                <div class="controls">
                    <input type="text" name="term_of_payment" id="term_of_payment"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$term_of_payment; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="remark" class="control-label">หมายเหตุ / Note : </label>

                <div class="controls">
                    <textarea name="remark" id="remark" rows="4"
                              class="input-xlarge ckedi"><?php echo @$remark; ?></textarea>
                </div>
            </div>
        </div>
        <div class="span12">
            <div class="box-title">
                <h3><i class="glyphicon-shopping_cart"></i> รายการสินค้า / บริการ</h3>
            </div>
            <table id="table_items" class="table table-hover table-bordered dataTable-scroll-x">
                <thead>
                <tr>
                    <th class="span1 text-align-center">ลำดับที่<br/>Item No.</th>
                    <th class="span5 text-align-center">รายการสินค้า/บริการ<br/> Description</th>
                    <th class="span1 text-align-center">ต้นทุน Cost</th>
                    <th class="span1 text-align-center">จำนวน<br/> Quantity</th>
                    <th class="span1 text-align-center">ราคา/หน่วย<br/> Price/Unit</th>
                    <th class="span1 text-align-center">ส่วนลด<br/> Discount</th>
                    <th class="span2 text-align-center" colspan="2">รวม Amount</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($id) foreach ($objQuotationItems as $key => $value): ?>
                    <tr class="tr_items">
                        <td><input type="hidden" name="item_id[]" class="item_id"
                                   value="<?php echo $value->id; ?>"/>
                            <input type="text" name="item_no[]"
                                   placeholder="Text" class="input-block-level item_no"
                                   maxlength="4" value="<?php echo $value->item_no; ?>"></td>
                        <td><input type="text" name="description[]"
                                   placeholder="Text input"
                                   class="input-block-level"
                                   value="<?php echo $value->description; ?>"></td>
                        <td><input type="text" name="cost[]" maxlength="8"
                                   placeholder="Number" class="input-block-level cost"
                                   data-rule-number="true"
                                   value="<?php echo $value->cost != 0 ? str_replace(".00", "", $value->cost) : ''; ?>"></td>
                        <td><input type="text" name="quantity[]" maxlength="8"
                                   placeholder="Number" class="input-block-level quantity"
                                   data-rule-number="true"
                                   value="<?php echo $value->quantity != 0 ? str_replace(".00", "", $value->quantity) : ''; ?>"></td>
                        <td><input type="text" name="price[]" maxlength="8"
                                   placeholder="Number" class="input-block-level price"
                                   data-rule-number="true"
                                   value="<?php echo $value->price != 0 ? str_replace(".00", "", $value->price) : ''; ?>"></td>
                        <td><input type="text" name="discount[]" maxlength="8"
                                   placeholder="Number" class="input-block-level discount"
                                   data-rule-number="true"
                                   value="<?php echo $value->discount != 0 ? str_replace(".00", "", $value->discount) : ''; ?>"></td>
                        <td><input type="text" disabled
                                   placeholder="" class="input-block-level amount"
                                   value="<?php echo $value->amount != 0 ? str_replace(".00", "", $value->amount) : ''; ?>"></td>
                        <td>
                            <button tabindex="999" class="btn btn-danger btnDeleteItem">
                                <i class="glyphicon-bin"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (count(@$objQuotationItems) < 13): ?>
                    <tr class="tr_items">
                        <td><input type="hidden" name="item_id[]" class="item_id" value=""/>
                            <input type="text" name="item_no[]"
                                   placeholder="Text" class="input-block-level item_no"
                                   maxlength="4"></td>
                        <td><input type="text" name="description[]"
                                   placeholder="Text input" class="input-block-level"></td>
                        <td><input type="text" name="cost[]" maxlength="8"
                                   placeholder="Number" class="input-block-level cost"
                                   data-rule-number="true"></td>
                        <td><input type="text" name="quantity[]" maxlength="8"
                                   placeholder="Number" class="input-block-level quantity"
                                   data-rule-number="true"></td>
                        <td><input type="text" name="price[]" maxlength="8"
                                   placeholder="Number" class="input-block-level price"
                                   data-rule-number="true"></td>
                        <td><input type="text" name="discount[]" maxlength="8"
                                   placeholder="Number" class="input-block-level discount"
                                   data-rule-number="true"></td>
                        <td><input type="text" disabled
                                   placeholder="" class="input-block-level amount"></td>
                        <td>
                            <button tabindex="999" class="btn btn-danger btnDeleteItem">
                                <i class="glyphicon-bin"></i></button>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="span12">
            <div class="form-actions">
                <button type="button" class="btn btn-inverse" id="btnAddItem"> New Item</button>
            </div>
        </div>
        <div class="span12">
            <table class="table">
                <tbody>
                <tr>
                    <td class="span10 text-align-right" colspan="6">Discount Total :</td>
                    <td class="span2 text-align-right" id="discount_total"><?php
                        echo @$discount_total ? number_format($discount_total, 2) : "0.00"; ?></td>
                </tr>
                <tr>
                    <td class="span10 text-align-right" colspan="6">Amount :</td>
                    <td class="span2 text-align-right" id="amount"><?php
                        echo @$amount ? number_format($amount, 2) : "0.00"; ?></td>
                </tr>
                <tr>
                    <td class="span10 text-align-right" colspan="6">Vat 7% :</td>
                    <td class="span2 text-align-right" id="vat"><?php
                        echo @$vat ? number_format($vat, 2) : "0.00"; ?></td>
                </tr>
                <tr>
                    <td class="span10 text-align-right" colspan="6">Total Amount :</td>
                    <td class="span2 text-align-right" id="total_amount"><?php
                        echo @$total_amount ? number_format($total_amount, 2) : "0.00"; ?></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="span12">
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="btnSave">Save changes
                </button>
                <button type="button" class="btn" id="btnCancel">Cancel</button>
            </div>
        </div>
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