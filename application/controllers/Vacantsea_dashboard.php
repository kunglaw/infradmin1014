<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * Class Vacantsea_dashboard

 * Handle vacantsea dashboard, showing vacantsea graph.

 *

 * @author pulung

 * @copyright 2015 PT. Badr Interactive

 */



class Vacantsea_dashboard extends CI_Controller {



    private $_menu = MENU_VACANTSEA;



    private $_route = "vacantsea/dashboard";

    private $_view_folder = "vacantsea_dashboard";



    public function __construct() {



        parent::__construct();

        check_auth();

        check_privileges($this->_menu);



    }



    /**

     * Show growth

     */

    public function show_dashboard() {


		ini_set("memory_limit", "256M");
        set_page_title("Vacantsea Growth");



        $this->session->set_userdata("sidebar_flag", $this->_menu);



        // prepare vacantsea login data

        $data["base_url"] = base_url();

        $data["controller_name"] = $this->_route;

        $data["view_folder"] = $this->_view_folder;



        // prepare month and year dropdown value for growth graph filter.

        $data["year"] = array();

        for ($year = 2010; $year <= date("Y"); $year++) {

            $data["year"][$year] = $year;

        }



        $data["month"] = array(1 => "January", 2 => "February", 3 => "March",

            4 => "April", 5 => "May", 6 => "June", 7 => "July", 8 => "August",

            9 => "September", 10 => "October", 11 => "November", 12 => "December");



        $this->load->view($this->_view_folder ."/dashboard", $data);

    }



    /**

     * Get growth data for graphic.

     *

     * @param null $year

     * @param null $month

     */

    public function get_growth_data($year = NULL, $month = NULL) {

		ini_set("memory_limit", "128M");

        $response = array();

        if ($year == NULL || $month == NULL) {

            $year = date("Y");

            $month = date("m");

        }

        // retrieve seatizen total in a month.

        $this->load->model("vacantsea_model", "vacantsea");

        $total_vacantsea_in_month = $this->vacantsea->get_total_vacantsea_in_a_month($year, $month);

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

        foreach ($total_vacantsea_in_month as $total_in_day) {



            // fill the empty days.

            while ($total_in_day["day"] != $counter) {



                $element = new stdClass();

                $element->posted = 0;

                $element->date = date("Y-m-d", strtotime($year ."-". $month ."-". $counter ." 00:00:00"));

                $growth_data[] = $element;



                $counter++;

            }



            // fill existing days

            $element = new stdClass();

            $element->posted = $total_in_day["total"];

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

                $element->posted = 0;

            } else {

                $element->posted = $trailing_value;

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



}



/* End of file Log_seatizen.php */

/* Location: ./application/controllers/web/Log_seatizen.php */