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
                            <a href="<?php echo $webUrl; ?>dashboard">Home</a>
                            <i class="icon-angle-right"></i>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $webUrl; ?>setting/departmentList">Department</a>
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
                                    <?php if (@$permissionInsert): ?>
                                        <a href="<?php echo $webUrl; ?>department/add" class="btn btn-mini">
                                            <i title="Add"
                                               class="icon-plus"> Add</i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if (@$permission): ?>
                                <div class="box-content nopadding">
                                    <table
                                        class="table table-hover table-nomargin dataTable table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
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
                                                <td class="center"><?php echo $key+1; ?></td>
                                                <td><?php echo $value->title; ?></td>
                                                <td><?php echo $value->description; ?></td>
                                                <td><?php echo "$value->create_datetime"; ?></td>
                                                <td><?php echo $value->update_datetime; ?></td>
                                                <td class="hidden-400">
                                                    <?php if (@$permissionUpdate): ?>
                                                        <a href="<?php echo $webUrl; ?>department/edit/<?php echo $value->id; ?>"
                                                           class="btn" rel="tooltip" title=""
                                                           data-original-title="Edit"><i
                                                                class="icon-edit"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (@$permissionDelete): ?>
                                                        <a href="#messageDeleteData" class="btn" rel="tooltip" title=""
                                                           data-original-title="Delete"
                                                           onclick="urlDelete='<?php echo $webUrl; ?>department/delete/<?php echo $value->id; ?>';"
                                                           role="button" data-toggle="modal">
                                                            <i class="icon-remove"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>

                                        <?php
                                        endforeach;
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else:
                                $this->load->view("permission_page");
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->load->view("footer");
