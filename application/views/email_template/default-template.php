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
font-size:14px; 
border:1px solid black; ">
	
    <div style="
    background-color:#2ab8e7;
    margin-top:0px;
    height:100px;
    padding:20px 20px 0px 20px;
    display:block;
    " >
    	<!-- header -->
        <div style="clear:both"></div>
        <center>
          <a href="<?=infr_url()?>" style="text-decoration:none;display:block; " target="_blank"> 
          	  <img src="<?=LOGO_INFORMASEA_BIG?>" alt="informasea" style="line-height:100px" 
              title="<?=TITLE." - ".INFORMASEA_SLOGAN?>" >
              <!-- <h1 style="color:#FFF; font-size:48px"><?=TITLE?></h1>--> 
          </a>
          <div style="color:#FFF; display:block;"><?=INFORMASEA_SLOGAN?></div>
        </center>
    </div>
    
    <div style="min-height:200px;
    padding:10px 20px 10px 20px;
    ">
    	<!-- body -->
        <?=$body?>
        
        <!-- info -->
        <div>
        	<div>Have fun on board.</div>
            <div><b style="color:#337AB7">Informasea</b> team, </div>
            <b><a href="mailto:<?=$config["smtp_user"]?>" style="text-decoration:none" target="_blank"><?=$config["smtp_user"]?></a></b>
            
            <p>This Email was sent to <b><?=$email_to?></b> from 
            <b><a href="mailto:<?=$config["smtp_user"]?>" style="text-decoration:none" target="_blank"><?=$config["smtp_user"]?></a></b> 
            in accordance with 
            <a href="<?=infr_url("our-policy")?>" style="text-decoration:none" target="_blank">our policy</a> </p>
            
            <p>* please, do not reply any kind of message to this email </p>
        </div>
        
    
    </div>
    <div style="background-color:#CCC; height:30px; line-height:30px;
    padding:10px 20px 10px 20px; display:block">
    	<!-- footer -->
     
        <b style="float:left"> <a href="<?=infr_url("about")?>" style="text-decoration:none" target="_blank"> About </a> | 
        <a href="<?=infr_url("our-policy")?>" style="text-decoration:none" target="_blank"> Privacy Policy </a> </b>
        <span style="float:right"> <?=COPYRIGHT?> </span>
        
        
    </div>
	
</div>