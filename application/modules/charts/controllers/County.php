<?php
defined("BASEPATH") or exit();
/**
* 
*/
class County extends MY_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('county_model');
	}

	function county_table($year=NULL,$month=NULL,$to_month=NULL)
	{
		$data['outcomes']= $this->county_model->county_table($year,$month);

		$link = $year . '/' . $month;

		$data['link'] =  base_url('charts/county/download_county_table/' . $link);

    	$this->load->view('counties_table_view',$data);
	}

	function download_county_table($year=NULL,$month=NULL,$to_month=NULL)
	{
		$this->county_model->download_county_table($year,$month);
		
	}



	function county_subcounties($year=NULL,$month=NULL,$county=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->county_model->county_subcounties($year,$month,$county);

		$link = $year . '/' . $month . '/' . $county;

		$data['link'] =  base_url('charts/county/download_subcounty_table/' . $link);

    	$this->load->view('counties_table_view',$data);
	}

	function download_subcounty_table($year=NULL,$month=NULL,$county=NULL,$to_month=NULL)
	{
		$this->county_model->download_subcounty_table($year,$month,$county);
		
	}

	function subcounty_outcomes($year=NULL,$month=NULL,$county=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->county_model->subcounty_outcomes($year,$month,$county);

		$this->load->view('county_outcomes_view',$data);
	}

	
}
?>