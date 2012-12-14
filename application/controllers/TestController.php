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




}