$(function () {
    $("#signin").click(function () {
        userAuthen();
        return false;
    });
    $("#signOut").click(function () {
        signOut();
        return false;
    });

});

//function list
function userAuthen() {
    var data = {
        username: $("#username").val(),
        password: $("#password").val(),
        page: "signin",
        action: "signIn"
    };//END: data

    $.ajax({
        type: "POST",
        url: "functions.php",
        data: data,
        success: function (data) {
            $("#authenResult").html(data);
        }
    });//END: ajax
}//END: userAuthen

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
}