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
                        <a href="<?php echo base_url(); ?>vessel" style="color: #3093E4;">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </span>
                    VESSEL DETAIL

                    <span class="pull-right">
                        <a href="#" class="delete-one-button button-green-white"
                                data-toggle="modal" data-target="#delete-one-confirmation">

                            Delete
                        </a>
                        <input type="hidden" class="object-id" value="<?php echo $ship_id; ?>">
                    </span>
                </h1>


            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->


        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="col-md-12">

                            <table class="company-detail">
                                <thead class="button-green-white">
                                <tr>
                                    <td colspan="2">
                                        <?php echo $ship_name; ?>
                                    </td>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td>Type</td>
                                    <td><?php echo $ship_type; ?></td>
                                </tr>

                                <tr>
                                    <td>Description</td>
                                    <td><?php echo $description; ?></td>
                                </tr>

                                <tr>
                                    <td>Flag</td>
                                    <td><?php echo $nationality; ?></td>
                                </tr>

                                <tr>
                                    <td>Weight</td>
                                    <td><?php echo $weight; ?></td>
                                </tr>

                                <tr>
                                    <td>Engine</td>
                                    <td><?php echo $engine; ?></td>
                                </tr>

                                <tr>
                                    <td>Built</td>
                                    <td><?php echo $built; ?></td>
                                </tr>

                                </tbody>
                            </table>

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

    <?php
    $modal_delete_data = array();
    $modal_delete_data["table_name"] = $delete_table_name;
    $modal_delete_data["parent_route"] = $parent_route;
    $this->load->view("modal/delete_confirmation", $modal_delete_data);
    ?>

<script type="text/javascript">

    var baseURL = "<?php echo base_url(); ?>";

    $(document).ready(function() {
        $("#delete-many-confirmation #delete-button").click(function() {
            window.location.href = baseURL + "vessel";
        });
    })
</script>

<?php $this->load->view("element/footer"); ?>