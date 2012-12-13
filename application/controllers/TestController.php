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


	function testRegex(){
		$str="What is Askceg?";
		echo "before : ".$str;
		$str = trim($str, '-');
		$str = preg_replace('/[^A-Za-z0-9]+/', '-', $str);
		echo "<br>after : ".$str;
	}
}