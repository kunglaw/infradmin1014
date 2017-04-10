<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Seatizen_dashboard
 * Handle seatizen dashboard.
 *
 * @author pulung
 * @copyright 2015 PT. Badr Interactive
 */

class Seatizen_dashboard extends CI_Controller {

    private $_seatizen_login_table = "log_login_seatizen";
    private $_seatizen_table = "pelaut_ms";

    private $_menu = MENU_SEATIZEN;

    private $_route = "seatizen/dashboard";
    private $_view_folder = "seatizen_dashboard";

    public function __construct() {

        parent::__construct();
        check_auth();
        check_privileges($this->_menu);

    }

    /**
     * Show seatizen growth and login history
     */
    public function show_dashboard() {

        set_page_title("Seatizen Growth");

        $this->session->set_userdata("sidebar_flag", $this->_menu);

        // prepare seatizen login data
        $data["base_url"] = base_url();
        $data["controller_name"] = $this->_route;
        $data["view_folder"] = $this->_view_folder;
        $data["dt_list_source"] = $data["base_url"] . $data["controller_name"] ."/login";
        $data["table_name"] = $this->_seatizen_login_table;

        $data["need_image_tools"] = false;

        // prepare month and year dropdown value for growth graph filter.
        $data["year"] = array();
        for ($year = 2010; $year <= date("Y"); $year++) {
            $data["year"][$year] = $year;
        }

        $data["month"] = array(1 => "January", 2 => "February", 3 => "March",
            4 => "April", 5 => "May", 6 => "June", 7 => "July", 8 => "August",
            9 => "September", 10 => "October", 11 => "November", 12 => "December");

        $this->load->view($data["view_folder"] ."/dashboard", $data);
    }

    /**
     * Get growth data for graphic.
     *
     * @param null $year
     * @param null $month
     */
    public function get_growth_data($year = NULL, $month = NULL) {

        if ($year == NULL || $month == NULL) {
            $year = date("Y");
            $month = date("m");
        }

        // retrieve seatizen total in a month.
        $this->load->model("seatizen_model", "seatizen");
        $total_seatizen_in_month = $this->seatizen->get_total_seatizen_in_a_month($year, $month);


        $growth_data = array();
        $counter = 1;

        $end = date("t", strtotime($year ."-". $month ."-01 00:00:00")); // get total day in given month
        $active_day = (int) date("d");

        $trailing_value = NULL;
        if ($year == date("Y") && $month < date("m")) {
            $trailing_value = 0;
            $active_day = $end;
        } else if ($year < date("Y")) {
            $trailing_value = 0;
            $active_day = $end;
        }


        $total_view_in_month = 0;

        // repack the seatizen creation date
        foreach ($total_seatizen_in_month as $total_in_day) {

            // fill the empty days.
            while ($total_in_day["day"] != $counter) {

                $element = new stdClass();
                $element->registered = 0;
                $element->date = date("Y-m-d", strtotime($year ."-". $month ."-". $counter ." 00:00:00"));
                $growth_data[] = $element;

                $counter++;
            }

            // fill existing days
            $element = new stdClass();
            $element->registered = $total_in_day["total"];
            $total_view_in_month += $total_in_day["total"];
            $element->date = date("Y-m-d", strtotime($year ."-". $month ."-". $total_in_day["day"] ." 00:00:00"));
            $growth_data[] = $element;

            $counter++;
        }

        // fill trailing empty days
        while ($counter <= $end) {

            $element = new stdClass();

            // for current month display.
            if ($year == date("Y") && $month == date("m") && $counter <= date("d")) {
                $element->registered = 0;
            } else {
                $element->registered = $trailing_value;
            }

            $element->date = date("Y-m-d", strtotime($year ."-". $month ."-". $counter ." 00:00:00"));
            $growth_data[] = $element;
            $counter++;
        }

        $response["growth_data"] = $growth_data;
        $response["average_view"] = (float) $total_view_in_month / (float) $active_day;


        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output(json_encode($response));
    }

    /**
     * Return all item in specified table.
     */
    public function get_login_data() {

        $this->load->library("datatables");

        $edit_button_area = "";

        // specify columns for datatables
        $this->datatables->select(
            "CONCAT_WS(' ', ". $this->_seatizen_table .".nama_depan, ". $this->_seatizen_table .".nama_belakang) AS name,".
            $this->_seatizen_login_table .".action_time AS action_time".
            $edit_button_area,

            false
        );

        $this->datatables->from($this->_seatizen_login_table);

        $this->datatables->join(
            $this->_seatizen_table,
            $this->_seatizen_table .".pelaut_id = ". $this->_seatizen_login_table .".seatizen_id",
            "left"
        );


        // add condition for date range filtering.
        $start_date = $this->input->post("start_date");
        $end_date = $this->input->post("end_date");

        if (! empty($start_date) && ! empty($end_date)) {

            // validate correct date.
            $this->load->helper("date");
            $correct_date = validate_date($start_date, "d-m-Y");
            $correct_date = $correct_date && validate_date($end_date, "d-m-Y");

            if ($correct_date) {

                // reposition date format from d-m-Y to Y-m-d
                $date_fragments = explode("-", $start_date);
                $start_date = $date_fragments[2] ."-". $date_fragments[1] ."-". $date_fragments[0];

                $date_fragments = explode("-", $end_date);
                $end_date = $date_fragments[2] ."-". $date_fragments[1] ."-". $date_fragments[0];

                $this->datatables->where("DATE(". $this->_seatizen_login_table .".action_time) >=", $start_date);
                $this->datatables->where("DATE(". $this->_seatizen_login_table .".action_time) <=", $end_date);
            }
        }

        $this->output->set_content_type("application/json");
        $this->output->set_status_header(200);
        $this->output->set_output($this->datatables->generate());
    }

}

/* End of file Log_seatizen.php */
/* Location: ./application/controllers/web/Log_seatizen.php */