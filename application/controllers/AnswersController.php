<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AnswersController extends CI_Controller {

	public $data=array();

	public function __construct()
	{
	        parent::__construct();
			$this->data['page']="answers";
	}
		
	function index()
	{
		$this->load->view('AnswerQuestionView');
		
	}

	function viewAnswersForQuestion($q_id){

		$this->load->model('AnswersModel');
		$this->load->model('QuestionsModel');
		$this->QuestionsModel->sqlUpdateViewCount($q_id);
		$curr_id=$this->session->userdata('user_id');
		$this->data['centerContent']=$this->AnswersModel->sqlReadAnswers($q_id,$curr_id);
		$this->load->view('Skeleton',$this->data);
	}

	function postAnswerForQuestionToDb(){

		$posted_by=$this->session->userdata('user_name');
		//$posted_by="hello";
		$answerObj=$this->input->post('answerObj');
		$this->load->model('AnswersModel');

		$response=$this->AnswersModel->sqlCreateAnswer($answerObj,$posted_by);
		echo $response;
	}


	
}
