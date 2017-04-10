<?php // list template vacantsea , untuk universal content ?>

<?php
$now = date("Y-m-d H:i:s");

if(empty($vacantsea))
{

  //$aaa = $this->load->database(DB2_GROUP,true);
  $str = " SELECT a.*,b.tampil,b.nama_perusahaan,b.username,c.valid_email,c.status FROM `infr6975_informaseadb2015`.`vacantsea` a 
  LEFT JOIN `infr6975_informaseadb2015`.`perusahaan` b ON a.id_perusahaan = b.id_perusahaan  
  LEFT JOIN `infr6975_informaseadb2015`.`perusahaan_setting` c ON b.id_perusahaan = c.id_perusahaan
  WHERE 
  `stat` = 'open' AND status = 'VERIFIED' AND valid_email = 'valid' AND a.expired_date > '$now' ORDER BY annual_sallary DESC LIMIT 8";
  
  $q = $this->db->query($str);	  
  $dt_vacantsea = $q->result_array();
  
}
else
{
	
	$dt_vacantsea = $vacantsea;	
}

?>

<div style="font-size:16px; margin-right:auto; margin-right:auto; width:80%; display:inline">
	<p> <b style="font-size:18px; color:#337AB7;" > Other Vacantsea </b> </p>
    <div><?=$list_description?></div>
  			
	  <?php 
	  	//print_r($dt_vacantsea);
	  foreach($dt_vacantsea as $row){ 
	  	
		if(empty($row["data_scrap"]))
		{
			$str_vac = "SELECT * FROM perusahaan WHERE id_perusahaan = $row[id_perusahaan]";
			$q_vac = $this->db->query($str_vac);
			$f_vac = $q_vac->row_array();
		}
		else
		{
			$f_vac = json_decode($row["data_scrap"],TRUE);
		}
		
	  ?>
       
       <?php // http://www.informasea.com/vacantsea/detail/17/electrical-officer 
			$url_title = url_title($row["vacantsea"]);
		?>
       
       <a href="<?=infr_url("vacantsea/detail/$row[vacantsea_id]/$url_title")?>" style="text-decoration:none" target="_blank">
          <span style="float:left; font-size:14px; margin:0 9px 10px 0; width:48%; display:inline; text-align:left">
            <span style="float:left; margin-right:10px;">
                <img src="<?=check_logo_agentsea($f_vac['username'])?>" 
                style="width:90px; height:90px; border:1px solid grey" mc:label="image" mc:edit="tiwc150_image00">
            </span>
            <span style="float:left; width:55%" >
                <span><b> <?=$row["vacantsea"]?></b></span><br>
                <span> <?=$row['perusahaan']?> </span><br>
               
            </span>
            
          </span>
  	   </a>
       
	  <?php } ?>
	  
	  <div style="clear:both"></div>

</div>