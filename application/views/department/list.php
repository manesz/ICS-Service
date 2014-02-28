<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$this->load->view("header");
$this->load->view("navigator_menu");

$objData = $this->Department_model->departmentList();
?>

    <script>
    </script>
    <div class="container-fluid" id="content">

        <?php
        $this->load->view("sidebar_menu");
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
                            <a class="link" href="<?php echo $webUrl; ?>dashboard">Home</a>
                            <i class="icon-angle-right"></i>
                        </li>
                        <li>
                            <a class="active link" href="<?php echo $webUrl; ?>setting/departmentList">Department</a>
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
                                    <a href="<?php echo $webUrl; ?>setting/departmentAdd" class="btn btn-mini">
                                        <i title="Add"
                                           class="icon-plus"></i></a>
                                </div>
                            </div>
                            <div class="box-content nopadding">
                                <table class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Create Datetime</th>
                                        <th>Update Datetime</th>
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
                                                <a href="<?php echo $webUrl; ?>setting/departmentEdit/<?php echo $value->id; ?>"
                                                   class="btn link" rel="tooltip" title="" data-original-title="Edit"><i
                                                        class="icon-edit"></i></a>
                                                <a href="#messageDeleteData" class="btn" rel="tooltip" title=""
                                                   data-original-title="Delete"
                                                   onclick="urlDelete='<?php echo $webUrl; ?>setting/departmentDelete/<?php echo $value->id; ?>';"
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
        </div>
    </div>
<?php
$this->load->view("footer");
