<?php //email-agentsea-list ?>
    
    <div>
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
        	<p><b style="font-size:18px; color:#337AB7;" > Dear Mr/s <?=$name?> , </b></p>
            <p> Introducing our service to help you finding preferable vacantsea and networking with 
            seafarers or agentsea.  </p>
            <p> <b><a href="<?=infr_url()?>"> Informasea </a> </b> helps you :  </p>
            
            <ul style="line-height:20px; list-style-type:lower-alpha; ">
            	<li> 
                	<div><b style="color:#337AB7; font-size:18px;"> Find preferable job </b> </div> 
                    
                    <div> Apply any vacantsea based on your qualification. </div>
                    <div> After apply, you can monitor your status, got accepted or rejected. </div> 
                    <div>&nbsp;</div>
                </li>
                <li> 
                	<div><b style="color:#337AB7; font-size:18px;"> Impressive Resume </b></div> 
                    
                    <div> Keep your resume up to date! </div>
                    <div> Agentsea will be able to view your complete resume after applying the vacantsea. </div> 
                    <div> upload all your scan certified and apprisal / performance report. </div>
                    <div> only agentsea with applied vacantsea can view your complete resume. </div>
                    <div>&nbsp;</div>
                </li>
                <li> 
                	<div><b style="color:#337AB7; font-size:18px;"> Networking with other seatizen or agentsea  </b></div> 
                    
                    <div> chat and get connected with all your colleague. </div>
                    <div> Agentsea will be able to view your complete resume after applying the vacantsea. </div> 
                    <div> Chat with any preferable agentsea. </div>
                   
                    <div>&nbsp;</div>
                </li>
                
            </ul>
        
        </div>
        
        <center>
        	<?php include "list-template-agentsea.php";?>
        </center>
        
      
        
    
    </div>
