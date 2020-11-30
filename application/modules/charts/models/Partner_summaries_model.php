<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Partner_summaries_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}


	function partner_counties_outcomes($year=NULL,$month=NULL,$partner=NULL,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['partner' => $partner]);
		extract($d);

		$sql = "CALL `proc_get_vl_partner_county_details`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		// echo "<pre>";print_r($result);die();

		$data['outcomes'][0]['name'] = "&lt; LDL";
		$data['outcomes'][1]['name'] = "&lt; 1000 cp/ml";
		$data['outcomes'][2]['name'] = "Suppressed";
		$data['outcomes'][3]['name'] = "Suppression";

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "column";
		$data['outcomes'][3]['type'] = "spline";
		

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;
		$data['outcomes'][2]['yAxis'] = 1;

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' %');
		$data['outcomes'][3]['tooltip'] = array("valueSuffix" => ' %');
 
		$data['outcomes'][0]['color'] = '#1BA39C';
		$data['outcomes'][1]['color'] = '#66ff66';
		$data['outcomes'][2]['color'] = '#F2784B';

		$data['title'] = "";
 
		foreach ($result as $key => $value) {
			$suppressed = (int)$value['undetected']+(int)$value['less1000'];
			$nonsuppressed = (int)$value['less5000']+(int)$value['above5000'];
			$data['categories'][$key] 					= $value['county'];
			$data['outcomes'][0]['data'][$key] = (int) $value['undetected'];
			$data['outcomes'][0]['data'][$key] = (int) $value['less1000'];
			$data['outcomes'][1]['data'][$key] = (int) $suppressed;
			$data['outcomes'][2]['data'][$key] = round(@(((int) $suppressed*100)/((int) $suppressed+(int) $nonsuppressed)),1);
		}
		// echo "<pre>";print_r($data);die();
		return $data;

	}

	function partner_counties_table($year=NULL,$month=NULL,$partner=NULL,$to_year=null,$to_month=null)
	{
		$table = '';
		$count = 1;
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['partner' => $partner]);
		extract($d);

		$type = 1;
		$sql = "CALL `proc_get_vl_partner_county_details`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		$sqlAge = "CALL `proc_get_vl_partner_agecategories_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$partner."');";
		$sqlGender = "CALL `proc_get_vl_partner_gender_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$partner."');";
		// echo "<pre>";print_r($sql);die();
		$this->db->close();
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		$resultage = $this->db->query($sqlAge)->result();
		$this->db->close();
		$resultGender = $this->db->query($sqlGender)->result();

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
				<td>".$count."</td>
				<td>".$value['county']."</td>
				<td>".number_format((int) $value['facilities'])."</td>
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
				<td>".number_format((int) $validTests)."</td>
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

	function download_partner_counties($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['partner' => $partner]);
		extract($d);

		$sql = "CALL `proc_get_vl_partner_county_details`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$data = $this->db->query($sql)->result_array();

		$this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

	    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */


	    $b = array('County', 'Facilities', 'Tests', 'Received', 'Rejected', 'All Tests', 'Redraws', 'Undetected', 'less1000', 'above1000 - less5000', 'above5000', 'Baseline Tests', 'Baseline >1000', 'Confirmatory Tests', 'Confirmatory >1000');

	    fputcsv($f, $b, $delimiter);

	    foreach ($data as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="eid_partner_sites.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);


	}
}
?>