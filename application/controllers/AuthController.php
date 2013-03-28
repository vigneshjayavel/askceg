<?php
class AuthController extends CI_Controller {

	function AuthController()
	{
		parent::__construct();	
	}
	
	function index()
	{
		/*
			NOTE: pls load sessions library in autoload.php
			u shud have something like this
			$autoload['libraries'] = array('session');
		*/

		//equivalent to $_SESSION['logged_in']
	    if ($this->session->userdata('logged_in') == TRUE)
	    {
	    	//redirect to some page if logged in
	        redirect('HomeController');
	    	
	    }
	    else
	    //ignore the rest of the func
	    {
        
		$this->load->model('metamodel');
       	$data['metaContent']=$this->metamodel->getmeta("normal");
		$this->load->model('profilemodel');
		$data['centerContent']=$this->profilemodel->loginForm();
	    $this->data['paginationrequired']="false";
		
		$this->load->view('Skeleton',$data);
	}
	
	}
	function AddAccountRequest(){
		$account['user_id']=$this->input->post('reg_no');
		$account['user_name']=$this->input->post('user_name');
		$account['user_pass']=$this->input->post('pwd');
		$account['user_email']=$this->input->post('user_email');
        
		$account['user_type']=$this->input->post('user_type');
		$account['user_department']=$this->input->post('department');
		$account['user_group']=$this->input->post('group');
		$account['user_year']=$this->input->post('Year');
		$account['user_gender']=$this->input->post('gender');
		$account['user_degree']=$this->input->post('degree');
		$account['user_course']=$this->input->post('course');
		$this->load->model('authmodel');
		$data['centerContent']=$this->authmodel->AddAccountRequest($account);
		$this->load->view('Skeleton',$data);
	
   }
	function RequestAccount(){ 
		
		$this->load->model('authmodel');
		$data['centerContent']=$this->authmodel->getCenterContentRequestAccount();
		$this->load->view('Skeleton',$data);
	}
	function AddRemoveUser(){
		//$group_id=$this->session->userdata('group_id');
		$this->load->model('authmodel');
		$data['centerContent']=$this->authmodel->AddRemoveUserMarkup();
		$this->load->view('Skeleton',$data);

	}
	function AddUser(){
		$user_id = $this->input->post('adduser');
		$this->load->model('authmodel');
		$flag=$this->authmodel->sqlAddUser($user_id);

		if($flag==1){
			$msg='user is added sucessfully.you  will be redirected to the admin panel';
		}
		else
			$msg='something went wrong :(';
			echo $msg.'
            <script>
                window.setInterval(function(){
                    window.location="'.base_url().'AuthController/AddRemoveuser/";
                },3000);
            </script>
            ';



	}
	
	function RemoveUser(){
		$user_id = $this->input->post('removeuser');
		$this->load->model('authmodel');
		$flag=$this->authmodel->sqlRemoveUser($user_id);
		if($flag==1){
			$msg='user is removed sucessfully.you  will be redirected to the admin panel';
		}
		else
			$msg='something went wrong :(';
			echo $msg.'
            <script>
                window.setInterval(function(){
                    window.location="'.base_url().'AuthController/AddRemoveuser/";
                },3000);
            </script>
            ';


	}
	function process_login()
	{
		//get username & pass
	    $user_id = $this->input->post('user_id');    
	    $user_pass = $this->input->post('user_pass');
	    
	    //validate
        $data['page']='login';
		$this->load->model('authmodel');
	     $loginstatus =$this->authmodel->authenticate($user_id,$user_pass);


		$this->load->model('profilemodel');
		$data['centerContent']=$this->profilemodel->loginForm();
		if($loginstatus==true)
		{
			$this->load->model('authmodel');
		    $user_name =$this->authmodel->getUserName($user_id);
		    $group_id=$this->authmodel->getUserGroupId($user_id);
		    $year_id=$this->authmodel->getUserYearId($user_id);

			$sessionData = array(
			'user_id'  => $user_id,
			'logged_in' => TRUE,
			'user_name' => $user_name,
			'group_id' => $group_id,
		
			);

            //jus like $_SESSION['someKey']='someValue';
            //but note that here the key itself is an array of keys!!
            $this->session->set_userdata($sessionData);
            
			//echo "sessiontrue";//
			 redirect('HomeController');
		}
        else
        {
             
            //echo $user_id.$user_pass."false";
            $data['centerContent']='<div id="message">Oopsie, it seems your username or password is incorrect, please try again.</div>'.
            $data['centerContent'];
             	$this->load->view('Skeleton',$data);

        }
	 }
	 function AddNewUser()
	 {

	 	$this->load->model('authmodel');
		$data['centerContent']=$this->authmodel->getCenterContentAddNewUser();
		$this->load->view('Skeleton',$data);



	 }
	function logout()
	{
		//note the funtion to destroy !
	    $this->session->sess_destroy();
	    
	    redirect('AuthController');
	}
}
?>