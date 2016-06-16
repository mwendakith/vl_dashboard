<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Labs_model extends MY_Model
{
	
	function lab_testing_trends($year=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		$data['year'] = $year;

		$sql = "CALL `proc_get_labs_testing_trends`('".$year."')";

		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$categories = array();
		foreach ($result as $key => $value) {
			if (!in_array($value['labname'], $categories)) {
				$categories[] = $value['labname'];
			}
		}

		$months = array(1,2,3,4,5,6,7,8,9,10,11,12);
		$count = 0;
		foreach ($categories as $key => $value) {
			foreach ($months as $key1 => $value1) {
				foreach ($result as $key2 => $value2) {
					if ((int) $value1 == (int) $value2['month'] && $value == $value2['labname']) {
						$data['test_trends'][$key]['name'] = $value;
						$data['test_trends'][$key]['data'][$count] = (int) $value2['alltests'];
					}
				}
				$count++;
			}
			$count = 0;
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function lab_rejection_trends($year=NULL)
	{
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		$data['year'] = $year;

		$sql = "CALL `proc_get_labs_testing_trends`('".$year."')";

		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$categories = array();
		foreach ($result as $key => $value) {
			if (!in_array($value['labname'], $categories)) {
				$categories[] = $value['labname'];
			}
		}

		$months = array(1,2,3,4,5,6,7,8,9,10,11,12);
		$count = 0;
		foreach ($categories as $key => $value) {
			foreach ($months as $key1 => $value1) {
				foreach ($result as $key2 => $value2) {
					if ((int) $value1 == (int) $value2['month'] && $value == $value2['labname']) {
						$data['reject_trend'][$key]['name'] = $value;
						$data['reject_trend'][$key]['data'][$count] = (int) $value2['rejected'];
					}
				}
				$count++;
			}
			$count = 0;
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function sample_types($year=NULL,$month=NULL)
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
		
		$sql = "CALL `proc_get_labs_sampletypes`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
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
			
				$data['categories'][$key] = $value['labname'];

				$data["sample_types"][0]["data"][$key]	= (int) $value['edta'];
				$data["sample_types"][1]["data"][$key]	= (int) $value['dbs'];
				$data["sample_types"][2]["data"][$key]	= (int) $value['plasma'];
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;
	}

	function labs_turnaround($year=NULL,$month=NULL)
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

		$sql = "CALL `proc_get_labs_tat`('".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		
		foreach ($result as $key => $value) {
			$labname = strtolower(str_replace(" ", "_", $value['labname']));

			$data[$labname]['tat1'] = (int) $value['tat1'];
			$data[$labname]['tat2'] = (int) $value['tat2'] + (int) $value['tat1'];
			$data[$labname]['tat3'] = (int) $value['tat3'] + (int) $data[$labname]['tat2'];
			$data[$labname]['tat4'] = (int) $value['tat4'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function labs_outcomes($year=NULL,$month=NULL)
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

		$sql = "CALL `proc_get_lab_outcomes`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		
		$data['lab_outcomes'][0]['name'] = 'Suspected treatment failure & greater 1000';
		$data['lab_outcomes'][1]['name'] = 'Detectable & less 1000';

		$count = 0;
		
		$data["lab_outcomes"][0]["data"][0]	= $count;
		$data["lab_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['labname'];
			$data["lab_outcomes"][0]["data"][$key]	=  (int) $value['sustxfl'];
			$data["lab_outcomes"][1]["data"][$key]	=  (int) $value['detectableNless1000'];
		}
		// echo "<pre>";print_r($data);
		return $data;
	}
	
}
?>