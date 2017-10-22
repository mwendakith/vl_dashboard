<?php
(defined('BASEPATH') or exit('No direct script access allowed!'));

/**
* 
*/
class Pmtct extends MY_Controller
{
	
	function __construct()
	{
		parent:: __construct();
		$this->load->model('pmtct_model');
	}

	public function pmtct_outcomes ($year=null,$month=null,$type=1,$to_year=null,$to_month=null,$partner=null)
	{
		$data['outcomes'] = $this->pmtct_model->pmtct_outcomes($year,$month,$to_year,$to_month,$partner);
		if ($type == 1) {
			$data['type'] = 'normal';
		} else if ($type == 2) {
			$data['type'] = 'percent';
		}
		$this->load->view('pmtct_view',$data);
	}
}
?>