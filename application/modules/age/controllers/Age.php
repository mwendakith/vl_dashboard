<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Age extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom','tablecloth','select2')));
		$this->data['age'] = TRUE;
		$this->load->module('charts/ages');
	}

	function index()
	{
		$this->clear_all_session_data();
		$this->data['content_view'] = 'age/age_view';
		// echo "<pre>";print_r($t`his->data);die();
		$this -> template($this->data);
	}
}
?>