<?php // new email activation code for agentsea ?>
<!-- 
bg-primary : #337AB7
bg-success: #DFF0D8
bg-info   : #D9EDF7
bg-warning : #FCF8E3
bg-danger: #F2DEDE
-->

<div style="
margin:0 auto; 
padding:0; 
font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; 
width:80%;
font-size:16px; 
border:1px solid black; ">
	
   <?php include "header_email_template.php"; ?>
    
    <div style="min-height:200px;
    padding:10px 20px 10px 20px;
    ">
    	
		<h3> dear, Mr/s. <?=$contact_person?>  </h3>
    
    	<p> Introducing our recruitment crew system on <a href="<?=infr_url()?>"> <b>informasea.com</b> </a>. </p>       
        
        <p> Based on our discussion before about our offering to share your vacancy, you may check by clicking this button below : </p>
        
        <p align="center">
        	<div style="border:1px solid black; padding:20px; width:50%">
            	<?php $vac_title = url_title($vacantsea["vacantsea"])?>
            	
                <p>
                  <a href="<?=infr_url("vacantsea/detail/$vacantsea_id/$vac_title")?>">
                      <h4> <?=$vacantsea["vacantsea"]?> </h4>
                  </a>
                  <a href="<?=infr_url("agentsea/$company[username]/home")?>">
                      <?=$company["company"]?>
                  </a>
                </p>

                <div style="color:grey">Navigation Area : <?=$vacantsea["navigation_area"]?></div>
                <?php
					$str2 = "SELECT * FROM rank WHERE rank_id = '$vacantsea[rank_id]' ";
					$q2   = $this->db->query($str2);
					$f2   = $q2->row_array();
				?>
                <div style="color:grey">Rank : <?=$f2["rank"]; ?></div>
                
                <div style="color:grey"> Contract dynamic : <?=$vacantsea["contract_dynamic"]?> </div>
                
                <div style="color:grey">Annual Salary : <br> <h4 style="color:green"> 
					<?=$vacantsea["sallary_curr"]?> &nbsp; <?=$vacantsea["annual_sallary"]; ?> <?=$vacantsea["sallary_range"]?> </h4>
                </div>
                
                <center> <a href="<?=infr_url("vacantsea/detail/$vacantsea_id/$vac_title")?>" 
                style="font-size: 10pt; color:#FFF;
                background-color: #F90; padding: 10px 10px 10px 10px; text-decoration : none;   ">Detail Vacantsea >></a> </center>
                <span style="clear:both"></span>
                
            </div>
             <span style="clear:both"></span>
        </p>
        
        <div style="line-height:20px">
        	<div> You may see full resume of your applicant by login using : </div>
        	<div> Email : <?=$email?> </div>
            <div> Username : <?=$company['username']?> </div>
            <div> Password : <?=$password?> </div>
        </div>
        
        <p>Access your <a href="<?=$str_url?>" > Dashboard </a> to hire or send a message to your applicant.</p>
        
        <!-- <center>
          <div style="
              background-color:#337AB7;
              width:250px;
              height:50px;
              line-height:50px; 
              margin-top:50px;
              margin-bottom:50px;
          ">
          <a href="<?=$str_url?>" style="text-decoration:none; text-align:center;">
              <!-- button 
              <h2 style="color:#FFF; vertical-align:middle">Login</h2>    
          </a>
          </div>
        </center> -->
        
        
        <?php  include "email_info.php"; ?>
        
    
    </div>
   <?php include "footer_email_template.php"; ?>
	
</div>