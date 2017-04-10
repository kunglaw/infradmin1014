<?php  if ( ! defined('BASEPATH')) exit('No direct script misc allowed');


/**
 * Helper to assist in misc operation.
 * 
 * @copyright 	2015 PT. Badr Interactive
 * @link		http://badr.co.id
 */

if (!function_exists('move_from_temp_loc')) {
    /**
     * Function to move file from temporary location.
     * CAUTION: you should use server URL instead of localhost one for $source_address
     * and $dest_address
     *
     * @param string $source_address source address (please define the base here)
     * @param string $dest_address destination address (destination folder)
     * @param string $new_name_without_extension (brand new name for the file)
     * @return string new name with extension.
     */
    function move_from_temp_loc($source_address, $dest_address,
                                $new_name_without_extension) {

        $result = copy_from_temp_loc($source_address, $dest_address,
            $new_name_without_extension);

        // delete temp file.
        unlink($source_address);

        return $result;
    }
}

if (!function_exists('copy_from_temp_loc')) {
    /**
     * Function to copy file from temporary location.
     * CAUTION: you should use server URL instead of localhost one for $source_address
     * and $dest_address
     *
     * @param string $source_address source address (please define the base here)
     * @param string $dest_address destination address (destination folder)
     * @param string $new_name_without_extension (brand new name for the file)
     * @return string new name with extension.
     */
    function copy_from_temp_loc($source_address, $dest_address,
                                $new_name_without_extension) {

        if (!file_exists($source_address) || is_dir($source_address)) {
            return "";
        }

        $filename_fragments = explode(".", $source_address);
        $extension = $filename_fragments[count($filename_fragments) - 1];
        $result = copy($source_address, $dest_address . $new_name_without_extension .".". $extension);

        if ($result) {
            return $new_name_without_extension .".". $extension;
        } else {
            return "";
        }
    }
}

if (!function_exists('save_with_random_filename')) {
    /**
     * Function to move file from temporary location.
     * CAUTION: you should use server URL instead of localhost one for $source_address
     * and $dest_address
     *
     * @param string $source_address source address (please define the base here)
     * @param string $dest_address destination address (destination folder)
     * @return string new name with extension.
     */
    function save_with_random_filename($source_address, $dest_address) {

        $CI =& get_instance();

        $file_info = pathinfo($source_address);

        $CI->load->helper("string");

        $target_filename = "";

        do {

            $target_filename = random_string("alnum", 8) .".". $file_info["extension"];

        } while(file_exists($dest_address . $target_filename));


        $result = copy($source_address, $dest_address . $target_filename);

        unlink($source_address);

        if ($result) {
            return $target_filename;
        } else {
            return "";
        }
    }
}

if (!function_exists('convert_to_dropdown_conf')) {
    /**
     * Convert database rows result into value => name format inside array.
     *
     * @param $list
     * @param string $key_field
     * @param string $value_field
     * @return array
     */
    function convert_to_dropdown_conf($list, $key_field="id", $value_field="name") {

        $dropdown = array(); // id - name correspondention

        foreach ($list as $element) {

            $dropdown[$element[$key_field]] = $element[$value_field];
        }
        return $dropdown;
    }
}

/* End of file misc_helper.php */