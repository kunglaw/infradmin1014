<?php // new email activation code for agentsea 
// Array ( [id_perusahaan] => 58 [authorized] => on [activation] => ACTIVE [valid_email] => VALID [send_email] => yes ) 
?>
<!-- 
bg-primary : #337AB7
bg-success: #DFF0D8
bg-info   : #D9EDF7
bg-warning : #FCF8E3
bg-danger: #F2DEDE
-->


    <div>
    	<!-- body -->
        <center> <h2 style="font-size:36px; color:#337AB7"> Welcome on Board! You've successfully signed up at <?=WEBSITE?>. </h2> </center>
		
        <center>
        <div>
        	<!-- text -->
        	<div> <h2> Informasea helps you to find your qualified crew from our seatizen database.</h2> </div>
        	<div> No more worries about crew's document expiration since we will help you notified from your dashboard. </div>
        </div>
        </center>
        
        <div>
        	<h3> In this email we inform you that :  </h3>
            <ul>
            	<?php if($authorized == "on"){ ?>
            	<li> <b> Your company is authorized by informasea.com. </b> you can publish your vacantsea post now</li>
                <?php } if($activation == "ACTIVE") {   ?>
                <li> <b> Your Account is Active. </b> you can setting an Account of your company and posting a vacantsea </li>
                <?php } if($valid_email == "VALID"){ ?>
            	<li> <b> Your Email is Valid. </b> We have to know your email to inform an applicant that already apply your vacantsea </li>
                <?php } ?>
                
            </ul>
        </div>

        <center>
         
          <a href="<?=$str_url?>" style="background-color:#f5774e;color:#ffffff;display:inline-block;font-family:'Source Sans Pro', Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;">
              <!-- button --> 
              Login
          </a>
          
        </center>
        
        <?php  include "email_info.php"; ?>
        
    
    </div>
   