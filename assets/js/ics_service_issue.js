var strGroupImage = "";
var noImgUrl = baseUrl + "assets/img/no_img.gif";
var countBox = countImage;
function appendImage() {
    var strHtml = strGroupImage;
    countImage += 1;
    countBox += 1;
    strHtml = strHtml.replace(new RegExp("Image 0", 'g'), "Image " + countImage);
    strHtml = strHtml.replace(new RegExp("_-0", 'g'), "_-" + countBox);
    $("#groupImage").append(strHtml);
    $("#box_image_-" + countBox).removeClass("hidden");
    $("#boxChangeID_-" + countBox).val(countImage);
    if (countImage == 1) {
        $(".box-title .actions").remove();
        showHtmlFadeIn("#box_image_-" + countBox);
    } else {
        showHtmlFadeIn("#box_image_-" + countBox, "#title_image_-" + countImage);
    }
}

function removeBox(evn) {
    var id = evn.id.replace("btnRemoveImage_-", "");
    var imageID = $("#image_-" + id + " .oldID").val();
    if (issue_page == 'edit' && imageID != 0) {
        var url = evn.href;
        var hash = url.split('#')[1];
        if (hash) {
            url = webUrl + 'issue/deleteImage/'+ hash;
            $.post(url,
                function (result) {
                    if (result == "delete fail") {
                        clickNotifyError();
                    } else {
                        doRemoveBox(id);
                    }
                }
            ).done(function () {
                    //alert("second success");
                })
                .fail(function () {
                    clickNotifyError();
                })
                .always(function () {
                    //alert("finished");
                });
        } else {
            clickNotifyError();
        }
    } else {
        doRemoveBox(id);
    }
    return false;
}

function doRemoveBox(id){
    var boxName = "#box_image_-" + id;
    var changeID = $("#boxChangeID_-" + id).val();
    var time = 800;
    $(boxName).fadeOut(time, function () {
        reIDBoxNumber(changeID);
        $(boxName).remove();
        countImage -= 1;
        focusToDiv("box_image_-" + countImage, "#title_image_-" + countImage);
    });
}

function saveHtmlToStr() {
    var str = '<div class="box box-color green box-small box-bordered box_image"' +
        'id="box_image_-0">';
    str += $("#box_image_-0").html();
    str += "</div>";
    strGroupImage = str;
}

function reIDBoxNumber(changeID) {
    $("#groupImage").each(function () {
        $('.box_image', this).each(function () {
            var id = this.id;
            id = id.replace("box_image_-", "");
            var oldID = $("#boxChangeID_-" + id, this).val();
            if (oldID != 0) {
                if (oldID > changeID) {
                    var newID = oldID - 1;
                    var strHtml = $("h3", this).html().replace(oldID, newID);
                    $("h3", this).html(strHtml);
                    $("#boxChangeID_-" + id, this).val(newID);
                }
            }
        });
    })
}
//------------------------------------------Add--------------------------//
$(function () {
    saveHtmlToStr();
    if (!countImage) {
        appendImage();
    }
    $("#btnAddOtherImage").click(function () {
        appendImage();
    });
});

$(document).ready(function () {
    $("#formPost").submit(function () {
        disableID("btnSave");
        var checkPost = checkValidateForm("#" + this.id);
        if (checkPost) {
            var arrayImage = [];
            var description = $(".cke_reset").contents().find("body").html();
            $(".fileupload-preview").each(function () {
                var id = this.id.replace("image_preview_-", "");
                if (id != 0) {
                    var imageName = $("#imagefile_-" + id).val();
                    var dataImage = $("img", this).attr("src");
                    var title = $("#title_image_-" + id).val();
                    var description = $("#description_image_-" + id).val();
                    var imageID = $("#image_-" + id + " .oldID").val();
                    var arrayDataImage = [
                        imageName,
                        dataImage,
                        title,
                        description,
                        imageID
                    ];
                    arrayImage.push(arrayDataImage);
                }
            });//alert(arrayImage);
            var data = $(this).serialize();
            data = data + '&' + $.param({
                array_image: arrayImage,
                description: description,
                fileType: "image",
                imagePatch: 'uploads/issue/'
            });
            postData(url_post_data, data, url_list);
        } else {
            enableID("btnSave");
        }
        return false;
    });
});
//------------------------------------------Edit--------------------------//

function removeImageIssue(path, key) {
    if (confirm("ต้องการลบรูปใช่หรือไม่")) {
        doRemoveImage(path, key);
    }
}

function doRemoveImage(path, key) {
    var url_post = webUrl + "upload/deleteImage";
    $.post(url_post, {
            path: path
        },
        function (result) {
            if (result == "delete fail") {
                clickNotifyError();
            } else {
//                    $("#image_path").html("");
                $("#groupBtn_-" + key).show();
                $("#btnDeleteImage_-" + key).hide();
                $("#imgThumbnail_-" + key).html('<img src="' + noImgUrl + '">');
            }
        }
    ).done(function () {
            //alert("second success");
        })
        .fail(function () {
            clickNotifyError();
        })
        .always(function () {
            //alert("finished");
        });
}