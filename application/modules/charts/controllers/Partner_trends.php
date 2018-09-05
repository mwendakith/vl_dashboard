<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Partner_trends extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('partner_trends_model');
	}

	function positive_trends($partner=NULL){
		$obj = $this->partner_trends_model->yearly_trends($partner);
		// echo "<pre>";print_r($obj);echo "</pre>";die();

		$data['trends'] = $obj['suppression_trends'];
		$data['title'] = "Suppression Trends";
		$data['div_name'] = "suppression";
		$data['suffix'] = "%";
		$data['yAxis'] = "Suppression Rate (%)";
		$this->load->view('yearly_trends_view', $data);

		$data['trends'] = $obj['test_trends'];
		$data['title'] = "Testing Trends";
		$data['div_name'] = "tests";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of  Valid Tests";
		$this->load->view('yearly_trends_view', $data);

		

		$data['trends'] = $obj['rejected_trends'];
		$data['title'] = "Rejection Rate Trends";
		$data['div_name'] = "rejects";
		$data['suffix'] = "%";
		$data['yAxis'] = "Rejection (%)";
		$this->load->view('yearly_trends_view', $data);


		$data['trends'] = $obj['tat_trends'];
		$data['title'] = "Collection - Dispatch";
		$data['div_name'] = "tat";
		$data['suffix'] = "";
		$data['yAxis'] = "TAT(Days)";
		$this->load->view('yearly_trends_view', $data);

		

		//echo json_encode($obj);
		//echo "<pr>";print_r($obj);die;

	}

	function summary($partner=NULL){
		$data['trends'] = $this->partner_trends_model->yearly_summary($partner);
		$data['div_name'] = "partner_trends";
		//$data['trends'] = $this->positivity_model->yearly_summary();
		//echo json_encode($data);
		// echo "<pre>";print_r($data);die();
		$this->load->view('trends_outcomes_view', $data);
	}
<<<<<<< HEAD
=======
	

	function age_summary($partner=NULL){
		$data['trends'] = $this->partner_trends_model->yearly_age_summary($partner);
		$data['div_name'] = "national_age_trends";
		$this->load->view('trends_view_two', $data);
	}

	function quarterly($partner=NULL){
		$obj = $this->partner_trends_model->quarterly_trends($partner);
		// echo "<pre>";print_r($obj);echo "</pre>";die();

		$data['trends'] = $obj['suppression_trends'];
		$data['title'] = "Suppression Trends";
		$data['div_name'] = "suppression_q";
		$data['suffix'] = "%";
		$data['yAxis'] = "Suppression Rate (%)";
		$this->load->view('quarterly_trends_view', $data);

		$data['trends'] = $obj['test_trends'];
		$data['title'] = "Testing Trends";
		$data['div_name'] = "tests_q";
		$data['suffix'] = "";
		$data['yAxis'] = "Number of  Valid Tests";
		$this->load->view('quarterly_trends_view', $data);

		

		$data['trends'] = $obj['rejected_trends'];
		$data['title'] = "Rejection Rate Trends";
		$data['div_name'] = "rejects_q";
		$data['suffix'] = "%";
		$data['yAxis'] = "Rejection (%)";
		$this->load->view('quarterly_trends_view', $data);


		$data['trends'] = $obj['tat_trends'];
		$data['title'] = "Turn Around Time (Collection - Dispatch)";
		$data['div_name'] = "tat_q";
		$data['suffix'] = "";
		$data['yAxis'] = "TAT(Days)";
		$this->load->view('quarterly_trends_view', $data);
	}

	function quarterly_outcomes($partner=NULL){
		$data['trends'] = $this->partner_trends_model->quarterly_outcomes($partner);
		// echo "<pre>";print_r($data);echo "</pre>";die();
		$data['div_name'] = "quarterly_trends";
		$this->load->view('trends_outcomes_view', $data);
	}
>>>>>>> dfa5047ba0638ef2034b95dfa69e0cd14bb05ef6


}