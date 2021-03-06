<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 8/8/2557
 * Time: 8:34 น.
 */

//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment; filename= " . "test" . ".xls");
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();

$objQuotation = $this->Quotation_model->quotationList($id);
extract((array)$objQuotation[0]);
$objQuotationItem = $this->Quotation_model->quotationItemList(0, $id);
$countQuotationItem = count($objQuotationItem)
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <!-- Apple devices fullscreen -->
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <!-- Apple devices fullscreen -->
    <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent"/>

    <title>ICS Print Quotation</title>
    <style>
        body {
            font-size: 12px;
        }

        table tr td {
            padding: 3px;
        }

        table .content {
            margin: 1em;
            border-collapse: collapse;
        }

        table .content th {
            padding: .3em;
            border: 1px #ccc solid;
            background: #DDD;
        }

        table .content td {
            padding: .3em;
            border: 1px #ccc solid;
        }

        .border {
            border: 1px #000 solid;
        }

        .border-bottom {
            border-bottom: 1px #000 solid;
        }

        .border-top {
            border-top: 1px #000 solid;
        }

        .border-left {
            border-left: 1px #000 solid;
        }

        .border-right {
            border-right: 1px #000 solid;
        }

        .font-11 {
            font-size: 11px !important;
        }

        table.padding2px tr td {
            padding: 0px 2px 0px 2px;
        !important;
        }
    </style>
</head>
<body>

<table width="800" align="center">
<thead>
<tr><!-- document header -->
    <td style="">
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="9%" height="89">
                    <img width="80" src="<?php echo $baseUrl; ?>assets/img/logo.png"/></td>
                <td>
                    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="2"><strong style="font-size: 18px;">IdeaCorners Studio Company Limited./
                                    บริษัท ไอเดีย คอร์เนอร์ สตูดิโอ จำกัด</strong></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                    <span class="style3"><b
                                            style="font-size: 10px;">                                </span>

                                <div align="left" style="font-size:9px;">We are confident of providing services to
                                    support the goals. And solve all your business problems.
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><span style="font-size:10px;"><strong>Address :</strong> 18/379 ม.5 หมู่บ้านเปี่ยมสุข (ซ.5) ซอยวัดกู้ ถ.แจ้งวัฒนะ ต.บางพูด อ.ปากเกร็ด จ.นนทบุรี 11120</span>
                            </td>
                        </tr>
                        <tr>
                            <td height="23"><span style="font-size:10px;"><strong>Tel :</strong> 084-672-7423 <strong>Email  : </strong>info@ideacorners.com <strong>Website : </strong>http://www.ideacorners.com<br/>
                          <strong>Facebook : </strong>facebook@ideacorners <strong>Twitter : </strong>@ideacorners</span></td>
                            <td width="300" align="center" bgcolor="#FFC000" class="border">
                                <span>ใบเสนอราคา / QUOTATION</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr><!-- quotation main info -->
    <td>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td width="170" align="left" valign="top" class="border-top border-left">ชื่อลูกค้า / Customer :</td>
                <td align="left" valign="top" class="border-top"> <?php echo @$contact_name; ?></td>
                <td width="150" colspan="" align="left" valign="top" class="border-top border-left font-11">เลขที่เอกสาร
                    / Quotation No. :
                </td>
                <td width="150" align="left" valign="top"
                    class="border-top border-left border-right"><?php echo @$quotation_no; ?></td>
            </tr>
            <tr>
                <td align="left" valign="top" class="border-left font-11">ชื่อบริษัท / Crop. Name :</td>
                <td align="left" valign="top"> <?php echo @$customer_name; ?></td>
                <td align="left" valign="top" class="border-left font-11">วันที่เสนอ / Quotation Date :</td>
                <td align="left" valign="top"
                    class="border-top border-left border-right"><?php echo $this->Constant_model->thaiDate(@$quotation_date, false, false); ?></td>
            </tr>
            <tr>
                <td align="left" valign="top" class="border-left font-11">ที่อยู่ / Address :</td>
                <td align="left" valign="top"> <?php echo @$address; ?></td>
                <td align="left" valign="top" class="border-left font-11">ผู้ที่เสนอ / Proposer :</td>
                <td align="left" valign="top" class="border-top border-left border-right"><?php echo @$proposer; ?></td>
            </tr>
            <tr>
                <td align="left" valign="top" class="border-left font-11">เบอร์มือถือ / Mobile :</td>
                <td align="left" valign="top"> <?php echo @$contact_mobile; ?></td>
                <td align="left" valign="top" class="border-left font-11">เบอร์มือถือ / Mobile :</td>
                <td align="left" valign="top" class="border-top border-left border-right"><?php echo @$mobile; ?></td>
            </tr>
            <tr>
                <td align="left" valign="top" class="border-left font-11">เบอร์ติดต่อ / Tel :</td>
                <td align="left" valign="top"> <?php echo @$contact_tel; ?></td>
                <td align="left" valign="top" class="border-left font-11">เบอร์ติดต่อ / Telephone :</td>
                <td align="left" valign="top"
                    class="border-top border-left border-right"><?php echo @$telephone; ?></td>
            </tr>
            <tr>
                <td align="left" valign="top" class="border-left font-11">เบอร์แฟ็ก / Fax :</td>
                <td align="left" valign="top"> <?php echo @$contact_fax; ?></td>
                <td align="left" valign="top" class="border-left font-11">เบอร์แฟ็ก / Fax:</td>
                <td align="left" valign="top" class="border-top border-left border-right"><?php echo @$fax; ?></td>
            </tr>
            <tr>
                <td align="left" valign="top" class="border-left font-11">อีเมลล์ / Email :</td>
                <td align="left" valign="top"> <?php echo @$contact_email; ?></td>
                <td align="left" valign="top" class="border-left font-11">อีเมล / Email :</td>
                <td align="left" valign="top" class="border-top border-left border-right"><?php echo @$email; ?></td>
            </tr>
            <tr>
                <td align="left" valign="top" class="border-bottom border-top border-left font-11">ระยะเวลายืนราคา /
                    Term of Valid :
                </td>
                <td align="left" valign="top" class="border-bottom border-top"> <?php echo @$term_of_valid; ?></td>
                <td align="left" valign="top" class="border-bottom border-top border-left font-11">การจ่ายเงิน / Pay of
                    Valid
                    :
                </td>
                <td align="left" valign="top"
                    class="border-bottom border-top border-right border-left"><?php echo @$pay_of_valid; ?></td>
            </tr>

        </table>
    </td>
</tr>
<tr>
    <td>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td bgcolor="#FFC000" class="border font-11" width="160">Term of payment :</td>
                <td class="border-right border-top border-bottom"><?php echo @$term_of_payment; ?></td>
            </tr>
        </table>
    </td>
<tr/>
<tr><!-- quotation description info -->
    <td style="height: 450px !important; vertical-align: top;">
        <table class="padding2px" width="100%" cellpadding="0" cellspacing="0">
            <col width="141">
            <col width="580">
            <col width="96">
            <col width="91" span="2">
            <col width="92">
            <tr>
                <td width="130" height="50" align="center" bgcolor="#FFC000"
                    class="border-top border-right border-left border-bottom">
                    ลำดับที่<br>
                    Item No.
                </td>
                <td align="center" bgcolor="#FFC000" class="border-top border-right border-bottom">
                    รายการสินค้า/บริการ<br>
                    Description
                </td>
                <td width="75" align="center" bgcolor="#FFC000" class="border-top border-right border-bottom">จำนวน<br>
                    Quantity
                </td>
                <td width="75" align="center" bgcolor="#FFC000" class="border-top border-right border-bottom">ราคา/หน่วย<br>
                    Price/Unit
                </td>
                <td width="75" align="center" bgcolor="#FFC000" class="border-top border-right border-bottom">ส่วนลด<br>
                    Discount
                </td>
                <td width="75" align="center" bgcolor="#FFC000" class="border-top border-right border-bottom">รวม<br>
                    Amount
                </td>
            </tr>
            <?php if ($countQuotationItem): ?>
                <?php for ($i = 0;
                           $i < 12;
                           $i++): ?>
                    <tr height="20">
                        <td align="center"
                            class="border-right border-left"><?php echo @$objQuotationItem[$i]->item_no; ?></td>
                        <td class="border-right"><?php echo @$objQuotationItem[$i]->description; ?></td>
                        <td height="31" align="right"
                            class="border-right"><?php echo @$objQuotationItem[$i]->quantity > 0 ? str_replace('.00', '&nbsp;&nbsp;', @$objQuotationItem[$i]->quantity."") : "-&nbsp;&nbsp;"; ?></td>
                        <td height="31" align="right"
                            class="border-right"><?php echo @$objQuotationItem[$i]->price > 0 ? number_format(@$objQuotationItem[$i]->price, 2) : "-&nbsp;&nbsp;"; ?></td>
                        <td height="31" align="right"
                            class="border-right"><?php echo @$objQuotationItem[$i]->discount > 0 ? number_format(@$objQuotationItem[$i]->discount, 2) : "-&nbsp;&nbsp;"; ?></td>
                        <td height="31" align="right"
                            class="border-right"><?php echo @$objQuotationItem[$i]->amount > 0 ? number_format(@$objQuotationItem[$i]->amount, 2) : "-&nbsp;&nbsp;"; ?></td>
                    </tr>
                <?php endfor; ?>
                <tr height="20">
                    <td align="center"
                        class="border-right border-left border-bottom"><?php echo @$objQuotationItem[12]->item_no; ?></td>
                    <td class="border-right border-bottom"><?php echo @$objQuotationItem[12]->description; ?></td>
                    <td height="31" align="right"
                        class="border-right border-bottom"><?php echo @$objQuotationItem[12]->quantity > 0 ? @$objQuotationItem[12]->quantity : "-&nbsp;&nbsp;"; ?></td>
                    <td height="31" align="right"
                        class="border-right border-bottom"><?php echo @$objQuotationItem[12]->price > 0 ? number_format(@$objQuotationItem[12]->price, 2) : "-&nbsp;&nbsp;"; ?></td>
                    <td height="31" align="right"
                        class="border-right border-bottom"><?php echo @$objQuotationItem[12]->discount > 0 ? number_format(@$objQuotationItem[12]->discount, 2) : "-&nbsp;&nbsp;"; ?></td>
                    <td height="31" align="right"
                        class="border-right border-bottom"><?php echo @$objQuotationItem[12]->amount > 0 ? number_format(@$objQuotationItem[12]->amount, 2) : "-&nbsp;&nbsp;"; ?></td>
                </tr>
            <?php endif; ?>
        </table>
    </td>
</tr>
<tr><!-- standard condition -->
    <td height="160">
        <table width="100%" height="100%" cellpadding="0" cellspacing="0">
            <col width="141">
            <col width="580">
            <col width="96">
            <col width="91" span="2">
            <col width="92">
            <tr>
                <td width="98" align="left" valign="top">Note :</td>
                <td align="left" valign="top"><?php echo nl2br(@$remark); ?></td>
                <td width="225" height="20" align="left" bgcolor="#FFC000" class="border-top border-right border-left">
                    Discount
                    Total
                </td>
                <td width="75" align="right"
                    class="border-top border-right"><?php echo number_format(@$discount_total, 2); ?></td>
            </tr>
            <tr>
                <td width="98" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td height="20" align="left" bgcolor="#FFC000" class="border-top border-right border-left">Amount</td>
                <td align="right" class="border-top border-right"><?php echo number_format(@$amount, 2); ?></td>
            </tr>
            <tr>
                <td width="98" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td height="20" align="left" bgcolor="#FFC000" class="border-top border-right border-left">Vat 7%</td>
                <td align="right" class="border-top border-right"><?php echo number_format(@$vat, 2); ?></td>
            </tr>
            <tr>
                <td width="98" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td height="20" align="left" bgcolor="#FFC000"
                    class="border-top border-right border-left border-bottom">Total Amount
                </td>
                <td align="right"
                    class="border-top border-right border-bottom"><?php echo number_format(@$total_amount, 2); ?></td>
            </tr>
            <tr>
                <td width="98" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td height="15" colspan="2" align="right">&nbsp;</td>
            </tr>
            <tr>
                <td width="98" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td height="20" colspan="2" align="center" bgcolor="#FFC000"
                    class="border"><?php echo @$total_amount_text; ?></td>
            </tr>
            <tr>
                <td width="98" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td height="15" colspan="2" align="right">&nbsp;</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>
        <table width="100%" style="height:50px;">
            <tr>
                <td align="left" valign="top"><p>Approved By </p>

                    <p>_________________________________________________</p>
                    (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
                </td>
                <td width="300" align="left" valign="top"><p>Present By
                    </p>
                    <?php
                    if (file_exists(@$signature_path)):
                        ?>
                        <img style="margin-top:-65px;position:absolute;margin-left:80px;z-index: -1;"
                             width="200"
                             src="<?php echo $baseUrl . $signature_path; ?>"/>
                    <?php
                    endif;
                    ?>
                    <p align="center">_________________________________________________</p>

                    <p align="center"><strong><?php echo @$proposer ? "( &nbsp; $proposer &nbsp; )" : ""; ?></strong>
                    </p>
                </td>
            </tr>
        </table>
    </td>
</tr>
</thead>
<tbody></tbody>
</table>
</body>
</html>