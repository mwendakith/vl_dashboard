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

	function samples_outcomes($year=NULL,$month=NULL,$to_year=null,$to_month=null)
	{
		//return "this";
		
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
			$sql = "CALL `proc_get_vl_samples_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_samples_outcomes`('".$partner."','".$year."','".$month."','".$to_year."','".$to_month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['county_outcomes'][0]['name'] = 'Not Suppresed';
		$data['county_outcomes'][1]['name'] = 'Suppresed';

		$count = 0;
		
		$data["county_outcomes"][0]["data"][0]	= $count;
		$data["county_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["county_outcomes"][0]["data"][$key]	=  (int) $value['nonsuppressed'];
			$data["county_outcomes"][1]["data"][$key]	=  (int) $value['suppressed'];
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function samples_vl_outcomes($year=NULL,$month=NULL,$sample=NULL,$to_year=null,$to_month=null)
	{
		
		if ($sample==null || $sample=='null') {
			$sample = $this->session->userdata('sample_filter');
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

		$data['vl_outcomes']['data'][0]['name'] = 'Suppresed';
		$data['vl_outcomes']['data'][1]['name'] = 'Not Suppresed';

		$count = 0;

		$data['vl_outcomes']['data'][0]['y'] = $count;
		$data['vl_outcomes']['data'][1]['y'] = $count;

		foreach ($result as $key => $value) {
			$total = (int) ($value['undetected']+$value['less1000']+$value['less5000']+$value['above5000']);
			$less = (int) ($value['undetected']+$value['less1000']);
			$greater = (int) ($value['less5000']+$value['above5000']);

			$data['ul'] .= '<tr>
	    		<td colspan="2">Tests With Valid Outcomes:</td>
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
	    		<td></td>
	    		<td></td>
	    		<td></td>
	    		<td></td>
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
						
			$data['vl_outcomes']['data'][0]['y'] = (int) $value['undetected']+(int) $value['less1000'];
			$data['vl_outcomes']['data'][1]['y'] = (int) $value['less5000']+(int) $value['above5000'];

			$data['vl_outcomes']['data'][0]['color'] = '#1BA39C';
			$data['vl_outcomes']['data'][1]['color'] = '#F2784B';
		}
		$data['vl_outcomes']['data'][0]['sliced'] = true;
		$data['vl_outcomes']['data'][0]['selected'] = true;
		
		return $data;
	}

	function samples_gender($year=NULL,$month=NULL,$sample=NULL,$to_year=null,$to_month=null)
	{
		
		if ($sample==null || $sample=='null') {
			$sample = $this->session->userdata('sample_filter');
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

		if ($partner==null || $partner=='null') {
			$sql = "CALL `proc_get_vl_samples_gender`('".$sample."','".$year."','".$month."','".$to_year."','".$to_month."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_samples_gender`('".$partner."','".$sample."','".$year."','".$month."','".$to_year."','".$to_month."')";
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
			$data["gender"][0]["data"][0]	=  (int) $value['maletest'];
			$data["gender"][0]["data"][1]	=  (int) $value['femaletest'];
		}

		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		// $data['gender'][0]['drilldown']['color'] = '#913D88';
		
		return $data;
	}

	function samples_age($year=NULL,$month=NULL,$sample=NULL,$to_year=null,$to_month=null)
	{
		
		if ($sample==null || $sample=='null') {
			$sample = $this->session->userdata('sample_filter');
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

		if ($partner==null || $partner=='null') {
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

	function samples_suppression($year=NULL,$sample=NULL)
	{
		
		if ($sample==null || $sample=='null') {
			$sample = $this->session->userdata('sample_filter');
		}
		
		if ($year==null || $year=='null') {
			$to = $this->session->userdata('filter_year');
		}else {
			$to = $year;
		}
		$from = $to-1;

		if ($partner==null || $partner=='null') {
			$sql = "CALL `proc_get_vl_sample_summary`('".$sample."','".$from."','".$to."')";
		} else {
			$sql = "CALL `proc_get_vl_partner_samples_sample_types`('".$partner."','".$sample."','".$from."')";
			$sql2 = "CALL `proc_get_vl_partner_samples_sample_types`('".$partner."','".$sample."','".$to."')";
		}
		
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
			$data['outcomes'][0]['data'][$key] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$key] = (int) $value['suppressed'];
			$data['outcomes'][2]['data'][$key] = round($value['percentage'], 1);
			
		}
		
		return $data;
	}

	function county_outcomes($year=null,$month=null,$sample=null,$to_year=null,$to_month=null)
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
		//Assigning the value of the month or setting it to the selected value
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		if ($sample==null || $sample=='null') {
			$sample = $this->session->userdata('sample_filter');
		}

		if ($partner==null || $partner=='null') {
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
			$data['outcomes'][2]['data'][$key] = round($value['percentage'], 1);
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}
}
?>