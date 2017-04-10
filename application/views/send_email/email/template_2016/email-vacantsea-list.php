<?php // new email activation code for agentsea ?>
<!-- 
bg-primary : #337AB7
bg-success: #DFF0D8
bg-info   : #D9EDF7
bg-warning : #FCF8E3
bg-danger: #F2DEDE
-->


    
    <div >
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
        
        <center>
        	<?php include "list-template-vacantsea.php";?>
        </center>
      
        
    
    </div>
   