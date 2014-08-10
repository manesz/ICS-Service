<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 8/8/2557
 * Time: 8:34 น.
 */

$webUrl = $this->Constant_model->webUrl();
$baseUrl = base_url();
$this->load->view("header");
$this->load->view("navigator_menu");

$objData = $this->Quotation_model->quotationList();
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
                        <h1>Quotation</h1>
                    </div>
                </div>
                <div class="breadcrumbs">
                    <ul>
                        <li>
                            <a class="link" href="<?php echo $webUrl; ?>dashboard">Home</a>
                            <i class="icon-angle-right"></i>
                        </li>
                        <li>
                            <a class="active" href="<?php echo $webUrl; ?>quotation">Quotation</a>
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
                                    Quotation
                                </h3>

                                <div class="actions">
                                    <?php if (@$permissionInsert): ?>
                                        <a href="<?php echo $webUrl; ?>quotation/add" class="btn btn-mini">
                                            <i title="Add"
                                               class="icon-plus"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if (@$permission): ?>
                                <div class="box-content nopadding">
                                    <table
                                        class="table table-hover table-nomargin dataTable dataTable-tools table-bordered">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Project</th>
                                            <th>Company</th>
                                            <th>Quotation Date</th>
                                            <th>Update Datetime</th>
                                            <th>Edit</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php
                                        foreach ($objData as $key => $value):
                                            ?>
                                            <tr>
                                                <td class="center"><?php echo $key + 1; ?></td>
                                                <td><?php if ($value->project_name_en && $value->project_name_th) {
                                                        echo "$value->project_name_en ($value->project_name_th)";
                                                    } else if (!$value->project_name_en && $value->project_name_th) {
                                                        echo $value->project_name_th;
                                                    } else {
                                                        echo '-';
                                                    } ?></td>
                                                <td><?php if ($value->company_name_en && $value->company_name_th) {
                                                        echo "$value->company_name_en ($value->company_name_th)";
                                                    } else if (!$value->company_name_en && $value->company_name_th) {
                                                        echo $value->company_name_th;
                                                    } else {
                                                        echo '-';
                                                    } ?></td>
                                                <td><?php echo "$value->quotation_date"; ?></td>
                                                <!--                                                <td>-->
                                                <?php //echo "$value->quotation_date"; ?><!--</td>-->
                                                <td><?php echo $value->update_datetime; ?></td>
                                                <td class="hidden-400">
                                                    <?php if (@$permissionUpdate): ?>
                                                        <a href="<?php echo $webUrl; ?>quotation/edit/<?php echo $value->id; ?>"
                                                           class="btn" rel="tooltip" title=""
                                                           data-original-title="Edit"><i
                                                                class="icon-edit"></i></a>
                                                    <?php endif; ?>
                                                    <?php if (@$permissionDelete): ?>
                                                        <a href="#messageDeleteData" class="btn" rel="tooltip" title=""
                                                           data-original-title="Delete"
                                                           onclick="urlDelete='<?php echo $webUrl; ?>quotation/delete/<?php echo $value->id; ?>';"
                                                           role="button" data-toggle="modal">
                                                            <i class="icon-remove"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <a href="<?php echo $webUrl; ?>quotation/print/<?php echo $value->id; ?>"
                                                       class="btn" rel="tooltip" title=""
                                                       data-original-title="Print"><i
                                                            class="icon-print"></i></a>
                                                    <a href="<?php echo $webUrl; ?>quotation/print/<?php echo $value->id; ?>"
                                                       class="btn" rel="tooltip" title=""
                                                       data-original-title="Download Excel"><i
                                                            class="icon-download-alt"></i></a>
                                                </td>
                                            </tr>

                                        <?php
                                        endforeach;
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php
                            else:
                                $this->load->view("permission_page");
                            endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->load->view("footer");
