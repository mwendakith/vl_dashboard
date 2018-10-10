<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * 
 */
class Agencies_model extends MY_Model
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function suppression($year=null,$month=null,$to_year=null,$to_month,$type=null,$agency_id=null) {
		if ($year==null || $year=='null') 
			$year = $this->session->userdata('filter_year');
		
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = 0;
			}else {
				$month = $this->session->userdata('filter_month');
			}
		}

		if ($to_month==null || $to_month=='null') 
			$to_month = 0;
		if ($to_year==null || $to_year=='null') 
			$to_year = 0;

		if ($type==null || $type == 'null')
			$type = 0;
		if ($agency_id==null || $agency_id == 'null')
			$agency_id = $this->session->userdata('funding_agency_filter');

		$sql = "CALL `proc_get_vl_agencies_outcomes`('".$year."','".$month."','".$to_year."','".$to_month."','".$type."','".$agency_id."')";

		$result = $this->db->query($sql)->result_array();

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
		$data['categories'][0] 		   = 'No Data';
		$data['outcomes'][0]['data'][0] = (int) 0;
		$data['outcomes'][1]['data'][0] = (int) 0;
		$data['outcomes'][2]['data'][0] = (int) 0;
 
		foreach ($result as $key => $value) {
			$suppressed = (int)$value['suppressed'];
			$nonsuppressed = (int)$value['nonsuppressed'];
			$data['categories'][$key] 		   = $value['agency'];
			$data['outcomes'][0]['data'][$key] = (int) $nonsuppressed;
			$data['outcomes'][1]['data'][$key] = (int) $suppressed;
			$data['outcomes'][2]['data'][$key] = round(@(((int) $suppressed*100)/((int) $suppressed+(int) $nonsuppressed)),1);
		}
		
		return $data;

	}

	public function outcomes ($year=null,$month=null,$to_year=null,$to_month,$type=null,$agency_id=null) {

	}

	function get_sampletypesData($year=null,$type=null,$agency_id=null)
	{
		$array1 = array();
		$array2 = array();
		$sql2 = NULL;
 
		if ($type==null || $type=='null') 
			$type = 0;
		
		if ($agency_id==null || $agency_id=='null') 
			$agency_id = $this->session->userdata('funding_agency_filter');
 
 
		if ($year==null || $year=='null') {
			$to = $this->session->userdata('filter_year');
		}else {
			$to = $year;
		}
		$from = $to-1;
 
		$sql = "CALL `proc_get_vl_fundingagencies_sample_types`('".$from."','".$to."','".$type."','".$agency_id."')";

		$array1 = $this->db->query($sql)->result_array();
		return $array1;
	}

	public function sample_types($year=NULL,$type=null,$agency_id=null,$all=NULL) {
		$result = $this->get_sampletypesData($year,$type,$agency_id);
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
}

?>