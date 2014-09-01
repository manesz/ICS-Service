var urlDelete = "";
var strWaitImage = "<div class='wait hidden'></div>";
var strWaitImageOnTop = "<div class='wait-ontop hidden'></div>";

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

function logFeed() {
    var $el = $("#log_feed");
//    var random = new Array('<span class="label"><i class="icon-plus"></i></span> <a href="#">John Doe</a> added a new photo','<span class="label label-success"><i class="icon-user"></i></span> New user registered','<span class="label label-info"><i class="icon-shopping-cart"></i></span> New order received','<span class="label label-warning"><i class="icon-comment"></i></span> <a href="#">John Doe</a> commented on <a href="#">News #123</a>');
    var auto = $el.parents(".box").find(".box-title .actions .custom-checkbox").hasClass("checkbox-active");
//    var randomIndex = Math.floor(Math.random() * 4);
//    var newElement = random[randomIndex];
    var url_feed = webUrl + 'dashboard?feed=true';
    $.post(url_feed, { max_feed: max_feed + 1}, function (result) {
        if (auto && result != "null") {
            max_feed++;
            $el.prepend("<tr><td>" + result + "</td></tr>").find("tr").first().hide();
            $el.find("tr").first().fadeIn();
            if ($el.find("tbody tr").length > 50) {
                $el.find("tbody tr").last().fadeOut(400, function () {
                    $(this).remove();
                });
            }
        }
        slimScrollUpdate($el.parents(".scrollable"));
        setTimeout(function () {
            logFeed();
        }, 5000);//update ทุกๆ 5 วินาที
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
            if (urlRedirect != "" && urlRedirect != false)
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
    //focusToDiv('main')
}
function hideWaitImage() {
    $(".wait").addClass("hidden");
}

function showWaitImageOnTop() {
    $(".wait-ontop").removeClass("hidden");
    //focusToDiv('main')
}
function hideWaitImageOnTop() {
    $(".wait-ontop").addClass("hidden");
}

function openUrl(url) {
    showWaitImageOnTop();
//    setTimeout(redirectUrl(url), 1000);
    //$('html, body').animate({ scrollTop: $("body").offset().top }, 'slow', function () {
    redirectUrl(url);
    //});
    return false;
}

function redirectUrl(url) {
    showWaitImageOnTop();
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
                    clickNotifyError('เกิดข้อผิดพลาด กรุณาลองใหม่');
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
    if (message == undefined) {
        message = 'เกิดข้อผิดพลาด กรุณาลองใหม่';
    }
    $("#btnNotifyError").attr('data-notify-message', message);
    $("#btnNotifyError").click();
    $(".gritter-with-image").addClass("gritter-without-image");
    $(".gritter-without-image").removeClass("gritter-with-image");
    $(".gritter-item img").remove();
}

function focusToDiv(id, focusID) {
//    if (id != undefined) {
//        if (id.indexOf('#') < 0 ) {
//            id = "#" + id;
//        }
//    }
//    if (focusID != undefined ){
//        if (focusID.indexOf('#') < 0 ){
//            focusID = "#" + focusID;
//        }
//    }
    $('html, body').animate({ scrollTop: $(id).offset().top }, 'slow', function () {
        if (focusID != undefined) {
            $(focusID).focus();
        }
    });
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
            focusToDiv(id, focusID);
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
    $(".user").hover(function () {
            $(".dropdown", this).addClass("open");
        }, // over
        function (e) {
            $(".dropdown", this).removeClass("open");
        });
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

    $("#navigation").prepend(strWaitImageOnTop);
    $("a").click(function () {
        if (this.href.indexOf("#") < 0 && this.href.indexOf("javascript") < 0 && this.href != "") {
            openUrl(this.href);
            return false;
        }
    });
    $("#title").focus();
    $("#name").focus();
    $("#to").focus();
});