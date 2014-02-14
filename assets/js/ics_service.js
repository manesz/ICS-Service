var urlDelete = "";
var strWaitImage = "<div class='wait hidden'></div>";
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
    $("a").click(function(){
        if (this.href.indexOf("#") < 0 && this.href.indexOf("javascript") < 0){
            openUrl(this.href);
            return false;
        }
    });
});

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

function innerHtml(id, href) {
    $("body, html").animate({
            scrollTop: $("body").position().top
        },
        100,
        function () {
        });
    $(id).empty();
    $(id).html(strWaitImage);
    $(id).load(href, function(){
    });
}

function openUrl(url) {
//    var id = "#main";
//    $(id).empty();
//    $(id).html(strWaitImage);
    $(".wait").removeClass("hidden");
    $("body, html").animate({
            scrollTop: $("body").position().top
        },
        100,
        function () {
        });
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
        );
    }
}
function deleteData() {
    $.post(urlDelete,
        function (result) {
            if (result == "delete fail") {
                alert('** เกิดการผิดพลาด');
            } else {
                openUrl(urlList);
            }
        }
    );
    return false;
}