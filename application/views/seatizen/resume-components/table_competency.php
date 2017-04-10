<div id="data-table-competency" class="jarak">
        <div>
            <h3 class="page-header" style="padding-bottom:0px"> COC and Endorsement </h3> <span> (the "Number" of document will be hidden from others) </span>
            
            <button class="pull-right btn btn-filled btn-sm" id="coc-btn" modal="form-add-competency">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Add
            </button>
        </div>
        
        <div class="clearfix"></div>
          <br />
          
        <table class="table table-bordered hover">
            <thead>
            <th>
                Certificate of Competency
            </th>
            <th>
                No License
            </th>
            <th>Issued Place & Issued Date <?php //$date_issued_lbl?></th>
            <th>Expiry Date <?php //$date_expired_lbl?></th>
            </thead>
            <tbody>
             <?php
             foreach($competency as $row){
                 
                 if($row['grade_license'] != "Certificate of Endorsement" && $row['type'] == "coc")
                 {
                     $e = "UNLIMITED";
                 }
                 else
                 {
                     $e = date_format_str($row['expired_date']);
                 }
                 
             ?>
              <tr title="Click to view attachment">
              <?php $n = ""; if($row['type'] == "cor" OR $row['grade_license'] == "Certificate of Endorsement"){ 
                $n = $row['negara']; }
                ?>
                <td class='link-to-coc-attachment'>
                  <?php
					  if(empty($row['attachment']))
					  { 
						echo $n." ".$row['grade_license']; 
					  }
					  else  
					  {
						$t = "click to view attachment";
						$file_type = '';
					   
						$username = $this->session->userdata("username");
						
						$extensi = end(explode('.', $row['attachment']));
						$nama_file = strtolower($row['negara'])."_".strtolower(str_replace(' ', '_', $row['grade_license'])).".$extensi";
						$open = "class='data-gambar-coc'";
						if(strtolower($extensi) == 'pdf') $open = "target='_blank' class='data-pdf-coc'";

						echo "<a href='".img_url("document/$username/coc/$nama_file")."' title='$nama_file' $open > $n $row[grade_license] </a>"; 
					  }
				  ?>
                </td>
                <td> <?php echo $row['no_license']; ?> 
                  <!-- <form method="POST" action="http://pelaut.dephub.go.id/index.php?hal=src" target="_blank"
                  <input type="hidden" name="name" value="<?php //echo substr($row['no_license'],0,10); ?>">
                    <input type="submit" value="<?php // echo $row['no_license']; ?>" style="background:none;
                    border:none;color:#3366cc;">
                  </form>
                  <?php //echo $row['no_license']?> --></td>
                <!-- <td><?php echo $row['negara']?></td> -->
                <td>  <?php 
                  if(empty($row['place_issued']) AND empty($row['date_issued'])){
                    echo " ";
                  }else if(!empty($row['place_issued']) AND empty($row['date_issued'])){
                    echo $row['date_issued'];
                  } else if(empty($row['place_issued']) AND !empty($row['date_issued'])){
                    echo date_format_str($row['date_issued']);
                  }else{
                     echo $row['place_issued']." , ".date_format_str($row['date_issued']);
                  }
                  ?></td>
                <td><?php echo $e; ?>
                  <span class="pull-right col-md-4">
                  <button class="btn btn-default btn-xs competency-update-btn" modal="form-update-competency" 
                    onclick="javascript:edit_cocend(<?=$row['id_licenses']?>)" title="Update">
                        <span class="glyphicon glyphicon-edit"></span> 
                    </button>

                    <button class="btn btn-default btn-xs competency-delete-btn" modal="delete-competency-modal" 
                    onclick="javascript:delete_cocend(<?=$row['id_licenses']?>)" title="Delete" <?php echo $style ?>>
                        <span class="glyphicon glyphicon-remove"></span> 
                    </button>
                    
                    <?php 
					$class = "";
					if(empty($row['attachment'])){
						 
						 $class = "disabled";
						 
					 }  ?>
                    <a class="btn btn-default btn-xs <?=$class?>" modal="download-coc-modal" title="Download"  href='<?=base_url("seaman/resume_process/download_attachment/?t=coc&id=$row[id_licenses]")?>' >
                      
                        <span class="fa fa-download"></span> 
                      
                    </a>
                    
                  </span>
                  <?php 
                  $now = date('Y-m-d');
                   if($e != "UNLIMITED"){
                          if($row['expired_date'] == "0000-00-00"){
                                
                              echo "";
                          }
                      else if($row['expired_date'] <= $now){
                        echo "<small class='label label-danger pull-right'><i class='fa fa-tag'></i> Expired</small>";
                      } else if($row['expired_date'] > $now){
                        $expired_date = new DateTime($row['expired_date']);
                        $now = new DateTime(date('Y-m-d'));

                        $difference = $expired_date->diff($now);
                   
                        // if ($difference->y == 0 AND $difference->d <= 180 AND $difference->m <= 6 AND $difference->days <= 180){

                        //   echo "<small class='label label-warning pull-right'> Expired in ".$difference->days." Days </small>";

                        // }

                        if($difference->y == 0 AND $difference->m <=6 AND $difference->days <= 180){

                              if($difference->m != 0 AND $difference->d != 0){

                                    echo "<small class='label label-warning pull-right' data-toggle='tooltip' data-placement='top' title='".$difference->m." months and ".$difference->d." days left'>".$difference->m." m  ".$difference->d." d left </small>";

                              } else if($difference->m != 0 AND $difference->d == 0){
                                  echo "<small class='label label-warning pull-right' data-toggle='tooltip' data-placement='top' title='".$difference->m." months left'>".$difference->m." m left </small>";
                              } else if($difference->m == 0 AND $difference->d != 0){
                                echo "<small class='label label-warning pull-right' data-toggle='tooltip' data-placement='top' title='".$difference->d." days left'>".$difference->d." d left </small>";
                              }

                        }

                      }




                }
                  ?>
                
                    <!-- <button class="btn btn-default btn-xs competency-update-btn" modal="form-update-competency" 
                    onclick="javascript:edit_cocend(<?=$row['id_licenses']?>)" title="Update">
                        <span class="glyphicon glyphicon-edit"></span> 
                    </button> -->

                    
                                  
                </td>
              </tr>
             <?php
             }
             ?>
            </tbody>
            </table>
        
    </div>