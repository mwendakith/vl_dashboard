<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class National extends MY_Controller {

	function __construct()
	{
		parent:: __construct();
		$this->load->model('national_model');
	}

	public function national()
	{
		$data['county_outcomes'] = $this->county_outcomes();
		$data['vl_outcomes'] 	 = $this->vl_outcomes();
		$data['justification'] 	 = $this->justification();
		$data['age'] 	 		 = $this->age();
		$data['gender'] 	 	 = $this->gender();
		$data['sample_types'] 	 = $this->sample_types();

		return $data;
	}

	function county_outcomes()
	{
		return $this->national_model->county_outcomes();
	}

	function vl_outcomes()
	{
		return $this->national_model->vl_outcomes();
	}

	function justification()
	{
		return $this->national_model->justification();
	}

	function age()
	{
		return $this->national_model->age();
	}

	function gender()
	{
		return $this->national_model->gender();
	}

	function sample_types()
	{
		return $this->national_model->sample_types();
	}

}
?>