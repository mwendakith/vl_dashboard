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
			$dropdown .= '<option value="'.$value['ID'].'">'.$value['name'].'</option>';
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

	function get_partners_dropdown()
	{
		$dropdown = '';
		$partner_data = $this->db->get('partners')->result_array();

		foreach ($partner_data as $key => $value) {
			$dropdown .= '<option value="'.$value['ID'].'">'.$value['name'].'</option>';
		}
		
		return $dropdown;
	}

	function get_partner_name($partner_id)
	{
		$this->db->where('ID', $partner_id);
		$data = $this->db->get('partners')->result_array();
		$name = $data[0]["name"];

		return $name;
	}
}
?>