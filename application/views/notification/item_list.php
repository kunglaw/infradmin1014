<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 29/10/14
 * Time: 13:00
 */
?>
<?php $this->load->view("element/header"); ?>

    <!-- DataTables CSS -->
    <link href="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo bower_url(); ?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    NOTIFICATION LIST
                </h1>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->


        <?php show_notification(); ?>


        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-list">
                                        <thead class="button-green-white">
                                            <tr>
                                                <th>Notification</th>
                                                <th>Action</th>

                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!-- /.row -->


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
    $modal_block_data = array();
    $modal_block_data["route"] = $block_route;
    $this->load->view("modal/block_confirmation", $modal_block_data);
    $this->load->view("modal/unblock_confirmation", $modal_block_data);

    $modal_reject_request_data = array();
    $modal_reject_request_data["route"] = $notification_route;
    $this->load->view("modal/reject_request_confirmation", $modal_reject_request_data);

    $modal_delete_data = array();
    $modal_delete_data["table_name"] = $delete_table_name;
    $this->load->view("modal/delete_confirmation", $modal_delete_data);
    ?>


    <!-- DataTables JavaScript -->
    <script src="<?php echo bower_url(); ?>datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

        var source = "<?php echo isset($dt_list_source) ? $dt_list_source : ""; ?>";
        var baseURL = "<?php echo $base_url; ?>";
        var tableName = "<?php echo $table_name; ?>"; // for bulk action
        var controllerName = "<?php echo $controller_name; ?>"; // for link to page detail
        var oTable = null;

        var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

        var settings = {
            processing: true,
            autoWidth: false,
            ajax: {
                url: source,
                type: "POST",
                data: function(data) {
                    data.token_field = csrfHash;
                }
            },
            serverSide: true,
            lengthChange: false,
            searching: false,
            pageLength: 10,
            dom: '<"H"r>t<"F"p>',
            order: [
                [4, 'desc']
            ],
            columns: [

                { visible: true, searchable: false, orderable: false, className: "left linkable", width: "80%", data: "notification_text", name: "notification_text"},
                { visible: true, searchable: false, orderable: false, className: "center", width: "20%", data: "notification_action", name: "notification_action"},

                { visible: false, data: "type", name: "type"},
                { visible: false, data: "target", name: "target"},
                { visible: false, data: "source", name: "source"},
                { visible: false, data: "destination", name: "destination"},
                { visible: false, data: "status", name: "status"},
                { visible: false, data: "time", name: "time"}
            ],
            responsive: true,
            drawCallback: function() {


                listCheckboxes = {};
                $("input[name=id_all]").prop("checked", false);
            }
        };


        $(document).ready(function () {

            oTable = $('#dataTables-list').DataTable(settings);

            $("#dataTables-list").on("click", "td.linkable", function () {

                var childDiv = $(this).children("div");

                var reference = childDiv.attr("value");
                var routeDetail = childDiv.attr("route");
                document.location.href = baseURL + routeDetail + "/detail/page/" + reference;
            });
        });

    </script>

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>