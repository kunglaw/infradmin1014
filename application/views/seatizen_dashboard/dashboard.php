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
                    SEATIZEN MANAGEMENT
                </h1>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <h4>
                    Seatizen Growth
                </h4>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->


        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-12">
                                Month
                                &nbsp;&nbsp;
                                <?php
                                echo form_dropdown(
                                    "month_filter",
                                    $month,
                                    date("m"),
                                    'class="search"'
                                );
                                ?>

                                &nbsp;&nbsp;&nbsp;

                                Year
                                &nbsp;&nbsp;
                                <?php
                                echo form_dropdown(
                                    "year_filter",
                                    $year,
                                    date("Y"),
                                    'class="search"'
                                );
                                ?>

                                &nbsp;&nbsp;&nbsp;
                                Growth Average
                                &nbsp;&nbsp;
                                <span id="growth-average"></span>
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 40px;">

                            <div class="col-md-12">

                                <div id="growth-graph" style="height: 300px;">

                                </div>

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

        <div class="row">
            <div class="col-md-12">
                <h4>
                    Seatizen Login History
                </h4>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->


        <!-- Custom Fonts -->
        <link href="<?php echo bower_url(); ?>bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css"
              rel="stylesheet" type="text/css">

        <style type="text/css">
            .input-daterange input:first-child,
            .input-daterange input:last-child {
                border-radius: 0;
            }
        </style>

        <script src="<?php echo bower_url(); ?>bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-lg-12 input-daterange" id="datepicker">

                                Date
                                &nbsp;&nbsp;

                                <?php
                                echo form_input("start");
                                ?>

                                &nbsp;
                                to
                                &nbsp;

                                <?php
                                echo form_input("end");
                                ?>

                                &nbsp;
                                <?php
                                echo form_button(
                                    array(
                                        "name" => "clear",
                                        "class" => "button-green-white"
                                    ),
                                    "Clear Date"
                                );
                                ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-list">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
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
                </div>
            </div>
        </div>

    </div>
    <!-- /#page-wrapper -->


    <!-- DataTables JavaScript -->
    <script src="<?php echo bower_url(); ?>datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Raphael and Morrisjs JavaScript -->
    <script src="<?php echo bower_url(); ?>raphael/raphael-min.js"></script>
    <script src="<?php echo bower_url(); ?>morrisjs/morris.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        var source = "<?php echo isset($dt_list_source) ? $dt_list_source : ""; ?>";
        var baseURL = "<?php echo $base_url; ?>";
        var tableName = "<?php echo $table_name; ?>"; // for bulk action
        var controllerName = "<?php echo $controller_name; ?>"; // for link to page detail
        var oTable = null;

        var csrfTokenName = '<?php echo $this->security->get_csrf_token_name(); ?>';
        var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';


        function getGrowthData(year, month) {

            var params = "";
            if (typeof year !== "undefined" && typeof month !== "undefined") {
                params = year + "/" + month;
            }

            $.ajax({
                dataType: "json",
                type: "GET",
                url: baseURL + controllerName + "/growth/" + params,
                beforeSend: function(data) {

                    $("#growth-graph").empty();
                    $("#growth-graph").html("Loading data...");
                },
                success: function(data) {

                    $("#growth-graph").empty();

                    Morris.Line({
                        element: 'growth-graph',
                        data: data.growth_data,
                        xLabels: 'day',
                        xkey: 'date',
                        ykeys: ['registered'],
                        labels: ['Registered'],
                        lineColors: ['red'],
                        lineWidth: [2],
                        xLabelFormat: function(x) { // set X label
                            return x.getDate(); // return date of the month
                        },
                        grid: false,
                        pointSize: 1
                    });

                    $("#growth-average").html(data.average_view);
                }
            });
        }

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
                [1, 'desc']
            ],
            columns: [
                { visible: true, searchable: true, orderable: true, className: "left name", width: "20%", data: "name", name: "name"},
                { visible: true, searchable: false, orderable: true, className: "left", width: "80%", data: "action_time", name: "action_time"}
            ],
            responsive: true,
            drawCallback: function() {

                listCheckboxes = {};
                $("input[name=id_all]").prop("checked", false);
            }
        };

        $(document).ready(function () {

            oTable = $('#dataTables-list').DataTable(settings);

            getGrowthData();

            $("select[name=month_filter], " + "select[name=year_filter]").change(function() {

                getGrowthData(
                    $("select[name=year_filter]").val(),
                    $("select[name=month_filter]").val());

            });

            var datepickerObject = $(".input-daterange").datepicker({

                format: "dd-mm-yyyy",
                todayBtn: "linked",
                clearBtn: true

            }).on("changeDate", function(e) {

                // create new datatables settings with new date range parameter
                var filteredSettings = settings;
                filteredSettings.ajax.data = function(data) {
                    data.token_field = csrfHash;
                    data.start_date = $("#datepicker input[name=start]").val();
                    data.end_date = $("#datepicker input[name=end]").val();
                };

                // re-initialize datatables with new settings.
                oTable.destroy();
                oTable = $('#dataTables-list').DataTable(filteredSettings);
            });

            $("button[name=clear]").click(function() {

                $(".input-daterange input").each(function (){
                    $(this).datepicker("clearDates");
                });
            });
        });
    </script>

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>