<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summaries extends MY_Controller {

	function __construct()
	{
		parent:: __construct();
		$this->load->model('summaries_model');
	}

	function turnaroundtime($year=NULL,$month=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->turnaroundtime($year,$month,$county,$to_year,$to_month);

		$this->load->view('turnaroundtime_view',$data);
	}

	function vl_coverage($type=NULL,$ID=NULL)
	{
		$data['outcomes'] = $this->summaries_model->vl_coverage($type,$ID);

		$this->load->view('vl_coverage_view',$data);
	}
	
	function county_outcomes($year=NULL,$month=NULL,$pfil=NULL,$partner=NULL,$county=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['trends'] = $this->summaries_model->county_outcomes($year,$month,$pfil,$partner,$county,$to_year,$to_month);
		$data['div_name'] = "summary_county_outcomes";		

		$this->load->view('trends_outcomes_view', $data);
	}

	function vl_outcomes($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->vl_outcomes($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('vl_outcomes_view',$data);
	}
	

	function justification($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->justification($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('justification_view',$data);
	}

	function justificationbreakdown($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->justification_breakdown($year,$month,$county,$partner,$to_year,$to_month);
		
		$this->load->view('justification_breakdown_view',$data);
	}

	function age($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->age($year,$month,$county,$partner,$to_year,$to_month);
		
    	$this->load->view('agegroup_view',$data);
	}

	function agebreakdown($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->age_breakdown($year,$month,$county,$partner,$to_year,$to_month);
		
		$this->load->view('agegroupBreakdown',$data);
	}

	function gender($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		$data['outcomes'] = $this->summaries_model->gender($year,$month,$county,$partner,$to_year,$to_month);

    	$this->load->view('gender_view',$data);
	}

	function sample_types($year=NULL,$county=NULL,$partner=NULL, $all=NULL)
	{
		$data['outcomes'] = $this->summaries_model->sample_types($year,$county,$partner, $all);
		$link = $year . '/' . $county . '/' . $partner;

		$data['link'] = base_url('charts/summaries/download_sampletypes/' . $link);

    	$this->load->view('national_sample_types',$data);
	}

	function download_sampletypes($year=NULL,$county=NULL,$partner=NULL)
	{
		$this->summaries_model->download_sampletypes($year,$county,$partner);
	}

	function get_patients($year=NULL,$month=NULL,$county=NULL,$partner=NULL,$to_year=NULL,$to_month=NULL)
	{
		
		$data['trends'] = $this->summaries_model->get_patients($year,$month,$county,$partner,$to_year,$to_month);
		$data['div_name'] = "unique_patients";

		$this->load->view('longitudinal_view',$data);
	}

	function current_suppression($county=NULL,$partner=NULL)
	{
		$data['outcomes'] = $this->summaries_model->current_suppression($county,$partner);
		$data['div_name'] = "suppression_pie";

    	$this->load->view('pie_chart_view',$data);
	}

	function current_age($type, $param_type=1, $param=NULL){
		$data['outcomes'] = $this->summaries_model->current_age_chart($type,$param_type,$param);		
    	$this->load->view('agegroup_view',$data);
	}

	function current_gender($type, $param_type=1, $param=NULL){
		$data['outcomes'] = $this->summaries_model->current_gender_chart($type,$param_type,$param);
    	$this->load->view('gender_view',$data);
	}

	/** 
	**Current listings sorted by county
	*/
	function county_listing(){
		$data['cont'] = $this->summaries_model->suppression_listings(1, 1, 0);
		$data['cont']['div'] = 'county_sup_listings';
		$data['cont']['title'] = 'County Listing';
		$data['cont']['table_div'] = 'county_sup_listings_table';

		$this->load->view('current_suppression_listing',$data);
	}

	function subcounty_listing($county=NULL){
		$data['cont'] = $this->summaries_model->suppression_listings(2, 1, $county);
		$data['cont']['div'] = 'subcounty_sup_listings';
		$data['cont']['title'] = 'Sub-County Listing';
		$data['cont']['table_div'] = 'subcounty_sup_listings_table';

		$this->load->view('current_suppression_listing',$data);
	}

	function partner_listing($county=NULL){
		$data['cont'] = $this->summaries_model->suppression_listings(3, 1, $county);
		$data['cont']['div'] = 'partner_sup_listings';
		$data['cont']['title'] = 'Partner Listing';
		$data['cont']['table_div'] = 'partner_sup_listings_table';

		$this->load->view('current_suppression_listing',$data);
	}

	function site_listing($county=NULL){
		$data['cont'] = $this->summaries_model->suppression_listings(4, 1, $county);
		$data['cont']['div'] = 'site_sup_listings';
		$data['cont']['title'] = 'Facility Listing';
		$data['cont']['table_div'] = 'site_sup_listings_table';

		$this->load->view('current_suppression_listing',$data);
	}

	/** 
	**Current listings sorted by partner
	*/
	function county_listing_partner($partner=NULL){
		$data['cont'] = $this->summaries_model->suppression_listings(1, 3, $partner);
		$data['cont']['div'] = 'county_sup_listings';
		$data['cont']['title'] = 'County Listing';
		$data['cont']['table_div'] = 'county_sup_listings_table';

		$this->load->view('current_suppression_listing',$data);
	}

	function subcounty_listing_partner($partner=NULL){
		$data['cont'] = $this->summaries_model->suppression_listings(2, 3, $partner);
		$data['cont']['div'] = 'subcounty_sup_listings';
		$data['cont']['title'] = 'Sub-County Listing';
		$data['cont']['table_div'] = 'subcounty_sup_listings_table';

		$this->load->view('current_suppression_listing',$data);
	}

	function partner_listing_partner(){
		$data['cont'] = $this->summaries_model->suppression_listings(3, 3, 1000);
		$data['cont']['div'] = 'partner_sup_listings';
		$data['cont']['title'] = 'Partner Listing';
		$data['cont']['table_div'] = 'partner_sup_listings_table';

		$this->load->view('current_suppression_listing',$data);
	}

	function site_listing_partner($partner=NULL){
		$data['cont'] = $this->summaries_model->suppression_listings(4, 3, $partner);
		$data['cont']['div'] = 'site_sup_listings';
		$data['cont']['title'] = 'Facility Listing';
		$data['cont']['table_div'] = 'site_sup_listings_table';

		$this->load->view('current_suppression_listing',$data);
	}




	/** 
	**Current age listings sorted by county (suppressed)
	*/
	function county_listing_age(){
		$data['cont'] = $this->summaries_model->suppression_age_listings(1, 1, 1, 0);
		$data['cont']['div'] = 'county_sup_listings_age';
		$data['cont']['title'] = 'County Listing Age';
		$data['cont']['table_div'] = 'county_sup_listings_table_age';

		$this->load->view('current_age_suppression_listing_sup',$data);
	}

	function subcounty_listing_age($county=NULL){
		$data['cont'] = $this->summaries_model->suppression_age_listings(1, 2, 1, $county);
		$data['cont']['div'] = 'subcounty_sup_listings_age';
		$data['cont']['title'] = 'Sub-County Listing Age';
		$data['cont']['table_div'] = 'subcounty_sup_listings_table_age';

		$this->load->view('current_age_suppression_listing_sup',$data);
	}

	function partner_listing_age($county=NULL){
		$data['cont'] = $this->summaries_model->suppression_age_listings(1, 3, 1, $county);
		$data['cont']['div'] = 'partner_sup_listings_age';
		$data['cont']['title'] = 'Partner Listing Age';
		$data['cont']['table_div'] = 'partner_sup_listings_table_age';

		$this->load->view('current_age_suppression_listing_sup',$data);
	}

	function site_listing_age($county=NULL){
		$data['cont'] = $this->summaries_model->suppression_age_listings(1, 4, 1, $county);
		$data['cont']['div'] = 'site_sup_listings_age';
		$data['cont']['title'] = 'Facility Listing Age';
		$data['cont']['table_div'] = 'site_sup_listings_table_age';

		$this->load->view('current_age_suppression_listing_sup',$data);
	}

	/** 
	**Current age listings sorted by county (non suppressed)
	*/

	function county_listing_age_n(){
		$data['cont'] = $this->summaries_model->suppression_age_listings(0, 1, 1, 0);
		$data['cont']['div'] = 'county_sup_listings_age_n';
		$data['cont']['title'] = 'County Listing Age Non Suppressed';
		$data['cont']['table_div'] = 'county_sup_listings_table_age_n';

		$this->load->view('current_age_suppression_listing',$data);
	}

	function subcounty_listing_age_n($county=NULL){
		$data['cont'] = $this->summaries_model->suppression_age_listings(0, 2, 1, $county);
		$data['cont']['div'] = 'subcounty_sup_listings_age_n';
		$data['cont']['title'] = 'Sub-County Listing Age Non Suppressed';
		$data['cont']['table_div'] = 'subcounty_sup_listings_table_age_n';

		$this->load->view('current_age_suppression_listing',$data);
	}

	function partner_listing_age_n($county=NULL){
		$data['cont'] = $this->summaries_model->suppression_age_listings(0, 3, 1, $county);
		$data['cont']['div'] = 'partner_sup_listings_age_n';
		$data['cont']['title'] = 'Partner Listing Age Non Suppressed';
		$data['cont']['table_div'] = 'partner_sup_listings_table_age_n';

		$this->load->view('current_age_suppression_listing',$data);
	}

	function site_listing_age_n($county=NULL){
		$data['cont'] = $this->summaries_model->suppression_age_listings(0, 4, 1, $county);
		$data['cont']['div'] = 'site_sup_listings_age_n';
		$data['cont']['title'] = 'Facility Listing Age Non Suppressed';
		$data['cont']['table_div'] = 'site_sup_listings_table_age_n';

		$this->load->view('current_age_suppression_listing',$data);
	}


	/** 
	**Current age listings sorted by partner (suppressed)
	*/
	function county_listing_partner_age($partner=NULL){
		$data['cont'] = $this->summaries_model->suppression_age_listings(1, 1, 3, $partner);
		$data['cont']['div'] = 'county_sup_listings_age';
		$data['cont']['title'] = 'County Listing Age Suppressed';
		$data['cont']['table_div'] = 'county_sup_listings_table_age';

		$this->load->view('current_age_suppression_listing_sup',$data);
	}

	function subcounty_listing_partner_age($partner=NULL){
		$data['cont'] = $this->summaries_model->suppression_age_listings(1, 2, 3, $partner);
		$data['cont']['div'] = 'subcounty_sup_listings_age';
		$data['cont']['title'] = 'Sub-County Listing Age Suppressed';
		$data['cont']['table_div'] = 'subcounty_sup_listings_table_age';

		$this->load->view('current_age_suppression_listing_sup',$data);
	}

	function partner_listing_partner_age(){
		$data['cont'] = $this->summaries_model->suppression_age_listings(1, 3, 3, 1000);
		$data['cont']['div'] = 'partner_sup_listings_age';
		$data['cont']['title'] = 'Partner Listing Age Suppressed';
		$data['cont']['table_div'] = 'partner_sup_listings_table_age';

		$this->load->view('current_age_suppression_listing_sup',$data);
	}

	function site_listing_partner_age($partner=NULL){
		$data['cont'] = $this->summaries_model->suppression_age_listings(1, 4, 3, $partner);
		$data['cont']['div'] = 'site_sup_listings_age';
		$data['cont']['title'] = 'Facility Listing Age Suppressed';
		$data['cont']['table_div'] = 'site_sup_listings_table_age';

		$this->load->view('current_age_suppression_listing_sup',$data);
	}

	/** 
	**Current age listings sorted by partner (non suppressed)
	*/
	function county_listing_partner_age_n($partner=NULL){
		$data['cont'] = $this->summaries_model->suppression_age_listings(0, 1, 3, $partner);
		$data['cont']['div'] = 'county_sup_listings_age_n';
		$data['cont']['title'] = 'County Listing Age Non Suppressed';
		$data['cont']['table_div'] = 'county_sup_listings_table_age_n';

		$this->load->view('current_age_suppression_listing',$data);
	}

	function subcounty_listing_partner_age_n($partner=NULL){
		$data['cont'] = $this->summaries_model->suppression_age_listings(0, 2, 3, $partner);
		$data['cont']['div'] = 'subcounty_sup_listings_age_n';
		$data['cont']['title'] = 'Sub-County Listing Age Non Suppressed';
		$data['cont']['table_div'] = 'subcounty_sup_listings_table_age_n';

		$this->load->view('current_age_suppression_listing',$data);
	}

	function partner_listing_partner_age_n(){
		$data['cont'] = $this->summaries_model->suppression_age_listings(0, 3, 3, 1000);
		$data['cont']['div'] = 'partner_sup_listings_age_n';
		$data['cont']['title'] = 'Partner Listing Age Non Suppressed';
		$data['cont']['table_div'] = 'partner_sup_listings_table_age_n';

		$this->load->view('current_age_suppression_listing',$data);
	}

	function site_listing_partner_age_n($partner=NULL){
		$data['cont'] = $this->summaries_model->suppression_age_listings(0, 4, 3, $partner);
		$data['cont']['div'] = 'site_sup_listings_age_n';
		$data['cont']['title'] = 'Facility Listing Age Non Suppressed';
		$data['cont']['table_div'] = 'site_sup_listings_table_age_n';

		$this->load->view('current_age_suppression_listing',$data);
	}




	/** 
	**Current gender listings sorted by county
	*/
	function county_listing_gender(){
		$data['cont'] = $this->summaries_model->suppression_gender_listings(1, 1, 0);
		$data['cont']['div'] = 'county_sup_listings_gender';
		$data['cont']['title'] = 'County Listing Gender';
		$data['cont']['table_div'] = 'county_sup_listings_table_gender';

		$this->load->view('current_gender_suppression_listing',$data);
	}

	function subcounty_listing_gender($county=NULL){
		$data['cont'] = $this->summaries_model->suppression_gender_listings(2, 1, $county);
		$data['cont']['div'] = 'subcounty_sup_listings_gender';
		$data['cont']['title'] = 'Sub-County Listing Gender';
		$data['cont']['table_div'] = 'subcounty_sup_listings_table_gender';

		$this->load->view('current_gender_suppression_listing',$data);
	}

	function partner_listing_gender($county=NULL){
		$data['cont'] = $this->summaries_model->suppression_gender_listings(3, 1, $county);
		$data['cont']['div'] = 'partner_sup_listings_gender';
		$data['cont']['title'] = 'Partner Listing Gender';
		$data['cont']['table_div'] = 'partner_sup_listings_table_gender';

		$this->load->view('current_gender_suppression_listing',$data);
	}

	function site_listing_gender($county=NULL){
		$data['cont'] = $this->summaries_model->suppression_gender_listings(4, 1, $county);
		$data['cont']['div'] = 'site_sup_listings_gender';
		$data['cont']['title'] = 'Facility Listing Gender';
		$data['cont']['table_div'] = 'site_sup_listings_table_gender';

		$this->load->view('current_gender_suppression_listing',$data);
	}

	/** 
	**Current gender listings sorted by partner
	*/
	function county_listing_partner_gender($partner=NULL){
		$data['cont'] = $this->summaries_model->suppression_gender_listings(1, 3, $partner);
		$data['cont']['div'] = 'county_sup_listings_gender';
		$data['cont']['title'] = 'County Listing Gender';
		$data['cont']['table_div'] = 'county_sup_listings_table_gender';

		$this->load->view('current_gender_suppression_listing',$data);
	}

	function subcounty_listing_partner_gender($partner=NULL){
		$data['cont'] = $this->summaries_model->suppression_gender_listings(2, 3, $partner);
		$data['cont']['div'] = 'subcounty_sup_listings_gender';
		$data['cont']['title'] = 'Sub-County Listing Gender';
		$data['cont']['table_div'] = 'subcounty_sup_listings_table_gender';

		$this->load->view('current_gender_suppression_listing',$data);
	}

	function partner_listing_partner_gender(){
		$data['cont'] = $this->summaries_model->suppression_gender_listings(3, 3, 1000);
		$data['cont']['div'] = 'partner_sup_listings_gender';
		$data['cont']['title'] = 'Partner Listing Gender';
		$data['cont']['table_div'] = 'partner_sup_listings_table_gender';

		$this->load->view('current_gender_suppression_listing',$data);
	}

	function site_listing_partner_gender($partner=NULL){
		$data['cont'] = $this->summaries_model->suppression_gender_listings(4, 3, $partner);
		$data['cont']['div'] = 'site_sup_listings_gender';
		$data['cont']['title'] = 'Facility Listing Gender';
		$data['cont']['table_div'] = 'site_sup_listings_table_gender';

		$this->load->view('current_gender_suppression_listing',$data);
	}





	

	function display_date()
	{
		echo "(".$this->session->userdata('filter_year')." ".$this->summaries_model->resolve_month($this->session->userdata('filter_month')).")";
	}

	function display_range()
	{
		echo "(".($this->session->userdata('filter_year')-1)." - ".$this->session->userdata('filter_year').")";
	}

}
?>