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
    	<!-- body -->
        
        <?php include "introducing-agentsea.php" ?>
        
        <center>
          <div style="
              background-color:#FF9900;
              width:350px;
              height:50px;
              line-height:50px; 
              margin-top:50px;
              margin-bottom:50px;
          ">
          
          <a href="<?=$str_url?>" style="text-decoration:none; text-align:center;">
              <!-- button --> 
              <h2 style="color:#FFF; vertical-align:middle"><i style='font-size:14px'> Post Vacantsea and Get Qualified Crew for Free </i></h2>    
          </a>
          </div>
        </center>
       
        
        <?php  include "email_info.php"; ?>
        
    
    </div>
   <?php include "footer_email_template.php"; ?>
	
</div>