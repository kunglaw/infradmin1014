<?php
	//$str_url;
	//$pelaut;
	
	//$message_text = array("phone not valid","unauthorize person");
	
?>
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
	
    <?php include "header_email_template.php"; ?>
    
    <div style="min-height:200px;
    padding:10px 20px 10px 20px;
    ">
    	<!-- body -->
        <center><h3><?=$title_text?></h3></center>
		
        <p>Dear Mr/Mrs <?=$contact_person?></p>
        <p>We are truly sorry for this inconvinience.we couldn't send your activation code because : </p>
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
   <?php include "footer_email_template.php"; ?>
	
</div>