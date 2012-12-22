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

		$this->load->model('questionsmodel');
		$this->data['centerContent']=$this->questionsmodel->getCenterContent();
		$this->load->view('Skeleton',$this->data);
		
	}
	function Topic($topic_id){
       $this->load->model('questionsmodel');
		$this->data['centerContent']=$this->questionsmodel->getTopicPage($topic_id);
		$this->load->view('Skeleton',$this->data);
		


	}
	function followQuestion($q_id){
		
		$redirectUrl=$this->input->get('redirectUrl');
		$posted_by=$this->session->userdata('user_id');
		$this->load->model('questionsmodel');
		$this->questionsmodel->sqlCreateFollower($q_id,$posted_by);
		//$this->load->view('Skeleton',$this->data);
		redirect(urldecode($redirectUrl));
	
	}
	function followTopic($topic_id){
		
		$redirectUrl=$this->input->get('redirectUrl');
		$posted_by=$this->session->userdata('user_id');
		$this->load->model('questionsmodel');
		$this->questionsmodel->sqlCreateFollowerTopic($topic_id,$posted_by);
		//$this->load->view('Skeleton',$this->data);
		redirect(urldecode($redirectUrl));
	
	}
	function unfollowQuestion($q_id){
		
		$redirectUrl=$this->input->get('redirectUrl');
		$posted_by=$this->session->userdata('user_id');
		$this->load->model('questionsmodel');
		$this->questionsmodel->sqlDeleteFollower($q_id,$posted_by);
		//$this->load->view('Skeleton',$this->data);
		redirect(urldecode($redirectUrl));
	
	}
	function unfollowTopic($topic_id){
		
		$redirectUrl=$this->input->get('redirectUrl');
		$posted_by=$this->session->userdata('user_id');
		$this->load->model('questionsmodel');
		$this->questionsmodel->sqlDeleteFollowerTopic($topic_id,$posted_by);
		//$this->load->view('Skeleton',$this->data);
		redirect(urldecode($redirectUrl));
	
	}
	function viewQuestion($category_id=null,$topic_id=null,$q_id=null){
		
		//equivalent to $_SESSION['logged_in']
	    if ($this->session->userdata('logged_in') == TRUE)
	    {
	    	//redirect to some page if logged in
	       // redirect('HomeController');
	    $this->load->model('questionsmodel');
		$this->data['centerContent']=$this->questionsmodel->sqlReadQuestions($category_id,$topic_id,$q_id);
		$this->load->view('Skeleton',$this->data);
	    }
	}
	function viewTopics($category_id=null){
		
		//equivalent to $_SESSION['logged_in']
	    if ($this->session->userdata('logged_in') == TRUE)
	    {
	    	//redirect to some page if logged in
	       // redirect('HomeController');
	    $this->load->model('questionsmodel');
		$this->data['centerContent']=$this->questionsmodel->sqlgetTopicsInCategory($category_id);
		$this->load->view('Skeleton',$this->data);
	    }
	}
	
	function AskQuestion(){
		$this->load->model('questionsmodel');
		$this->data['centerContent']=$this->questionsmodel->getCenterContentAskQuestion();
		$this->load->view('Skeleton',$this->data);
		

	}
	

	function AnswerQuestion(){

		$this->load->model('questionsmodel');
		$this->data['centerContent']=$this->questionsmodel->sqlReadQuestions();
		$this->load->view('Skeleton',$this->data);
		
	}
	function DeleteQuestion($q_id){

		$this->load->model('questionsmodel');
		$this->data['centerContent']=$this->questionsmodel->sqlDeleteQuestions($q_id);
		$this->load->view('Skeleton',$this->data);
		
	}

	function CreateDiscussion(){
		$this->data['page']="createDiscussionPage";
		$this->load->model('questionsmodel');
		$this->data['centerContent']=$this->questionsmodel->getCenterContentCreateDiscussion();
		$this->load->view('Skeleton',$this->data);

	}

	function Education($topic_id=null)
	{
		$this->load->model('questionsmodel');
		$this->data['centerContent']=$this->questionsmodel->sqlReadQuestions('1',$topic_id,null);
		$this->load->view('Skeleton',$this->data);
	}
	function Entertainment($topic_id=null)
	{
		$this->load->model('questionsmodel');
		$this->data['centerContent']=$this->questionsmodel->sqlReadQuestions('2',$topic_id,null);
		$this->load->view('Skeleton',$this->data);
	}
	function Sports($topic_id=null)
	{
		$this->load->model('questionsmodel');
		$this->data['centerContent']=$this->questionsmodel->sqlReadQuestions('3',$topic_id,null);
		$this->load->view('Skeleton',$this->data);
	}
	function Technology($topic_id=null)
	{
		$this->load->model('questionsmodel');
		$this->data['centerContent']=$this->questionsmodel->sqlReadQuestions('4',$topic_id,null);
		$this->load->view('Skeleton',$this->data);
	}
	function Miscellaneous($topic_id=null)
	{
		$this->load->model('questionsmodel');
		$this->data['centerContent']=$this->questionsmodel->sqlReadQuestions('5',$topic_id,null);
		$this->load->view('Skeleton',$this->data);
	}


	function getAllQuestionsFromDb(){

		//load questions model
		$this->load->model('questionsmodel');

		//get all questions using a func in that model
		$this->data['centerContent'] = $this->questionsmodel->sqlReadQuestions();
		$this->load->view('Skeleton',$this->data);
	}

	function postQuestionToDb(){

		$questionObj=$this->input->post('questionObj');
		//load questions model

		$this->load->model('questionsmodel');
		$posted_by=$this->session->userdata('user_id');

		//get all questions using a func in that model
		$content = $this->questionsmodel->sqlCreateQuestion($questionObj,$posted_by);
		echo $content;	
	}
    
	function postTopicToDb(){

		$topicObj=$this->input->post('topicObj');
		//load questions model

		$this->load->model('questionsmodel');
		$posted_by=$this->session->userdata('user_id');

		//get all questions using a func in that model
		$content = $this->questionsmodel->sqlCreateTopic($topicObj,$posted_by);
		echo $content;	
	}
	function getTopicsInCategory($category)
	{
		$this->load->model('questionsmodel');
		$content=$this->questionsmodel->sqlGetTopicsInCategory1($category);
		echo $content;
	} 
}
