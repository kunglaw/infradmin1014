<?php

class Token{
	
	private $CI;
	
	 /** @var string */
    protected $alphabet;

    /** @var int */
    protected $alphabetLength;

    /**
     * @param string $alphabet
     */
    public function __construct($alphabet = '')
    {
		$this->CI =& get_instance();
		
        if ('' !== $alphabet) {
            $this->setAlphabet($alphabet);
        } else {
            $this->setAlphabet(
                  implode(range('a', 'z'))
                . implode(range('A', 'Z'))
                . implode(range(0, 9))
            );
        }
    }

    /**
     * @param string $alphabet
     */
    public function setAlphabet($alphabet)
    {
        $this->alphabet = $alphabet;
        $this->alphabetLength = strlen($alphabet);
    }

    /**
     * @param int $length
     * @return string
     */
    public function generate($length)
    {
        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $randomKey = $this->getRandomInteger(0, $this->alphabetLength);
            $token .= $this->alphabet[$randomKey];
        }

        return $token;
    }

    /**
     * @param int $min
     * @param int $max
     * @return int
     */
    protected function getRandomInteger($min, $max)
    {
        $range = ($max - $min);

        if ($range < 0) {
            // Not so random...
            return $min;
        }

        $log = log($range, 2);

        // Length in bytes.
        $bytes = (int) ($log / 8) + 1;

        // Length in bits.
        $bits = (int) $log + 1;

        // Set all lower bits to 1.
        $filter = (int) (1 << $bits) - 1;

        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));

            // Discard irrelevant bits.
            $rnd = $rnd & $filter;

        } while ($rnd >= $range);

        return ($min + $rnd);
    }
	
	/* $data = array(
		no_token STRING 56
		page STRING,
		email STRING
		type_user STRING
	)*/
	function insert_token($data)
	{
		$CI = $this->CI;
		
		$data["jml"] = !empty($data["jml"]) ? $data["jml"] : "+24";
		$data["satuan"] = !empty($data["satuan"]) ? $data["satuan"] : "hours";
		
		$now = date("Y-m-d H:i:s");
		$next = strtotime("$data[jml] $data[satuan]");
		$expired = date("Y-m-d H:i:s",$next);
		
		$ip_address = $CI->input->ip_address();
		$user_agent = $CI->input->user_agent();
		
		$page      = $data["page"];
		$email     = $data["email"];
		$type_user = $data["type_user"];
		$no_token  = $data["no_token"];  
		
		$str_intoken  = "INSERT INTO token_tbl SET					 ";
		$str_intoken .= "no_token 		= '$no_token'				,";
		$str_intoken .= "page			= '$page'					,";
		$str_intoken .= "create_date 	= '$now'					,";
		$str_intoken .= "expiry_date	= '$expired'				,"; // 24 jam setelah create_date
		$str_intoken .= "email			= '$email'					,"; 
		$str_intoken .= "type_user		= '$type_user'				,";
		$str_intoken .= "ip_address		= '$ip_address'				,";
		$str_intoken .= "user_agent		= '$user_agent'				 ";
		
		//echo $str_intoken;
		
		$q = $CI->db->query($str_intoken);
		
		return $q;
	}
	
	function read_token($no_token)
	{
		$CI = $this->CI;
		
		$str = "SELECT * FROM token_tbl WHERE no_token = '$no_token' ";
		$q = $CI->db->query($str);
		$f = $q->row_array();
		
		return $f;
	}
	
	/*
	
		$data_token = array(
			
			"no_token" => $no_token,
			"email"    => $email,
			"page"     => $page,
			"type_user"=> $type_user
		
		)
		
	*/
	function check_token($data_token)
	{
		
		$CI = $this->CI;
		
		foreach($data_token as $key => $value )
		{
			$CI->db->where($key,$value);
		}
		
		$q = $CI->db->get("token_tbl");
		$f = $q->row_array(); 
		
		return $f;
	}
	
	/* 
		
		$data = array(
		  no_token STRING 56
		  page STRING,
		  email STRING
		  type_user STRING
	    )
		
	*/
	// untuk dijalankan saat user ada yang login 
	function delete_token($data)
	{
		$CI = $this->CI;
		
		$q = $CI->db->delete('token_tbl', $data);

		
		/* $str = "DELETE FROM token_tbl WHERE email = '$email' AND page = 'forgotpass' AND type_user = '$type_user'  ";
		$q   = $CI->db->query($str);*/
		
		return $q; 
		
	}
	
	function __destruct()
	{
		
	}

}