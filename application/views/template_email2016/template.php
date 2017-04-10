<?php // ALL TEMPLATE 
//$content_template = $this->load->view("asd/asdas",$aa,true);
//$content_template = "<p> isi email </p>"; // ini yang bener
//$content_template = "asdasd/asdasd/sdasd";
?>

  
  <table style="margin: 0 auto;border-collapse: collapse !important;width: 80% !important;" cellspacing="0" cellpadding="0" class="force-width-100">
    <tr>
       <?php // contentnya harus ada disini ?>
       <div style="margin:20px 0;">
       
        <?php //$this->load->view($content_template); //include "$content" 
		
		//include $content_template;
		
		echo $content_template;
		?>
    
        <!-- <hr>
        <small style="font-size:10px">
        <div> Have fun on board. </div>
        <div> Informasea team, </div>
        
        <div> This Email was sent to alhusna901@gmail.com from in accordance with our policy </div>
        
        <div> * please, do not reply any kind of message to this email </div>
        </small> -->
         
       </div> 
       <!-- END CONTENT -->
    </tr>
  </table>
  

  

<?php // end ALL TEMPLATE ?>