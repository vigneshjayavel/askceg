<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ValidationController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
			
	}

	public function checkExistence(){
		
		$data=$this->input->post('dataObj');
		$data=json_decode($data,TRUE);
		$content=$data['content'];
		$type=$data['type'];
		$result=null;
		if($content=='What is Askceg?')
			$result='yes';
		else
			$result='no';
		$jsonObj= json_encode(array("result"=>$result));
		echo $jsonObj;
	}

	public function test(){
		
		$data=$this->input->post('dataObj');
		$data=json_decode($data,TRUE);
		$content=$data['content'];
		$type=$data['type'];

		$jsonObj= json_encode(array("content"=>$content,"type"=>$type));
		echo $jsonObj;
	}

}
