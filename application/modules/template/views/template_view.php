<?php
	ob_start();
	$this->load->view('header_view');
	$this->load->view('utils/filter_view');
	$this->load->view($content_view);
	$this->load->view('footer_view');
?>