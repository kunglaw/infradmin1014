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
                    VACANTSEA MANAGEMENT

                    <span class="pull-right">
                        <a href="<?php echo base_url(); ?>vacantsea/dashboard" class="button-green-white">
                            <i class="fa fa-line-chart"></i>
                            Vacantsea Growth
                        </a>
                    </span>
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
                                        "class" => " search",
                                        "name" => "filter_1",
                                        "placeholder" => "Name"
                                    )
                                );
                                ?>

                                <?php
                                echo form_input(
                                    array(
                                        "class" => " search",
                                        "name" => "filter_2",
                                        "placeholder" => "Company"
                                    )
                                );
                                ?>

                                <?php
                                echo form_input(
                                    array(
                                        "class" => " search",
                                        "name" => "filter_3",
                                        "placeholder" => "Department"
                                    )
                                );
                                ?>

                                <?php
                                echo form_input(
                                    array(
                                        "class" => " search",
                                        "name" => "filter_4",
                                        "placeholder" => "Rank"
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
                                            <th style="text-align: center;"><input type="checkbox" name="id_all"></th>
                                            <th>Title</th>
                                            <th>Company</th>
                                            <th>Department</th>
                                            <th>Rank</th>
                                            <th>Create Date</th>
                                            <th>Expired Date</th>
                                            <th>Salary</th>
                                            <th>View</th>
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
            pageLength: 10,
            dom: '<"H"r>t<"F"ip>',
            order: [
                [4, 'desc']
            ],
            columns: [
                { visible: true, searchable: false, orderable: false, className: "center reference", width: "2%", data: "checkbox"},

                { visible: true, searchable: true, orderable: true, className: "left linkable name", width: "15%", data: "name", name: "name"},
                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "company", name: "company"},
                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "department", name: "department"},
                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "rank", name: "rank"},
                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "create_date", name: "create_date"},
                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "12%", data: "expired_date", name: "expired_date"},
                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "10%", data: "salary", name: "salary"},
                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "10%", data: "view", name: "view"},

                { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "log_link"}
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
                oTable.column(1).search($(this).val()).draw();
            });

            $("input[name=filter_2]").on("keyup change", function () {
                oTable.column(2).search($(this).val()).draw();
            });

            $("input[name=filter_3]").on("keyup change", function () {
                oTable.column(3).search($(this).val()).draw();
            });

            $("input[name=filter_4]").on("keyup change", function () {
                oTable.column(4).search($(this).val()).draw();
            });

            $("#dataTables-list").on("click", "td.linkable", function () {
                var reference = $(this).parent().find(".reference").find("input[name=list_checkboxes\\[\\]]").val();
                document.location.href = baseURL + controllerName + "/detail/page/" + reference;
            });
        });

    </script>

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>