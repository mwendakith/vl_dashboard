<?php
(defined('BASEPATH') or exit('No direct script access allowed!'));
/**
* 
*/
class Pmtct_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}

	public function pmtct_outcomes($year=null,$month=null,$to_year=null,$to_month=null,$partner=null)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}
		$default = 0;
		$sql = "CALL `proc_get_vl_pmtct`('".$default."','".$year."','".$month."','".$to_year."','".$to_month."','".$default."','".$default."','".$partner."','".$default."')";

		$result = $this->db->query($sql)->result();

		$count = 0;
		$name = '';
		
		// echo "<pre>";print_r($result);die();
		$data['pmtct'][0]['name'] = 'Not Suppresed';
		$data['pmtct'][1]['name'] = 'Suppresed';
 
		$data["pmtct"][0]["data"][0]	= $count;
		$data["pmtct"][1]["data"][0]	= $count;
		$data['categories'][0]			= 'No Data';
 
		foreach ($result as $key => $value) {
			$data['categories'][$key] 		= $value->pmtcttype;
			$data["pmtct"][0]["data"][$key]	=  (int) ($value->less5000+$value->above5000);
			$data["pmtct"][1]["data"][$key]	=  (int) ($value->undetected+$value->less1000);
		}
		// die();
		$data['pmtct'][0]['drilldown']['color'] = '#913D88';
		$data['pmtct'][1]['drilldown']['color'] = '#96281B';
 
		// echo "<pre>";print_r($data);die();
		// $data['categories'] = array_values($data['categories']);
		// $data["pmtct"][0]["data"] = array_values($data["pmtct"][0]["data"]);
		// $data["pmtct"][1]["data"] = array_values($data["pmtct"][1]["data"]);
		// echo "<pre>";print_r($data);die();
		return $data;
	}
}
?>