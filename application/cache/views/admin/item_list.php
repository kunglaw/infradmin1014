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
                    ADMIN MANAGEMENT

                    <span class="pull-right">
                        <a href="#create-edit-popup" class="open-popup create-button button-green-white ">
                            <i class="fa fa-plus"></i>
                            Create Admin
                        </a>
                    </span>
                    <a href="#create-edit-popup" class="create-button-no-reset" style="display:none;"></a>
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
                                        "placeholder" => "Email"
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
                                            <th>Email</th>
                                            <th>Role</th>
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
    $popup_data = array();
    $popup_data["initial_name"] = $create_popup_header;
    $popup_data["popup_location"] = $view_folder ."/item_popup";
    $popup_data["action_target"] = $controller_name ."/add";
    $this->load->view("element/create_edit_popup", $popup_data);
    ?>

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
                { visible: true, searchable: false, orderable: false, className: "center", width: "3%", data: "checkbox"},

                { visible: true, searchable: true, orderable: true, className: "left name", width: "20%", data: "name", name: "name"},
                { visible: true, searchable: true, orderable: true, className: "left", width: "20%", data: "email", name: "email"},
                { visible: true, searchable: true, orderable: true, className: "left", width: "51%", data: "role", name: "role"},
				
				// { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "edit_link"}, // edit
                { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "edit_link"}, // edit
                { visible: true, searchable: false, orderable: false, className: "left", width: "3%", data: "delete_link"} // delete
            ],
            responsive: true,
            drawCallback: function() {


                listCheckboxes = {};
                $("input[name=id_all]").prop("checked", false);

                // register triggers for magnific popup
                $(".edit-button, .edit-button-return-action").magnificPopup({
                    closeOnBgClick: false,
                    callbacks: {
                        close: function() {

                            $(".thumbnail-wrapper").hide();
                            $(".thumbnail-wrapper-footer").hide();

                            $(".thumbnail-view").show();
                        }
                    }
                });

                $(".edit-button").click(prepareEditForm);
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


            // register triggers for magnific popup
            $(".create-button, .create-button-no-reset").magnificPopup({
                closeOnBgClick: false,
                callbacks: {
                    close: function() {

                        $(".thumbnail-wrapper").hide();
                        $(".thumbnail-wrapper-footer").hide();

                        $(".thumbnail-view").show();
                    }
                }
            });

            $(".create-button").click(prepareCreateForm);

        });

    </script>

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>