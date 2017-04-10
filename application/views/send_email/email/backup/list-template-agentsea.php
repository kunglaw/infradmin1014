<?php // list template agentsea , untuk universal content ?>

<?php
	
	$str = "SELECT *
	FROM `infr6975_informaseadb2015`.`perusahaan`
	WHERE `tampil` =1
	AND `activation_code` = 'ACTIVE'
	ORDER BY `id_perusahaan` DESC
	LIMIT 8 ";
	
	$q = $this->db->query($str);
	
	$dt_agentsea = $q->result_array();

?>

<div style="font-size:16px; margin-right:auto; margin-right:auto; width:80%; display:inline">
	<p> <b style="font-size:18px; color:#337AB7;" > Other Agentsea you may know </b> </p>
	  
	  <?php foreach($dt_agentsea as $row){ 
	  
	  ?>
	  <a href="<?=infr_url("agentsea/$row[username]/home")?>" style="text-decoration:none" target="_blank">
	  <div style="border:1px solid #000; float:left; display:inline-block; height:190px; width:20%; padding:20px; margin-left:1%; margin-bottom:20px"> 
	  
		<img style=" height:80px; width:80px; margin-bottom:30px; margin-right:20px; border:1px solid #999" 
		src="<?=check_logo_agentsea($row['username'])?>">
		<div style=" text-align:left">
			<div> <b> <?=$row['nama_perusahaan']?> </b> </div>
			<div><?=flag_nationality($row['nationality'])?> </div>
			
		</div>
		<span style="clear:both"></span>
	 
	  </div>
	   </a>
	  <?php } ?>
	  
	  <span style="clear:both"></span>

</div>
<div style="clear:both"></div>