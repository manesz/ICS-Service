var countImage = 1;
var strGroupImage = "";
function appendImage() {
    var strHtml = strGroupImage;
    countImage++;
    strHtml = strHtml.replace(new RegExp("Image 1", 'g'), "Image " + countImage);
    strHtml = strHtml.replace(new RegExp("_-1", 'g'), "_-" + countImage);
    $("#groupImage").append(strHtml);
    showHtmlFadeIn("#box_image_-" + countImage, "#title_image_-" + countImage);
}

function removeBox(id) {
    id = id.replace("btnRemoveImage_-", "");
    var boxName = "#box_image_-" + id;
    var time = 800;
    $(boxName).fadeOut(time, function () {
        $(boxName).remove();
    });
    countImage--;
    return false;
}
//------------------------------------------Add--------------------------//
$(function () {
    $("#btnAddOtherImage").click(function () {
        appendImage();
    });
});

$(document).ready(function () {
    strGroupImage = $("#groupImage").html();

    $("#formPost").submit(function () {
        disableID("btnSave");
        var checkPost = checkValidateForm("#" + this.id);
        if (checkPost) {
            var arrayImage = [];
            var description = $(".cke_reset").contents().find("body").html();
            $(".fileupload-preview").each(function () {
                var id = this.id.replace("image_preview_-", "");
                var imageName = $("#imagefile_-" + id).val();
                var dataImage = $("img", this).attr("src");
                var title = $("#title_image_-" + id).val();
                var description = $("#description_image_-" + id).val();
                var arrayDataImage = [
                    imageName,
                    dataImage,
                    title,
                    description
                ];
                arrayImage.push(arrayDataImage);
            });
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
