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
		$data['trends']= $this->ages_model->ages_outcomes($year,$month,$to_year,$to_month,$partner);
		$data['div_name'] = "age_summary_outcomes";		

		$this->load->view('trends_outcomes_view', $data);
	}

	function partner_ages_outcomes($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL,$age=NULL)
	{
		$age = $this->split_ages($age);
		$data['trends']= $this->ages_model->partner_ages_outcomes($year,$month,$to_year,$to_month,$age);
		$data['div_name'] = "age_summary_outcomes_by_partner";		

		$this->load->view('trends_outcomes_view', $data);
	}

	function age_county_outcomes($year=NULL,$month=NULL,$age=NULL,$to_year=NULL,$to_month=NULL,$partner=NULL)
	{
		$age = $this->split_ages($age);
		$data['trends'] = $this->ages_model->county_outcomes($year,$month,$age,$to_year,$to_month,$partner);
		$data['div_name'] = "age_county_outcomes";		

		$this->load->view('trends_outcomes_view', $data);
	}

	function age_vl_outcome($year=NULL,$month=NULL,$age=NULL,$to_year=NULL,$to_month=NULL,$partner=NULL)
	{
		$age = $this->split_ages($age);
		$data['outcomes']= $this->ages_model->ages_vl_outcomes($year,$month,$age,$to_year,$to_month,$partner);

		$this->load->view('vl_outcomes_view',$data);
	}

	function age_gender($year=NULL,$month=NULL,$age=NULL,$to_year=NULL,$to_month=NULL,$partner=NULL)
	{
		$age = $this->split_ages($age);
		$data['trends'] = $this->ages_model->ages_gender($year,$month,$age,$to_year,$to_month,$partner);
		$data['div_name'] = 'age_gender_outcomes';
		
    	$this->load->view('trends_outcomes_view',$data);
	}

	function age_breakdowns($year=NULL,$month=NULL,$age=NULL,$to_year=NULL,$to_month=NULL,$county=null,$partner=null,$subcounty=null,$site=null)
	{
		$age = $this->split_ages($age);
		$data['outcomes'] = $this->ages_model->ages_breakdowns($year,$month,$age,$to_year,$to_month,$county,$partner,$subcounty,$site);
		if ($county == 1 || $county == '1') $data['is_counties'] = true;
		
		$this->load->view('age_breakdown_listing',$data);
	}

	function sample_types($year=NULL,$age=NULL,$partner=NULL)
	{
		$age = $this->split_ages($age);
		$data['outcomes'] = $this->ages_model->ages_samples($year,$age,$partner);
		// $link = $year . '/' . $age . '/' . $partner;

		$data['link'] =  "";

    	$this->load->view('sample_types_view',$data);
	}

	function age_regimen($year=NULL,$month=NULL,$age=NULL,$to_year=NULL,$to_month=NULL)
	{
		$age = $this->split_ages($age);
		$data['trends'] = $this->ages_model->age_regimens($year,$month,$age,$to_year,$to_month);
		$data['div_name'] = 'ages_regimen_outcomes';
		
		
		$this->load->view('trends_outcomes_view', $data);
	}


	function download_sampletypes($year=NULL,$age=NULL,$partner=NULL)
	{
		$age = $this->split_ages($age);
		$this->ages_model->download_sampletypes($year,$age,$partner);
	}
}
?>