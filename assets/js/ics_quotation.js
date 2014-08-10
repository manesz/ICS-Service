
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
});

$(document).on("click", "#btnAddItem", function (e) {
    var $tr = $(".tr_items").last();
    var $clone = $tr.clone();
    $clone.find(':text').val('');
    $tr.after($clone);
    $(".tr_items").last().hide().fadeIn(function () {
        $(".tr_items .item_no").focus();
        $(this).closest('tr').find('.item_id').val("add");
    });
    return false;
});

$(document).on("click", ".btnDeleteItem", function (e) {
    if ($('.btnDeleteItem').length > 1) {
        var id = $(this).closest('tr').find(".item_id").val();
        deleteItem(id);
        $(this).closest('tr').fadeOut(function () {
            $(this).remove();
            $(".tr_items .item_no").focus();
            calculateAmount();
        });
    }
    else $(".tr_items .item_no").focus();
    return false;
});

$(document).on("keydown", ".tr_items input", function (e) {
    if (e.which == 13)
        return false;
});

$(document).on("change", ".tr_items input", function (e) {
    var id = $(this).closest('tr').find('.item_id').val();
    if (id) {
        var url = url_post_edit_item + id;
        var quotation_id = $("#quotation_id").val();
        var data = $(this).closest('tr').find('input').serialize();
        data += '&' + $.param({
            quotation_id: quotation_id
        });
        postData(url, data, '');
    } else {
        $(this).closest('tr').find('.item_id').val("add");
    }
    calculateAmount();
    return false;
});

$(document).on("keypress", ".cost, .quantity, .price, .discount", function (event) {
    if (
        (event.which != 46 || $(this).val().indexOf('.') != -1) &&
            (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
    var text = $(this).val();
    if ((text.indexOf('.') != -1) && (text.substring(text.indexOf('.')).length > 2)) {
        event.preventDefault();
    }
});

function deleteItem(id) {
    var url = url_post_delete_item + id;
    postData(url, {'post': true}, '');
}

function calculateAmount() {
    var sumDiscount = 0;
    var sumAmount = 0;
    var quantity = 0;
    var price = 0;
    var discount = 0;
    var ckDiscount = true;
    var ckQuantity = true;
    var ckPrice = true;
    $('.tr_items').each(function () {
        ckDiscount = true;
        ckQuantity = true;
        ckPrice = true;
//        var ckDiscount = true;
        $(this).find('.quantity').each(function () {
            if ($(this).val())
                quantity = parseFloat($(this).val());
            else ckQuantity = false;
        });
        $(this).find('.price').each(function () {
            if ($(this).val())
                price = parseFloat($(this).val());
            else ckPrice = false;
        });
        $(this).find('.discount').each(function () {
            if ($(this).val()) {
                discount = parseFloat($(this).val());
                sumDiscount += discount;
            } else {
                ckDiscount = false;
                discount = 0;
            }
        });
        if (ckPrice && ckQuantity) {
            sumAmount += quantity * price;
            $(this).find('.amount').val(addCommas((quantity * price) - discount));
        } else {
            $(this).find('.amount').val('');
        }

    });
    var vat = sumAmount * 0.07;
    var total_amount = sumAmount + vat;
    total_amount = total_amount - sumDiscount;
    $("#discount_total").html(addCommas(sumDiscount));
    $("#amount").html(addCommas(sumAmount));
    $("#vat").html(addCommas(vat));
    $("#total_amount").html(addCommas(total_amount));
}

function validate(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault)
            theEvent.preventDefault();
    }
}

function addCommas(nStr) {
    if (isNaN(nStr))return '0.00';
    nStr = Math.round(parseFloat(nStr + "") * 100) / 100;
    nStr += '';
    nStr = nStr.replace(/\,/g, '');
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    x2 = x2.length == 2 ? x2 + '0' : x2;
    x2 = x2 ? x2 : '.00';
    return x1 + x2;
}

