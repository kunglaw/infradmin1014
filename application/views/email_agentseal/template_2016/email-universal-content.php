    
    <div style="">
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
        
        <div style="line-height:20px; font-size:16px;"> 
        	<?php echo $content // content, tulis sendiri ?>
        </div>
        
        
        <center>
          <?php if($is_first_button == true){  ?>
          <a href="<?=$str_url?>" style="background-color:#f5774e;color:#ffffff;display:inline-block;font-family:'Source Sans Pro', Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;padding:0 20px;-webkit-text-size-adjust:none;"> 
         <?=$first_title_btn?> </a>
          
          <?php } ?>
          
          <?php if($is_second_button == true){  ?>
          
          <a href="<?=$second_str_url?>" style="background-color:#f5774e;color:#ffffff;display:inline-block;font-family:'Source Sans Pro', Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;padding:0 20px;-webkit-text-size-adjust:none;"> 
        <?=$second_title_btn?> </a>
          
          <?php } ?>
          
        </center>
        <br>
        
        <center>   	
            <?php echo $list_template // list data seatizen , vacantsea , agentsea  ?>
        </center>
        
        <div style="clear:both"></div>

    </div>
  