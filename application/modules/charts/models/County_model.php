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
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county]);
		extract($d);


		$sql = "CALL `proc_get_vl_county_subcounty_outcomes`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		
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
		$d = $this->extract_variables($year, $month, $to_year, $to_month);
		extract($d);
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
					$genderData[$value]['selection'] = $v->selection;
					if ($v->name == 'F'){
						$genderData[$value]['femaletests'] = $v->tests;
						$genderData[$value]['femalesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'M'){
						$genderData[$value]['maletests'] = $v->tests;
						$genderData[$value]['malesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'No Data'){
						$genderData[$value]['Nodatatests'] = $v->tests;
						$genderData[$value]['Nodatasustx'] = ($v->less5000+$v->above5000);
					}
				}
			}
		}
		foreach ($counties as $key => $value) {
			foreach ($resultage as $k => $v) {
				if ($value == $v->selection) {
					$ageData[$value]['selection'] = $v->selection;
					if ($v->name == '15-19') {
						$ageData[$value]['less19tests'] = $v->tests;
						$ageData[$value]['less19sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '10-14') {
						$ageData[$value]['less14tests'] = $v->tests;
						$ageData[$value]['less14sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == 'Less 2') {
						$ageData[$value]['less2tests'] = $v->tests;
						$ageData[$value]['less2sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '2-9') {
						$ageData[$value]['less9tests'] = $v->tests;
						$ageData[$value]['less9sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '20-24') {
						$ageData[$value]['less25tests'] = $v->tests;
						$ageData[$value]['less25sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '25+') {
						$ageData[$value]['above25tests'] = $v->tests;
						$ageData[$value]['above25sustx'] = ($v->less5000+$v->above5000);	
					}
				}
			}
		}
		// echo "<pre>";print_r($ageData);die();
		foreach ($result as $key => $value) {
			$routine = ((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000']);
			$routinesus = ((int) $value['less5000'] + (int) $value['above5000']);
			$validTests = ((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx']);
			$femaletests = ($genderData[$value['county']]['femaletests']) ? number_format((int) $genderData[$value['county']]['femaletests']) : 0;
			$femalesustx = ($genderData[$value['county']]['femalesustx']) ? number_format((int) $genderData[$value['county']]['femalesustx']) : 0;
			$maletests = ($genderData[$value['county']]['maletests']) ? number_format((int) $genderData[$value['county']]['maletests']) : 0;
			$malesustx = ($genderData[$value['county']]['malesustx']) ? number_format((int) $genderData[$value['county']]['malesustx']) : 0;
			$Nodatatests = ($genderData[$value['county']]['Nodatatests']) ? number_format((int) $genderData[$value['county']]['Nodatatests']) : 0;
			$Nodatasustx = ($genderData[$value['county']]['Nodatasustx']) ? number_format((int) $genderData[$value['county']]['Nodatasustx']) : 0;
			$less2tests = ($ageData[$value['county']]['less2tests']) ? number_format($ageData[$value['county']]['less2tests']) : 0;
			$less2sustx = ($ageData[$value['county']]['less2sustx']) ? number_format($ageData[$value['county']]['less2sustx']) : 0;
			$less9tests = ($ageData[$value['county']]['less9tests']) ? number_format($ageData[$value['county']]['less9tests']) : 0;
			$less9sustx = ($ageData[$value['county']]['less9sustx']) ? number_format($ageData[$value['county']]['less9sustx']) : 0;
			$less14tests = ($ageData[$value['county']]['less14tests']) ? number_format($ageData[$value['county']]['less14tests']) : 0;
			$less14sustx = ($ageData[$value['county']]['less14sustx']) ? number_format($ageData[$value['county']]['less14sustx']) : 0;
			$less19tests = ($ageData[$value['county']]['less19tests']) ? number_format($ageData[$value['county']]['less19tests']) : 0;
			$less19sustx = ($ageData[$value['county']]['less19sustx']) ? number_format($ageData[$value['county']]['less19sustx']) : 0;
			$less25tests = ($ageData[$value['county']]['less25tests']) ? number_format($ageData[$value['county']]['less25tests']) : 0;
			$less25sustx = ($ageData[$value['county']]['less25sustx']) ? number_format($ageData[$value['county']]['less25sustx']) : 0;
			$above25tests = ($ageData[$value['county']]['above25tests']) ? number_format($ageData[$value['county']]['above25tests']) : 0;
			$above25sustx = ($ageData[$value['county']]['above25sustx']) ? number_format($ageData[$value['county']]['above25sustx']) : 0;
			$table .= "<tr>
						<td>".($key+1)."</td>
						<td>".$value['county']."</td>
						<td>".number_format((int) $value['sitesending'])."</td>
						<td>".number_format((int) $value['received'])."</td>
						<td>".number_format((int) $value['rejected']) . " (" . 
							round((($value['rejected']*100)/$value['received']), 1, PHP_ROUND_HALF_UP)."%)</td>
						<td>".number_format((int) $validTests + (int) $value['invalids'])."</td>
						<td>".number_format((int) $value['invalids'])."</td>
						<td>".number_format($routine)."</td>
						<td>".number_format($routinesus)."</td>
						<td>".number_format((int) $value['baseline'])."</td>
						<td>".number_format((int) $value['baselinesustxfail'])."</td>
						<td>".number_format((int) $value['confirmtx'])."</td>
						<td>".number_format((int) $value['confirm2vl'])."</td>
						<td>".number_format($validTests)."</td>
						<td>".number_format((int) $routinesus + (int) $value['baselinesustxfail'] + (int) $value['confirm2vl'])."</td>
						<td>".$femaletests."</td>
						<td>".$femalesustx."</td>
						<td>".$maletests."</td>
						<td>".$malesustx."</td>
						<td>".$Nodatatests."</td>
						<td>".$Nodatasustx."</td>
						<td>".$less2tests."</td>
						<td>".$less2sustx."</td>
						<td>".$less9tests."</td>
						<td>".$less9sustx."</td>
						<td>".$less14tests."</td>
						<td>".$less14sustx."</td>
						<td>".$less19tests."</td>
						<td>".$less19sustx."</td>
						<td>".$less25tests."</td>
						<td>".$less25sustx."</td>
						<td>".$above25tests."</td>
						<td>".$above25sustx."</td>";
			
			$table .= "</tr>";
			$count++;
		}
		
		// echo $table;die();
		return $table;
	}

	function download_county_table($year=NULL,$month=NULL,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month);
		extract($d);

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
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county]);
		extract($d);

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
					$genderData[$value]['selection'] = $v->selection;
					if ($v->name == 'F'){
						$genderData[$value]['femaletests'] = $v->tests;
						$genderData[$value]['femalesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'M'){
						$genderData[$value]['maletests'] = $v->tests;
						$genderData[$value]['malesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'No Data'){
						$genderData[$value]['Nodatatests'] = $v->tests;
						$genderData[$value]['Nodatasustx'] = ($v->less5000+$v->above5000);
					}
				}
			}
		}
		foreach ($counties as $key => $value) {
			foreach ($resultage as $k => $v) {
				if ($value == $v->selection) {
					$ageData[$value]['selection'] = $v->selection;
					if ($v->name == '15-19') {
						$ageData[$value]['less19tests'] = $v->tests;
						$ageData[$value]['less19sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '10-14') {
						$ageData[$value]['less14tests'] = $v->tests;
						$ageData[$value]['less14sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == 'Less 2') {
						$ageData[$value]['less2tests'] = $v->tests;
						$ageData[$value]['less2sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '2-9') {
						$ageData[$value]['less9tests'] = $v->tests;
						$ageData[$value]['less9sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '20-24') {
						$ageData[$value]['less25tests'] = $v->tests;
						$ageData[$value]['less25sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '25+') {
						$ageData[$value]['above25tests'] = $v->tests;
						$ageData[$value]['above25sustx'] = ($v->less5000+$v->above5000);	
					}
				}
			}
		}
		// echo "<pre>";print_r($sql);die();
		foreach ($result as $key => $value) {
			$routine = ((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000']);
			$routinesus = ((int) $value['less5000'] + (int) $value['above5000']);
			$validTests = ((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx']);
			$routine = ((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000']);
			$routinesus = ((int) $value['less5000'] + (int) $value['above5000']);
			$validTests = ((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx']);
			$femaletests = ($genderData[$value['subcounty_id']]['femaletests']) ? number_format((int) $genderData[$value['subcounty_id']]['femaletests']) : 0;
			$femalesustx = ($genderData[$value['subcounty_id']]['femalesustx']) ? number_format((int) $genderData[$value['subcounty_id']]['femalesustx']) : 0;
			$maletests = ($genderData[$value['subcounty_id']]['maletests']) ? number_format((int) $genderData[$value['subcounty_id']]['maletests']) : 0;
			$malesustx = ($genderData[$value['subcounty_id']]['malesustx']) ? number_format((int) $genderData[$value['subcounty_id']]['malesustx']) : 0;
			$Nodatatests = ($genderData[$value['subcounty_id']]['Nodatatests']) ? number_format((int) $genderData[$value['subcounty_id']]['Nodatatests']) : 0;
			$Nodatasustx = ($genderData[$value['subcounty_id']]['Nodatasustx']) ? number_format((int) $genderData[$value['subcounty_id']]['Nodatasustx']) : 0;
			$less2tests = ($ageData[$value['subcounty_id']]['less2tests']) ? number_format($ageData[$value['subcounty_id']]['less2tests']) : 0;
			$less2sustx = ($ageData[$value['subcounty_id']]['less2sustx']) ? number_format($ageData[$value['subcounty_id']]['less2sustx']) : 0;
			$less9tests = ($ageData[$value['subcounty_id']]['less9tests']) ? number_format($ageData[$value['subcounty_id']]['less9tests']) : 0;
			$less9sustx = ($ageData[$value['subcounty_id']]['less9sustx']) ? number_format($ageData[$value['subcounty_id']]['less9sustx']) : 0;
			$less14tests = ($ageData[$value['subcounty_id']]['less14tests']) ? number_format($ageData[$value['subcounty_id']]['less14tests']) : 0;
			$less14sustx = ($ageData[$value['subcounty_id']]['less14sustx']) ? number_format($ageData[$value['subcounty_id']]['less14sustx']) : 0;
			$less19tests = ($ageData[$value['subcounty_id']]['less19tests']) ? number_format($ageData[$value['subcounty_id']]['less19tests']) : 0;
			$less19sustx = ($ageData[$value['subcounty_id']]['less19sustx']) ? number_format($ageData[$value['subcounty_id']]['less19sustx']) : 0;
			$less25tests = ($ageData[$value['subcounty_id']]['less25tests']) ? number_format($ageData[$value['subcounty_id']]['less25tests']) : 0;
			$less25sustx = ($ageData[$value['subcounty_id']]['less25sustx']) ? number_format($ageData[$value['subcounty_id']]['less25sustx']) : 0;
			$above25tests = ($ageData[$value['subcounty_id']]['above25tests']) ? number_format($ageData[$value['subcounty_id']]['above25tests']) : 0;
			$above25sustx = ($ageData[$value['subcounty_id']]['above25sustx']) ? number_format($ageData[$value['subcounty_id']]['above25sustx']) : 0;
			$table .= "<tr>
						<td>".($key+1)."</td>
						<td>".$value['subcounty']."</td>
						<td>".number_format((int) $value['sitesending'])."</td>
						<td>".number_format((int) $value['received'])."</td>
						<td>".number_format((int) $value['rejected']) . " (" . 
							round(@(($value['rejected']*100)/$value['received']), 1, PHP_ROUND_HALF_UP)."%)</td>
						<td>".number_format((int) $validTests + (int) $value['invalids'])."</td>
						<td>".number_format((int) $value['invalids'])."</td>

						<td>".number_format($routine)."</td>
						<td>".number_format($routinesus)."</td>
						<td>".number_format((int) $value['baseline'])."</td>
						<td>".number_format((int) $value['baselinesustxfail'])."</td>
						<td>".number_format((int) $value['confirmtx'])."</td>
						<td>".number_format((int) $value['confirm2vl'])."</td>
						<td>".number_format((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx'])."</td>
						<td>".number_format((int) $routinesus + (int) $value['baselinesustxfail'] + (int) $value['confirm2vl'])."</td>
						<td>".$femaletests."</td>
						<td>".$femalesustx."</td>
						<td>".$maletests."</td>
						<td>".$malesustx."</td>
						<td>".$Nodatatests."</td>
						<td>".$Nodatasustx."</td>
						<td>".$less2tests."</td>
						<td>".$less2sustx."</td>
						<td>".$less9tests."</td>
						<td>".$less9sustx."</td>
						<td>".$less14tests."</td>
						<td>".$less14sustx."</td>
						<td>".$less19tests."</td>
						<td>".$less19sustx."</td>
						<td>".$less25tests."</td>
						<td>".$less25sustx."</td>
						<td>".$above25tests."</td>
						<td>".$above25sustx."</td>";
						
					$table .= "</tr>";
			$count++;
		}
		
		return $table;
	}

	function download_subcounty_table($year=NULL,$month=NULL,$county=NULL,$to_year=null,$to_month=null)
	{
		$table = '';
		$count = 1;
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county]);
		extract($d);


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
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county]);
		extract($d);

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
			$validTests = ((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx']);

			$table .= "<tr>
						<td>".($key+1)."</td>
						<td>".$value['partner']."</td>
						<td>".number_format((int) $value['received'])."</td>
						<td>".number_format((int) $value['rejected']) . " (" . 
							round(@(($value['rejected']*100)/$value['received']), 1, PHP_ROUND_HALF_UP)."%)</td>
						<td>".number_format((int) $validTests + (int) $value['invalids'])."</td>
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
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county]);
		extract($d);

		$type = 1;
		$type2 = 3;
		$sql = "CALL `proc_get_vl_sites_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$county."')";
		$sqlAge = "CALL `proc_get_vl_county_agecategories_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type2."','".$county."');";
		$sqlGender = "CALL `proc_get_vl_county_gender_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type2."','".$county."');";
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
		$data = [];
		foreach ($resultage as $key => $value) {
			if (!in_array($value->selection, $counties))
				$counties[] = $value->selection;
		}
		foreach ($counties as $key => $value) {
			foreach ($resultGender as $k => $v) {
				if ($value == $v->selection) {
					$genderData[$value]['selection'] = $v->selection;
					if ($v->name == 'F'){
						$genderData[$value]['femaletests'] = $v->tests;
						$genderData[$value]['femalesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'M'){
						$genderData[$value]['maletests'] = $v->tests;
						$genderData[$value]['malesustx'] = ($v->less5000+$v->above5000);
					}
					if ($v->name == 'No Data'){
						$genderData[$value]['Nodatatests'] = $v->tests;
						$genderData[$value]['Nodatasustx'] = ($v->less5000+$v->above5000);
					}
				}
			}
		}
		foreach ($counties as $key => $value) {
			foreach ($resultage as $k => $v) {
				if ($value == $v->selection) {
					$ageData[$value]['selection'] = $v->selection;
					if ($v->name == '15-19') {
						$ageData[$value]['less19tests'] = $v->tests;
						$ageData[$value]['less19sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '10-14') {
						$ageData[$value]['less14tests'] = $v->tests;
						$ageData[$value]['less14sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == 'Less 2') {
						$ageData[$value]['less2tests'] = $v->tests;
						$ageData[$value]['less2sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '2-9') {
						$ageData[$value]['less9tests'] = $v->tests;
						$ageData[$value]['less9sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '20-24') {
						$ageData[$value]['less25tests'] = $v->tests;
						$ageData[$value]['less25sustx'] = ($v->less5000+$v->above5000);	
					}
					if ($v->name == '25+') {
						$ageData[$value]['above25tests'] = $v->tests;
						$ageData[$value]['above25sustx'] = ($v->less5000+$v->above5000);	
					}
				}
			}
		}


		foreach ($result as $key => $value) {
			$routine = ((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000']);
			$routinesus = ((int) $value['less5000'] + (int) $value['above5000']);
			$validTests = ((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx']);
			$femaletests = ($genderData[$value['facility_id']]['femaletests']) ? number_format((int) $genderData[$value['facility_id']]['femaletests']) : 0;
			$femalesustx = ($genderData[$value['facility_id']]['femalesustx']) ? number_format((int) $genderData[$value['facility_id']]['femalesustx']) : 0;
			$maletests = ($genderData[$value['facility_id']]['maletests']) ? number_format((int) $genderData[$value['facility_id']]['maletests']) : 0;
			$malesustx = ($genderData[$value['facility_id']]['malesustx']) ? number_format((int) $genderData[$value['facility_id']]['malesustx']) : 0;
			$Nodatatests = ($genderData[$value['facility_id']]['Nodatatests']) ? number_format((int) $genderData[$value['facility_id']]['Nodatatests']) : 0;
			$Nodatasustx = ($genderData[$value['facility_id']]['Nodatasustx']) ? number_format((int) $genderData[$value['facility_id']]['Nodatasustx']) : 0;
			$less2tests = ($ageData[$value['facility_id']]['less2tests']) ? number_format($ageData[$value['facility_id']]['less2tests']) : 0;
			$less2sustx = ($ageData[$value['facility_id']]['less2sustx']) ? number_format($ageData[$value['facility_id']]['less2sustx']) : 0;
			$less9tests = ($ageData[$value['facility_id']]['less9tests']) ? number_format($ageData[$value['facility_id']]['less9tests']) : 0;
			$less9sustx = ($ageData[$value['facility_id']]['less9sustx']) ? number_format($ageData[$value['facility_id']]['less9sustx']) : 0;
			$less14tests = ($ageData[$value['facility_id']]['less14tests']) ? number_format($ageData[$value['facility_id']]['less14tests']) : 0;
			$less14sustx = ($ageData[$value['facility_id']]['less14sustx']) ? number_format($ageData[$value['facility_id']]['less14sustx']) : 0;
			$less19tests = ($ageData[$value['facility_id']]['less19tests']) ? number_format($ageData[$value['facility_id']]['less19tests']) : 0;
			$less19sustx = ($ageData[$value['facility_id']]['less19sustx']) ? number_format($ageData[$value['facility_id']]['less19sustx']) : 0;
			$less25tests = ($ageData[$value['facility_id']]['less25tests']) ? number_format($ageData[$value['facility_id']]['less25tests']) : 0;
			$less25sustx = ($ageData[$value['facility_id']]['less25sustx']) ? number_format($ageData[$value['facility_id']]['less25sustx']) : 0;
			$above25tests = ($ageData[$value['facility_id']]['above25tests']) ? number_format($ageData[$value['facility_id']]['above25tests']) : 0;
			$above25sustx = ($ageData[$value['facility_id']]['above25sustx']) ? number_format($ageData[$value['facility_id']]['above25sustx']) : 0;
			$table .= "<tr>
						<td>".($key+1)."</td>
						<td>".$value['facility']."</td>
						<td>".$value['facilitycode']."</td>
						<td>".$value['subcounty']."</td>
						<td>".number_format((int) $value['received'])."</td>
						<td>".number_format((int) $value['rejected']) . " (" . 
							round(@(($value['rejected']*100)/$value['received']), 1, PHP_ROUND_HALF_UP)."%)</td>
						<td>".number_format((int) $validTests + (int) $value['invalids'])."</td>
						<td>".number_format((int) $value['invalids'])."</td>
						<td>".number_format($routine)."</td>
						<td>".number_format($routinesus)."</td>
						<td>".number_format((int) $value['baseline'])."</td>
						<td>".number_format((int) $value['baselinesustxfail'])."</td>
						<td>".number_format((int) $value['confirmtx'])."</td>
						<td>".number_format((int) $value['confirm2vl'])."</td>
						<td>".number_format((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx'])."</td>
						<td>".number_format((int) $routinesus + (int) $value['baselinesustxfail'] + (int) $value['confirm2vl'])."</td>
						<td>".$femaletests."</td>
						<td>".$femalesustx."</td>
						<td>".$maletests."</td>
						<td>".$malesustx."</td>
						<td>".$Nodatatests."</td>
						<td>".$Nodatasustx."</td>
						<td>".$less2tests."</td>
						<td>".$less2sustx."</td>
						<td>".$less9tests."</td>
						<td>".$less9sustx."</td>
						<td>".$less14tests."</td>
						<td>".$less14sustx."</td>
						<td>".$less19tests."</td>
						<td>".$less19sustx."</td>
						<td>".$less25tests."</td>
						<td>".$less25sustx."</td>
						<td>".$above25tests."</td>
						<td>".$above25sustx."</td>";

					$table .= "</tr>";
			$count++;

		}
		// echo $table;die();
		
		return $table;
	}

	function download_partners_county_table($year=NULL,$month=NULL,$county=NULL,$to_year=null,$to_month=null)
	{
		$table = '';
		$count = 1;
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county]);
		extract($d);


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

	function county_outcome_table($year=NULL,$month=NULL,$to_year=null,$to_month=null)
	{
		// $table = '';
		$d = $this->extract_variables($year, $month, $to_year, $to_month);
		extract($d);
		
		$sql = "CALL `proc_get_vl_county_outcomes_age_gender`('".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$records = $this->db->query($sql)->result();
		$this->db->close();
		// echo "<pre>";print_r($records);die();
		$county = [];

		foreach ($records as $key => $value) {
				if (!in_array($value->county, $county))
				{
					$county[] = $value->county;
				}

				if ($value->gender == 1) {
					if ($value->age == 6) {
						$mTestUnder2[$value->county] = $value->tests;
						$mNonSupUnder2[$value->county] = $value->nonsup;
					}
					if ($value->age == 7) { 
						$mTest2To9[$value->county] = $value->tests;
						$mNonSup2To9[$value->county] = $value->nonsup;
					}
					if ($value->age == 8) { 
						$mTest10To14[$value->county] = $value->tests;
						$mNonSup10To14[$value->county] = $value->nonsup;
					}
					if ($value->age == 9) { 
						$mTest15To19[$value->county] = $value->tests;
						$mNonSup15To19[$value->count] = $value->nonsup;
					}
					if ($value->age == 10) { 
						$mTest20To24[$value->county] = $value->tests;
						$mNonSup20To24[$value->county] = $value->nonsup;
					}
					if ($value->age == 11) { 
						$mTestAbove25[$value->county] = $value->tests;
						$mNonSupAbove25[$value->county] = $value->nonsup;
					}
				}
			 if ($value->gender == 2) {
				if ($value->age == 6) {
					$fTestUnder2[$value->county] = $value->tests;
					$fNonSupUnder2[$value->county] = $value->nonsup;
				}
				if ($value->age == 7) {
					$fTest2To9[$value->county] = $value->tests;
					$fNonSup2To9[$value->county] = $value->nonsup;
				}
				if ($value->age == 8) {
					$fTest10To14[$value->county] = $value->tests;
					$fNonSup10To14[$value->county] = $value->nonsup;
				}
				if ($value->age == 9) {
					$fTest15To19[$value->county] = $value->tests;
					$fNonSup15To19[$value->county] = $value->nonsup;
				}
				if ($value->age == 10) {
					$fTest20To24[$value->county] = $value->tests;
					$fNonSup20To24[$value->county] = $value->nonsup;
				}
				if ($value->age == 11) {
					$fTestAbove25[$value->county] = $value->tests;
					$fNonSupAbove25[$value->county] = $value->nonsup;
				}
			}
		}
		// echo "<pre>";print_r($data['mTestUnder2']);die();
		foreach ($county as $key => $value) {
			$table .= "<tr>
						<td>".($key+1)."</td>
						<td>".$value."</td>
						<td>".number_format((int) $mTestUnder2[$value])."</td>
						<td>".number_format((int) $mNonSupUnder2[$value])."</td>
						<td>".number_format((int) $mTest2To9[$value]) ."</td>
						<td>".number_format((int) $mNonSup2To9[$value])."</td>
						<td>".number_format((int) $mTest10To14[$value])."</td>
						<td>".number_format((int) $mNonSup10To14[$value])."</td>
						<td>".number_format((int) $mTest15To19[$value])."</td>
						<td>".number_format((int) $mNonSup15To19[$value])."</td>
						<td>".number_format((int) $mTest20To24[$value])."</td>
						<td>".number_format((int) $mNonSup20To24[$value])."</td>
						<td>".number_format((int) $mTestAbove25[$value])."</td>
						<td>".number_format((int) $mNonSupAbove25[$value])."</td>

						<td>".number_format((int) $fTestUnder2[$value])."</td>
						<td>".number_format((int) $fNonSupUnder2[$value])."</td>
						<td>".number_format((int) $fTest2To9[$value]) ."</td>
						<td>".number_format((int) $fNonSup2To9[$value])."</td>
						<td>".number_format((int) $fTest10To14[$value])."</td>
						<td>".number_format((int) $fNonSup10To14[$value])."</td>
						<td>".number_format((int) $fTest15To19[$value])."</td>
						<td>".number_format((int) $fNonSup15To19[$value])."</td>
						<td>".number_format((int) $fTest20To24[$value])."</td>
						<td>".number_format((int) $fNonSup20To24[$value])."</td>
						<td>".number_format((int) $fTestAbove25[$value])."</td>
						<td>".number_format((int) $fNonSupAbove25[$value])."</td>";
			$table .= "</tr>";
			
		}
		// echo $table;die();
		// echo "<pre>";print_r($county);die();
		return $table;		
				
	}
} 