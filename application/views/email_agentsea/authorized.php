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
        <center> <h2 style="font-size:36px; color:#337AB7"> Welcome on Board! You've successfully signed up at <?=WEBSITE?>. </h2> </center>
		
        <center>
        <div style="line-height:20px">
        	<!-- text -->
        	<div> <h2> Informasea helps you to find your qualified crew from our seatizen database.</h2> </div>
        	<div> No more worries about crew's document expiration since we will help you notified from your dashboard. </div>
        </div>
        </center>
        
        
        <center>
          <div style="
              background-color:#337AB7;
              width:250px;
              height:50px;
              line-height:50px; 
              margin-top:50px;
              margin-bottom:50px;
          ">
          <a href="<?=$str_url?>" style="text-decoration:none; text-align:center;">
              <!-- button --> 
              <h2 style="color:#FFF; vertical-align:middle">Activate Account</h2>    
          </a>
          </div>
        </center>
        
        
        <?php  include "email_info.php"; ?>
        
    
    </div>
   <?php include "footer_email_template.php"; ?>
	
</div>