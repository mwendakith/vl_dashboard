
<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Sites extends MY_Controller
{
	public $data = array();

	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','highstock','highmaps','highcharts','custom')));
		$this->data['sit'] = TRUE;
	}

	function index()
	{
		$this->load->module('charts/sites');

		$this->data['content_view'] = 'sites/sites_view';
		$this -> template($this->data);
	}
}
?>