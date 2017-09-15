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

	function regimens_outcomes($year=NULL,$month=NULL,$to_year=null,$to_month=null,$partner=NULL)
	{
		if ($partner==null || $partner=='null') {
			$partner = null;
		}
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

		if ($partner==null) {
			$sql = "CALL `proc_get_vl_regimen_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."')";
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
 
		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data['outcomes'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$key] = (int) $value['suppressed'];
			$data['outcomes'][2]['data'][$key] = round(@(((int) $value['suppressed']*100)/((int) $value['suppressed']+(int) $value['nonsuppressed'])),1);
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function regimen_vl_outcomes($year=NULL,$month=NULL,$regimen=NULL,$to_year=null,$to_month=null,$partner=NULL)
	{
		if ($partner==null || $partner=='null') {
			$partner = null;
		}
		if ($regimen==null || $regimen=='null') {
			$regimen = $this->session->userdata('regimen_filter');
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

		if ($partner==null) {
			$sql = "CALL `proc_get_vl_regimen_vl_outcomes`('".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_regimen_vl_outcomes`('".$partner."','".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
				
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

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
	    		<td>'. round((($value['rejected']*100)/$value['alltests']), 1, PHP_ROUND_HALF_UP).'%</td>
	    	</tr>';
						
			$data['vl_outcomes']['data'][0]['y'] = (int) $value['undetected']+(int) $value['less1000'];
			$data['vl_outcomes']['data'][1]['y'] = (int) $value['less5000']+(int) $value['above5000'];

			$data['vl_outcomes']['data'][0]['color'] = '#1BA39C';
			$data['vl_outcomes']['data'][1]['color'] = '#F2784B';
		}
		$data['vl_outcomes']['data'][0]['sliced'] = true;
		$data['vl_outcomes']['data'][0]['selected'] = true;
		
		return $data;
	}

	function regimen_gender($year=NULL,$month=NULL,$regimen=NULL,$to_year=null,$to_month=null,$partner=NULL)
	{
		if ($partner==null || $partner=='null') {
			$partner = null;
		}
		if ($regimen==null || $regimen=='null') {
			$regimen = $this->session->userdata('regimen_filter');
		}
		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($to_year==null || $to_year=='null') {
			$to_year = 0;
		}
		if ($to_month==null || $to_month=='null') {
			$to_month = 0;
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		if ($partner==null) {
			$sql = "CALL `proc_get_vl_regimen_gender`('".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_regimen_gender`('".$partner."','".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['gender'][0]['name'] = 'Test';

		$count = 0;
		
		$data["gender"][0]["data"][0]	= $count;
		$data["gender"][0]["data"][1]	= $count;
		$data['categories'][0]			= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][0] 			= 'Male';
			$data['categories'][1] 			= 'Female';
			$data['categories'][2] 			= 'No Data';
			$data["gender"][0]["data"][0]	=  (int) $value['maletest'];
			$data["gender"][0]["data"][1]	=  (int) $value['femaletest'];
			$data["gender"][0]["data"][2]	= (int) $value['nodata'];
		}

		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		
		return $data;
	}

	function regimen_age($year=NULL,$month=NULL,$regimen=NULL,$to_year=null,$to_month=null,$partner=NULL)
	{
		if ($partner==null || $partner=='null') {
			$partner = null;
		}
		if ($regimen==null || $regimen=='null') {
			$regimen = $this->session->userdata('regimen_filter');
		}
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

		if ($partner==null) {
			$sql = "CALL `proc_get_vl_regimen_age`('".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_regimen_age`('".$partner."','".$regimen."','".$year."','".$month."','".$to_year."','".$to_month."')";
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

		$data['sample_types'][0]['name'] = 'EDTA';
		$data['sample_types'][1]['name'] = 'DBS';
		$data['sample_types'][2]['name'] = 'Plasma';
		$data['sample_types'][3]['name'] = 'Suppression';

		$data['sample_types'][0]['type'] = "column";
		$data['sample_types'][1]['type'] = "column";
		$data['sample_types'][2]['type'] = "column";
		$data['sample_types'][3]['type'] = "spline";

		$data['sample_types'][0]['yAxis'] = 1;
		$data['sample_types'][1]['yAxis'] = 1;
		$data['sample_types'][2]['yAxis'] = 1;

		$data['sample_types'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['sample_types'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['sample_types'][2]['tooltip'] = array("valueSuffix" => ' ');
		$data['sample_types'][3]['tooltip'] = array("valueSuffix" => ' %');
 
		$count = 0;
		
		$data['categories'][0] = 'No Data';
		$data["sample_types"][0]["data"][0]	= $count;
		$data["sample_types"][1]["data"][0]	= $count;
		$data["sample_types"][2]["data"][0]	= $count;
		$data["sample_types"][3]["data"][0]	= $count;
 
		foreach ($result as $key => $value) {
			
				$data['categories'][$key] = $this->resolve_month($value['month']).'-'.$value['year'];
 
				$data["sample_types"][0]["data"][$key]	= (int) $value['edta'];
				$data["sample_types"][1]["data"][$key]	= (int) $value['dbs'];
				$data["sample_types"][2]["data"][$key]	= (int) $value['plasma'];
				$data["sample_types"][3]["data"][$key]	= round($value['suppression'],1);
			
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
		
		if ($partner==null || $partner=='null') {
			$partner = null;
		}
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

		if ($regimen==null || $regimen=='null') {
			$regimen = $this->session->userdata('regimen_filter');
		}

		if ($partner==null) {
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
 
		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data['outcomes'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$key] = (int) $value['suppressed'];
			$data['outcomes'][2]['data'][$key] = round(@(((int) $value['suppressed']*100)/((int) $value['suppressed']+(int) $value['nonsuppressed'])),1);
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}
}
?>