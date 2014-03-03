<?php

$this->load->view("header");
$this->load->view("navigator_menu");
$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();

$objIssue = $this->Issue_model->issueList($id);
$objImage = $this->Issue_model->getImageByIssueID($id);
extract((array)$objIssue[0]);
?>
    <script>

        var url_post_data = "<?php echo $webUrl; ?>issue/issueEdit/<?php echo @$id; ?>";
        var url_list = "<?php echo $webUrl; ?>issue";
        var countImage = <?php echo count((array)$objImage);?>;
        $(document).ready(function () {
            $('#btnCancel').click(function () {
                openUrl(url_list);
                return false;
            });
        });
    </script>
    <script src="<?php echo $baseUrl; ?>assets/js/ics_service_issue.js"></script>
<div class="container-fluid" id="content">

<?php
$this->load->view("sidebar_menu");
?>
    <div id="main">
    <div class="container-fluid">
    <div class="page-header">
        <div class="pull-left">
            <h1>Edit Issue</h1>
        </div>
    </div>
    <div class="breadcrumbs">
        <ul>
            <li>
                <a class="link" href="<?php echo $webUrl; ?>Dashboard">Home</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a class="link" href="<?php echo $webUrl; ?>issue">Issue</a>
                <i class="icon-angle-right"></i>
            </li>
            <li>
                <a class="link" href="#">Edit Issue</a>
            </li>
        </ul>
        <div class="close-bread">
            <a href="#"><i class="icon-remove"></i></a>
        </div>
    </div>

    <div class="row-fluid">
    <div class="span12">
    <div class="box box-color box-bordered">
    <div class="box-title">
        <h3>
            <i class="icon-list"></i> Issue
        </h3>
    </div>
    <!-- END: .box-title -->
    <?php if (@$permission): ?>
        <div class="box-content nopadding">
            <form action="" method="POST" autocomplete="off"
                  class='form-horizontal form-column form-bordered form-validate'
                  id="formPost" name="formPost">
                <div class="span12">
                    <div class="control-group">
                        <label for="name" class="control-label">Title :</label>

                        <div class="controls">
                            <input type="text" name="title" id="title" placeholder="Title"
                                   class="input-block-level" data-rule-required="true"
                                   value="<?php echo @$title; ?>">
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="description" class="control-label">Description :</label>

                        <div class="controls">
                            <textarea name="ck" id="description" rows="5"
                                      class="input-block-level ckeditor"
                                      data-rule-required="true"><?php echo @$description; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="span12" id="groupImage">
                    <div class="box box-color green box-small box-bordered box_image hidden"
                         id="box_image_-0">
                        <div class="box-title">
                            <input type="hidden" id="boxChangeID_-0" value="0">

                            <h3>
                                <i class="icon-picture"></i>
                                Image 0
                            </h3>

                            <div class="actions">
                                <a href="#" id="btnRemoveImage_-0"
                                   onclick="return removeBox(this.id);"
                                   class="btn btn-mini"><i class="icon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">
                            <div class="span12">
                                <div class="control-group ">
                                    <label for="image_-0" class="control-label">Image: </label>

                                    <div class="controls">
                                        <div class="fileupload fileupload-new" id="image_-0"
                                             data-provides="fileupload">
                                            <div class="fileupload-new thumbnail"
                                                 style="width: 200px; height: 150px;">
                                                <img
                                                    src="<?php echo $baseUrl; ?>assets/img/no_img.gif"/>
                                            </div>
                                            <div id="image_preview_-0"
                                                 class="fileupload-preview fileupload-exists thumbnail"
                                                 style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                                <input type="hidden" value="0">
                                                 </div>
                                            <div>
                                                <span class="btn btn-file">
                                                    <span class="fileupload-new">Select image</span>
                                                    <span class="fileupload-exists">Change</span>
                                                    <input type="file" id="imagefile_-0"
                                                           name='imagefile_-0'/>
                                                </span>
                                                <a href="#" class="btn fileupload-exists"
                                                   data-dismiss="fileupload">Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="title_image_-0" class="control-label">Title
                                        :</label>

                                    <div class="controls">
                                        <input type="text" id="title_image_-0"
                                               placeholder="Title"
                                               class="input-block-level">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label for="description_image_-0" class="control-label">Description
                                        :</label>

                                    <div class="controls">
                                        <textarea id="description_image_-0" rows="5"
                                                  class="input-block-level"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php foreach ($objImage as $key => $value) :
                        ?>
                        <div class="box box-color green box-small box-bordered box_image"
                             id="box_image_-<?php echo $key + 1; ?>">
                            <div class="box-title">
                                <input type="hidden" id="boxChangeID_-<?php echo $key + 1; ?>"
                                       value="<?php echo $key + 1; ?>">

                                <h3>
                                    <i class="icon-picture"></i>
                                    Image <?php echo $key + 1; ?>
                                </h3>
                                <?php if ($key): ?>
                                    <div class="actions">
                                        <a href="#" id="btnRemoveImage_-<?php echo $key + 1; ?>"
                                           onclick="return removeBox(this.id);"
                                           class="btn btn-mini"><i class="icon-remove"></i></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="box-content">
                                <div class="span12">
                                    <div class="control-group ">
                                        <label for="image_-<?php echo $key + 1; ?>"
                                               class="control-label">Image: </label>

                                        <div class="controls">
                                            <div class="fileupload fileupload-new"
                                                 id="image_-<?php echo $key + 1; ?>"
                                                 data-provides="fileupload">
                                                <div id="imgThumbnail_-<?php echo $key + 1; ?>"
                                                     class="fileupload-new thumbnail"
                                                     style="width: 200px; height: 150px;">
                                                    <img src="<?php
                                                    echo !file_exists(@$value->image) ? $baseUrl . "assets/img/no_img.gif" :
                                                        $baseUrl . $value->image;
                                                    ?>"/>
                                                </div>
                                                <div id="image_preview_-<?php echo $key + 1; ?>"
                                                     class="fileupload-preview fileupload-exists thumbnail"
                                                     style="max-width: 200px; max-height: 150px; line-height: 20px;">
                                                    <input type="hidden" value="<?php echo $value->id; ?>">
                                                </div>
                                                <div>
                                                    <span id="groupBtn_-<?php echo $key + 1; ?>"
                                                          class="btn btn-file <?php echo !file_exists($value->image) ? "" : 'hide'; ?>">
                                                        <span class="fileupload-new">Select image</span>
                                                        <span class="fileupload-exists">Change</span>
                                                        <input type="file"
                                                               id="imagefile_-<?php echo $key + 1; ?>"
                                                               name='imagefile_-<?php echo $key + 1; ?>'/>
                                                    </span>
                                                    <?php if (file_exists($value->image)): ?>
                                                        <input type="button"
                                                               id="btnDeleteImage_-<?php echo $key + 1; ?>"
                                                               onclick="removeImageIssue('<?php echo $value->image; ?>', <?php echo $key + 1; ?>);"
                                                               class="btn" value="Remove">
                                                    <?php endif; ?>
                                                    <a href="#" class="btn fileupload-exists"
                                                       data-dismiss="fileupload">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="title_image_-<?php echo $key + 1; ?>"
                                               class="control-label">Title
                                            :</label>

                                        <div class="controls">
                                            <input type="text"
                                                   id="title_image_-<?php echo $key + 1; ?>"
                                                   placeholder="Title"
                                                   class="input-block-level"
                                                   value="<?php echo $value->title; ?>">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label for="description_image_-<?php echo $key + 1; ?>"
                                               class="control-label">Description
                                            :</label>

                                        <div class="controls">
                                            <textarea
                                                id="description_image_-<?php echo $key + 1; ?>"
                                                rows="5"
                                                class="input-block-level"><?php echo $value->description; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="span12">
                    <div class="form-actions">
                        <button type="button" class="btn btn-inverse" id="btnAddOtherImage">Add Image
                        </button>
                    </div>
                </div>
                <div class="span12">
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" id="btnSave">Save Issue
                        </button>
                        <button type="button" class="btn" id="btnCancel">Cancel</button>
                    </div>
                </div>
                <!--END:span6 -->
            </form>
        </div>
        <!-- END: .box-content nopadding -->
    <?php else:
        $this->load->view("permission_page");
    endif;
    ?>
    </div>
    <!-- END: .box -->
    </div>
    <!-- END: .span12 -->
    </div>
    <!-- END: .row-fluid -->

    </div>
    <!-- END: #main -->
    </div><!-- END: .container-fluid -->
<?php
$this->load->view("footer");
?>