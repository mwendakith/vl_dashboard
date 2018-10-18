<?php
defined('BASEPATH') or exit('No direct script allowed');

/**
 * 
 */
class Agencies extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('agencies_model');
	}

	public function suppression($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id=null) {
		$data['trends'] = $this->agencies_model->suppression($year,$month,$to_year,$to_month,$type,$agency_id);
		$data['div_name'] = "funding_agencies_supppression";
		if ($type == 1)
			$data['div_name'] = "partner_agency_supppression";

		$this->load->view('trends_outcomes_view', $data);
	}

	public function outcomes ($year=null,$month=null,$to_year=null,$to_month,$type=null,$agency_id=null) {

	}

	function vl_outcomes($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL,$type=NULL,$agency_id=NULL)
	{
		$data['outcomes'] = $this->agencies_model->vl_outcomes($year,$month,$to_year,$to_month,$type,$agency_id);

    	$this->load->view('vl_outcomes_view',$data);
	}
	

	function justification($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL,$type=NULL,$agency_id=NULL)
	{
		$data['outcomes'] = $this->agencies_model->justification($year,$month,$to_year,$to_month,$type,$agency_id);

    	$this->load->view('justification_view',$data);
	}

	// function justificationbreakdown($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	// {
	// 	$data['outcomes'] = $this->agencies_model->justification_breakdown($year,$month,$county,$partner,$to_year,$to_month);
		
	// 	$this->load->view('justification_breakdown_view',$data);
	// }

	function age($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL,$type=NULL,$agency_id=NULL)
	{
		$data['outcomes'] = $this->agencies_model->age($year,$month,$to_year,$to_month,$type,$agency_id);
		
    	$this->load->view('agegroup_view',$data);
	}

	// function agebreakdown($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	// {
	// 	$data['outcomes'] = $this->agencies_model->age_breakdown($year,$month,$county,$partner,$to_year,$to_month);
		
	// 	$this->load->view('agegroupBreakdown',$data);
	// }

	function gender($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL,$type=NULL,$agency_id=NULL)
	{
		$data['outcomes'] = $this->agencies_model->gender($year,$month,$to_year,$to_month,$type,$agency_id);

    	$this->load->view('gender_view',$data);
	}

	public function sample_types($year=NULL,$type=null,$agency_id=null,$all=NULL) {
		$data['outcomes'] = $this->agencies_model->sample_types($year,$type,$agency_id, $all);
		$link = $year . '/' . $type . '/' . $agency_id;

		$data['link'] = base_url('charts/agencies/download_sampletypes/' . $link);

    	$this->load->view('national_sample_types',$data);
	}
}

?>