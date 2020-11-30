<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Baseline_model extends MY_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function notification($param_type=NULL,$param=NULL,$year=null,$month=null,$to_year=null,$to_month=null)
	{
 
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		$data['year'] = $year;
		$data['month'] = '';


		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}else{
			$data['month'] = ' as of '.$this->resolve_month($month);
		}


		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}else {
			$data['month'] .= ' to '.$this->resolve_month($to_month).' of '.$to_year;
		}

		if ($param==null || $param=='null') {
			if($param_type == 1){
				$param = $this->session->userdata('county_filter');
			}
			else if ($param_type == 2) {
				$param = $this->session->userdata('sub_county_filter');
			}
			else if ($param_type == 3) {
				$param =  $this->session->userdata('partner_filter');
			}
			else if ($param_type == 4) {
				$param =  $this->session->userdata('site_filter');
			}
			else{
				$param_type=0;
			}
		}
 
		$sql = "CALL `proc_get_vl_baseline`('".$param_type."','".$param."','".$year."','".$month."','".$to_year."','".$to_month."')";

		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		
		// echo "<pre>";print_r($result);die();
		$data['color'] = '#E4F1FE';

		
		foreach ($result as $key => $value) {

			$suppressed = (int) $value['undetected'] + (int) $value['less1000'];
			$nonsuppressed = (int) $value['above5000'] + (int) $value['less5000'];
			$total = $suppressed + $nonsuppressed;
			$nonsuppression = $nonsuppressed / $total * 100;

			$data['rate'] = round($nonsuppression, 2);
			$data['sustxfail'] = $nonsuppressed;

		}
		return $data;
	}

	
	function baseline_list($param_type=NULL,$year=null,$month=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month);
		extract($d);


		if ($param_type==null || $param_type=='null') {
			$param_type = 1;
		}


		$sql = "CALL `proc_get_vl_baseline_list`('".$param_type."','".$year."','".$month."','".$to_year."','".$to_month."')";
		
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();

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
		$data['div_name'] = "div_" . $param_type;
 
		foreach ($result as $key => $value) {

			$suppressed = (int) $value['undetected'] + (int) $value['less1000'];
			$nonsuppressed = (int) $value['above5000'] + (int) $value['less5000'];
			$total = $suppressed + $nonsuppressed;

			$data['categories'][$key] 			= $value['name'];
			$data['outcomes'][0]['data'][$key]  = $nonsuppressed;
			$data['outcomes'][1]['data'][$key]  = $suppressed;
			$data['outcomes'][2]['data'][$key]  = round(@(($suppressed*100)/ $total), 1);
			if($key == 50) break;
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function age($param_type=NULL,$param=NULL,$year=null,$month=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month);
		extract($d);

		if ($param==null || $param=='null') {
			if($param_type == 1){
				$param = $this->session->userdata('county_filter');
			}
			else if ($param_type == 2) {
				$param = $this->session->userdata('sub_county_filter');
			}
			else if ($param_type == 3) {
				$param =  $this->session->userdata('partner_filter');
			}
			else if ($param_type == 4) {
				$param =  $this->session->userdata('site_filter');
			}
			else{
				$param_type=0;
			}
		}
 
		$sql = "CALL `proc_get_vl_baseline`('".$param_type."','".$param."','".$year."','".$month."','".$to_year."','".$to_month."')";

		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		
		// echo "<pre>";print_r($result);die();
		$data['ageGnd'][0]['name'] = 'Tests';
 
		foreach ($result as $key => $value) {
			$data['categories'][0] = "Less 2";
			$data["ageGnd"][0]["data"][0] = (int) $value['less2'];

			$data['categories'][1] = "2-9";
			$data["ageGnd"][0]["data"][1] = (int) $value['less9'];

			$data['categories'][2] = "10-14";
			$data["ageGnd"][0]["data"][2] = (int) $value['less14'];

			$data['categories'][3] = "15-19";
			$data["ageGnd"][0]["data"][3] = (int) $value['less19'];

			$data['categories'][4] = "20-24";
			$data["ageGnd"][0]["data"][4] = (int) $value['less24'];

			$data['categories'][5] = "25+";
			$data["ageGnd"][0]["data"][5] = (int) $value['over25'];
		}
		// die();
		$data['ageGnd'][0]['drilldown']['color'] = '#913D88';

		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function gender($param_type=NULL,$param=NULL,$year=null,$month=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month);
		extract($d);

		if ($param==null || $param=='null') {
			if($param_type == 1){
				$param = $this->session->userdata('county_filter');
			}
			else if ($param_type == 2) {
				$param = $this->session->userdata('sub_county_filter');
			}
			else if ($param_type == 3) {
				$param =  $this->session->userdata('partner_filter');
			}
			else if ($param_type == 4) {
				$param =  $this->session->userdata('site_filter');
			}
			else{
				$param_type=0;
			}
		}
 
		$sql = "CALL `proc_get_vl_baseline`('".$param_type."','".$param."','".$year."','".$month."','".$to_year."','".$to_month."')";

		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		
		// echo "<pre>";print_r($result);die();
		$data['gender'][0]['name'] = 'Tests';
 
		foreach ($result as $key => $value) {
			$data['categories'][0] = "No Gender";
			$data["gender"][0]["data"][0] = (int) $value['nogendertest'];

			$data['categories'][1] = "Male";
			$data["gender"][0]["data"][1] = (int) $value['maletest'];

			$data['categories'][2] = "Female";
			$data["gender"][0]["data"][2] = (int) $value['femaletest'];
		}
		// die();
		$data['gender'][0]['drilldown']['color'] = '#913D88';

		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function samples($param_type=NULL,$param=NULL,$year=null,$month=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month);
		extract($d);

		if ($param==null || $param=='null') {
			if($param_type == 1){
				$param = $this->session->userdata('county_filter');
			}
			else if ($param_type == 2) {
				$param = $this->session->userdata('sub_county_filter');
			}
			else if ($param_type == 3) {
				$param =  $this->session->userdata('partner_filter');
			}
			else if ($param_type == 4) {
				$param =  $this->session->userdata('site_filter');
			}
			else{
				$param_type=0;
			}
		}
 
		$sql = "CALL `proc_get_vl_baseline`('".$param_type."','".$param."','".$year."','".$month."','".$to_year."','".$to_month."')";

		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		
		// echo "<pre>";print_r($result);die();
		$data['county_outcomes'][0]['name'] = 'Tests';
 
		foreach ($result as $key => $value) {
			$data['categories'][0] = "EDTA";
			$data["county_outcomes"][0]["data"][0] = (int) $value['edta'];

			$data['categories'][1] = "DBS";
			$data["county_outcomes"][0]["data"][1] = (int) $value['dbs'];

			$data['categories'][2] = "Plasma";
			$data["county_outcomes"][0]["data"][2] = (int) $value['plasma'];
		}
		// die();
		$data['county_outcomes'][0]['drilldown']['color'] = '#913D88';

		// echo "<pre>";print_r($data);die();
		return $data;
	}

}