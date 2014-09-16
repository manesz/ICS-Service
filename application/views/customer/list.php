<?php

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$this->load->view("header");
$this->load->view("navigator_menu");
$objData = $this->Customer_model->customerList();

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
                        <h1>Customer</h1>
                    </div>
                </div>
                <div class="breadcrumbs">
                    <ul>
                        <li>
                            <a class="link" href="<?php echo $webUrl; ?>dashboard">Home</a>
                            <i class="icon-angle-right"></i>
                        </li>
                        <li>
                            <a class="active link" href="<?php echo $webUrl; ?>customer">Customer</a>
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
                                    Customer
                                </h3>

                                <div class="actions">
                                    <?php if (@$permissionInsert): ?>
                                        <a href="<?php echo $webUrl; ?>customer/add" class="btn btn-mini"><i
                                                title="Add" class="icon-plus"> Add</i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if (@$permission): ?>
                                <div class="box-content nopadding">
                                    <table
                                        class="table table-hover table-nomargin dataTable dataTable-tools table-bordered display dataTable-scroll-x">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>TAX ID</th>
                                            <th>Name TH</th>
                                            <th>Name EN</th>
                                            <th>Telephone</th>
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
                                                <td class="center"><?php echo $key+1; ?></td>
                                                <td><?php echo $value->taxpayer_number; ?></td>
                                                <td><?php echo $value->name_th; ?></td>
                                                <td><?php echo $value->name_en; ?></td>
                                                <td><?php echo "$value->telephone"; ?></td>
                                                <td><?php echo $value->email; ?></td>
                                                <td><?php echo $value->update_datetime; ?></td>
                                                <td class="hidden-400">
                                                    <?php if (@$permissionUpdate): ?>
                                                        <a href="<?php echo $webUrl; ?>customer/edit/<?php echo $value->id; ?>"
                                                           class="btn link" rel="tooltip" title=""
                                                           data-original-title="Edit"><i
                                                                class="icon-edit"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (@$permissionDelete): ?>
                                                        <a href="#messageDeleteData" class="btn" rel="tooltip" title=""
                                                           data-original-title="Delete"
                                                           onclick="urlDelete='<?php echo $webUrl; ?>customer/delete/<?php echo $value->id; ?>';"
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
