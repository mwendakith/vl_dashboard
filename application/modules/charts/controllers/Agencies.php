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
		$data['div_name'] = "partner_agencies_supppression";		

		$this->load->view('trends_outcomes_view', $data);
	}

	public function outcomes ($year=null,$month=null,$to_year=null,$to_month,$type=null,$agency_id=null) {

	}

	public function sample_types($year=NULL,$type=null,$agency_id=null,$all=NULL)
	{
		$data['outcomes'] = $this->agencies_model->sample_types($year,$type,$agency_id, $all);
		$link = $year . '/' . $type . '/' . $agency_id;

		$data['link'] = base_url('charts/agencies/download_sampletypes/' . $link);

    	$this->load->view('national_sample_types',$data);
	}
}

?>