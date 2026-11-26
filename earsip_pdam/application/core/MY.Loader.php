<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Override database loader to handle deprecation warnings
     */
    public function database($params = '', $return = FALSE, $query_builder = NULL)
    {
        // Remove dynamic property warnings
        return parent::database($params, $return, $query_builder);
    }
}