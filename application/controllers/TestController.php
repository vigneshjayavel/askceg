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

	function testSession(){
		$this->load->model('authmodel');
		$temp=$this->session->userdata('group_id');

		echo $temp;
	}

}