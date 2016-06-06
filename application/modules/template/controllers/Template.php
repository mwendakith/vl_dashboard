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
		$data['breadcrum'] = $this->breadcrum();
		// echo "<pre>";print_r($data);die();
		$this->load->view('template_view',$data);
	}

	function filter_region_data()
	{
		$data = array(
					'county' => $this->input->post('county')
				);

		$this->filter_regions($data);

		echo $this->session->userdata('county_filter');
	}

	function breadcrum()
	{
		$this->load->model('template_model');
		if (!$this->session->userdata('county_filter')) {
			echo "<a href='javascript:void(0)' class='alert-link'><strong>Kenya</strong></a>";
		} else {
			$county = $this->template_model->get_county_name($this->session->userdata('county_filter'));
			echo "Kenya / <a href='javascript:void(0)' class='alert-link'><strong>".$county."</strong></a>";
		}
	}

	function dates()
	{
		$data = array(
					'prev_year' => ($this->session->userdata('filter_year')-1),
					'year' => $this->session->userdata('filter_year'),
					'month' => $this->session->userdata('filter_month'));
		echo json_encode($data);
	}
}
?>