<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
* 
*/
class Template_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}

	function get_counties_dropdown()
	{
		$dropdown = '';
		$county_data = $this->db->get('countys')->result_array();

		foreach ($county_data as $key => $value) {
			$dropdown .= '<option value="'.$value['ID'].'">'.$value['name'].' County</option>';
		}
		
		return $dropdown;
	}

	function get_sub_county_dropdown()
	{
		$dropdown = '';
		$this->db->from('districts');
		$this->db->order_by("name", "asc");
		$county_data = $this->db->get()->result_array();
		
		foreach ($county_data as $key => $value) {
			$dropdown .= '<option value="'.$value['id'].'">'.$value['name'].' Sub-County</option>';
		}
		
		return $dropdown;
	}

	function get_partners_dropdown()
	{
		$dropdown = '';
		$this->db->where('flag', 1);
		$this->db->order_by("name","asc");
		$partner_data = $this->db->get('partners')->result_array();
		// $partner_data = $this->db->query('SELECT `ID`, `name` FROM `partners` ORDER BY `name` ASC')->result_array();

		foreach ($partner_data as $key => $value) {
			$dropdown .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
		}
		
		return $dropdown;
	}

	function get_lab_dropdown()
	{
		$dropdown = '';
		$this->db->order_by("name","asc");
		$lab_data = $this->db->get('labs')->result_array();

		foreach ($lab_data as $key => $value) {
			$dropdown .= '<option value="'.$value['ID'].'">'.$value['labname'].'</option>';
		}
		$dropdown .= '<option value="11">POC Sites</option>';
				
		return $dropdown;
	}

	function get_sample_dropdown()
	{
		$dropdown = '';
		$this->db->order_by("name","asc");
		$lab_data = $this->db->get('viralsampletypedetails')->result_array();

			$dropdown .= '<option value=1>Plasma</option>
						  <option value=2>DBS</option>';
		
		return $dropdown;
	}

	function get_site_dropdown()
	{
		$dropdown = '';
		$site_data = $this->db->query('SELECT DISTINCT `view_facilitys`.`ID`, `view_facilitys`.`name` FROM `vl_site_summary` JOIN `view_facilitys` ON `vl_site_summary`.`facility` = `view_facilitys`.`ID`')->result_array();

		foreach ($site_data as $key => $value) {
			$dropdown .= '<option  value="'.$value['ID'].'">'.$value['name'].'</option>';
		}

		return $dropdown;
	}

	function get_site_details($id)
	{
		
		$site_data = $this->db->query("SELECT * FROM `view_facilitys` WHERE `ID` = $id")->result();
		return $site_data;
	}

	function get_regimen_dropdown()
	{
		$dropdown = '';
		$this->db->order_by("name","asc");
		$county_data = $this->db->get('viralprophylaxis')->result_array();

		foreach ($county_data as $key => $value) {
			$dropdown .= '<option value="'.$value['ID'].'">'.$value['name'].'</option>';
		}
		
		return $dropdown;
	}

	function get_age_dropdown()
	{
		$dropdown = '';
		$regimen_data = $this->db->query("SELECT * FROM `agecategory` WHERE `ID` > '5' ")->result_array();

		foreach ($regimen_data as $key => $value) {
			$dropdown .= '<option value="'.$value['ID'].'">'.$value['name'].'</option>';
		}
		
		return $dropdown;
	}

	function pmtct_dropdown()
	{
		$dropdown = '';
		// $this->db->order_by("name","asc");
		$this->db->where('subID', 1);
		$lab_data = $this->db->get('viralpmtcttype')->result_array();

		foreach ($lab_data as $key => $value) {
			$dropdown .= '<option value="'.$value['ID'].'">'.$value['name'].'</option>';
		}
		
		return $dropdown;
	}

	function funding_agencies_dropdown() {
		$dropdown = '';
		
		$funding_agencies = $this->db->get('funding_agencies')->result_array();
		foreach ($funding_agencies as $key => $value) {
			$dropdown .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
		}
		
		return $dropdown;
	}

	function get_county_name($county_id)
	{
		$this->db->where('ID', $county_id);
		$data = $this->db->get('countys')->result_array();
		$name = $data[0]["name"];

		return $name;
	}

	function get_sub_county_name($sub_county_id)
	{
		$this->db->where('ID', $sub_county_id);
		$data = $this->db->get('districts')->result_array();
		$name = $data[0]["name"];

		return $name;
	}

	function get_partner_name($partner_id)
	{
		$this->db->where('ID', $partner_id);
		$data = $this->db->get('partners')->result_array();
		$name = $data[0]["name"];

		return $name;
	}

	function get_funding_agency($funding_agency) {
		$this->db->where('id', $funding_agency);
		$data = $this->db->get('funding_agencies')->result_array();
		$name = $data[0]['name'];

		return $name;
	}
}
?>