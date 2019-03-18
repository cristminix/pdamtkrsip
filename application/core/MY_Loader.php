<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {
	public function __construct()
    {
            parent::__construct();
    }

	public function add_view_path($path)
    {
            $this->_ci_view_paths[$path] = TRUE;
    }
    public function change_view_path($path)
    {	
    		$this->_ci_view_paths = array();
            $this->_ci_view_paths[$path] = TRUE;
    }
    public function get_view_paths()
    {
        return $this->_ci_view_paths;
    }

}