<?php // new email activation code for agentsea ?>

    
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
        
        <?php 
			
			if($user_type == "seatizen")
			{
				include "introducing-seatizen.php"; 
			}
			else
			{
				include "introducing-agentsea.php";
			}
			
		?>
            
        <br>
        <div style="width: 100%">
        <center>
            
            
        <a href="<?php echo infr_url('users/register') ?>" style="background-color:#f5774e;color:#ffffff;display:inline-block;font-family:'Source Sans Pro', Helvetica, Arial, sans-serif;font-size:18px;font-weight:400;line-height:45px;text-align:center;text-decoration:none;width:200px;-webkit-text-size-adjust:none;"> 
         Register </a>
        </center>
            
        </div>
        <br>
       
        <center>
        	<?php include "list-template-seatizen.php";?>

        </center>
        
        <div style="clear:both"></div>
       
        
    
    </div>
   
