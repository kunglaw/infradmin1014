<?php if(!defined('BASEPATH')) exit ('no direct script access allowed');



class Resume_data extends CI_Model{

  

  // Macam - macam data berbentuk Json yang dibutuhkan page Resume. deal with it  

  private $db=null;

  function __construct()

  {

  	parent::__construct();

  	$this->db = $this->load->database(DB2_GROUP, TRUE);

  }



  function get_json_ship()

  {

	  $this->load->model("vessel_model");

	  $vessel = $this->vessel_model->get_ship_json();

	  return $vessel;

	  

  }

  

  function get_json_rank()
  {

	  $this->load->model("rank_model");

	  

	  $id_department = $this->input->post('id_department');

	  $curr_rank     = $this->input->post('curr_rank');

	  $rank = $this->rank_model->get_rank_bydept($id_department);

	  

	 if(!empty($rank))

	  {

		foreach($rank as $row)

		{

			$selected = "";

			if($row['rank_id'] == $curr_rank)

			{

				$selected = "selected='selected'";	

			}

			

			

			echo "<option value='$row[rank_id]' $selected >$row[rank]</option>";

		}

	  }

	  else

	  {

		  echo "<option value='0' >- Other -</option>";

		  

	  }

	  

  }

  

  function get_json_ship_type()

  {

  	  $this->load->model("vessel_model");

	  $vessel_type = $this->vessel_model->get_ship_type_json();

	  

	  return $vessel_type;

	  

  }

  

  function get_ship_type()

  {

	  $this->load->model('vessel_model');

	  $ship_type = $this->vessel_model->get_ship_type();

	  $curr_type = $this->input->post('curr_type');

	  

	  if(!empty($ship_type))

	  {

		foreach($ship_type as $row)

		{

			if($curr_type == $row['type_id'])

			{

				$selected = "selected='selected'";

			}

			else

			{

				$selected = "";	

			}

			

			echo "<option value='$row[type_id]' $selected >$row[ship_type]</option>";

		}

	  }

	  else

	  {

		  echo "<option value='0' >- Other -</option>";

		  

	  }

  }

  

  function get_ship()

  {

	  $this->load->model('vessel_model');	

	  $ship = $this->vessel_model->get_ship();

	  

	  if(!empty($ship))

	  {

		foreach($ship as $row)

		{

			echo "<option value='$row[ship_id]' >$row[ship_name]</option>";

		}

	  }

	  else

	  {

		  echo "<option value='0' >- Other -</option>";

		  

	  }

  }

  

  // by type

  function get_ship_bytype()

  {

	  $this->load->model('vessel_model');

	  $type_id = $this->input->post("type_id"); 

	  $ship = $this->vessel_model->get_ship_bytypeid($type_id);

	  

	  if(!empty($ship))

	  {

		foreach($ship as $row)

		{

			$selected = "";

			if($type_id == $row["ship_type_id"])

			{

				$selected = "selected='selected'";

			}

			

			echo "<option value='$row[ship_id]' $selected >$row[ship_name]</option>";

		}

	  }

	  else

	  {

		  echo "<option value='0' >- Other -</option>";

		  

	  }

  

  }

  

  //by vessel_id

  function get_ship_type_byvi()

  {

	  $this->load->model('vessel_model');

	  $id = $this->input->post("vessel_id"); //echo "<hr>";

	  $detail_ship = $this->vessel_model->get_ship_detail($id);

	  //print_r($detail_ship); echo "<hr>"; 

	  //echo $detail_ship['id_ship_type'];

	  //exit;

	  $ship_type = $this->vessel_model->get_shiptype_byshipid($detail_ship['id_ship_type']);

	  //print_r($ship_type); echo "<hr>";

	  

	  if(!empty($ship_type))

	  {

		foreach($ship_type as $row)

		{

			echo "<option value='$row[type_id]' >$row[ship_type]</option>";

		}

	  }

	  else

	  {

		  echo "<option value='0' >- Other -</option>";

		  

	  }

  }

  

  function __destruct()

  {

	  //echo "<!-- end class -->";	

  }

  

 

}



?>