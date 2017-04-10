<?php // list template seatizen , untuk universal content ?>
<?php
	$a = $this->load->database(DB2_GROUP,true);
	
	if(!empty($vessel_type)){
		$str = "SELECT a.*,b.rank,b.department
	  FROM `infr6975_informaseadb2015`.`pelaut_ms` a 
	  
	  LEFT JOIN `infr6975_informaseadb2015`.`profile_resume_tr` b ON 
	  
	  a.pelaut_id = b.pelaut_id
  
	  WHERE a.activation = 'ACTIVE' and a.show = TRUE
	  AND b.vessel_type = '$vessel_type' 

	  ORDER BY create_date DESC LIMIT 8"; 
	}
	else if(!empty($department)){ 
	
	  $str = "SELECT a.*,b.rank,b.department
	  FROM `infr6975_informaseadb2015`.`pelaut_ms` a 
	  
	  LEFT JOIN `infr6975_informaseadb2015`.`profile_resume_tr` b ON 
	  
	  a.pelaut_id = b.pelaut_id
  
	  WHERE a.activation = 'ACTIVE' and a.show = TRUE
	  AND ( (department = '$department' OR rank = '$rank') AND (rank <> 0 AND department <> 0)"; 
	  if(!empty($vessel_type)) $str .= "AND b.vessel_type = '$vessel_type'";
	  
	  $str .= ") ORDER BY create_date DESC
	  LIMIT 8 ";
	}
	else
	{
		$str = "SELECT a.*,b.rank,b.department
		FROM `infr6975_informaseadb2015`.`pelaut_ms` a 
		
		LEFT JOIN `infr6975_informaseadb2015`.`profile_resume_tr` b ON 
		
		a.pelaut_id = b.pelaut_id
	
		WHERE a.activation = 'ACTIVE' and a.show = TRUE 
		AND a.nama_depan <> '' AND a.nama_belakang <> ''
		AND rank <> 0 AND department <> 0
	   
		ORDER BY create_date DESC
		LIMIT 8 ";

	}
	echo $str;
	$q = $a->query($str);
	
	$dt_seatizen = $q->result_array();

?>
<div style="font-size:16px; margin-right:auto; margin-right:auto; width:100%; display:inline">
	<p> <b style="font-size:18px; color:#337AB7;" > Other seatizen you may know </b> </p>
	  
	  <?php foreach($dt_seatizen as $row){ 
	  	
		$dt = $this->sm->get_detailseatizen_a($row['pelaut_id']);
	  ?>
	  <a href="<?=infr_url("profile/$row[username]")?>" style="text-decoration:none" target="_blank">
	  <div style="border:1px solid #000; float:left; display:inline-block; height:150px; width:18%; padding:20px; margin-left:1%; margin-bottom:20px"> 
	  
		<img style=" height:80px; width:80px; margin-bottom:30px; margin-right:20px; border:1px solid #999" 
		src="<?=check_profile_seaman($row['username'])?>">
		<div style=" text-align:left">
			<div> <b> 
				<?=$row['nama_depan']?> <?=$row['nama_belakang']?> </b> </div>
			<div><?=flag_plus_rank($row['kebangsaan'], $dt['rank'])?> </div>
			<!--<div> <?php //format_rank($dt['rank']) ?>
			<!--</div>-->
		</div>
		<span style="clear:both"></span>
	 
	  </div>
	   </a>
	  <?php } ?>
	  
	  <span style="clear:both"></span>

</div>