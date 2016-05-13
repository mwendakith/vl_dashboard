<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summaries_model extends MY_Model
{
	function __construct()
	{
		parent:: __construct();
	}

	function county_outcomes($year=null,$month=null)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}

		$sql = "CALL `proc_get_county_outcomes`('".$year."','".$month."')";
		
		$result = $this->db->query($sql)->result_array();

		$data['county_outcomes'][0]['name'] = 'Suspected treatment failure & greater 1000';
		$data['county_outcomes'][1]['name'] = 'Detectable & less 1000';

		$count = 0;
		
		$data["county_outcomes"][0]["data"][0]	= $count;
		$data["county_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["county_outcomes"][0]["data"][$key]	=  (int) $value['sustxfl'];
			$data["county_outcomes"][1]["data"][$key]	=  (int) $value['detectableNless1000'];
		}
		// echo "<pre>";print_r($data);
		return $data;
	}

	function vl_outcomes($year=null,$month=null)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}

		$sql = "CALL `proc_get_national_vl_outcomes`('".$year."','".$month."')";
		
		$result = $this->db->query($sql)->result_array();

		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;

		$data['vl_outcomes']['data'][0]['name'] = 'Undetected';
		$data['vl_outcomes']['data'][1]['name'] = 'less1000';
		$data['vl_outcomes']['data'][2]['name'] = 'less5000';
		$data['vl_outcomes']['data'][3]['name'] = 'above5000';

		$count = 0;

		$data['vl_outcomes']['data'][0]['y'] = $count;
		$data['vl_outcomes']['data'][1]['y'] = $count;
		$data['vl_outcomes']['data'][2]['y'] = $count;
		$data['vl_outcomes']['data'][3]['y'] = $count;

		foreach ($result as $key => $value) {
			$data['vl_outcomes']['data'][0]['y'] = (int) $value['undetected'];
			$data['vl_outcomes']['data'][1]['y'] = (int) $value['less1000'];
			$data['vl_outcomes']['data'][2]['y'] = (int) $value['less5000'];
			$data['vl_outcomes']['data'][3]['y'] = (int) $value['above5000'];
		}

		$data['vl_outcomes']['data'][3]['sliced'] = true;
		$data['vl_outcomes']['data'][3]['selected'] = true;
		
		return $data;
	}

	function justification($year=null,$month=null)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}

		$sql = "CALL `proc_get_national_justification`('".$year."','".$month."')";
		$result = $this->db->query($sql)->result_array();

		$data['justification']['name'] = 'Tests';
		$data['justification']['colorByPoint'] = true;

		$count = 0;

		$data['justification']['data'][0]['name'] = 'No Data';

		foreach ($result as $key => $value) {

			$data['justification']['data'][$key]['y'] = $count;
			
			$data['justification']['data'][$key]['name'] = $value['name'];
			$data['justification']['data'][$key]['y'] = (int) $value['justifications'];
		}

		$data['justification']['data'][0]['sliced'] = true;
		$data['justification']['data'][0]['selected'] = true;

		return $data;
	}

	function age($year=null,$month=null)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}

		$sql = "CALL `proc_get_national_age`('".$year."','".$month."')";
		$result = $this->db->query($sql)->result_array();

		$data['age']['name'] = 'Tests';
		$data['age']['colorByPoint'] = true;

		$count = 0;

		foreach ($result as $key => $value) {

			$data['age']['data'][$key]['y'] = $count;

			if ($value['name']=='0')
				$data['age']['data'][$key]['name'] = 'No Data';
			else
				$data['age']['data'][$key]['name'] = $value['name'];

			$data['age']['data'][$key]['y'] = (int) $value['agegroups'];
		}

		$data['age']['data'][0]['sliced'] = true;
		$data['age']['data'][0]['selected'] = true;

		return $data;
	}

	function gender($year=null,$month=null)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}

		$sql = "CALL `proc_get_national_gender`('".$year."','".$month."')";
		$result = $this->db->query($sql)->result_array();

		$data['gender']['name'] = 'Tests';
		$data['gender']['colorByPoint'] = true;

		$count = 0;

		foreach ($result as $key => $value) {

			$data['gender']['data'][$key]['y'] = $count;

			if ($value['name']=='F')
				$data['gender']['data'][$key]['name'] = 'Female';
			else
				$data['gender']['data'][$key]['name'] = 'Male';

			$data['gender']['data'][$key]['y'] = (int) $value['gender'];
		}

		$data['gender']['data'][0]['sliced'] = true;
		$data['gender']['data'][0]['selected'] = true;

		return $data;
	}

	function sample_types($year=null)
	{
		$array1 = array();
		$array2 = array();

		if ($year==null || $year=='null') {
			$to = $this->session->userdata('filter_year');
		}else {
			$to = $year;
		}
		$from = $to-1;

		$sql = "CALL `proc_get_national_sample_types`('".$from."','".$to."')";

		$result = $this->db->query($sql)->result_array();

		$data['sample_types'][0]['name'] = 'EDTA';
		$data['sample_types'][1]['name'] = 'DBS';
		$data['sample_types'][2]['name'] = 'Plasma';

		$count = 0;
		
		$data['categories'][0] = 'No Data';
		$data["sample_types"][0]["data"][0]	= $count;
		$data["sample_types"][1]["data"][0]	= $count;
		$data["sample_types"][2]["data"][0]	= $count;

		foreach ($result as $key => $value) {
			
				$data['categories'][$key] = $this->resolve_month($value['month']).'-'.$value['year'];

				$data["sample_types"][0]["data"][$key]	= (int) $value['edta'];
				$data["sample_types"][1]["data"][$key]	= (int) $value['dbs'];
				$data["sample_types"][2]["data"][$key]	= (int) $value['plasma'];
			
		}
		
		return $data;
	}

	

}
?>