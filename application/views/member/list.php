<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();

$objData = $this->Member_model->memberList();
?>

<script>
    var urlList = "<?php echo $webUrl; ?>member/memberList";
    function deleteClick(url) {
        if (confirm("คุณต้องการลบข้อมูลใช่หรือไม่")) {
            $.post(url,
                function (result) {
                    if (result == "delete fail") {
                        alert('** เกิดการผิดพลาด');
                    } else {
                        alert(result);
                        innerHtml('#main', urlList);
                    }
                }
            );
        }
        return false;
    }
</script>
<div class="container-fluid">
    <div class="page-header">
        <div class="pull-left">
            <h1>MEMBER</h1>
        </div>
    </div>
    <!-- END: .page-header -->
</div>
<!-- END:.container-fluid -->

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="breadcrumbs">
                <ul>
                    <li>
                        <a href="<?php echo $webUrl; ?>dashboard">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo $webUrl; ?>member">MEMBER</a>
                    </li>
                </ul>
                <div class="close-bread">
                    <a href="#"><i class="icon-remove"></i></a>
                </div>
            </div>
            <!-- END: ,breadcrumbs -->
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span12">
            <div class="box box-color box-bordered">
                <div class="box-title">
                    <h3>
                        <i class="icon-list"></i>
                        MEMBER
                    </h3>

                    <div class="actions">
                        <a href="#" class="btn btn-mini content-refresh"><i title="Refresh"
                                                                            class="icon-refresh"></i></a>
                        <!--                        <a href="#" class="btn btn-mini content-remove"><i title="Remove Table" class="icon-remove"></i></a>-->
                        <a href="#" class="btn btn-mini content-slideUp"><i title="Hide"
                                                                            class="icon-angle-down"></i></a>
                        <a href="#" onclick="innerHtml('#main', '<?php echo $webUrl; ?>member/memberAdd');return false;"
                           class="btn btn-mini"><i title="Add"
                                                   class="icon-plus"></i></a>
                    </div>
                </div>
                <div class="box-content nopadding">
<!--                    <table class="display table table-hover table-nomargin dataTable dataTable-tools table-bordered dataTable-scroll-x"-->
<!--                        id="testDT">-->
                    <table class="table table-hover  dataTable dataTable-tools table-bordered dataTable-scroll-x"
                        id="">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Telephone</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Update Time</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($objData as $key => $value):
                            ?>
                            <tr>
                                <td class="center"><?php echo $value->id; ?></td>
                                <td><?php echo $value->username; ?></td>
                                <td><?php echo "$value->first_name $value->last_name"; ?></td>
                                <td><?php echo $value->telephone; ?></td>
                                <td><?php echo "$value->mobile"; ?></td>
                                <td><?php echo $value->email; ?></td>
                                <td><?php echo $value->update_datetime; ?></td>
                                <td class="hidden-400">
                                    <a href="#"
                                       onclick="innerHtml('#main', '<?php echo $webUrl; ?>member/memberEdit/<?php echo $value->id; ?>'); return false;"
                                       class="btn" rel="tooltip" title="" data-original-title="Edit"><i
                                            class="icon-edit"></i></a>
                                    <a href="#messageDeleteData" class="btn" rel="tooltip" title="" data-original-title="Delete"
                                       onclick="urlDelete='<?php echo $webUrl; ?>member/memberDelete/<?php echo $value->id; ?>?type=1';"
                                       role="button" data-toggle="modal">
                                        <i class="icon-remove"></i>
                                    </a>
                                </td>
                            </tr>

                        <?php
                        endforeach;
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>