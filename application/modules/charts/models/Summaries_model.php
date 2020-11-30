<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Summaries_model extends MY_Model
{
	function __construct()
	{
		parent:: __construct();
	}
 
	function turnaroundtime($year=null,$month=null,$county=null,$to_year=null,$to_month=null,$nat=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county]);
		extract($d);
 		if ($nat) {
 			$sql = "CALL `proc_get_national_tat`('".$year."','".$month."','".$to_year."','".$to_month."')";
 		} else {
 			$sql = "CALL `proc_get_poc_tat`('".$year."','".$month."','".$to_year."','".$to_month."')";
 		}
 		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$count = 0;
		$tat1 = 0;
		$tat2 = 0;
		$tat3 = 0;
		$tat4 = 0;
		$tat = array();
		
		foreach ($result as $key => $value) {
			if (($value['tat1']!=0) || ($value['tat2']!=0) || ($value['tat3']!=0) || ($value['tat4']!=0)) {
				$count++;
 
				$tat1 = $tat1+$value['tat1'];
				$tat2 = $tat2+$value['tat2'];
				$tat3 = $tat3+$value['tat3'];
				$tat4 = $tat4+$value['tat4'];
			}
		}
		$tat[] = array(
					'tat1' => $tat1,
					'tat2' => $tat2,
					'tat3' => $tat3,
					'tat4' => $tat4,
					'count' => $count
					);
		// echo "<pre>";print_r($tat);die();
		foreach ($tat as $key => $value) {
			if ($value['count'] == 0) {
				$data['tat1'] = $data['tat2'] = $data['tat3'] = $data['tat4'] = 0;
			} else {
				$data['tat1'] = round(@($value['tat1']/$value['count']));
				$data['tat2'] = round(@($value['tat2']/$value['count']) + $data['tat1']);
				$data['tat3'] = round(@($value['tat3']/$value['count']) + $data['tat2']);
				$data['tat4'] = round(@($value['tat4']/$value['count']));
			}
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function vl_coverage($year=null,$month=null,$to_year=null,$to_month=null,$type=null,$id=null)
	{
		$county = $partner = null;
		if ($type == 1)
			$county = $id;
		else if ($type == 2)
			$partner == $id;

		$current_suppression = $this->get_patients($year,$month,$county,$partner,$to_year,$to_month);
		// echo "<pre>";print_r($current_suppression);die();
		// $sql = "CALL `proc_get_vl_current_suppression`('".$type."','".$ID."')";
		// echo "<pre>";print_r($sql);die();
		// $result = $this->db->query($sql)->result_array();
		// $uniquepts = 0;
		// $totalasatmar = 0;
		// $vl_coverage = 0;

		$data['coverage'] = round($current_suppression['coverage']);
		if ($data['coverage'] < 51) {
			$data['color'] = 'rgba(255,0,0,0.5)';
		} else if ($data['coverage'] > 50 && $data['coverage'] < 71) {
			$data['color'] = 'rgba(255,255,0,0.5)';
		} else if ($data['coverage'] > 70) {
			$data['color'] = 'rgba(0,255,0,0.5)';
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}
 
	function county_outcomes($year=null,$month=null,$pfil=null,$partner=null,$county=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county, 'partner' => $partner]);
		extract($d);
				
		// echo "PFil: ".$pfil." --Partner: ".$partner." -- County: ".$county;
		if ($county) {
			$sql = "CALL `proc_get_county_sites_outcomes`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			if ($pfil==1) {
				if ($partner && is_int(!is_null($partner))) {
					$sql = "CALL `proc_get_partner_sites_outcomes`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
				} else {
					$sql = "CALL `proc_get_partner_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."')";
				}
				
			} else {
				$sql = "CALL `proc_get_county_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."')";
			}
		}
		// echo "<pre>";print_r($sql);echo "</pre>";die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();

		$data['outcomes'][0]['name'] = "Not Suppressed";
		$data['outcomes'][1]['name'] = "LLV";
		$data['outcomes'][2]['name'] = "LDL";
		$data['outcomes'][3]['name'] = "Suppression";
		$data['outcomes'][4]['name'] = "90% Target";

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "column";
		$data['outcomes'][3]['type'] = "spline";
		$data['outcomes'][4]['type'] = "spline"; 

		$data['outcomes'][0]['color'] = '#F2784B';
		$data['outcomes'][1]['color'] = '#66ff66';
		$data['outcomes'][2]['color'] = '#1BA39C';
		

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
 
	function vl_outcomes($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county, 'partner' => $partner]);
		extract($d);

		if ($partner) {
			$sql = "CALL `proc_get_partner_vl_outcomes`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
			$sql2 = "CALL `proc_get_partner_sitessending`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
			$sql3 = "CALL `proc_get_vl_current_suppression`('3','".$partner."')";
		} else {
			if (!$county) {
				$sql = "CALL `proc_get_national_vl_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."')";
				$sql2 = "CALL `proc_get_national_sitessending`('".$year."','".$month."','".$to_year."','".$to_month."')";
				$sql3 = "CALL `proc_get_vl_current_suppression`('0','0')";
			} else {
				$sql = "CALL `proc_get_regional_vl_outcomes`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
				$sql2 = "CALL `proc_get_regional_sitessending`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
				$sql3 = "CALL `proc_get_vl_current_suppression`('1','".$county."')";
			}
		}
		// echo "<pre>";print_r($params);echo "</pre>";
		// echo "<pre>";print_r($sql2);echo "</pre>";die();
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		$sitessending = $this->db->query($sql2)->result_array();
		$this->db->close();

		// Getting the broken down r categories
		// $res = $this->req($params);
		// echo "<pre>";print_r($res);echo "</pre>";
		// echo "<pre>";print_r($result);echo "</pre>";
		// echo "<pre>";print_r($sitessending);echo "</pre>";die();
		$color = array('#6BB9F0', '#F2784B', '#1BA39C', '#5C97BF');
 
		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;
		$data['ul'] = '';
 
		$data['vl_outcomes']['data'][0]['name'] = '&lt;= 400';
		$data['vl_outcomes']['data'][1]['name'] = '401 - 999';
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
	    	/*
				<tr>
		    		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Valid Tests &lt; LDL:</td>
		    		<td>'.number_format($value['undetected']).'</td>
		    		<td>Percentage Undetectable</td>
		    		<td>'.round((@($value['undetected']/$total)*100),1).'%</td>
		    	</tr>
	    	*/
						
			$data['vl_outcomes']['data'][0]['y'] = (int) $value['undetected'];
			$data['vl_outcomes']['data'][1]['y'] = (int) $value['less1000'];
			$data['vl_outcomes']['data'][2]['y'] = (int) $value['less5000']+(int) $value['above5000'];
 
			$data['vl_outcomes']['data'][0]['color'] = '#1BA39C';
			$data['vl_outcomes']['data'][1]['color'] = '#66ff66';
			$data['vl_outcomes']['data'][2]['color'] = '#F2784B';
		}
 
		$count = 0;
		$sites = 0;
		foreach ($sitessending as $key => $value) {
			if ((int) $value['sitessending'] != 0) {
				$sites = (int) $sites + (int) $value['sitessending'];
				$count++;
			}
		}
		// echo "<pre>";print_r($sites);echo "<pre>";print_r($count);echo "<pre>";print_r(round(@$sites / $count));die();
		$data['ul'] .= "<tr> <td colspan=2>Average Sites Sending:</td><td colspan=2>".number_format(round(@($sites / $count)))."</td></tr>";
		$count = 1;
		$sites = 0;
 
		$data['vl_outcomes']['data'][2]['sliced'] = true;
		$data['vl_outcomes']['data'][2]['selected'] = true;
		
		return $data;
	}
 
	function justification($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county, 'partner' => $partner]);
		extract($d);
 
		if ($partner) {
			$sql = "CALL `proc_get_partner_justification`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			if (!$county) {
				$sql = "CALL `proc_get_national_justification`('".$year."','".$month."','".$to_year."','".$to_month."')";
			} else {
				$sql = "CALL `proc_get_regional_justification`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		
		$data['justification']['name'] = 'Tests';
		$data['justification']['colorByPoint'] = true;
 
		$count = 0;
 
		$data['justification']['data'][0]['name'] = 'No Data';
 
		foreach ($result as $key => $value) {
			if($value['name'] == 'Routine VL'){
				$data['justification']['data'][$key]['color'] = '#1BA39C';
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
 
	function justification_breakdown($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county, 'partner' => $partner]);
		extract($d);
 
		if ($partner) {
			// $sql = "CALL `proc_get_partner_justification_breakdown`('6','".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
			// $sql2 = "CALL `proc_get_partner_justification_breakdown`('9','".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";

			$sql = "CALL `proc_get_vl_pmtct`('1','".$year."','".$month."','".$to_year."','".$to_month."','','','".$partner."','','')";
			$sql2 = "CALL `proc_get_vl_pmtct`('2','".$year."','".$month."','".$to_year."','".$to_month."','','','".$partner."','','')";

		} else {
			if (!$county) {
				// $sql = "CALL `proc_get_national_justification_breakdown`('6','".$year."','".$month."','".$to_year."','".$to_month."')";
				// $sql2 = "CALL `proc_get_national_justification_breakdown`('9','".$year."','".$month."','".$to_year."','".$to_month."')";

				$sql = "CALL `proc_get_vl_pmtct`('1','".$year."','".$month."','".$to_year."','".$to_month."','1','','','','')";
				$sql2 = "CALL `proc_get_vl_pmtct`('2','".$year."','".$month."','".$to_year."','".$to_month."','1','','','','')";


			} else {
				// $sql = "CALL `proc_get_regional_justification_breakdown`('6','".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
				// $sql2 = "CALL `proc_get_regional_justification_breakdown`('9','".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";

				$sql = "CALL `proc_get_vl_pmtct`('1','".$year."','".$month."','".$to_year."','".$to_month."','','".$county."','','','')";
				$sql2 = "CALL `proc_get_vl_pmtct`('2','".$year."','".$month."','".$to_year."','".$to_month."','','".$county."','','','')";
			}
		}
		// echo "<pre>";print_r($sql);
		// echo "<pre>";print_r($sql2);die();
		
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
 
	function age($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county, 'partner' => $partner]);
		extract($d);
 
		if ($partner) {
			$sql = "CALL `proc_get_partner_age`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			if (!$county) {
				$sql = "CALL `proc_get_national_age`('".$year."','".$month."','".$to_year."','".$to_month."')";
			} else {
				$sql = "CALL `proc_get_regional_age`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
			}
		}
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
 
	function age_breakdown($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county, 'partner' => $partner]);
		extract($d);
 
		if ($partner) {
			$sql = "CALL `proc_get_partner_age`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			if (!$county) {
				$sql = "CALL `proc_get_national_age`('".$year."','".$month."','".$to_year."','".$to_month."')";
			} else {
				$sql = "CALL `proc_get_regional_age`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
 
		$data['children']['name'] = 'Tests';
		$data['children']['colorByPoint'] = true;
 
		$data['adults']['name'] = 'Tests';
		$data['adults']['colorByPoint'] = true;
		$adults = 0;
		$sadult = 0;
		$children = 0;
		$schildren = 0;
		$count = 0;
 
		foreach ($result as $key => $value) {
			
			if ($value['name']=='Less 2' || $value['name']=='2-9' || $value['name']=='10-14') {
				$data['ul']['children'] = '';
				$children = (int) $children + (int) $value['agegroups'];
				$schildren = (int) $schildren + (int) $value['suppressed'];
				$data['children']['data'][$key]['y'] = $count;
				$data['children']['data'][$key]['name'] = $value['name'];
				$data['children']['data'][$key]['y'] = (int) $value['agegroups'];
 
			} else if ($value['name']=='15-19' || $value['name']=='20-24' || $value['name']=='25+') {
				$data['ul']['adults'] = '';
				$adults = (int) $adults + (int) $value['agegroups'];
				$sadult = (int) $sadult + (int) $value['suppressed'];
				$data['adults']['data'][$key]['y'] = $count;
				$data['adults']['data'][$key]['name'] = $value['name'];
				$data['adults']['data'][$key]['y'] = (int) $value['agegroups'];
			}
		}
		// echo "<pre>";print_r($schildren);echo "</pre>";
		// echo "<pre>";print_r($data);
		$data['ctotal'] = $children;
		$data['atotal'] = $adults;
		
		$data['ul']['children'] = '<li>Children Suppression : '.(int)(((int) $schildren/(int) $children)*100).'%</li>';
		$data['ul']['adults'] = '<li>Adult Suppression : '.(int)(((int) $sadult/(int) $adults)*100).'%</li>';
		$data['children']['data'] = array_values($data['children']['data']);
		$data['adults']['data'] = array_values($data['adults']['data']);
 
		$data['children']['data'][0]['sliced'] = true;
		$data['children']['data'][0]['selected'] = true;
 
		$data['adults']['data'][0]['sliced'] = true;
		$data['adults']['data'][0]['selected'] = true;
 
		// echo "<pre>";print_r($data);die();
		
		return $data;
	}
 
	function gender($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county, 'partner' => $partner]);
		extract($d);
 
		if ($partner) {
			$sql = "CALL `proc_get_partner_gender`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			if (!$county) {
				$sql = "CALL `proc_get_national_gender`('".$year."','".$month."','".$to_year."','".$to_month."')";
			} else {
				$sql = "CALL `proc_get_regional_gender`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
			}
		}
		// CALL `proc_get_national_gender`('2017','0','0','0');
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

	function get_sampletypesData($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL,$type=NULL,$id=NULL,$all=NULL)
	{
		$array1 = array();
		$type = (int) $type;
		$sessionFiltersArray = ['county' => NULL, 'subcounty' => NULL, 'facility' => NULL, 'partner' => NULL, 'lab' => NULL, 'regimen' => NULL, 'age_cat' => NULL];
		
		if ($type == 1)
			$sessionFiltersArray = ['county' => $id];
		else if ($type == 2)
			$sessionFiltersArray = ['subcounty' => $id];
		if ($type == 3)
			$sessionFiltersArray = ['facility' => $id];
		else if ($type == 4)
			$sessionFiltersArray = ['partner' => $id];
		else if ($type == 5)
			$sessionFiltersArray = ['lab' => $id];
		else if ($type == 6)
			$sessionFiltersArray = ['regimen' => $id];
		else if ($type == 7)
			$sessionFiltersArray = ['age_cat' => $id];
		
		$d = $this->extract_variables($year, $month, $to_year, $to_month, $sessionFiltersArray);
		// echo "<pre>";print_r($d);die();
		extract($d);
		
		$type = $id = 0;
		$multipleID = '';

 		if (isset($county)){$type = 1; $id = $county;}
 		else if(isset($subcounty)){$type = 2; $id = $subcounty;}
 		else if(isset($facility)){$type = 3; $id = $facility;}
 		else if(isset($partner)){$type = 4; $id = $partner;}
 		else if(isset($lab)){$type = 5; $id = $lab;}
 		else if(isset($regimen)){$type = 6; $id = $regimen;}
 		else if(isset($age_cat)){$type = 7; $multipleID = $this->build_Inarray($age_cat);}

		$sql = "CALL `proc_get_vl_sample_types_trends`('".$type."','".$id."','".$year."','".$month."','".$to_year."','".$to_month."','".$multipleID."')";
		// echo "<pre>";print_r($sql);die();
		$array1 = $this->db->query($sql)->result_array();
		return $array1;
	}
 
	function sample_types($year=NULL,$month=NULL,$to_year=NULL,$to_month=NULL,$type=NULL,$id=NULL,$all=NULL) {
		$result = $this->get_sampletypesData($year,$month,$to_year,$to_month,$type,$id,$all);
		
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
 					$data["sample_types"][0]["data"][$key]	= ((int) $value['alledta'] + (int) $value['allplasma']);
					$data["sample_types"][1]["data"][$key]	= (int) $value['alldbs'];
				}
 				else{
 					$data["sample_types"][0]["data"][$key]	= ((int) $value['edta'] + (int) $value['plasma']);
					$data["sample_types"][1]["data"][$key]	= (int) $value['dbs'];
 				}

				// $data["sample_types"][3]["data"][$key]	= round($value['suppression'],1);
			
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



	function get_patients($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county, 'partner' => $partner], true);
		extract($d);

		$sql;

		if ($partner) {
			$params = "patient/partner/{$partner}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
			// $sql = "Select sum(totalartmar) as totalartmar from view_facilitys where partner='{$partner}'";
		} else {
			if (!$county) {
				$params = "patient/national/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
				// $sql = "Select sum(totalartmar) as totalartmar from view_facilitys";
			} else {
				$query = $this->db->get_where('countys', array('id' => $county), 1)->row();
				$c = $query->CountyMFLCode;

				$params = "patient/county/{$c}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
				// $sql = "Select sum(totalartmar) as totalartmar from view_facilitys where county='{$county}'";
			}
		}
		$this->db->close();
		// echo "<pre>";print_r($params);die();
		$result = $this->req($params);	

		// $res = $this->db->query($sql)->row();

		// $this->db->close();	

		// echo "<pre>";print_r($result);die();

		$data['outcomes'][0]['name'] = "Patients grouped by tests received";

		// $data['outcomes'][0]['type'] = "column";

		// $data['outcomes'][0]['yAxis'] = 1;

		// $data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');

		$data['title'] = " ";

		$data['unique_patients'] = 0;
		$data['size'] = 0;
		// $data['total_patients'] = $res->totalartmar;
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

		$data['coverage'] = round(@($data['unique_patients'] / $data['total_patients'] * 100), 2);
		if ($data['coverage'] ==INF) {
			$data['coverage'] = 0;
		}

		return $data;
	}

	function get_current_suppresion($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county, 'partner' => $partner], true);
		extract($d);

		if ($partner) {
			$params = "patient/suppression/partner/{$partner}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
		} else {
			if (!$county) {
				$params = "patient/suppression/national/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
			} else {
				$query = $this->db->get_where('countys', array('id' => $county), 1)->row();
				$c = $query->CountyMFLCode;

				$params = "patient/suppression/county/{$c}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
			}
		}
		$this->db->close();

		$result = $this->req($params);	


		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;
		$data['ul'] = '';

		$data['vl_outcomes']['data'][0]['name'] = '<= 400 copies/ml (LDL)';
		$data['vl_outcomes']['data'][1]['name'] = '401 - 999 copies/ml (LLV)';
		$data['vl_outcomes']['data'][2]['name'] = '>= 1000 copies/ml (HVL)';
		
		$data['vl_outcomes']['data'][0]['y'] = (int) $result->rcategory1;
		$data['vl_outcomes']['data'][1]['y'] = (int) $result->rcategory2;
		$data['vl_outcomes']['data'][2]['y'] = (int) $result->rcategory3 + (int) $result->rcategory4;
		
		$data['vl_outcomes']['data'][0]['z'] = number_format($result->rcategory1);
		$data['vl_outcomes']['data'][1]['z'] = number_format($result->rcategory2);
		$data['vl_outcomes']['data'][2]['z'] = number_format($result->rcategory3 + $result->rcategory4);

		$data['vl_outcomes']['data'][0]['color'] = '#1BA39C';
		$data['vl_outcomes']['data'][1]['color'] = '#66ff66';
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

	function current_suppression($county=null, $partner=null, $annual=NULL){
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}

		// echo "<pre>";print_r($result);die();
		$color = array('#6BB9F0', '#F2784B', '#1BA39C', '#5C97BF');

		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;
		$data['ul'] = '';

		if (!is_null($partner)) {
			$sql = "CALL `proc_get_vl_current_suppression`('3','".$partner."')";
			if ($annual==1) {
				$sql = "CALL `proc_get_vl_current_suppression_year`('3','".$partner."')";
			}
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_vl_current_suppression`('0','0')";
			} else {
				$sql = "CALL `proc_get_vl_current_suppression`('1','".$county."')";
			}
		}

		$result = $this->db->query($sql)->row();

		$this->db->close();
		
		$data['vl_outcomes']['data'][0]['name'] = '<= 400 copies/ml (LDL)';
		$data['vl_outcomes']['data'][1]['name'] = '401 - 999 copies/ml (LLV)';
		$data['vl_outcomes']['data'][2]['name'] = '>= 1000 copies/ml (HVL)';

		$data['vl_outcomes']['data'][0]['y'] = (int) $result->undetected;
		$data['vl_outcomes']['data'][1]['y'] = (int) $result->less1000;
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
		$data['ul'] .= "<= 400 copies/ml - " . number_format($result->undetected) . "<br />";
		$data['ul'] .= "401 - 999 copies/ml - " . number_format($result->less1000) . "<br />";
		$data['ul'] .= "Non Suppressed - " . number_format($result->nonsuppressed) . "<br />";
		$data['ul'] .= "<b>N.B.</b> These values exclude baseline tests. </p>";
		
		return $data;
	}

	function current_gender_chart($type, $param_type=1, $param=NULL, $annual=NULL)
	{
		

		if($param_type == 1){

			if ($param==null || $param=='null') {
				$param = $this->session->userdata('county_filter');
			}

			if ($param==null || $param=='null') {
				$param = 0;
			}
			$sql = "CALL `proc_get_vl_current_gender_suppression_listing`({$type}, {$param})";
		}

		else{			

			if ($param==null || $param=='null') {
				$param = $this->session->userdata('partner_filter');
			}

			if ($param==null || $param=='null') {
				$param = 1000;
			}
			$sql = "CALL `proc_get_vl_current_gender_suppression_listing_partner`({$type}, {$param})";

			if ($annual==1) {
				$sql = "CALL `proc_get_vl_current_gender_suppression_listing_partner_year`({$type}, {$param})";
			}
		}

		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->row();
		// echo "<pre>";print_r($result);die();
		$data['gender'][0]['name'] = 'Not Suppressed';
		$data['gender'][1]['name'] = 'Suppressed';

		$data['categories'][0] = 'No data';
		$data["gender"][0]["data"][0] = (int) $result->nogender_nonsuppressed;
		$data["gender"][1]["data"][0] = (int) $result->nogender_suppressed;

		$data['categories'][1] = 'Male';
		$data["gender"][0]["data"][1] = (int) $result->male_nonsuppressed;
		$data["gender"][1]["data"][1] = (int) $result->male_suppressed;

		$data['categories'][2] = 'Female';
		$data["gender"][0]["data"][2] = (int) $result->female_nonsuppressed;
		$data["gender"][1]["data"][2] = (int) $result->female_suppressed;
 
		$data['gender'][0]['drilldown']['color'] = '#913D88';
		$data['gender'][1]['drilldown']['color'] = '#96281B';
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function current_age_chart($type, $param_type=1, $param=NULL, $annual=NULL)
	{
		

		if($param_type == 1){

			if ($param==null || $param=='null') {
				$param = $this->session->userdata('county_filter');
			}

			if ($param==null || $param=='null') {
				$param = 0;
			}
			$sql = "CALL `proc_get_vl_current_age_suppression_listing`({$type}, {$param})";
		}

		else{			

			if ($param==null || $param=='null') {
				$param = $this->session->userdata('partner_filter');
			}

			if ($param==null || $param=='null') {
				$param = 1000;
			}
			$sql = "CALL `proc_get_vl_current_age_suppression_listing_partner`({$type}, {$param})";

			if ($annual==1) {
				$sql = "CALL `proc_get_vl_current_age_suppression_listing_partner_year`({$type}, {$param})";
			}
		}

		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->row();
		// echo "<pre>";print_r($result);die();
		$data['ageGnd'][0]['name'] = 'Not Suppressed';
		$data['ageGnd'][1]['name'] = 'Suppressed';

		$data['categories'][0] = 'No data';
		$data["ageGnd"][0]["data"][0] = (int) $result->noage_nonsuppressed;
		$data["ageGnd"][1]["data"][0] = (int) $result->noage_suppressed;

		$data['categories'][1] = 'Less 2';
		$data["ageGnd"][0]["data"][1] = (int) $result->less2_nonsuppressed;
		$data["ageGnd"][1]["data"][1] = (int) $result->less2_suppressed;

		$data['categories'][2] = '2-9';
		$data["ageGnd"][0]["data"][2] = (int) $result->less9_nonsuppressed;
		$data["ageGnd"][1]["data"][2] = (int) $result->less9_suppressed;

		$data['categories'][3] = '10-14';
		$data["ageGnd"][0]["data"][3] = (int) $result->less14_nonsuppressed;
		$data["ageGnd"][1]["data"][3] = (int) $result->less14_suppressed;

		$data['categories'][4] = '15-19';
		$data["ageGnd"][0]["data"][4] = (int) $result->less19_nonsuppressed;
		$data["ageGnd"][1]["data"][4] = (int) $result->less19_suppressed;

		$data['categories'][5] = '20-24';
		$data["ageGnd"][0]["data"][5] = (int) $result->less24_nonsuppressed;
		$data["ageGnd"][1]["data"][5] = (int) $result->less24_suppressed;

		$data['categories'][6] = '25+';
		$data["ageGnd"][0]["data"][6] = (int) $result->over25_nonsuppressed;
		$data["ageGnd"][1]["data"][6] = (int) $result->over25_suppressed;
 
		$data['ageGnd'][0]['drilldown']['color'] = '#913D88';
		$data['ageGnd'][1]['drilldown']['color'] = '#96281B';
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function suppression_listings($type, $param_type=1, $param=NULL, $annual=NULL)
	{
		$li = '';
		$table = '';
		$sql = '';

		if($param_type == 1){

			if ($param==null || $param=='null') {
				$param = $this->session->userdata('county_filter');
			}

			if ($param==null || $param=='null') {
				$param = 0;
			}
			$sql = "CALL `proc_get_vl_current_suppression_listing`({$type}, {$param})";
		}

		else{			

			if ($param==null || $param=='null') {
				$param = $this->session->userdata('partner_filter');
			}

			if ($param==null || $param=='null') {
				$param = 1000;
			}
			$sql = "CALL `proc_get_vl_current_suppression_listing_partners`({$type}, {$param})";

			if ($annual==1) {
				$sql = "CALL `proc_get_vl_current_suppression_listing_partners_year`({$type}, {$param})";
			}
		}

		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		// echo "<pre>";print_r($result);die();
		$count = 1;
		$listed = FALSE;

		if($result)
		{
			foreach ($result as $key => $value)
			{
				$name;

				switch ($type) {
					case 1:
						$name = $value['countyname'];
						break;
					case 2:
						$name = $value['subcounty'];
						break;
					case 3:
						$name = $value['partnername'];
						break;
					case 4:
						$name = $value['name'];
						break;
					default:
						break;
				}
				$patients = ($value['suppressed']+$value['nonsuppressed']);
				$suppression = round(($value['suppressed']*100/$patients),1);
				$coverage = round(($patients*100/$value['totallstrpt']),1);

				if ($count<16) {
					$li .= '<a href="javascript:void(0);" class="list-group-item" ><strong>'.$count.'.</strong>&nbsp;'.$name.':&nbsp;'.$suppression.'%</a>';
				}

				$table .= '<tr>';
				$table .= '<td>'.$count.'</td>';
				$table .= '<td>'.$name.'</td>';
				$table .= '<td>'.$suppression.'%</td>';
				$table .= '<td>'.$patients.'</td>';
				$table .= '<td>'.($value['totallstrpt']).'</td>';
				$table .= '<td>'.$coverage.'%</td>';
				$table .= '</tr>';
				$count++;
			}
		}
		else{
			$li = 'No Data';
		}

		$data = array(
						'ul' => $li,
						'table' => $table);
		return $data;
	}

	function suppression_age_listings($suppressed, $type, $param_type=1, $param=NULL, $annual=NULL)
	{
		$li = '';
		$table = '';
		$sql = '';

		if($param_type == 1){

			if ($param==null || $param=='null') {
				$param = $this->session->userdata('county_filter');
			}

			if ($param==null || $param=='null') {
				$param = 0;
			}
			$sql = "CALL `proc_get_vl_current_age_suppression_listing`({$type}, {$param})";
		}

		else{			

			if ($param==null || $param=='null') {
				$param = $this->session->userdata('partner_filter');
			}

			if ($param==null || $param=='null') {
				$param = 1000;
			}
			$sql = "CALL `proc_get_vl_current_age_suppression_listing_partner`({$type}, {$param})";

			if ($annual==1) {
				$sql = "CALL `proc_get_vl_current_age_suppression_listing_partner_year`({$type}, {$param})";
			}
		}

		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		// echo "<pre>";print_r($result);die();
		$count = 1;
		$listed = FALSE;

		if($result)
		{
			foreach ($result as $key => $value)
			{
				$name;

				switch ($type) {
					case 1:
						$name = $value['countyname'];
						break;
					case 2:
						$name = $value['subcounty'];
						break;
					case 3:
						$name = $value['partnername'];
						break;
					case 4:
						$name = $value['name'];
						break;
					default:
						break;
				}

				if ($count<16) {
					$li .= '<a href="javascript:void(0);" class="list-group-item" ><strong>'.$count.'.</strong>&nbsp;'.$name.'</a>';
				}

				$table .= '<tr>';
				$table .= '<td>'.$count.'</td>';
				$table .= '<td>'.$name.'</td>';

				if($suppressed == 1){
					$table .= '<td>'.$value['noage_suppressed'].'</td>';
					$table .= '<td>'.$value['less2_suppressed'].'</td>';
					$table .= '<td>'.$value['less9_suppressed'].'</td>';
					$table .= '<td>'.$value['less14_suppressed'].'</td>';
					$table .= '<td>'.$value['less19_suppressed'].'</td>';
					$table .= '<td>'.$value['less24_suppressed'].'</td>';
					$table .= '<td>'.$value['over25_suppressed'].'</td>';
				}
				else{
					$table .= '<td>'.$value['noage_nonsuppressed'].'</td>';
					$table .= '<td>'.$value['less2_nonsuppressed'].'</td>';				
					$table .= '<td>'.$value['less9_nonsuppressed'].'</td>';				
					$table .= '<td>'.$value['less14_nonsuppressed'].'</td>';				
					$table .= '<td>'.$value['less19_nonsuppressed'].'</td>';				
					$table .= '<td>'.$value['less24_nonsuppressed'].'</td>';				
					$table .= '<td>'.$value['over25_nonsuppressed'].'</td>';
				}

				$table .= '</tr>';
				$count++;
			}
		}
		else{
			$li = 'No Data';
		}

		$data = array(
						'ul' => $li,
						'table' => $table);
		return $data;
	}


	function suppression_gender_listings($type, $param_type=1, $param=NULL, $annual=NULL)
	{
		$li = '';
		$table = '';
		$sql = '';

		if($param_type == 1){

			if ($param==null || $param=='null') {
				$param = $this->session->userdata('county_filter');
			}

			if ($param==null || $param=='null') {
				$param = 0;
			}
			$sql = "CALL `proc_get_vl_current_gender_suppression_listing`({$type}, {$param})";
		}

		else{			

			if ($param==null || $param=='null') {
				$param = $this->session->userdata('partner_filter');
			}

			if ($param==null || $param=='null') {
				$param = 1000;
			}
			$sql = "CALL `proc_get_vl_current_gender_suppression_listing_partner`({$type}, {$param})";

			if($annual==1){
				$sql = "CALL `proc_get_vl_current_gender_suppression_listing_partner_year`({$type}, {$param})";
			}
		}

		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		// echo "<pre>";print_r($result);die();
		$count = 1;
		$listed = FALSE;

		if($result)
		{
			foreach ($result as $key => $value)
			{
				$name;

				switch ($type) {
					case 1:
						$name = $value['countyname'];
						break;
					case 2:
						$name = $value['subcounty'];
						break;
					case 3:
						$name = $value['partnername'];
						break;
					case 4:
						$name = $value['name'];
						break;
					default:
						break;
				}

				if ($count<16) {
					$li .= '<a href="javascript:void(0);" class="list-group-item" ><strong>'.$count.'.</strong>&nbsp;'.$name.'</a>';
				}

				$table .= '<tr>';
				$table .= '<td>'.$count.'</td>';
				$table .= '<td>'.$name.'</td>';
				$table .= '<td>'.$value['male_suppressed'].'</td>';
				$table .= '<td>'.$value['male_nonsuppressed'].'</td>';
				$table .= '<td>'.$value['female_suppressed'].'</td>';
				$table .= '<td>'.$value['female_nonsuppressed'].'</td>';
				$table .= '<td>'.$value['nogender_suppressed'].'</td>';
				$table .= '<td>'.$value['nogender_nonsuppressed'].'</td>';
				$table .= '</tr>';
				$count++;
			}
		}
		else{
			$li = 'No Data';
		}

		$data = array(
						'ul' => $li,
						'table' => $table);
		return $data;
	}

	function county_partner_table($year=NULL,$month=NULL,$to_year=null,$to_month=null, $county=null,$data)
	{
		$table = '';
		$count = 0;
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['county' => $county]);
		extract($d);
		$type = 4;
		$default = $data['county'];
		$sql = "CALL `proc_get_vl_site_summary`('".$year."','".$month."','".$to_year."','".$to_month."')";
		$sqlAge = "CALL `proc_get_vl_county_agecategories_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$default."');";
		$sqlGender = "CALL `proc_get_vl_county_gender_details`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$default."');";
		// echo "<pre>";print_r($sqlAge);die();
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		$resultage = $this->db->query($sqlAge)->result();
		$this->db->close();
		$resultGender = $this->db->query($sqlGender)->result();
		 // echo "<pre>";print_r($resultGender);die();
		$partners = [];
		$ageData = [];
		$genderData = [];
		foreach ($resultage as $key => $value) {
			if (!in_array($value->selection, $partners))
				$partners[] = $value->selection;
		}
		// echo "<pre>";print_r($partners);die();
		foreach ($partners as $key => $value) {
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
		// echo "<pre>";print_r($genderData);
		// echo "<pre>";print_r($genderData['AMPATH Plus']);die();
		foreach ($partners as $key => $value) {
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
		// echo "<pre>";print_r($genderData['AMPATH Plus']]['femaletests']);die();
		foreach ($result as $key => $value) {
			if (in_array($value['partner'], $partners)){
				$routine = ((int) $value['undetected'] + (int) $value['less1000'] + (int) $value['less5000'] + (int) $value['above5000']);
				$routinesus = ((int) $value['less5000'] + (int) $value['above5000']);
				$validTests = ((int) $routine + (int) $value['baseline'] + (int) $value['confirmtx']);
				$femaletests = ($genderData[$value['partner']]['femaletests']) ? number_format((int) $genderData[$value['partner']]['femaletests']) : 0;
				$femalesustx = ($genderData[$value['partner']]['femalesustx']) ? number_format((int) $genderData[$value['partner']]['femalesustx']) : 0;
				$maletests = ($genderData[$value['partner']]['maletests']) ? number_format((int) $genderData[$value['partner']]['maletests']) : 0;
				$malesustx = ($genderData[$value['partner']]['malesustx']) ? number_format((int) $genderData[$value['partner']]['malesustx']) : 0;
				$Nodatatests = ($genderData[$value['partner']]['Nodatatests']) ? number_format((int) $genderData[$value['partner']]['Nodatatests']) : 0;
				$Nodatasustx = ($genderData[$value['partner']]['Nodatasustx']) ? number_format((int) $genderData[$value['partner']]['Nodatasustx']) : 0;
				$less2tests = ($ageData[$value['partner']]['less2tests']) ? number_format($ageData[$value['partner']]['less2tests']) : 0;
				$less2sustx = ($ageData[$value['partner']]['less2sustx']) ? number_format($ageData[$value['partner']]['less2sustx']) : 0;
				$less9tests = ($ageData[$value['partner']]['less9tests']) ? number_format($ageData[$value['partner']]['less9tests']) : 0;
				$less9sustx = ($ageData[$value['partner']]['less9sustx']) ? number_format($ageData[$value['partner']]['less9sustx']) : 0;
				$less14tests = ($ageData[$value['partner']]['less14tests']) ? number_format($ageData[$value['partner']]['less14tests']) : 0;
				$less14sustx = ($ageData[$value['partner']]['less14sustx']) ? number_format($ageData[$value['partner']]['less14sustx']) : 0;
				$less19tests = ($ageData[$value['partner']]['less19tests']) ? number_format($ageData[$value['partner']]['less19tests']) : 0;
				$less19sustx = ($ageData[$value['partner']]['less19sustx']) ? number_format($ageData[$value['partner']]['less19sustx']) : 0;
				$less25tests = ($ageData[$value['partner']]['less25tests']) ? number_format($ageData[$value['partner']]['less25tests']) : 0;
				$less25sustx = ($ageData[$value['partner']]['less25sustx']) ? number_format($ageData[$value['partner']]['less25sustx']) : 0;
				$above25tests = ($ageData[$value['partner']]['above25tests']) ? number_format($ageData[$value['partner']]['above25tests']) : 0;
				$above25sustx = ($ageData[$value['partner']]['above25sustx']) ? number_format($ageData[$value['partner']]['above25sustx']) : 0;
				$table .= "<tr>
							<td>".($count+1)."</td>
							<td>".$value['partner']."</td>
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
		}
		
		// echo $table;die();
		return $table;
	}

}
?>
 
 
 
 
 
