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
	
    <div style="
    background-color:#2ab8e7; 
    height:100px;
    margin-top:0px;
    padding:20px 20px 0px 20px;
    display:block;
    " >
    	<!-- header -->
        <div style="clear:both"></div>
        <center>
          <a href="<?=infr_url()?>" style="text-decoration:none;display:block; "> 
          	  <img src="<?=LOGO_INFORMASEA_WHITE?>" alt="informasea" style="line-height:100px" 
              title="<?=TITLE." - ".INFORMASEA_SLOGAN?>" >
              <!-- <h1 style="color:#FFF; font-size:48px"><?=TITLE?></h1>--> 
          </a>
          
        </center>
    </div>
    
    <div style="min-height:200px;
    padding:10px 20px 10px 20px;
    ">
    	<!-- body -->
        <?php /* <center> <h2 style="font-size:36px; color:#337AB7"> Welcome on board !</h2> </center> */ ?>
        
        <center> 
        	<h2 style="font-size:36px; color:#337AB7"> Hello Seatizen !</h2>
        	<h4 style="font-size:24px; color:#337AB7; margin-top:-30px;"> Find your preferable vacantsea and networking with seafarers or agentsea. </h4> 
        </center>
        
        <?php /* <div style="line-height:20px">
        	<!-- text -->
        	<div> <h2> Informasea helps you to find your preferable vacantsea based on your qualification and expectation .</h2> 
            
            <ul style="line-height:20px; font-weight:bold">
            	<li> build your network from our seafarers and company database </li>
                <li> complete your resume to make yourself noticeable by agentsea </li>
                <li> aplly any preferable vacantsea </li>
                <li> promote yourself to impress agentsea </li>
            </ul>
            
            </div>
        	
        </div> */ ?>
        
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
        
        <div style="font-size:24px; margin-left:auto; margin-right:auto; width:30%;">
           <?php /*  <p> You can login <!-- by <b>facebook</b> or --> by our <b>login form </b> after you Activate your account by clicking Activate Account button in the future using : </p> */ ?>
        	<div>
            	<ul style="line-height:30px; font-weight:bold; list-style-type:none">
                	<li> Username: <?=$username?></li>
                	<li> Password: <?=$password?></li>
                </ul>
            </div>
           
            <?php /* <p>To edit username or password, go to your <a href="<?=infr_url("profile/$username/account")?>">account page</a></p>
            <p> Didn't sign up at Informasea ? <a href="<?php echo infr_url("users/users_process/cancel_account/?username=$username")?>">click here to cancel this account</a> </p> */ ?>
        </div>
        
        <?php /* <div style="text-align:center"> you should changed the password Immediately </div> */ ?>
        
        <center> 
        
        <div> <h4> Clicking this button and ready to get hired or networking!! </h4> </div>
               
        <a href="<?=$str_url?>" style="text-decoration:none">
          <div style="
              background-color:#FF6600;
              width:250px;
              height:50px;
              line-height:50px; 
              margin-top:10px;
              margin-bottom:50px;
          ">
              <!-- button --> 
              <h2 style="color:#FFF; vertical-align:middle">Activate Account</h2>    
          
          </div>
        </a>
        </center>
        
        <center>
        	<div style="font-size:16px; margin-right:auto; margin-right:auto; width:80%; display:inline">
            	<p> <b style="font-size:18px; color:#337AB7;" > Other seatizen you may know </b> </p>
               
                  
                  <?php foreach($dt_seatizen as $row){ 
				  
				  	$dt = $this->seatizen_model->get_detailseatizen_a($row['pelaut_id']);
				  ?>
                  <a href="<?=infr_url("profile/$row[username]")?>" style="text-decoration:none" target="_blank">
                  <div style="border:1px solid #000; float:left; display:inline-block; height:190px; width:28%; padding:20px; margin-left:1%; margin-bottom:20px"> 
                  
                  	<img style=" height:80px; width:80px; margin-bottom:30px; margin-right:20px; border:1px solid #999" 
                    src="<?=check_profile_seaman($row['username'])?>">
                    <div style=" text-align:left">
                    	<div> <b> 
							<?=$row['nama_depan']?> <?=$row['nama_belakang']?> </b> </div>
                        <div><?=flag_nationality($row['kebangsaan'])?> </div>
                        <div> <?=format_rank($dt['rank'])?> </div>
                    </div>
                    <span style="clear:both"></span>
                 
                  </div>
                   </a>
                  <?php } ?>
                  
                  <span style="clear:both"></span>
            
            </div>
        </center>
        
        <div style="clear:both"></div>
        
        <!-- info -->
        <div>
        	<div>Have fun on board.</div>
            <div><b style="color:#337AB7">Informasea</b> team, </div>
            <b><a href="mailto:<?=$config["smtp_user"]?>" style="text-decoration:none"><?=$config["smtp_user"]?></a></b>
            
            <p>This Email was sent to <b><?=$email_to?></b> from 
            <b><a href="mailto:<?=$config["smtp_user"]?>" style="text-decoration:none"><?=$config["smtp_user"]?></a></b> 
            in accordance with 
            <a href="<?=infr_url("our_policy")?>" style="text-decoration:none">our policy</a> </p>
            
            <p>* please, do not reply any kind of message to this email </p>
        </div>
        
    
    </div>
    <div style="background-color:#CCC; height:30px; line-height:30px;
    padding:10px 20px 10px 20px; display:block">
    	<!-- footer -->
     
        <b style="float:left"> <a href="<?=infr_url("about")?>" style="text-decoration:none"> About </a> | <a href="<?=infr_url("our-policy")?>" style="text-decoration:none"> Privacy Policy </a> </b>
        <span style="float:right"> copyright @ 2014 - <?=WEBSITE?> . All right reserved </span>
        
        
    </div>
	
</div>