<?php

/**

 * Created by PhpStorm.

 * User: pulung

 * Date: 29/10/14

 * Time: 13:00

 */
 
?>

<?php $this->load->view("element/header"); ?>

<?php $dt_rank 	   = $this->generic_model->retrieve_one($table="rank",array("rank_id"=>$rank_id)); 
	  $dt_department = $this->generic_model->retrieve_one($table="department",array("department_id"=>$department)); 
?>

    <!-- DataTables CSS -->
    <link href="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="<?php echo bower_url(); ?>datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- DataTables JavaScript -->
    <script src="<?php echo bower_url(); ?>datatables/media/js/jquery.dataTables.min.js"></script>

    <script src="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    
	<div class="temp-modal"></div>
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
                    
                    <?php if(!empty($id_perusahaan)){ ?>
                    	<button class="btn btn-primary pull-right" id="edit-vacantsea-btn"><i class="glyphicon glyphicon-edit"></i> Edit Vacantsea </button>
                    <?php }else{  ?>
                    	<button class="btn btn-primary pull-right" id="edit-vacantsea-scrap-btn"><i class="glyphicon glyphicon-edit"></i> Edit Vacantsea </button>
                    <?php } ?>

                </h1>
                <span class="clearfix"></span>

            </div>

            <!-- /.col-md-12 -->

        </div>

        <!-- /.row -->



        <div class="row">



            <div class="col-md-12">

                <div class="panel panel-default">



                    <div class="panel-body">

                        <div class="row" style="">

                            <div class="col-md-12">



                                <table class="company-detail">

                                    <thead class="button-green-white">

                                    <tr>

                                        <td colspan="2">

                                            <h4><b><?php echo $vacantsea; ?></b></h4>

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

                                        <td><?php echo $dt_department["department"]; ?></td>

                                    </tr>

                                    

                                    <tr>

                                        <td>Rank</td>

                                        <td><?php echo $dt_rank["rank"]; ?></td>

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
                                    	<td> Url Source </td>
                                    	<td><a href="<?= $url_source ?>" target="_blank"><?= $url_source ?></a></td>
                                    </tr>
									
                                    <tr>

                                        <td>Created Date</td>

                                        <td><?php echo date_format_only($create_date); ?></td>

                                    </tr>



                                    <tr>

                                        <td>Expired Date</td>

                                        <td><?php echo date_format_only($expired_date); ?></td>

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

        

        <div class="row">

            <div class="col-md-12">

            

                <h3 class="page-header">

                    

                    Applicant List 

                </h3>

                

                <table class="table table-striped table-bordered hover" id="test-tbl">

                  <thead>

                      <tr>

                          <th>Seatizen Name</th>

                          <th>Vacantsea Rank</th>

                          <th>Rank Seatizen</th>

                          <th>Applied Date</th>

                          <th>Applied Status</th>

                          <th>Hired / Approved Date </th>

                      </tr>

                  </thead>

                  <tbody>

                      <?php 

		

					  foreach($applicant_list as $row){ 

					  

					  	$dt_pelaut = $this->generic_model->retrieve_one($table="pelaut_ms",array("pelaut_id"=>$row["id_pelaut"]));

						$dt_prof_res_tr = $this->generic_model->retrieve_one($table="profile_resume_tr",array("pelaut_id"=>$row["id_pelaut"]));

						$dt_rank = $this->generic_model->retrieve_one($table="rank",array("rank_id"=>$rank_id));

						$dt_rank_pel = $this->generic_model->retrieve_one($table="rank",array("rank_id"=>$dt_prof_res_tr["rank"]));

						

						

						$val_approved = "username=$row[username]&page=hire_crew&action=approved&id_vacantsea=$row[id_vacantsea]";

						$val_hired = "username=$row[username]&page=hire_crew&action=hire_applicant&id_vacantsea=$row[id_vacantsea]";

						

						$dt_log_hired = $this->seatizen_model->get_log_hired($val_hired); 

						$dt_log_approve = $this->seatizen_model->get_log_approved($val_approved);  

					  

					  ?> 

                      <tr>

                          <td>
						  	<a href="<?php echo base_url("seatizen/detail/page/$dt_pelaut[pelaut_id]"); ?>" target="_blank"> 
								<?=$dt_pelaut["nama_depan"]." ".$dt_pelaut["nama_belakang"]?> </a>
                          </td>

                          <td><?=$dt_rank["rank"]?></td>

                          <td><?=format_rank($dt_rank_pel["rank"])?></td>

                          <td><?=date_format_db($row["datetime"])?></td>

                          <td><?=$row["status"]?></td>

                          <td><?=$dt_log_hired." / ".$dt_log_approve?></td>

                      </tr>

                      <?php } ?>

                  </tbody>

            	</table>

                

            </div>

            <!-- /.col-md-12 -->

           

            

        </div>



    </div>

    <!-- /#page-wrapper -->

	

    <script>

        

		

		$(document).ready(function(e) {

           

			$("#test-tbl").DataTable();

        });
		
		$("#edit-vacantsea-btn").click(function(){
			
			$.ajax({
				url:"<?=base_url("vacantsea/update_modal")?>",
				data:"vacantsea_id="+<?=$vacantsea_id?>,
				type:"POST",
				success: function(dt)
				{
					
					$(".temp-modal").html(dt);
				}
				
			});
				
		});
		
		$("#edit-vacantsea-scrap-btn").click(function(){
			
			$.ajax({
				url:"<?=base_url("vacantsea/update_vacantsea_scrap_modal")?>",
				data:"vacantsea_id="+<?=$vacantsea_id?>,
				type:"POST",
				success: function(dt)
				{
					$(".temp-modal").html(dt);
				}
				
			});
				
		})

	

	

	</script>

    

<?php $this->load->view("element/footer"); ?>