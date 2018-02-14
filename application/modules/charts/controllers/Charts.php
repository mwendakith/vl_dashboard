<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Charts extends MY_Controller {

	
	public function index()
	{
		$z = 1;
		if( $z <= 1) return true;

	    for( $elf = floor(sqrt($z)); $elf > 1; $elf--) { 
	        for( $rtk = ceil(log($z)/log($elf)); $rtk > 1; $rtk--) { 
	            if( pow($elf,$rtk) == $z) return true;
	            break;
	        }
	        
	    }
	    return false;
		
	}

	function art()
	{
		// echo "Starting import! <br /><br />";
		$file = base_url('assets/files/recovered.csv');
		$file = fopen($file, "r");
		$data = array();
		$newdata = array();
		if ($file) {
		    while (($row = fgetcsv($file, 0, ";")) !== false) {
		        if (empty($header))
		        {
		        	$header = explode(",", $row[0]);
		        	continue;
		        }
		        $data[] = explode(",", $row[0]);
		    }
		    foreach ($data as $key => $value) {
		    	$newdata[] = array(
		    					$header[0] => $value[0],
		    					$header[1] => $value[1],
		    					$header[2] => $value[2],
		    					$header[3] => $value[3]
		    					);
		    }
		}

		//Separating the facilities without MFL codes with those with MFL codes in the $newdata array()
		$no_mfls = array();
		$withmfls = array();
		$incomplete = array();
		foreach ($newdata as $key => $value) {
			if ($value['IPSL/MFL'] == '' || is_null($value['IPSL/MFL'])) {
				$no_mfls[] = $value;
			} else {
				$this->db->select('ID');
				$this->db->from('facilitys');
				$this->db->where('facilitycode', $value['IPSL/MFL']);
				$resp = $this->db->get()->result();
				if (empty($resp)) {
					$incomplete[] = $value;
				} else {
					$value['facility_id'] = $resp[0]->ID;
					$withmfls[] = $value;
				}
			}
		}
		
		//Checking if the facilities already exists
		$exists_without_mfl = array();
		$new_facilities = array();
		if (!empty($no_mfls)) {
			foreach ($no_mfls as $key => $value) {
				$this->db->like('name', $value['Facility Name']);
				$result = $this->db->get('facilitys')->result();
				if (!empty($result)) {
					$value['IPSL/MFL'] = $result[0]->facilitycode;
					$value['facility_id'] = $result[0]->ID;
					$exists_without_mfl[] = $value;
				} else {
					$new_facilities[] = $value;
				}
			}
		}
		// Inserting the ART data to the database	
		$insertData = array();	
		$existsing = array_merge($withmfls, $exists_without_mfl);
		// echo "<pre>";print_r($existsing);die();
		foreach ($existsing as $key => $value) {
			$insertData[] = array(
								'facility_id' => $value['facility_id'],
								'MFL_Code' => $value['IPSL/MFL'],
								'current_on_treatment' => $value['TX CURR'],
								'starting_date' => '2017-09-01',
								'ending_date' => '2018-03-31'
							);
		}

		$this->db->insert_batch('artregister', $insertData);
		// Downloading the csv of the new facilities
		if (!empty($new_facilities)) $this->create_csv($new_facilities, 'New Facilities');
		echo "\n\n\n";
		// Downloading the csv of the incomplete facilities
		if (!empty($incomplete)) $this->create_csv($incomplete, 'Incomplete Facilities');	

		// die("Import complete check for any of the generateed files!");
	}

	function create_csv($data=null, $file_name='download')
	{
		$this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";

	    /** open raw memory as file, no need for temp files, be careful not to run out of memory thought */
	    $f = fopen('php://memory', 'w');
	    /** loop through array  */

	    $b = array('County', 'Facility Name', 'IPSL/MFL', 'TX CURR');

	    fputcsv($f, $b, $delimiter);

	    foreach ($data as $line) {
	        /** default php csv handler **/
	        fputcsv($f, $line, $delimiter);
	    }
	    /** rewrind the "file" with the csv lines **/
	    fseek($f, 0);
	    /** modify header to be downloadable csv file **/
	    header('Content-Type: application/csv');
	    header('Content-Disposition: attachement; filename="'.$file_name.'.csv";');
	    /** Send file to browser for download */
	    fpassthru($f);
	    fclose($f);
	}

	function number_format()
	{
		echo number_format("10000000.1",2)."<br>";
	}

}
?>