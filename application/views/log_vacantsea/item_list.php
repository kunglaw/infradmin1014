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

                        <a href="<?php echo base_url(); ?>vacantsea" style="color: #3093E4;">

                            <i class="fa fa-arrow-left"></i>

                        </a>

                    </span>

                    VACANTSEA: <?php echo $item_name; ?>

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

                                        "placeholder" => "Seatizen Name"

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

                                            <th>Seatizen Name / Location </th>
											<th>Ip address </th>
                                            <th>Action Time</th>

                                        </tr>

                                        </thead>

                                        <tbody>
                                        <?php foreach($list_log as $row){ ?>
                                            <tr>
                                            	<td>
                                                	<div id="geocite-<?=$row["id"]?>" on></div>
                                                    <script>
														//$(document).ready(function(e) {
                                                            geocite("<?=$row['ip_address']?>",<?=$row["id"]?>);
                                                        //});
														
                                                    </script>
													<?php 
														$geo = json_decode(file_get_contents("http://ipinfo.io/$row[ip_address]/json"));
														
														//$geo = json_decode(file_get_contents("https://freegeoip.net/json/$row[ip_address]"),TRUE);
														$pelaut = $this->seatizen_model->get_detailseatizen($row['seatizen_id']);
														if(!empty($pelaut))
														{
															$location = $geo->city.", ".$geo->region;
															echo "<b> ".$pelaut["nama_depan"]." ".$pelaut["nama_belakang"]." </b> ( $location )";
														}
														else
														{															
															$location = $geo->city.", ".$geo->region;
															echo $location;
														}
															
										
													?>
                                                </td>
                                                <td><?php echo $row["ip_address"] ?></td>
                                            	<td><?php echo $row["action_time"] ?></td>
                                            </tr>
										<?php } ?>					
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

		function geocite(ip_address,id)
		{
			//alert(ip_address);
			
			$.ajax({
				
				type:"POST",
				url:"<?=base_url("log_vacantsea/geocite")?>",
				data:"ip_address="+ip_address,
				success: function(data)
				{
					$("#geocite-"+id).html(data);
				}
				
				
			});
			
		}

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

            /* ajax: {

                url: source,

                type: "POST",

                data: function(data) {

                    data.token_field = csrfHash;

                }

            }, */

            //serverSide: true,

            lengthChange: false,

            searching: true,

            pageLength: 10,

            dom: '<"H"r>t<"F"ip>',

            order: [

                [2, 'DESC']

            ],

            columns: [

                { visible: true, searchable: true, orderable: true, className: "left name", width: "50%", data: "name", name: "name"},
				{ visible: true, searchable: true, orderable: true, className: "left name", width: "20%", data: "ip_address", name: "ip_address"},
                { visible: true, searchable: true, orderable: true, className: "left name", width: "30%", data: "action_time", name: "action_time"}

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