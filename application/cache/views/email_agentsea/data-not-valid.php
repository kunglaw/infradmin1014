<?php
	//$str_url;
	//$pelaut;
	
	//$message_text = array("phone not valid","unauthorize person");
	
?>
  <div style="background-color:#E8E8E8">
      <center>
      <table style="width:90%;max-width:600px;margin:20px auto;border-radius:7px;border-spacing:0;border-collapse:collapse" align="center">
          
          <tbody style="border-spacing:0;border-collapse:collapse">
          <tr style="height:23px;overflow:hidden">
              <td style="height:23px;overflow:hidden;background:#2ab8e7;border-radius:6px 6px 0 0;padding:0;margin:0">&nbsp;</td>
          </tr>
          
          
          <tr>
              <td style="width:auto;padding:20px 60px 15px;background:#fff;border-bottom:3px solid #dedede">
                  <h1 style="margin:0;font-size:30px;font-family:'Trebuchet MS';line-height:1.1em"><a style="text-decoration:none;color:#2ab8e6" href="<?php echo "informasea.com"; ?>" target="_blank">informasea.com</a></h1>
              </td>
          </tr>
          
          <tr>
              <td style="background:#fff;font-size:16px;font-family:'Open Sans',arial,sans-serif;padding:15px 60px;color:#7d7878">
              	  
                  <h3><?=$title_text?></h3>
                  
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
                  
                  <?php /* the phone number is not valid. please send us the valid phone number to continue verification process by reply this message</p>*/ ?>
                  
                  </p>
  
                  <?php /* <p>If you are an agent from this company, please kindly ask the manager to add yourself as an agent from your company dashboard web</p>*/ ?>
                  
  
                  <p>Best Regards,<br> 
                  Informasea team</p>
                  
              </td>
          </tr>
          
          <tr>
          
              <td style="background:#bdbdbd;padding:10px 60px;font-size:12px;font-family:'Open Sans',arial,sans-serif;color:#000;border-radius:0 0 6px 6px">
                  © 2015 informasea, All rights reserved.  | <a style="color:#000;text-decoration:none" href="mailto:info@informasea.com" target="_blank">info.informasea.com</a>
              </td>
              
          </tr>
          </tbody>
          
      </table>
      </center>
      <div class="yj6qo"></div><div class="adL"></div>
  </div>