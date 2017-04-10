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
                        <a href="<?php echo base_url(); ?>seatizen" style="color: #3093E4;">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </span>
                    SEATIZEN DETAIL

                    <span class="pull-right">
                        <?php if ($activation == "ACTIVE"): ?>
                            <a href="#" class="block-one-button button-green-white"
                               data-toggle="modal" data-target="#block-one-confirmation"
                               style="margin-right: 10px;">
                                Block
                            </a>
                            <input type="hidden" class="object-id" value="<?php echo $item_id; ?>">

                        <?php else: ?>

                            <a href="#" class="unblock-one-button button-green-white"
                                data-toggle="modal" data-target="#unblock-one-confirmation"
                                style="margin-right: 10px;">

                                Unblock
                            </a>
                            <input type="hidden" class="object-id" value="<?php echo $item_id; ?>">

                        <?php endif; ?>

                        <a href="<?php echo base_url() ."seatizen/log/". $item_id; ?>" class="button-green-white ">
                            Seatizen Log
                        </a>
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

                        <div class="col-md-1">

                            <img src="<?php echo check_profile_seaman($username); ?>" height="112" width="112" />

                        </div>

                        <div class="col-md-10">
							
                            <?php if ($detail_available): ?>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Name
                                    </div>
                                    <div class="pull-left">:</div>
                                    <div class="col-md-9">
                                        <?php echo $nama_depan." ".$nama_belakang; ?> 

                                        <a href="<?php echo infr_url("profile/$username/resume");?>" target="_blank"> View Resume </a>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Rank
                                    </div>
                                    <div class="pull-left">:</div>
                                    <div class="col-md-9">
                                        <?php echo format_rank($rank_name); ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        National
                                    </div>
                                    <div class="pull-left">:</div>
                                    <div class="col-md-9">
                                        <?php echo flag_nationality($kebangsaan); ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Religion
                                    </div>
                                    <div class="pull-left">:</div>
                                    <div class="col-md-9">
                                        <?php echo e_field($agama); ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Gender
                                    </div>
                                    <div class="pull-left">:</div>
                                    <div class="col-md-9">
                                        <?php echo e_field($gender); ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Birth Place
                                    </div>
                                    <div class="pull-left">:</div>
                                    <div class="col-md-9">
                                        <?php echo e_field($tempat_lahir); ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Birth Date
                                    </div>
                                    <div class="pull-left">:</div>
                                    <div class="col-md-9">
                                        <?php echo date_format_only($tanggal_lahir); ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Address
                                    </div>
                                    <div class="pull-left">:</div>
                                    <div class="col-md-9">
                                        <?php echo e_field($alamat); ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Phone
                                    </div>
                                    <div class="pull-left">:</div>
                                    <div class="col-md-9">
                                        <?php echo e_field($telepon); ?>
                                    </div>
                                </div>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Email
                                    </div>
                                    <div class="pull-left">:</div>
                                    <div class="col-md-9">
                                        <?php echo e_field($email); ?>
                                    </div>
                                </div>

                              <!--   <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Status
                                    </div>
                                    <div class="col-md-10">
                                        <?php //echo $crew_status; ?>
                                    </div>
                                </div> -->
                                <div class="row" style="margin-bottom:10px;">
                                    <div class="col-md-2">
                                        Join Since
                                    </div>
                                    
                                    <div class="pull-left">:</div>
                                    <div class="col-md-9">
                                    	<?php $this->load->helper("date"); ?>
                                        <?php echo date_format_db($create_date);  ?>
                                    </div>

                                </div>
                                
                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-2">
                                        Register From 
                                    </div>
                                    <div class="pull-left">:</div>
                                    <div class="col-md-9">
                                    	<?php $link_facebook = "https://www.facebook.com/$facebook_id"; ?>
                                        <?php echo $register_from; ?> 
										<?php 
										
										if($register_from == "fb_register_email" || $register_from == "fb_register_noemail")
										{ 
											echo " / <a href='$link_facebook' target='_blank'> View Facebook </a>";
											//cho "/ ".$facebook_id; 
										}
										else if($register_from == "Google+")
										{
												
										}
										
										?>
                                    </div>
                                </div>
                                
                                <div class="row" style="margin-bottom:10px;">
                                	<div class="col-md-2">
                                       
                                    </div>
                                    
                                    <div class="col-md-9">
                                    	<button class="btn btn-primary" id="profile-btn" modal="form-profile"> Edit </button>
                                    </div>
                                </div>
                                
                          


                            <?php else: ?>

                                <div class="row" style="margin-bottom: 10px;">
                                    <div class="col-md-12">
                                        Seatizen is not a crew, crew detail is not available.
                                    </div>
                                </div>

                            <?php endif; ?>

                        </div>

                         <div style="clear:both;"> </div>
                        
                        <div class="col-md-4" style="">
                          <h3 class="page-header">  Total View Profile </h3>
                          <table class="company-detail table table-bordered">
                            <tr>
                                <td width="50%"><strong> Total View  </strong></td>
                                <td width="2%"> : </td>
                                <td> <?php echo $jumlah_view; ?> </td>
                            </tr>
                          </table>
                        </div>
                          
                        <div style="clear:both;"> </div>
                        
                        <div class="col-md-10" style="">
                        	<h3 class="page-header"> Applied Vacantsea List </h3>
                            <!-- <table class="table table-striped table-bordered hover" id="applied-tbl">
                            	<thead>
                                	<tr>
                                    	<th> Vacantsea Title </th>
                                        <th> Vacantsea Rank </th>
                                        <th> Company Name </th>
                                        <th> Applied Date </th>
                                        <th> Applied Status</th>
                                        <th> Hired / Approved Date </th>
                                    </tr>
                                
                                </thead>
                                <tbody>
                                	
                                	<?php foreach($applied_vacantsea as $row){ 
										
										$dt_vac = $this->generic_model->retrieve_one($table="vacantsea",array("vacantsea_id"=>$row["id_vacantsea"]),$order_criteria=array(), $length=NULL, $offset=NULL);
								  		$dt_com = $this->generic_model->retrieve_one($table="perusahaan", array("id_perusahaan"=>$dt_vac["id_perusahaan"]),$order_criteria=array(), $length=NULL, $offset=NULL);
										$dt_rank = $this->generic_model->retrieve_one($table="rank",array("rank_id"=>$dt_vac["rank_id"]),$order_criteria=array(), $length=NULL, $offset=NULL);
									?>
                                	<tr>
                                    	<td><?=$dt_vac["vacantsea"]?></td>
                                        <td><?=$dt_rank["rank"]?></td>
                                        <td><?=$dt_com["nama_perusahaan"]?></td>
                                        <td><?=date_format_db($row["datetime"])?></td>
                                        <td><?=$row["status"]?></td>
                                        <td><?=" "?></td>
                                	</tr>
                                    <?php } ?>
                                </tbody>
                            
                            </table> -->
						</div>
                        
                        <table class="table table-striped table-bordered hover" id="test-tbl">
                        	<thead>
                            	<tr>
                                	<th> Vacantsea Title</th>
                                	<th> Vacantsea Rank</th>
                                    <th> Company Name</th>
                                    <th> Applied Date </th>
                                    <th> Applied Status</th>
                                    <th> Hired / Approved Date </th>
                                </tr>
                                
                            </thead>
                            <tbody>
                            	<?php foreach($applied_vacantsea as $row){ 
								
									$dt_vac = $this->generic_model->retrieve_one($table="vacantsea",array("vacantsea_id"=>$row["id_vacantsea"]),$order_criteria=array(), $length=NULL, $offset=NULL);
								  		$dt_com = $this->generic_model->retrieve_one($table="perusahaan", array("id_perusahaan"=>$dt_vac["id_perusahaan"]),$order_criteria=array(), $length=NULL, $offset=NULL);
										$dt_rank = $this->generic_model->retrieve_one($table="rank",array("rank_id"=>$dt_vac["rank_id"]),$order_criteria=array(), $length=NULL, $offset=NULL);
									
									$val_approved = "username=$row[username]&page=hire_crew&action=approved&id_vacantsea=$dt_vac[vacantsea_id]";
								 	$date_approved = $this->seatizen->get_log_approved($val_approved);
									
									$val_hired = "username=$row[username]&page=hire_crew&action=hire_applicant&id_vacantsea=$dt_vac[vacantsea_id]";
									$date_hired = $this->seatizen->get_log_hired($val_hired); 
									
								?>
                            	<tr>
                                	<td><a href="<?=base_url("vacantsea/detail/page/$row[id_vacantsea]")?>" target="_blank"><?=$dt_vac["vacantsea"]?></a></td>
                                    <td><?=$dt_rank["rank"]?></td>
                                    <td><?=$dt_com["nama_perusahaan"]?></td>
                                    <td><?=date_format_db($row["datetime"])?></td>
                                    <td><?=$row["status"]?></td>
                                    <td><?=$date_hired." / ".$date_approved?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php include_once 'resume-components/table_kepelautan.php'; ?>
                        <?php include_once "resume-components/table_describe.php"; ?>
                        <?php include_once "resume-components/table_cover_letter.php" ?>
                        <?php include_once 'resume-components/table_document_record.php'; ?>
                        <?php include_once 'resume-components/table_competency.php'; ?>
                        <?php include_once 'resume-components/table_proficiency.php'; ?>
                        <?php include_once 'resume-components/table_sea_record.php'; ?>
                        <?php include_once 'resume-components/table_document_upload.php'; ?>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->
        
       <div class="tmp_modal"> TEMP_MODAL </div>

    </div>
    <!-- /#page-wrapper -->
 
    
    <!-- DataTables JavaScript -->
    <script src="<?php echo bower_url(); ?>datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo bower_url(); ?>datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
      
    <script>
        
		
		$(document).ready(function(e) {
            $("#applied-tbl").DataTable(/*settings*/);
			$("#test-tbl").DataTable();
        });
	
	
	</script>
  

    <?php
    $modal_block_data = array();
    $modal_block_data["route"] = $block_route;
    $this->load->view("modal/block_confirmation", $modal_block_data);
    $this->load->view("modal/unblock_confirmation", $modal_block_data);
    ?>

<?php $this->load->view("element/footer"); ?>