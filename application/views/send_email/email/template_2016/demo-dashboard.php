<?php // new email activation code for agentsea ?>
    
    <div>
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
          
          
          <a href="<?=$str_url?>" style="background-color:#f5774e;color:#ffffff;display:inline-block;font-family:'Source Sans Pro', Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;padding:0 20px;-webkit-text-size-adjust:none;"> 
         Demo </a>
          
        </center>
    
    </div>
 