<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
* 
*/
class Samples_model extends MY_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function samples_outcomes($year=NULL,$month=NULL,$to_year=null,$to_month=null,$partner=null)
	{
		//return "this";
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['partner' => $partner]);
		extract($d);

		if (!$partner) {
			$sql = "CALL `proc_get_vl_samples_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_samples_outcomes`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['county_outcomes'][0]['name'] = 'Not Suppressed';
		$data['county_outcomes'][1]['name'] = 'Suppressed';

		$count = 0;
		
		$data["county_outcomes"][0]["data"][0]	= $count;
		$data["county_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			// if ($key==0 || $key==1) {
			// 	if (!in_array("Plasma", $data['categories'][0]))
			// 	{
			// 		$data['categories'][0] 				= "Plasma";
			// 	}
			// 	$data["county_outcomes"][0]["data"][0]	=  (int) ($data["county_outcomes"][0]["data"][0] + $value['nonsuppressed']);
			// 	$data["county_outcomes"][1]["data"][0]	=  (int) ($data["county_outcomes"][1]["data"][0] + $value['suppressed']);
			// }else{
			
			$data['categories'][$key] 					= $value['sample_type_name'];
			$data["county_outcomes"][0]["data"][$key]	=  (int) $value['nonsuppressed'];
			$data["county_outcomes"][1]["data"][$key]	=  (int) $value['suppressed'];
			// }
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function samples_vl_outcomes($year=NULL,$month=NULL,$sample=NULL,$to_year=null,$to_month=null,$partner=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['partner' => $partner, 'sample' => $sample]);
		extract($d);

		if (!$partner) {
			$sql = "CALL `proc_get_vl_samples_vl_outcomes`('".$sample."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_samples_vl_outcomes`('".$partner."','".$sample."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
				
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$color = array('#6BB9F0', '#F2784B', '#1BA39C', '#5C97BF');

		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;
		$data['ul'] = '';

		$data['vl_outcomes']['data'][0]['name'] = 'LDL';
		$data['vl_outcomes']['data'][1]['name'] = 'LLV';
		$data['vl_outcomes']['data'][2]['name'] = 'Not Suppressed';

		$count = 0;

		$data['vl_outcomes']['data'][0]['y'] = $count;
		$data['vl_outcomes']['data'][1]['y'] = $count;
		$data['vl_outcomes']['data'][2]['y'] = $count;

		foreach ($result as $key => $value) {
			$total = (int) ($value['undetected'] + $value['less1000'] + $value['less5000'] + $value['above5000']);
			$less = (int) ($value['undetected'] + $value['less1000']);
			$greater = (int) ($value['less5000'] + $value['above5000']);
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
	    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests &gt;= 1000 copies/ml (HVL):</td>
	    		<td>'.number_format($greater).'</td>
	    		<td>Percentage Non Suppression</td>
	    		<td>'.round((@($greater/$total)*100),1).'%</td>
	    	</tr>
 
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests &lt= 400 copies/ml (LDL):</td>
	    		<td>'.number_format($value['undetected']).'</td>
	    		<td>Percentage Suppression</td>
	    		<td>'.round((@($value['undetected']/$total)*100),1).'%</td>
	    	</tr>
 
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests 401 - 999 copies/ml (LLV):</td>
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
						
			$data['vl_outcomes']['data'][0]['y'] = (int) $value['undetected'];
			$data['vl_outcomes']['data'][1]['y'] = (int) $value['less1000'];
			$data['vl_outcomes']['data'][2]['y'] = (int) $value['less5000']+(int) $value['above5000'];
 
			$data['vl_outcomes']['data'][0]['color'] = '#1BA39C';
			$data['vl_outcomes']['data'][1]['color'] = '#66ff66';
			$data['vl_outcomes']['data'][2]['color'] = '#F2784B';
		}
		$data['vl_outcomes']['data'][0]['sliced'] = true;
		$data['vl_outcomes']['data'][0]['selected'] = true;
		
		return $data;
	}

	function samples_gender($year=NULL,$month=NULL,$sample=NULL,$to_year=null,$to_month=null,$partner=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['partner' => $partner, 'sample' => $sample]);
		extract($d);

		if (!$partner) {
			$sql = "CALL `proc_get_vl_samples_gender`('".$sample."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_samples_gender`('".$partner."','".$sample."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['ageGnd'][0]['name'] = 'Test';

		$count = 0;
		
		$data["ageGnd"][0]["data"][0]	= $count;
		$data["ageGnd"][0]["data"][1]	= $count;
		$data['categories'][0] = 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][0] 			= 'Male';
			$data['categories'][1] 			= 'Female';
			$data["ageGnd"][0]["data"][0]	=  (int) $value['maletest'];
			$data["ageGnd"][0]["data"][1]	=  (int) $value['femaletest'];
		}

		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		
		return $data;
	}

	function samples_age($year=NULL,$month=NULL,$sample=NULL,$to_year=null,$to_month=null,$partner=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['partner' => $partner, 'sample' => $sample]);
		extract($d);

		if (!$partner) {
			$sql = "CALL `proc_get_vl_samples_age`('".$sample."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_samples_age`('".$partner."','".$sample."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['ageGnd'][0]['name'] = 'Test';

		$count = 0;
		
		$data["ageGnd"][0]["data"][0]	= $count;
		$data["ageGnd"][0]["data"][1]	= $count;
		$data['categories'][0]			= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][0] 			= 'No Age';
			$data['categories'][1] 			= 'Less 2';
			$data['categories'][2] 			= 'Less 9';
			$data['categories'][3] 			= 'Less 14';
			$data['categories'][4] 			= 'Less 19';
			$data['categories'][5] 			= 'Less 24';
			$data['categories'][6] 			= 'over 25';
			$data["ageGnd"][0]["data"][0]	=  (int) $value['noage'];
			$data["ageGnd"][0]["data"][1]	=  (int) $value['less2'];
			$data["ageGnd"][0]["data"][2]	=  (int) $value['less9'];
			$data["ageGnd"][0]["data"][3]	=  (int) $value['less14'];
			$data["ageGnd"][0]["data"][4]	=  (int) $value['less19'];
			$data["ageGnd"][0]["data"][5]	=  (int) $value['less24'];
			$data["ageGnd"][0]["data"][6]	=  (int) $value['over25'];
		}
		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		
		return $data;
	}

	function samples_suppression($year=NULL,$month=NULL,$sample=NULL,$to_year=NULL,$to_month=NULL)
	{
		
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['sample' => $sample]);
		extract($d);
		//if ($partner==null || $partner=='null') {
		$sql = "CALL `proc_get_vl_sample_summary`('".$sample."','".$year."','".$month."','".$to_year."','".$to_month."')";
		/*} else {
			$sql = "CALL `proc_get_vl_partner_samples_sample_types`('".$partner."','".$sample."','".$from."')";
			$sql2 = "CALL `proc_get_vl_partner_samples_sample_types`('".$partner."','".$sample."','".$to."')";
		}*/
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$data['outcomes'][0]['name'] = "Nonsuppressed";
		$data['outcomes'][1]['name'] = "Suppressed";
		$data['outcomes'][2]['name'] = "Suppression";


		//$data['outcomes'][0]['drilldown']['color'] = '#913D88';
		//$data['outcomes'][1]['drilldown']['color'] = '#96281B';
		//$data['outcomes'][2]['color'] = '#257766';

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "spline";

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' %');

		$data['title'] = "Outcomes";

		foreach ($result as $key => $value) {
			
			$data['categories'][$key] = $this->resolve_month($value['month']).'-'.$value['year'];
			$data['outcomes'][0]['data'][$key] = (int) ($value['tests'] - $value['suppressed']);
			$data['outcomes'][1]['data'][$key] = (int) $value['suppressed'];

			$data['outcomes'][2]['data'][$key] = round(@$value['suppression'],1);
			//$data['outcomes'][2]['data'][$key] = round($value['percentage'], 2);
			
		}
		return $data;
	}

	function county_outcomes($year=null,$month=null,$sample=null,$to_year=null,$to_month=null,$partner=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['partner' => $partner, 'sample' => $sample]);
		extract($d);

		if (!$partner) {
			$sql = "CALL `proc_get_vl_county_samples_outcomes`('".$sample."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_county_samples_outcomes`('".$partner."','".$sample."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['outcomes'][0]['name'] = "Nonsuppressed";
		$data['outcomes'][1]['name'] = "Suppressed";
		$data['outcomes'][2]['name'] = "Suppression";


		//$data['outcomes'][0]['drilldown']['color'] = '#913D88';
		//$data['outcomes'][1]['drilldown']['color'] = '#96281B';
		//$data['outcomes'][2]['color'] = '#257766';

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "spline";

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' %');

		$data['title'] = "Outcomes";


		

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];

			$data['outcomes'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$key] = (int) $value['suppressed'];

			$data['outcomes'][2]['data'][$key] = round(@(((int) $value['suppressed']*100)/((int) $value['suppressed']+(int) $value['nonsuppressed'])),1);
			//$data['outcomes'][2]['data'][$key] = round($value['percentage'], 2);
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}
}
?>