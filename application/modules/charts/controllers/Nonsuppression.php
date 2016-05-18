<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Nonsuppression extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('nonsuppression_model');
	}

	function gender_age_group($year=NULL,$month=NULL)
	{
		// $data['suppressions'] = $this->summaries_model->county_outcomes($year,$month);

    	$this->load->view('sup_genderage_group_view');
	}

	function justification($year=NULL,$month=NULL)
	{
		// $data['suppressions'] = $this->summaries_model->county_outcomes($year,$month);

    	$this->load->view('sup_justification_view');
	}
	function regimen($year=NULL,$month=NULL)
	{
		// $data['suppressions'] = $this->summaries_model->county_outcomes($year,$month);

    	$this->load->view('sup_regimen_view');
	}
	function sample_type($year=NULL,$month=NULL)
	{
		// $data['suppressions'] = $this->summaries_model->county_outcomes($year,$month);

    	$this->load->view('sup_sampleTypes_view');
	}

	
	function display_date()
	{
		echo "(".$this->session->userdata('filter_year')." ".$this->nonsuppression_model->resolve_month($this->session->userdata('filter_month')).")";
	}

	function display_range()
	{
		echo "(".($this->session->userdata('filter_year')-1)." - ".$this->session->userdata('filter_year').")";
	}
}
?>