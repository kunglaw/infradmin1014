<?php include "config.php"; ?>

<div  style="padding: 0;margin: 0;display: block;background: #eeebeb;-webkit-text-size-adjust: none;-webkit-font-smoothing: antialiased;width: 100%;height: 100%;color: #6f6f6f;font-weight: 400;font-size: 18px;" bgcolor="#eeebeb">  

  <table align="center" cellpadding="0" cellspacing="0" width="100%" height="100%" style="border-collapse: collapse !important;">
    <tr>
      <td align="center" valign="top" style="background-color: #eeebeb;font-family: Arial, sans-serif;border-collapse: collapse;" width="100%">

      <center>

        <table cellspacing="0" cellpadding="0" width="600" class="w320" style="border-collapse: collapse !important;">
          <tr>
            <td align="center" valign="top" style="font-family: Arial, sans-serif;border-collapse: collapse;">

			<!-- table logo -->
            <?php include "header.php"; ?>
            
			<!-- header flat -->
            <?php include "header_flat.php"; ?>

            </td>
          </tr>
        </table>

        <table cellspacing="0" cellpadding="0" class="force-full-width" bgcolor="#ffffff" style="border-collapse: collapse !important;width: 100% !important;">
          <tr>
            <td style="background-color: #ffffff;font-family: Arial, sans-serif;border-collapse: collapse;">
            <br>
            
            <?php include "template.php"; //$this->load->view($include_url."/template.php"); ?>
                            
            <!-- footer -->
            <?php include "footer.php"; //$this->load->view($include_url."/footer.php"); ?>
            </td>
          </tr>
        </table>

      </center>

      </td>
    </tr>
  </table>

</div>