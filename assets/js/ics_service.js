var urlDelete = "";
var strWaitImage = "<div class='wait hidden'></div>";

//function list
function userAuthen() {
    $("#authenResult").html(strWaitImage);
    var data = {
        username: $("#username").val(),
        password: $("#password").val()
    };//END: data

    $.ajax({
        type: "POST",
        url: webUrl + "signin",
        data: data,
        success: function (data) {
            $("#authenResult").html(data);
            enableID("btnSignIn");
        }, error: function (XMLHttpRequest, textStatus, errorThrown) {
            clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
        }

    });//END: ajax
}//END: userAuthen


/*
 function signOut() {
 alert("signOut");//DEBUG
 var data = {
 page: "signin",
 action: "signOut"
 }
 $.ajax({
 type: "POST",
 url: "functions.php",
 data: data,
 success: function (data) {
 $("#resultSignOut").html(data);
 }
 });
 }*/

function postData(url, data, urlRedirect) {
    showWaitImage();
    disableID("btnAdd");
    disableID("btnSave");
    disableID("btnCancel");
    $.post(url, data, function (result) {
        if (result == "add fail" || result == "edit fail") {
            clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
        } else {
            clickNotifyUpdate();
            if (urlRedirect != "")
                openUrl(urlRedirect);
        }
//        alert(result);
        enableID("btnAdd");
        enableID("btnSave");
        enableID("btnCancel");
        hideWaitImage();
    })
        .done(function () {
            //alert("second success");
        })
        .fail(function () {
            clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
            enableID("btnAdd");
            enableID("btnSave");
            enableID("btnCancel");
            hideWaitImage();
        })
        .always(function () {
            //alert("finished");
        });
}

function postDataSetHtml(id, url, data) {
    $(id).empty();
    $(id).html(strWaitImage);
    if (url.indexOf('?') > -1) {
        url = url + "&url_type=inner";
    } else {
        url = url + "?url_type=inner";
    }
    $.post(url, data, function (result) {
        $(id).fadeIn(300, function () {
            $(this).html(result);
        });
    })
        .done(function () {
            //alert("second success");
        })
        .fail(function () {
            clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
        })
        .always(function () {
            //alert("finished");
        });
}

function innerHtml(id, href) {
    $(id).empty();
    $(id).html(strWaitImage);
    if (href.indexOf('?') > -1) {
        href = href + "&url_type=inner";
    } else {
        href = href + "?url_type=inner";
    }
    $(id).load(href);
    $(id).load(href, function (response, status, xhr) {
        if (status == "error") {
            var msg = "Sorry but there was an error: ";
            $(id).html(msg + xhr.status + " " + xhr.statusText);
            clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
        }
    });
}

function showWaitImage() {
    $(".wait").removeClass("hidden");
    $("body, html").animate({
            scrollTop: $("body").position().top
        },
        100,
        function () {
        });
}
function hideWaitImage() {

    $(".wait").addClass("hidden");
}

function openUrl(url) {
    showWaitImage();
    setTimeout(redirectUrl(url), 1000);
    return false;
}

function redirectUrl(url) {
    window.location.href = url;
}

function disableID(id) {
    $('#' + id).prop('disabled', true);
}
function enableID(id) {
    $('#' + id).prop('disabled', false);
}

function checkValidateForm(id) {
    var checkPost = true;
    $(id + " .error").each(function () {
        var className = $(this).attr('class');
        var index = className.indexOf("valid");
        if (index < 0) {
            checkPost = false;
        }
    });
    return checkPost;
}

function removeImage(path) {
    if (confirm("ต้องการลบรูปใช่หรือไม่")) {
        var url_post = webUrl + "upload/deleteimage";
        var noImgUrl = baseUrl + "assets/img/no_img.gif";
        $.post(url_post, {
                path: path
            },
            function (result) {
                if (result == "delete fail") {
                    alert('** เกิดข้อผิดพลาด');
                } else {
                    $("#image_path").html("");
                    $("#groupBtn").show();
                    $("#btnDeleteImage").hide();
                    $("#imgThumbnail").html('<img src="' + noImgUrl + '">');
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
}
function deleteData() {
    if (urlDelete != "") {
        $.post(urlDelete, function (result) {
            if (result == "delete fail") {
                clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
            } else {
                clickNotifyUpdate();
                openUrl(window.location.href);
            }
        })
            .done(function () {
                //alert("second success");
            })
            .fail(function () {
                clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
            })
            .always(function () {
                //alert("finished");
            });
    }
}
function clickNotifyUpdate() {
    //btnNotifyUpdate
    $("#btnNotifyUpdate").click();
    $(".gritter-with-image").addClass("gritter-without-image");
    $(".gritter-without-image").removeClass("gritter-with-image");
    $(".gritter-item img").remove();

}
function clickNotifyError(message) {
    $("#btnNotifyError").attr('data-notify-message', message);
    $("#btnNotifyError").click();
    $(".gritter-with-image").addClass("gritter-without-image");
    $(".gritter-without-image").removeClass("gritter-with-image");
    $(".gritter-item img").remove();
}

function scrollTop() {
    $("body, html").animate({
            scrollTop: $("body").position().top
        },
        500,
        function () {
        });
}

function showHtmlFadeIn(id, focusID) {
    var time = 800;
    $(id).hide();
    $(id).fadeIn(time, function () {
        $(this).removeClass("hidden");
        if (focusID != undefined) {
            $(focusID).focus();
        }
    });
}
function showHtmlFadeOut(id) {
    var time = 800;
    $(id).fadeOut(time, function () {
        $(this).addClass("hidden");
    });

}

$(function () {
    $("#frmSignIn").submit(function () {
        disableID("btnSignIn");
        var checkPost = checkValidateForm("#frmSignIn");
        if (checkPost) {
            userAuthen();
        } else {
            enableID("btnSignIn");
        }
        return false;
    });

    $("#main").prepend(strWaitImage);
    $("a").click(function () {
        if (this.href.indexOf("#") < 0 && this.href.indexOf("javascript") < 0) {
            openUrl(this.href);
            return false;
        }
    });
    $("#title").focus();
    $("#name").focus();
    $("#to").focus();
});