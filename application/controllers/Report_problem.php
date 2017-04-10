<?php if(!defined('BASEPATH')) exit('no direct script access allowed');


    class Report_problem extends CI_Controller {


    
    private $_primary_table = "report_problem";

    private $_respon_table = "respon_report";


    private $_menu = MENU_REPORT;

    private $_route = "report";
    private $_view_folder = "report_problem";

    public function __construct() {

        parent::__construct();
                $this->load->model('report_model');

        //check_auth();
        //check_privileges($this->_menu);

    }

    public function list_item() {
        set_page_title("Report Problem Management");

        $this->session->set_userdata("sidebar_flag", $this->_menu);


        if($this->session->userdata('role') == 1) { 
        $data['report'] = $this->report_model->get_report_all();
    } else{
        $data['report'] = $this->report_model->report_admin($this->session->userdata('name'));
    }

       $this->load->view($this->_view_folder.'/item_list',$data);

    }

    function list_item_all(){
        set_page_title("ALL REPORT");

        $this->session->set_userdata("sidebar_flag",$this->_menu);

        $data['report'] = $this->report_model->all_report();

        $this->load->view($this->_view_folder.'/item_all',$data);

    }

    function form_edit_report()
    {
        $id_report = $this->input->post("id_report");
        // load data 
        $data['report'] = $this->report_model->detail_report($id_report);
            
        $this->load->view("modal/form_edit_report",$data);
        
        
    }

    function form_edit_pic(){
        $id_report = $this->input->post('id_report');

        $data['report'] = $this->report_model->detail_report($id_report);

        $this->load->view('modal/form_edit_pic',$data);
    }


      public function show_item_detail($item_id) {

        set_page_title("Report Detail");

        $this->session->set_userdata("sidebar_flag", $this->_menu);

      

                $data['report'] = $this->report_model->detail_report($item_id);
                $data['history'] = $this->report_model->get_history($item_id);
        // $item_detail["item_id"] = $item_id;

        // $item_detail["base_url"] = base_url();
        // $item_detail["controller_name"] = $this->_vessel_route;
        // $item_detail["view_folder"] = $this->_view_folder;
        // $item_detail["dt_list_source"] = $item_detail["base_url"] . $this->_vessel_route ."/list/". $item_id;
        // $item_detail["table_name"] = $this->_vessel_table;
        // $item_detail["delete_table_name"] = $this->_vessel_table;

        $this->load->view($this->_view_folder ."/item_detail", $data);
    }

    function edit_report($id){


        set_page_title("Respon Report");

                $this->session->set_userdata('sidebar_flag',$this->_menu);

                $data['report'] = $this->report_model->detail_report($id);

                $this->load->view($this->_view_folder."/edit",$data);


    }

    function proses_edit_pic(){

        $id_report = $this->input->post('id_report');
        $pic = $this->input->post('pic');
        $superadmin = $this->session->userdata('name');
        $now = date('Y-m-d H:i:s');
      
      $f = $this->report_model->detail_report($id_report);
        if($f['pic'] == ""){
            $b = $this->report_model->add_history($id_report,$pic,$superadmin,"pending");
             $a =         $this->report_model->update_pic($pic,$id_report);

        } else {
                $b = $this->report_model->add_history($id_report,$pic,$superadmin,"pending");

                    $a = $this->report_model->update_pic($pic,$id_report);
        }


        $z = $this->db->query("INSERT INTO admin_message (source,destination,type,target) VALUES (9,'$pic',10,'$id_report')");


    if($a){


        echo "<div class='alert alert-success'> PIC has been changed </div>";
        echo "<script> setTimeout(function() { location.reload(); }, 3000); </script>";


    } else {
        echo "GAGAL";
    }   
    }


    function proses_edit(){
        $id_report = $this->input->post('id_report');
        //$pic = $this->input->post('pic');
        $solution_report = $this->input->post('solution_report');
        $status_report = $this->input->post('status_report');
    
        $a = $this->report_model->update_report($solution_report,$status_report,$id_report);
        if($a){
            redirect('report_problem');
        } else{
            redirect('report_problem');
        }
    }


    }