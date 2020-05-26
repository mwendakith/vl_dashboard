<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
* 
*/
class Template extends MY_Controller
{
	
	public function index($data)
	{
		$this->load_template($data);
	}

	public function load_template($data)
	{

		$this->load->model('template_model');

		$data['filter'] = $this->template_model->get_counties_dropdown();
		$data['partner'] = $this->template_model->get_partners_dropdown();
		$data['sites'] = $this->template_model->get_site_dropdown();
		$data['regimen'] = $this->template_model->get_regimen_dropdown();
		$data['age_filter'] = $this->template_model->get_age_dropdown();
		$data['subCounty'] = $this->template_model->get_sub_county_dropdown();
		$data['laborotories'] = $this->template_model->get_lab_dropdown();
		$data['samples'] = $this->template_model->get_sample_dropdown();
		$data['pmtcts'] = $this->template_model->pmtct_dropdown();
		$data['agencies'] = $this->template_model->funding_agencies_dropdown();
		// $data['breadcrum'] = $this->breadcrum();
		// echo "<pre>";print_r($data);die();
		$this->load->view('template_view',$data);
	}

	function filter_county_data()
	{
		
		$data = array(
				'county' => $this->input->post('county')
			);

		$this->filter_regions($data);
		echo $this->session->userdata('county_filter');
		// echo json_encode($this->session->all_userdata());
	}

	function filter_sub_county_data()
	{
		
		$data = array(
				'subCounty' => $this->input->post('subCounty')
			);
		// echo "<pre>";print_r($data);die();
		$this->filter_sub_county($data);

		echo $this->session->userdata('sub_county_filter');
		
	}

	function filter_partner_data()
	{		
		$data = array(
				'partner' => $this->input->post('partner')
			);
		
		$this->filter_partners($data);

		echo json_encode($this->session->userdata('partner_filter'));
		
	}
	function filter_site_data()
	{
		$data = array(
				'site' => $this->input->post('site')
			);
		
		$this->filter_site($data);

		// echo $this->input->post('site');

		echo $this->session->userdata('site_filter');
	}

	function filter_regimen_data()
	{
		$data = array(
				'regimen' => $this->input->post('regimen')
			);

		$this->filter_regimens($data);

		echo $this->session->userdata('regimen_filter');
	}

	function filter_age_category_data()
	{
		$data = array(
				'age_category' => $this->input->post('age_cat')
			);

		$this->filter_ages($data);

		echo json_encode($this->session->userdata('age_category_filter'));
	}

	function filter_sample_data()
	{
		$data = array(
				'sample' => $this->input->post('sample')
			);

		$this->filter_sample($data);

		echo $this->session->userdata('sample_filter');
	}

	function filter_partner_age_data()
	{
		$data = array(
				'ageCat' => $this->input->post('ageCat')
			);

		$this->filter_partner_ages($data);

		echo json_encode($this->session->userdata('patner_age_category_filter'));
	}

	function filter_partner_regimen_data()
	{
		$data = array(
				'patReg' => $this->input->post('regimen')
			);

		$this->filter_partner_regimen($data);

		echo $this->session->userdata('patner_regimen_filter');
	}

	function filter_date_data()
	{
		$data = array(
				'year' => $this->input->post('year'),
				'month' => $this->input->post('month')
			);
		
		echo $this->set_filter_date($data);
	}

	function filter_pmtct_data()
	{
		$data = array(
				'pmtct' => $this->input->post('pmtct')
		);

		$this->filter_pmtct($data);
		echo $this->session->userdata('pmtct_filter');
	}

	function filter_funding_agency_data() {
		$data = array(
				'funding_agency' => $this->input->post('agency')
		);

		$response = $this->filter_funding_agency($data);
		if ($response)
			echo json_encode($this->session->userdata('funding_agency_filter'));
	}

	function breadcrum($data=null,$partner=NULL,$site=NULL,$sub_county=NULL,$type=null)
	{
		/*$type ==> 
			1: county
			2: Partner
			3: Sub-County
			4: Site
			5: Funding Agency*/
		$this->load->model('template_model');
		// $data = trim($data,"%22");
		// echo $data;die();
		if ($partner=='null'||$partner==null) {
			$partner = NULL;
		}
		if ($site=='null'||$site==null) {
			$site = NULL;
		}
		if ($data=='null'||$data==null) {
			$data = NULL;
		}
		if ($sub_county=='null'||$sub_county==null) {
			$sub_county = NULL;
		}
		if ($type=='null'||$type==null) {
			$type = NULL;
		}
		
		if ($partner) {
			if ($data==null || $data=='null') {
				// echo "No partner is set";
				if (!$this->session->userdata('partner_filter')) {
					echo "<a href='javascript:void(0)' class='alert-link'><strong>All Partners</strong></a>";
				} else {
					$partner = $this->template_model->get_partner_name($this->session->userdata('partner_filter'));
					echo "<a href='javascript:void(0)' class='alert-link'><strong>".$partner."</strong></a>";
				}
			} else {
				// echo "A partner is set";
				$partner = $this->template_model->get_partner_name($data);
				echo "<a href='javascript:void(0)' class='alert-link'><strong>".$partner."</strong></a>";
			}
		} else if ($site) {
			if (!$data) {
				if (!$this->session->userdata('site_filter')) {
					echo "<a href='javascript:void(0)' class='alert-link'><strong>All Sites</strong></a>";
				} else {
					$site = $this->template_model->get_site_name($this->session->userdata('site_filter'));
					echo "<a href='javascript:void(0)' class='alert-link'><strong>".$site."</strong></a>";
				}
			} else {
				$site = $this->template_model->get_site_name($data);
				echo "<a href='javascript:void(0)' class='alert-link'><strong>".$site."</strong></a>";
			}
			
		} else if ($sub_county) {
			if (!$data) {
				if (!$this->session->userdata('sub_county_filter')) {
					echo "<a href='javascript:void(0)' class='alert-link'><strong>All Sub-Counties</strong></a>";
				} else {
					$sub_county = $this->template_model->get_sub_county_name($this->session->userdata('sub_county_filter'));
					echo "<a href='javascript:void(0)' class='alert-link'><strong>".$sub_county."</strong></a>";
				}
			} else {
				$sub_county = $this->template_model->get_sub_county_name($data);
				echo "<a href='javascript:void(0)' class='alert-link'><strong>".$sub_county."</strong></a>";
			}
			
		} else if($type) {
			if ($type == 5 || $type == '5') {
				if ($data == null || $data == 'null') {
					echo "<a href='javascript:void(0)' class='alert-link'><strong>All Funding Agencies</strong></a>";
				} else {
					$agency = $this->template_model->get_funding_agency($data);
					echo "<a href='javascript:void(0)' class='alert-link'><strong>".$agency."</strong></a>";
				}
			}
		} else {
			if (!$data) {
				if (!$this->session->userdata('county_filter')) {
					echo "<a href='javascript:void(0)' class='alert-link'><strong>Kenya</strong></a>";
				} else {
					$county = $this->template_model->get_county_name($this->session->userdata('county_filter'));
					echo "Kenya / <a href='javascript:void(0)' class='alert-link'><strong>".$county."</strong></a>";
				}
			} else {
				if ($data == '48' || $data == 48) {
					echo "<a href='javascript:void(0)' class='alert-link'><strong>Kenya</strong></a>";
				} else {
					$county = $this->template_model->get_county_name($data);
					echo "Kenya / <a href='javascript:void(0)' class='alert-link'><strong>".$county."</strong></a>";
				}
			}
		}
	}

	function dates()
	{
		$this->load->model('template_model');
		$data = array(
					'prev_year' => ($this->session->userdata('filter_year')-1),
					'year' => $this->session->userdata('filter_year'),
					'month' => $this->template_model->resolve_month($this->session->userdata('filter_month')));
		echo json_encode($data);
	}

	public function get_current_header(){

		$this->load->model('template_model');
		
    	$year = ((int) Date('Y'));
    	$prev_year = ((int) Date('Y')) - 1;
    	$month = ((int) Date('m')) - 1;
    	$prev_month = ((int) Date('m'));

    	if($month == 0){
    		echo "(Jan - Dec {$prev_year})";
    	}
    	else{
    		echo "(" . $this->template_model->resolve_month($prev_month) . ", {$prev_year} - " . $this->template_model->resolve_month($month) . ", {$year})";
    	}
	}

	public function get_site_details($id)
	{
		// echo $id;
		$this->load->model('template_model');
		
		echo json_encode($this->template_model->get_site_details($id));

	}
}
?>