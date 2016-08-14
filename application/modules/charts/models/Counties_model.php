<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Counties_model extends MY_Model
{
	function __construct()
	{
		parent:: __construct();;
	}

	function country_tests($year=NULL,$month=NULL)
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
		
		$sql = "CALL `proc_get_county_suppression`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			
				$data[$value['id']]['id'] = $value['id'];
				
				$data[$value['id']]['value'] = $value['tests'];
				
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;

	}

	function country_suppression($year=NULL,$month=NULL)
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
		
		$sql = "CALL `proc_get_county_suppression`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			
				$data[$value['id']]['id'] = $value['id'];
				if($value['tests'] == 0){
					$data[$value['id']]['value'] = 0;
				}
				else{
					$data[$value['id']]['value'] = round((int) $value['suppressed'] / $value['tests'] * 100);
				}
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;

	}

	function country_non_suppression($year=NULL,$month=NULL)
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
		
		$sql = "CALL `proc_get_county_non_suppression`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			
				$data[$value['id']]['id'] = $value['id'];
				if($value['tests'] == 0){
					$data[$value['id']]['value'] = 0;
				}
				else{
					$data[$value['id']]['value'] = 
					round((int) $value['non_suppressed'] / $value['tests'] * 100);
				}
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;

	}

	function country_rejects($year=NULL,$month=NULL)
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
		
		$sql = "CALL `proc_get_county_rejected`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			
				$data[$value['id']]['id'] = $value['id'];
				if($value['tests'] == 0){
					$data[$value['id']]['value'] = 0;
				}
				else{
					$data[$value['id']]['value'] = round((int) $value['rejected'] / $value['tests'] * 100);
				}
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;

	}

	function country_pregnant($year=NULL,$month=NULL)
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
		
		$sql = "CALL `proc_get_county_pregnant_women`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			
				$data[$value['id']]['id'] = $value['id'];
				
				$data[$value['id']]['value'] = $value['tests'];
				
				
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;

	}

	function country_lactating($year=NULL,$month=NULL)
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
		
		$sql = "CALL `proc_get_county_lactating_women`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data;
		foreach ($result as $key => $value) {
			
				$data[$value['id']]['id'] = $value['id'];
				
				$data[$value['id']]['value'] = $value['tests'];
				
				
			
		}
		 // echo "<pre>";print_r($data);die();
		return $data;

	}		

	function county_details($county=NULL,$year=NULL,$month=NULL)
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
		
		$sql = "CALL `proc_get_county_partner_details`('".$county."','".$year."','".$month."')";

		$result = $this->db->query($sql)->result_array();
		
		return $result;
	}
	
	
}
?>