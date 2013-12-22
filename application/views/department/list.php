<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$this->load->view("cms/header");
$this->load->view("cms/navigator");

$objData = $this->Department_model->departmentList();
?>

    <script>
        function deleteClick(url) {
            if (confirm("คุณต้องการลบข้อมูลใช่หรือไม่")) {
                $.post(url,
                    function (result) {
                        if (result == "delete fail") {
                            alert('** เกิดการผิดพลาด');
                        } else {
                            alert(result);
                            window.location.reload();
                        }
                    }
                );
            }
            return false;
        }
    </script>
    <div class="container-fluid" id="content">

        <?php
        $this->load->view("cms/sidebar");
        ?>
        <div id="main">
            <div class="container-fluid">
                <div class="page-header">
                    <div class="pull-left">
                        <h1>Department</h1>
                    </div>
                </div>
                <div class="breadcrumbs">
                    <ul>
                        <li>
                            <a href="<?php echo $webUrl; ?>Dashboard">Home</a>
                            <i class="icon-angle-right"></i>
                        </li>
                        <li>
                            <a class="active" href="#">Department</a>
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
                                    <i class="icon-list"></i>
                                    Department
                                </h3>
                                <div class="actions">
                                    <a href="#" class="btn btn-mini content-refresh"><i title="Refresh" class="icon-refresh"></i></a>
                                    <a href="#" class="btn btn-mini content-remove"><i title="Remove Table" class="icon-remove"></i></a>
                                    <a href="#" class="btn btn-mini content-slideUp"><i title="Hide" class="icon-angle-down"></i></a>
                                    <a href="<?php echo $webUrl; ?>setting/departmentAdd" class="btn btn-mini"><i title="Add" class="icon-plus"></i></a>
                                </div>
                            </div>
                            <div class="box-content nopadding">
                                <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>title</th>
                                        <th>description</th>
                                        <th>create_datetime</th>
                                        <th>update_datetime</th>
                                        <th>Edit</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    foreach ($objData as $key => $value):
                                        ?>
                                        <tr>
                                            <td class="center"><?php echo $value->id; ?></td>
                                            <td><?php echo $value->title; ?></td>
                                            <td><?php echo $value->description; ?></td>
                                            <td><?php echo "$value->create_datetime"; ?></td>
                                            <td><?php echo $value->update_datetime; ?></td>
                                            <td class="hidden-400">
                                                <a href="#" onclick="openUrl('<?php echo $webUrl; ?>setting/departmentEdit/<?php echo $value->id; ?>'); return false;"
                                                   class="btn" rel="tooltip" title="" data-original-title="Edit"><i class="icon-edit"></i></a>
                                                <a href="#" class="btn" rel="tooltip" title="" data-original-title="Delete"
                                                   onclick="return deleteClick('<?php echo $webUrl; ?>setting/departmentDelete/<?php echo $value->id; ?>');"><i class="icon-remove"></i></a>
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
        </div>
    </div>
<?php
$this->load->view("cms/footer");
