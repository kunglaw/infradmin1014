<?php include "config.php"; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Informasea new Email template </title>
    <!-- Designed by https://github.com/kaytcat -->
    <!-- Header image designed by Freepik.com -->
    
  </head>
  <body offset="0" class="body" style="padding: 0;margin: 0;display: block;background: #eeebeb;-webkit-text-size-adjust: none;-webkit-font-smoothing: antialiased;width: 100%;height: 100%;color: #6f6f6f;font-weight: 400;font-size: 18px;" bgcolor="#eeebeb">
  
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
                <?php include "header_flat.php" ?>
    
                </td>
              </tr>
            </table>

         <table cellspacing="0" cellpadding="0" class="force-full-width" bgcolor="#ffffff" style="border-collapse: collapse !important;width: 100% !important;">
              <tr>
                <td style="background-color: #ffffff;font-family: Arial, sans-serif;border-collapse: collapse;">
                <br>
				
                <?php include "template.php" ?>
                                
				<!-- footer -->
                <?php include "footer.php" ?>
                </td>
              </tr>
            </table>
      </center>

      </td>
    </tr>
  </table>
 </body>
</html>
