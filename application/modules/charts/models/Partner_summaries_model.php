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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

		$sql = "CALL `proc_get_vl_partner_county_details`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		
		// echo "<pre>";print_r($sql);die();
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
 
		foreach ($result as $key => $value) {
			$suppressed = (int)$value['undetected']+(int)$value['less1000'];
			$nonsuppressed = (int)$value['less5000']+(int)$value['above5000'];
			$data['categories'][$key] 					= $value['county'];
			$data['outcomes'][0]['data'][$key] = (int) $nonsuppressed;
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

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
			$routine = ((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000']);
			$routinesus = ((int) $value['less5000'] + (int) $value['above5000']);
			$table .= "<tr>
				<td>".$count."</td>
				<td>".$value['county']."</td>
				<td>".number_format((int) $value['facilities'])."</td>
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

	function download_partner_counties($year=NULL,$month=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
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
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}

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


	function partner_tat_outcomes($year=null, $month=null, $to_year=null, $to_month=null,$partner=null)
	{
		$type = 1;
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}
		//Initializing the value of the Year to the selected year or the default year which is current year
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		//Assigning the value of the month or setting it to the selected value
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		
		if ($partner==null) $partner = 0;
		$sql = "CALL `proc_get_vl_tat_ranking`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$partner."')";
		// echo "<pre>";print_r($sql);echo "</pre>";die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();

		$data['outcomes'][0]['name'] = "Processing-Dispatch (P-D)";
		$data['outcomes'][1]['name'] = "Receipt to-Processing (R-P)";
		$data['outcomes'][2]['name'] = "Collection-Receipt (C-R)";
		$data['outcomes'][3]['name'] = "Collection-Dispatch (C-D)";

		$data['outcomes'][0]['color'] = 'rgba(0, 255, 0, 0.498039)';
		$data['outcomes'][1]['color'] = 'rgba(255, 255, 0, 0.498039)';
		$data['outcomes'][2]['color'] = 'rgba(255, 0, 0, 0.498039)';
		// $data['outcomes'][0]['color'] = '#26C281';
		// $data['outcomes'][1]['color'] = '#FABE58';
		// $data['outcomes'][2]['color'] = '#EF4836';
		$data['outcomes'][3]['color'] = '#913D88';

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "column";
		$data['outcomes'][3]['type'] = "spline";

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;
		$data['outcomes'][2]['yAxis'] = 1;

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][3]['tooltip'] = array("valueSuffix" => ' Days');

		$data['title'] = "";
		
		$data['categories'][0] = 'No Data';
		$data["outcomes"][0]["data"][0]	= 0;
		$data["outcomes"][1]["data"][0]	= 0;
		$data["outcomes"][2]["data"][0]	= 0;
		$data["outcomes"][3]["data"][0]	= 0;

		$count = 0;
		foreach ($result as $key => $value) {
			if ($count < 100) {
				$data['categories'][$key] = $value['name'];
				$data["outcomes"][0]["data"][$key]	= round($value['tat3'],1);
				$data["outcomes"][1]["data"][$key]	= round($value['tat2'],1);
				$data["outcomes"][2]["data"][$key]	= round($value['tat1'],1);
				$data["outcomes"][3]["data"][$key]	= round($value['tat4'],1);
			}
			$count++;
			
		}

		// echo "<pre>";print_r($data);die();
		return $data;
	}
	
}
?>