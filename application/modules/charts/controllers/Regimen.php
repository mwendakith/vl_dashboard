<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Regimen extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('regimen_model');
	}

	function regimen_outcomes($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL,$partner=NULL)
	{
		$data['outcomes']= $this->regimen_model->regimens_outcomes($year,$month,$to_year,$to_month,$partner);
		$data['div'] = "random_div";
		$data['type'] = "normal";

		$this->load->view('county_outcomes_view', $data);
	}

	function regimen_county_outcomes($year=NULL,$month=NULL,$regimen=NULL,$to_year=NULL,$to_month=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->regimen_model->county_outcomes($year,$month,$regimen,$to_year,$to_month,$partner);

    	$this->load->view('county_outcomes_view_two',$data);
	}

	function regimen_vl_outcome($year=NULL,$month=NULL,$regimen=NULL,$to_year=NULL,$to_month=NULL,$partner=NULL)
	{
		$data['outcomes']= $this->regimen_model->regimen_vl_outcomes($year,$month,$regimen,$to_year,$to_month,$partner);

		// $this->load->view('vl_outcomes_view',$data);
		$this->load->view('vl_outcomes_view',$data);
	}

	function regimen_gender($year=NULL,$month=NULL,$regimen=NULL,$to_year=NULL,$to_month=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->regimen_model->regimen_gender($year,$month,$regimen,$to_year,$to_month,$partner);
		
    	// $this->load->view('gender_view',$data);
    	$this->load->view('age_regimen_gender_view',$data);
	}

	function regimen_age($year=NULL,$month=NULL,$regimen=NULL,$to_year=NULL,$to_month=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->regimen_model->regimen_age($year,$month,$regimen,$to_year,$to_month,$partner);
		
    	// $this->load->view('agegroup_view',$data);
    	$this->load->view('regimen_agegroup_view',$data);
	}

	function sample_types($year=NULL,$regimen=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->regimen_model->regimen_samples($year,$regimen,$partner);

    	$this->load->view('sample_types_view',$data);
	}
}
?>