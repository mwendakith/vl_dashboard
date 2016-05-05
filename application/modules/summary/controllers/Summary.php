<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary extends MY_Controller {

	function __construct()
	{
		parent:: __construct();
	}

	public function index()
	{
		$this->load->module('charts/national');

		$data = $this->national->national();
		echo "<pre>";print_r($data);
	}
}