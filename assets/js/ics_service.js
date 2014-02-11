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
});

//function list
function userAuthen() {
    $("#authenResult").html('');
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

var strWaitImage = "<div align='center'><img width='50' height='50' src='" +
    baseUrl + "assets/img/loading.gif'/></div>";
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
        //jQuery.validator();
//        $("#testDT").dataTable();
    });
}

function openUrl(url) {
    window.location.href = url;
    return false;
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