<?php
defined("BASEPATH") or exit();

/**
* 
*/
class Partner extends MY_Controller
{
	public $data = array();

	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts')));

		$this->load->module('charts/summaries');
	}

	public function index()
	{
		$this->data['content_view'] = 'partner/partner_summary_view';
		$this -> template($this->data);
	}

	public function nosuppression()
	{
		$this->data['content_view'] = 'partner/partner_no_suppression_view';
		$this -> template($this->data);
	}
}
?>