<?php
defined("BASEPATH") or exit();
/**
* 
*/
class Ages extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('ages_model');
	}

	function age_outcomes($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL,$partner=NULL)
	{
		$data['outcomes']= $this->ages_model->ages_outcomes($year,$month,$to_year,$to_month,$partner);

		$this->load->view('county_outcomes_view', $data);
	}

	function age_county_outcomes($year=NULL,$month=NULL,$age=NULL,$to_year=NULL,$to_month=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->ages_model->county_outcomes($year,$month,$age,$to_year,$to_month,$partner);

    	$this->load->view('county_outcomes_view_two',$data);
	}

	function age_vl_outcome($year=NULL,$month=NULL,$age=NULL,$to_year=NULL,$to_month=NULL,$partner=NULL)
	{
		$data['outcomes']= $this->ages_model->ages_vl_outcomes($year,$month,$age,$to_year,$to_month,$partner);

		$this->load->view('vl_outcomes_view',$data);
	}

	function age_gender($year=NULL,$month=NULL,$age=NULL,$to_year=NULL,$to_month=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->ages_model->ages_gender($year,$month,$age,$to_year,$to_month,$partner);
		
    	$this->load->view('age_regimen_gender_view',$data);
	}

	function sample_types($year=NULL,$age=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->ages_model->ages_samples($year,$age,$partner);

    	$this->load->view('sample_types_view',$data);
	}
}
?>