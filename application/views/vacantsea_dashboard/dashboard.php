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
                    VACANTSEA DASHBOARD
                </h1>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <h4>
                    Vacantsea Growth
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
    </div>

    <!-- Raphael and Morrisjs JavaScript -->
    <script src="<?php echo bower_url(); ?>raphael/raphael-min.js"></script>
    <script src="<?php echo bower_url(); ?>morrisjs/morris.min.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        var source = "<?php echo isset($dt_list_source) ? $dt_list_source : ""; ?>";
        var baseURL = "<?php echo $base_url; ?>";
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
                        ykeys: ['posted'],
                        labels: ['Posted'],
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

        $(document).ready(function () {

            getGrowthData();

            $("select[name=month_filter], " + "select[name=year_filter]").change(function() {

                getGrowthData(
                    $("select[name=year_filter]").val(),
                    $("select[name=month_filter]").val());

            });
        });
    </script>

<?php echo js("bulk_action.js"); ?>

<?php $this->load->view("element/footer"); ?>