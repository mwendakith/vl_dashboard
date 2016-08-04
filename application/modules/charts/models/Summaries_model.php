<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summaries_model extends MY_Model
{
	function __construct()
	{
		parent:: __construct();
	}

	function turnaroundtime($year=null,$month=null,$county=null)
	{
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

		$sql = "CALL `proc_get_national_tat`('".$year."','".$month."')";
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

	function county_outcomes($year=null,$month=null,$pfil=NULL,$partner=NULL)
	{
		if (!$partner) {
			$partner = $this->session->userdata('partner_filter');
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

		if ($pfil) {
			if ($partner) {
				$sql = "CALL `proc_get_partner_sites_outcomes`('".$partner."','".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_partner_outcomes`('".$year."','".$month."')";
			}
		} else {
			$sql = "CALL `proc_get_county_outcomes`('".$year."','".$month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		
		$data['county_outcomes'][0]['name'] = 'Not Suppresed';
		$data['county_outcomes'][1]['name'] = 'Suppresed';

		$count = 0;
		
		$data["county_outcomes"][0]["data"][0]	= $count;
		$data["county_outcomes"][1]["data"][0]	= $count;
		$data['categories'][0]					= 'No Data';

		foreach ($result as $key => $value) {
			$data['categories'][$key] 					= $value['name'];
			$data["county_outcomes"][0]["data"][$key]	=  (int) $value['sustxfl'];
			$data["county_outcomes"][1]["data"][$key]	=  (int) $value['detectableNless1000'];
		}
		// echo "<pre>";print_r($data);
		return $data;
	}

	function vl_outcomes($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if (!$partner) {
			$partner = $this->session->userdata('partner_filter');
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
			$sql = "CALL `proc_get_partner_vl_outcomes`('".$partner."','".$year."','".$month."')";
			$sql2 = "CALL `proc_get_partner_sitessending`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_national_vl_outcomes`('".$year."','".$month."')";
				$sql2 = "CALL `proc_get_national_sitessending`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_regional_vl_outcomes`('".$county."','".$year."','".$month."')";
				$sql2 = "CALL `proc_get_regional_sitessending`('".$county."','".$year."','".$month."')";
			}
		}
		// echo "<pre>";print_r($sql);
		
		$result = $this->db->query($sql)->result_array();
		$this->db->close();
		$sitessending = $this->db->query($sql2)->result_array();
		// echo "<pre>";print_r($result);die();
		$color = array('#6BB9F0', '#F2784B', '#1BA39C', '#5C97BF');

		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;
		$data['ul'] = '';

		$data['vl_outcomes']['data'][0]['name'] = 'Undetected';
		$data['vl_outcomes']['data'][1]['name'] = 'less1000';
		$data['vl_outcomes']['data'][2]['name'] = 'less5000';
		$data['vl_outcomes']['data'][3]['name'] = 'above5000';

		$count = 0;

		$data['vl_outcomes']['data'][0]['y'] = $count;
		$data['vl_outcomes']['data'][1]['y'] = $count;
		$data['vl_outcomes']['data'][2]['y'] = $count;
		$data['vl_outcomes']['data'][3]['y'] = $count;

		foreach ($result as $key => $value) {
			$data['ul'] .= '<li>Total Tests: '.$value['alltests'].'</li>';
			$data['ul'] .= '<li>Suspected Tx Failures: '.$value['sustxfail'].' <strong>('.(int) (($value['sustxfail']/$value['alltests'])*100).'%)</strong></li>';
			$data['ul'] .= '<li>Total Repeat VL: '.$value['confirm2vl'].'</li>';
			$data['ul'] .= '<li>Confirmed Tx Failure: '.$value['confirmtx'].'</li>';
			$data['ul'] .= '<li>Rejected: '.$value['rejected'].'</li>';
						
			$data['vl_outcomes']['data'][0]['y'] = (int) $value['undetected'];
			$data['vl_outcomes']['data'][1]['y'] = (int) $value['less1000'];
			$data['vl_outcomes']['data'][2]['y'] = (int) $value['less5000'];
			$data['vl_outcomes']['data'][3]['y'] = (int) $value['above5000'];

			$data['vl_outcomes']['data'][0]['color'] = '#1BA39C';
			$data['vl_outcomes']['data'][1]['color'] = '#5C97BF';
			$data['vl_outcomes']['data'][2]['color'] = '#6BB9F0';
			$data['vl_outcomes']['data'][3]['color'] = '#F2784B';
		}

		$count = 1;
		$sites = 0;
		foreach ($sitessending as $key => $value) {
			if ((int) $value['sitessending'] != 0) {
				$sites = (int) $sites + (int) $value['sitessending'];
				$count++;
			}
		}
		$data['ul'] .= '<li>Sites Sending: '.round(@$sites / $count).'</li>';
		$count = 1;
		$sites = 0;

		$data['vl_outcomes']['data'][3]['sliced'] = true;
		$data['vl_outcomes']['data'][3]['selected'] = true;
		
		return $data;
	}

	function justification($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if (!$partner) {
			$partner = $this->session->userdata('partner_filter');
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
			$sql = "CALL `proc_get_partner_justification`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_national_justification`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_regional_justification`('".$county."','".$year."','".$month."')";
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

		return $data;
	}

	function age($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if (!$partner) {
			$partner = $this->session->userdata('partner_filter');
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
			$sql = "CALL `proc_get_partner_age`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_national_age`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_regional_age`('".$county."','".$year."','".$month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		// $data['age']['name'] = 'Tests';
		// $data['age']['colorByPoint'] = true;

		$count = 0;
		$adults = 0;
		$children = 0;
		$asustx = 0;
		$csustx = 0;
		$data['ul'] = '';

		foreach ($result as $key => $value) {
			if ($value['name'] == '15-19' || $value['name'] == '20-24' || $value['name'] == '25+') {
				$adults = (int) $adults + (int) $value['agegroups'];
				$asustx = (int) $asustx + (int) $value['sustxfail'];
			} else {
				$children = (int) $children + (int) $value['agegroups'];
				$csustx = (int) $csustx + (int) $value['sustxfail'];
			}
		}

		$data['ul'] .= '<li><strong>Adults Suppresed: '.(int) ((($adults-$asustx)/$adults)*100).'%</strong></li>';
		$data['ul'] .= '<li><strong>Children Suppresed: '.(int) ((($children-$csustx)/$children)*100).'%</strong></li>';

		$data['ageGnd'][0]['y'] = $adults;
		$data['ageGnd'][0]['color'] = '#86E2D5';
		$data['ageGnd'][0]['drilldown']['name'] = 'Adults';
		$data['ageGnd'][1]['y'] = $children;
		$data['ageGnd'][1]['color'] = '#E26A6A';
		$data['ageGnd'][1]['drilldown']['name'] = 'Children';
		
		foreach ($result as $key => $value) {
			if ($value['name'] == '15-19' || $value['name'] == '20-24' || $value['name'] == '25+') {
				$data['ageGnd'][0]['drilldown']['categories'][$key] = $value['name'];
				$data['ageGnd'][0]['drilldown']['data'][$key] = (int) $value['agegroups'];
			} else {
				$data['ageGnd'][1]['drilldown']['categories'][$key] = $value['name'];
				$data['ageGnd'][1]['drilldown']['data'][$key] = (int) $value['agegroups'];
			}

			// $data['age']['data'][$key]['y'] = $count;

			// if ($value['name']=='0')
			// 	$data['age']['data'][$key]['name'] = 'No Data';
			// else
			// 	$data['age']['data'][$key]['name'] = $value['name'];

			// $data['age']['data'][$key]['y'] = (int) $value['agegroups'];
		}
		$data['ageGnd'][0]['drilldown']['color'] = '#913D88';
		$data['ageGnd'][1]['drilldown']['color'] = '#96281B';

		$data['ageGnd'][0]['drilldown']['categories'] = array_values($data['ageGnd'][0]['drilldown']['categories']);
		$data['ageGnd'][1]['drilldown']['categories'] = array_values($data['ageGnd'][1]['drilldown']['categories']);
		$data['ageGnd'][0]['drilldown']['data'] = array_values($data['ageGnd'][0]['drilldown']['data']);
		$data['ageGnd'][1]['drilldown']['data'] = array_values($data['ageGnd'][1]['drilldown']['data']);
		// echo "<pre>";print_r($data);die();
		// $data['age']['data'][0]['sliced'] = true;
		// $data['age']['data'][0]['selected'] = true;
		// echo "<pre>";print_r($data);
		return $data;
	}

	function age_breakdown($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}
		if (!$partner) {
			$partner = $this->session->userdata('partner_filter');
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
			$sql = "CALL `proc_get_partner_age`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_national_age`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_regional_age`('".$county."','".$year."','".$month."')";
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
		$children = 0;
		$count = 0;

		foreach ($result as $key => $value) {
			
			if ($value['name']=='<2' || $value['name']=='2-9' || $value['name']=='10-14') {
				$data['ctotal'] = (int) $children + (int) $value['agegroups'];
				$data['children']['data'][$key]['y'] = $count;
				$data['children']['data'][$key]['name'] = $value['name'];
				$data['children']['data'][$key]['y'] = (int) $value['agegroups'];

			} else {
				$data['atotal'] = (int) $adults + (int) $value['agegroups'];
				$data['adults']['data'][$key]['y'] = $count;
				$data['adults']['data'][$key]['name'] = $value['name'];
				$data['adults']['data'][$key]['y'] = (int) $value['agegroups'];
			}
			
			
		}

		$data['children']['data'][0]['sliced'] = true;
		$data['children']['data'][0]['selected'] = true;

		$data['adults']['data'][1]['sliced'] = true;
		$data['adults']['data'][1]['selected'] = true;
		
		$data['children']['data'] = array_values($data['children']['data']);
		$data['adults']['data'] = array_values($data['adults']['data']);
		
		return $data;
	}

	function gender($year=null,$month=null,$county=null,$partner=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
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
			$sql = "CALL `proc_get_partner_gender`('".$partner."','".$year."','".$month."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_national_gender`('".$year."','".$month."')";
			} else {
				$sql = "CALL `proc_get_regional_gender`('".$county."','".$year."','".$month."')";
			}
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data['ul'] = '';
				
		$data['gender']['name'] = 'Tests';
		$data['gender']['colorByPoint'] = true;

		$count = 0;
		// echo "<pre>";print_r($result);die();
		foreach ($result as $key => $value) {

			$data['gender']['data'][$key]['y'] = $count;

			if ($value['name']=='F'){
				$data['gender']['data'][$key]['name'] = 'Female';
				$data['ul'] .= '<li><strong>Female Suppresed: '.(int) ((((int) $value['gender']-(int) $value['sustxfail'])/(int) $value['gender'])*100).'%</strong></li>';
			}
			else {
				$data['gender']['data'][$key]['name'] = 'Male';
				$data['ul'] .= '<li><strong>Male Suppresed: '.(int) ((((int) $value['gender']-(int) $value['sustxfail'])/(int) $value['gender'])*100).'%</strong></li>';
			}

			$data['gender']['data'][$key]['y'] = (int) $value['gender'];
		}

		$data['gender']['data'][0]['sliced'] = true;
		$data['gender']['data'][0]['selected'] = true;
		
		return $data;
	}

	function sample_types($year=null,$county=null,$partner=null)
	{
		$array1 = array();
		$array2 = array();
		$sql2 = NULL;

		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}

		if ($year==null || $year=='null') {
			$to = $this->session->userdata('filter_year');
		}else {
			$to = $year;
		}
		$from = $to-1;

		if ($partner) {
			$sql = "CALL `proc_get_partner_sample_types`('".$partner."','".$from."')";
			$sql2 = "CALL `proc_get_partner_sample_types`('".$partner."','".$to."')";
		} else {
			if ($county==null || $county=='null') {
				$sql = "CALL `proc_get_national_sample_types`('".$from."','".$to."')";
			} else {
				$sql = "CALL `proc_get_regional_sample_types`('".$county."','".$from."')";
				$sql2 = "CALL `proc_get_regional_sample_types`('".$county."','".$to."')";
			}
		}
		// echo "<pre>";print_r($sql);
		$array1 = $this->db->query($sql)->result_array();
		
		if ($sql2) {
			$this->db->close();
			$array2 = $this->db->query($sql2)->result_array();
		}

		$result = array_merge($array1,$array2);
		// echo "<pre>";print_r($result);die();
		$data['sample_types'][0]['name'] = 'EDTA';
		$data['sample_types'][1]['name'] = 'DBS';
		$data['sample_types'][2]['name'] = 'Plasma';

		$count = 0;
		
		$data['categories'][0] = 'No Data';
		$data["sample_types"][0]["data"][0]	= $count;
		$data["sample_types"][1]["data"][0]	= $count;
		$data["sample_types"][2]["data"][0]	= $count;

		foreach ($result as $key => $value) {
			
				$data['categories'][$key] = $this->resolve_month($value['month']).'-'.$value['year'];

				$data["sample_types"][0]["data"][$key]	= (int) $value['edta'];
				$data["sample_types"][1]["data"][$key]	= (int) $value['dbs'];
				$data["sample_types"][2]["data"][$key]	= (int) $value['plasma'];
			
		}
		
		return $data;
	}

	

}
?>