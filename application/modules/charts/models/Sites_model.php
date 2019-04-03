<?php
defined('BASEPATH') or exit();

/**
* 
*/
class Sites_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}


	function sites_outcomes($year=null,$month=null,$partner=null,$to_year=null,$to_month=null)
	{
		
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_year');
		}
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

		if ($partner) {
			$sql = "CALL `proc_get_partner_sites_outcomes`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}  else {
			$sql = "CALL `proc_get_all_sites_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		// $sql = "CALL `proc_get_all_sites_outcomes`('".$year."','".$month."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();

		$data['outcomes'][0]['name'] = "Not Suppressed";
		$data['outcomes'][1]['name'] = "&lt; 1000";
		$data['outcomes'][2]['name'] = "&lt; LDL";
		$data['outcomes'][3]['name'] = "Suppression";
		$data['outcomes'][4]['name'] = "90% Target";

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "column";
		$data['outcomes'][3]['type'] = "spline";
		$data['outcomes'][4]['type'] = "spline"; 

		$data['outcomes'][0]['color'] = '#F2784B';
		$data['outcomes'][1]['color'] = '#1BA39C';
		$data['outcomes'][2]['color'] = '#66ff66';
		

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;
		$data['outcomes'][2]['yAxis'] = 1;

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][3]['tooltip'] = array("valueSuffix" => ' %');
		$data['outcomes'][4]['tooltip'] = array("valueSuffix" => ' %');

		$data['title'] = "";
 		$data['categories'][0] 			= "No Data";
		$data['outcomes'][0]['data'][0] = 0;
		$data['outcomes'][1]['data'][0] = 0;
		$data['outcomes'][2]['data'][0] = 0;
		$data['outcomes'][3]['data'][0] = 0;
		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data['outcomes'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$key] = (int) $value['less1000'];
			$data['outcomes'][2]['data'][$key] = (int) $value['undetected'];
			$data['outcomes'][3]['data'][$key] = round(@(((int) $value['suppressed']*100)/((int) $value['suppressed']+(int) $value['nonsuppressed'])),1);
			$data['outcomes'][4]['data'][$key] = 90;
		}
		
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function getSelectionData($resultage) {
		$counties = [];
		foreach ($resultage as $key => $value) {
			if (!in_array($value->selectionID, $counties))
				$counties[] = $value->selectionID;
		}

		return $counties;
	}

	public function getbreakdownGenderData($counties, $resultGender) {
		ini_set("memory_limit", "-1");
		$genderData = [];
		foreach ($counties as $key => $value) {
			foreach ($resultGender as $k => $v) {
				if ($value == $v->selectionID) {
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
		return $genderData;
	}

	public function getbreakdownAgeData($counties, $resultage) {
		ini_set("memory_limit", "-1");
		$ageData = [];
		foreach ($counties as $key => $value) {
			foreach ($resultage as $k => $v) {
				if ($value == $v->selectionID) {
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
		return $ageData;
	}

	public function getbreakdownData($counties, $resultage, $resultGender) {
		return ['ageData' => $this->getbreakdownAgeData($counties,$resultage), 'genderData' => $this->getbreakdownGenderData($counties,$resultGender)];
	}

	function partner_sites_outcomes($year=NULL,$month=NULL,$partner=NULL,$to_year=null,$to_month=null)
	{
		$table = '';
		$count = 1;

		if ($partner==null || $partner=='null')
			$partner = $this->session->userdata('partner_filter');

		if ($to_month==null || $to_month=='null')
			$to_month = 0;
		
		if ($to_year==null || $to_year=='null')
			$to_year = 0;
		
		if ($year==null || $year=='null')
			$year = $this->session->userdata('filter_year');

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		$type = 2;

		$sql = "CALL `proc_get_partner_sites_details`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";

		$sqlAge = "CALL `proc_get_vl_partner_agecategories_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$partner."');";
		$sqlGender = "CALL `proc_get_vl_partner_gender_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$partner."');";
		$this->db->close();
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		$resultage = $this->db->query($sqlAge)->result();
		$this->db->close();
		$resultGender = $this->db->query($sqlGender)->result();
		$this->db->close();

		$counties = $this->getSelectionData($resultage);
		$breakdownData = $this->getbreakdownData($counties, $resultage, $resultGender);
		// echo "<pre>";print_r($breakdownData);die();
		foreach ($result as $key => $value) {
			$routine = ((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000']);
			$routinesus = ((int) $value['less5000'] + (int) $value['above5000']);
			$validTests = ((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx']);
			$femaletests = ($breakdownData['genderData'][$value['facility']]['femaletests']) ? number_format((int) $breakdownData['genderData'][$value['facility']]['femaletests']) : 0;
			$femalesustx = ($breakdownData['genderData'][$value['facility']]['femalesustx']) ? number_format((int) $breakdownData['genderData'][$value['facility']]['femalesustx']) : 0;
			$maletests = ($breakdownData['genderData'][$value['facility']]['maletests']) ? number_format((int) $breakdownData['genderData'][$value['facility']]['maletests']) : 0;
			$malesustx = ($breakdownData['genderData'][$value['facility']]['malesustx']) ? number_format((int) $breakdownData['genderData'][$value['facility']]['malesustx']) : 0;
			$Nodatatests = ($breakdownData['genderData'][$value['facility']]['Nodatatests']) ? number_format((int) $breakdownData['genderData'][$value['facility']]['Nodatatests']) : 0;
			$Nodatasustx = ($breakdownData['genderData'][$value['facility']]['Nodatasustx']) ? number_format((int) $breakdownData['genderData'][$value['facility']]['Nodatasustx']) : 0;
			$less2tests = ($breakdownData['ageData'][$value['facility']]['less2tests']) ? number_format($breakdownData['ageData'][$value['facility']]['less2tests']) : 0;
			$less2sustx = ($breakdownData['ageData'][$value['facility']]['less2sustx']) ? number_format($breakdownData['ageData'][$value['facility']]['less2sustx']) : 0;
			$less9tests = ($breakdownData['ageData'][$value['facility']]['less9tests']) ? number_format($breakdownData['ageData'][$value['facility']]['less9tests']) : 0;
			$less9sustx = ($breakdownData['ageData'][$value['facility']]['less9sustx']) ? number_format($breakdownData['ageData'][$value['facility']]['less9sustx']) : 0;
			$less14tests = ($breakdownData['ageData'][$value['facility']]['less14tests']) ? number_format($breakdownData['ageData'][$value['facility']]['less14tests']) : 0;
			$less14sustx = ($breakdownData['ageData'][$value['facility']]['less14sustx']) ? number_format($breakdownData['ageData'][$value['facility']]['less14sustx']) : 0;
			$less19tests = ($breakdownData['ageData'][$value['facility']]['less19tests']) ? number_format($breakdownData['ageData'][$value['facility']]['less19tests']) : 0;
			$less19sustx = ($breakdownData['ageData'][$value['facility']]['less19sustx']) ? number_format($breakdownData['ageData'][$value['facility']]['less19sustx']) : 0;
			$less25tests = ($breakdownData['ageData'][$value['facility']]['less25tests']) ? number_format($breakdownData['ageData'][$value['facility']]['less25tests']) : 0;
			$less25sustx = ($breakdownData['ageData'][$value['facility']]['less25sustx']) ? number_format($breakdownData['ageData'][$value['facility']]['less25sustx']) : 0;
			$above25tests = ($breakdownData['ageData'][$value['facility']]['above25tests']) ? number_format($breakdownData['ageData'][$value['facility']]['above25tests']) : 0;
			$above25sustx = ($breakdownData['ageData'][$value['facility']]['above25sustx']) ? number_format($breakdownData['ageData'][$value['facility']]['above25sustx']) : 0;
			$table .= "<tr>
				<td>".$count."</td>
				<td>".$value['MFLCode']."</td>
				<td>".$value['name']."</td>
				<td>".$value['county']."</td>
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

	function sites_trends($year=null,$month=null,$site=null,$to_year=null,$to_month=null)
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
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}
		$data['year'] = $year;

		$sql = "CALL `proc_get_sites_trends`('".$site."','".$year."')";

		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		
		$months = array(1,2,3,4,5,6,7,8,9,10,11,12);
		$count = 0;


		$data['test_trends'][0]['name'] = 'Tests';
		$data['test_trends'][1]['name'] = 'Suppressed';
		$data['test_trends'][2]['name'] = 'Non Suppressed';
		$data['test_trends'][3]['name'] = 'Rejected';

		$data['test_trends'][0]['data'][0] = $count;
		$data['test_trends'][1]['data'][0] = $count;
		$data['test_trends'][2]['data'][0] = $count;
		$data['test_trends'][3]['data'][0] = $count;

		foreach ($months as $key1 => $value1) {
			foreach ($result as $key2 => $value2) {
				if ((int) $value1 == (int) $value2['month']) {
					$data['test_trends'][0]['data'][$count] = ((int) $value2['undetected']+(int) $value2['less1000']+(int) $value2['less5000']+(int) $value2['above5000'] + (int) $value2['confirmtx'] + (int) $value2['baseline']);
					$data['test_trends'][1]['data'][$count] = (int) $value2['undetected']+(int) $value2['less1000'];
					$data['test_trends'][2]['data'][$count] = (int) $value2['less5000']+(int) $value2['above5000'];
					$data['test_trends'][3]['data'][$count] = (int) $value2['rejected'];

					$count++;
				}
				
			}
		}
		
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function site_outcomes_chart($year=null,$month=null,$site=null,$to_year=null,$to_month=null)
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
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}
		
		$sql = "CALL `proc_get_sites_sample_types`('".$site."','".$year."')";
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$months = array(1,2,3,4,5,6,7,8,9,10,11,12);

		$data['sample_types'][0]['name'] = 'EDTA';
		$data['sample_types'][1]['name'] = 'DBS';
		$data['sample_types'][2]['name'] = 'Plasma';

		$count = 0;
		
		$data['categories'] = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
		$data["sample_types"][0]["data"][0]	= $count;
		$data["sample_types"][1]["data"][0]	= $count;
		$data["sample_types"][2]["data"][0]	= $count;

		foreach ($months as $key => $value) {
			foreach ($result as $key1 => $value1) {
				if ((int) $value == (int) $value1['month']) {
					$data["sample_types"][0]["data"][$key]	= (int) $value1['edta'];
					$data["sample_types"][1]["data"][$key]	= (int) $value1['dbs'];
					$data["sample_types"][2]["data"][$key]	= (int) $value1['plasma'];

					$count++;
				}
				
			}
		}
		 // echo "<pre>";print_r($data);die();
		return $data;
	}

	function sites_vloutcomes($year=null,$month=null,$site=null,$to_year=null,$to_month=null)
	{
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		
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

		$sql = "CALL `proc_get_sites_vl_outcomes`('".$site."','".$year."','".$month."','".$to_year."','".$to_month."')";
		$sql2 = "CALL `proc_get_vl_current_suppression`('4','".$site."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$this->db->close();
		
		// echo "<pre>";print_r($result);die();
		$color = array('#6BB9F0', '#F2784B', '#1BA39C', '#5C97BF');

		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;
		$data['ul'] = '';

		$data['vl_outcomes']['data'][0]['name'] = '&lt; 1000';
		$data['vl_outcomes']['data'][1]['name'] = '&lt; LDL';
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
			
			// 	<td colspan="2">Cumulative Tests (All Samples Run):</td>
	    	// 	<td colspan="2">'.number_format($value['alltests']).'</td>
	    	// </tr>
	    	// <tr>
			$data['ul'] .= '
			<tr>
	    		<td>Total VL tests done:</td>
	    		<td>'.number_format($total_tests ).'</td>
	    		<td>Non Suppression</td>
	    		<td>'. number_format($non_suppressed) . ' (' . round((($non_suppressed / $total_tests  )*100),1).'%)</td>
	    	</tr>
 
			<tr>
	    		<td colspan="2">&nbsp;&nbsp;&nbsp;Routine VL Tests with Valid Outcomes:</td>
	    		<td colspan="2">'.number_format($total).'</td>
	    	</tr>
 
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests &gt; 1000 copies/ml:</td>
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
	    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests &lt; LDL:</td>
	    		<td>'.number_format($value['undetected']).'</td>
	    		<td>Percentage Undetectable</td>
	    		<td>'.round((@($value['undetected']/$total)*100),1).'%</td>
	    	</tr>
 
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;Baseline VLs:</td>
	    		<td>'.number_format($value['baseline']).'</td>
	    		<td>Non Suppression ( &gt; 1000cpml)</td>
	    		<td>'.number_format($value['baselinesustxfail']). ' (' .round(($value['baseline'] * 100 / $value['baselinesustxfail']), 1). '%)' .'</td>
	    	</tr>
 
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;Confirmatory Repeat Tests:</td>
	    		<td>'.number_format($value['confirmtx']).'</td>
	    		<td>Non Suppression ( &gt; 1000cpml)</td>
	    		<td>'.number_format($value['confirm2vl']). ' (' .round(($value['confirm2vl'] * 100 / $value['confirmtx']), 1). '%)' .'</td>
	    	</tr>
 
	    	<tr>
	    		<td>Rejected Samples:</td>
	    		<td>'.number_format($value['rejected']).'</td>
	    		<td>Percentage Rejection Rate</td>
	    		<td>'. round((($value['rejected']*100)/$value['received']), 1, PHP_ROUND_HALF_UP).'%</td>
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

	function sites_age($year=null,$month=null,$site=null,$to_year=null,$to_month=null)
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
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		$sql = "CALL `proc_get_sites_age`('".$site."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$count = 0;
		$loop = 0;
		$name = '';
		$nonsuppressed = 0;
		$suppressed = 0;
		
		// echo "<pre>";print_r($result);die();
		$data['ageGnd'][0]['name'] = 'Not Suppressed';
		$data['ageGnd'][1]['name'] = 'Suppressed';
 
		$count = 0;
		
		$data["ageGnd"][0]["data"][0]	= $count;
		$data["ageGnd"][1]["data"][0]	= $count;
		$data['categories'][0]			= 'No Data';
 
		foreach ($result as $key => $value) {
			if ($value['name']=='No Data') {
				$loop = $key;
				$name = $value['name'];
				$nonsuppressed = $value['nonsuppressed'];
				$suppressed = $value['suppressed'];
			} else if ($value['name']=='Less 2') {
				$loop = $key;
				$name = $value['name'];
				$nonsuppressed = $value['nonsuppressed'];
				$suppressed = $value['suppressed'];
			} else if ($value['name']=='2-9') {
				$loop = $key;
				$name = $value['name'];
				$nonsuppressed = $value['nonsuppressed'];
				$suppressed = $value['suppressed'];
			} else if ($value['name']=='10-14') {
				$loop = $key;
				$name = $value['name'];
				$nonsuppressed = $value['nonsuppressed'];
				$suppressed = $value['suppressed'];
			} else if ($value['name']=='15-19') {
				$loop = $key;
				$name = $value['name'];
				$nonsuppressed = $value['nonsuppressed'];
				$suppressed = $value['suppressed'];
			} else if ($value['name']=='20-24') {
				$loop = $key;
				$name = $value['name'];
				$nonsuppressed = $value['nonsuppressed'];
				$suppressed = $value['suppressed'];
			} else if ($value['name']=='25+') {
				$loop = $key;
				$name = $value['name'];
				$nonsuppressed = $value['nonsuppressed'];
				$suppressed = $value['suppressed'];
			}
			
			$data['categories'][$loop] 			= $name;
			$data["ageGnd"][0]["data"][$loop]	=  (int) $nonsuppressed;
			$data["ageGnd"][1]["data"][$loop]	=  (int) $suppressed;
		}
		// die();
		$data['ageGnd'][0]['drilldown']['color'] = '#913D88';
		$data['ageGnd'][1]['drilldown']['color'] = '#96281B';
 
		// echo "<pre>";print_r($data);die();
		$data['categories'] = array_values($data['categories']);
		$data["ageGnd"][0]["data"] = array_values($data["ageGnd"][0]["data"]);
		$data["ageGnd"][1]["data"] = array_values($data["ageGnd"][1]["data"]);
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function sites_gender($year=null,$month=null,$site=null,$to_year=null,$to_month=null)
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
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		$sql = "CALL `proc_get_sites_gender`('".$site."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['gender'][0]['name'] = 'Not Suppressed';
		$data['gender'][1]['name'] = 'Suppressed';
 
		$count = 0;
		
		$data["gender"][0]["data"][0]	= $count;
		$data["gender"][1]["data"][0]	= $count;
		$data['categories'][0]			= 'No Data';
 
		foreach ($result as $key => $value) {
			$data['categories'][$key] 			= $value['name'];
			$data["gender"][0]["data"][$key]	=  (int) $value['nonsuppressed'];
			$data["gender"][1]["data"][$key]	=  (int) $value['suppressed'];
		}
 
		$data['gender'][0]['drilldown']['color'] = '#913D88';
		$data['gender'][1]['drilldown']['color'] = '#96281B';
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function partner_sites_outcomes_download($year=NULL,$month=NULL,$partner=NULL,$to_year=null,$to_month=null)
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

		$sql = "CALL `proc_get_partner_sites_details`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$data = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($data);die();
		

		// $this->load->helper('download');
  //       $this->load->library('PHPReport/PHPReport');

  //       ini_set('memory_limit','-1');
	 //    ini_set('max_execution_time', 900);


  //       $template = 'partner_sites.xlsx';

	 //    //set absolute path to directory with template files
	 //    $templateDir = __DIR__ . "/";
	    
	 //    //set config for report
	 //    $config = array(
	 //        'template' => $template,
	 //        'templateDir' => $templateDir
	 //    );


	 //      //load template
	 //    $R = new PHPReport($config);
	    
	 //    $R->load(array(
	 //            'id' => 'data',
	 //            'repeat' => TRUE,
	 //            'data' => $data   
	 //        )
	 //    );
	      
	 //      // define output directoy 
	 //    $output_file_dir = __DIR__ ."/tmp/";
	 //     // echo "<pre>";print_r("Still working");die();

	 //    $output_file_excel = $output_file_dir  . "partner_sites.xlsx";
	 //    //download excel sheet with data in /tmp folder
	 //    $result = $R->render('excel', $output_file_excel);
	 //    force_download($output_file_excel, null);	

        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

	    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('MFL Code', 'Name', 'County', 'Received', 'Rejected', 'All Tests', 'Redraws', 'Undetected', 'less1000', 'above1000 - less5000', 'above5000', 'Baseline Tests', 'Baseline >1000', 'Confirmatory Tests', 'Confirmatory >1000');

	    fputcsv($f, $b, $delimiter);

	    foreach ($data as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="vl_partner_sites.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
		
	}


	function justification($year=null,$month=null,$site=null,$to_year=null,$to_month=null)
	{
		
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
 
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
 
		$sql = "CALL `proc_get_vl_site_justification`('".$site."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		
		$data['justification']['name'] = 'Tests';
		$data['justification']['colorByPoint'] = true;
 
		$count = 0;
 
		$data['justification']['data'][0]['name'] = 'No Data';
 
		foreach ($result as $key => $value) {
			if($value['name'] == 'Routine VL'){
				$data['justification']['data'][$key]['color'] = '#5C97BF';
			}
			$data['justification']['data'][$key]['y'] = $count;
			
			$data['justification']['data'][$key]['name'] = $value['name'];
			$data['justification']['data'][$key]['y'] = (int) $value['justifications'];
		}
 
		$data['justification']['data'][0]['sliced'] = true;
		$data['justification']['data'][0]['selected'] = true;
		// echo "<pre>";print_r($data);die();
		return $data;
	}
 
	function justification_breakdown($year=null,$month=null,$site=null,$to_year=null,$to_month=null)
	{
		
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
 
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			$month = $this->session->userdata('filter_month');
		}
 

		$sql = "CALL `proc_get_vl_pmtct`('1','".$year."','".$month."','".$to_year."','".$to_month."','','','','','".$site."')";
		$sql2 = "CALL `proc_get_vl_pmtct`('2','".$year."','".$month."','".$to_year."','".$to_month."','','','','','".$site."')";

		
		
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



	function get_patients($site=null,$year=null,$month=null,$to_year=NULL,$to_month=NULL)
	{
		$type = 0;

		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
				$type = 1;
			}else {
				$month = $this->session->userdata('filter_month');
				$type = 3;
			}
		}
		
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

		if ($type == 0) {
			if($to_year == 0){
				$type = 3;
			}
			else{
				$type = 5;
			}
		}	

		$query = $this->db->get_where('facilitys', array('id' => $site), 1)->row();

		$facility = $query->facilitycode;

		$this->db->close();

		$sql = "CALL `proc_get_vl_site_patients`('".$site."','".$year."')";
		$res = $this->db->query($sql)->row();

		$this->db->close();
		

		$params = "patient/facility/{$facility}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
		// $params = "patient/national/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";

		$result = $this->req($params);

		// echo "<pre>";print_r($result);die();

		$data['outcomes'][0]['name'] = "Patients grouped by tests received";

		$data['title'] = " ";

		$data['unique_patients'] = 0;
		$data['size'] = 0;
		$data['total_patients'] = $query->totalartmar;
		$data['total_tests'] = 0;

		foreach ($result as $key => $value) {

			$data['categories'][$key] = $value->tests;
		
			$data['outcomes'][0]['data'][$key] = (int) $value->totals;
		
			$data['outcomes'][0]['data'][$key] = (int) $value->totals;
			$data['unique_patients'] += (int) $value->totals;
			$data['total_tests'] += ($data['categories'][$key] * $data['outcomes'][0]['data'][$key]);
			$data['size']++;


		}

		$data['coverage'] = round(($data['unique_patients'] / $data['total_patients'] * 100), 2);

		// $data['stats'] = "<tr><td>" . $result->total_tests . "</td><td>" . $result->one . "</td><td>" . $result->two . "</td><td>" . $result->three . "</td><td>" . $result->three_g . "</td></tr>";

		// $unmet = $res->totalartmar - $result->total_patients;
		// $unmet_p = round((($unmet / (int) $res->totalartmar) * 100),2);

		// $data['tests'] = $result->total_tests;
		// $data['patients_vl'] = $result->total_patients;
		// $data['patients'] = $res->totalartmar;
		// $data['unmet'] = $unmet;
		// $data['unmet_p'] = $unmet_p;

		return $data;
	}

	function current_suppression($site=null){
		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		$sql = "CALL `proc_get_vl_current_suppression`('4','".$site."')";
		$result = $this->db->query($sql)->row();

		$this->db->close();
		
		// echo "<pre>";print_r($result);die();
		$color = array('#6BB9F0', '#F2784B', '#1BA39C', '#5C97BF');

		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;
		$data['ul'] = '';


		$data['vl_outcomes']['data'][0]['name'] = '401 - 1000 copies/ml';
		$data['vl_outcomes']['data'][1]['name'] = '< 400 copies/ml';
		$data['vl_outcomes']['data'][2]['name'] = '> 1000 copies/ml';

		$data['vl_outcomes']['data'][0]['y'] = (int) $result->less1000;
		$data['vl_outcomes']['data'][1]['y'] = (int) $result->undetected;
		$data['vl_outcomes']['data'][2]['y'] = (int) $result->nonsuppressed;

		$data['vl_outcomes']['data'][0]['z'] = number_format($result->less1000);
		$data['vl_outcomes']['data'][1]['z'] = number_format($result->undetected);
		$data['vl_outcomes']['data'][2]['z'] = number_format($result->nonsuppressed);

		$data['vl_outcomes']['data'][0]['color'] = '#1BA39C';
		$data['vl_outcomes']['data'][1]['color'] = '#66ff66';
		$data['vl_outcomes']['data'][2]['color'] = '#F2784B';		

		$data['vl_outcomes']['data'][1]['sliced'] = true;
		$data['vl_outcomes']['data'][1]['selected'] = true;

		$data['ul'] = "<p>  ";
		$data['ul'] .= "< 400 copies/ml - " . number_format($result->undetected) . "<br />";
		$data['ul'] .= "401 - 1000 copies/ml - " . number_format($result->less1000) . "<br />";
		$data['ul'] .= "Non Suppressed - " . number_format($result->nonsuppressed) . "<br />";
		$data['ul'] .= "<b>N.B.</b> These values exclude baseline tests. </p>";
		
		return $data;
	}


	function get_patients_outcomes($site=null,$year=null,$month=null,$to_year=NULL,$to_month=NULL)
	{
		$type = 0;

		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
				$type = 1;
			}else {
				$month = $this->session->userdata('filter_month');
				$type = 3;
			}
		}
		
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

		if ($type == 0) {
			if($to_year == 0){
				$type = 3;
			}
			else{
				$type = 5;
			}
		}		

		$query = $this->db->get_where('facilitys', array('id' => $site), 1)->row();

		$facility = $query->facilitycode;

		$params = "patient/facility/{$facility}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";

		$result = $this->req($params);

		$data['categories'] = array('Total Patients', "VL's Done");
		$data['outcomes']['name'] = 'Tests';
		$data['outcomes']['data'][0] = (int) $result->total_patients;
		$data['outcomes']['data'][1] = (int) $result->total_tests;
		$data["outcomes"]["color"] =  '#1BA39C';

		return $data;
	}

	function get_patients_graph($site=null,$year=null,$month=null,$to_year=NULL,$to_month=NULL)
	{
		$type = 0;

		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
				$type = 1;
			}else {
				$month = $this->session->userdata('filter_month');
				$type = 3;
			}
		}
		
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

		if ($type == 0) {
			if($to_year == 0){
				$type = 3;
			}
			else{
				$type = 5;
			}
		}		

		$query = $this->db->get_where('facilitys', array('id' => $site), 1)->row();

		$facility = $query->facilitycode;

		$params = "patient/facility/{$facility}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";

		$result = $this->req($params);

		$data['categories'] = array('1 VL', '2 VL', '3 VL', '> 3 VL');
		$data['outcomes']['name'] = 'Tests';
		$data['outcomes']['data'][0] = (int) $result->one;
		$data['outcomes']['data'][1] = (int) $result->two;
		$data['outcomes']['data'][2] = (int) $result->three;
		$data['outcomes']['data'][3] = (int) $result->three_g;
		$data["outcomes"]["color"] =  '#1BA39C';

		return $data;
	}
	

	// function get_patients($site=null,$year=null){
	// 	if ($year==null || $year=='null') {
	// 		$year = $this->session->userdata('filter_year');
	// 	}
	// 	if ($site==null || $site=='null') {
	// 		$site = $this->session->userdata('site_filter');
	// 	}

	// 	$sql = "CALL `proc_get_vl_site_patients`('".$site."','".$year."')";
	// 	// echo "<pre>";print_r($sql);die();
	// 	$result = $this->db->query($sql)->row();

	// 	$data['stats'] = "<tr><td>" . $result->alltests . "</td><td>" . $result->onevl . "</td><td>" . $result->twovl . "</td><td>" . $result->threevl . "</td><td>" . $result->above3vl . "</td></tr>";

	// 	$data['tests'] = $result->alltests;
	// 	$data['patients'] = $result->totalartmar;
	// 	$unmet = (int) $result->totalartmar - (int) $result->alltests;
	// 	$unmet_p = round((($unmet / (int) $result->totalartmar) * 100),2);
	// 	$data['unmet'] = $unmet_p;

	// 	return $data;
	// }

	// function get_patients_outcomes($site=null,$year=null){
	// 	if ($year==null || $year=='null') {
	// 		$year = $this->session->userdata('filter_year');
	// 	}
	// 	if ($site==null || $site=='null') {
	// 		$site = $this->session->userdata('site_filter');
	// 	}

	// 	$sql = "CALL `proc_get_vl_site_patients`('".$site."','".$year."')";
	// 	// echo "<pre>";print_r($sql);die();
	// 	$result = $this->db->query($sql)->row();
	// 	// echo "<pre>";print_r($result);die();
	// 	$data['categories'] = array('Total Patients', "VL's Done");
	// 	$data['outcomes']['name'] = 'Tests';
	// 	$data['outcomes']['data'][0] = (int) $result->totalartmar;
	// 	$data['outcomes']['data'][1] = (int) $result->alltests;
	// 	$data["outcomes"]["color"] =  '#1BA39C';

	// 	return $data;
	// }

	

	// function get_patients_graph($site=null,$year=null){
	// 	if ($year==null || $year=='null') {
	// 		$year = $this->session->userdata('filter_year');
	// 	}
	// 	if ($site==null || $site=='null') {
	// 		$site = $this->session->userdata('site_filter');
	// 	}

	// 	$sql = "CALL `proc_get_vl_site_patients`('".$site."','".$year."')";
	// 	// echo "<pre>";print_r($sql);die();
	// 	$result = $this->db->query($sql)->row();

	// 	$data['categories'] = array('1 VL', '2 VL', '3 VL', '> 3 VL');
	// 	$data['outcomes']['name'] = 'Tests';
	// 	$data['outcomes']['data'][0] = (int) $result->onevl;
	// 	$data['outcomes']['data'][1] = (int) $result->twovl;
	// 	$data['outcomes']['data'][2] = (int) $result->threevl;
	// 	$data['outcomes']['data'][3] = (int) $result->above3vl;
	// 	$data["outcomes"]["color"] =  '#1BA39C';

	// 	return $data;


	// }


	function site_patients($site=null,$year=null,$month=null,$to_year=NULL,$to_month=NULL)
	{
		$type = 0;

		if ($site==null || $site=='null') {
			$site = $this->session->userdata('site_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
				$type = 1;
			}else {
				$month = $this->session->userdata('filter_month');
				$type = 3;
			}
		}
		
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}

		if ($type == 0) {
			if($to_year == 0){
				$type = 3;
			}
			else{
				$type = 5;
			}
		}		

		$query = $this->db->get_where('facilitys', array('id' => $site), 1)->row();

		$facility = $query->facilitycode;

		$params = "patient/facility/{$facility}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";

		$data = $this->req($params);

		return $data;
	}
}
?>