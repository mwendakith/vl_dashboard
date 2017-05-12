<?php
defined("BASEPATH") or exit("No direct script access allowed!");

/**
* 
*/
class Live_model extends MY_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	function get_dropdown(){
		$query = $this->db->get('labs');
		$this->db->close();
		$data = "<option disabled> Select a lab </option>";

		foreach ($query->result_array() as $key => $value) {
			// $data['lab'][$value['ID']] = $value['name'];
			$data .= "<option value=" . $value['ID'] . ">" . $value['name'] . "</option>";

		}
		return $data;
	}

	function get_data($type=2, $lab=1){
		$sql = "CALL `proc_get_vl_lab_live_data`('".$type."')";
		$sql2 = "CALL `proc_get_vl_live_data_totals`('".$type."')";

		$result = $this->db->query($sql)->result_array();

		// return json_encode($result);
		$this->db->close();
		$totals = $this->db->query($sql2)->row();
		$this->db->close();

		$sql3 = "CALL `proc_get_vl_live_lab_samples`('".$type."', '".$lab."')";
		$row = $this->db->query($sql3)->row();
		$this->db->close();

		$sql4 = "CALL `proc_get_vl_live_lab_samples`('".$type."', '')";
		$row2 = $this->db->query($sql4)->row();

		$data = null;


		$data['updated'] = date('D d-m-Y g:i a');

		$data['year_to_date'] = number_format($totals->yeartodate) . '/' . number_format($totals->monthtodate);

		foreach ($totals as $key => $value) {
			$data[$key] = (int) $value;
		}

		$data['machines'][0] = "Abbot";
		$data['machines'][1] = "Panther";
		$data['machines'][2] = "Roche";

		$data['minprocess'][0] = (int) $totals->abbottinprocess;
		$data['minprocess'][1] = (int) $totals->panthainprocess;
		$data['minprocess'][2] = (int) $totals->rocheinprocess;

		$data['mprocessed'][0] = (int) $totals->abbottprocessed;
		$data['mprocessed'][1] = (int) $totals->panthaprocessed;
		$data['mprocessed'][2] = (int) $totals->rocheprocessed;

		$i=0;


		foreach ($result as $key => $value) {
			$data['labs'][$i] = $value['name'];
			$data['enteredsamplesatsitea'][$i] = (int) $value['enteredsamplesatsite'];
			$data['enteredsamplesatlaba'][$i] = (int) $value['enteredsamplesatlab'];
			$data['receivedsamplesa'][$i] = (int) $value['receivedsamples'];
			$data['inqueuesamplesa'][$i] = (int) $value['inqueuesamples'];
			$data['inprocesssamplesa'][$i] = (int) $value['inprocesssamples'];
			$data['processedsamplesa'][$i] = (int) $value['processedsamples'];
			$data['pendingapprovala'][$i] = (int) $value['pendingapproval'];
			$data['dispatchedresultsa'][$i] = (int) $value['dispatchedresults'];
			$data['oldestinqueuesamplea'][$i] = (int) $value['oldestinqueuesample'];

			$phpdate = strtotime( $value['dateupdated'] );
			$data['updated_time'] = date('D d-m-Y g:i a', $phpdate);
			//$data['updated_time'] = $value['dateupdated'];
			$phpdate = strtotime( $value['dateupdated'] );
			$data['updated_time'] = date('D d-m-Y g:i a', $phpdate);

			$i++;

		}

		$data['age_cat'] = array('1 week', '2 weeks', '3 weeks', '&gt; 4 weeks');

		$data['age'][0] = (int) $row->oneweek;
		$data['age'][1] = (int) $row->twoweeks;
		$data['age'][2] = (int) $row->threeweeks;
		$data['age'][3] = (int) $row->aboveamonth;

		$data['age_nat'][0] = (int) $row2->oneweek;
		$data['age_nat'][1] = (int) $row2->twoweeks;
		$data['age_nat'][2] = (int) $row2->threeweeks;
		$data['age_nat'][3] = (int) $row2->aboveamonth;

		return json_encode($data);

	}


	// function get_vl_data(){
	// 	$sql = "CALL `proc_get_vl_lab_live_data`()";
	// 	$sql2 = "CALL `proc_get_vl_live_data_totals`()";

	// 	$result = $this->db->query($sql)->result_array();

	// 	// return json_encode($result);
	// 	$this->db->close();
	// 	$totals = $this->db->query($sql2)->row();

	// 	$data = null;

	// 	$data['updated'] = date('D d-m-Y g:i a');

	// 	foreach ($totals as $key => $value) {
	// 		$data[$key] = (int) $value;
	// 	}

	// 	$data['machines'][0] = "Abbot";
	// 	$data['machines'][1] = "Panther";
	// 	$data['machines'][2] = "Roche";

	// 	$data['minprocess'][0] = (int) $totals->abbottinprocess;
	// 	$data['minprocess'][1] = (int) $totals->panthainprocess;
	// 	$data['minprocess'][2] = (int) $totals->rocheinprocess;

	// 	$data['mprocessed'][0] = (int) $totals->abbottprocessed;
	// 	$data['mprocessed'][1] = (int) $totals->panthaprocessed;
	// 	$data['mprocessed'][2] = (int) $totals->rocheprocessed;



	// 	$i=0;


	// 	foreach ($result as $key => $value) {
	// 		$data['labs'][$i] = $value['name'];
	// 		$data['enteredsamplesatsitea'][$i] = (int) $value['enteredsamplesatsite'];
	// 		$data['enteredsamplesatlaba'][$i] = (int) $value['enteredsamplesatlab'];
	// 		$data['receivedsamplesa'][$i] = (int) $value['receivedsamples'];
	// 		$data['inqueuesamplesa'][$i] = (int) $value['inqueuesamples'];
	// 		$data['inprocesssamplesa'][$i] = (int) $value['inprocesssamples'];
	// 		$data['processedsamplesa'][$i] = (int) $value['processedsamples'];
	// 		$data['pendingapprovala'][$i] = (int) $value['pendingapproval'];
	// 		$data['dispatchedresultsa'][$i] = (int) $value['dispatchedresults'];
	// 		$data['oldestinqueuesamplea'][$i] = (int) $value['oldestinqueuesample'];
	// 		//$data['updated_time'] = $value['dateupdated'];
	// 		$phpdate = strtotime( $value['dateupdated'] );
	// 		$data['updated_time'] = date('D d-m-Y g:i a', $phpdate);

		// foreach ($result as $key => $value) {
		// 	$data['labs'][$i] = $value['name'];
		// 	$data['enteredsamplesatsitea'][$i] = (int) $value['enteredsamplesatsite'];
		// 	$data['enteredsamplesatlaba'][$i] = (int) $value['enteredsamplesatlab'];
		// 	$data['receivedsamplesa'][$i] = (int) $value['receivedsamples'];
		// 	$data['inqueuesamplesa'][$i] = (int) $value['inqueuesamples'];
		// 	$data['inprocesssamplesa'][$i] = (int) $value['inprocesssamples'];
		// 	$data['processedsamplesa'][$i] = (int) $value['processedsamples'];
		// 	$data['pendingapprovala'][$i] = (int) $value['pendingapproval'];
		// 	$data['dispatchedresultsa'][$i] = (int) $value['dispatchedresults'];
		// 	$data['oldestinqueuesamplea'][$i] = (int) $value['oldestinqueuesample'];
		// 	// $data['updated_time'] = $value['dateupdated'];
		// 	$phpdate = strtotime( $value['dateupdated'] );
		// 	$data['updated_time'] = date('D d-m-Y g:i a', $phpdate);


			// foreach ($value as $key2 => $value2) {
			// 	$n = $value2 . 'a';
			// 	if($value2 == "name"){
			// 		$data['labs'][$i] = $value2;
			// 	}
			// 	else{
			// 		$data[$n][$i] = (int) $value2;
			// 	}
			// }


	// 		// foreach ($value as $key2 => $value2) {
	// 		// 	$n = $value2 . 'a';
	// 		// 	if($value2 == "name"){
	// 		// 		$data['labs'][$i] = $value2;
	// 		// 	}
	// 		// 	else{
	// 		// 		$data[$n][$i] = (int) $value2;
	// 		// 	}
	// 		// }

	// 		$i++;

	// 	}

	// 	return json_encode($data);

	// }


	// function get_eid_data(){
	// 	$sql = "CALL `proc_get_eid_lab_live_data`()";
	// 	$sql2 = "CALL `proc_get_eid_live_data_totals`()";

	// 	$result = $this->db->query($sql)->result_array();

	// 	// return json_encode($result);
	// 	$this->db->close();
	// 	$totals = $this->db->query($sql2)->row();

	// 	$data = null;

	// 	$data['updated'] = date('D d-m-Y g:i a');

	// 	foreach ($totals as $key => $value) {
	// 		$data[$key] = (int) $value;
	// 	}

	// 	$data['machines'][0] = "Abbot";
	// 	$data['machines'][1] = "Panther";
	// 	$data['machines'][2] = "Roche";

	// 	$data['minprocess'][0] = (int) $totals->abbottinprocess;
	// 	$data['minprocess'][1] = (int) $totals->panthainprocess;
	// 	$data['minprocess'][2] = (int) $totals->rocheinprocess;

	// 	$data['mprocessed'][0] = (int) $totals->abbottprocessed;
	// 	$data['mprocessed'][1] = (int) $totals->panthaprocessed;
	// 	$data['mprocessed'][2] = (int) $totals->rocheprocessed;



	// 	$i=0;


	// 	foreach ($result as $key => $value) {
	// 		$data['labs'][$i] = $value['name'];
	// 		$data['enteredsamplesatsitea'][$i] = (int) $value['enteredsamplesatsite'];
	// 		$data['enteredsamplesatlaba'][$i] = (int) $value['enteredsamplesatlab'];
	// 		$data['receivedsamplesa'][$i] = (int) $value['receivedsamples'];
	// 		$data['inqueuesamplesa'][$i] = (int) $value['inqueuesamples'];
	// 		$data['inprocesssamplesa'][$i] = (int) $value['inprocesssamples'];
	// 		$data['processedsamplesa'][$i] = (int) $value['processedsamples'];
	// 		$data['pendingapprovala'][$i] = (int) $value['pendingapproval'];
	// 		$data['dispatchedresultsa'][$i] = (int) $value['dispatchedresults'];
	// 		$data['oldestinqueuesamplea'][$i] = (int) $value['oldestinqueuesample'];
	// 		// $data['updated_time'] = $value['dateupdated'];
	// 		$phpdate = strtotime( $value['dateupdated'] );
	// 		$data['updated_time'] = date('D d-m-Y g:i a', $phpdate);


	// 		// foreach ($value as $key2 => $value2) {
	// 		// 	$n = $value2 . 'a';
	// 		// 	if($value2 == "name"){
	// 		// 		$data['labs'][$i] = $value2;
	// 		// 	}
	// 		// 	else{
	// 		// 		$data[$n][$i] = (int) $value2;
	// 		// 	}
	// 		// }

	// 		$i++;

	// 	}
		
	// 	return json_encode($data);

	// }

	

}