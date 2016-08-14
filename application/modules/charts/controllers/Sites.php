<?php 
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Sites extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('sites_model');
	}

	function site_outcomes($year=NULL,$month=NULL,$site=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->sites_model->sites_outcomes($year,$month,$site,$partner);

    	$this->load->view('site_outcomes_view',$data);
	}

	function partner_sites($year=NULL,$month=NULL,$site=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->sites_model->partner_sites_outcomes($year,$month,$site,$partner);

    	$this->load->view('partner_site__view',$data);
	}

	function site_outcomes_chart($month=null,$year=null,$site)
	{
		$data['trends'] = $this->sites_model->site_outcomes_chart($year,$month,$site);

		$this->load->view('labs_testing_trends',$data);
	}

	function site_trends($year=null,$month=null,$site=null)
	{
		$data['outcomes'] = $this->sites_model->site_trends($year,$month,$site);

		$this->load->view('labs_sample_types',$data);
	}

	function site_Vlotcomes($month=null,$year=null,$site)
	{
		$data['outcomes'] = null;

		$this->load->view('',$data);
	}

	function site_agegroups($month=null,$year=null,$site)
	{
		$data['outcomes'] = null;

		$this->load->view('',$data);
	}

	function site_gender($month=null,$year=null,$site)
	{
		$data['outcomes'] = null;

		$this->load->view('',$data);
	}

	function site_justification($month=null,$year=null,$site)
	{
		$data['outcomes'] = null;

		$this->load->view('',$data);
	}
}
?>