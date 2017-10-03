<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summaries extends MY_Controller {

	function __construct()
	{
		parent:: __construct();
		$this->load->model('summaries_model');
	}

	function turnaroundtime($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->turnaroundtime($year,$month,$county,$to_year,$to_month);

		$this->load->view('turnaroundtime_view',$data);
	}
	
	function county_outcomes($year=NULL,$month=NULL,$pfil=NULL,$partner=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['trends'] = $this->summaries_model->county_outcomes($year,$month,$pfil,$partner,$county,$to_year,$to_month);
		$data['div_name'] = "summary_county_outcomes";		

		$this->load->view('trends_outcomes_view', $data);
	}

	function vl_outcomes($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->vl_outcomes($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('vl_outcomes_view',$data);
	}
	

	function justification($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->justification($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('justification_view',$data);
	}

	function justificationbreakdown($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->justification_breakdown($year,$month,$county,$partner,$to_year,$to_month);
		
		$this->load->view('justification_breakdown_view',$data);
	}

	function age($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->age($year,$month,$county,$partner,$to_year,$to_month);
		
    	$this->load->view('agegroup_view',$data);
	}

	function agebreakdown($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->age_breakdown($year,$month,$county,$partner,$to_year,$to_month);
		
		$this->load->view('agegroupBreakdown',$data);
	}

	function gender($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->gender($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('gender_view',$data);
	}

	function sample_types($year=NULL,$county=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->summaries_model->sample_types($year,$county,$partner);
		$link = $year . '/' . $county . '/' . $partner;

		$data['link'] = base_url('charts/summaries/download_sampletypes/' . $link);
		if ($partner == NULL || $partner == 'NULL' || $partner == null || $partner == 'null') {
			// echo "<pre>";print_r("This is not");die();
			$view = 'national_sample_types';
		} else {
			// echo "<pre>";print_r("This is partner");die();
			$view = 'sample_types_view';
		}
		$this->load->view('national_sample_types',$data);
	}

	function download_sampletypes($year=NULL,$county=NULL,$partner=NULL)
	{
		$this->summaries_model->download_sampletypes($year,$county,$partner);
	}

	function get_patients($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data = $this->summaries_model->get_patients($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('patients_view',$data);
	}

	function get_patients_outcomes($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data = $this->summaries_model->get_patients_outcomes($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('patients_outcomes_graph',$data);
	}

	function get_patients_graph($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data = $this->summaries_model->get_patients_graph($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('patients_graph',$data);
	}

	function display_date()
	{
		echo "(".$this->session->userdata('filter_year')." ".$this->summaries_model->resolve_month($this->session->userdata('filter_month')).")";
	}

	function display_range()
	{
		echo "(".($this->session->userdata('filter_year')-1)." - ".$this->session->userdata('filter_year').")";
	}

}
?>