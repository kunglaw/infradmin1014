<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-list">
        <thead class="button-green-white">
        <tr>
            <th style="text-align: center;"> No </th>
            <th>Ad Name</th>
            <!-- <th>Ad Page</th> -->
            <th>Area</th>
            <th>Periode</th>
            <th>Media</th>
            <!-- <th>Attachment</th> -->
            <th>Status</th>
            <th>Paid Status</th>
            <th>Start Date</th>
            <th>Expired Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php 
             $no=1;
            foreach ($dt_ad_req as $dt) {
                
               $q = "select title from admin_ad_area where id_area = '$dt[id_area]'";
               $exec = $this->db->query($q);
               $data_area = $exec->row_array();
               $exec->free_result();

               $q = "select amount_periode, range_periode from admin_ad_periode where id_periode = '$dt[id_periode]'";
               $exec = $this->db->query($q);
               $data_periode = $exec->row_array();
               $exec->free_result();
               
               $dt_page = $this->advertise_model->detail_ad_page($dt['id_page']);
               $ad_periode = ($dt['quantity_periode']*$data_periode['amount_periode']);
			   
			    $btn_paid_status = "";
				$btn_status ="";
				if($dt["paid_status"] == "waiting")
				{
					$btn_paid_status = "";
					$btn_status ="disabled";
					$title ="Waiting for Payment Confirmation";
				}	
				else if($dt["paid_status"] == "pending_confirm")
				{
					$btn_paid_status = "";
					$btn_status ="disabled";
					$title = "Waiting for Admin to Check the Payment ";
				}
				else
				{
					$btn_paid_status = "";
					$btn_status ="";	
					$title = "User has been Paid for the Ads ";
				}
        ?>
            <tr <?=$class ?>>
              <td class="center reference" >
                    <span data-toggle="popover" data-content="<?=$data_content?>" 
                    title="<?=$title_popup?>" class="ipop">
                      <?="#".$dt["id_ad"]?>
                    </span>
              </td>
              <td class="left name" >
                <div data-toggle="popover" class="ipop pull-left" data-content="<?=$data_content?>" 
                title="<?=$title_popup?>"> 
                    <?=$dt['ad_name']?>                                          
                </div>
              </td>
              <!-- <td>
                <div data-toggle="popover" class="ipop pull-left" data-content="<?=$data_content?>" 
                title="<?=$title_popup?>"> 
                    <?php echo $dt_page['page'];?>                                   
                </div>
              </td> -->
              <td class="left linkable" >
                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                title="<?=$title_popup?>"> 
                    <?=$data_area['title']?>
                </div>
              </td>
              <td class="left linkable" >
                <div data-toggle="popover" class="ipop" data-content="<?=$data_content?>"
                title="<?=$title_popup?>"> 
                    <?="$ad_periode $data_periode[range_periode]"?> 
                </div>
              </td>
              <td>
                  <a href="<?=infr_url("infrasset/advertise/$dt[media]")?>" target="_blank"><?=$dt["media"]?></a>
              </td>
              <td>
                <?php echo $dt['status'] ?>
              </td>
              <td>
              	<div data-toggle="popover" class="ipop" data-content="<?=$title?>"
                title="Paid Status : ">
                	<?php echo $dt['paid_status'] ?>
                </div>
              </td>
              <td>
                <?php echo $dt['start_date'] ?>
              </td><td>
                <?php echo $dt['expired_date'] ?>
              </td>
              <td>
                 <?php
                    
                 ?>
                 <a class="btn btn-primary <?=$btn_paid_status?>" title="Paid Status" onClick="paid_status_modal('<?=$dt['id_ad']?>')" 
                  href="#">

                  <span class="glyphicon glyphicon-euro"></span>
                 </a>
                 
                 <a class="btn btn-primary <?=$btn_status?>"  title="Activate" onClick="activate_modal('<?=$dt['id_ad']?>')" 
                  href="#">

                  <span class="glyphicon glyphicon-edit"></span>
                 </a>
                 
                 
              </td>
             
              
          </tr>
                <?php
                
            }
            
         ?>
        </tbody>
    </table>
</div>