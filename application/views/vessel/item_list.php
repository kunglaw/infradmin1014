<?php
/**
 * Created by PhpStorm.
 * User: pulung
 * Date: 29/10/14
 * Time: 13:00
 */
?>
<?php $this->load->view("element/header"); ?>

<?php
echo form_open("vessel/import", array("id" => "import-vessel-form", "style" => "display: none;"));
echo form_upload("excel_file");
echo form_close();
?>

    <!-- DataTables CSS -->
    <link href="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo bower_url(); ?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    VESSEL MANAGEMENT

                    <span class="pull-right">

                        <a href="<?php echo base_url(); ?>assets/document/vessel-template.xlsx"
                            class="button-green-white"
                            style="margin-right: 10px;">

                            <i class="fa fa-arrow-circle-down"></i>
                            Download Template
                        </a>

                        <a href="#import-popup" class="button-green-white" id="import-popup">
                            <i class="fa fa-cloud-upload"></i>
                            Import Vessel Data
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
                                echo form_button(
                                    array(
                                        "class" => "button-green-white ",
                                        "data-toggle" => "modal",
                                        "data-target" => "#delete-many-confirmation"
                                    ),
                                    "Delete"
                                );
                                ?>

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
                                        "placeholder" => "Type"
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
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Company</th>
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
            searching: true,
            pageLength: 10,
            dom: '<"H"r>t<"F"ip>',
            order: [
                [1, 'asc']
            ],
            columns: [
                { visible: true, searchable: false, orderable: false, className: "center reference", width: "2%", data: "checkbox"},

                { visible: true, searchable: true, orderable: true, className: "left linkable name", width: "25%", data: "name", name: "name"},
                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "25%", data: "type", name: "type"},
                { visible: true, searchable: true, orderable: true, className: "left linkable", width: "45%", data: "company", name: "company"},
                { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "delete_link"}
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

            $("#dataTables-list").on("click", "td.linkable", function () {
                var reference = $(this).parent().find(".reference").find("input[name=list_checkboxes\\[\\]]").val();
                document.location.href = baseURL + controllerName + "/detail/page/" + reference;
            });



            // trigger file upload to show.
            $("#import-popup").click(function() {
                $("input[name=excel_file]").click();
            });

            $("input[name=excel_file]").change(function() {

                if ($(this).val() != "") {

                    var uploadOptions = {
                        success: function(data) {

                            var result = data;

                            if (result.status == "error") {

                                showNotification("danger", result.notification);

                            } else {

                                showNotification("success", result.notification);

                                // redraw datatable,
                                oTable.draw();
                            }
                        },
                        error: function(data) {

                            console.log(data);
                            showNotification("danger", result.notification);
//                            location.reload();
                        }
                    };

                    $("#import-vessel-form").ajaxForm(uploadOptions);
                    $("#import-vessel-form").submit();


                    $(this).val("");

                    return false;
                }
            });
        });

    </script>

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>