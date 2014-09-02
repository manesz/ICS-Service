<?php

/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 8/8/2557
 * Time: 8:35 น.
 */
class Quotation_model extends CI_Model
{
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->tbQuotation = $this->Constant_model->tbQuotation;
        $this->tbQuotationItem = $this->Constant_model->tbQuotationItem;
        $this->tbProject = $this->Constant_model->tbProject;
        $this->tbCustomer = $this->Constant_model->tbCustomer;
    }

    private $tbQuotation = "";
    private $tbQuotationItem = "";
    private $tbProject = "";
    private $tbCustomer = "";

    function quotationList($id = 0, $orderBy = "")
    {
        $strAnd = $id == 0 ? "" : " AND a.id = $id";
        $strOrder = $orderBy ? " ORDER BY $orderBy" : " ORDER BY a.id DESC";
        $sql = "
            SELECT
              a.*,
              b.name_en AS project_name_en,
              b.name_th AS project_name_th,
              c.name_en AS customer_name_en,
              c.name_th AS customer_name_th
            FROM
              `$this->tbQuotation` a
            LEFT JOIN `$this->tbProject` b
            ON (a.project_id = b.id AND b.publish = 1)
            LEFT JOIN `$this->tbCustomer` c
            ON (b.customer_id = c.id AND c.publish = 1)
            WHERE 1
            AND a.publish = 1
            $strAnd
            $strOrder
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return (object)array();
        }
    }

    function genQuotationNo()
    {
        $monthNow = date('m');
        $strQuotationNo = date("Y") + 543;
        $strQuotationNo = substr($strQuotationNo, -2) . date('m');
        $sql = "
            SELECT
              COUNT(`id`) AS count
            FROM
              `ics_quotation`
            WHERE 1
              AND MONTH(`create_datetime`) = '$monthNow'
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            $count = $result[0]->count + 1;
            $invID = str_pad($count, 3, '0', STR_PAD_LEFT);
            return "ICS-$strQuotationNo" . $invID;
        } else {
            return "ICS-$strQuotationNo" . '0001';
        }
    }

    function quotationAdd($post)
    {
        extract($post);
        $data = array(
            'project_id' => intval(@$project_id),
            'contact_name' => trim(@$contact_name),
            'customer_name' => trim(@$customer_name),
            'address' => trim(@$address),
            'contact_mobile' => trim(@$contact_mobile),
            'contact_tel' => trim(@$contact_tel),
            'contact_fax' => trim(@$contact_fax),
            'contact_email' => trim(@$contact_email),
            'quotation_no' => trim(@$quotation_no),
            'quotation_date' => @$quotation_date,
            'proposer' => trim(@$proposer),
            'mobile' => trim(@$mobile),
            'telephone' => trim(@$telephone),
            'fax' => trim(@$fax),
            'email' => trim(@$email),
            'signature_path' => trim(@$signature_path),
            'term_of_valid' => trim(@$term_of_valid),
            'pay_of_valid' => trim(@$pay_of_valid),
            'term_of_payment' => trim(@$term_of_payment),
            'remark' => trim(@$remark),
            'create_datetime' => date('Y-m-d H:i:s'),
            'update_datetime' => "0000-00-00 00:00:00",
            'publish' => 1,
        );
        $data = $this->calculateAmount($data, $post);
        $this->db->insert($this->tbQuotation, $data);
        $id = $this->db->insert_id($this->tbQuotation);
        if (!$id) return false;
        $data['id'] = $id;
        $this->Log_model->logAdd('add quotation', $this->tbQuotation, __LINE__, $data);

        //add quotation item
        $post['quotation_id'] = $id;
        if (!$this->quotationItemAdd($post))
            return false;
        return $id;
    }

    function quotationEdit($id, $post)
    {
        extract($post);
        $data = array(
            'id' => $id,
            'project_id' => intval(@$project_id),
            'contact_name' => trim(@$contact_name),
            'customer_name' => trim(@$customer_name),
            'address' => trim(@$address),
            'contact_mobile' => trim(@$contact_mobile),
            'contact_tel' => trim(@$contact_tel),
            'contact_fax' => trim(@$contact_fax),
            'contact_email' => trim(@$contact_email),
            'quotation_no' => trim(@$quotation_no),
            'quotation_date' => @$quotation_date,
            'proposer' => trim(@$proposer),
            'mobile' => trim(@$mobile),
            'telephone' => trim(@$telephone),
            'fax' => trim(@$fax),
            'email' => trim(@$email),
            'signature_path' => trim(@$signature_path),
            'term_of_valid' => trim(@$term_of_valid),
            'pay_of_valid' => trim(@$pay_of_valid),
            'term_of_payment' => trim(@$term_of_payment),
            'remark' => trim(@$remark),
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 1,
        );
        $data = $this->calculateAmount($data, $post);

        //add quotation item
        $post['quotation_id'] = $id;
        if (!$this->quotationItemAdd($post))
            return false;

        $result = $this->Log_model->logAdd('edit quotation', $this->tbQuotation, __LINE__, $data);
        if (!$result) {
            return false;
        }
        return $this->db->update($this->tbQuotation, $data, array('id' => $id));
    }

    function quotationItemAdd($post)
    {
        extract($post);
        foreach ($item_no as $key => $value) {
            $amount = (round(@$price[$key], 2) * @$quantity[$key]) - round(@$discount[$key], 2);
            $data = array(
                'quotation_id' => intval(@$quotation_id),
                'item_no' => trim(@$value),
                'description' => @$description[$key],
                'quantity' => intval(@$quantity[$key]),
                'cost' => round(@$cost[$key], 2),
                'price' => round(@$price[$key], 2),
                'discount' => round(@$discount[$key], 2),
                'amount' => $amount,
                'create_datetime' => date('Y-m-d H:i:s'),
                'update_datetime' => "0000-00-00 00:00:00",
                'publish' => 1,
            );
            if (@$item_id[$key] == 'add') {//ถ้ายังไม่มีการสร้าง quotation item
                $result = $this->db->insert($this->tbQuotationItem, $data);
                if (!$result)
                    return false;
                $this->Log_model->logAdd('add quotation item', $this->tbQuotationItem, __LINE__, $data);
            }
        }
        return true;
    }

    function quotationItemEdit($id, $post)
    {
        extract($post);
        $quotation_id = intval(@$quotation_id);
        $item_no = @$item_no[0];
        $description = @$description[0];
        $quantity = round(doubleval(@$quantity[0]), 2);
        $cost = round(doubleval(@$cost[0]), 2);
        $price = round(doubleval(@$price[0]), 2);
        $discount = round(doubleval(@$discount[0]), 2);
        $amount = ($price * $quantity) - $discount;
        $data = array(
            'id' => $id,
            'quotation_id' => $quotation_id,
            'item_no' => $item_no,
            'description' => $description,
            'quantity' => $quantity,
            'cost' => $cost,
            'price' => $price,
            'discount' => $discount,
            'amount' => $amount,
            'update_datetime' => date('Y-m-d H:i:s'),
            'publish' => 1,
        );
        $result = $this->db->update($this->tbQuotationItem, $data, array('id' => $id));
        if (!$result) return false;
        return $this->Log_model->logAdd('edit quotation item',
            $this->tbQuotationItem, __LINE__, $data);
    }

    function quotationItemList($id = 0, $quotationID = 0, $orderBy = "")
    {
        $strAnd = $id == 0 ? " AND quotation_id = $quotationID" :
            " AND id = $id AND quotation_id = $quotationID";
        $strOrder = $orderBy ? " ORDER BY $orderBy" : " ORDER BY id ASC";
        $sql = "
            SELECT
              *
            FROM `$this->tbQuotationItem`
            WHERE 1
            AND publish = 1
            $strAnd
            $strOrder
        ";
        $query = $this->db->query($sql);
        if ($query->num_rows()) {
            $result = $query->result();
            return $result;
        } else {
            return (object)array();
        }
    }

    function calculateAmount($data, $post)
    {
        extract($post);
        $sumAmount = 0;
        $sumDiscount = 0;
        foreach ($item_no as $key => $value) {
            $sumAmount += (round($price[$key], 2) * $quantity[$key]) - round($discount[$key], 2);
            $sumDiscount += round($discount[$key], 2);
        }
        $vat = round($sumAmount * 0.07, 2);
        $totalAmount = $sumAmount + $vat;
        $totalAmountText = $this->Constant_model->ThaiBahtConversion($totalAmount);
        $data['discount_total'] = $sumDiscount;
        $data['amount'] = $sumAmount;
        $data['vat'] = $vat;
        $data['total_amount'] = $totalAmount;
        $data['total_amount_text'] = $totalAmountText;
        return $data;
    }

    function updateAmount()
    {

    }
}