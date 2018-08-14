<?php
defined("BASEPATH") or exit("No direct script access allowed");

/**
* 
*/
class Partner_trends_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();;
	}

	function yearly_trends($partner=NULL){

		
		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}

		if (is_null($partner)) {
			$sql = "CALL `proc_get_vl_national_yearly_trends`();";
		} else {
			$sql = "CALL `proc_get_vl_partner_yearly_trends`(" . $partner . ");";
		}
		
		$result = $this->db->query($sql)->result_array();
		
		$year;
		$i = 0;
		$b = true;

		$data;

		foreach ($result as $key => $value) {

			if($b){
				$b = false;
				$year = (int) $value['year'];
			}

			$y = (int) $value['year'];
			if($value['year'] != $year){
				$i++;
				$year--;
			}

			$month = (int) $value['month'];
			$month--;

			$tests = (int) $value['suppressed'] + (int) $value['nonsuppressed'];

			$data['suppression_trends'][$i]['name'] = $value['year'];
			$data['suppression_trends'][$i]['data'][$month] = round(@(($value['suppressed']*100)/$tests), 1, PHP_ROUND_HALF_UP);


			$data['test_trends'][$i]['name'] = $value['year'];
			$data['test_trends'][$i]['data'][$month] = $tests;

			$data['rejected_trends'][$i]['name'] = $value['year'];
			$data['rejected_trends'][$i]['data'][$month] = round(@(($value['rejected']*100)/$value['received']), 1, PHP_ROUND_HALF_UP);

			$data['tat_trends'][$i]['name'] = $value['year'];
			$data['tat_trends'][$i]['data'][$month] = (int) $value['tat4'];

		}
		

		return $data;
	}

	function yearly_summary($partner=NULL){

		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}
		
		if(is_null($partner)){
			$sql = "CALL `proc_get_vl_national_yearly_summary`();";
		} else {
			$sql = "CALL `proc_get_vl_partner_yearly_summary`(" . $partner . ");";
		}
		// echo "<pre>";print_r($sql);die();
		
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$year = date("Y");
		$i = 0;

		$data['outcomes'][0]['name'] = "Nonsuppressed";
		$data['outcomes'][1]['name'] = "Suppressed";
		$data['outcomes'][2]['name'] = "Suppression";

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "spline";

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;

		foreach ($result as $key => $value) {
			$data['categories'][$i] = $value['year'];
			
			$data['outcomes'][0]['data'][$i] = (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$i] = (int) $value['suppressed'];
			$data['outcomes'][2]['data'][$i] = round(@(((int) $value['suppressed']*100)/((int) $value['suppressed']+(int) $value['nonsuppressed'])),1);
			$i++;
		}
		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' %');

		$data['title'] = "Outcomes";

		return $data;
	}

	function yearly_age_summary($partner=NULL){

		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}
		
		if(is_null($partner)){
			$sql = "CALL `proc_get_vl_national_yearly_tests_age`();";
		} else {
			$sql = "CALL `proc_get_vl_yearly_summary`(" . $partner . ");";
		}
		// echo "<pre>";print_r($sql);die();
		
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		// $year = date("Y");
		$year;
		$i = 0;
		$b = true;

		$data['outcomes'][0]['name'] = "No Data";
		$data['outcomes'][1]['name'] = "25+";
		$data['outcomes'][2]['name'] = "20-24";
		$data['outcomes'][3]['name'] = "15-19";
		$data['outcomes'][4]['name'] = "10-14";
		$data['outcomes'][5]['name'] = "2-9";
		$data['outcomes'][6]['name'] = "less 2";
		$data['outcomes'][7]['name'] = "Less 19 Contribution";

		$data['outcomes'][0]['type'] = "column";
		$data['outcomes'][1]['type'] = "column";
		$data['outcomes'][2]['type'] = "column";
		$data['outcomes'][3]['type'] = "column";
		$data['outcomes'][4]['type'] = "column";
		$data['outcomes'][5]['type'] = "column";
		$data['outcomes'][6]['type'] = "column";
		$data['outcomes'][7]['type'] = "spline";

		$data['outcomes'][0]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][1]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][2]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][3]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][4]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][5]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][6]['tooltip'] = array("valueSuffix" => ' ');
		$data['outcomes'][7]['tooltip'] = array("valueSuffix" => ' %');

		$data['outcomes'][0]['yAxis'] = 1;
		$data['outcomes'][1]['yAxis'] = 1;
		$data['outcomes'][2]['yAxis'] = 1;
		$data['outcomes'][3]['yAxis'] = 1;
		$data['outcomes'][4]['yAxis'] = 1;
		$data['outcomes'][5]['yAxis'] = 1;
		$data['outcomes'][6]['yAxis'] = 1;

		$data['title'] = "Tests Grouped By Age";

		foreach ($result as $key => $value) {

			if($b){
				$b = false;
				$year = (int) $value['year'];				
			}

			if($year != $value['year']){
				$total = $data['outcomes'][0]['data'][$i] + $data['outcomes'][1]['data'][$i] + $data['outcomes'][2]['data'][$i] + $data['outcomes'][3]['data'][$i] + $data['outcomes'][4]['data'][$i] + $data['outcomes'][5]['data'][$i] + $data['outcomes'][6]['data'][$i];

				$numerator = $data['outcomes'][3]['data'][$i] + $data['outcomes'][4]['data'][$i] + $data['outcomes'][5]['data'][$i] + $data['outcomes'][6]['data'][$i];

				$data['outcomes'][7]['data'][$i] = round(@( $numerator*100 / $total ),1);

				$year++;
				$i++;
			}

			$data['categories'][$i] = $value['year'];
			$age = (int) $value['age'];

			switch ($age) {
				case 0:
					$data['outcomes'][0]['data'][$i] = (int) $value['tests'];
					break;
				case 6:
					$data['outcomes'][6]['data'][$i] = (int) $value['tests'];
					break;
				case 7:
					$data['outcomes'][5]['data'][$i] = (int) $value['tests'];
					break;
				case 8:
					$data['outcomes'][4]['data'][$i] = (int) $value['tests'];
					break;
				case 9:
					$data['outcomes'][3]['data'][$i] = (int) $value['tests'];
					break;
				case 10:
					$data['outcomes'][2]['data'][$i] = (int) $value['tests'];
					break;
				case 11:
					$data['outcomes'][1]['data'][$i] = (int) $value['tests'];
					break;
				default:
					break;
			}

		}
		$total = $data['outcomes'][0]['data'][$i] + $data['outcomes'][1]['data'][$i] + $data['outcomes'][2]['data'][$i] + $data['outcomes'][3]['data'][$i] + $data['outcomes'][4]['data'][$i] + $data['outcomes'][5]['data'][$i] + $data['outcomes'][6]['data'][$i];

		$numerator = $data['outcomes'][3]['data'][$i] + $data['outcomes'][4]['data'][$i] + $data['outcomes'][5]['data'][$i] + $data['outcomes'][6]['data'][$i];

		$data['outcomes'][7]['data'][$i] = round(@( $numerator*100 / $total ),1);

		return $data;
	}

	function quarterly_trends($partner=NULL){

		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}

		if (is_null($partner)) {
			$sql = "CALL `proc_get_vl_national_yearly_trends`();";
		} else {
			$sql = "CALL `proc_get_vl_partner_yearly_trends`(" . $partner . ");";
		}
		
		$result = $this->db->query($sql)->result_array();
		
		$year;
		$i = 0;
		$b = true;
		$limit = 0;
		$quarter = 1;

		$data;

		foreach ($result as $key => $value) {

			if($b){
				$b = false;
				$year = (int) $value['year'];
			}

			$y = (int) $value['year'];
			$name = $y . ' Q' . $quarter;
			if($value['year'] != $year){
				$year--;
				if($month != 2){
					$i++;
				}
			}

			$month = (int) $value['month'];
			$modulo = ($month % 3);

			$month= $modulo-1;

			if($modulo == 0){
				$month = 2;
			}			

			$tests = (int) $value['suppressed'] + (int) $value['nonsuppressed'];

			$data['suppression_trends'][$i]['name'] = $name;
			$data['suppression_trends'][$i]['data'][$month] = round(@(($value['suppressed']*100)/$tests), 4, PHP_ROUND_HALF_UP);


			$data['test_trends'][$i]['name'] = $name;
			$data['test_trends'][$i]['data'][$month] = $tests;

			$data['rejected_trends'][$i]['name'] = $name;
			$data['rejected_trends'][$i]['data'][$month] = round(@(($value['rejected']*100)/$value['received']), 4, PHP_ROUND_HALF_UP);

			$data['tat_trends'][$i]['name'] = $name;
			$data['tat_trends'][$i]['data'][$month] = (int) $value['tat4'];

			if($modulo == 0){
				$i++;
				$quarter++;
				$limit++;
			}
			if($quarter == 5){
				$quarter = 1;
			}
			if ($limit == 8) {
				break;
			}
		}

		return $data;
	}


	function quarterly_outcomes($partner=NULL)
	{

		if ($partner==null || $partner=='null') {
			$partner = $this->session->userdata('partner_filter');
		}

		if (is_null($partner)) {
			$sql = "CALL `proc_get_vl_national_yearly_trends`();";
		} else {
			$sql = "CALL `proc_get_vl_partner_yearly_trends`(" . $partner . ");";
		}
		
		$result = $this->db->query($sql)->result_array();
		
		$year;
		$years = 1;
		$prev_year = date('Y') - 1;
		$cur_month = date('m');

		$extra = ceil($cur_month / 3);
		$columns = 8 + $extra;

		$b = true;
		$quarter = 1;

		$i = 8;

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

		$data['categories'] = array_fill(0, $columns, "Null");
		$data['outcomes'][0]['data'] = array_fill(0, $columns, 0);
		$data['outcomes'][1]['data'] = array_fill(0, $columns, 0);
		$data['outcomes'][2]['data'] = array_fill(0, $columns, 0);


		foreach ($result as $key => $value) {

			if($b){
				$b = false;
				$year = (int) $value['year'];
			}

			$y = (int) $value['year'];
			$name = $y . ' Q' . $quarter;
			if($value['year'] != $year){
				$year--;
				$years++;

				if($years > 3) break;

				if($year == $prev_year){
					$i = 4;
					$quarter=1;
				}
			}

			$month = (int) $value['month'];
			$modulo = ($month % 3);

			$data['categories'][$i] = $name;

			$data['outcomes'][0]['data'][$i] += (int) $value['nonsuppressed'];
			$data['outcomes'][1]['data'][$i] += (int) $value['suppressed'];	
			$data['outcomes'][2]['data'][$i] = round(@(( $data['outcomes'][1]['data'][$i]*100)/
				($data['outcomes'][0]['data'][$i]+$data['outcomes'][1]['data'][$i])),1);		

			if($modulo == 0){
				$i++;
				$quarter++;
			}
			if($quarter == 5){
				$quarter = 1;
				$i = 0;
			}	
		}

		return $data;

	}




}