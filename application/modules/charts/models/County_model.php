<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class County_model extends MY_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function county_table($year=NULL,$month=NULL)
	{
		$table = '';
		$count = 1;
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		$sql = "CALL `proc_get_vl_county_details`('".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($sql);die();
		foreach ($result as $key => $value) {
			$table .= '<tr>';
			$table .= '<td>'.$count.'</td>';
			// $table .= '<td>'.$value['MFLCode'].'</td>';
			// $table .= '<td>'.$value['name'].'</td>';
			$table .= '<td>'.$value['county'].'</td>';
			$table .= '<td>'.$value['tests'].'</td>';
			$table .= '<td>'.$value['sustxfail'].'</td>';
			$table .= '<td>'.$value['confirmtx'].'</td>';
			$table .= '<td>'.$value['rejected'].'</td>';
			$table .= '<td>'.$value['adults'].'</td>';
			$table .= '<td>'.$value['paeds'].'</td>';
			$table .= '<td>'.$value['maletest'].'</td>';
			$table .= '<td>'.$value['femaletest'].'</td>';
			$table .= '</tr>';
			$count++;
		}
		

		return $table;
	}

	function download_county_table($year=NULL,$month=NULL)
	{
		
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}


		$sql = "CALL `proc_get_vl_county_details`('".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($sql);die();

		$this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

	    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('County', 'Tests', '>1000cp/ml', 'Confirm Repeat Tests', 'Rejected', 'Adult Tests', 'Peads Tests', 'Male', 'Female');

	    fputcsv($f, $b, $delimiter);

	    foreach ($result as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="vl_counties_summary.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
	}

	function subcounty_table($year=NULL,$month=NULL)
	{
		$table = '';
		$count = 1;
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}


		$sql = "CALL `proc_get_vl_county_details`('".$county."','".$year."','".$month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($sql);die();
		foreach ($result as $key => $value) {
			$table .= '<tr>';
			$table .= '<td>'.$count.'</td>';
			// $table .= '<td>'.$value['MFLCode'].'</td>';
			// $table .= '<td>'.$value['name'].'</td>';
			$table .= '<td>'.$value['county'].'</td>';
			$table .= '<td>'.$value['tests'].'</td>';
			$table .= '<td>'.$value['sustxfail'].'</td>';
			$table .= '<td>'.$value['confirmtx'].'</td>';
			$table .= '<td>'.$value['rejected'].'</td>';
			$table .= '<td>'.$value['adults'].'</td>';
			$table .= '<td>'.$value['paeds'].'</td>';
			$table .= '<td>'.$value['maletest'].'</td>';
			$table .= '<td>'.$value['femaletest'].'</td>';
			$table .= '</tr>';
			$count++;
		}
		

		return $table;
	}

}