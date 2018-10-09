<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class Agencies_model extends MY_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function suppression($year=null,$month=null,$to_year=null,$to_month,$type=null,$agency_id=null) {
		if ($year==null || $year=='null') 
			$year = $this->session->userdata('filter_year');
		
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		if ($to_month==null || $to_month=='null') 
			$to_month = 0;
		if ($to_year==null || $to_year=='null') 
			$to_year = 0;

		if ($type==null || $type == 'null')
			$type = 0;
		if ($agency_id==null || $agency_id == 'null')
			$agency_id = 0;

		$sql = "CALL `proc_get_vl_agencies_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$agency_id."')";

		$result = $this->db->query($sql)->result_array();

		$data['outcomes'][0]['name'] = "Not Suppressed";
		$data['outcomes'][1]['name'] = "Suppressed";
		$data['outcomes'][2]['name'] = "Suppression";

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "spline";
		

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' %');

		$data['title'] = "";
		$data['categories'][0] 		   = 'No Data';
		$data['outcomes'][0]['data'][0] = (int) 0;
		$data['outcomes'][1]['data'][0] = (int) 0;
		$data['outcomes'][2]['data'][0] = (int) 0;
 
		foreach ($result as $key => $value) {
			$suppressed = (int)$value['suppressed'];
			$nonsuppressed = (int)$value['nonsuppressed'];
			$data['categories'][$key] 		   = $value['agency'];
			$data['outcomes'][0]['data'][$key] = (int) $nonsuppressed;
			$data['outcomes'][1]['data'][$key] = (int) $suppressed;
			$data['outcomes'][2]['data'][$key] = round(@(((int) $suppressed*100)/((int) $suppressed+(int) $nonsuppressed)),1);
		}
		
		return $data;

	}

	public function outcomes ($year=null,$month=null,$to_year=null,$to_month,$type=null,$agency_id=null) {

	}
}

?>