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
        
        <?=""//$content?>
        <?php if(!empty($file_img) && $file_img != "%3c" && $file_img != "<"): ?>
          <br>
          <center>
          <img src="<?=EMAIL_IMG.$file_img?>" style="width:100%; max-width: 256px">
          </center>
          <input type="hidden" name="file_imgnya" value="<?php echo $file_img ?>">
          <br>
          <br>
        <?php endif; ?>
        <?php include "introducing-agentsea.php"; ?>
        
        <center>
          <div style="
              background-color:#FF9900;
              width:350px;
              height:50px;
              
              margin-top:40px;
              margin-bottom:50px;
              display:inline-block;
              line-height:10px;
             
          ">
          
          <a href="<?=$str_url?>" style="text-decoration:none; text-align:center; " target="_blank">
              <!-- button --> 
              <h2 style="color:#FFF;">Demo</h2>
          </a>
          </div>
          
        </center>
       
        
        <?php include ("email_info.php") ?>
        
    
    </div>
    
    <?php include "footer_email_template.php" ?>
	
</div>