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
                                "name" => "filter_5",
                                "placeholder" => "Name"
                            )
                        );
                        ?>
  
                        <?php
                        echo form_input(
                            array(
                                "class" => " search",
                                "name" => "filter_6",
                                "placeholder" => "Company"
                            )
                        );
                        ?>
  
                        <?php
                        echo form_input(
                            array(
                                "class" => " search",
                                "name" => "filter_7",
                                "placeholder" => "Rank"
                            )
                        );
                        ?>
                        
                        <?php
                        echo form_input(
                            array(
                                "class" => " search",
                                "name" => "filter_8",
                                "placeholder" => "status"
                            )
                        );
                        ?>
                    </div>
                    <!-- /.col-md-12 -->
                </div>
                <!-- /.row -->
  				
                <style>
					.Processed{
						
					}
					
					.Approved{
						color:#0F0;	
					}
					
					.Rejected{
						color:#F60;
					}
				
				</style>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-list2">
                                <thead class="button-green-white">
                                <tr>
                                    <th style="text-align: center;"><input type="checkbox" name="id_all"></th>
                                    <th>Applicant</th>
                                    <th>Rank</th>
                                    <th>Vacantsea Rank</th>
                                    <th>Company</th>
                                    <th>Status</th>
                                    <th>Vacantsea Create Date</th>
                                    <th>Apply Date</th>
                                  
                                </tr>
                                </thead>
                                <tbody>
                                  <?php 
								  
								  foreach($applicant_list as $row){ 
                                  
                                    $seatizen = $this->seatizen_model->get_detailseatizen($row["id_pelaut"]);
									$profile  = $this->Profile_resume_model->get_profile_resume($seatizen["pelaut_id"]);
									$rank 	 = $this->rank_model->get_rank_detail_byid($profile["rank"]);
									$vacantsea = $this->vacantsea->vacantsea_detail($row["id_vacantsea"]);
									
									$vac_rank = $this->rank_model->get_rank_detail_byid($vacantsea["rank_id"]);
									$company = $this->agentsea_model->detail_agentsea($vacantsea["id_perusahaan"]);
									
									if($row["admin_post"] > 0)
									{
										// get data admin
										$stra = "SELECT * FROM admin_user WHERE id = '$row[admin_post]' ";
										$qa   = $this->db->query($stra);
										$fa   = $qa->row_array();
										
										$pic = $fa["name"]." ( admin )";  
									}
									else
									{
										$pic = $company["contact_person"];	
									}
									$vac2 = htmlentities($vacantsea['vacantsea']);
									$data_content = "<div> PIC : $pic </div>". 
									" <div> $vac </div>";
										                                  
                                  ?>
                                   <tr class="<?=$row["status"]?>">
                                    <td class="center reference">
                                      <input type="checkbox" value="<?=$row['id_aplicant']?>" name="list_checkboxes[]">
                                      <?=$row['id_aplicant']?>
                                    </td>
                                    <td class="">
                                      <span data-toggle="popover" data-content="<?=$data_content?>" 
                                       title="Vacantsea" class="ipop">
                                       	<a href="<?=base_url("seatizen/detail/page/$row[id_pelaut]")?>" target="_blank"> 
                                      		<?php echo $seatizen["nama_depan"]." ".$seatizen["nama_belakang"]; ?>
                                        </a>
                                      </span>
                                    </td>
                                    <td class=""> 
                                      <span data-toggle="popover" data-content="<?=$data_content?>" 
                                      title="Vacantsea" class="ipop"> 
                                      	<?=$rank["rank"]?>
                                      </span>
                                    </td>
                                    <td class=""> 
                                       <span data-toggle="popover" data-content="<?=$data_content?>" 
                                      title="Vacantsea" class="ipop">
                                     	 <?=$vac_rank["rank"]?> 
                                       </span>
                                    </td>
                                    <td> 

                                      <span data-toggle="popover" data-content="<?=$data_content?>"
                                      title="Update" class="ipop"> 

                                      <?php 

                                         // $company = $this->agentsea_model->detail_agentsea($row['id_perusahaan']);
										 $c = json_decode($vacantsea["data_scrap"],true);
                                          if($vacantsea["data_scrap"] == "")
                                          {
                                              $company_name = $vacantsea["perusahaan"];
                                          }
                                          else
                                          {
											  
                                              $company_name = $c['company'];
                                          }
                                          
										 // print_r($c);
										  
                                          echo  $company_name;

                                      ?>

                                      </span>

                                    </td>
                                    <td>
                                    	<span data-toggle="popover" data-content="<?=$data_content?>" 
                                      title="Vacantsea" class="ipop">
                                      	<?=$row["status"]?>
                                      </span>
                                    </td>
                                    <td class=""> 
                                       <span data-toggle="popover" data-content="<?=$data_content?>" 
                                      title="Vacantsea" class="ipop">
                                     	<?=$vacantsea["create_date"]?> 
                                      </span>
                                    </td>
                                    <td class=""> 
                                      <span data-toggle="popover" data-content="<?=$data_content?>" 
                                      title="Vacantsea" class="ipop">
                                     	<?=$row["datetime"]?> 
                                      </span>
                                    </td>
                                   
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

<script>
	$(document).ready(function(e) {
        
		//$("h1").mouseenter(function(){ alert("hello"); });
		// INGA2, HARUS CLASSSSSSS
		$(".role-popover").popover({
			trigger	  :'hover',
			'placement'  :'top',
			animation	:true,
			//container	:false,
			title		:'info',
			
			delay		:1, // { "show": 500, "hide": 100 }
			html		 :true,
			//placement:'right',
			//'selector':'false',
			template:'<div class="popover col-md-4" style="border:1px solid #CCC" ><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
			
			//viewport:{ selector: 'body', padding: 0 }
			
		});
		
		$(".ipop").popover({
			trigger	  :'hover',
			'placement'  :'top',
			animation	:true,
			//container	:false,
			title		:'Info',
			delay		:1, // { "show": 500, "hide": 100 }
			html		 :true,
			//placement:'right',
			//'selector':'false',
			template:'<div class="popover col-md-4" style="border:1px solid #CCC" ><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
			
			//viewport:{ selector: 'body', padding: 0 }
		});
		
    });

</script>