<?php // list template agentsea , untuk universal content ?>

<?php
	
	// setting
	$list_title	   = "Other agentsea you may know"; //Other Seatizen you may know
	$list_description = "";
	
	$str = "SELECT *
	FROM `infr6975_informaseadb2015`.`perusahaan`
	WHERE `tampil` =1
	AND `activation_code` = 'ACTIVE'
	ORDER BY `id_perusahaan` DESC
	LIMIT 8 ";
	
	$q = $this->db->query($str);
	
	$dt_agentsea = $q->result_array();

?>

	<p> <b style="font-size:18px; color:#337AB7;" > <?=$list_title?> </b> </p>
    <div><?=$list_description?></div>
	  
	  <?php foreach($dt_agentsea as $row){ 
	  
	  ?>
       
       <a href="<?=infr_url("agentsea/$row[username]/home")?>" style="text-decoration:none" target="_blank">
  <span style="float:left; font-size:14px; margin:0 9px 10px 0; width:48%; display:inline; text-align:left">
    <span style="float:left; margin-right:10px;">
        <img src="<?=check_logo_agentsea($row['username'])?>" 
        style="width:90px; height:90px; border:1px solid grey" mc:label="image" mc:edit="tiwc150_image00">
    </span>
    <span style="float:left; width:55%" >
        <span><b> <?=$row['nama_perusahaan']?> </b></span><br>
        <span><?=flag_nationality($row['nationality'])?> </span><br>
       
    </span>
    
  </span>
  </a>
	  <?php } ?>
	  
	<span style="clear:both"></span>