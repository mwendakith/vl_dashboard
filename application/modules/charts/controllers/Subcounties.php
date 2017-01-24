<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Subcounties extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('subcounty_model');
	}

	function subcounty_outcomes($year=NULL,$month=NULL)
	{
		$data['outcomes']= $this->subcounty_model->subcounty_outcomes($year,$month);

		$this->load->view('county_outcomes_view', $data);
	}
	
	function subcounty_vl_outcomes($year=NULL,$month=NULL,$subcounty=NULL)
	{
		$data['outcomes']= $this->subcounty_model->subcounty_vl_outcomes($year,$month,$subcounty);

		$this->load->view('vl_outcomes_view',$data);
	}

	function subcounty_gender($year=NULL,$month=NULL,$subcounty=NULL)
	{
		$data['outcomes'] = $this->subcounty_model->subcounty_gender($year,$month,$subcounty);
		
    	$this->load->view('age_regimen_gender_view',$data);
	}

	function subcounty_age($year=NULL,$month=NULL,$subcounty=NULL)
	{
		$data['outcomes'] = $this->subcounty_model->subcounty_age($year,$month,$subcounty);
		
    	// $this->load->view('agegroup_view',$data);
    	$this->load->view('regimen_agegroup_view',$data);
	}

	function sample_types($year=NULL,$subcounty=NULL)
	{
		$data['outcomes'] = $this->subcounty_model->subcounty_samples($year,$subcounty);

    	$this->load->view('sample_types_view',$data);
	}

	function subcounty_sites($year=NULL,$month=NULL,$subcounty=NULL)
	{
		$data['outcomes'] = $this->subcounty_model->subcounty_sites($year,$month,$subcounty);
		
    	$link = $year . '/' . $month . '/' . $partner;
		$data['link'] =  base_url('charts/subcounties/download_subcounty_sites/' . $link);

    	$this->load->view('partner_site__view',$data);
	}

	function download_subcounty_sites($year=NULL,$month=NULL,$subcounty=NULL)
	{
		$this->subcounty_model->download_subcounty_sites($year,$month,$subcounty);
	}

}
?>