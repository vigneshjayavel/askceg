<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestController extends CI_Controller {

	function index(){

		$this->load->view('TestView');

	}

	function dbTest(){

		echo '';
	}

	function test(){
		$this->load->view('TestView');
	}
   	
   	function convert(){
		$this->load->model('questionsmodel');
		$data['centerContent']=$this->questionsmodel->convert();
		$this->load->view('Skeleton',$this->data);
	}

	function testData($q_id){
		echo "This is test!! ".$q_id;
	}


}