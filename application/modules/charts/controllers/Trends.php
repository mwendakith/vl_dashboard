<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Trends extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('trends_model');
	}

	function positive_trends($county=NULL){
		$obj = $this->trends_model->yearly_trends($county);
		// echo "<pre>";print_r($obj);echo "</pre>";die();
		$data['trends'] = $obj['test_trends'];
		$data['title'] = "Test Trends";
		$data['div'] = "#tests";
		$data['div_name'] = "tests";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Tests";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['positivity_trends'];
		$data['title'] = "Positivity Trends";
		$data['div'] = "#positivity";
		$data['div_name'] = "positivity";
		$data['suffix'] = "%";
		$data['yAxis'] = "Number of Positives (%)";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['rejected_trends'];
		$data['title'] = "Rejected Trends";
		$data['div'] = "#rejects";
		$data['div_name'] = "rejects";
		$data['suffix'] = "%";
		$data['yAxis'] = "Number of Rejects (%)";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['infant_trends'];
		$data['title'] = "Infant tests (less than 2m)";
		$data['div'] = "#infants";
		$data['div_name'] = "infants";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of Infant Tests";
		$this->load->view('lab_performance_view', $data);

		$data['trends'] = $obj['tat4_trends'];
		$data['title'] = "Turnaround Time";
		$data['div'] = "#tat";
		$data['div_name'] = "tat";
		$data['suffix'] = "";
		$data['yAxis'] = "Tat4 Time";
		$this->load->view('lab_performance_view', $data);

		

		//echo json_encode($obj);
		//echo "<pr>";print_r($obj);die;

	}

	function summary($county=NULL){
		$data['trends'] = $this->trends_model->yearly_summary($county);
		//$data['trends'] = $this->positivity_model->yearly_summary();
		//echo json_encode($data);
		// echo "<pre>";print_r($data);die();
		$this->load->view('trends_outcomes_view', $data);
	}


}