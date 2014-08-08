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
?>
    <script>
        var url_post_data = "<?php echo $webUrl; ?>quotation/add";
        var url_list = "<?php echo $webUrl; ?>quotation";
        $(document).ready(function () {
            $('#btnCancel').click(function () {
                openUrl(url_list);
                return false;
            });

            $("#formPost").submit(function () {
                disableID("btnSave");
                var checkPost = checkValidateForm("#formPost");
                if (checkPost) {
                    postData(url_post_data, $(this).serialize(), url_list);
                } else {
                    enableID("btnSave");
                }
                return false;
            });

            $("#btnAddItem").click(function () {
                var $tr = $(".tr_items").last();
                var $clone = $tr.clone();
                $clone.find(':text').val('');
                $tr.after($clone);
                $(".tr_items").last().hide().fadeIn(function () {
                    $(".tr_items .item_no").focus();
                });
                return false;
            });
        });

        $(document).on("click", ".btnDeleteItem", function (e) {
            if ($('.btnDeleteItem').length > 1)
                $(this).closest('tr').fadeOut(function () {
                    $(this).remove();
                    $(".tr_items .item_no").focus();
                });
            else $(".tr_items .item_no").focus();
            return false;
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
                <a class="link" href="<?php echo $webUrl; ?>quotation/<?php echo $id ? "edit/$id" : "add" ?>">New
                    Quotation</a>
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
        <div class="span12">
            <div class="box-title">
                <h3><i class="icon-user"></i> รายละเอียดลูกค้า</h3>
            </div>
            <div class="control-group">
                <label for="customer_name" class="control-label">ชื่อลูกค้า / Customer : </label>

                <div class="controls">
                    <input type="text" name="customer_name" id="customer_name"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
                </div>
            </div>
            <div class="control-group">
                <label for="company_name" class="control-label">ชื่อบริษัท / Crop. Name : </label>

                <div class="controls">
                    <input type="text" name="company_name" id="company_name"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
                </div>
            </div>

            <div class="control-group">
                <label for="address" class="control-label">ที่อยู่ / Address : </label>

                <div class="controls">
                    <textarea name="address" id="address" rows="4"
                              class="input-xlarge ckedi"></textarea>
                </div>
            </div>
            <div class="control-group">
                <label for="customer_mobile" class="control-label">เบอร์มือถือ / Mobile : </label>

                <div class="controls">
                    <input type="text" name="customer_mobile" id="customer_mobile"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
                </div>
            </div>
            <div class="control-group">
                <label for="customer_tel" class="control-label">เบอร์ติดต่อ / Tel : </label>

                <div class="controls">
                    <input type="text" name="customer_tel" id="customer_tel"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
                </div>
            </div>
            <div class="control-group">
                <label for="customer_fax" class="control-label">เบอร์แฟ็ก / Fax : </label>

                <div class="controls">
                    <input type="text" name="customer_fax" id="customer_fax"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
                </div>
            </div>
            <div class="control-group">
                <label for="customer_email" class="control-label">อีเมลล์ / Email : </label>

                <div class="controls">
                    <input type="text" name="customer_email" id="customer_email"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
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
                           data-rule-required="true">
                </div>
            </div>
            <div class="control-group">
                <label for="quotation_date" class="control-label">วันที่เสนอ / Quotation Date
                </label>
                <div class="controls">
                    <input type="text" name="quotation_date" id="quotation_date"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
                </div>
            </div>
            <div class="control-group">
                <label for="proposer" class="control-label">ผู้ที่เสนอ / Proposer

                </label>

                <div class="controls">
                    <input type="text" name="proposer" id="proposer"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
                </div>
            </div>
            <div class="control-group">
                <label for="mobile" class="control-label">เบอร์มือถือ / Mobile
                </label>
                <div class="controls">
                    <input type="text" name="mobile" id="mobile"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
                </div>
            </div>
            <div class="control-group">
                <label for="telephone" class="control-label">เบอร์ติดต่อ / Telephone : </label>

                <div class="controls">
                    <input type="text" name="telephone" id="telephone"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
                </div>
            </div>
            <div class="control-group">
                <label for="fax" class="control-label">เบอร์แฟ็ก / Fax :</label>

                <div class="controls">
                    <input type="text" name="fax" id="fax"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
                </div>
            </div>
            <div class="control-group">
                <label for="email" class="control-label">อีเมล / Email :</label>

                <div class="controls">
                    <input type="text" name="email" id="email"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
                </div>
            </div>
            <div class="control-group">
                <label for="pay_of_valid" class="control-label">การจ่ายเงิน/Pay of Valid :</label>

                <div class="controls">
                    <input type="text" name="pay_of_valid" id="pay_of_valid"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
                </div>
            </div>
            <div class="control-group">
                <label for="term_of_payment" class="control-label">Term of payment :</label>

                <div class="controls">
                    <input type="text" name="term_of_payment" id="term_of_payment"
                           placeholder="Text input" class="input-xlarge"
                           data-rule-required="true">
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
                <tr class="tr_items">
                    <td>
                        <input type="text" name="item_no[]"
                               placeholder="Number" class="input-block-level item_no" maxlength="4"></td>
                    <td><input type="text" name="description[]"
                               placeholder="Text input" class="input-block-level"></td>
                    <td><input type="text" name="cost[]"
                               placeholder="Number" class="input-block-level cost"
                               data-rule-number="true"></td>
                    <td><input type="text" name="quantity[]"
                               placeholder="Number" class="input-block-level quantity"
                               data-rule-number="true"></td>
                    <td><input type="text" name="price[]"
                               placeholder="Number" class="input-block-level price"
                               data-rule-number="true"></td>
                    <td><input type="text" name="discount"
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
            <div></div>
        </div>
        <div class="span12">
            <div class="form-actions">
                <button type="button" class="btn btn-inverse" id="btnAddItem"> New Item</button>
            </div>
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