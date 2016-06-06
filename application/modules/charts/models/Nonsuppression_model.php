<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
* 
*/
class Nonsuppression_model extends MY_Model
{
	
	function __construct()
	{
		parent:: __construct();
	}

	function notification_bar($year=NULL,$month=NULL,$county=NULL)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}

		$data['year'] = $year;
		$data['month'] = '';

		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}else {
			$data['month'] = ' as of '.$this->resolve_month($month);
		}

		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_national_sustxfail_notification`('".$year."','".$month."')";
			$data['county'] = 'National';
		} else {
			$sql = "CALL `proc_get_regional_sustxfail_notification`('".$county."','".$year."','".$month."')";
			$data['county'] = $county;
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		
		foreach ($result as $key => $value) {
			(int) $data['rate'] = $value['sustxfail_rate'];
			if ((int) $value['sustxfail_rate']=0) {
				$data['color'] = '#81CFE0';
			} else if ($value['sustxfail_rate']>0 && $value['sustxfail_rate']<10) {
				$data['color'] = '#3FC380';
			} else if($value['sustxfail_rate']>=10 && $value['sustxfail_rate']<50) {
				$data['color'] = '#E9D460';
			} else if($value['sustxfail_rate']>=50 && $value['sustxfail_rate']<90) {
				$data['color'] = '#F89406';
			} else if($value['sustxfail_rate']>=90 && $value['sustxfail_rate']<100) {
				$data['color'] = '#CF000F';
			}
		}
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function gender_group_chart($year=NULL,$month=NULL,$county=NULL)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_national_sustxfail_gender`('".$year."','".$month."')";
		} else {
			$sql = "CALL `proc_get_regional_sustxfail_gender`('".$county."','".$year."','".$month."')";
		}
		
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['categories'][0] = '';
		$data['gnd_gr']['name'] = 'Susp. Tx. Fail';
		$data['gnd_gr']['data'][0] = 0;
			
		foreach ($result as $key => $value) {
			if ($value['name']=='F') {
				$data['categories'][$key] = 'Female';
				$data['gnd_gr']['data'][$key] = (int) $value['sustxfail'];
			} else {
				$data['categories'][$key] = 'Male';
				$data['gnd_gr']['data'][$key] = (int) $value['sustxfail'];
			}
			
		}
		
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function age_group_chart($year=NULL,$month=NULL,$county=NULL)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_national_sustxfail_age`('".$year."','".$month."')";
		} else {
			$sql = "CALL `proc_get_regional_sustxfail_age`('".$county."','".$year."','".$month."')";
		}

		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();
		$data['categories'][0] = '';
		$data['age_gr']['name'][0] = 'Age Groups';
		$data['age_gr']['data'][0] = 0;

		foreach ($result as $key => $value) {
			$data['categories'][$key] = $value['name'];
			$data['age_gr']['data'][$key] = (int) $value['sustxfail'];
		}

		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function justifications($year=NULL,$month=NULL,$county=NULL)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_national_sustxfail_justification`('".$year."','".$month."')";
		} else {
			$sql = "CALL `proc_get_regional_sustxfail_justification`('".$county."','".$year."','".$month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();

		$data['li'] = '';
		$data['justification']['name'] = 'Non Suppression';
		$data['justification']['colorByPoint'] = true;

		$count = 0;

		$data['justification']['data'][0]['name'] = 'No Data';

		foreach ($result as $key => $value) {
			$data['li'] .= '<a href="#" class="list-group-item"><strong>'.$value['name'].':-></strong>&nbsp;'.$value['sustxfail'].'</a>';
			$data['justification']['data'][$key]['y'] = $count;
			
			$data['justification']['data'][$key]['name'] = $value['name'];
			$data['justification']['data'][$key]['y'] = (int) $value['sustxfail'];
		}

		$data['justification']['data'][0]['sliced'] = true;
		$data['justification']['data'][0]['selected'] = true;
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function sampletypes($year=NULL,$month=NULL,$county=NULL)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_national_sustxfail_sampletypes`('".$year."','".$month."')";
		} else {
			$sql = "CALL `proc_get_regional_sustxfail_sampletypes`('".$county."','".$year."','".$month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		// echo "<pre>";print_r($result);die();

		$data['sampletype']['name'] = 'Non Suppression';
		$data['sampletype']['colorByPoint'] = true;

		$count = 0;

		$data['sampletype']['data'][0]['name'] = 'No Data';

		foreach ($result as $key => $value) {
			$data['sampletype']['data'][$key]['y'] = $count;
			
			$data['sampletype']['data'][$key]['name'] = $value['name'];
			$data['sampletype']['data'][$key]['y'] = (int) $value['sustxfail'];
		}

		$data['sampletype']['data'][0]['sliced'] = true;
		$data['sampletype']['data'][0]['selected'] = true;
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function regimen($year=null,$month=null,$county=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_national_sustxfail_regimen`('".$year."','".$month."')";
		} else {
			$sql = "CALL `proc_get_regional_sustxfail_regimen`('".$county."','".$year."','".$month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();
		$data['regimen']['name'] = 'Non Suppression';
		$data['regimen']['colorByPoint'] = true;

		$count = 0;

		$data['li'] = '';
		$data['regimen']['data'][0]['name'] = 'No Data';
		$data['regimen']['data'][0]['y'] = 0;

		foreach ($result as $key => $value) {
			$data['li'] .= '<a href="#" class="list-group-item"><strong>'.$value['name'].':-></strong>&nbsp;'.$value['sustxfail'].'</a>';
			$data['regimen']['data'][$key]['y'] = $count;
			
			$data['regimen']['data'][$key]['name'] = $value['name'];
			$data['regimen']['data'][$key]['y'] = (int) $value['sustxfail'];
		}

		$data['regimen']['data'][0]['sliced'] = true;
		$data['regimen']['data'][0]['selected'] = true;
		// echo "<pre>";print_r($data);die();
		return $data;
	}

	function county_listings($year=NULL,$month=NULL,$county=NULL)
	{
		$li = '';
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}

		$sql = "CALL `proc_get_sustxfail_counties`('".$year."','".$month."')";
		$result = $this->db->query($sql)->result_array();

		// echo "<pre>";print_r($result);die();
		$count = 1;
		$listed = FALSE;

		if($result)
			{
				if ($county==null || $county=='null') {
					foreach ($result as $key => $value)
						{
							if ($count<11) {
								$li .= '<a href="javascript:void(0);" class="list-group-item" onclick="county_filter('.$value['ID'].')"><strong>'.$count.'.</strong>&nbsp;'.$value['name'].':&nbsp;'.(int)$value['sustxfail'].'%</a>';
							}
							// else {
							// 	exit();
							// }
							$count++;
						}
				} else {
					foreach ($result as $key => $value)
						{
							if ($count<11) {
								if ($county == $value['ID']) {
									$li .= '<pre><strong><a href="javascript:void(0);" class="list-group-item" onclick="county_filter('.$value['ID'].')">'.$count.'.&nbsp;'.$value['name'].':&nbsp;'.(int)$value['sustxfail'].'%</a></strong></pre>';
									$listed = TRUE;
								} else {
									$li .= '<a href="javascript:void(0);" class="list-group-item" onclick="county_filter('.$value['ID'].')"><strong>'.$count.'.</strong>&nbsp;'.$value['name'].':&nbsp;'.(int)$value['sustxfail'].'%</a>';
								}
							}
							// else {
							// 	exit();
							// }
							$count++;
						}
					if(!$listed)
						{
							$count = 1;
							foreach ($result as $key => $value)
								{
									if ($county == $value['ID'])
										{
											$li .= '<pre><strong><a href="javascript:void(0);" class="list-group-item" onclick="county_filter('.$value['ID'].')">'.$count.'.&nbsp;'.$value['name'].':&nbsp;'.(int)$value['sustxfail'].'%</a></strong></pre>';
										}
									$count++;
								}
						}
					
				}
			}else{
				$li = 'No Data';
			}
		
		// echo "<pre>";print_r($li);die();
		return $li;
	}

	function partners($year=null,$month=null,$county=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_national_sustxfail_partner`('".$year."','".$month."')";
		} else {
			$sql = "CALL `proc_get_regional_sustxfail_partner`('".$county."','".$year."','".$month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$li = '';
		$count = 1;
		if($result)
			{
				foreach ($result as $key => $value) {
					$li .= '<a href="#" class="list-group-item"><strong>'.$count.'.</strong>&nbsp;'.$value['name'].':&nbsp;'.$value['sustxfail'].'</a>';
					$count++;
				}
			}else{
				$li = 'No Data';
			}

		return $li;
	}


	function regimen_listing($year=null,$month=null,$county=null)
	{
		if ($county==null || $county=='null') {
			$county = $this->session->userdata('county_filter');
		}

		if ($year==null || $year=='null') {
			$year = $this->session->userdata('filter_year');
		}
		if ($month==null || $month=='null') {
			if ($this->session->userdata('filter_month')==null || $this->session->userdata('filter_month')=='null') {
				$month = $this->session->userdata('filter_month');
			}else {
				$month = 0;
			}
		}
		if ($county==null || $county=='null') {
			$sql = "CALL `proc_get_national_sustxfail_rank_regimen`('".$year."','".$month."')";
		} else {
			$sql = "CALL `proc_get_regional_sustxfail_rank_regimen`('".$county."','".$year."','".$month."')";
		}
		// echo "<pre>";print_r($sql);die();
		$result = $this->db->query($sql)->result_array();

		$li = '';
		$count = 1;
		if($result)
			{
				foreach ($result as $key => $value) {
					$li .= '<a href="#" class="list-group-item"><strong>'.$count.'.</strong>&nbsp;'.$value['name'].':&nbsp;'.$value['sustxfail'].'</a>';
					$count++;
				}
			}else{
				$li = 'No Data';
			}

		return $li;
	}
}
?>