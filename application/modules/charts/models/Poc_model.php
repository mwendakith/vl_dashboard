<?php
defined('BASEPATH') or exit('No direct script access allowed!');

/**
* 
*/
class Poc_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}

	function testing_trends($county=null,$year=null,$month=null,$to_year=null,$to_month=null)
	{
		if($county == NULL || $county == 48 || $county=='null') $county=0;
		if ($year==null || $year=='null') $year = $this->session->userdata('filter_year');

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		if ($to_month==null || $to_month=='null') $to_month = 0;
		if ($to_year==null || $to_year=='null') $to_year = 0;


		$sql = "CALL `proc_get_vl_poc_trends`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo $sql;die();
		$result = $this->db->query($sql)->result_array();

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
			$data['categories'][$key] = $this->resolve_month($value['month']).'-'.$value['year'];
			$data['outcomes'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$key] = (int) $value['less1000'];
			$data['outcomes'][2]['data'][$key] = (int) $value['undetected'];
			$data['outcomes'][3]['data'][$key] = round(@(((int) $value['suppressed']*100)/((int) $value['suppressed']+(int) $value['nonsuppressed'])),1);
			$data['outcomes'][4]['data'][$key] = 90;
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}


	function vl_outcomes($county=null,$year=null,$month=null,$to_year=null,$to_month=null)
	{
		if($county == NULL || $county == 48 || $county=='null') $county=0;
		if ($year==null || $year=='null') $year = $this->session->userdata('filter_year');

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		if ($to_month==null || $to_month=='null') $to_month = 0;
		if ($to_year==null || $to_year=='null') $to_year = 0;


		$sql = "CALL `proc_get_county_poc_vl_outcomes`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo $sql;die();
		$result = $this->db->query($sql)->result_array();

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
	    		<td>'.number_format($value['baselinesustxfail']). ' (' .round(@($value['baselinesustxfail'] * 100 / $value['baseline']), 1). '%)' .'</td>
	    	</tr>
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;Confirmatory Repeat Tests:</td>
	    		<td>'.number_format($value['confirmtx']).'</td>
	    		<td>Non Suppression ( &gt; 1000cpml)</td>
	    		<td>'.number_format($value['confirm2vl']). ' (' .round(@($value['confirm2vl'] * 100 / $value['confirmtx']), 1). '%)' .'</td>
	    	</tr>
 
	    	<tr>
	    		<td>Rejected Samples:</td>
	    		<td>'.number_format($value['rejected']).'</td>
	    		<td>Percentage Rejection Rate</td>
	    		<td>'. round(@(($value['rejected']*100)/$value['received']), 1, PHP_ROUND_HALF_UP).'%</td>
	    	</tr>';
						
			$data['vl_outcomes']['data'][0]['y'] = (int) $value['less1000'];
			$data['vl_outcomes']['data'][1]['y'] = (int) $value['undetected'];
			$data['vl_outcomes']['data'][2]['y'] = (int) $value['less5000']+(int) $value['above5000'];
 
			$data['vl_outcomes']['data'][0]['color'] = '#1BA39C';
			$data['vl_outcomes']['data'][1]['color'] = '#66ff66';
			$data['vl_outcomes']['data'][2]['color'] = '#F2784B';
		}
		
		// echo "<pre>";print_r($sites);echo "<pre>";print_r($count);echo "<pre>";print_r(round(@$sites / $count));die();
		// $data['ul'] .= "<tr> <td colspan=2>Average Sites Sending:</td><td colspan=2>".number_format(round(@($sites / $count)))."</td></tr>";
 
		$data['vl_outcomes']['data'][2]['sliced'] = true;
		$data['vl_outcomes']['data'][2]['selected'] = true;
		
		return $data;
	}


	function ages($county=null,$year=null,$month=null,$to_year=null,$to_month=null)
	{
		if($county == NULL || $county == 48 || $county=='null') $county=0;
		if ($year==null || $year=='null') $year = $this->session->userdata('filter_year');

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		if ($to_month==null || $to_month=='null') $to_month = 0;
		if ($to_year==null || $to_year=='null') $to_year = 0;


		$sql = "CALL `proc_get_vl_regional_poc_age`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo $sql;die();
		$result = $this->db->query($sql)->result_array();

		$data['ageGnd'][0]['name'] = 'Not Suppressed';
		$data['ageGnd'][1]['name'] = 'Suppressed';
 
		$count = 0;
		
		$data["ageGnd"][0]["data"][0]	= $count;
		$data["ageGnd"][1]["data"][0]	= $count;
		$data['categories'][0]			= 'No Data';
 
		foreach ($result as $key => $value) {
			
			$data['categories'][$loop] 			= $value['name'];
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


	function gender($county=null,$year=null,$month=null,$to_year=null,$to_month=null)
	{
		if($county == NULL || $county == 48 || $county=='null') $county=0;
		if ($year==null || $year=='null') $year = $this->session->userdata('filter_year');

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		if ($to_month==null || $to_month=='null') $to_month = 0;
		if ($to_year==null || $to_year=='null') $to_year = 0;


		$sql = "CALL `proc_get_vl_regional_poc_gender`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo $sql;die();
		$result = $this->db->query($sql)->result_array();


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



	function county_outcomes($year=null,$month=null,$to_year=null,$to_month=null)
	{
		if ($year==null || $year=='null') $year = $this->session->userdata('filter_year');

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
		if ($to_month==null || $to_month=='null') $to_month = 0;
		if ($to_year==null || $to_year=='null') $to_year = 0;


		$sql = "CALL `proc_get_vl_poc_county_trends`('".$year."','".$month."','".$to_year."','".$to_month."')";
		// echo $sql;die();
		$result = $this->db->query($sql)->result_array();

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
			$data['categories'][$key] = $value['countyname'];
			$data['outcomes'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$key] = (int) $value['less1000'];
			$data['outcomes'][2]['data'][$key] = (int) $value['undetected'];
			$data['outcomes'][3]['data'][$key] = round(@(((int) $value['suppressed']*100)/((int) $value['suppressed']+(int) $value['nonsuppressed'])),1);
			$data['outcomes'][4]['data'][$key] = 90;
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}


}