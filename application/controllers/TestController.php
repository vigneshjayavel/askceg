<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestController extends CI_Controller {

	function index(){

		$this->load->view('TestView');

	}
	public function api_getQuestionsMarkup(){ 
		$this->load->model('questionsmodel');
		$set=$this->input->post('set');
		$query = $this->questionsmodel->sqlReadQuestions(null,null,null,null,$set); 
		
		$resultLength=count($query);
		if($resultLength!=0){
			echo json_encode(array("data"=>$query));
		}
		else{
			echo null;
		}	 
	} 


	public function view(){
		$this->load->model('questionsmodel');
		
		$data['centerContent']=$this->questionsmodel->sqlReadQuestions(null,null,null,null,null);
		$this->load->view('Skeleton',$data);
	}

	function test(){
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



function print123($qid){
	$this->load->model('questionsmodel');
		$data['centerContent']=$this->questionsmodel->printanswer($qid);
		$this->load->view('Skeleton',$this->data);


}


}