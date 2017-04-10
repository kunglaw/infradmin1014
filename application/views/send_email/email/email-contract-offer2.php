<?php //email-agentsea-list ?>
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
	
    <?php include ("header_email_template.php") ?>
    
    <div style="min-height:200px;
    padding:10px 20px 10px 20px;
    ">
    	<!-- body -->
        <!-- <center> 
        	<h2 style="font-size:36px; color:#337AB7"> Hello Seatizen !</h2>
        	<h4 style="font-size:24px; color:#337AB7; margin-top:-30px;"> Find your preferable vacantsea and networking with seafarers or agentsea. </h4> 
        </center> -->
        
        <br>
        <br>
        <br>
        <div style="line-height:20px; font-size:16px;"> 
        	<!-- <p><b style="font-size:18px; color:#337AB7;" > Yth <?=$name?> </b></p>
            <br>
            <p> di Tempat </p>
            <br>-->
            <p>Yang bertanda tangan di bawah ini</p> 
            <br>
            <table style="margin-left: 30px;">
                <tr>
                    <td width="200">Nama Perusahaan</td>
                    <td width="20">:</td>
                    <td><?php echo $company_name ?></td>
                </tr>
                <tr>
                    <td>Alamat Perusahaan</td>
                    <td>:</td>
                    <td><?php echo $company_address ?></td>
                </tr>
                <tr>
                    <td>Telepon Perusahaan</td>
                    <td>:</td>
                    <td><?php echo $company_telp ?></td>
                </tr>
                <tr>
                    <td>Penanggung Jawab</td>
                    <td>:</td>
                    <td><?php echo $name ?></td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td><?php echo $title_pic ?></td>
                </tr>
            </table>
            <br>
            <p>Selanjutnya akan disebut sebagai <b>PIHAK PERTAMA</b></p>
            <br>
            <table style="margin-left: 30px;">
                <tr>
                    <td width="200">Nama Perusahaan</td>
                    <td width="20">:</td>
                    <td>Informasea.com</td>
                </tr>
                <tr>
                    <td>Alamat Perusahaan</td>
                    <td>:</td>
                    <td>Jl. Pinang Raya no xxx</td>
                </tr>
                <tr>
                    <td>Telepon Perusahaan</td>
                    <td>:</td>
                    <td>08945223658</td>
                </tr>
                <tr>
                    <td>Penanggung Jawab</td>
                    <td>:</td>
                    <td>Rifal Qori Kurniawan</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>Founder</td>
                </tr>
            </table>
            <br>
            <p>Selanjutnya akan disebut sebagai <b>PIHAK KEDUA</b></p>
            <br>

            <p>Untuk selanjutnya antara <b>PIHAK PERTAMA</b> dan <b>PIHAK KEDUA</b> memiliki perjanjian kerjasama dengan ketentuan sebagai berikut:</p>
            <br>
            <ol>
                <li>informasea.com membantu <?php echo $company_name ?> dengan cara mem-posting lowongan di informasea.com atas nama <?php echo $company_name ?>.</li>
                <li>Lowongan yang di-posting di informasea.com hanya lowongan yang telah <?php echo $company_name ?> buat di gotoseajobs ataupun job portal crewing lainnya.</li>
                <li>informasea.com akan melakukan marketing untuk lowongan tersebut melalui social media yang ada (facebook, twitter, linkedin, g+)</li>
                <li><?php echo $company_name ?> dapat memantau applicant yang telah melamar lowongan tersebut dengan mengakses informasea.com ataupun melalui email.</li>
                <li><?php echo $company_name ?> dapat langsung melihat CV dan resume pelamar melalui informasea.com dan dapat dengan mudah melakukan validasi sertifikat.</li>
                <li>Penawaran ini tidak dipungut biaya demi meningkatkan kebermanfaatan informasea.com sebagai komunitas pelaut dan job portal</li>
            </ol>
            <!-- <p> <b><a href="<?=infr_url()?>"> Informasea </a> </b> helps you :  </p> -->
            <br>
            <br>
            <p>Kami yakin dapat memberikan <?php echo $company_name ?> lebih banyak pilihan dalam proses hiring crew sehingga <?php echo $company_name ?> memiliki peluang yang lebih besar untuk menemukan crew yang kompeten.</p>
            <br>
            <p>Demikian perjajian kerjasama ini kami buat untuk menjadi ikatan diantara kami. Segala hal yang belum termuat pada perjajian ini, dibicarakan bersama antara pihak pertama dan pihak kedua untuk mencapai mufakat dikemudian hari dan otomatis menjadi addendum pada perjanjian ini.</p>
            <br>
            <p>Perjanjian ini kami buat secara penuh kesadaran dan tanpa paksaan dari manapun. Jika terjadi perselisihan pada pelaksanaan perjanjian ini, maka kami sepakat menyelesaikannya dengan cara kekeluargaan dan musyawarah, namun jika tidak terselesaikan juga, kami sepakat menyelesaikan secara hukum yang berlaku.</p>
            <br>
            <br>
            <br>
            <span style="text-align:right">
                <p>Salam Sukses</p>
                <br>
                <br>
                <br>
                <br>
                <p>Rifal Qori Kurniawan</p>
                <p>Founder Informasea.com</p>
            </span>
            <!-- <ul style="line-height:20px; list-style-type:lower-alpha; ">
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
                
            </ul> -->
        
        </div>
        <br>
        <br>
        <br>
        <center>
        <?php if(isset($id_contract)) $tambahan = "$id_contract/$token"; else $tambahan = ""; ?>
        <a href="<?php echo INFR_URL."contract/negotiate/$tambahan" ?>" style="font-size: 13pt; color: #ffffff; width: 50%; background-color: #3399ff; padding: 15px 40px 15px 40px; text-decoration : none">Negotiable</a>
        <a href="<?php echo INFR_URL."contract/agree/$tambahan" ?>" style="font-size: 13pt; color: #000000; width: 50%; background-color: #66ff66; padding: 15px 40px 15px 40px; text-decoration : none">Agree and Print</a>
        </center>
        <br>
        <br>
        <br>
        <!-- <center>
        	<?php //include "list-template-agentsea.php";?>
        </center> -->
        
        <?php include ("email_info.php") ?>
        
    
    </div>
    <?php include "footer_email_template.php" ?>
	
</div>