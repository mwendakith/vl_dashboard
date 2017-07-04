<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Labs extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('labs_model');
	}

	function lab_performance_stats($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['stats'] = $this->labs_model->lab_performance_stat($year,$month,$to_year,$to_month);

		$link = $year . '/' . $month . '/' . $to_year . '/' . $to_month;

		$data['link'] = base_url('charts/Labs/download_lab_performance_stats/' . $link);

		$this->load->view('lab_performance_stats_view', $data);
	}

	function download_lab_performance_stats($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$this->labs_model->download_lab_performance_stats($year,$month,$to_year,$to_month);
	}

	function testing_trends($year=NULL)
	{
		$data['trends'] = $this->labs_model->lab_testing_trends($year);

		$this->load->view('labs_testing_trends',$data);
	}

	function rejection_trends($year=NULL)
	{
		$data['trends'] = $this->labs_model->lab_rejection_trends($year);
		// $data['trends'] = $this->lab_model->lab_rejection_trends($year);

		$this->load->view('labs_rejection_trends',$data);
	}

	function sample_types($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['trends'] = $this->labs_model->sample_types($year,$month,$to_year,$to_month);

		$this->load->view('labs_sample_types',$data);
	}

	function turn_around_time($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['trends'] = $this->labs_model->labs_turnaround($year,$month,$to_year,$to_month);

		 // echo "<pre>";print_r($data);

		$this->load->view('labs_turnaround_time',$data);
	}

	function results_outcome($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['trends'] = $this->labs_model->labs_outcomes($year,$month,$to_year,$to_month);
		
		$this->load->view('lab_results_outcome', $data);
	}

	function display_date()
	{
		echo "(".$this->session->userdata('filter_year')." ".$this->labs_model->resolve_month($this->session->userdata('filter_month')).")";
	}

	function display_range()
	{
		echo "(".($this->session->userdata('filter_year')-1)." - ".$this->session->userdata('filter_year').")";
	}

	function summary($lab=NULL){
		$data['trends'] = $this->labs_model->yearly_summary($lab);
		$data['div_name'] = "lab_outcomes";

		$this->load->view('trends_outcomes_view', $data);
	}


	function lab_trends($lab=NULL){
		$obj = $this->labs_model->yearly_trends($lab);
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
		$data['title'] = "Turn Around Time (Collection - Dispatch)";
		$data['div_name'] = "tat";
		$data['suffix'] = "";
		$data['yAxis'] = "TAT(Days)";
		$this->load->view('yearly_trends_view', $data);

		

		//echo json_encode($obj);
		//echo "<pr>";print_r($obj);die;

	}


}
?>