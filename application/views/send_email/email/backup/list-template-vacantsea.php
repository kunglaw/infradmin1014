<?php // list template vacantsea , untuk universal content ?>

<?php
$aaa = $this->load->database(DB2_GROUP,true);
$str = " SELECT a.*,b.tampil,b.nama_perusahaan,b.username FROM `infr6975_informaseadb2015`.`vacantsea` a LEFT JOIN `infr6975_informaseadb2015`.`perusahaan` b ON 

a.id_perusahaan = b.id_perusahaan
WHERE 
`stat` = 'open' AND b.tampil = 1 ORDER BY annual_sallary DESC LIMIT 8";

	$q = $aaa->query($str);
	
	$dt_vacantsea = $q->result_array();

?>

<div style="font-size:16px; margin-right:auto; margin-right:auto; width:80%; display:inline">
	<p> <b style="font-size:18px; color:#337AB7;" > Other vacantsea you may need right now </b> </p>
  			
	  <?php 
	  	//print_r($dt_vacantsea);
	  foreach($dt_vacantsea as $row){ 
	  	
	  ?>
	 
	  <div style="border:1px solid #000; float:left; display:inline-block; height:190px; width:20%; padding:20px; margin-left:1%; margin-bottom:20px"> 
	  	
        <a href="<?=infr_url("vacantsea/detail/$row[vacantsea_id]/$url_title")?>">
		<img style=" height:100px; width:150px; margin-bottom:20px; margin-right:20px; border:1px solid #999" 
		src="<?=check_logo_agentsea($row['username'])?>">
        </a>
        
		<div style=" text-align:left">
        	<?php // http://www.informasea.com/vacantsea/detail/17/electrical-officer 
				$url_title = url_title($row["vacantsea"]);
			?>
        	<div>
            	<b>
					<a href="<?=infr_url("vacantsea/detail/$row[vacantsea_id]/$url_title")?>"> <?=$row["vacantsea"]?> </a>
                </b>
            </div>
			<div> 
            	<b>  
                  <a href="<?=infr_url("agentsea/$row[username]/home")?>" style="text-decoration:none" target="_blank">
                  <?=$row['nama_perusahaan']?></a> 
            	</b> 
            </div>			
		</div>
		<div style="clear:both"></div>
	 
	  </div>
	   </a>
	  <?php } ?>
	  
	  <div style="clear:both"></div>

</div>
 <div style="clear:both"></div>