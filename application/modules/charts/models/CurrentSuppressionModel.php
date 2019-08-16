<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
 * 
 */
class CurrentSuppressionModel extends MY_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function current_age($type = NULL, $id = NULL)
	{
		$result = $this->getCurrentAgeData($type, $id);

		$data['justification']['name'] = 'Tests';
		$data['justification']['colorByPoint'] = true;
 		
 		// Less 2
 		$data['justification']['data'][0]['name'] = '&lt; 2';
		$data['justification']['data'][0]['y'] = (int) ($result['less2_suppressed'] + $result['less2_nonsuppressed']);

 		// 2-9
 		$data['justification']['data'][1]['name'] = '2-9';
		$data['justification']['data'][1]['y'] = (int) ($result['less9_suppressed'] + $result['less9_nonsuppressed']);

 		// 10-14
 		$data['justification']['data'][2]['name'] = '10-14';
		$data['justification']['data'][2]['y'] = (int) ($result['less14_suppressed'] + $result['less14_nonsuppressed']);

 		// 15-19
 		$data['justification']['data'][3]['name'] = '15-19';
		$data['justification']['data'][3]['y'] = (int) ($result['less19_suppressed'] + $result['less19_nonsuppressed']);

 		// 20-24
 		$data['justification']['data'][4]['name'] = '20-24';
		$data['justification']['data'][4]['y'] = (int) ($result['less24_suppressed'] + $result['less24_nonsuppressed']);

 		//Above 25
 		$data['justification']['data'][5]['name'] = '&gt; 25';
		$data['justification']['data'][5]['y'] = (int) ($result['over25_suppressed'] + $result['over25_nonsuppressed']);
		$data['justification']['data'][5]['color'] = '#1BA39C';
		$data['justification']['data'][5]['sliced'] = true;
		$data['justification']['data'][5]['selected'] = true;

 		// No Data
 		$data['justification']['data'][6]['name'] = 'No Data';
		$data['justification']['data'][6]['y'] = (int) ($result['noage_suppressed'] + $result['noage_nonsuppressed']);
		return $data;
	}

	public function current_age_breakdown($type=null,$id=null) {
		return $this->getCurrentAgeData($type,$id);
	}

	public function current_suppression_age($type=null,$id=null,$first=true)
	{
		$result = $this->getCurrentAgeData($type, $id);

		$data['justification']['name'] = 'Tests';
		$data['justification']['colorByPoint'] = true;
 		 if (!$first || $first == 'false') {
 		 	$data['justification']['data'][0]['name'] = 'LDL';
			$data['justification']['data'][0]['y'] = (int) ($result['less2_suppressed'] + $result['less9_suppressed'] + $result['less14_suppressed'] + $result['less19_suppressed'] + $result['less24_suppressed']);
			$data['justification']['data'][0]['color'] = '#1BA39C';
			$data['justification']['data'][0]['sliced'] = true;
			$data['justification']['data'][0]['selected'] = true;

	 		// 2-9
	 		$data['justification']['data'][1]['name'] = 'LLV';
			$data['justification']['data'][1]['y'] = 0;

	 		// 10-14
	 		$data['justification']['data'][2]['name'] = 'HVL';
			$data['justification']['data'][2]['y'] = (int) ($result['less2_nonsuppressed'] + $result['less9_nonsuppressed'] + $result['less14_nonsuppressed'] + $result['less19_nonsuppressed'] + $result['less24_nonsuppressed']);
 		 } else {
 		 	$data['justification']['data'][0]['name'] = 'LDL';
			$data['justification']['data'][0]['y'] = (int) ($result['over25_suppressed']);
			$data['justification']['data'][0]['color'] = '#1BA39C';
			$data['justification']['data'][0]['sliced'] = true;
			$data['justification']['data'][0]['selected'] = true;

	 		// 2-9
	 		$data['justification']['data'][1]['name'] = 'LLV';
			$data['justification']['data'][1]['y'] = 0;

	 		// 10-14
	 		$data['justification']['data'][2]['name'] = 'HVL';
			$data['justification']['data'][2]['y'] = (int) ($result['over25_nonsuppressed']);
 		 }
		return $data;
	}

	private function getCurrentAgeData($type=0,$id=0)
	{
		if ($type==null || $type=='null'){
			$type = $id = 0;
		}
		
		$sql = "CALL `proc_get_vl_current_age_suppression`('".$type."','".$id."')";
		return $this->db->query($sql)->result_array()[0];
	}
}
?>

