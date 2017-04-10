
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
	
    <?php include "header_email_template.php"; ?>
    
    <div style="min-height:200px;
    padding:10px 20px 10px 20px;
    ">
    	<!-- body -->
        <?php /* <center> 
        	<?php $title_content // title content ?>
        </center> */ ?>
		    <?php if(!empty($file_img) && $file_img != "%3c" && $file_img != "<"): ?>
          <br>
          <center>
          <img src="<?=EMAIL_IMG.$file_img?>" style="width:100%; max-width: 256px">
          </center>
          <input type="hidden" name="file_imgnya" value="<?php echo $file_img ?>">
          <br>
          <br>
        <?php endif; ?>
        <div style="line-height:20px">
        	<?php echo $content // content ?>
        </div>
        
        <div style="clear:both"></div>
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
          
          <a href="<?=$str_url?>" style="text-decoration:none; text-align:center;" target="_blank">
              <!-- button --> 
              <h2 style="color:#FFF; vertical-align:middle"><?=$title_btn?></h2>    
          </a>
          
          </div>
          
          <?php if($is_reg == TRUE){ ?> 
          <div style="
              background-color:#FF9900;
              width:350px;
              height:50px;
             
              margin-top:40px;
              margin-bottom:50px;
              
              display:inline-block;
              line-height:10px;
             
          ">
          
          <a href="<?=$str_reg?>" style="text-decoration:none; text-align:center;" target="_blank">
              <!-- button --> 
              <h2 style="color:#FFF; vertical-align:middle"><?=$title_btn_reg?></h2>    
          </a>
          </div>
          <?php } ?>
			<div style="clear:both"></div>
        </center> 
        
        <div style="clear:both"></div>
        
        <?php  include "email_info.php"; ?>
        
    
    </div>
   <?php include "footer_email_template.php"; ?>
	
</div>