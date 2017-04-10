<?php 

	class Request_upgrade_model extends CI_Model{
		
		private $db;
		
		function __construct()
		{
			parent::__construct();
			// load database				   //check constants
			$this->db  = $this->load->database(DB_GROUP,TRUE);
			$this->db2 = $this->load->database(DB2_GROUP,TRUE);
			
		}
		
		function list_request_upgrade()
		{
			$str = "SELECT * from request_upgrade ";
			$q = $this->db2->query($str);
			$f = $q->result_array();
			
			return $f;
			
			
		}
		
		function detail_request($key)
		{
			$b_field = "b.id_pc,b.an_rekening,b.tanggal_transfer,b.jam_transfer,b.from_bank";
			
			$str  = "SELECT a.*,$b_field FROM request_upgrade a LEFT JOIN payment_confirm b ON a.no_invoice = b.no_invoice ";
			$str .= "WHERE a.no_invoice = '$key' "; 
			
			$q = $this->db2->query($str);
			$f = $q->row_array();
			
			return $f;	
			
		}
		
		function change_account($detail_order,$perusahaan)
		{
			$str  = "UPDATE perusahaan SET account_type = '$detail_order[account_pilihan]' WHERE email = '$perusahaan[email]' ";
			$q = $this->db2->query($str);
			
			$str_sel_crew = "SELECT * FROM perusahaan_setting WHERE id_perusahaan = '$perusahaan[id_perusahaan]' ";
			$q_sel_crew = $this->db2->query($str_sel_crew);
			$f_sel_crew = $q_sel_crew->row_array();		
			
			$today = date("Y-m-d");
			$active_until   = $perusahaan['active_until'];
			
			//$today 		= "2016-04-09";
			//$active_until = "2016-04-20";
			$req_month 	  = $detail_order['req_month']; 
			
			
			//update active_until
			if($today > $active_until) // active_until < today
			{
				$aa  = date("Y-m-d");  // waktu eksekusi
				$set_active_until = date("Y-m-d",strtotime("+$req_month month",$aa));
			}
			else // active_until > today
			{
				$aa  = strtotime("$active_until");  
				$aaa = date("Y-m-d",strtotime("+$req_month month",$aa));
				
				// cari selisihnya 
				$t = date_create($today);
				$au = date_create($active_until);
				
				$diff = date_diff($t,$au); 
				$left_time = $diff->format("%R%a");
				
				$set_active_until = date("Y-m-d",strtotime("+$left_time days",$aaa));
				
			}
	
			$str_uau = "UPDATE perusahaan SET active_until='$set_active_until' WHERE email = '$perusahaan[email]' ";
			$q_uau   = $this->db2->query($str_uau); 
				
			// update jumlah crew
			if($detail_order['account_pilihan'] != "Basic")
			{
			  if($detail_order['req_max_crew'] > 0)
			  {
				$result_crew = $detail_order['req_max_crew'] + $f_sel_crew['max_crew']; 
				
				// update max_crew
				$str2 = "UPDATE perusahaan_setting SET max_crew = '$result_crew' WHERE id_perusahaan = '$perusahaan[id_perusahaan]' ";
				$q2 = $this->db2->query($str2);	
			  }
			}
			
			//final process
			$str_uor = "UPDATE request_upgrade SET status = 'success' WHERE no_invoice = '$detail_order[no_invoice]' ";
			$q 	   = $this->db2->query($str_uor);
			
		}
			
		// gabungan 
		function list_order_confirm()
		{
			/*
				Array
				(
					[0] => id_pc
					[1] => no_invoice
					[2] => an_rekening
					[3] => total_purchase
					[4] => from_bank
					[5] => purpose_bank
					[6] => tanggal_transfer
					[7] => jam_transfer
					[8] => bukti_tranfer
					[9] => create_date
					[10] => ip_address
					[11] => user_agent
				)
			
			*/
			
			$b_field = "b.id_pc,b.an_rekening,b.tanggal_transfer,b.jam_transfer,b.from_bank";
			
			$str = "SELECT a.*,$b_field FROM request_upgrade a LEFT JOIN payment_confirm b ON a.no_invoice = b.no_invoice ";
			$q = $this->db2->query($str);
			$f = $q->result_array();
			
			return $f;
		}
		
		
		
	}