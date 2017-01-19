<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class County extends MY_Controller {
	public $data = array();

	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom', 'Kenya', 'tablecloth', 'select2')));
		$this->session->set_userdata('partner_filter', NULL);
		$this->load->module('charts/counties');
	}

	public function index()
	{
		$this->clear_all_session_data();
		$this->load->module('charts/summaries');
		$this->data['content_view'] = 'county/county_view';
		$this -> template($this->data);
	}

	public function subCounty()
	{
		$this->load->module('charts/subcounties');
		$this->data['sub_county'] = TRUE;
		$this->clear_all_session_data();
		$this->data['content_view'] = 'county/subCounty_view';
		$this->template($this->data);
	}

	function countyMap()
	{
		$this->data['county'] = TRUE;
		$this->data['content_view'] = 'county/county_map';
		$this -> template($this->data);
	}
}

?>

