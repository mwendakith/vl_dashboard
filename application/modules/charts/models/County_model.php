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

	function subcounty_outcomes($year=NULL,$month=NULL,$county=NULL,$to_year=null,$to_month=null)
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

		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}


		$sql = "CALL `proc_get_vl_county_subcounty_outcomes`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$data['county_outcomes'][0]['name'] = 'Not Suppresed';
		$data['county_outcomes'][1]['name'] = 'Suppresed';

		$count = 0;
		
		$data["county_outcomes"][0]["data"][0]	= $count;
		$data["county_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["county_outcomes"][0]["data"][$key]	=  (int) $value['nonsuppressed'];
			$data["county_outcomes"][1]["data"][$key]	=  (int) $value['suppressed'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;

	}

	function county_table($year=NULL,$month=NULL,$to_year=null,$to_month=null)
	{
		$table = '';
		$count = 1;
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

		$sql = "CALL `proc_get_vl_county_details`('".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($sql);die();
		foreach ($result as $key => $value) {
			$table .= '<tr>';
			$table .= '<td>'.$count.'</td>';
			// $table .= '<td>'.$value['MFLCode'].'</td>';
			// $table .= '<td>'.$value['name'].'</td>';
			$table .= '<td>'.$value['county'].'</td>';
			$table .= '<td>'.number_format($value['tests']).'</td>';
			$table .= '<td>'.number_format($value['sustxfail']).'</td>';
			$table .= '<td>'.number_format($value['confirmtx']).'</td>';
			$table .= '<td>'.number_format($value['rejected']).'</td>';
			$table .= '<td>'.number_format($value['adults']).'</td>';
			$table .= '<td>'.number_format($value['paeds']).'</td>';
			$table .= '<td>'.number_format($value['maletest']).'</td>';
			$table .= '<td>'.number_format($value['femaletest']).'</td>';
			$table .= '</tr>';
			$count++;
		}
		

		return $table;
	}

	function download_county_table($year=NULL,$month=NULL,$to_year=null,$to_month=null)
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


		$sql = "CALL `proc_get_vl_county_details`('".$year."','".$month."','".$to_year."','".$to_month."')";
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

	function county_subcounties($year=NULL,$month=NULL,$county=NULL,$to_year=null,$to_month=null)
	{
		$table = '';
		$count = 1;
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

		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}


		$sql = "CALL `proc_get_vl_subcounty_details`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($sql);die();
		foreach ($result as $key => $value) {
			$table .= '<tr>';
			$table .= '<td>'.$count.'</td>';
			// $table .= '<td>'.$value['MFLCode'].'</td>';
			// $table .= '<td>'.$value['name'].'</td>';
			$table .= '<td>'.$value['subcounty'].'</td>';
			$table .= '<td>'.number_format($value['tests']).'</td>';
			$table .= '<td>'.number_format($value['sustxfail']).'</td>';
			$table .= '<td>'.number_format($value['confirmtx']).'</td>';
			$table .= '<td>'.number_format($value['rejected']).'</td>';
			$table .= '<td>'.number_format($value['adults']).'</td>';
			$table .= '<td>'.number_format($value['paeds']).'</td>';
			$table .= '<td>'.number_format($value['maletest']).'</td>';
			$table .= '<td>'.number_format($value['femaletest']).'</td>';
			$table .= '</tr>';
			$count++;
		}
		
		return $table;
	}

	function download_subcounty_table($year=NULL,$month=NULL,$county=NULL,$to_year=null,$to_month=null)
	{
		$table = '';
		$count = 1;
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

		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}


		$sql = "CALL `proc_get_vl_subcounty_details`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

	    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('County', 'Subcounty', 'Tests', '>1000cp/ml', 'Confirm Repeat Tests', 'Rejected', 'Adult Tests', 'Peads Tests', 'Male', 'Female');

	    fputcsv($f, $b, $delimiter);

	    foreach ($result as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="vl_counties_subcounties.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
		
	}

	function county_partners($year=NULL,$month=NULL,$county=NULL,$to_year=null,$to_month=null)
	{
		$table = '';
		$count = 1;
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

		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}


		$sql = "CALL `proc_get_vl_county_partners`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($sql);die();
		foreach ($result as $key => $value) {
			if ($value['partner'] == NULL || $value['partner'] == 'NULL') {
				$value['partner'] = 'No Partner';
			}
			$table .= '<tr>';
			$table .= '<td>'.$count.'</td>';
			// $table .= '<td>'.$value['MFLCode'].'</td>';
			// $table .= '<td>'.$value['name'].'</td>';
			$table .= '<td>'.$value['partner'].'</td>';
			$table .= '<td>'.number_format($value['tests']).'</td>';
			$table .= '<td>'.number_format($value['sustxfail']).'</td>';
			$table .= '<td>'.number_format($value['confirmtx']).'</td>';
			$table .= '<td>'.number_format($value['rejected']).'</td>';
			$table .= '<td>'.number_format($value['adults']).'</td>';
			$table .= '<td>'.number_format($value['paeds']).'</td>';
			$table .= '<td>'.number_format($value['maletest']).'</td>';
			$table .= '<td>'.number_format($value['femaletest']).'</td>';
			$table .= '</tr>';
			$count++;
		}
		
		return $table;
	}

	function download_partners_county_table($year=NULL,$month=NULL,$county=NULL,$to_year=null,$to_month=null)
	{
		$table = '';
		$count = 1;
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

		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}


		$sql = "CALL `proc_get_vl_county_partners`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

	    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('County', 'Partner', 'Tests', '>1000cp/ml', 'Confirm Repeat Tests', 'Rejected', 'Adult Tests', 'Peads Tests', 'Male', 'Female');

	    fputcsv($f, $b, $delimiter);

	    foreach ($result as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="vl_counties_subcounties.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
		
	}

}