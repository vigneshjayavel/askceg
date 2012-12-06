<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AjaxSearchController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
			
	}

	public function getData(){
			
		$jsonObj= array(
		array("resultData"=>"What is php?","resultType"=>"Question","targetURL"=>"AjaxSearchController/getData"),
		array("resultData"=>"why is vishnu so gay?","resultType"=>"Question","targetURL"=>"AjaxSearchController/getData"),
		array("resultData"=>"why is vikki so gay?","resultType"=>"Question","targetURL"=>"AjaxSearchController/getData"),
		array("resultData"=>"why is vishnuJayvel so gay?","resultType"=>"Question","targetURL"=>"AjaxSearchController/getData"),
		array("resultData"=>"ibatch site sucks","resultType"=>"Category","targetURL"=>"AjaxSearchController/getData"),
		array("resultData"=>"we hate ROS","resultType"=>"Topic","targetURL"=>"AjaxSearchController/getData"),
				);
		echo json_encode($jsonObj);
	}

}
