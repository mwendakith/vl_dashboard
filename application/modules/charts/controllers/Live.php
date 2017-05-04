<?php
defined("BASEPATH") or exit();
/**
* 
*/
class Live extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('live_model');
	}

	function get_vl_data(){
		echo $this->live_model->get_vl_data();
	}

	function get_eid_data(){
		echo $this->live_model->get_eid_data();
	}

	
}
?>