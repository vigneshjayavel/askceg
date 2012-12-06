<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestController extends CI_Controller {

	function index(){

		$this->load->view('TestView');

	}

	function dbTest(){

		$sql='insert into dummy values(1,"vvv")';
		$query=$this->db->query($sql);
		$i=1;
		echo $query;
		/*if( $row=$query->row_array() ){

			echo $i.' '.$row['name'].' '.$row['id']."\n";
			$i++;

		}*/
	}

	function test(){
		$this->load->model('searchmodel');
		$temp=$this->searchmodel->sqlReturnSearchResult('ibatch');

		echo $temp;
	}

}