<?php
defined("BASEPATH") or exit("No direct script access allowed!");
/**
* 
*/
class Labs extends MY_Controller
{
	public $data = array();

	function __construct()
	{
		parent:: __construct();
		$this->data	=	array_merge($this->data,$this->load_libraries(array('material','custom', 'tablecloth','select2')));
		$this->load->module('charts/labs');
	}

	public function index()
	{
		$this->data['labs'] = TRUE;
		$this->data['content_view'] = 'labs/labs_summary_view';
		$this -> template($this->data);
	}

	public function poc()
	{
		$this->data['content_view'] = 'labs/poc';
		$this -> template($this->data);
	}

	public function covid()
	{
		$this->data['content_view'] = 'labs/covid';
		$this -> template($this->data);
	}

	public function test()
	{
		// echo eval(APPPATH . 'views/maintenance_view.php');	
		echo "We are undergoing maintenance. We apologise for the inconvenience.";							
		die();
	}

}
?>