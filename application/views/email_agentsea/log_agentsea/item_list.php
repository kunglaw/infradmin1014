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
                    <span>
                        <a href="<?php echo base_url(); ?>agentsea" style="color: #3093E4;">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </span>
                    LOG: <?php echo $item_name; ?>
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

                                <?php
                                echo form_input(
                                    array(
                                        "class" => "search",
                                        "name" => "filter_1",
                                        "placeholder" => "Action"
                                    )
                                );
                                ?>

                            </div>
                            <!-- /.col-md-12 -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-list">
                                        <thead class="button-green-white">
                                        <tr>
                                            <th>Username</th>
                                           	<th>Nama</th>
                                            <th>Action</th>
                                            <th>IP Address</th>
                                            <th>User Agent</th>
                                            <th>Session ID</th>
                                            <th>Date</th>
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
            searching: true,
            pageLength: 30,
            dom: '<"H"r>t<"F"ip>',
            order: [
                [2, 'desc']
            ],
            columns: [
				
				{ visible: true, searchable: true, orderable: true, className: "left linkable", width: "", data: "username", name: "username"},
                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "", data: "nama", name: "nama"},
				{ visible: true, searchable: true, orderable: true, className: "left linkable name", width: "20%", data: "action", name: "action"},
				{ visible: true, searchable: true, orderable: true, className: "left linkable", width: "", data: "ip_address", name: "ip_address"},
                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "50%", data: "user_agent", name: "user_agent"},
				{ visible: true, searchable: true, orderable: true, className: "left linkable", width: "", data: "session_id", name: "session_id"},
              
                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "20%", data: "action_time_shown", name: "action_time_shown"},

                { visible: false, searchable: false, orderable: false, className: "left", width: "3%", data: "action_time_hidden"}
            ],
            responsive: true,
            drawCallback: function() {


                listCheckboxes = {};
                $("input[name=id_all]").prop("checked", false);
            }
        };


        $(document).ready(function () {

            oTable = $('#dataTables-list').DataTable(settings);

            $("input[name=filter_1]").on("keyup change", function () {
                oTable.column(0).search($(this).val()).draw();
            });
        });

    </script>

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>