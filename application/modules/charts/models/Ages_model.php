<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Ages_model extends MY_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function build_Inarray($array = null)
	{
		if (is_null($array)) return null;
		$query = "IN (";
		$elements = sizeof($array);
		foreach ($array as $key => $value) {
			($key+1 == $elements) ? $query .= $value : $query .= $value . ",";
		}
		$query .= ")";
		return $query;
	}

	function ages_outcomes($year=NULL,$month=NULL,$to_year=null,$to_month=null,$partner=null)
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
		if ($partner==null || $partner=='null') {
			$partner = null;
		}

		if ($partner==null) {
			$sql = "CALL `proc_get_vl_age_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_age_outcomes`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
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
	 	$data['categories'][0] 			= "No Data";
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

	function partner_ages_outcomes($year=NULL,$month=NULL,$to_year=null,$to_month=null,$age_cat=null)
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

		if ($age_cat==null || $age_cat=='null') {
			$age_cat = $this->session->userdata('age_category_filter');
		}
		$age_cat = $this->build_Inarray($age_cat);
				
		$sql = "CALL `proc_get_vl_partner_age_suppression`('".$age_cat."','".$year."','".$month."','".$to_year."','".$to_month."')";	
		
		
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

	function ages_vl_outcomes($year=NULL,$month=NULL,$age_cat=NULL,$to_year=null,$to_month=null,$partner=null)
	{
		if ($age_cat==null || $age_cat=='null') {
			$age_cat = $this->session->userdata('age_category_filter');
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
		if ($partner==null || $partner=='null') {
			$partner = null;
		}
		
		$age_cat = $this->build_Inarray($age_cat);
		
		if ($partner==null) {
			$sql = "CALL `proc_get_vl_age_vl_outcomes`('".$age_cat."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_age_vl_outcomes`('".$partner."','".$age_cat."','".$year."','".$month."','".$to_year."','".$to_month."')";
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

	function ages_gender($year=NULL,$month=NULL,$age_cat=NULL,$to_year=null,$to_month=null,$partner=null)
	{
		$age_cat = $this->build_Inarray($age_cat);
		if ($age_cat==null || $age_cat=='null') {
			$age_cat = $this->session->userdata('age_category_filter');
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
		if ($partner==null || $partner=='null') {
			$partner = null;
		}

		if ($partner==null) {
			$sql = "CALL `proc_get_vl_age_gender`('".$age_cat."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_age_gender`('".$partner."','".$age_cat."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		
		if ($partner==null) {
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

			$data['categories'][0] 			= 'Male';
			$data['categories'][1] 			= 'Female';
			$data['categories'][2] 			= 'No Data';

			foreach ($result as $key => $value) {
				$nodata = (int) $value['nodatanonsuppressed'] + (int) $value['nodatasuppressed'];
				$male = (int) $value['malenonsuppressed'] + (int) $value['malesuppressed'];
				$female = (int) $value['femalenonsuppressed'] + (int) $value['femalesuppressed'];

				$data["outcomes"][0]["data"][0]	=  (int) $value['malenonsuppressed'];
				$data["outcomes"][1]["data"][0]	=  (int) $value['malesuppressed'];
				$data["outcomes"][2]["data"][0]	=  round(((int) $value['malesuppressed']/$male)*100,1);
				$data["outcomes"][0]["data"][1]	=  (int) $value['femalenonsuppressed'];
				$data["outcomes"][1]["data"][1]	=  (int) $value['femalesuppressed'];
				$data["outcomes"][2]["data"][1]	=  round(((int) $value['femalesuppressed']/$female)*100,1);
				$data["outcomes"][0]["data"][2]	=  (int) $value['nodatanonsuppressed'];
				$data["outcomes"][1]["data"][2]	=  (int) $value['nodatasuppressed'];
				$data["outcomes"][2]["data"][2]	=  round(((int) $value['nodatasuppressed']/$nodata)*100,1);
			}
		} else {
			// echo "<pre>";print_r($result);die();
			$data['outcomes'][0]['name'] = "Tests";

			$data['title'] = "";

			$data['categories'][0] 			= 'Male';
			$data['categories'][1] 			= 'Female';
			$data['categories'][2] 			= 'No Data';

			foreach ($result as $key => $value) {
				$data["outcomes"][0]["data"][0]	=  (int) $value['maletest'];
				$data["outcomes"][0]["data"][1]	=  (int) $value['femaletest'];
				$data["outcomes"][0]["data"][2]	=  (int) $value['nodata'];
			}
		}
		
		// $data['gender'][0]['drilldown']['color'] = ;
		// $data['gender'][1]['drilldown']['color'] = '#1BA39C';
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function get_sampletypesData($year=NULL,$age_cat=NULL,$partner=null)
	{

		$age_cat = $this->build_Inarray($age_cat);

		$array1 = array();
		$array2 = array();
		$sql2 = NULL;

		if ($age_cat==null || $age_cat=='null') {
			$age_cat = $this->session->userdata('age_category_filter');
		}

		
		if ($year==null || $year=='null') {
			$to = $this->session->userdata('filter_year');
		}else {
			$to = $year;
		}
		if ($partner==null || $partner=='null') {
			$partner = null;
		}
		$from = $to-1;

		if ($partner==null) {
			$sql = "CALL `proc_get_vl_age_sample_types`('".$age_cat."','".$from."')";
			$sql2 = "CALL `proc_get_vl_age_sample_types`('".$age_cat."','".$to."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_age_sample_types`('".$partner."','".$age_cat."','".$from."')";
			$sql2 = "CALL `proc_get_vl_partner_age_sample_types`('".$partner."','".$age_cat."','".$to."')";
		}
		
		$array1 = $this->db->query($sql)->result_array();
		
		if ($sql2) {
			$this->db->close();
			$array2 = $this->db->query($sql2)->result_array();
		}
 
		return array_merge($array1,$array2);
	}

	function ages_samples($year=NULL,$age_cat=NULL,$partner=null)
	{
		$result = $this->get_sampletypesData($year,$age_cat,$partner);
		
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
				$data["sample_types"][3]["data"][$key]	= round(@($value['suppressed']/$value['tests'])*100,1);
			
		}
		
		return $data;
	}

	function download_sampletypes($year=NULL,$age_cat=NULL,$partner=null)
	{
		$data = $this->get_sampletypesData($year,$age_cat,$partner);
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
	    header('Content-Disposition: attachement; filename="'.Date('YmdH:i:s').'vl_agessampleTypes.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
	}

	function ages_breakdowns($year=null,$month=null,$age_cat=null,$to_year=null,$to_month=null,$county=null,$partner=null,$subcounty=null,$site=null)
	{
		$default = 0;
		$li = '';
		$table = '';
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

		if ($age_cat==null || $age_cat=='null') {
			$age_cat = $this->session->userdata('age_category_filter');
		}
		$age_cat = $this->build_Inarray($age_cat);
		
		if ($county == 1 || $county == '1') {
			$sql = "CALL `proc_get_vl_age_breakdowns_outcomes`('".$age_cat."','".$year."','".$month."','".$to_year."','".$to_month."','".$county."','".$default."','".$default."','".$default."')";
			$div_name = 'countyLising';
			$modal_name = 'countyModal';
		} elseif ($partner == 1 || $partner == '1') {
			$sql = "CALL `proc_get_vl_age_breakdowns_outcomes`('".$age_cat."','".$year."','".$month."','".$to_year."','".$to_month."','".$default."','".$partner."','".$default."','".$default."')";
			$div_name = 'partnerLising';
			$modal_name = 'partnerModal';
		} elseif ($subcounty == 1 || $subcounty == '1') {
			$sql = "CALL `proc_get_vl_age_breakdowns_outcomes`('".$age_cat."','".$year."','".$month."','".$to_year."','".$to_month."','".$default."','".$default."','".$subcounty."','".$default."')";
			$div_name = 'subcountyLising';
			$modal_name = 'subcountyModal';
		} elseif ($site == 1 || $site == '1') {
			$sql = "CALL `proc_get_vl_age_breakdowns_outcomes`('".$age_cat."','".$year."','".$month."','".$to_year."','".$to_month."','".$default."','".$default."','".$default."','".$site."')";
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

	function county_outcomes($year=null,$month=null,$age_cat=null,$to_year=null,$to_month=null,$partner=null)
	{
		
		$age_cat = $this->build_Inarray($age_cat);
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
		if ($partner==null || $partner=='null') {
			$partner = null;
		}

		if ($age_cat==null || $age_cat=='null') {
			$age_cat = $this->session->userdata('age_category_filter');
		}

		if ($partner==null) {
			$sql = "CALL `proc_get_vl_county_age_outcomes`('".$age_cat."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_county_age_outcomes`('".$partner."','".$age_cat."','".$year."','".$month."','".$to_year."','".$to_month."')";
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

	function age_regimens($year=NULL,$month=NULL,$age=NULL,$to_year=NULL,$to_month=NULL)
	{
		$age = $age[0];
		// $age = $this->build_Inarray($age);
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

		if ($age==null || $age=='null') {
			$age = $this->session->userdata('age_category_filter');
		}

		$sql = "CALL `proc_get_vl_age_regimen`('".$age."','".$year."','".$month."','".$to_year."','".$to_month."')";
		
		$result = $this->db->query($sql)->result_array();
		
		$data['outcomes'][0]['name'] = 'Non-Suppressed';
		$data['outcomes'][1]['name'] = 'Suppressed';
		$data['outcomes'][2]['name'] = 'Suppression';

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "spline";

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' %');
 
		$count = 0;
		
		$data['categories'][0] = 'No Data';
		$data["outcomes"][0]["data"][0]	= $count;
		$data["outcomes"][1]["data"][0]	= $count;
		$data["outcomes"][2]["data"][0]	= $count;
 
		foreach ($result as $key => $value) {
				$total = $value['suppressed']+$value['nonsuppressed'];
				$data['categories'][$key] = $value['name'];
 
				$data["outcomes"][0]["data"][$key]	= (int) $value['nonsuppressed'];
				$data["outcomes"][1]["data"][$key]	= (int) $value['suppressed'];
				$data["outcomes"][2]["data"][$key]	= round(@($value['suppressed']/$total)*100,1);
			
		}
		$data['title'] = '';

		return $data;
	}

}