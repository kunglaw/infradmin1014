<?php
	//$str_url;
	//$pelaut;
	
	//$message_text = array("phone not valid","unauthorize person");
	
?>
<?php // new email activation code for agentsea ?>
    
    <div>
    	<!-- body -->
        <center><h3><?=$title_text?></h3></center>
		
        <p>Dear Mr/Mrs <?=$contact_person?></p>
        <p>We are truly sorry for this inconvinience we couldn't send your activation code because : </p>
        <ul>
          <?php
          
          for($i = 0; $i <= count($message_text)-1; $i++)
          {
          ?>
          <li>
              <?=$message_text[$i]?>
          </li>
          <?php
          }
          ?>
          
        </ul>
        
       <?php  include "email_info.php"; ?>
        
    
    </div>
  