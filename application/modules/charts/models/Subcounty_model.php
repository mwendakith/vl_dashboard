<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
* 
*/
class Subcounty_model extends MY_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function subcounty_outcomes($year=NULL,$month=NULL,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month);
		extract($d);

		$sql = "CALL `proc_get_vl_subcounty_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$res = $this->db->query($sql)->result_array();

		$result = array_splice($res, 0, 50);

		// echo "<pre>";print_r($result);die();


		$data['outcomes'][0]['name'] = "Not Suppressed";
		$data['outcomes'][1]['name'] = "Suppressed";
		$data['outcomes'][2]['name'] = "Suppression";
		$data['outcomes'][3]['name'] = "90% Target";

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "spline";
		$data['outcomes'][3]['type'] = "spline";
		

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' %');
		$data['outcomes'][3]['tooltip'] = array("valueSuffix" => ' %');

		$data['title'] = "";
 		$data['categories'][0] 			= "No Data";
		$data['outcomes'][0]['data'][0] = 0;
		$data['outcomes'][1]['data'][0] = 0;
		$data['outcomes'][2]['data'][0] = 0;
		$data['outcomes'][3]['data'][0] = 0;
		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data['outcomes'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$key] = (int) $value['suppressed'];
			$data['outcomes'][2]['data'][$key] = round(@(((int) $value['suppressed']*100)/((int) $value['suppressed']+(int) $value['nonsuppressed'])),1);
			$data['outcomes'][3]['data'][$key] = 90;
		}

		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function county_subcounties($year=NULL,$month=NULL,$to_year=null,$to_month=null)
	{
		$table = '';
		$count = 1;
		$d = $this->extract_variables($year, $month, $to_year, $to_month);
		extract($d);

		$type = 0;
		$default = 0;
		$sql = "CALL `proc_get_vl_subcounty_details`('0','".$year."','".$month."','".$to_year."','".$to_month."')";
		$sqlAge = "CALL `proc_get_vl_subcounty_agecategories_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$default."');";
		$sqlGender = "CALL `proc_get_vl_subcounty_gender_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$default."');";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		$resultage = $this->db->query($sqlAge)->result();
		$this->db->close();
		$resultGender = $this->db->query($sqlGender)->result();
		// echo "<pre>";print_r($result);die();
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
			$femaletests = ($genderData[$value['subcounty']]['femaletests']) ? number_format((int) $genderData[$value['subcounty']]['femaletests']) : 0;
			$femalesustx = ($genderData[$value['subcounty']]['femalesustx']) ? number_format((int) $genderData[$value['subcounty']]['femalesustx']) : 0;
			$maletests = ($genderData[$value['subcounty']]['maletests']) ? number_format((int) $genderData[$value['subcounty']]['maletests']) : 0;
			$malesustx = ($genderData[$value['subcounty']]['malesustx']) ? number_format((int) $genderData[$value['subcounty']]['malesustx']) : 0;
			$Nodatatests = ($genderData[$value['subcounty']]['Nodatatests']) ? number_format((int) $genderData[$value['subcounty']]['Nodatatests']) : 0;
			$Nodatasustx = ($genderData[$value['subcounty']]['Nodatasustx']) ? number_format((int) $genderData[$value['subcounty']]['Nodatasustx']) : 0;
			$less2tests = ($ageData[$value['subcounty']]['less2tests']) ? number_format($ageData[$value['subcounty']]['less2tests']) : 0;
			$less2sustx = ($ageData[$value['subcounty']]['less2sustx']) ? number_format($ageData[$value['subcounty']]['less2sustx']) : 0;
			$less9tests = ($ageData[$value['subcounty']]['less9tests']) ? number_format($ageData[$value['subcounty']]['less9tests']) : 0;
			$less9sustx = ($ageData[$value['subcounty']]['less9sustx']) ? number_format($ageData[$value['subcounty']]['less9sustx']) : 0;
			$less14tests = ($ageData[$value['subcounty']]['less14tests']) ? number_format($ageData[$value['subcounty']]['less14tests']) : 0;
			$less14sustx = ($ageData[$value['subcounty']]['less14sustx']) ? number_format($ageData[$value['subcounty']]['less14sustx']) : 0;
			$less19tests = ($ageData[$value['subcounty']]['less19tests']) ? number_format($ageData[$value['subcounty']]['less19tests']) : 0;
			$less19sustx = ($ageData[$value['subcounty']]['less19sustx']) ? number_format($ageData[$value['subcounty']]['less19sustx']) : 0;
			$less25tests = ($ageData[$value['subcounty']]['less25tests']) ? number_format($ageData[$value['subcounty']]['less25tests']) : 0;
			$less25sustx = ($ageData[$value['subcounty']]['less25sustx']) ? number_format($ageData[$value['subcounty']]['less25sustx']) : 0;
			$above25tests = ($ageData[$value['subcounty']]['above25tests']) ? number_format($ageData[$value['subcounty']]['above25tests']) : 0;
			$above25sustx = ($ageData[$value['subcounty']]['above25sustx']) ? number_format($ageData[$value['subcounty']]['above25sustx']) : 0;
			$table .= "<tr>
						<td>".($key+1)."</td>
						<td>".$value['subcounty']."</td>
						<td>".$value['county']."</td>
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

	function subcounty_vl_outcomes($year=NULL,$month=NULL,$subcounty=NULL,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['subcounty' => $subcounty]);
		extract($d);

		$sql = "CALL `proc_get_vl_subcounty_vl_outcomes`('".$subcounty."','".$year."','".$month."','".$to_year."','".$to_month."')";
		$sql2 = "CALL `proc_get_vl_current_suppression`('2','".$subcounty."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		
		$this->db->close();
		$current = $this->db->query($sql2)->row();
		$this->db->close();
		

		$color = array('#6BB9F0', '#F2784B', '#1BA39C', '#5C97BF');

		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;
		$data['ul'] = '';

		$data['vl_outcomes']['data'][0]['name'] = '&lt;= 1000';
		$data['vl_outcomes']['data'][1]['name'] = 'LDL';
		$data['vl_outcomes']['data'][2]['name'] = 'Not Suppressed';

		$count = 0;

		$data['vl_outcomes']['data'][0]['y'] = $count;
		$data['vl_outcomes']['data'][1]['y'] = $count;

		foreach ($result as $key => $value) {
			$total = (int) ($value['undetected']+$value['less1000']+$value['less5000']+$value['above5000']);
			$less = (int) ($value['undetected']+$value['less1000']);
			$greater = (int) ($value['less5000']+$value['above5000']);
			$non_suppressed = $greater + (int) $value['confirm2vl'];
			$total_tests = (int) $value['confirmtx'] + $total + (int) $value['baseline'];

			$data['ul'] .= '
			<tr>
	    		<td>Total VL tests done:</td>
	    		<td>'.number_format($total_tests ). '</td>
	    		<td>Non Suppression</td>
	    		<td>'. number_format($non_suppressed) . ' (' . round((($non_suppressed / $total_tests  )*100),1).'%</td>
	    	</tr>

			<tr>
	    		<td colspan="2">Routine VL Tests with Valid Outcomes:</td>
	    		<td colspan="2">'.number_format($total).'</td>
	    	</tr>

	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests &gt;= 1000 copies/ml:</td>
	    		<td>'.number_format($greater).'</td>
	    		<td>Percentage Non Suppression</td>
	    		<td>'.round((($greater/$total)*100),1).'%</td>
	    	</tr>

	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests &lt; 1000 copies/ml:</td>
	    		<td>'.number_format($value['less1000']).'</td>
	    		<td>Percentage Suppression</td>
	    		<td>'.round((@($value['less1000']/$total)*100),1).'%</td>
	    	</tr>
 
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests LDL:</td>
	    		<td>'.number_format($value['undetected']).'</td>
	    		<td>Percentage Undetectable</td>
	    		<td>'.round((@($value['undetected']/$total)*100),1).'%</td>
	    	</tr>
 
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;Baseline VLs:</td>
	    		<td>'.number_format($value['baseline']).'</td>
	    		<td>Non Suppression ( &gt;= 1000cpml)</td>
	    		<td>'.number_format($value['baselinesustxfail']). ' (' .round(($value['baselinesustxfail'] * 100 / $value['baseline']), 1). '%)' .'</td>
	    	</tr>

	    	<tr>
	    		<td colspan="2">Confirmatory Repeat Tests:</td>
	    		<td colspan="2">'.number_format($value['confirmtx']).'</td>
	    	</tr>

	    	<tr>
	    		<td>Rejected Samples:</td>
	    		<td>'.number_format($value['rejected']).'</td>
	    		<td>Percentage Rejection Rate</td>
	    		<td>'. round((($value['rejected']*100)/$value['alltests']), 1, PHP_ROUND_HALF_UP).'%</td>
	    	</tr>';
						
			$data['vl_outcomes']['data'][0]['y'] = (int) $value['less1000'];
			$data['vl_outcomes']['data'][1]['y'] = (int) $value['undetected'];
			$data['vl_outcomes']['data'][2]['y'] = (int) $value['less5000']+(int) $value['above5000'];

			$data['vl_outcomes']['data'][0]['color'] = '#1BA39C';
			$data['vl_outcomes']['data'][1]['color'] = '#66ff66';
			$data['vl_outcomes']['data'][2]['color'] = '#F2784B';
		}
		$data['vl_outcomes']['data'][2]['sliced'] = true;
		$data['vl_outcomes']['data'][2]['selected'] = true;
		
		return $data;
	}

	function subcounty_gender($year=NULL,$month=NULL,$subcounty=NULL,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['subcounty' => $subcounty]);
		extract($d);

		$sql = "CALL `proc_get_vl_subcounty_gender`('".$subcounty."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();

		$data['gender'][0]['name'] = 'Not Suppressed';
		$data['gender'][1]['name'] = 'Suppressed';

		$count = 0;
		
		$data["gender"][0]["data"][0]	= $count;
		$data["gender"][0]["data"][1]	= $count;
		$data['categories'][0]			= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 			= $value['name'];
			$data['gender'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['gender'][1]['data'][$key] = (int) $value['suppressed'];
		}
		$data['gender'][0]['drilldown']['color'] = '#913D88';
		$data['gender'][1]['drilldown']['color'] = '#96281B';
		
		return $data;
	}

	function subcounty_age($year=NULL,$month=NULL,$subcounty=NULL,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['subcounty' => $subcounty]);
		extract($d);

		$sql = "CALL `proc_get_vl_subcounty_age`('".$subcounty."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		
		$data['ageGnd'][0]['name'] = 'Not Suppressed';
		$data['ageGnd'][1]['name'] = 'Suppressed';
 
		$count = 0;
		
		$data["ageGnd"][0]["data"][0]	= $count;
		$data["ageGnd"][1]["data"][0]	= $count;

		foreach ($result as $key => $value) {
			$data['categories'][$key] 			= $value['name'];
			$data['ageGnd'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['ageGnd'][1]['data'][$key] = (int) $value['suppressed'];
		}
		$data['ageGnd'][0]['drilldown']['color'] = '#913D88';
		$data['ageGnd'][0]['drilldown']['color'] = '#913D88';
		
		return $data;
	}

	function get_sampletypesData($year=null,$subcounty=null)
	{
		$array1 = array();
		$array2 = array();
		$sql2 = NULL;

		if ($subcounty==null || $subcounty=='null') {
			$subcounty = $this->session->userdata('sub_county_filter');
		}
		
		if ($year==null || $year=='null') {
			$to = $this->session->userdata('filter_year');
		}else {
			$to = $year;
		}
		$from = $to-1;

		$sql = "CALL `proc_get_vl_subcounty_sample_types`('".$subcounty."','".$from."','".$to."')";
		// echo "<pre>";print_r($sql);die();
		$array1 = $this->db->query($sql)->result_array();
		return $array1;
		
		// if ($sql2) {
		// 	$this->db->close();
		// 	$array2 = $this->db->query($sql2)->result_array();
		// }
 
		// return array_merge($array1,$array2);
	}

	function subcounty_samples($year=NULL,$subcounty=NULL, $all=null)
	{
		$result = $this->get_sampletypesData($year,$subcounty);

		$data['sample_types'][0]['name'] = 'Plasma';
		$data['sample_types'][1]['name'] = 'DBS';

		$data['sample_types'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['sample_types'][1]['tooltip'] = array("valueSuffix" => ' ');
 
		$count = 0;
		
		$data['categories'][0] = 'No Data';
		$data["sample_types"][0]["data"][0]	= $count;
		$data["sample_types"][1]["data"][0]	= $count;
 
		foreach ($result as $key => $value) {
			
			$data['categories'][$key] = $this->resolve_month($value['month']).'-'.$value['year'];

			if ($all == 1) {
				$data["sample_types"][0]["data"][$key]	= (int) ($value['alledta'] + $value['allplasma']);
				$data["sample_types"][1]["data"][$key]	= (int) $value['alldbs'];
			}else{
				$data["sample_types"][0]["data"][$key]	= (int) ($value['edta'] + $value['plasma']);
				$data["sample_types"][1]["data"][$key]	= (int) $value['dbs'];
			}
			
		}
		
		return $data;
	}

	function download_sampletypes($year=null,$subcounty=null)
	{
		$data = $this->get_sampletypesData($year,$subcounty);
		// echo "<pre>";print_r($result);die();
		$this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

	    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('Month', 'Year', 'EDTA', 'DBS', 'Plasma', 'ALL EDTA', 'ALL DBS', 'ALL Plasma', 'Suppressed', 'Tests', 'Suppression');

	    fputcsv($f, $b, $delimiter);

	    foreach ($data as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="'.Date('YmdH:i:s').'vl_subcountysampleTypes.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
	}

	function subcounty_sites($year=NULL,$month=NULL,$subcounty=NULL,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['subcounty' => $subcounty]);
		extract($d);

		$table = '';
		$count = 1;
		$type = 1;

		$sql = "CALL `proc_get_vl_subcounty_sites_details`('".$subcounty."','".$year."','".$month."','".$to_year."','".$to_month."')";
		$sqlAge = "CALL `proc_get_vl_subcounty_agecategories_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$subcounty."');";
		$sqlGender = "CALL `proc_get_vl_subcounty_gender_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$subcounty."');";
		// echo "<pre>";print_r($sql);die();
		$this->db->close();
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		$resultage = $this->db->query($sqlAge)->result();
		$this->db->close();
		$resultGender = $this->db->query($sqlGender)->result();
		// echo "<pre>";print_r($sqlAge);die();
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
		// echo "<pre>";print_r($result);die();

		foreach ($result as $key => $value) {
			$routine = ((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000']);
			$routinesus = ((int) $value['less5000'] + (int) $value['above5000']);
			$validTests = ((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx']);
			$femaletests = ($genderData[$value['name']]['femaletests']) ? number_format((int) $genderData[$value['name']]['femaletests']) : 0;
			$femalesustx = ($genderData[$value['name']]['femalesustx']) ? number_format((int) $genderData[$value['name']]['femalesustx']) : 0;
			$maletests = ($genderData[$value['name']]['maletests']) ? number_format((int) $genderData[$value['name']]['maletests']) : 0;
			$malesustx = ($genderData[$value['name']]['malesustx']) ? number_format((int) $genderData[$value['name']]['malesustx']) : 0;
			$Nodatatests = ($genderData[$value['name']]['Nodatatests']) ? number_format((int) $genderData[$value['name']]['Nodatatests']) : 0;
			$Nodatasustx = ($genderData[$value['name']]['Nodatasustx']) ? number_format((int) $genderData[$value['name']]['Nodatasustx']) : 0;
			$less2tests = ($ageData[$value['name']]['less2tests']) ? number_format($ageData[$value['name']]['less2tests']) : 0;
			$less2sustx = ($ageData[$value['name']]['less2sustx']) ? number_format($ageData[$value['name']]['less2sustx']) : 0;
			$less9tests = ($ageData[$value['name']]['less9tests']) ? number_format($ageData[$value['name']]['less9tests']) : 0;
			$less9sustx = ($ageData[$value['name']]['less9sustx']) ? number_format($ageData[$value['name']]['less9sustx']) : 0;
			$less14tests = ($ageData[$value['name']]['less14tests']) ? number_format($ageData[$value['name']]['less14tests']) : 0;
			$less14sustx = ($ageData[$value['name']]['less14sustx']) ? number_format($ageData[$value['name']]['less14sustx']) : 0;
			$less19tests = ($ageData[$value['name']]['less19tests']) ? number_format($ageData[$value['name']]['less19tests']) : 0;
			$less19sustx = ($ageData[$value['name']]['less19sustx']) ? number_format($ageData[$value['name']]['less19sustx']) : 0;
			$less25tests = ($ageData[$value['name']]['less25tests']) ? number_format($ageData[$value['name']]['less25tests']) : 0;
			$less25sustx = ($ageData[$value['name']]['less25sustx']) ? number_format($ageData[$value['name']]['less25sustx']) : 0;
			$above25tests = ($ageData[$value['name']]['above25tests']) ? number_format($ageData[$value['name']]['above25tests']) : 0;
			$above25sustx = ($ageData[$value['name']]['above25sustx']) ? number_format($ageData[$value['name']]['above25sustx']) : 0;
			$table .= "<tr>
				<td>".$count."</td>
				<td>".$value['MFLCode']."</td>
				<td>".$value['name']."</td>
				<td>".$value['county']."</td>
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


	function download_subcounty_sites($year=NULL,$month=NULL,$subcounty=NULL,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['subcounty' => $subcounty]);
		extract($d);

		$table = '';
		$count = 1;

		$sql = "CALL `proc_get_vl_subcounty_sites_details`('".$subcounty."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

	    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('MFLCode', 'Facility',  'County', 'Sub-County', 'Received', 'Rejected', 'All Tests', 'Redraws', 'Undetected', 'less1000', 'above1000 - less5000', 'above5000', 'Baseline Tests', 'Baseline >1000', 'Confirmatory Tests', 'Confirmatory >1000');

	    fputcsv($f, $b, $delimiter);

	    foreach ($result as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="'.Date('Ymd H:i:s').'vl_subcounty_sites.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
	}

	function justification_breakdown($year=null,$month=null,$subcounty=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['subcounty' => $subcounty]);
		extract($d); 

		$sql = "CALL `proc_get_vl_pmtct`('1','".$year."','".$month."','".$to_year."','".$to_month."','','','','".$subcounty."','')";
		$sql2 = "CALL `proc_get_vl_pmtct`('2','".$year."','".$month."','".$to_year."','".$to_month."','','','','".$subcounty."','')";

		
		
		$preg_mo = $this->db->query($sql)->result_array();
		$this->db->close();
		$lac_mo = $this->db->query($sql2)->result_array();
		// echo "<pre>";print_r($preg_mo);echo "</pre>";
		// echo "<pre>";print_r($lac_mo);die();
		$data['just_breakdown'][0]['name'] = 'Not Suppressed';
		$data['just_breakdown'][1]['name'] = 'Suppressed';
 
		$count = 0;
		
		$data["just_breakdown"][0]["data"][0]	= $count;
		$data["just_breakdown"][1]["data"][0]	= $count;
		$data['categories'][0]			= 'No Data';
 
		foreach ($preg_mo as $key => $value) {
			$data['categories'][0] 			= 'Pregnant Mothers';
			$data["just_breakdown"][0]["data"][0]	=  (int) $value['less5000'] + (int) $value['above5000'];
			$data["just_breakdown"][1]["data"][0]	=  (int) $value['undetected'] + (int) $value['less1000'];
		}
 
		foreach ($lac_mo as $key => $value) {
			$data['categories'][1] 			= 'Lactating Mothers';
			$data["just_breakdown"][0]["data"][1]	=  (int) $value['less5000'] + (int) $value['above5000'];
			$data["just_breakdown"][1]["data"][1]	=  (int) $value['undetected'] + (int) $value['less1000'];
		}
 
		$data['just_breakdown'][0]['drilldown']['color'] = '#913D88';
		$data['just_breakdown'][1]['drilldown']['color'] = '#96281B';
				
		return $data;
	}






	function get_patients($year=null,$month=null,$subcounty=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['subcounty' => $subcounty], true);
		extract($d);

		$query = $this->db->get_where('districts', array('id' => $subcounty), 1)->row();
		$sc = $query->SubCountyDHISCode;

		$params = "patient/subcounty/{$sc}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";

		$this->db->close();

		$result = $this->req($params);	

		// echo "<pre>";print_r($result);die();

		$data['outcomes'][0]['name'] = "Patients grouped by tests received";

		$data['title'] = " ";

		$data['unique_patients'] = 0;
		$data['size'] = 0;
		$data['total_patients'] = $result->art;
		$data['as_at'] = $result->as_at;
		$data['total_tests'] = 0;

		foreach ($result->unique as $key => $value) {

			$data['categories'][$key] = (int) $value->tests;
		
			$data['outcomes'][0]['data'][$key] = (int) $value->totals;
			$data['unique_patients'] += (int) $value->totals;
			$data['total_tests'] += ($data['categories'][$key] * $data['outcomes'][0]['data'][$key]);
			$data['size']++;
		}

		$data['coverage'] = round(($data['unique_patients'] / $data['total_patients'] * 100), 2);

		return $data;
	}

	function get_current_suppresion($year=null,$month=null,$subcounty=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['subcounty' => $subcounty], true);
		extract($d);

		$query = $this->db->get_where('districts', array('id' => $subcounty), 1)->row();
		$sc = $query->SubCountyDHISCode;
		$params = "patient/suppression/subcounty/{$sc}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
		
		$this->db->close();

		$result = $this->req($params);	


		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;
		$data['ul'] = '';

		$data['vl_outcomes']['data'][0]['name'] = '<= 400 copies/ml';
		$data['vl_outcomes']['data'][1]['name'] = '401 - 999 copies/ml';
		$data['vl_outcomes']['data'][2]['name'] = '>= 1000 copies/ml';
		
		$data['vl_outcomes']['data'][0]['y'] = (int) $result->rcategory1;
		$data['vl_outcomes']['data'][1]['y'] = (int) $result->rcategory2;
		$data['vl_outcomes']['data'][2]['y'] = (int) $result->rcategory3 + (int) $result->rcategory4;
		
		$data['vl_outcomes']['data'][0]['z'] = number_format($result->rcategory1);
		$data['vl_outcomes']['data'][1]['z'] = number_format($result->rcategory2);
		$data['vl_outcomes']['data'][2]['z'] = number_format($result->rcategory3 + $result->rcategory4);

		$data['vl_outcomes']['data'][0]['color'] = '#66ff66';
		$data['vl_outcomes']['data'][1]['color'] = '#1BA39C';
		$data['vl_outcomes']['data'][2]['color'] = '#F2784B';

		$data['vl_outcomes']['data'][0]['sliced'] = true;
		$data['vl_outcomes']['data'][0]['selected'] = true;

		$data['ul'] = "<p>  ";
		$data['ul'] .= "<= 400 copies/ml - " . number_format($result->rcategory1) . "<br />";
		$data['ul'] .= "401 - 999 copies/ml - " . number_format($result->rcategory2) . "<br />";
		$data['ul'] .= "Non Suppressed - " . number_format($result->rcategory3 + $result->rcategory4) . "<br />";
		$data['ul'] .= "<b>N.B.</b> These values exclude baseline tests. </p>";

		return $data;
	}

}
?>