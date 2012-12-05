<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AjaxSearchController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
			
	}

	public function getData(){
			
		$jsonObj= array(
		array("searchTerm"=>"What is php?","searchType"=>"Question","targetURL"=>"AjaxSearchController/getData"),
		array("searchTerm"=>"why is vishnu so gay?","searchType"=>"Question","targetURL"=>"AjaxSearchController/getData"),
		array("searchTerm"=>"why is vikki so gay?","searchType"=>"Question","targetURL"=>"AjaxSearchController/getData"),
		array("searchTerm"=>"why is vishnuJayvel so gay?","searchType"=>"Question","targetURL"=>"AjaxSearchController/getData"),
		array("searchTerm"=>"ibatch site sucks","searchType"=>"Category","targetURL"=>"AjaxSearchController/getData"),
		array("searchTerm"=>"we hate ROS","searchType"=>"Topic","targetURL"=>"AjaxSearchController/getData"),
				);
		echo json_encode($jsonObj);
	}

}
