<?php
(defined('BASEPATH') or exit('No direct script access is allowed!'));

/**
* 
*/
class Tat extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('tat_model');
	}

	public function outcomes($year=null, $month=null, $to_year=null, $to_month=null, $type=null, $id=null)
	{
		$data['trends'] = $this->tat_model->outcomes($year, $month, $to_year, $to_month, $type, $id);
		$data['div_name'] = "summary_tat_summary";
		$data['tat'] = true;
		// echo "<pre>";print_r($data);die();
		$this->load->view('trends_outcomes_view', $data);
	}

	public function details($year=null, $month=null, $to_year=null, $to_month=null, $type=null, $id=null)
	{
		if ($type == 0) $title = 'County';
		if ($type == 1) $title = 'Partner';
		if ($type == 2) $title = 'Sub-county';
		if ($type == 3) $title = 'Facility';
		$data['th'] = '<tr class="colhead">
							<th>#</th>
							<th>'.$title.'</th>
							<th>Collection To Receipt</th>
							<th>Receipt To Processing</th>
							<th>Processing To Dispatch</th>
							<th>Collection To Dispatch</th>
						</tr>';
		$data['outcomes'] = $this->tat_model->details($year, $month, $to_year, $to_month, $type, $id);
		// echo "<pre>";print_r($data);die();
		$this->load->view('table_view',$data);
	}
}

?>