<?php
	//$str_url;
	//$pelaut;
?>
<?php /* <div style="background-color:#E8E8E8">
    <center>
    <table style="width:90%;max-width:600px;margin:20px auto;border-radius:7px;border-spacing:0;border-collapse:collapse" align="center">
        
        <tbody style="border-spacing:0;border-collapse:collapse">
        <tr style="height:23px;overflow:hidden">
            <td style="height:23px;overflow:hidden;background:#2ab8e7;border-radius:6px 6px 0 0;padding:0;margin:0">&nbsp;</td>
        </tr>
        
        
        <tr>
            <td style="width:auto;padding:20px 60px 15px;background:#fff;border-bottom:3px solid #dedede">
                <h1 style="margin:0;font-size:30px;font-family:'Trebuchet MS';line-height:1.1em"><a style="text-decoration:none;color:#2ab8e6" href="<?php echo base_url("home"); ?>" target="_blank">informasea.com</a></h1>
            </td>
        </tr>
        
        <tr>
            <td style="background:#fff;font-size:16px;font-family:'Open Sans',arial,sans-serif;padding:15px 60px;color:#7d7878">
                
                <h3>Company has been registered </h3>
                
                <p>Dear Mr/Mrs <?=$contact_person?></p>
                <p>We are truly sorry for this inconvinience.we couldn't send your activation code because 
                
                this company has beeen registered by <?=$another_contact_person
                </p>

                <p>If you are an agent from this company, please kindly ask the manager to add yourself as an agent from your company dashboard web</p> 
                
                <p>Please kindly contact us if you have any question</p>

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
</div> */ ?>

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
font-size:14px; 
border:1px solid black; ">
	
    <div style="
    background-color:#2ab8e7;
    margin-top:0px;
    height:100px;
    padding:20px 20px 0px 20px;
    display:block;
    " >
    	<!-- header -->
        <div style="clear:both"></div>
        <center>
          <a href="<?=infr_url()?>" style="text-decoration:none;display:block; "> 
          	  <img src="<?=LOGO_INFORMASEA_BIG?>" alt="informasea" style="line-height:100px" 
              title="<?=TITLE." - ".INFORMASEA_SLOGAN?>" >
              <!-- <h1 style="color:#FFF; font-size:48px"><?=TITLE?></h1>--> 
          </a>
          <div style="color:#FFF; display:block;"><?=INFORMASEA_SLOGAN?></div>
        </center>
    </div>
    
    <div style="min-height:200px;
    padding:10px 20px 10px 20px;
    ">
    	<!-- body -->
        <center> <h3>Company has been registered </h3> </center>
		
        <div style="line-height:20px">
        	<p>Dear Mr/Mrs <?=$contact_person?></p>
            <p>We are truly sorry for this inconvinience.we couldn't send your activation code because 
            
            this company has beeen registered by <?=$another_contact_person?>
            </p>

            <p>If you are an agent from this company, please kindly ask the manager to add yourself as an agent from your company dashboard web</p> 
            
            <p>Please kindly contact us if you have any question</p>
        </div>
        
        <!-- info -->
        <div>
        	<div>Best Regard , </div>
            <div><b style="color:#337AB7">Informasea</b> team, </div>
            <b><a href="mailto:<?=$config["smtp_user"]?>" style="text-decoration:none"><?=$config["smtp_user"]?></a></b>
            
            <p>This Email was sent to <b><?=$email_to?></b> from 
            <b><a href="mailto:<?=$config["smtp_user"]?>" style="text-decoration:none"><?=$config["smtp_user"]?></a></b> 
            in accordance with 
            <a href="<?=infr_url("our-policy")?>" style="text-decoration:none">our policy</a> </p>
            
            <p>* please, do not reply any kind of message to this email </p>
        </div>
        
    
    </div>
    <div style="background-color:#CCC; height:30px; line-height:30px;
    padding:10px 20px 10px 20px; display:block">
    	<!-- footer -->
     
        <b style="float:left"> <a href="<?=infr_url("about")?>" style="text-decoration:none"> About </a> | 
        <a href="<?=infr_url("our-policy")?>" style="text-decoration:none"> Privacy Policy </a> </b>
        <span style="float:right"> <?=COPYRIGHT?> </span>
        
        
    </div>
	
</div>