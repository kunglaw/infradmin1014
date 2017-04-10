<div id="data-table-experience" class="jarak">  
  <div>
      <h3 class="page-header" style="padding-bottom:0px"> Sea Record Service </h3>
  <button class="pull-right btn btn-filled btn-sm" id="experience-btn" modal="form-add-experience">
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Add
  </button>
  </div>
  
  <div class="clearfix" style="margin-bottom: 10px"></div>
  <div class="clearfix"></div>
  <table class="table table-bordered hover">
      <thead>
        <tr>
          <th width="">Vessel Name</th>
          <th width="">Vessel Type </th>
          <th>Size</th>
          <th>Rank</th>
          <th>Company</th>               
          <th width="20%">Periode</th>
          <th width="13%">Action</th>
        </tr>
      </thead>
      <tbody>
            <?php
                $this->load->model("vessel_model");
                
                $vessel_model = $this->vessel_model;
            
                foreach($experience as $row)
                {
                    //$vessel_name = $vessel_model->get_ship_detail($row['ship_id']);
                    $vessel_type = $vessel_model->get_ship_type_detail($row['ship_type_id']);
                    $rank 		= $this->resume_model->get_rank_detail($row['rank_id']);
                    
                    $periode_from = date_format_str($row['periode_from']);
                    $periode_to = date_format_str($row['periode_to']);
                    $create_date = date_format_str($row['datetime']);
                    $last_update = date_format_str($row['last_update']);
                     
            ?>
            <tr data-toggle="popover" data-content="Created: <?php echo $create_date; ?> Updated : <?php echo $last_update; ?> " id="data-update" data-placement="bottom" >
            
              <td ><?php echo $row['ship_name'] ?> </td>
              <td ><?php echo $vessel_type['ship_type'] ?> </td>
              <?php 
              if($row['satuan'] == 'm3'){
                $satuan = "M&sup3;";
              }else{
                $satuan = $row['satuan'];
              }
              ?>
              <td ><?php echo $row['weight']."  ".$satuan  ?></td>
              
              <td><?php  echo $rank['rank'] ?> </td>
              
              <td><?php echo $row['company'] ?></td>
              
              <td ><?php echo $periode_from ?> ~ <?php echo $periode_to; ?></td>
              <td > 
                <button class="btn btn-default btn-xs experience-update-btn" modal="form-update-experience" title="Update" 
                onclick="javascript:update_experience(<?php echo $row['experience_id']?>)">
                    <span class="glyphicon glyphicon-edit"></span> 
                </button>
                
                <button class="btn btn-default btn-xs experience-delete-btn" modal="delete-experience-modal" title="Delete"
                onclick="javascript:delete_experience(<?php echo $row['experience_id']?>)">
                    <span class="glyphicon glyphicon-remove"></span> 
                </button>
               
              </td>
            </tr>
            
            <?php
                }
            ?>
     </tbody>
  </table>
</div>