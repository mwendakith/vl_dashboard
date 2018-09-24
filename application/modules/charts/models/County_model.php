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

		$data['county_outcomes'][0]['name'] = 'Not Suppressed';
		$data['county_outcomes'][1]['name'] = 'Suppressed';

		$count = 0;
		
		$data["county_outcomes"][0]["data"][0]	= $count;
		$data["county_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

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


		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["county_outcomes"][0]["data"][$key]	=  (int) $value['nonsuppressed'];
			$data["county_outcomes"][1]["data"][$key]	=  (int) $value['suppressed'];
			
			$data['outcomes'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$key] = (int) $value['suppressed'];
			$data['outcomes'][2]['data'][$key] = round(@(((int) $value['suppressed']*100)/((int) $value['suppressed']+(int) $value['nonsuppressed'])),1);
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
		$type = 0;
		$default = 0;
		$sql = "CALL `proc_get_vl_county_details`('".$year."','".$month."','".$to_year."','".$to_month."')";
		$sqlAge = "CALL `proc_get_vl_county_agecategories_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$default."');";
		$sqlGender = "CALL `proc_get_vl_county_gender_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$default."');";
		// echo "<pre>";print_r($sqlAge);die();
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		$resultage = $this->db->query($sqlAge)->result();
		$this->db->close();
		$resultGender = $this->db->query($sqlGender)->result();
		// echo "<pre>";print_r($resultage);die();
		$counties = [];
		$ageData = [];
		$genderData = [];
		foreach ($resultage as $key => $value) {
			if (!in_array($value->selection, $counties))
				$counties[] = $value->selection;
		}
		foreach ($counties as $key => $value) {
			foreach ($resultGender as $k => $v) {
				if ($value == $v->selection) {
					$genderData[$key]['selection'] = $v->selection;
					if ($v->name == 'F'){
						$genderData[$key]['femaletests'] = $v->tests;
						$genderData[$key]['femalesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'M'){
						$genderData[$key]['maletests'] = $v->tests;
						$genderData[$key]['malesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'No Data'){
						$genderData[$key]['Nodatatests'] = $v->tests;
						$genderData[$key]['Nodatasustx'] = ($v->less5000+$v->above5000);
					}
				}
			}
		}
		foreach ($counties as $key => $value) {
			foreach ($resultage as $k => $v) {
				if ($value == $v->selection) {
					$ageData[$key]['selection'] = $v->selection;
					if ($v->name == '15-19') {
						$ageData[$key]['less19tests'] = $v->tests;
						$ageData[$key]['less19sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '10-14') {
						$ageData[$key]['less14tests'] = $v->tests;
						$ageData[$key]['less14sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == 'Less 2') {
						$ageData[$key]['less2tests'] = $v->tests;
						$ageData[$key]['less2sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '2-9') {
						$ageData[$key]['less9tests'] = $v->tests;
						$ageData[$key]['less9sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '20-24') {
						$ageData[$key]['less25tests'] = $v->tests;
						$ageData[$key]['less25sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '25+') {
						$ageData[$key]['above25tests'] = $v->tests;
						$ageData[$key]['above25sustx'] = ($v->less5000+$v->above5000);	
					}
				}
			}
		}
		// echo "<pre>";print_r($ageData);die();
		foreach ($result as $key => $value) {
			$routine = ((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000']);
			$routinesus = ((int) $value['less5000'] + (int) $value['above5000']);
			$table .= "<tr>
						<td>".($key+1)."</td>
						<td>".$value['county']."</td>
						<td>".number_format((int) $value['sitesending'])."</td>
						<td>".number_format((int) $value['received'])."</td>
						<td>".number_format((int) $value['rejected']) . " (" . 
							round((($value['rejected']*100)/$value['received']), 1, PHP_ROUND_HALF_UP)."%)</td>
						<td>".number_format((int) $value['alltests'])."</td>
						<td>".number_format((int) $value['invalids'])."</td>
						<td>".number_format($routine)."</td>
						<td>".number_format($routinesus)."</td>
						<td>".number_format((int) $value['baseline'])."</td>
						<td>".number_format((int) $value['baselinesustxfail'])."</td>
						<td>".number_format((int) $value['confirmtx'])."</td>
						<td>".number_format((int) $value['confirm2vl'])."</td>
						<td>".number_format((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx'])."</td>
						<td>".number_format((int) $routinesus + (int) $value['baselinesustxfail'] + (int) $value['confirm2vl'])."</td>";
			foreach ($genderData as $k => $v) {
				if ($value['county'] == $v['selection']) {
					$table .= "
							<td>".number_format((int) $v['femaletests'])."</td>
							<td>".number_format((int) $v['femalesustx'])."</td>
							<td>".number_format((int) $v['maletests'])."</td>
							<td>".number_format((int) $v['malesustx'])."</td>
							<td>".number_format((int) $v['Nodatatests'])."</td>
							<td>".number_format((int) $v['Nodatasustx'])."</td>";
				}
			}
			foreach ($ageData as $k => $v) {
				if ($value['county'] == $v['selection']) {
					$table .= "
							<td>".number_format((int) $v['less2tests'])."</td>
							<td>".number_format((int) $v['less2sustx'])."</td>
							<td>".number_format((int) $v['less9tests'])."</td>
							<td>".number_format((int) $v['less9sustx'])."</td>
							<td>".number_format((int) $v['less14tests'])."</td>
							<td>".number_format((int) $v['less14sustx'])."</td>
							<td>".number_format((int) $v['less19tests'])."</td>
							<td>".number_format((int) $v['less19sustx'])."</td>
							<td>".number_format((int) $v['less25tests'])."</td>
							<td>".number_format((int) $v['less25sustx'])."</td>
							<td>".number_format((int) $v['above25tests'])."</td>
							<td>".number_format((int) $v['above25sustx'])."</td>";
				}
			}
			$table .= "</tr>";
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

	    $b = array('County', 'Facilities Sending Samples', 'Received', 'Rejected', 'All Tests', 'Redraws', 'Undetected', 'less1000', 'above1000 - less5000', 'above5000', 'Baseline Tests', 'Baseline >1000', 'Confirmatory Tests', 'Confirmatory >1000');

	    fputcsv($f, $b, $delimiter);

	    foreach ($result as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="'.Date('Ymd H:i:s').'vl_counties_summary.csv";');
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

		$type = 2;
		$sql = "CALL `proc_get_vl_subcounty_details`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		$sqlAge = "CALL `proc_get_vl_county_agecategories_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$county."');";
		$sqlGender = "CALL `proc_get_vl_county_gender_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$county."');";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		$resultage = $this->db->query($sqlAge)->result();
		$this->db->close();
		$resultGender = $this->db->query($sqlGender)->result();
		// echo "<pre>";print_r($resultage);die();
		$counties = [];
		$ageData = [];
		$genderData = [];
		foreach ($resultage as $key => $value) {
			if (!in_array($value->selection, $counties))
				$counties[] = $value->selection;
		}
		
		foreach ($counties as $key => $value) {
			foreach ($resultGender as $k => $v) {
				if ($value == $v->selection) {
					$genderData[$key]['selection'] = $v->selection;
					if ($v->name == 'F'){
						$genderData[$key]['femaletests'] = $v->tests;
						$genderData[$key]['femalesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'M'){
						$genderData[$key]['maletests'] = $v->tests;
						$genderData[$key]['malesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'No Data'){
						$genderData[$key]['Nodatatests'] = $v->tests;
						$genderData[$key]['Nodatasustx'] = ($v->less5000+$v->above5000);
					}
				}
			}
		}
		foreach ($counties as $key => $value) {
			foreach ($resultage as $k => $v) {
				if ($value == $v->selection) {
					$ageData[$key]['selection'] = $v->selection;
					if ($v->name == '15-19') {
						$ageData[$key]['less19tests'] = $v->tests;
						$ageData[$key]['less19sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '10-14') {
						$ageData[$key]['less14tests'] = $v->tests;
						$ageData[$key]['less14sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == 'Less 2') {
						$ageData[$key]['less2tests'] = $v->tests;
						$ageData[$key]['less2sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '2-9') {
						$ageData[$key]['less9tests'] = $v->tests;
						$ageData[$key]['less9sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '20-24') {
						$ageData[$key]['less25tests'] = $v->tests;
						$ageData[$key]['less25sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '25+') {
						$ageData[$key]['above25tests'] = $v->tests;
						$ageData[$key]['above25sustx'] = ($v->less5000+$v->above5000);	
					}
				}
			}
		}
		// echo "<pre>";print_r($sql);die();
		foreach ($result as $key => $value) {
			$routine = ((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000']);
			$routinesus = ((int) $value['less5000'] + (int) $value['above5000']);
			$table .= "<tr>
						<td>".($key+1)."</td>
						<td>".$value['subcounty']."</td>
						<td>".number_format((int) $value['sitesending'])."</td>
						<td>".number_format((int) $value['received'])."</td>
						<td>".number_format((int) $value['rejected']) . " (" . 
							round(@(($value['rejected']*100)/$value['received']), 1, PHP_ROUND_HALF_UP)."%)</td>
						<td>".number_format((int) $value['alltests'])."</td>
						<td>".number_format((int) $value['invalids'])."</td>

						<td>".number_format($routine)."</td>
						<td>".number_format($routinesus)."</td>
						<td>".number_format((int) $value['baseline'])."</td>
						<td>".number_format((int) $value['baselinesustxfail'])."</td>
						<td>".number_format((int) $value['confirmtx'])."</td>
						<td>".number_format((int) $value['confirm2vl'])."</td>
						<td>".number_format((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx'])."</td>
						<td>".number_format((int) $routinesus + (int) $value['baselinesustxfail'] + (int) $value['confirm2vl'])."</td>";
					foreach ($genderData as $k => $v) {
						if ($value['subcounty_id'] == $v['selection']) {
							$table .= "
									<td>".number_format((int) $v['femaletests'])."</td>
									<td>".number_format((int) $v['femalesustx'])."</td>
									<td>".number_format((int) $v['maletests'])."</td>
									<td>".number_format((int) $v['malesustx'])."</td>
									<td>".number_format((int) $v['Nodatatests'])."</td>
									<td>".number_format((int) $v['Nodatasustx'])."</td>";
						}
					}
					foreach ($ageData as $k => $v) {
						if ($value['subcounty'] == $v['selection']) {
							$table .= "
									<td>".number_format((int) $v['less2tests'])."</td>
									<td>".number_format((int) $v['less2sustx'])."</td>
									<td>".number_format((int) $v['less9tests'])."</td>
									<td>".number_format((int) $v['less9sustx'])."</td>
									<td>".number_format((int) $v['less14tests'])."</td>
									<td>".number_format((int) $v['less14sustx'])."</td>
									<td>".number_format((int) $v['less19tests'])."</td>
									<td>".number_format((int) $v['less19sustx'])."</td>
									<td>".number_format((int) $v['less25tests'])."</td>
									<td>".number_format((int) $v['less25sustx'])."</td>
									<td>".number_format((int) $v['above25tests'])."</td>
									<td>".number_format((int) $v['above25sustx'])."</td>";
						}
					}
						
					$table .= "</tr>";
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

	    $b = array('County', 'Subcounty', 'Facilities Sending Samples', 'Received', 'Rejected', 'All Tests', 'Redraws', 'Undetected', 'less1000', 'above1000 - less5000', 'above5000', 'Baseline Tests', 'Baseline >1000', 'Confirmatory Tests', 'Confirmatory >1000');

	    fputcsv($f, $b, $delimiter);

	    foreach ($result as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="'.Date('Ymd H:i:s').'vl_counties_subcounties.csv";');
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

		$type = 1;
		$sql = "CALL `proc_get_vl_county_partners`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		$sqlAge = "CALL `proc_get_vl_county_agecategories_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$county."');";
		$sqlGender = "CALL `proc_get_vl_county_gender_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$county."');";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		$resultage = $this->db->query($sqlAge)->result();
		$this->db->close();
		$resultGender = $this->db->query($sqlGender)->result();
		// echo "<pre>";print_r($resultage);die();
		$counties = [];
		$ageData = [];
		$genderData = [];
		$data = [];
		foreach ($resultage as $key => $value) {
			if (!in_array($value->selection, $counties))
				$counties[] = $value->selection;
		}
		foreach ($counties as $key => $value) {
			foreach ($resultGender as $k => $v) {
				if ($value == $v->selection) {
					$genderData[$key]['selection'] = $v->selection;
					if ($v->name == 'F'){
						$genderData[$key]['femaletests'] = $v->tests;
						$genderData[$key]['femalesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'M'){
						$genderData[$key]['maletests'] = $v->tests;
						$genderData[$key]['malesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'No Data'){
						$genderData[$key]['Nodatatests'] = $v->tests;
						$genderData[$key]['Nodatasustx'] = ($v->less5000+$v->above5000);
					}
				}
			}
		}
		foreach ($counties as $key => $value) {
			foreach ($resultage as $k => $v) {
				if ($value == $v->selection) {
					$ageData[$key]['selection'] = $v->selection;
					if ($v->name == '15-19') {
						$ageData[$key]['less19tests'] = $v->tests;
						$ageData[$key]['less19sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '10-14') {
						$ageData[$key]['less14tests'] = $v->tests;
						$ageData[$key]['less14sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == 'Less 2') {
						$ageData[$key]['less2tests'] = $v->tests;
						$ageData[$key]['less2sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '2-9') {
						$ageData[$key]['less9tests'] = $v->tests;
						$ageData[$key]['less9sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '20-24') {
						$ageData[$key]['less25tests'] = $v->tests;
						$ageData[$key]['less25sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '25+') {
						$ageData[$key]['above25tests'] = $v->tests;
						$ageData[$key]['above25sustx'] = ($v->less5000+$v->above5000);	
					}
				}
			}
		}
		foreach ($result as $key => $value) {
			$data[$key] = $value;
			foreach ($genderData as $k => $v) {
				$data[$key] = array_merge($data[$key], $v);
			}
			foreach ($ageData as $k => $v) {
				$data[$key] = array_merge($data[$key], $v);
			}
		}
		// echo "<pre>";print_r($sql);die();
		foreach ($data as $key => $value) {
			if ($value['partner'] == NULL || $value['partner'] == 'NULL') {
				$value['partner'] = 'No Partner';
			}
			$routine = ((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000']);
			$routinesus = ((int) $value['less5000'] + (int) $value['above5000']);
			$table .= "<tr>
						<td>".($key+1)."</td>
						<td>".$value['partner']."</td>
						<td>".number_format((int) $value['received'])."</td>
						<td>".number_format((int) $value['rejected']) . " (" . 
							round(@(($value['rejected']*100)/$value['received']), 1, PHP_ROUND_HALF_UP)."%)</td>
						<td>".number_format((int) $value['alltests'])."</td>
						<td>".number_format((int) $value['invalids'])."</td>

						<td>".number_format($routine)."</td>
						<td>".number_format($routinesus)."</td>
						<td>".number_format((int) $value['baseline'])."</td>
						<td>".number_format((int) $value['baselinesustxfail'])."</td>
						<td>".number_format((int) $value['confirmtx'])."</td>
						<td>".number_format((int) $value['confirm2vl'])."</td>
						<td>".number_format((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx'])."</td>
						<td>".number_format((int) $routinesus + (int) $value['baselinesustxfail'] + (int) $value['confirm2vl'])."</td>
						<td>".number_format((int) @$value['femaletests'])."</td>
						<td>".number_format((int) @$value['femalesustx'])."</td>
						<td>".number_format((int) @$value['maletests'])."</td>
						<td>".number_format((int) @$value['malesustx'])."</td>
						<td>".number_format((int) @$value['Nodatatests'])."</td>
						<td>".number_format((int) @$value['Nodatasustx'])."</td>
						<td>".number_format((int) @$value['less2tests'])."</td>
						<td>".number_format((int) @$value['less2sustx'])."</td>
						<td>".number_format((int) @$value['less9tests'])."</td>
						<td>".number_format((int) @$value['less9sustx'])."</td>
						<td>".number_format((int) @$value['less14tests'])."</td>
						<td>".number_format((int) @$value['less14sustx'])."</td>
						<td>".number_format((int) @$value['less19tests'])."</td>
						<td>".number_format((int) @$value['less19sustx'])."</td>
						<td>".number_format((int) @$value['less25tests'])."</td>
						<td>".number_format((int) @$value['less25sustx'])."</td>
						<td>".number_format((int) @$value['above25tests'])."</td>
						<td>".number_format((int) @$value['above25sustx'])."</td>";
						
					$table .= "</tr>";
			$count++;
		}
		
		return $table;
	}

	function county_facilities($year=NULL,$month=NULL,$county=NULL,$to_year=null,$to_month=null)
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

		$type = 1;
		$type2 = 3;
		$sql = "CALL `proc_get_vl_sites_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$county."')";
		$sqlAge = "CALL `proc_get_vl_county_agecategories_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type2."','".$county."');";
		$sqlGender = "CALL `proc_get_vl_county_gender_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type2."','".$county."');";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		$resultage = $this->db->query($sqlAge)->result();
		$this->db->close();
		$resultGender = $this->db->query($sqlGender)->result();
		// echo "<pre>";print_r($resultage);die();
		$counties = [];
		$ageData = [];
		$genderData = [];
		$data = [];
		foreach ($resultage as $key => $value) {
			if (!in_array($value->selection, $counties))
				$counties[] = $value->selection;
		}
		foreach ($counties as $key => $value) {
			foreach ($resultGender as $k => $v) {
				if ($value == $v->selection) {
					$genderData[$key]['selection'] = $v->selection;
					if ($v->name == 'F'){
						$genderData[$key]['femaletests'] = $v->tests;
						$genderData[$key]['femalesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'M'){
						$genderData[$key]['maletests'] = $v->tests;
						$genderData[$key]['malesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'No Data'){
						$genderData[$key]['Nodatatests'] = $v->tests;
						$genderData[$key]['Nodatasustx'] = ($v->less5000+$v->above5000);
					}
				}
			}
		}
		foreach ($counties as $key => $value) {
			foreach ($resultage as $k => $v) {
				if ($value == $v->selection) {
					$ageData[$key]['selection'] = $v->selection;
					if ($v->name == '15-19') {
						$ageData[$key]['less19tests'] = $v->tests;
						$ageData[$key]['less19sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '10-14') {
						$ageData[$key]['less14tests'] = $v->tests;
						$ageData[$key]['less14sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == 'Less 2') {
						$ageData[$key]['less2tests'] = $v->tests;
						$ageData[$key]['less2sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '2-9') {
						$ageData[$key]['less9tests'] = $v->tests;
						$ageData[$key]['less9sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '20-24') {
						$ageData[$key]['less25tests'] = $v->tests;
						$ageData[$key]['less25sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '25+') {
						$ageData[$key]['above25tests'] = $v->tests;
						$ageData[$key]['above25sustx'] = ($v->less5000+$v->above5000);	
					}
				}
			}
		}
		foreach ($result as $key => $value) {
			$data[$key] = $value;
			foreach ($genderData as $k => $v) {
				$data[$key] = array_merge($data[$key], $v);
			}
			foreach ($ageData as $k => $v) {
				$data[$key] = array_merge($data[$key], $v);
			}
		}

		foreach ($data as $key => $value) {
			$routine = ((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000']);
			$routinesus = ((int) $value['less5000'] + (int) $value['above5000']);
			$table .= "<tr>
						<td>".($key+1)."</td>
						<td>".$value['facility']."</td>
						<td>".$value['facilitycode']."</td>
						<td>".$value['subcounty']."</td>
						<td>".number_format((int) $value['received'])."</td>
						<td>".number_format((int) $value['rejected']) . " (" . 
							round(@(($value['rejected']*100)/$value['received']), 1, PHP_ROUND_HALF_UP)."%)</td>
						<td>".number_format((int) $value['alltests'])."</td>
						<td>".number_format((int) $value['invalids'])."</td>
						<td>".number_format($routine)."</td>
						<td>".number_format($routinesus)."</td>
						<td>".number_format((int) $value['baseline'])."</td>
						<td>".number_format((int) $value['baselinesustxfail'])."</td>
						<td>".number_format((int) $value['confirmtx'])."</td>
						<td>".number_format((int) $value['confirm2vl'])."</td>
						<td>".number_format((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx'])."</td>
						<td>".number_format((int) $routinesus + (int) $value['baselinesustxfail'] + (int) $value['confirm2vl'])."</td>
						<td>".number_format((int) @$value['femaletests'])."</td>
						<td>".number_format((int) @$value['femalesustx'])."</td>
						<td>".number_format((int) @$value['maletests'])."</td>
						<td>".number_format((int) @$value['malesustx'])."</td>
						<td>".number_format((int) @$value['Nodatatests'])."</td>
						<td>".number_format((int) @$value['Nodatasustx'])."</td>
						<td>".number_format((int) @$value['less2tests'])."</td>
						<td>".number_format((int) @$value['less2sustx'])."</td>
						<td>".number_format((int) @$value['less9tests'])."</td>
						<td>".number_format((int) @$value['less9sustx'])."</td>
						<td>".number_format((int) @$value['less14tests'])."</td>
						<td>".number_format((int) @$value['less14sustx'])."</td>
						<td>".number_format((int) @$value['less19tests'])."</td>
						<td>".number_format((int) @$value['less19sustx'])."</td>
						<td>".number_format((int) @$value['less25tests'])."</td>
						<td>".number_format((int) @$value['less25sustx'])."</td>
						<td>".number_format((int) @$value['above25tests'])."</td>
						<td>".number_format((int) @$value['above25sustx'])."</td>";
					$table .= "</tr>";
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

	    $b = array('County', 'Partner', 'Facilities Sending Samples', 'Received', 'Rejected', 'All Tests', 'Redraws', 'Undetected', 'less1000', 'above1000 - less5000', 'above5000', 'Baseline Tests', 'Baseline >1000', 'Confirmatory Tests', 'Confirmatory >1000');

	    fputcsv($f, $b, $delimiter);

	    foreach ($result as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="'.Date('Ymd H:i:s').'vl_county_partners.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
		
	}
}