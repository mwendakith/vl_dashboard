<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class Agencies_model extends MY_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function suppression($year=null,$month=null,$to_year=null,$to_month,$type=null,$agency_id=null) {
		if ($year==null || $year=='null') 
			$year = $this->session->userdata('filter_year');
		
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		if ($to_month==null || $to_month=='null') 
			$to_month = 0;
		if ($to_year==null || $to_year=='null') 
			$to_year = 0;

		if ($type==null || $type == 'null')
			$type = 0;
		if ($agency_id==null || $agency_id == 'null')
			$agency_id = $this->session->userdata('funding_agency_filter');

		$sql = "CALL `proc_get_vl_agencies_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$agency_id."')";

		$result = $this->db->query($sql)->result_array();

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
		$data['categories'][0] 		   = 'No Data';
		$data['outcomes'][0]['data'][0] = (int) 0;
		$data['outcomes'][1]['data'][0] = (int) 0;
		$data['outcomes'][2]['data'][0] = (int) 0;
		$data['outcomes'][3]['data'][0] = (int) 0;
 
		foreach ($result as $key => $value) {
			if (!((int) $value['suppressed'] == 0 && (int) $value['nonsuppressed'] == 0)){
				$suppressed = (int)$value['suppressed'];
				$nonsuppressed = (int)$value['nonsuppressed'];
				$data['categories'][$key] 		   = $value['agency'];
				$data['outcomes'][0]['data'][$key] = (int) $nonsuppressed;
				$data['outcomes'][1]['data'][$key] = (int) $suppressed;
				$data['outcomes'][2]['data'][$key] = round(@(((int) $suppressed*100)/((int) $suppressed+(int) $nonsuppressed)),1);
				$data['outcomes'][3]['data'][$key] = 90;
			}
		}
		
		return $data;

	}

	public function current_suppression($agency_id) {
		if ($agency_id==null || $agency_id == 'null')
			$agency_id = $this->session->userdata('funding_agency_filter');
		$sql = "CALL `proc_get_vl_current_suppression`('5','".$agency_id."')";
		$result = $this->db->query($sql)->result();
		$this->db->close();
		
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
		$data['categories'][0] 		   = 'No Data';
		$data['outcomes'][0]['data'][0] = (int) 0;
		$data['outcomes'][1]['data'][0] = (int) 0;
		$data['outcomes'][2]['data'][0] = (int) 0;
		$data['outcomes'][3]['data'][0] = (int) 0;
 
		foreach ($result as $key => $value) {
			if (!((int) $value->suppressed == 0 && (int) $value->nonsuppressed == 0)){
				$data['categories'][$key] 		   = $value->partners;
				$data['outcomes'][0]['data'][$key] = (int) $value->nonsuppressed;
				$data['outcomes'][1]['data'][$key] = (int) $value->suppressed;
				$data['outcomes'][2]['data'][$key] = round(@(((int) $value->suppressed*100)/((int) $value->suppressed+(int) $value->nonsuppressed)),1);
				$data['outcomes'][3]['data'][$key] = 90;
			}
		}
		
		return $data;
	}

	public function outcomes ($year=null,$month=null,$to_year=null,$to_month,$type=null,$agency_id=null) {

	}
 
	function vl_outcomes($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id=null) {
		if ($type == null || $to_month=='null')
			$type = 0;
		
		if ($agency_id==null || $agency_id == 'null')
			$agency_id = $this->session->userdata('funding_agency_filter');

		if ($to_month==null || $to_month=='null')
			$to_month = 0;
		
		if ($to_year==null || $to_year=='null')
			$to_year = 0;
		 
		if ($year==null || $year=='null')
			$year = $this->session->userdata('filter_year');
		
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
 
		$sql = "CALL `proc_get_vl_funding_agencies_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$agency_id."')";
		$sql2 = "CALL `proc_get_vl_fundingagencies_sitessending`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$agency_id."')";
		// $sql3 = "CALL `proc_get_vl_current_suppression`('1','".$county."')";
		
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		$sitessending = $this->db->query($sql2)->result_array();
		$this->db->close();
		
		$color = array('#6BB9F0', '#F2784B', '#1BA39C', '#5C97BF');
 
		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;
		$data['ul'] = '';
 
		$data['vl_outcomes']['data'][0]['name'] = 'Suppressed';
		$data['vl_outcomes']['data'][1]['name'] = 'Not Suppressed';
 
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
	    		<td>'.number_format($total_tests ).'</td>
	    		<td>Non Suppression</td>
	    		<td>'. number_format($non_suppressed) . ' (' . round((@($non_suppressed / $total_tests  )*100),1).'%)</td>
	    	</tr>
 
			<tr>
	    		<td colspan="2">&nbsp;&nbsp;&nbsp;Routine VL Tests with Valid Outcomes:</td>
	    		<td colspan="2">'.number_format($total).'</td>
	    	</tr>
 
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests &gt; 1000 copies/ml:</td>
	    		<td>'.number_format($greater).'</td>
	    		<td>Percentage Non Suppression</td>
	    		<td>'.round((@($greater/$total)*100),1).'%</td>
	    	</tr>
 
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests &lt;= 400 copies/ml:</td>
	    		<td>'.number_format($value['undetected']).'</td>
	    		<td>Percentage Suppression</td>
	    		<td>'.round((@($value['undetected']/$total)*100),1).'%</td>
	    	</tr>
 
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests 401 - 999 copies/ml:</td>
	    		<td>'.number_format($value['less1000']).'</td>
	    		<td>Percentage Suppression</td>
	    		<td>'.round((@($value['less1000']/$total)*100),1).'%</td>
	    	</tr>
  
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;Baseline VLs:</td>
	    		<td>'.number_format($value['baseline']).'</td>
	    		<td>Non Suppression ( &gt;= 1000cpml)</td>
	    		<td>'.number_format($value['baselinesustxfail']). ' (' .round(@($value['baselinesustxfail'] * 100 / $value['baseline']), 1). '%)' .'</td>
	    	</tr>
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;Confirmatory Repeat Tests:</td>
	    		<td>'.number_format($value['confirmtx']).'</td>
	    		<td>Non Suppression ( &gt;= 1000cpml)</td>
	    		<td>'.number_format($value['confirm2vl']). ' (' .round(@($value['confirm2vl'] * 100 / $value['confirmtx']), 1). '%)' .'</td>
	    	</tr>
 
	    	<tr>
	    		<td>Rejected Samples:</td>
	    		<td>'.number_format($value['rejected']).'</td>
	    		<td>Percentage Rejection Rate</td>
	    		<td>'. round(@(($value['rejected']*100)/$value['received']), 1, PHP_ROUND_HALF_UP).'%</td>
	    	</tr>';
						
			$data['vl_outcomes']['data'][0]['y'] = (int) $value['undetected']+(int) $value['less1000'];
			$data['vl_outcomes']['data'][1]['y'] = (int) $value['less5000']+(int) $value['above5000'];
 
			$data['vl_outcomes']['data'][0]['color'] = '#1BA39C';
			$data['vl_outcomes']['data'][1]['color'] = '#F2784B';
		}
 
		$count = 0;
		$sites = 0;
		foreach ($sitessending as $key => $value) {
			if ((int) $value['sitessending'] != 0) {
				$sites = (int) $sites + (int) $value['sitessending'];
				$count++;
			}
		}
		
		$data['ul'] .= "<tr> <td colspan=2>Average Sites Sending:</td><td colspan=2>".number_format(round(@($sites / $count)))."</td></tr>";
		$count = 1;
		$sites = 0;
 
		$data['vl_outcomes']['data'][0]['sliced'] = true;
		$data['vl_outcomes']['data'][0]['selected'] = true;
		
		return $data;
	}
 
	function justification($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id=null)
	{
		if ($type == null || $to_month=='null')
			$type = 0;
		
		if ($agency_id==null || $agency_id == 'null')
			$agency_id = $this->session->userdata('funding_agency_filter');

		if ($to_month==null || $to_month=='null')
			$to_month = 0;
		
		if ($to_year==null || $to_year=='null')
			$to_year = 0;
		
 
		if ($year==null || $year=='null')
			$year = $this->session->userdata('filter_year');
		
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
 
		$sql = "CALL `proc_get_vl_fundingagencies_justification`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$agency_id."')";
		
		$result = $this->db->query($sql)->result_array();
		
		$count = 0;
 		$data['justification']['name'] = 'Tests';
		$data['justification']['colorByPoint'] = true;
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
 
	// function justification_breakdown($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id=null)
	// {
	// 	if ($to_month==null || $to_month=='null')
	// 		$to_month = 0;
		
	// 	if ($to_year==null || $to_year=='null')
	// 		$to_year = 0;
 
	// 	if ($year==null || $year=='null')
	// 		$year = $this->session->userdata('filter_year');
		
	// 	if ($month==null || $month=='null')
	// 		$month = $this->session->userdata('filter_month');
		 
	// 	if (!is_null($partner)) {
	// 		$sql = "CALL `proc_get_vl_pmtct`('1','".$year."','".$month."','".$to_year."','".$to_month."','','','".$partner."','','')";
	// 		$sql2 = "CALL `proc_get_vl_pmtct`('2','".$year."','".$month."','".$to_year."','".$to_month."','','','".$partner."','','')";
	// 	} else {
	// 		if ($county==null || $county=='null') {
	// 			$sql = "CALL `proc_get_vl_pmtct`('1','".$year."','".$month."','".$to_year."','".$to_month."','1','','','','')";
	// 			$sql2 = "CALL `proc_get_vl_pmtct`('2','".$year."','".$month."','".$to_year."','".$to_month."','1','','','','')";
	// 		} else {
	// 			$sql = "CALL `proc_get_vl_pmtct`('1','".$year."','".$month."','".$to_year."','".$to_month."','','".$county."','','','')";
	// 			$sql2 = "CALL `proc_get_vl_pmtct`('2','".$year."','".$month."','".$to_year."','".$to_month."','','".$county."','','','')";
	// 		}
	// 	}
		
	// 	$preg_mo = $this->db->query($sql)->result_array();
	// 	$this->db->close();
	// 	$lac_mo = $this->db->query($sql2)->result_array();
		
	// 	$count = 0;
	// 	$data['just_breakdown'][0]['name'] = 'Not Suppressed';
	// 	$data['just_breakdown'][1]['name'] = 'Suppressed';
	// 	$data["just_breakdown"][0]["data"][0]	= $count;
	// 	$data["just_breakdown"][1]["data"][0]	= $count;
	// 	$data['categories'][0]			= 'No Data';
 
	// 	foreach ($preg_mo as $key => $value) {
	// 		$data['categories'][0] 			= 'Pregnant Mothers';
	// 		$data["just_breakdown"][0]["data"][0]	=  (int) $value['less5000'] + (int) $value['above5000'];
	// 		$data["just_breakdown"][1]["data"][0]	=  (int) $value['undetected'] + (int) $value['less1000'];
	// 	}
 
	// 	foreach ($lac_mo as $key => $value) {
	// 		$data['categories'][1] 			= 'Lactating Mothers';
	// 		$data["just_breakdown"][0]["data"][1]	=  (int) $value['less5000'] + (int) $value['above5000'];
	// 		$data["just_breakdown"][1]["data"][1]	=  (int) $value['undetected'] + (int) $value['less1000'];
	// 	}
 
	// 	$data['just_breakdown'][0]['drilldown']['color'] = '#913D88';
	// 	$data['just_breakdown'][1]['drilldown']['color'] = '#96281B';
				
	// 	return $data;
	// }
 
	function age($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id=null)
	{
		if ($type == null || $to_month=='null')
			$type = 0;
		
		if ($agency_id==null || $agency_id == 'null')
			$agency_id = $this->session->userdata('funding_agency_filter');

		if ($to_month==null || $to_month=='null') 
			$to_month = 0;
		
		if ($to_year==null || $to_year=='null') 
			$to_year = 0;
		 
		if ($year==null || $year=='null') 
			$year = $this->session->userdata('filter_year');
		
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
 
		$sql = "CALL `proc_get_vl_fundingagencies_age`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$agency_id."')";
		
		$result = $this->db->query($sql)->result_array();
		$count = 0;
		$loop = 0;
		$name = '';
		$nonsuppressed = 0;
		$suppressed = 0;
		
		$count = 0;
		$data['ageGnd'][0]['name'] = 'Not Suppressed';
		$data['ageGnd'][1]['name'] = 'Suppressed';
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
		
		$data['ageGnd'][0]['drilldown']['color'] = '#913D88';
		$data['ageGnd'][1]['drilldown']['color'] = '#96281B';
 		$data['categories'] = array_values($data['categories']);
		$data["ageGnd"][0]["data"] = array_values($data["ageGnd"][0]["data"]);
		$data["ageGnd"][1]["data"] = array_values($data["ageGnd"][1]["data"]);
		
		return $data;
	}
 
	// function age_breakdown($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id=null)
	// {
	// 	if ($to_month==null || $to_month=='null') 
	// 		$to_month = 0;
		
	// 	if ($to_year==null || $to_year=='null') 
	// 		$to_year = 0;
		
 
	// 	if ($year==null || $year=='null') 
	// 		$year = $this->session->userdata('filter_year');
		
	// 	if ($month==null || $month=='null') {
	// 		if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
	// 			$month = $this->session->userdata('filter_month');
	// 		}else {
	// 			$month = 0;
	// 		}
	// 	}
 
	// 	if (!is_null($partner)) {
	// 		$sql = "CALL `proc_get_partner_age`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
	// 	} else {
	// 		if ($county==null || $county=='null') {
	// 			$sql = "CALL `proc_get_national_age`('".$year."','".$month."','".$to_year."','".$to_month."')";
	// 		} else {
	// 			$sql = "CALL `proc_get_regional_age`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
	// 		}
	// 	}
	// 	$result = $this->db->query($sql)->result_array();
		
	// 	$data['children']['name'] = 'Tests';
	// 	$data['children']['colorByPoint'] = true;
 // 		$data['adults']['name'] = 'Tests';
	// 	$data['adults']['colorByPoint'] = true;
	// 	$adults = 0;
	// 	$sadult = 0;
	// 	$children = 0;
	// 	$schildren = 0;
	// 	$count = 0;
 
	// 	foreach ($result as $key => $value) {
			
	// 		if ($value['name']=='Less 2' || $value['name']=='2-9' || $value['name']=='10-14') {
	// 			$data['ul']['children'] = '';
	// 			$children = (int) $children + (int) $value['agegroups'];
	// 			$schildren = (int) $schildren + (int) $value['suppressed'];
	// 			$data['children']['data'][$key]['y'] = $count;
	// 			$data['children']['data'][$key]['name'] = $value['name'];
	// 			$data['children']['data'][$key]['y'] = (int) $value['agegroups'];
 
	// 		} else if ($value['name']=='15-19' || $value['name']=='20-24' || $value['name']=='25+') {
	// 			$data['ul']['adults'] = '';
	// 			$adults = (int) $adults + (int) $value['agegroups'];
	// 			$sadult = (int) $sadult + (int) $value['suppressed'];
	// 			$data['adults']['data'][$key]['y'] = $count;
	// 			$data['adults']['data'][$key]['name'] = $value['name'];
	// 			$data['adults']['data'][$key]['y'] = (int) $value['agegroups'];
	// 		}
	// 	}
		
	// 	$data['ctotal'] = $children;
	// 	$data['atotal'] = $adults;
		
	// 	$data['ul']['children'] = '<li>Children Suppression : '.(int)(((int) $schildren/(int) $children)*100).'%</li>';
	// 	$data['ul']['adults'] = '<li>Adult Suppression : '.(int)(((int) $sadult/(int) $adults)*100).'%</li>';
	// 	$data['children']['data'] = array_values($data['children']['data']);
	// 	$data['adults']['data'] = array_values($data['adults']['data']);
 
	// 	$data['children']['data'][0]['sliced'] = true;
	// 	$data['children']['data'][0]['selected'] = true;
 
	// 	$data['adults']['data'][0]['sliced'] = true;
	// 	$data['adults']['data'][0]['selected'] = true;
 
	// 	return $data;
	// }
 
	function gender($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$agency_id=null)
	{
		if ($type == null || $to_month=='null')
			$type = 0;
		
		if ($agency_id==null || $agency_id == 'null')
			$agency_id = $this->session->userdata('funding_agency_filter');

		if ($year==null || $year=='null') 
			$year = $this->session->userdata('filter_year');
		
		if ($to_month==null || $to_month=='null') 
			$to_month = 0;
		
		if ($to_year==null || $to_year=='null') 
			$to_year = 0;
		 
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
 
		$sql = "CALL `proc_get_vl_fundingagencies_gender`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$agency_id."')";
		
		$result = $this->db->query($sql)->result_array();
		 
		$count = 0;
		
		$data['gender'][0]['name'] = 'Not Suppressed';
		$data['gender'][1]['name'] = 'Suppressed';
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

	function get_sampletypesData($year=null,$type=null,$agency_id=null)
	{
		$array1 = array();
		$array2 = array();
		$sql2 = NULL;
 
		if ($type==null || $type=='null') 
			$type = 0;
		
		if ($agency_id==null || $agency_id=='null') 
			$agency_id = $this->session->userdata('funding_agency_filter');
 
 
		if ($year==null || $year=='null') {
			$to = $this->session->userdata('filter_year');
		}else {
			$to = $year;
		}
		$from = $to-1;
 
		$sql = "CALL `proc_get_vl_fundingagencies_sample_types`('".$from."','".$to."','".$type."','".$agency_id."')";

		$array1 = $this->db->query($sql)->result_array();
		return $array1;
	}

	public function sample_types($year=NULL,$type=null,$agency_id=null,$all=NULL) {
		$result = $this->get_sampletypesData($year,$type,$agency_id);
		// echo "<pre>";print_r($result);die();
		$data['sample_types'][0]['name'] = 'Plasma';
		$data['sample_types'][1]['name'] = 'DBS';
		// $data['sample_types'][3]['name'] = 'Suppression';
 
		$count = 0;
		
		$data['categories'][0] = 'No Data';
		$data["sample_types"][0]["data"][0]	= $count;
		$data["sample_types"][1]["data"][0]	= $count;
		// $data["sample_types"][3]["data"][0]	= $count;
 
		foreach ($result as $key => $value) {
			
			$data['categories'][$key] = $this->resolve_month($value['month']).'-'.$value['year'];

			if($all == 1){
					$data["sample_types"][0]["data"][$key]	= (int) ($value['alledta'] + $value['allplasma']);
				$data["sample_types"][1]["data"][$key]	= (int) $value['alldbs'];
			} else {
					$data["sample_types"][0]["data"][$key]	= (int) ($value['edta'] + $value['plasma']);
				$data["sample_types"][1]["data"][$key]	= (int) $value['dbs'];
			}			
		}
		
		return $data;
	}

	function download_sampletypes($year=null,$county=null,$partner=null)
	{
		$data = $this->get_sampletypesData($year,$county,$partner);
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
	    header('Content-Disposition: attachement; filename="'.Date('YmdH:i:s').'vl_sampleTypes.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);

	} 
}

?>