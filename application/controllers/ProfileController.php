<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProfileController extends CI_Controller {

	

	function index()
	{
		$this->load->model('profilemodel');
		$data['centerContent']=$this->profilemodel->getCenterContent();
		$this->load->view('Skeleton',$data);
		
	}
	function ViewUserProfile($user_id){
		$this->load->model('profilemodel');
		$this->load->model('questionsmodel');
		if($this->profilemodel->isStudent($user_id)==true){
	           
		$data['centerContent']=$this->profilemodel->getUserProfile($user_id);
		$data['centerContent'].=$this->questionsmodel->getQuestionsAsked($user_id);
		$data['centerContent'].=$this->questionsmodel->getQuestionsFollowed($user_id);
		$data['centerContent'].=$this->questionsmodel->getQuestionsAnswered($user_id);
		$this->load->view('Skeleton',$data);
	    }
	    else{


	    $data['centerContent']=$this->profilemodel->getTeacherProfile($user_id);
	    $data['centerContent'].=$this->questionsmodel->getQuestionsAsked($user_id);
	    $data['centerContent'].=$this->questionsmodel->getQuestionsFollowed($user_id);
	    $data['centerContent'].=$this->questionsmodel->getQuestionsAnswered($user_id);
	    $data['centerContent'].=$this->questionsmodel->getQuestionsAskedToTeacher($user_id);
	    $this->load->view('Skeleton',$data);
	  }
	
<<<<<<< HEAD
		}
		function EditProfile(){
	    $this->load->model('profilemodel');
	    $user_id=$this->session->userdata('user_id');
	if($this->profilemodel->isStudent($user_id)){
	
		$data['centerContent']=$this->profilemodel->getStudentProfileEdit($user_id);
		$this->load->view('Skeleton',$data);
	}
	else{
		$data['centerContent']=$this->profilemodel->getTeacherProfileEdit($user_id);
		$this->load->view('Skeleton',$data);
	}
}
		function ViewGroupProfile($group_id){
			$this->load->model('profilemodel');
			$this->load->model('questionsmodel');
=======
	}
	function EditStudentProfile()
	{   $user_id=$this->session->userdata('user_id');
		$this->load->model('profilemodel');
		$data['centerContent']=$this->profilemodel->getCenterContentMyProfileEdit($user_id);
		$this->load->view('Skeleton',$data);
	}
	function ViewGroupProfile($group_id){
		$this->load->model('profilemodel');
		$this->load->model('questionsmodel');
>>>>>>> 980e5a90e611bd5efdd71700cb08258d5b20a207
		$data['centerContent']=$this->profilemodel->getGroupProfile($group_id);
		$data['centerContent'].=$this->questionsmodel->getGroupScopeQuestions();
		$this->load->view('Skeleton',$data);
	
	}
	function ViewMyYearProfile(){
		$this->load->model('authmodel');
		$year_id=$this->authmodel->getUserYearId($this->session->userdata('user_id'));
		$this->ViewYearProfile($year_id);

	}
	function ViewYearProfile($year_id){
		$this->load->model('profilemodel');
		$this->load->model('questionsmodel');
		$data['centerContent']=$this->profilemodel->getYearProfile($year_id);
	   	// $data['centerContent'].=$this->questionsmodel->getYearScopeQuestions($year_id);
		$this->load->view('Skeleton',$data);

	}
	function ViewInterimProfile(){
		$this->load->model('profilemodel');
		$this->load->model('questionsmodel');
		$data['centerContent']=$this->profilemodel->getInterimProfile();
	    $data['centerContent'].=$this->questionsmodel->getGlobalScopeQuestions();
		$this->load->view('Skeleton',$data);

	}
	function ViewAdminPrivileges(){
		$this->load->model('profilemodel');
		$data['centerContent']=$this->profilemodel->getAdminPrivileges();
		$this->load->view('Skeleton',$data);

	}
	function MyProfile()
	{
		$this->load->model('profilemodel');
		$this->load->model('questionsmodel');
	    if($this->profilemodel->isStudent($this->session->userdata('user_id'))==true){
	        
		
		$data['centerContent']=$this->profilemodel->getUserProfile($this->session->userdata('user_id'));
		$data['centerContent'].=$this->questionsmodel->getQuestionsAsked($this->session->userdata('user_id'));
		$data['centerContent'].=$this->questionsmodel->getQuestionsFollowed($this->session->userdata('user_id'));
		$data['centerContent'].=$this->questionsmodel->getQuestionsAnswered($this->session->userdata('user_id'));
		$this->load->view('Skeleton',$data);}
		else{
       $data['centerContent']=$this->profilemodel->getTeacherProfile($this->session->userdata('user_id'));
		$data['centerContent'].=$this->questionsmodel->getQuestionsAsked($this->session->userdata('user_id'));
		$data['centerContent'].=$this->questionsmodel->getQuestionsFollowed($this->session->userdata('user_id'));
		$data['centerContent'].=$this->questionsmodel->getQuestionsAnswered($this->session->userdata('user_id'));
		$this->load->view('Skeleton',$data);}
		


	}
	function viewTopic($topic_url){
		
	    if ($this->session->userdata('logged_in') == TRUE)
	    {
	    $this->load->model('questionsmodel');
	    $this->load->model('profilemodel');
		$this->data['centerContent']=$this->profilemodel->getTopicProfile($topic_url);
		$this->data['centerContent'].=$this->questionsmodel->sqlReadQuestions(null,$topic_url,null);
		$this->load->view('Skeleton',$this->data);
	   }
	}
	function viewCategory($category_url){
		
		//equivalent to $_SESSION['logged_in']
	    if ($this->session->userdata('logged_in') == TRUE)
	    {
	    $this->load->model('questionsmodel');
	    $this->load->model('profilemodel');
	    $category_id=$this->profilemodel->sqlgetCategoryId($category_url);
	
		$this->data['centerContent']=$this->profilemodel->getCategoryProfile($category_id);
		$this->data['centerContent'].=$this->questionsmodel->sqlgetPromotedQuestions($category_id);
		$this->load->view('Skeleton',$this->data);
	   }
	}
	function EditTopicDesc($topic_id){

		$this->load->model('profilemodel');
		$data['centerContent']=$this->profilemodel->EditTopicDesc($topic_id);
		$this->load->view('Skeleton',$data);


	}

	function editTopicDescAgain($topic_id)
	{
		$topicDesc['topic_desc']=$this->input->post('editTopicDesc');
		$this->load->model('profilemodel');
		$data['centerContent']=$this->profilemodel->editTopicDescAgain($topicDesc['topic_desc'],$topic_id);
		$this->load->view('Skeleton',$data);

	}
	function EditCategoryDesc($category_id){

		$this->load->model('profilemodel');
		$data['centerContent']=$this->profilemodel->EditCategoryDesc($category_id);
		$this->load->view('Skeleton',$data);


	}

	function MyGroup()
	{
		$this->load->model('profilemodel');
		$this->load->model('questionsmodel');
		$data['centerContent']=$this->profilemodel->getCenterContentMyGroup();
		$data['centerContent'].=$this->questionsmodel->sqlReadQuestions(null,null,null,true);
		$this->load->view('Skeleton',$data);
	}
	function MyYear()
	{
		$this->load->model('profilemodel');
		$this->load->model('questionsmodel');
		$data['centerContent']=$this->profilemodel->getCenterContentMyYear();
			//$data['centerContent'].=$this->questionsmodel->getYearScopeQuestions();
		$this->load->view('Skeleton',$data);
	}
	function AccountSettings()
	{
		$this->load->view('AccountSettingsView');
	}
}
