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
	
     <?php include ("header_email_template.php") ?>
    
    <div style="min-height:200px;
    padding:10px 20px 10px 20px;
    ">
    	<!-- body -->
        <?php if(!empty($file_img) && $file_img != "%3c" && $file_img != "<"): ?>
          <br>
          <center>
          <img src="<?=EMAIL_IMG.$file_img?>" style="width:100%; max-width: 256px">
          </center>
          <input type="hidden" name="file_imgnya" value="<?php echo $file_img ?>">
          <br>
          <br>
        <?php endif; ?>
        
        <?php include "introducing-seatizen.php"; ?>
        <br><br>
        <div style="width: 100%">
        <center>
            <a href="<?php echo infr_url('users/register/seaman/') ?>" style="background-color: #337AB7; color: #ffffff; font-size: 14pt; border-radius: 5px;border:0px; width: 35%; padding: 10px 15px 10px 15px">Register Now</a>
        </center>
            
        </div>
        <br>
        <br>
        <center>
        	<?php include "list-template-seatizen.php";?>

        </center>
        
        <div style="clear:both"></div>
        <!-- <br>
        <br>
        <div style="width: 100%">
        <center>
            <a href="<?php //echo infr_url('users/register/seaman/') ?>" style="background-color: #337AB7; color: #ffffff; font-size: 14pt; border-radius: 5px;border:0px; width: 35%; padding: 10px 15px 10px 15px">Register Now</a>
        </center>
            
        </div>
        <br> -->
        <br>
        <?php include ("email_info.php") ?>
        
    
    </div>
    <?php include "footer_email_template.php" ?>
	
</div>