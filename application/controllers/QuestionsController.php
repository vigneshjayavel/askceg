<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class QuestionsController extends CI_Controller {

	public $data=array();

	public function __construct()
	{
	        parent::__construct();
			$this->data['page']="questions";
	}
	
	function index()
	{

		$this->load->model('QuestionsModel');
		$this->data['centerContent']=$this->QuestionsModel->getCenterContent();
		$this->load->view('Skeleton',$this->data);
		
	}
	function followQuestion($q_id){
		
		$redirectUrl=$this->input->get('redirectUrl');
		$posted_by=$this->session->userdata('user_name');
		$this->load->model('QuestionsModel');
		$this->QuestionsModel->sqlCreateFollower($q_id,$posted_by);
		//$this->load->view('Skeleton',$this->data);
		redirect(urldecode($redirectUrl));
	
	}
	function unfollowQuestion($q_id){
		
		$redirectUrl=$this->input->get('redirectUrl');
		$posted_by=$this->session->userdata('user_name');
		$this->load->model('QuestionsModel');
		$this->QuestionsModel->sqlDeleteFollower($q_id,$posted_by);
		//$this->load->view('Skeleton',$this->data);
		redirect(urldecode($redirectUrl));
	
	}
	function viewQuestion($category_id=null,$topic_id=null,$q_id=null){
		
		//equivalent to $_SESSION['logged_in']
	    if ($this->session->userdata('logged_in') == TRUE)
	    {
	    	//redirect to some page if logged in
	       // redirect('HomeController');
	    	echo "hello".$this->session->userdata('user_name');
	    }$this->load->model('QuestionsModel');
		$this->data['centerContent']=$this->QuestionsModel->sqlReadQuestions($category_id,$topic_id,$q_id);
		$this->load->view('Skeleton',$this->data);
	}

	function AskQuestion(){
		$this->load->model('QuestionsModel');
		$this->data['centerContent']=$this->QuestionsModel->getCenterContentAskQuestion();
		$this->load->view('Skeleton',$this->data);
		

	}

	function AnswerQuestion(){

		$this->load->model('QuestionsModel');
		$this->data['centerContent']=$this->QuestionsModel->sqlReadQuestions();
		$this->load->view('Skeleton',$this->data);
		
	}

	function CreateDiscussion(){

		$this->load->model('QuestionsModel');
		$this->data['centerContent']=$this->QuestionsModel->getCenterContentCreateDiscussion();
		$this->load->view('Skeleton',$this->data);

	}

	function Education($topic_id=null)
	{
		$this->load->model('QuestionsModel');
		$this->data['centerContent']=$this->QuestionsModel->sqlReadQuestions('1',$topic_id,null);
		$this->load->view('Skeleton',$this->data);
	}
	function Entertainment($topic_id=null)
	{
		$this->load->model('QuestionsModel');
		$this->data['centerContent']=$this->QuestionsModel->sqlReadQuestions('2',$topic_id,null);
		$this->load->view('Skeleton',$this->data);
	}
	function Sports($topic_id=null)
	{
		$this->load->model('QuestionsModel');
		$this->data['centerContent']=$this->QuestionsModel->sqlReadQuestions('3',$topic_id,null);
		$this->load->view('Skeleton',$this->data);
	}
	function Technology($topic_id=null)
	{
		$this->load->model('QuestionsModel');
		$this->data['centerContent']=$this->QuestionsModel->sqlReadQuestions('4',$topic_id,null);
		$this->load->view('Skeleton',$this->data);
	}
	function Miscellaneous($topic_id=null)
	{
		$this->load->model('QuestionsModel');
		$this->data['centerContent']=$this->QuestionsModel->sqlReadQuestions('5',$topic_id,null);
		$this->load->view('Skeleton',$this->data);
	}


	function getAllQuestionsFromDb(){

		//load questions model
		$this->load->model('QuestionsModel');

		//get all questions using a func in that model
		$this->data['centerContent'] = $this->QuestionsModel->sqlReadQuestions();
		$this->load->view('Skeleton',$this->data);
	}

	function postQuestionToDb(){

		$questionObj=$this->input->post('questionObj');
		//load questions model

		$this->load->model('QuestionsModel');
		$posted_by=$this->session->userdata('user_name');

		//get all questions using a func in that model
		$content = $this->QuestionsModel->sqlCreateQuestion($questionObj,$posted_by);
		echo $content;	
	}

	function getTopicsInCategory($category)
	{
		$this->load->model('QuestionsModel');
		$content=$this->QuestionsModel->sqlGetTopicsInCategory($category);
		echo $content;
	} 
}
