<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestController extends CI_Controller {

	function index(){

		$this->load->view('TestView');

	}

	function dbTest(){

		echo "<style>
.divLast 
{
   top: 0px;
   margin:0px;  
   padding: 0px 2px 2px 3px;    
   border-width: 2px;
   border-bottom: 2px white solid;
   width: 100%;
}
</style>
<div class='divLast'>
   test element with white border bottom
</div>";
	}

	function test(){
		$this->load->view('TestView');
	}

}