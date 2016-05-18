<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summaries extends MY_Controller {

	function __construct()
	{
		parent:: __construct();
		$this->load->model('summaries_model');
	}
	
	function county_outcomes($year=NULL,$month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->county_outcomes($year,$month);

    	$this->load->view('county_outcomes_view',$data);
	}

	function vl_outcomes($year=NULL,$month=NULL,$county=NULL)
	{
		$data['outcomes'] = $this->summaries_model->vl_outcomes($year,$month,$county);

    	$this->load->view('vl_outcomes_view',$data);
	}

	function justification($year=NULL,$month=NULL,$county=NULL)
	{
		$data['outcomes'] = $this->summaries_model->justification($year,$month,$county);

    	$this->load->view('justification_view',$data);
	}

	function age($year=NULL,$month=NULL,$county=NULL)
	{
		$data['outcomes'] = $this->summaries_model->age($year,$month,$county);

    	$this->load->view('agegroup_view',$data);
	}

	function gender($year=NULL,$month=NULL,$county=NULL)
	{
		$data['outcomes'] = $this->summaries_model->gender($year,$month,$county);

    	$this->load->view('gender_view',$data);
	}

	function sample_types($year=NULL,$county=NULL)
	{
		$data['outcomes'] = $this->summaries_model->sample_types($year,$county);

    	$this->load->view('sample_types_view',$data);
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