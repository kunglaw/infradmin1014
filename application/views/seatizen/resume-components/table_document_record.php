<div class="data-table-document">
        <div ><h3>  Document and Medical Record </h3></div>
        
        <div class="clearfix"></div>    
        
        <h5> Document Record <button class="btn btn-filled btn-sm pull-right" id="document-btn" modal="form-add-document"> 
            <span class="glyphicon glyphicon-plus"></span> Add 
        </button> </h5>
        <br />

        <div id="gambar-semua-document" style="display:none"> <!-- style="display:none" -->
        <ul id="grouped-image-list" class="link-list">
          <?php foreach($document as $row) { 
            if(!empty($row['attachment']))
              { 
                $file_type = '';
                $username = $this->session->userdata("username");
                
                $extensi = end(explode('.', $row['attachment']));
                $nama_file = strtolower($row['country'])."_".strtolower(str_replace(' ', '_', $row['type'])).".$extensi";
                $open = "";
                // echo strtolower($extensi)
                if(strtolower($extensi) != "pdf") { 
                  echo "<li><a href='".img_url("document/$username/doc/document_record/$nama_file")."' title='$t' $open > $row[country] $row[type] </a></li>"; 
                }

                
                //echo "<a class='preview' href='' title='Citra Kirana Cakepan pake jilbab kan?'><img alt='citra kirana' src='http://2.bp.blogspot.com/-2Oi1k1h9LQ8/UWzRHgDLwsI/AAAAAAAAD4Y/GLb0ky9qbTk/s1600/citra-kirana.jpg' width='150' /></a>";
              }
            ?>
            <!-- <li><a href="http://placehold.it/400x300/0cc/f7f7f7" title="Title 1">Image 1</a></li> -->
            <?php
          } ?>
          <!-- <li><a href="http://placehold.it/400x300/0cc/f7f7f7" title="Title 1">Image 1</a></li>
          <li><a href="http://placehold.it/300x400/c0c/f7f7f7" title="Title 2">Image 2</a></li>
          <li><a href="http://placehold.it/400x300/cc0/f7f7f7" title="Title 3">Image 3</a></li>
          <li><a href="http://placehold.it/300x400/777/f7f7f7" title="Title 4">Image 4</a></li> -->
        </ul>
      </div>
        
        <table class="table table-bordered hover">
            <thead>
              <th>Type</th>
              <th>Number</th>
              <th>Issued Place</th>
              <th>Issued Date</th>
              <th>Expiry Date</th>
            </thead>
            <tbody>
            
            <?php foreach($document as $row) {
                  if ($row['type_document'] == "document") {
                      $date_issued = date_format_str($row['date_issued']);
                      $date_expired = date_format_str($row['date_expired']);

                      // $a = explode("|",$row['type']);
                      // $b = implode(" ",$a);
    
            ?>
                  <tr>
                   
                    <td class='link-to-document-attachment'>
						
						<?php
							if(empty($row['attachment']))
							{ 
								echo $row['country']." ".$row['type']; 
							}
							else
							{
								
								$file_type = '';
								$username = $this->session->userdata("username");
								
								$extensi = end(explode('.', $row['attachment']));
								$nama_file = strtolower($row['country'])."_".strtolower(str_replace(' ', '_', $row['type'])).".$extensi";
								$open = "class='data-gambar-document'";
								// echo strtolower($extensi)
								if(strtolower($extensi) == "pdf") { $open = "target='_blank' class='data-pdf-document'"; }
				
								echo "<a href='".img_url("document/$username/doc/document_record/$nama_file")."' title='$nama_file' $open > $row[country] $row[type] </a>";	
                //echo "<a class='preview' href='' title='Citra Kirana Cakepan pake jilbab kan?'><img alt='citra kirana' src='http://2.bp.blogspot.com/-2Oi1k1h9LQ8/UWzRHgDLwsI/AAAAAAAAD4Y/GLb0ky9qbTk/s1600/citra-kirana.jpg' width='150' /></a>";
							}
						?>
                    
                    </td>
                    <td><?php echo $row['number'] ?> </td>
                    <td><?php echo $row['place'] ?> </td>
                    
                    <td><?php echo $date_issued ?></td>
                    <td><?php echo $date_expired ?>
					  
                      <span class="pull-right" style="width:103px; margin-left:10px">
                      		
                        <button class="btn btn-default btn-xs document-update-btn" modal="form-update-document" title="Update" 
                        onclick="javascript:update_document(<?=$row['document_id']?>)" >
                          <span class="glyphicon glyphicon-edit"></span> 
                        </button>
                        <?php 
                        $style = "";
                        if($row['type'] == 'Passport' || ($row['bawaan'] == 1)  ) { 
                          $style = "style='visibility:hidden'";
                        } ?>
                        <button class="btn btn-default btn-xs document-delete-btn" modal="delete-document-modal" title="Delete" 
                        onclick="javascript:delete_document(<?=$row['document_id']?>)" <?php echo $style ?> >
                          <span class="glyphicon glyphicon-remove"></span> 
                        </button>
                        <?php 
						  $disabled="";
						  $title_tag = "Download";
						  $href=base_url("seaman/resume_process/download_attachment/?t=document&id=$row[document_id]"); 
						  if(empty($row['attachment'])){ 
							$disabled = "disabled";
							$title_tag = "Download not Available";
						  } 
						?>
                            <a  class="btn btn-default btn-xs document-delete-btn <?=$disabled?>" modal="download-document-modal"
                             title="<?=$title_tag?>" href='<?=$href?>'>
                            	<span class="fa fa-download"></span> 
                            </a>
                      </span>
                      
                      <?php 
                        $now = date('Y-m-d');
                        if($row['date_expired'] == "0000-00-00"){
                          echo "";
                        } else  if($row['date_expired'] <= $now){
                          echo "<small class='label label-danger pull-right'><i class='fa fa-tag'></i> Expired</small>";
                        }      else if($row['date_expired'] <= $now){
                        echo "<small class='label label-danger pull-right'><i class='fa fa-tag'></i> Expired</small>";
                      } else if($row['date_expired'] > $now){
                        $expired_date = new DateTime($row['date_expired']);
                        $now = new DateTime(date('Y-m-d'));

                        $difference = $expired_date->diff($now);
                   
                        // if ($difference->y == 0 AND $difference->d <= 180 AND $difference->m <= 6 AND $difference->days <= 180){

                        //   echo "<small class='label label-warning pull-right'> Expired in ".$difference->days." Days </small>";

                       // }

                          // if($difference->y == 0 AND $difference->d <= 30 AND $difference->m <=6 AND $difference->days <= 180){
                          //     echo "<small class='label label-warning pull-right'> Expired in ".$difference->m.' Months and '.$difference->d.' days';                
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
                }
            ?>
            </tbody>
        </table>
        
         <br>

         <h5> Visa <button class="btn btn-filled btn-sm pull-right" id="visa_btn" id_pelaut="<?php echo $document[0]['pelaut_id'] ?>" modal="form-add-visa"> <span class="glyphicon glyphicon-plus"> </span> Add </button>
          <br /> </h5>
          
          <div id="gambar-semua-document" style="display:none"> <!-- style="display:none" -->
            <ul id="grouped-image-list" class="link-list">
              <?php foreach($visa as $row) { 
                if(!empty($row['attachment']))
                  { 
                    $file_type = '';
                    $username = $this->session->userdata("username");
                    
                    $extensi = end(explode('.', $row['attachment']));
                    $nama_file = strtolower(str_replace(' ', '_', $row['type'])).".$extensi";
                    $open = "";
                    // echo strtolower($extensi)
                    if(strtolower($extensi) != "pdf") { 
                      echo "<li><a href='".img_url("document/$username/doc/visa/$nama_file")."' title='$t' $open > $row[country] $row[type] </a></li>"; 
                    }
    
                    
                    //echo "<a class='preview' href='' title='Citra Kirana Cakepan pake jilbab kan?'><img alt='citra kirana' src='http://2.bp.blogspot.com/-2Oi1k1h9LQ8/UWzRHgDLwsI/AAAAAAAAD4Y/GLb0ky9qbTk/s1600/citra-kirana.jpg' width='150' /></a>";
                  }
                ?>
                <!-- <li><a href="http://placehold.it/400x300/0cc/f7f7f7" title="Title 1">Image 1</a></li> -->
                <?php
              } ?>
              <!-- <li><a href="http://placehold.it/400x300/0cc/f7f7f7" title="Title 1">Image 1</a></li>
              <li><a href="http://placehold.it/300x400/c0c/f7f7f7" title="Title 2">Image 2</a></li>
              <li><a href="http://placehold.it/400x300/cc0/f7f7f7" title="Title 3">Image 3</a></li>
              <li><a href="http://placehold.it/300x400/777/f7f7f7" title="Title 4">Image 4</a></li> -->
            </ul>
          </div>
          
          <table class="table table-bordered hover">
            <thead>
               <th>Type</th>
              <th>Number</th>
              <th>Issued Place</th>
              <th>Issued Date</th>
              <th>Expiry Date</th>
            </thead>
            <tbody>
              <?php 
              foreach($visa as $row){ ?>
              <tr>
              	
                <td class='link-to-document-attachment'>
						
					<?php
                        if(empty($row['attachment']))
                        { 
                            echo $row['country']." ".$row['type']; 
                        }
                        else
                        {
                            
                            $file_type = '';
                            $username = $this->session->userdata("username");
                            
                            $extensi = end(explode('.', $row['attachment']));
                            $nama_file = strtolower(str_replace(' ', '_', $row['type'])).".$extensi";
                            $open = "class='data-gambar-document'";
                            // echo strtolower($extensi)
                            if(strtolower($extensi) == "pdf") { $open = "target='_blank' class='data-pdf-document'"; }
            
                            echo "<a href='".img_url("document/$username/doc/visa/$nama_file")."' title='$nama_file' $open > $row[country] $row[type] </a>";	
            //echo "<a class='preview' href='' title='Citra Kirana Cakepan pake jilbab kan?'><img alt='citra kirana' src='http://2.bp.blogspot.com/-2Oi1k1h9LQ8/UWzRHgDLwsI/AAAAAAAAD4Y/GLb0ky9qbTk/s1600/citra-kirana.jpg' width='150' /></a>";
                        }
                    ?>
                
                </td>
              <!--  <?php //echo $row['type']; ?> </td> -->
              <td> <?php echo $row['number']; ?> </td>
              <td> <?php echo $row['place']; ?> </td>
              <td> <?php   
              if($row['date_issued'] != "0000-00-00"){
                echo date_format_str($row['date_issued']);
              } else {
                echo "";
              }
              ?>
               </td>
              <td> <?php echo date_format_str($row['date_expired']); ?> 
                <span class="pull-right col-md-3">
                   <button class="btn btn-default btn-xs document-update-btn" modal="form-update-document" title="Update" 
                    onclick="javascript:update_visa(<?=$row['document_id']?>)" >
                      <span class="glyphicon glyphicon-edit"></span> 
                    </button>
                    
                    <button class="btn btn-default btn-xs document-delete-btn" modal="delete-document-modal" title="Delete" 
                    onclick="javascript:delete_visa(<?=$row['document_id']?>)" >
                      <span class="glyphicon glyphicon-remove"></span> 
                    </button>
                    <?php 	
						$class="";
                        if(empty($row['attachment'])){						
                          $class = "disabled";
                        } 
					?>
                          <a  class="btn btn-default btn-xs <?=$class?>" href='<?=base_url("seaman/resume_process/download_attachment/?t=visa&id=$row[document_id]")?>' modal="download-visa-modal" title="Download">
                            <span class="fa fa-download"></span> 
                          </a>
                  </span>
              <?php 
                                  $now = date('Y-m-d');
                                  if($row['date_expired'] <= $now){
                                    echo "<small class='label label-danger pull-right'><i class='fa fa-tag'></i> Expired</small>";
                                  }     
                                  else if($row['date_expired'] <= $now){
                        echo "<small class='label label-danger pull-right'><i class='fa fa-tag'></i> Expired</small>";
                      } else if($row['date_expired'] > $now){
                        $expired_date = new DateTime($row['date_expired']);
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


                                  ?>




              <!-- </td> -->
              <!-- <td>
              	
              </td> 
              <td>  -->
                
              </td>
            </tr>
 

              <?php } ?>

            </tbody>
          </table>

          <br>
            
          <?php //$this->load->view('form-add-experience')?>
            
          <h5> Medical Record <button class="btn btn-filled btn-sm pull-right" id="medical-btn" id_pelaut="<?php echo $document[0]['pelaut_id'] ?>" modal="form-add-medical"><span class="glyphicon glyphicon-plus"></span> Add </button>
          <br> </h5> 
          
          <div id="gambar-semua-document" style="display:none"> <!-- style="display:none" -->
            <ul id="grouped-image-list" class="link-list">
              <?php foreach($medical as $row) { 
                if(!empty($row['attachment']))
                  { 
                    $file_type = '';
                    $username = $this->session->userdata("username");
                    
                    $extensi = end(explode('.', $row['attachment']));
                    $nama_file = strtolower(str_replace(' ', '_', $row['type'])).".$extensi";
                    $open = "";
                    // echo strtolower($extensi)
                    if(strtolower($extensi) != "pdf") { 
					
                      echo "<li><a href='".img_url("document/$username/doc/medical_record/$nama_file")."' title='$t' $open > $row[country] $row[type] </a></li>"; 
                    }
    
                    
                    //echo "<a class='preview' href='' title='Citra Kirana Cakepan pake jilbab kan?'><img alt='citra kirana' src='http://2.bp.blogspot.com/-2Oi1k1h9LQ8/UWzRHgDLwsI/AAAAAAAAD4Y/GLb0ky9qbTk/s1600/citra-kirana.jpg' width='150' /></a>";
                  }
                ?>
                <!-- <li><a href="http://placehold.it/400x300/0cc/f7f7f7" title="Title 1">Image 1</a></li> -->
                <?php
              } ?>
              <!-- <li><a href="http://placehold.it/400x300/0cc/f7f7f7" title="Title 1">Image 1</a></li>
              <li><a href="http://placehold.it/300x400/c0c/f7f7f7" title="Title 2">Image 2</a></li>
              <li><a href="http://placehold.it/400x300/cc0/f7f7f7" title="Title 3">Image 3</a></li>
              <li><a href="http://placehold.it/300x400/777/f7f7f7" title="Title 4">Image 4</a></li> -->
            </ul>
          </div>
          
           <table class="table table-bordered hover">
                <thead>
                <th>Type</th>
                <th>Number</th>
                <th>Issued Place</th>
                <th>Issued Date</th>
                <th>Expiry Date</th>
                </thead>
                <tbody>
                <?php
  
                foreach($medical as $row) {
					
                    if ($row['type_document'] == "medical" || $row['type_document'] == "medical_cert") {
                        //$date_issued = date_format_str($row['date_issued']);
                        $date_expired = date_format_str($row['date_expired']);
  
                        ?>
                        <tr>
                            <td class='link-to-medical-attachment'>
                              <?php
                                if(empty($row['attachment']))
                                { 
                                  echo $row['country']." ".$row['type']; 
                                }
                                else
                                {
                                  $t = "click to view attachment";
                                  $file_type = '';
                                 
                                  $username = $this->session->userdata("username");
                                  
                                  $extensi = end(explode('.', $row['attachment']));
                                  $nama_file = strtolower(str_replace(' ','_', $row['type'])).".$extensi";
                                  $open = "class='data-gambar-medical'";
                                  if(strtolower($extensi) == 'pdf') $open = "target='_blank' class='data-pdf-medical'";

                                  echo "<a href='".img_url("document/$username/doc/medical_record/$nama_file")."' title='$nama_file' $open > $row[type] </a>"; 
                                }
                            ?>
                            </td>
                            <td><?php echo $row['number'] ?> </td>
                            <td><?php echo $row['place'] ?> </td>
  
                            <td>
                            
                            <?php   
                            if($row['date_issued'] != "0000-00-00"){
                              echo date_format_str($row['date_issued']);
                            } else {
                              echo "";
                            }
                            ?> 
                            </td>
                            <td><?php echo date_format_str($date_expired); ?>
                              <span class="pull-right col-md-3">
                                <button class="btn btn-default btn-xs document-update-btn" modal="form-update-document" title="Update" 
                                onclick="javascript:update_medical(<?=$row['document_id']?>)" >
                                  <span class="glyphicon glyphicon-edit"></span> 
                                </button>
                                
                                <button class="btn btn-default btn-xs document-delete-btn" modal="delete-document-modal" title="Delete" 
                                onclick="javascript:delete_document(<?=$row['document_id']?>)" >
                                  <span class="glyphicon glyphicon-remove"></span> 
                                </button>
                                <?php $class="";
                                  if(empty($row['attachment'])){ 
                                    $class = "disabled";
                                    } 
                                ?>
                                <a class="btn btn-default btn-xs document-delete-btn <?php echo $class ?>" href='<?=base_url("seaman/resume_process/download_attachment/?t=medical_record&id=$row[document_id]")?>' modal="download-medical-modal" title="Download" >
                                 
                                    <span class="fa fa-download"></span> 
                                  
                                </a>
                              </span>
                              <?php 
                              $now = date('Y-m-d');
                              if($row['date_expired'] <= $now){
                                echo "<small class='label label-danger pull-right'><i class='fa fa-tag'></i> Expired</small>";
                              }     
                              else if($row['date_expired'] <= $now){
                    echo "<small class='label label-danger pull-right'><i class='fa fa-tag'></i> Expired</small>";
                  } else if($row['date_expired'] > $now){
                    $expired_date = new DateTime($row['date_expired']);
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
                              ?>
                            </td>
                        </tr>
                        
  
                    <?php
                    }
                }
                ?>
                </tbody>
           </table>
        
    </div>