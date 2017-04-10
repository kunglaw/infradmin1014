<?php // list template seatizen , untuk universal content ?>
<?php
	// setting
	if($user_type == "seatizen")
	{
		$list_title	   = "Other seatizen you may know"; //Other Seatizen you may know
		$list_description = "";
	}
	else if($user_type = "agentsea")
	{
		$list_title	   = "Our Qualified Seatizen";
		$list_description = "";
	}
	
	$a = $this->load->database(DB2_GROUP,true);
	$q = "select rank_id, rank from rank where id_department = '$department'";
	$exec = $a->query($q);
	$dt_rank_dept = $exec->result_array();
	
	shuffle($dt_rank_dept);


	$q = "SELECT a.*,b.rank,b.department FROM `infr6975_informaseadb2015`.`pelaut_ms` a LEFT JOIN `infr6975_informaseadb2015`.`profile_resume_tr` b ON a.pelaut_id = b.pelaut_id WHERE a.activation = 'ACTIVE' and a.show = TRUE AND a.nama_depan <> '' AND a.nama_belakang <> '' AND rank = '$rank' ORDER BY a.create_date DESC";
	$exec = $a->query($q);
	$hasil = $exec->result_array();
	$jumlah = count($hasil);
	if($jumlah > 0){
		if($jumlah < 8) {
			$index_terakhir = $jumlah;
			$dt_seatizen = $hasil;

			foreach ($dt_rank_dept as $rank) {
				if($index_terakhir == 8) break;
				$q = "SELECT a.*,b.rank,b.department FROM `infr6975_informaseadb2015`.`pelaut_ms` a LEFT JOIN `infr6975_informaseadb2015`.`profile_resume_tr` b ON a.pelaut_id = b.pelaut_id WHERE a.activation = 'ACTIVE' and a.show = TRUE AND a.nama_depan <> '' AND a.nama_belakang <> '' AND rank = '$rank[rank_id]' ORDER BY a.create_date DESC";
				$exec = $a->query($q);
				$hasil = $exec->result_array();
				$jumlah_rank = count($hasil);
				if($jumlah_rank == 0) continue;
				
				
					$q=0;
					foreach ($hasil as $seatizen) {
						if($index_terakhir == 8) break;
						$dt_seatizen[$index_terakhir++] = $hasil[$q++];
					}
			}
		}
		else {
			$q=0;
			foreach ($hasil as $seatizen) {
				if($q >= 8) break;
				$dt_seatizen[$q] = $hasil[$q++];
			}
		}
	}
	// if(!empty($vessel_type)){
	// 	$str = "SELECT a.*,b.rank,b.department
	//   FROM `infr6975_informaseadb2015`.`pelaut_ms` a 
	  
	//   LEFT JOIN `infr6975_informaseadb2015`.`profile_resume_tr` b ON 
	  
	//   a.pelaut_id = b.pelaut_id
  
	//   WHERE a.activation = 'ACTIVE' and a.show = TRUE
	//   AND b.vessel_type = '$vessel_type'";
	//   if(!empty($department)){ 
	//   	$str .= " and department = '$department' ";
	//   }
	//   $str .= "ORDER BY create_date DESC LIMIT 8"; 
	// }
	// else if(!empty($department)){ 
	
	//   $str = "SELECT a.*,b.rank,b.department
	//   FROM `infr6975_informaseadb2015`.`pelaut_ms` a 
	  
	//   LEFT JOIN `infr6975_informaseadb2015`.`profile_resume_tr` b ON 
	  
	//   a.pelaut_id = b.pelaut_id
  
	//   WHERE a.activation = 'ACTIVE' and a.show = TRUE
	//   AND ( (department = '$department' OR rank = '$rank') AND (rank <> 0 AND department <> 0)"; 
	//   if(!empty($vessel_type)) $str .= "AND b.vessel_type = '$vessel_type'";
	  
	//   $str .= ") ORDER BY create_date DESC
	//   LIMIT 8 ";
	// }
	// else
	// {
	// 	$str = "SELECT a.*,b.rank,b.department
	// 	FROM `infr6975_informaseadb2015`.`pelaut_ms` a 
		
	// 	LEFT JOIN `infr6975_informaseadb2015`.`profile_resume_tr` b ON 
		
	// 	a.pelaut_id = b.pelaut_id
	
	// 	WHERE a.activation = 'ACTIVE' and a.show = TRUE 
	// 	AND a.nama_depan <> '' AND a.nama_belakang <> ''
	// 	AND rank <> 0 AND department <> 0
	   
	// 	ORDER BY create_date DESC
	// 	LIMIT 8 ";

	// }
	// // echo $str;
	
	// $q = $a->query($str);
	
	// $dt_seatizen = $q->result_array();

?>

<p> <b style="font-size:18px; color:#337AB7;" > <?=$list_title?></b> </p>
<div><?=$list_description?></div>

<?php foreach($dt_seatizen as $row){ 
  
  $dt = $this->sm->get_detailseatizen_a($row['pelaut_id']);
?>
   <a href="<?=infr_url("profile/$row[username]")?>" style="text-decoration:none" target="_blank">
  <span style="float:left; font-size:14px; margin:0 9px 10px 0; width:48%; display:inline; text-align:left">
    <span style="float:left; margin-right:10px;">
        <img src="<?=check_profile_seaman($row['username'])?>" 
        style="width:90px; height:90px; border:1px solid grey" mc:label="image" mc:edit="tiwc150_image00">
    </span>
    <span style="float:left; width:55%" >
        <span><b> <?=$row['nama_depan']?> <?=$row['nama_belakang']?></b></span><br>
        <span> <?=flag_plus_rank($row['kebangsaan'], $dt['rank'])?> </span><br>
       
    </span>
    
  </span>
  </a>
<?php } ?>

<span style="clear:both"></span>

