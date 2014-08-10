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
}
$objProject = $this->Project_model->projectList();
$objCompany = $this->Company_model->companyList();
$arrayCompanyName = array();
$arrayCompanyAddress = array();
$arrayCompanyTelephone = array();
$arrayCompanyFax = array();
$arrayCompanyEmail = array();
foreach ($objCompany as $key => $value) {
    if ($value->name_th && $value->name_th != '-') {
        $arrayCompanyName[] = "&quot;" . str_replace('"', "'", $value->name_th) . "&quot;";
    } else if ($value->name_en && $value->name_en != '-') {
        $arrayCompanyName[] = "&quot;" . str_replace('"', "'", $value->name_en) . "&quot;";
    }
    $arrayCompanyAddress[] = $value->address_th;
    $arrayCompanyTelephone[] = $value->telephone;
    $arrayCompanyFax[] = $value->fax;
    $arrayCompanyEmail[] = $value->email;
}

$objCustomer = $this->Customer_model->customerList();
$arrayCustomer = array();
foreach ($objCustomer as $key => $value) {
    if ($value->name_th && $value->name_th != '-') {
        $arrayCustomer[] = "&quot;" . str_replace('"', "'", $value->name_th) . "&quot;";
    } else if ($value->name_en && $value->name_en != '-') {
        $arrayCustomer[] = "&quot;" . str_replace('"', "'", $value->name_en) . "&quot;";
    }
}

?>
    <script>
        var url_post_data = "<?php echo $webUrl; ?>quotation/<?php echo $id?"edit/$id":"add";?>";
        var url_list = "<?php echo $webUrl; ?>quotation";
        var url_post_edit_item = "<?php echo $webUrl; ?>quotation/item/edit/";
        var url_post_delete_item = "<?php echo $webUrl; ?>quotation/item/delete/";
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

        <div class="span12">
            <div class="box-title">
                <h3><i class="icon-user"></i> รายละเอียดลูกค้า</h3>
            </div>
            <div class="control-group">
                <label for="project_id" class="control-label">Project :</label>

                <div class="controls">
                    <div class="input-xlarge">
                        <select name="project_id" id="project_id"
                                class='chosen-select'>
                            <option value=""></option>
                            <?php foreach ($objProject as $key => $value): ?>
                                <option <?php echo @$project_id == $value->id ? 'selected' : ''; ?>
                                    value="<?php echo $value->id; ?>"><?php
                                    if ($value->name_th) echo $value->name_th; else $value->name_en; ?></option>
                            <?php endforeach; ?>
                        </select></div>
                </div>
            </div>
            <div class="control-group">
                <label for="customer_name" class="control-label">ชื่อลูกค้า / Customer : </label>

                <div class="controls">
                    <input type="text" data-provide="typeahead" id="customer_name" name="customer_name"
                           data-items="4" class="input-xlarge" autofocus=""
                           data-source='[<?php echo implode(',', $arrayCustomer); ?>]'
                           value="<?php echo @$customer_name; ?>">
                </div>
            </div>
            <div class="control-group">
                <label for="company_name" class="control-label">ชื่อบริษัท / Crop. Name : </label>

                <div class="controls">
                    <input type="text" data-provide="typeahead" id="company_name" name="company_name"
                           data-items="4" class="input-xlarge"
                           data-source='[<?php echo implode(',', $arrayCompanyName); ?>]'
                           value="<?php echo @$company_name; ?>">
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
                <label for="customer_mobile" class="control-label">เบอร์มือถือ / Mobile : </label>

                <div class="controls">
                    <input type="text" name="customer_mobile" id="customer_mobile"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$customer_mobile; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="customer_tel" class="control-label">เบอร์ติดต่อ / Tel : </label>

                <div class="controls">
                    <input type="text" name="customer_tel" id="customer_tel"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$customer_tel; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="customer_fax" class="control-label">เบอร์แฟ็ก / Fax : </label>

                <div class="controls">
                    <input type="text" name="customer_fax" id="customer_fax"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$customer_fax; ?>"
                        >
                </div>
            </div>
            <div class="control-group">
                <label for="customer_email" class="control-label">อีเมลล์ / Email : </label>

                <div class="controls">
                    <input type="text" name="customer_email" id="customer_email"
                           placeholder="Text input" class="input-xlarge"
                           value="<?php echo @$customer_email; ?>"
                        >
                </div>
            </div>
        </div>
        <div class="span12">
            <div class="box-title">
                <h3><i class="icon-user-md"></i> รายละเอียดผู้เสนอ</h3>
            </div>
            <div class="control-group">
                <label for="quotation_no" class="control-label">เลขที่เอกสาร / Quotation No. </label>

                <div class="controls">
                    <input type="text" name="quotation_no" id="quotation_no"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true"
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
                                   value="<?php echo $value->cost !=0 ? $value->cost : ''; ?>"></td>
                        <td><input type="text" name="quantity[]" maxlength="8"
                                   placeholder="Number" class="input-block-level quantity"
                                   data-rule-number="true"
                                   value="<?php echo $value->quantity !=0 ? $value->quantity : ''; ?>"></td>
                        <td><input type="text" name="price[]" maxlength="8"
                                   placeholder="Number" class="input-block-level price"
                                   data-rule-number="true"
                                   value="<?php echo $value->price !=0 ? $value->price : ''; ?>"></td>
                        <td><input type="text" name="discount[]" maxlength="8"
                                   placeholder="Number" class="input-block-level discount"
                                   data-rule-number="true"
                                   value="<?php echo $value->discount !=0 ? $value->discount : ''; ?>"></td>
                        <td><input type="text" disabled
                                   placeholder="" class="input-block-level amount"
                                   value="<?php echo $value->amount !=0 ? $value->amount : ''; ?>"></td>
                        <td>
                            <button tabindex="999" class="btn btn-danger btnDeleteItem">
                                <i class="glyphicon-bin"></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
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