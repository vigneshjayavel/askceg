<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestController extends CI_Controller {

	function index(){

		$this->load->view('TestView');

	}

	function dbTest($startIndex=null,$endIndex=null){

		if($startIndex==null && $endIndex==null){
			$sql = "SELECT 
			q.q_id,q.q_content
			FROM
			QUESTION q
			LIMIT 0,20";
		}
		else{
			$sql = "SELECT 
			q.q_id,q.q_content
			FROM
			QUESTION q
			LIMIT $startIndex,$endIndex ";
		}


		$query=$this->db->query($sql);
		$result='';
		$resultSet=$query->result_array();
		foreach($resultSet as $row){
			$result.='<div>'.$row['q_content'].'</div>';
		}
		echo $result;

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
	function time(){
		 $date = new DateTime(date('Y-m-d H:i:s AM'), new DateTimeZone('GMT'));
$date->setTimezone(new DateTimeZone('IST'));

echo $date->format('Y-m-d H:i:s');
}


}