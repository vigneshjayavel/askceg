<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProfileController extends CI_Controller {

	

	function index()
	{
		$this->load->model('profilemodel');
		$data['centerContent']=$this->profilemodel->getCenterContent();
		$this->load->view('spSkeleton',$data);
		
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
	
		}
		function EditProfile(){//for getting the edit profile page
			if ($this->session->userdata('logged_in') == TRUE)
		    {
					$this->load->model('profilemodel');
					$user_id=$this->session->userdata('user_id');
							if($this->profilemodel->isStudent($user_id)){

							$data['centerContent']=$this->profilemodel->getStudentProfileEdit($user_id);
							
							}
							else{
							$data['centerContent']=$this->profilemodel->getTeacherProfileEdit($user_id);
					
							}
			}
			else{
				$data['centerContent']="you havnt logged in yet!!";
			}
			$this->load->view('Skeleton',$data);
  
        }
        function EditStudentProfile(){//updating the user table
        $account['user_name']=$this->input->post('name');
	
		$account['user_email']=$this->input->post('email');
        

		$account['user_year']=$this->input->post('year');
		$account['user_degree']=$this->input->post('degree');
		$account['user_course']=$this->input->post('course');
		$group_id=$this->input->post('BatchSelectBox');
		$this->load->model('profilemodel');

	    $user_id=$this->session->userdata('user_id');
		//echo $account['user_name'];
		if($group_id!=$this->session->userdata('group_id')){

		$data['flag']=$this->profilemodel->sqlSendGroupRequest($group_id);
		}
		$data['centerContent']=$this->profilemodel->sqlEditStudentProfile($account,$user_id);

		if($data['centerContent']==1)//returns 1 if success
	     redirect('ProfileController/MyProfile');
	    else//returns error msg if failure
        $this->load->view('Skeleton',$data);
        
          }
     function cancelGroupRequest(){
     	$user_id=$this->session->userdata('user_id');

		$this->load->model('profilemodel');
		$data['flag']=$this->profilemodel->sqlCancelGroupRequest($user_id);
		if($data['flag']==1)
			  redirect('ProfileController/EditProfile');
			else
			  echo "something went wrong";

     }
	function ViewGroupProfile($group_id){
		$this->load->model('profilemodel');
		$this->load->model('questionsmodel');
		$data['centerContent']=$this->profilemodel->getGroupProfile($group_id);
		if($group_id==$this->session->userdata('group_id'))
		$data['centerContent'].=$this->questionsmodel->getGroupScopeQuestions($group_id);
		$this->load->view('Skeleton',$data);
	
	}
	function ViewMyYearProfile(){
		if ($this->session->userdata('logged_in') == TRUE)
	    {
		$this->load->model('authmodel');
		$year_id=$this->authmodel->getUserYearId($this->session->userdata('user_id'));
			if($year_id!=0)
				$this->ViewYearProfile($year_id);
			else{
				$this->data['centerContent']='You havnt specified your year yet!';

				$this->load->view('Skeleton',$this->data);
			}
      }

	    else{
	    	$this->load->model('profilemodel');
	    	$this->data['centerContent']='sorry you havnt logged in yet!!';
		$this->data['centerContent'].=$this->profilemodel->loginForm();

		$this->load->view('Skeleton',$this->data);
	   }

	}
	function ViewYearProfile($year_id){
		$this->load->model('profilemodel');
		$this->load->model('questionsmodel');
		$data['centerContent']=$this->profilemodel->getYearProfile($year_id);
	   	$data['paginationrequired']="false";
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
        
		$this->load->model('metamodel');
		$data['metaContent']=$this->metamodel->getMeta("normal",0);
	    
		$data['paginationrequired']="false";
	    if ($this->session->userdata('logged_in') == TRUE){
		$this->load->model('profilemodel');
		$this->load->model('questionsmodel');
	    if($this->profilemodel->isStudent($this->session->userdata('user_id'))==true){
	        
		
		$data['centerContent']=$this->profilemodel->getUserProfile($this->session->userdata('user_id'));
		$data['centerContent'].=$this->questionsmodel->getQuestionsAsked($this->session->userdata('user_id'));
		$data['centerContent'].=$this->questionsmodel->getQuestionsFollowed($this->session->userdata('user_id'));
		$data['centerContent'].=$this->questionsmodel->getQuestionsAnswered($this->session->userdata('user_id'));
		
		
		}
		else{
       $data['centerContent']=$this->profilemodel->getTeacherProfile($this->session->userdata('user_id'));
		$data['centerContent'].=$this->questionsmodel->getQuestionsAsked($this->session->userdata('user_id'));
		$data['centerContent'].=$this->questionsmodel->getQuestionsFollowed($this->session->userdata('user_id'));
		$data['centerContent'].=$this->questionsmodel->getQuestionsAnswered($this->session->userdata('user_id'));
		
		}
    }
    else{
    		$this->load->model('profilemodel');
	    	$data['centerContent']='sorry you havnt logged in yet!!';
			$data['centerContent'].=$this->profilemodel->loginForm();
	
	    
    }
     $this->load->view('Skeleton',$data);
	}
	function viewTopic($topic_url){
		$this->load->model('metamodel');
		$this->data['metaContent']=$this->metamodel->getMeta("topic",$topic_url);
		if ($this->session->userdata('logged_in') == TRUE)
	    {
	    $this->load->model('questionsmodel');
	    
	    $this->load->model('profilemodel');
		$this->data['centerContent']=$this->profilemodel->getTopicProfile($topic_url);
		$this->data['centerContent'].=$this->questionsmodel->sqlReadQuestions(null,$topic_url,null);
		$this->data['paginationrequired']="true";
		$this->data['paginationtype']="question";
		$this->data['topicUrl']=$topic_url;
	
	   }
	   else{
	   	$this->data['centerContent']='You have to login to view this page';
		
	   }

		$this->load->view('Skeleton',$this->data);
	}
	function viewCategory($category_url){
		
		//equivalent to $_SESSION['logged_in']
		$this->load->model('metamodel');
		$this->data['metaContent']=$this->metamodel->getMeta("normal",0);
	    if ($this->session->userdata('logged_in') == TRUE)
	    {
	    $this->load->model('questionsmodel');
	    $this->load->model('profilemodel');
	    $category_id=$this->profilemodel->sqlgetCategoryId($category_url);
	
		$this->data['centerContent']=$this->profilemodel->getCategoryProfile($category_id);
		$this->data['centerContent'].=$this->questionsmodel->sqlgetPromotedQuestions($category_id);
		$this->data['paginationrequired']="false";
		$this->load->view('Skeleton',$this->data);
	   }
	   else{
	    $this->load->model('profilemodel');
	    $this->data['centerContent']='sorry you havnt logged in yet!!';
		$this->data['centerContent'].=$this->profilemodel->loginForm();
		$this->load->view('Skeleton',$this->data);
	    
	    }
	}
	function EditTopicDesc($topic_id){

		$this->load->model('profilemodel');
		$data['centerContent']=$this->profilemodel->getEditTopicDescMarkUp($topic_id);
		$this->load->view('Skeleton',$data);


	}
    function UpdateTopicDesc($topic_id){
    	$this->load->model('profilemodel');
    	$topicDesc=$this->input->post('topicDesc');
        $data['centerContent']=$this->profilemodel->sqlUpdateTopicDesc($topic_id,$topicDesc);
		$this->load->view('Skeleton',$data);

    }
	

	function MyGroup()
	{
		if ($this->session->userdata('logged_in') == TRUE){
				$this->load->model('profilemodel');
				$this->load->model('questionsmodel');
				$data['centerContent']=$this->profilemodel->getCenterContentMyGroup();
				$group_id=$this->profilemodel->getGroupId($this->session->userdata('group_id'));
				if($group_id!=0||$group_id!=''||$group_id!=null){
				$data['centerContent'].=$this->questionsmodel->sqlReadQuestions(null,null,null,"true");
				}
				else
		        $data['centerContent'].=":(";
				$data['paginationrequired']="true";
				$data['paginationtype']="question";
				$data['groupScope']="true";
				$this->load->view('Skeleton',$data);
		}
		else{
				$this->load->model('profilemodel');
			    $this->data['centerContent']='sorry you havnt logged in yet!!';
				$this->data['centerContent'].=$this->profilemodel->loginForm();
				$this->load->view('Skeleton',$this->data);
		    
		}
	}
	function MyYear()
	{   if ($this->session->userdata('logged_in') == TRUE)
	    {
		$this->load->model('profilemodel');
		$this->load->model('questionsmodel');
		$data['centerContent']=$this->profilemodel->getCenterContentMyYear();
			//$data['centerContent'].=$this->questionsmodel->getYearScopeQuestions();
		$this->data['paginationrequired']="false";
		$this->load->view('Skeleton',$data);
		}
		else
		{
		$this->load->model('profilemodel');
	    $this->data['centerContent']='sorry you havnt logged in yet!!';
		$this->data['centerContent'].=$this->profilemodel->loginForm();
		$this->load->view('Skeleton',$this->data);
	    
		}
	}
	function AccountSettings()
	{
		$this->load->view('AccountSettingsView');
	}
}
