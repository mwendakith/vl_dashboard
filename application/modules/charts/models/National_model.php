<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class National_model extends MY_Model
{
	function __construct()
	{
		parent:: __construct();
	}

	function county_outcomes($year=null,$month=null)
	{
		$sql = "SELECT
					`c`.`name`,
					SUM((`vcs`.`Undetected`+`vcs`.`less1000`)) AS `detectableNless1000`,
					SUM((`vcs`.`less5000`+`vcs`.`above5000`)) AS `sustxfl`
				FROM `vl_county_summary` `vcs`
					JOIN `countys` `c` ON `vcs`.`county` = `c`.`ID`
				GROUP BY `vcs`.`county`";
		$result = $this->db->query($sql)->result_array();

		$data['county_outcomes'][0]['name'] = 'Suspected treatment failure & greater 1000';
		$data['county_outcomes'][1]['name'] = 'Detectable & less 1000';

		$count = 0;
		
		foreach ($result as $key => $value) {
			$data["county_outcomes"][0]["data"][$key]	= $count;
			$data["county_outcomes"][1]["data"][$key]	= $count;
			$data['categories'][$key]					= $count;

			$data['categories'][$key] 					= $value['name'];
			$data["county_outcomes"][0]["data"][$key]	=  (int) $value['sustxfl'];
			$data["county_outcomes"][1]["data"][$key]	=  (int) $value['detectableNless1000'];
		}
		// $data = $result;
		return $data;
	}

	function vl_outcomes($year=null,$month=null)
	{
		$sql = "SELECT
					SUM(`Undetected`) AS `undetected`,
					SUM(`less1000`) AS `less1000`,
					SUM(`less5000`) AS `less5000`,
					SUM(`above5000`) AS `above5000`
				FROM `vl_national_summary`";
		$result = $this->db->query($sql)->result_array();

		$data['vl_outcomes']['name'] = 'Tests';
		$data['vl_outcomes']['colorByPoint'] = true;

		$data['vl_outcomes']['data'][0]['name'] = 'Undetected';
		$data['vl_outcomes']['data'][1]['name'] = 'less1000';
		$data['vl_outcomes']['data'][2]['name'] = 'less5000';
		$data['vl_outcomes']['data'][3]['name'] = 'above5000';

		$count = 0;

		foreach ($result as $key => $value) {
			$data['vl_outcomes']['data'][0]['y'] = $count;
			$data['vl_outcomes']['data'][1]['y'] = $count;
			$data['vl_outcomes']['data'][2]['y'] = $count;
			$data['vl_outcomes']['data'][3]['y'] = $count;

			$data['vl_outcomes']['data'][0]['y'] = $value['undetected'];
			$data['vl_outcomes']['data'][1]['y'] = $value['less1000'];
			$data['vl_outcomes']['data'][2]['y'] = $value['less5000'];
			$data['vl_outcomes']['data'][3]['y'] = $value['above5000'];
		}

		$data['vl_outcomes']['data'][3]['sliced'] = true;
		$data['vl_outcomes']['data'][3]['selected'] = true;

		return $data;
	}

	function justification($year=null,$month=null)
	{
		$sql = "SELECT
					`vj`.`name`,
					SUM((`vnj`.`tests`)) AS `justifications`
				FROM `vl_national_justification` `vnj`
				JOIN `viraljustifications` `vj` 
					ON `vnj`.`justification` = `vj`.`ID`
				GROUP BY `vj`.`name`";
		$result = $this->db->query($sql)->result_array();

		$data['justification']['name'] = 'Tests';
		$data['justification']['colorByPoint'] = true;

		$count = 0;

		foreach ($result as $key => $value) {

			$data['justification']['data'][$key]['y'] = $count;
			
			$data['justification']['data'][$key]['name'] = $value['name'];
			$data['justification']['data'][$key]['y'] = $value['justifications'];
		}

		$data['justification']['data'][0]['sliced'] = true;
		$data['justification']['data'][0]['selected'] = true;

		return $data;
	}

	function age($year=null,$month=null)
	{
		$sql = "SELECT
					`ac`.`name`,
					SUM((`vna`.`tests`)) AS `agegroups`
				FROM `vl_national_age` `vna`
				JOIN `agecategory` `ac`
					ON `vna`.`age` = `ac`.`ID`
				GROUP BY `ac`.`name`";
		$result = $this->db->query($sql)->result_array();

		$data['age']['name'] = 'Tests';
		$data['age']['colorByPoint'] = true;

		$count = 0;

		foreach ($result as $key => $value) {

			$data['age']['data'][$key]['y'] = $count;

			if ($value['name']=='0')
				$data['age']['data'][$key]['name'] = 'No Data';
			else
				$data['age']['data'][$key]['name'] = $value['name'];

			$data['age']['data'][$key]['y'] = $value['agegroups'];
		}

		$data['age']['data'][0]['sliced'] = true;
		$data['age']['data'][0]['selected'] = true;

		return $data;
	}

	function gender($year=null,$month=null)
	{
		$sql = "SELECT
					`g`.`name`,
					SUM(`vng`.`tests`) AS `gender`
				FROM `vl_national_gender` `vng`
				JOIN `gender` `g`
					ON `vng`.`gender` = `g`.`ID`
				GROUP BY `g`.`name`";
		$result = $this->db->query($sql)->result_array();

		$data['gender']['name'] = 'Tests';
		$data['gender']['colorByPoint'] = true;

		$count = 0;

		foreach ($result as $key => $value) {

			$data['gender']['data'][$key]['y'] = $count;

			if ($value['name']=='F')
				$data['gender']['data'][$key]['name'] = 'Female';
			else
				$data['gender']['data'][$key]['name'] = 'Male';

			$data['gender']['data'][$key]['y'] = $value['gender'];
		}

		$data['gender']['data'][0]['sliced'] = true;
		$data['gender']['data'][0]['selected'] = true;

		return $data;
	}

	function sample_types($year=null,$month=null)
	{
		$sql = "SELECT
					`month`,
					`year`,
					`edta`,
					`dbs`,
					`plasma`
				FROM `vl_national_summary`
				WHERE `year` = '2016' OR `year` = '2015'";
		$result = $this->db->query($sql)->result_array();
	}

}
?>