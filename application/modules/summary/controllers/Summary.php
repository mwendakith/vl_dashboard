<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary extends MY_Controller {

	public $data = array();

	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts')));

		$this->load->module('charts/summaries');
	}

	public function index()
	{
		$this->data['content_view'] = 'summary/summary_view';
		$this -> template($this->data);
	}
}