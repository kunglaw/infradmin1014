<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 29/10/14
 * Time: 13:00
 */
?>
<?php $this->load->view("element/header"); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    <span>
                        <a href="<?php echo base_url(); ?>vacantsea" style="color: #3093E4;">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </span>
                    VACANTSEA DETAIL
                </h1>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->


        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="row" style="margin-bottom: 80px;">
                            <div class="col-md-12">

                                <table class="company-detail">
                                    <thead class="button-green-white">
                                    <tr>
                                        <td colspan="2">
                                            <?php echo $vacantsea; ?>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <tr>
                                        <td>Company</td>
                                        <td><?php echo $company; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Description</td>
                                        <td><?php echo $description; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Department</td>
                                        <td><?php echo $department; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Navigation Area</td>
                                        <td><?php echo $navigation_area; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Annual Salary</td>
                                        <td>
                                            <?php
                                            if (is_numeric($annual_sallary)) {
                                                echo number_format($annual_sallary, 0);
                                            } else {
                                                echo $annual_sallary;
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>Sallary Curr</td>
                                        <td><?php echo $sallary_curr; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Sallary Range</td>
                                        <td><?php echo $sallary_range; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Benefit</td>
                                        <td><?php echo $benefits; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Contract Type</td>
                                        <td><?php echo $contract_type; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Contract Dynamic</td>
                                        <td><?php echo $contract_dynamic; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Ship</td>
                                        <td><?php echo $ship; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Ship Type</td>
                                        <td><?php echo $ship_type; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Requested Certificates</td>
                                        <td><?php echo $requested_certificates; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Requested COC</td>
                                        <td><?php echo $requested_coc; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Experience</td>
                                        <td><?php echo $experience; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Nationality</td>
                                        <td><?php echo $nationality; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Created Date</td>
                                        <td><?php echo $create_date; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Expired Date</td>
                                        <td><?php echo $expired_date; ?></td>
                                    </tr>

                                    <tr>
                                        <td>Total Viewer</td>
                                        <td><?php echo $total_viewer; ?></td>
                                    </tr>

                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->

    </div>
    <!-- /#page-wrapper -->

<?php $this->load->view("element/footer"); ?>