<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	// daftar email untuk mengirim pesan 
	
	// cara menggunakan config email 
	$this->load->config('email') -> dimana email adalah nama file confignya 
	$this->config->item('info') -> dimana info adalah nama array key yang ada 

*/



//rini@informasea.com
/*
  $config['rini']['protocol']  = 'smtp';
  $config['rini']['mailtype']  = 'html';
  $config['rini']['priority']  = '1';
  $config['rini']['wordwrap']  = FALSE;
  $config['rini']['smtp_host'] = 'ssl://mail.adminrmasea.com';
  $config['rini']['smtp_port'] = 465;
  $config['rini']['smtp_user'] = 'rini@informasea.com';
  $config['rini']['smtp_pass'] = 'oD(%gTX-BZ+';
  $config['rini']['charset']   = 'utf-8';
*/

  // $config['rifalqori@informasea.com']['pass'] = "rKDwVXyTUxW8";
  // $config['rini@informasea.com']['pass'] = "oD(%gTX-BZ+";
  // $config['alhusna901@informasea.com']['pass'] = "*AnFO5Rdn_K0";
  // $config['radityapratama@informasea.com']['pass'] = "[oJi_7*[[E{w";


// info@informasea.com
$config['info']['protocol']  = 'smtp';
$config['info']['mailtype']  = 'html';
$config['info']['priority']  = '1';
$config['info']['wordwrap']  = FALSE;
$config['info']['smtp_host'] = 'ssl://mail.informasea.com';
$config['info']['smtp_port'] = 465;
$config['info']['smtp_user'] = 'info@informasea.com';
$config['info']['smtp_pass'] = 'uA8Q_MOh%%Ol';
$config['info']['charset']   = 'utf-8';

// alhusna901@informasea.com
$config['alhusna901']['protocol']  = 'smtp';
$config['alhusna901']['mailtype']  = 'html';
$config['alhusna901']['priority']  = '1';
$config['alhusna901']['wordwrap']  = FALSE;
$config['alhusna901']['smtp_host'] = 'ssl://mail.informasea.com';
$config['alhusna901']['smtp_port'] = 465;
$config['alhusna901']['smtp_user'] = 'alhusna901@informasea.com';
$config['alhusna901']['smtp_pass'] = '*AnFO5Rdn_K0';
$config['alhusna901']['charset']   = 'utf-8';

// vacantsea@informasea.com
$config['vacantsea']['protocol']  = 'smtp';
$config['vacantsea']['mailtype']  = 'html';
$config['vacantsea']['priority']  = '1';
$config['vacantsea']['wordwrap']  = FALSE;
$config['vacantsea']['smtp_host'] = 'ssl://mail.informasea.com';
$config['vacantsea']['smtp_port'] = 465;
$config['vacantsea']['smtp_user'] = 'vacantsea@informasea.com';
$config['vacantsea']['smtp_pass'] = ')34U-]=AytEA';
$config['vacantsea']['charset']   = 'utf-8';

// noreply@informasea.com
$config['noreply']['protocol']  = 'smtp';
$config['noreply']['mailtype']  = 'html';
$config['noreply']['priority']  = '1';
$config['noreply']['wordwrap']  = FALSE;
$config['noreply']['smtp_host'] = 'ssl://mail.informasea.com';
$config['noreply']['smtp_port'] = 465;
$config['noreply']['smtp_user'] = 'noreply@informasea.com';
$config['noreply']['smtp_pass'] = 'iy4k3uxso4gy';
$config['noreply']['charset']   = 'utf-8';