<?php

if(!function_exists("test_excel_field"))
{
	function test_excel_field($column,$value)
	{

		$CI =& get_instance();
				
		$broken_cell = FALSE;
		$broken_log  = ""; // alasan kenapa broken cell
		$last		= FALSE;
		
		switch($column)
		{
			case "A":
			  
			  if(!empty($value)){
			  
				$field["nama"]   = $value; // untuk pembacaan keys
				$new 	 		 = $value; // untuk nilainya 
				
			  }
			  else
			  {
				$broken_cell 	 = TRUE;
				$broken_log	  = "name must filled";  
			  }
				
			break;
			
			case "B":
				
				$field["alamat"] = $value;
				$new 	 		 = $value;
				
				
			break;
			
			case "C":
			  
			  if(!empty($value))
			  {
				$field["email"]  = $value;
				$new 	 		 = $value;
				
				$last			= TRUE; // menyatakan kalau ini akhir dari array
			  }
			  else
			  {
				$broken_cell	 = TRUE;
				$broken_log	  = "email must filled"; 
			  }
				
			break;
			
			default:
			break;
		}
		
		$key = array_keys($field);// harus dicari tau dahulu keysnya apa 
		
		return array('new'=>$new,"key"=>$key[0],"last"=>$last,"broken_cell"=>$broken_cell,"broken_log"=>$broken_log);
		
	}
}

if(!function_exists("insert_batch_test"))
{
  function insert_batch_test($data_list)
  {
	  
	  $CI =& get_instance();
	  
	  $CI->db2 = $CI->load->database(DB2_GROUP,true);
	  
	  foreach($data_list as $row) 
	  {
	  	$str  = "INSERT INTO test SET 	     ";
	  	$str .= "nama	= '$row[nama]'		,";
	  	$str .= "alamat	= '$row[alamat]'	,";
	  	$str .= "email	= '$row[email]'	     ";
	  
	  	$insert_batch = $CI->db2->query($str);
	  }
	  
	  return $insert_batch;
  }
}


if(!function_exists("seatizen_excel_field"))
{
	function seatizen_excel_field($column,$value)
	{
		$CI =& get_instance();
		
		// A - Q
		$CI->load->model("Seatizen_model");
		
		$broken_cell = FALSE;
		$broken_log  = "";
		$last		= FALSE;
		
		switch($column)
		{
			case "A":	// nama_depan
				
			  if (empty($value)) {
				  
				  $broken_cell     = true;
				  $broken_log	  = "firstname must filled";
				  
			  } else {
				  
				  $field["nama_depan"] = $value;
				  $new_seatizen 		= $value;
				  
			  }
					
			break;
			
			case "B": // nama_belakang
				
			  if (empty($value)) {
				  
				  $broken_cell     = true;
				  $broken_log 	  = "lastname must filled";
				  
			  } else {
				  
				  $field["nama_belakang"] = $value;
				  $new_seatizen		   = $value;
			  }
			
			break;
			
			case "C": // kebangsaan
			  
			  if(!empty($value))
			  {
			  	//cek nama negara benar atau id di database
			  	$field['kebangsaan']		= $value;
			  	$new_seatizen			   = $value;
			  }
			  else
			  {
				$field['kebangsaan']		= "";
			  	$new_seatizen			   = "";
			  	
			  }
			  
			break;
			
			case "D": // agama
			  
			  if(!empty($value))
			  {
			  	//cek nama negara benar atau id di database
			  	$field['agama']		= $value;
			  	$new_seatizen			   = $value;
			  }
			  else
			  {
				$field['agama']		= "";
			  	$new_seatizen			   = "";
			  	
			  }	
				
			break;
			
			case "E": // gender
			
			  if (empty($value)) {
				  
				  $broken_cell     = true;
				  $broken_log 	  = "gender must be filled";
				  
			  } else {
				  
				  $field["gender"]        = $value;
				  $new_seatizen		   = $value;
			  }
			
			break;
			
			case "F": // tempat_lahir
			
			  if(!empty($value))
			  {
			  	
			  	$field['tempat_lahir'] = $value;
			  	$new_seatizen	      = $value;
			  }
			  else
			  {
				$field['tempat_lahir'] = "";
			  	$new_seatizen		  = "";
			  	
			  }

			
			break;
			
			case "G": // tanggal_lahir
			  
			  if(!empty($value))
			  {
			  	//cek apakah ini datanya berbentuk tanggal ? 
			  	$field['tanggal_lahir']	 = $value;
			  	$new_seatizen			   = $value;
			  }
			  else
			  {
				$field['tanggal_lahir']	 = "";
			  	$new_seatizen			   = "";
			  	
			  }

			  
			break;
			
			case "H": // alamat
			
			  if(!empty($value))
			  {
			  	//cek nama negara benar atau id di database
			  	$field['alamat']	 		= $value;
			  	$new_seatizen			   = $value;
			  }
			  else
			  {
				$field['alamat']	 		= "";
			  	$new_seatizen			   = "";
			  	
			  }
	
			break;
			
			case "I": // telepon
			
			  if(!empty($value))
			  {
			  	//cek apakah ini angka 
			  	$field['telepon']	 	   = $value;
			  	$new_seatizen			   = $value;
			  }
			  else
			  {
				$field['telepon']	 	   = "";
			  	$new_seatizen			   = "";
			  	
			  }

			break;
			
			case "J": // handphone
			  if(!empty($value))
			  {
			  	//cek apakah ini angka 
			  	$field['handphone']	 	 = $value;
			  	$new_seatizen			   = $value;
			  }
			  else
			  {
				$field['tanggal_lahir']	 = "";
			  	$new_seatizen			   = "";
			  	
			  }

			break;
			
			case "L": // fax
			
			  if(!empty($value))
			  {
			  	//cek apakah ini angka 
			  	$field['fax']	 	 = $value;
			  	$new_seatizen		 = $value;
			  }
			  else
			  {
				$field['fax']	 	 = "";
			  	$new_seatizen		 = "";
			  	
			  }

			
			break;
			
			case "K": // email
 			  													// email
			  $check_email = $CI->seatizen_model->check_email($value);
			  $check_valid_email = filter_var($value, FILTER_VALIDATE_EMAIL);
			  // harus dicek, tidak boleh ada email yang sama 
			  // cek apakah ini email
			  // disini username di generate
			  if (empty($value) && !empty($check_email) || !$check_valid_email) {
					  
				  $broken_cell     = true;
				  $broken_log 	  = true;
					  
			  } else {
				  
				  // dicek disini , email tidak boleh ada yang sama dari database
				  $field["email"]  = $value; 
				  $new_seatizen    = $value;
				  
				  $ex = explode("@",$new_seatizen);
				  $field["username"] = $ex[0];
				  
				  
			  }

			
			break;
			
			case "M": // status_perkawinan 
			
			  if(!empty($value))
			  {
			  	//cek apakah ini angka 
			  	$field['status_perkawinan'] = $value;
			  	$new_seatizen			   = $value;
			  }
			  else
			  {
				$field['status_perkawinan'] = "";
			  	$new_seatizen			   = "";
			  	
			  }
			
			break;
			
			case "N": // keluarga terdekat
			
			  if(!empty($value))
			  {
			  	//cek apakah ini angka 
			  	$field['keluarga_terdekat'] = $value;
			  	$new_seatizen			   = $value;
			  }
			  else
			  {
				$field['keluarga_terdekat'] = "";
			  	$new_seatizen			   = "";
			  	
			  }
			
			break;
			
			case "O": // hubungan
			
			  if(!empty($value))
			  {
			  	//cek apakah ini angka 
			  	$field['hubungan'] 		  = $value;
			  	$new_seatizen			   = $value;
			  }
			  else
			  {
				$field['hubungan'] 		  = "";
			  	$new_seatizen			   = "";
			  	
			  } 
			
			break;
			
			case "P": // alamat_keluarga_terdekat
			
			  if(!empty($value))
			  {
			  	//cek apakah ini angka 
			  	$field['alamat_keluarga_terdekat'] = $value;
			  	$new_seatizen			  	      = $value;
			  }
			  else
			  {
				$field['alamat_keluarga_terdekat'] = "";
			  	$new_seatizen			   		  = "";
			  	
			  } 
			
			break;
			
			case "Q": // city 
			
			  if(!empty($value))
			  {
			  	//cek apakah ini angka 
			  	$field['city'] 		  = $value;
			  	$new_seatizen		   = $value;
			  }
			  else
			  {
				$field['city'] 		  = "";
			  	$new_seatizen		   = "";
			  	
			  } 
			   
			  $last = TRUE; // ini field terakhir 
			
			break;
			
			default:
			break;
			
		}
		
		
		$key = array_keys($field);// harus dicari tau dahulu keysnya apa 
		
		return array('new'=>$new_seatizen,"key"=>$key[0],"last"=>$last,"broken_cell"=>$broken_cell,"broken_log"=>$broken_log);
		
	}	
}

if(!function_exists("insert_batch_seatizen"))
{
	function insert_batch_seatizen($data_list)
	{
		$CI =& get_instance();
		
		$CI->db2 = $CI->load->database(DB2_GROUP,true);
		
		foreach($data_list as $row)
		{
			$str  = "INSERT INTO pelaut_ms SET 				 	 	 	 		 ";
			$str .= "nama_depan 			 = '$row[nama_depan]'  				,";
			$str .= "nama_belakang			 = '$row[nama_belakang]'			,";
			$str .= "username				 = '$username'						,";
			$str .= "password				 = '".md5($row['password'])."' 	    ,";
			$str .= "kebangsaan				 = '$row[kebangsaan]'				,";
			$str .= "agama					 = '$row[agama]'					,";
			$str .= "gender					 = '$row[gender]'				 	,";
			$str .= "tempat_lahir			 = '$row[tempat_lahir]'				,";
			$str .= "tanggal_lahir			 = '$row[tanggal_lahir]'			,";
			$str .= "alamat					 = '$row[alamat]'				    ,";
			$str .= "telepon				 = '$row[telepon]'					,";
			$str .= "handphone				 = '$row[handphone]'				,";
			$str .= "fax					 = '$row[fax]'						,";
			$str .= "email					 = '$row[email]'					,";
			$str .= "status_perkawinan		 = '$row[status_perkawinan]'		,";
			$str .= "keluarga_terdekat		 = '$row[keluarga_terdekat]'		,";
			$str .= "hubungan				 = '$row[hubungan]'					,";
			$str .= "alamat_keluarga_terdekat= '$row[alamat_keluarga_terdekat]'	,";
			
			$insert_batch = $CI->db2->query($str);
		}
		
		return $insert_batch;
	}
}

if(!function_exists("vessel_excel_field"))
{
	function vessel_excel_field($column)
	{
		$CI =& get_instance();
		
		switch ($column) {
		  case "A":
			  if (empty($value)) {
				  $broken_cell = true;
			  } else {
				  $new_ship["ship_name"] = $value;
			  }

			  break;
		  case "B":

			  $ship_type = $CI->generic->retrieve_one(
				  "ship_type", array("type_id" => (int) $value));

			  if (empty($ship_type)) {
				  log_message("error", "Ship type doesn't match: ". $value);
				  $broken_cell = true;
			  } else {
				  $new_ship["id_ship_type"] = $value;
			  }

			  break;
		  case "C":

			  $company = $CI->generic->retrieve_one(
				  "perusahaan", array("id_perusahaan" => (int) $value));

			  if (empty($company)) {
				  log_message("error", "Company doesn't match: ". $value);
				  $broken_cell = true;
			  } else {
				  $new_ship["id_perusahaan"] = $value;
			  }

			  break;
		  case "D":
			  if (empty($value)) {
				  $new_ship["description"] = "";
			  } else {
				  $new_ship["description"] = $value;
			  }

			  break;
		  case "E":
			  if (empty($value)) {
				  $new_ship["author"] = "";
			  } else {
				  $new_ship["author"] = $value;
			  }

			  break;
		  case "F":
			  if (empty($value)) {
				  $new_ship["imo"] = "";
			  } else {
				  $new_ship["imo"] = $value;
			  }
			  break;
		  case "G":

			  if (empty($value)) {
				  $new_ship["image_ship"] = "";
			  } else {
				  $new_ship["image_ship"] = $value;
			  }
			  break;
		  case "H":

			  if (empty($value)) {
				  $new_ship["weight"] = "";
			  } else {
				  $new_ship["weight"] = $value;
			  }
			  break;
		  case "I":

			  if (empty($value)) {
				  $new_ship["engine"] = "";
			  } else {
				  $new_ship["engine"] = $value;
			  }
			  break;
		  case "J":

			  $nationality = $CI->generic->retrieve_one(
				  "nationality", array("id" => (int) $value));

			  if (empty($nationality)) {
				  log_message("error", "Nationality doesn't match: ". $value);
				  $broken_cell = true;
			  } else {
				  $new_ship["flag"] = $value;
			  }

			  break;
		  case "K":

			  if (empty($value)) {
				  $new_ship["built"] = "";
			  } else {
				  $new_ship["built"] = $value;
			  }

			  break;
			  
		  case "L":

			  if (empty($value)) {
				  $new_ship["owner"] = "";
			  } else {
				  $new_ship["owner"] = $value;
			  }

			  break;
			  
		  case "M":
			  $new_ship["satuan"] 		  = $value;
			  $new_ship["number_of_views"] = 0;
			  $new_ship["image_ship"]      = "";

			  $data_list[] = $new_ship; // end of row, insert one data.
			  $new_ship = array(); // reset new ship
			  break;
			  
		  default:
			  break;
	    }
				
		return array("broken_cell"=>$broken_cell,"broken_log"=>$broken_log,"data_list"=>$data_list); 
		
	}
	
}

if(!function_exists("agentsea_excel_field"))
{
	function agentsea_excel_field()
	{
		$CI =& get_instance();
		
		
		
	}
	
}
