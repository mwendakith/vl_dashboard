<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Summaries_model extends MY_Model
{
	function __construct()
	{
		parent:: __construct();
	}
 
	function turnaroundtime($year=null,$month=null,$county=null,$to_year=null,$to_month=null)
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
 
		$sql = "CALL `proc_get_national_tat`('".$year."','".$month."','".$to_year."','".$to_month."')";
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
			$data['tat1'] = round(@$value['tat1']/@$value['count']);
			$data['tat2'] = round((@$value['tat2']/@$value['count']) + @$data['tat1']);
			$data['tat3'] = round((@$value['tat3']/@$value['count']) + @$data['tat2']);
			$data['tat4'] = round(@$value['tat4']/@$value['count']);
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}
 
	function county_outcomes($year=null,$month=null,$pfil=null,$partner=null,$county=null,$to_year=null,$to_month=null)
	{
		// echo "Year:".$year.":--: Month:".$month.":--: County:".$county.":--: Partner:".$partner.":--: pfil:".$pfil;die();
		//Initializing the value of the Year to the selected year or the default year which is current year
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		//Assigning the value of the month or setting it to the selected value
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}
 
		// Assigning the value of the county
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}
				
		// echo "PFil: ".$pfil." --Partner: ".$partner." -- County: ".$county;
		if ($county) {
			$sql = "CALL `proc_get_county_sites_outcomes`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			if ($pfil==1) {
				if ($partner) {
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
			$data['outcomes'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$key] = (int) $value['suppressed'];
			$data['outcomes'][2]['data'][$key] = round(@(((int) $value['suppressed']*100)/((int) $value['suppressed']+(int) $value['nonsuppressed'])),1);
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}
 
	function vl_outcomes($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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
 
		if ($partner) {
			$sql = "CALL `proc_get_partner_vl_outcomes`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
			$sql2 = "CALL `proc_get_partner_sitessending`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
			$sql3 = "CALL `proc_get_vl_current_suppression`('3','".$partner."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_national_vl_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."')";
				$sql2 = "CALL `proc_get_national_sitessending`('".$year."','".$month."','".$to_year."','".$to_month."')";
				$sql3 = "CALL `proc_get_vl_current_suppression`('0','0')";
			} else {
				$sql = "CALL `proc_get_regional_vl_outcomes`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
				$sql2 = "CALL `proc_get_regional_sitessending`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
				$sql3 = "CALL `proc_get_vl_current_suppression`('1','".$county."')";
			}
		}
		// echo "<pre>";print_r($sql);echo "</pre>";
		// echo "<pre>";print_r($sql2);echo "</pre>";die();
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		$sitessending = $this->db->query($sql2)->result_array();
		$this->db->close();
		$current = $this->db->query($sql3)->row();
		$this->db->close();
		// echo "<pre>";print_r($result);echo "</pre>";
		// echo "<pre>";print_r($sitessending);echo "</pre>";die();
		$color = array('#6BB9F0', '#F2784B', '#1BA39C', '#5C97BF');
 
		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;
		$data['ul'] = '';
 
		$data['vl_outcomes']['data'][0]['name'] = 'Suppresed';
		$data['vl_outcomes']['data'][1]['name'] = 'Not Suppresed';
 
		$count = 0;
 
		$data['vl_outcomes']['data'][0]['y'] = $count;
		$data['vl_outcomes']['data'][1]['y'] = $count;
 
		foreach ($result as $key => $value) {
			$total = (int) ($value['undetected']+$value['less1000']+$value['less5000']+$value['above5000']);
			$less = (int) ($value['undetected']+$value['less1000']);
			$greater = (int) ($value['less5000']+$value['above5000']);
			$non_suppressed = $greater + (int) $value['confirm2vl'];
			$total_tests = (int) $value['confirmtx'] + $total;
			
			// 	<td colspan="2">Cumulative Tests (All Samples Run):</td>
	    	// 	<td colspan="2">'.number_format($value['alltests']).'</td>
	    	// </tr>
	    	// <tr>
			$data['ul'] .= '
			<tr>
	    		<td>Current Suppressed:</td>
	    		<td>'.number_format($current->suppressed) . ' (' . round($current->suppression, 2) .'%)</td>
	    		<td>Current Non Suppressed</td>
	    		<td>'. number_format($current->nonsuppressed) . '</td>
	    	</tr>
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
	    		<td>'.number_format($less).'</td>
	    		<td>Percentage Suppression</td>
	    		<td>'.round((($less/$total)*100),1).'%</td>
	    	</tr>
 
	    	<tr>
	    		<td>&nbsp;&nbsp;&nbsp;Baseline VLs:</td>
	    		<td>'.number_format($value['baseline']).'</td>
	    		<td>Non Suppression ( &gt; 1000cpml)</td>
	    		<td>'.number_format($value['baselinesustxfail']). ' (' .round(($value['baselinesustxfail'] * 100 / $value['baseline']), 1). '%)' .'</td>
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
		// echo "<pre>";print_r($sites);echo "<pre>";print_r($count);echo "<pre>";print_r(round(@$sites / $count));die();
		$data['ul'] .= "<tr> <td colspan=2>Average Sites Sending:</td><td colspan=2>".number_format(round(@$sites / $count))."</td></tr>";
		$count = 1;
		$sites = 0;
 
		$data['vl_outcomes']['data'][0]['sliced'] = true;
		$data['vl_outcomes']['data'][0]['selected'] = true;
		
		return $data;
	}
 
	function justification($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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
 
		if ($partner) {
			$sql = "CALL `proc_get_partner_justification`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			if ($county==null || $county=='null') {
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
 
	function justification_breakdown($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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
 
		if ($partner) {
			$sql = "CALL `proc_get_partner_justification_breakdown`('6','".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
			$sql2 = "CALL `proc_get_partner_justification_breakdown`('9','".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_national_justification_breakdown`('6','".$year."','".$month."','".$to_year."','".$to_month."')";
				$sql2 = "CALL `proc_get_national_justification_breakdown`('9','".$year."','".$month."','".$to_year."','".$to_month."')";
			} else {
				$sql = "CALL `proc_get_regional_justification_breakdown`('6','".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
				$sql2 = "CALL `proc_get_regional_justification_breakdown`('9','".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
			}
		}
		// echo "<pre>";print_r($sql);
		// echo "<pre>";print_r($sql2);die();
		
		$preg_mo = $this->db->query($sql)->result_array();
		$this->db->close();
		$lac_mo = $this->db->query($sql2)->result_array();
		// echo "<pre>";print_r($preg_mo);echo "</pre>";
		// echo "<pre>";print_r($lac_mo);die();
		$data['just_breakdown'][0]['name'] = 'Not Suppresed';
		$data['just_breakdown'][1]['name'] = 'Suppresed';
 
		$count = 0;
		
		$data["just_breakdown"][0]["data"][0]	= $count;
		$data["just_breakdown"][1]["data"][0]	= $count;
		$data['categories'][0]			= 'No Data';
 
		foreach ($preg_mo as $key => $value) {
			$data['categories'][0] 			= 'Pregnant Mothers';
			$data["just_breakdown"][0]["data"][0]	=  (int) $value['less5000'] + (int) $value['above5000'];
			$data["just_breakdown"][1]["data"][0]	=  (int) $value['Undetected'] + (int) $value['less1000'];
		}
 
		foreach ($lac_mo as $key => $value) {
			$data['categories'][1] 			= 'Lactating Mothers';
			$data["just_breakdown"][0]["data"][1]	=  (int) $value['less5000'] + (int) $value['above5000'];
			$data["just_breakdown"][1]["data"][1]	=  (int) $value['Undetected'] + (int) $value['less1000'];
		}
 
		$data['just_breakdown'][0]['drilldown']['color'] = '#913D88';
		$data['just_breakdown'][1]['drilldown']['color'] = '#96281B';
				
		return $data;
	}
 
	function age($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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
 
		if ($partner) {
			$sql = "CALL `proc_get_partner_age`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			if ($county==null || $county=='null') {
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
		$data['ageGnd'][0]['name'] = 'Not Suppresed';
		$data['ageGnd'][1]['name'] = 'Suppresed';
 
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
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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
 
		if ($partner) {
			$sql = "CALL `proc_get_partner_age`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			if ($county==null || $county=='null') {
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
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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
 
		if ($partner) {
			$sql = "CALL `proc_get_partner_gender`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_national_gender`('".$year."','".$month."','".$to_year."','".$to_month."')";
			} else {
				$sql = "CALL `proc_get_regional_gender`('".$county."','".$year."','".$month."','".$to_year."','".$to_month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['gender'][0]['name'] = 'Not Suppresed';
		$data['gender'][1]['name'] = 'Suppresed';
 
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

	function get_sampletypesData($year=null,$county=null,$partner=null)
	{
		$array1 = array();
		$array2 = array();
		$sql2 = NULL;
 
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}
 
 
		if ($year==null || $year=='null') {
			$to = $this->session->userdata('filter_year');
		}else {
			$to = $year;
		}
		$from = $to-1;
 
		if ($partner) {
			$sql = "CALL `proc_get_partner_sample_types`('".$partner."','".$from."','".$to."')";
			// $sql2 = "CALL `proc_get_partner_sample_types`('".$partner."','".$to."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_national_sample_types`('".$from."','".$to."')";
			} else {
				$sql = "CALL `proc_get_regional_sample_types`('".$county."','".$from."','".$to."')";
				// $sql2 = "CALL `proc_get_regional_sample_types`('".$county."','".$to."')";
			}
		}
		// echo "<pre>";print_r($sql);echo "</pre>";
		// echo "<pre>";print_r($sql2);die();
		$array1 = $this->db->query($sql)->result_array();
		return $array1;
		
		// if ($sql2) {
		// 	$this->db->close();
		// 	$array2 = $this->db->query($sql2)->result_array();
		// }
 
		// return array_merge($array1,$array2);
	}
 
	function sample_types($year=null,$county=null,$partner=null, $all=null)
	{
		$result = $this->get_sampletypesData($year,$county,$partner);
		// echo "<pre>";print_r($result);die();
		$data['sample_types'][0]['name'] = 'EDTA';
		$data['sample_types'][1]['name'] = 'DBS';
		$data['sample_types'][2]['name'] = 'Plasma';
		// $data['sample_types'][3]['name'] = 'Suppression';
 
		$count = 0;
		
		$data['categories'][0] = 'No Data';
		$data["sample_types"][0]["data"][0]	= $count;
		$data["sample_types"][1]["data"][0]	= $count;
		$data["sample_types"][2]["data"][0]	= $count;
		// $data["sample_types"][3]["data"][0]	= $count;
 
		foreach ($result as $key => $value) {
			
				$data['categories'][$key] = $this->resolve_month($value['month']).'-'.$value['year'];

				if($all == 1){
 					$data["sample_types"][0]["data"][$key]	= (int) $value['alledta'];
					$data["sample_types"][1]["data"][$key]	= (int) $value['alldbs'];
					$data["sample_types"][2]["data"][$key]	= (int) $value['allplasma'];
				}
 				else{
 					$data["sample_types"][0]["data"][$key]	= (int) $value['edta'];
					$data["sample_types"][1]["data"][$key]	= (int) $value['dbs'];
					$data["sample_types"][2]["data"][$key]	= (int) $value['plasma'];
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
		$type = 0;
		$params;

		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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

		$sql;

		if ($partner) {
			$params = "patient/partner/{$partner}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
			$sql = "Select sum(totalartmar) as totalartmar from view_facilitys where partner='{$partner}'";
		} else {
			if ($county==null || $county=='null') {
				$params = "patient/national/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
				$sql = "Select sum(totalartmar) as totalartmar from view_facilitys'";
			} else {
				$query = $this->db->get_where('CountyMFLCode', array('id' => $county), 1)->row();
				$c = $query->CountyMFLCode;

				$params = "patient/county/{$c}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
				$sql = "Select sum(totalartmar) as totalartmar from view_facilitys where county='{$county}'";
			}
		}
		$this->db->close();

		$result = $this->req($params);		

		// echo "<pre>";print_r($result);die();

		$data['outcomes'][0]['name'] = "Patients grouped by tests received";

		$data['outcomes'][0]['type'] = "column";

		$data['outcomes'][0]['yAxis'] = 1;

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');

		$data['title'] = " ";

		foreach ($result as $key => $value) {

			$data['categories'][$key] = $value->tests;
		
			$data['outcomes'][0]['data'][$key] = (int) $value->totals;

		}


		return $data;
	}

	function get_patients_outcomes($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		$type = 0;
		$params;

		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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

		if ($partner) {
			$params = "patient/partner/{$partner}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
		} else {
			if ($county==null || $county=='null') {
				$params = "patient/national/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
			} else {
				$query = $this->db->get_where('CountyMFLCode', array('id' => $county), 1)->row();
				$c = $query->CountyMFLCode;

				$params = "patient/county/{$c}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
			}
		}

		$result = $this->req($params);

		$data['categories'] = array('Total Patients', "VL's Done");
		$data['outcomes']['name'] = 'Tests';
		$data['outcomes']['data'][0] = (int) $result->total_patients;
		$data['outcomes']['data'][1] = (int) $result->total_viralloads;
		$data["outcomes"]["color"] =  '#1BA39C';

		return $data;
	}

	function get_patients_graph($year=null,$month=null,$county=null,$partner=null,$to_year=null,$to_month=null)
	{
		$type = 0;
		$params;

		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
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

		if ($partner) {
			$params = "patient/partner/{$partner}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
		} else {
			if ($county==null || $county=='null') {
				$params = "patient/national/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
			} else {
				$query = $this->db->get_where('CountyMFLCode', array('id' => $county), 1)->row();
				$c = $query->CountyMFLCode;

				$params = "patient/county/{$c}/{$type}/{$year}/{$month}/{$to_year}/{$to_month}";
			}
		}

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
}
?>
 
 
 
 
 
