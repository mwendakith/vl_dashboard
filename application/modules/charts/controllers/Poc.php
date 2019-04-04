<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Poc extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('poc_model');
	}

	function testing_trends($county=null,$year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['trends'] = $this->poc_model->testing_trends($county,$year,$month,$toYear,$toMonth);
		$data['div_name'] = "poc_time_summary";

		$this->load->view('trends_outcomes_view', $data);
	}

	function vl_outcomes($county=null,$year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['outcomes'] = $this->poc_model->vl_outcomes($county,$year,$month,$toYear,$toMonth);

		$this->load->view('vl_outcomes_view', $data);
	}

	function ages($county=null,$year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['outcomes'] = $this->poc_model->ages($county,$year,$month,$toYear,$toMonth);

		$this->load->view('agegroup_view', $data);
	}

	function gender($county=null,$year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['outcomes'] = $this->poc_model->gender($county,$year,$month,$toYear,$toMonth);

		$this->load->view('gender_view', $data);
	}

	function county_outcomes($year=null,$month=null,$toYear=null,$toMonth=null)
	{
		$data['trends'] = $this->poc_model->county_outcomes($year,$month,$toYear,$toMonth);
		$data['div_name'] = "summary_counties_summary_poc";

		$this->load->view('trends_outcomes_view', $data);
	}
}

?>