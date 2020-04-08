<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
* 
*/
class Regimen_model extends MY_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function regimens_outcomes($year=NULL,$month=NULL,$to_year=null,$to_month=null,$partner=NULL, $group=0)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['partner' => $partner]);
		extract($d);

		if (!$partner) {
			$sql = "CALL `proc_get_vl_regimen_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."'.'".$group."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_regimen_outcomes`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
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

		$data['categories'][0] = "No Data";
		$data['outcomes'][0]['data'][0] = 0;
		$data['outcomes'][1]['data'][0] = 0;
		$data['outcomes'][2]['data'][0] = 0;
 
		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['regimenname'];
			$data['outcomes'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$key] = (int) $value['suppressed'];
			$data['outcomes'][2]['data'][$key] = round(@(((int) $value['suppressed']*100)/((int) $value['suppressed']+(int) $value['nonsuppressed'])),1);
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function regimens_outcomes_group($group,$year,$month,$to_year,$to_month)
	{

	}

	function regimen_vl_outcomes($year=NULL,$month=NULL,$regimen=NULL,$to_year=null,$to_month=null,$partner=NULL)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['partner' => $partner, 'regimen' => $regimen]);
		extract($d);

		if (!$partner) {
			$sql = "CALL `proc_get_vl_regimen_vl_outcomes`('".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_regimen_vl_outcomes`('".$partner."','".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
				
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
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

	function regimen_gender($year=NULL,$month=NULL,$regimen=NULL,$to_year=null,$to_month=null,$partner=NULL)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['partner' => $partner, 'regimen' => $regimen]);
		extract($d);

		if (!$partner) {
			$sql = "CALL `proc_get_vl_regimen_gender`('".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_regimen_gender`('".$partner."','".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
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

		$count = 0;
		
		$data["outcomes"][0]["data"][0]	= $count;
		$data["outcomes"][0]["data"][1]	= $count;
		$data['categories'][0]			= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][0] 			= 'Male';
			$data['categories'][1] 			= 'Female';
			$data['categories'][2] 			= 'No Data';
			$data["outcomes"][0]["data"][0]	=  (int) $value['malenonsuppressed'];
			$data["outcomes"][0]["data"][1]	=  (int) $value['femalenonsuppressed'];
			$data["outcomes"][0]["data"][2]	= (int) $value['nogendernonsuppressed'];

			$data["outcomes"][1]["data"][0]	=  (int) $value['maletest'] - (int) $value['malenonsuppressed'];
			$data["outcomes"][1]["data"][1]	=  (int) $value['femaletest'] - (int) $value['femalenonsuppressed'];
			$data["outcomes"][1]["data"][2]	= (int) $value['nodata'] - (int) $value['nogendernonsuppressed'];

			$data["outcomes"][2]["data"][0]	=  round(@(((int) $value['maletest'] - (int) $value['malenonsuppressed'])/(int) $value['maletest'])*100, 1);
			$data["outcomes"][2]["data"][1]	=  round(@(((int) $value['femaletest'] - (int) $value['femalenonsuppressed'])/(int) $value['femaletest'])*100, 1);
			$data["outcomes"][2]["data"][2]	= round(@(((int) $value['nodata'] - (int) $value['nogendernonsuppressed'])/(int) $value['nodata'])*100, 1);
		}
		$data['title'] = '';
		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		
		return $data;
	}

	function regimen_age($year=NULL,$month=NULL,$regimen=NULL,$to_year=null,$to_month=null,$partner=NULL)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['partner' => $partner, 'regimen' => $regimen]);
		extract($d);

		if (!$partner) {
			$sql = "CALL `proc_get_vl_regimen_age`('".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_regimen_age`('".$partner."','".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
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

		$count = 0;
		
		$data["outcomes"][0]["data"][0]	= $count;
		$data["outcomes"][0]["data"][1]	= $count;
		$data['categories'][0]			= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][0] 			= 'No Age';
			$data['categories'][1] 			= 'Less 2';
			$data['categories'][2] 			= 'Less 9';
			$data['categories'][3] 			= 'Less 14';
			$data['categories'][4] 			= 'Less 19';
			$data['categories'][5] 			= 'Less 24';
			$data['categories'][6] 			= 'over 25';
			$data["outcomes"][0]["data"][0]	=  (int) $value['noage_nonsuppressed'];
			$data["outcomes"][0]["data"][1]	=  (int) $value['less2_nonsuppressed'];
			$data["outcomes"][0]["data"][2]	=  (int) $value['less9_nonsuppressed'];
			$data["outcomes"][0]["data"][3]	=  (int) $value['less14_nonsuppressed'];
			$data["outcomes"][0]["data"][4]	=  (int) $value['less19_nonsuppressed'];
			$data["outcomes"][0]["data"][5]	=  (int) $value['less24_nonsuppressed'];
			$data["outcomes"][0]["data"][6]	=  (int) $value['over25_nonsuppressed'];

			$data["outcomes"][1]["data"][0]	=  (int) $value['noage']  - (int) $value['noage_nonsuppressed'];
			$data["outcomes"][1]["data"][1]	=  (int) $value['less2']  - (int) $value['less2_nonsuppressed'];
			$data["outcomes"][1]["data"][2]	=  (int) $value['less9']  - (int) $value['less9_nonsuppressed'];
			$data["outcomes"][1]["data"][3]	=  (int) $value['less14'] - (int) $value['less14_nonsuppressed'];
			$data["outcomes"][1]["data"][4]	=  (int) $value['less19'] - (int) $value['less19_nonsuppressed'];
			$data["outcomes"][1]["data"][5]	=  (int) $value['less24'] - (int) $value['less24_nonsuppressed'];
			$data["outcomes"][1]["data"][6]	=  (int) $value['over25'] - (int) $value['over25_nonsuppressed'];

			$data["outcomes"][2]["data"][0]	=  round(@(((int) $value['noage']  - (int) $value['noage_nonsuppressed'])/(int) $value['noage'])*100, 1);
			$data["outcomes"][2]["data"][1]	=  round(@(((int) $value['less2']  - (int) $value['less2_nonsuppressed'])/(int) $value['less2'])*100, 1);
			$data["outcomes"][2]["data"][2]	=  round(@(((int) $value['less9']  - (int) $value['less9_nonsuppressed'])/(int) $value['less9'])*100, 1);
			$data["outcomes"][2]["data"][3]	=  round(@(((int) $value['less14'] - (int) $value['less14_nonsuppressed'])/(int) $value['less14'])*100, 1);
			$data["outcomes"][2]["data"][4]	=  round(@(((int) $value['less19'] - (int) $value['less19_nonsuppressed'])/(int) $value['less19'])*100, 1);
			$data["outcomes"][2]["data"][5]	=  round(@(((int) $value['less24'] - (int) $value['less24_nonsuppressed'])/(int) $value['less24'])*100, 1);
			$data["outcomes"][2]["data"][6]	=  round(@(((int) $value['over25'] - (int) $value['over25_nonsuppressed'])/(int) $value['over25'])*100, 1);
		}
		$data['title'] = '';
		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function get_sampletypesData($year=NULL,$regimen=NULL,$partner=null)
	{
		$array1 = array();
		$array2 = array();
		$sql2 = NULL;

		if ($partner==null || $partner=='null') {
			$partner = null;
		}
		if ($regimen==null || $regimen=='null') {
			$regimen = $this->session->userdata('regimen_filter');
		}
		
		if ($year==null || $year=='null') {
			$to = $this->session->userdata('filter_year');
		}else {
			$to = $year;
		}
		$from = $to-1;

		if ($partner==null) {
			$sql = "CALL `proc_get_vl_sample_types`('".$regimen."','".$from."')";
			$sql2 = "CALL `proc_get_vl_sample_types`('".$regimen."','".$to."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_regimen_sample_types`('".$partner."','".$regimen."','".$from."')";
			$sql2 = "CALL `proc_get_vl_partner_regimen_sample_types`('".$partner."','".$regimen."','".$to."')";
		}
		// echo "<pre>";print_r($sql);die();
		$array1 = $this->db->query($sql)->result_array();
		
		if ($sql2) {
			$this->db->close();
			$array2 = $this->db->query($sql2)->result_array();
		}
 
		return array_merge($array1,$array2);
	}

	function regimen_samples($year=NULL,$regimen=NULL,$partner=NULL)
	{
		$result = $this->get_sampletypesData($year,$regimen,$partner);

		$data['sample_types'][0]['name'] = 'Plasma';
		$data['sample_types'][1]['name'] = 'DBS';
		$data['sample_types'][2]['name'] = 'Suppression';

		$data['sample_types'][0]['type'] = "column";
		$data['sample_types'][1]['type'] = "column";
		$data['sample_types'][2]['type'] = "spline";

		$data['sample_types'][0]['yAxis'] = 1;
		$data['sample_types'][1]['yAxis'] = 1;

		$data['sample_types'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['sample_types'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['sample_types'][2]['tooltip'] = array("valueSuffix" => ' %');
 
		$count = 0;
		
		$data['categories'][0] = 'No Data';
		$data["sample_types"][0]["data"][0]	= $count;
		$data["sample_types"][1]["data"][0]	= $count;
		$data["sample_types"][2]["data"][0]	= $count;
 
		foreach ($result as $key => $value) {
			
				$data['categories'][$key] = $this->resolve_month($value['month']).'-'.$value['year'];
 
				$data["sample_types"][0]["data"][$key]	= (int) ($value['edta'] + $value['plasma']);
				$data["sample_types"][1]["data"][$key]	= (int) $value['dbs'];
				$data["sample_types"][2]["data"][$key]	= round($value['suppression'],1);
			
		}
		
		return $data;
	}

	function download_sampletypes($year=NULL,$regimen=NULL,$partner=null)
	{
		$data = $this->get_sampletypesData($year,$regimen,$partner);
		// echo "<pre>";print_r($result);die();
		$this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

	    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('Month', 'Year', 'EDTA', 'DBS', 'Plasma', 'Suppressed', 'Tests', 'Suppression');

	    fputcsv($f, $b, $delimiter);

	    foreach ($data as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="'.Date('YmdH:i:s').'vl_regimensampleTypes.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
	}

	function county_outcomes($year=null,$month=null,$regimen=null,$to_year=null,$to_month=null,$partner=NULL)
	{
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['partner' => $partner, 'regimen' => $regimen]);
		extract($d);

		if (!$partner) {
			$sql = "CALL `proc_get_vl_county_regimen_outcomes`('".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_county_regimen_outcomes`('".$partner."','".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		
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

		$data['categories'][0] = "No Data";
		$data['outcomes'][0]['data'][0] = 0;
		$data['outcomes'][1]['data'][0] = 0;
		$data['outcomes'][2]['data'][0] = 0;
 
		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data['outcomes'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$key] = (int) $value['suppressed'];
			$data['outcomes'][2]['data'][$key] = round(@(((int) $value['suppressed']*100)/((int) $value['suppressed']+(int) $value['nonsuppressed'])),1);
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function regimens_breakdowns($year=null,$month=null,$regimen=null,$to_year=null,$to_month=null,$county=null,$partner=null,$subcounty=null,$site=null)
	{
		$default = 0;
		$li = '';
		$table = '';
		$d = $this->extract_variables($year, $month, $to_year, $to_month, ['regimen' => $regimen]);
		extract($d);

		if ($county == 1 || $county == '1') {
			$sql = "CALL `proc_get_vl_regimens_breakdowns_outcomes`('".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."','".$county."','".$default."','".$default."','".$default."')";
			$div_name = 'countyLising';
			$modal_name = 'countyModal';
		} elseif ($partner == 1 || $partner == '1') {
			$sql = "CALL `proc_get_vl_regimens_breakdowns_outcomes`('".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."','".$default."','".$partner."','".$default."','".$default."')";
			$div_name = 'partnerLising';
			$modal_name = 'partnerModal';
		} elseif ($subcounty == 1 || $subcounty == '1') {
			$sql = "CALL `proc_get_vl_regimens_breakdowns_outcomes`('".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."','".$default."','".$default."','".$subcounty."','".$default."')";
			$div_name = 'subcountyLising';
			$modal_name = 'subcountyModal';
		} elseif ($site == 1 || $site == '1') {
			$sql = "CALL `proc_get_vl_regimens_breakdowns_outcomes`('".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."','".$default."','".$default."','".$default."','".$site."')";
			$div_name = 'siteLising';
			$modal_name = 'siteModal';
		}

		$result = $this->db->query($sql)->result_array();
		
		$count = 1;

		if($result)
		{
			foreach ($result as $key => $value)
			{
				if ($count<16) {
					$li .= '<a href="javascript:void(0);" class="list-group-item" ><strong>'.$count.'.</strong>&nbsp;'.$value['name'].':&nbsp;&nbsp;&nbsp;'.round($value['percentage'],1).'%&nbsp;&nbsp;&nbsp;('.number_format($value['total']).')</a>';
				}
					$table .= '<tr>';
					$table .= '<td>'.$count.'</td>';
					$table .= '<td>'.$value['name'].'</td>';
					$table .= '<td>'.number_format((int) $value['total']).'</td>';
					$table .= '<td>'.number_format((int) $value['suppressed']).'</td>';
					$table .= '<td>'.number_format((int) $value['nonsuppressed']).'</td>';
					$table .= '<td>'.round($value['percentage'],1).'%</td>';
					$table .= '</tr>';
					$count++;
			}
		}else{
			$li = 'No Data';
		}
		
		$data = array(
						'ul' => $li,
						'table' => $table,
						'div_name' => $div_name,
						'modal_name' => $modal_name);
		return $data;
	}
}
?>