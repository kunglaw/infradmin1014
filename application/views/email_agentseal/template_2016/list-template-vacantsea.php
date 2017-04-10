<?php // list template vacantsea , untuk universal content ?>

<?php

// setting
	$list_title	   = "Top Vacantsea"; //Other Seatizen you may know
	$list_description = "";

$aaa = $this->load->database(DB2_GROUP,true);
$str = " SELECT a.*,b.tampil,b.nama_perusahaan,b.username FROM `infr6975_informaseadb2015`.`vacantsea` a LEFT JOIN `infr6975_informaseadb2015`.`perusahaan` b ON 

a.id_perusahaan = b.id_perusahaan
WHERE 
`stat` = 'open' AND b.tampil = 1 AND a.expired_date > now() ORDER BY annual_sallary DESC LIMIT 8";

	$q = $aaa->query($str);
	
	$dt_vacantsea = $q->result_array();

?>

<div style="font-size:16px; margin-right:auto; margin-right:auto; width:80%; display:inline">
	<p> <b style="font-size:18px; color:#337AB7;" > <?=$list_title?> </b> </p>
    <div><?=$list_description?></div>
  			
	  <?php 
	  	//print_r($dt_vacantsea);
	  foreach($dt_vacantsea as $row){ 
	  	
	  ?>
       
       <?php // http://www.informasea.com/vacantsea/detail/17/electrical-officer 
			$url_title = url_title($row["vacantsea"]);
		?>
       
       <a href="<?=infr_url("vacantsea/detail/$row[vacantsea_id]/$url_title")?>" style="text-decoration:none" target="_blank">
          <span style="float:left; font-size:14px; margin:0 9px 10px 0; width:48%; display:inline; text-align:left">
            <span style="float:left; margin-right:10px;">
                <img src="<?=check_logo_agentsea($row['username'])?>" 
                style="width:90px; height:90px; border:1px solid grey" mc:label="image" mc:edit="tiwc150_image00">
            </span>
            <span style="float:left; width:55%" >
                <span><b> <?=$row["vacantsea"]?> </b></span><br>
                <span> <?=$row['nama_perusahaan']?> </span><br>
               
            </span>
            
          </span>
  	   </a>
       
	  <?php } ?>
	  
	  <div style="clear:both"></div>

</div>
 <div style="clear:both"></div>