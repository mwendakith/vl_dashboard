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
	}

	public function pmtct_outcomes ($year=null,$month=null,$type=1,$to_year=null,$to_month=null,$partner=null)
	{
		if ($type == 1) {
			print_r("Normal");
		} else if ($type == 2) {
			print_r("Percentage");
		}
		
	}
}
?>