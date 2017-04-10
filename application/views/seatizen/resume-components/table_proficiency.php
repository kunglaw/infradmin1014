<div id="data-table-proficiency" class="jarak">
      <div>
      <h3 class="page-header" style="padding-bottom:0px"> Certificate of Proficiency </h3>
      
      	<button class="pull-right btn btn-filled btn-sm"  id="proficiency-btn" modal="form-add-proficiency">
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Add
      	</button>
        
      </div>
      
      <div class="clearfix" style="margin-bottom: 10px"></div>
      <div class="clearfix"></div>
      <table class="table table-bordered hover" >
          <thead>
            <tr>
              
              <th>Certificate</th>
              <th>Number </th>
              <th>Issued Place </th>
              <th> Issued Date </th>
              <th>Expiry Date <?php //$date_expired_lbl?></th>
              <!-- <th width="15%">Action</th> -->
            </tr>
          </thead>
          <tbody>
              <?php
              foreach($proficiency as $row2)
              {
              ?>
                <tr>
                  <td class='link-to-proficiency-attachment'> 
				  <?php
					if(empty($row2['attachment']))
					{ 
					  echo $row2['sertifikat_stwc']; 
					}
					else
					{
					  $t = "click to view attachment";
					  $file_type = '';
					 
					  $username = $this->session->userdata("username");
					  
					  $extensi = end(explode('.', $row2['attachment']));
					  $rep = strtolower(str_replace(' ','_',$row2['sertifikat_stwc']));
					  $rep = strtolower(str_replace('/','',$rep));
					  $nama_file = $rep.".$extensi";
					  $open = "class='data-gambar-proficiency'";
					  if(strtolower($extensi) == 'pdf') $open = "target='_blank' class='data-pdf-proficiency'";

					  echo "<a href='".img_url("document/$username/proficiency/$nama_file")."' title='$nama_file' $open > $row2[sertifikat_stwc] </a>"; 
					}
                  ?>
                  </td>
                  <td><a title="Data Sertifikat" data-toggle="popover" data-content="" 
                  id="data-sertifikat" href="#">
                  <form method="POST" action="http://pelaut.dephub.go.id/index.php?hal=src" target="_blank"> 
                  <input type="hidden" name="name" value="<?php echo substr($row2['no_sertifikat'],0,10); ?>">
                    <input type="submit" value="<?php echo $row2['no_sertifikat']; ?>" style="background:none;
                    border:none;color:#3366cc;onhover:color:red;">
                  </form>
				  <?php //echo $row2['no_sertifikat']; ?></a></td>
                  
                  <td><?php echo $row2['place_issue']; ?></td>
                  <td><?php echo date_format_str($row2['date_issue']); ?></td>
                  <td> <?php echo date_format_str($row2['expired_date']); ?>
                    <span class="pull-right col-md-4">
                  <button class="btn btn-default btn-xs proficiency-update-btn" modal="form-update-proficiency" title="Update" 
                    onclick="javascript:update_proficiency(<?php echo $row2['id_sertifikat']?>)">
                        <span class="glyphicon glyphicon-edit"></span> 
                    </button>
                    
                    <button class="btn btn-default btn-xs proficiency-delete-btn" modal="delete-proficiency-modal" title="Delete"
                    onclick="javascript:delete_proficiency(<?php echo $row2['id_sertifikat']?>)">
                        <span class="glyphicon glyphicon-remove"></span> 
                    </button>
                     <?php 
					 	$class = "";
					 	if(empty($row2['attachment'])){ $class ="disabled"; }
					 ?>
                        <a class="btn btn-default btn-xs <?=$class?>" modal="download-proficiency-modal" title="Download" href='<?=base_url("seaman/resume_process/download_attachment/?t=proficiency&id=$row2[id_sertifikat]")?>' >
                         
                            <span class="fa fa-download"></span> 
                         
                        </a>
                     
                  </span>
                    <?php 
                    $now = date('Y-m-d');
                    if($row2['expired_date'] == "0000-00-00"){
                      echo "";
                    }else if($row2['expired_date'] <= $now){
                        echo "<small class='label label-danger pull-right'><i class='fa fa-tag'></i> Expired</small>";
                      } else if($row2['expired_date'] > $now){
                        $expired_date = new DateTime($row2['expired_date']);
                        $now = new DateTime(date('Y-m-d'));

                        $difference = $expired_date->diff($now);
                        // if($difference->y==0 AND $difference->d <=30 AND $difference->m <= 6){
                        //      if($difference->y==0 AND $difference->d == 0 AND $difference->m <= 6){

                        //   echo "<small class='label label-warning pull-right'> Expired in ".$difference->m." months </small>";
                        //      }else {

                        //   echo "<small class='label label-warning pull-right'> Expired in ".$difference->m." months and ".$difference->d." Days </small>";
                        //      }
                        // } else

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

                     
                      ?>


                   
                    
                  </td>
                </tr>
  
              <?php
              }
              ?>
              </tbody>    
      </table>
    </div>