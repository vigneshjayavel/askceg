<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProfileController extends CI_Controller {

	
	function index()
	{
		$this->load->model('profilemodel');
		$data['centerContent']=$this->profilemodel->getCenterContent();
		$this->load->view('Skeleton',$data);
		
	}
	function MyProfile()
	{
		$this->load->model('profilemodel');
		
		$data['centerContent']=$this->profilemodel->getCenterContentMyProfile();

		$this->load->view('Skeleton',$data);
	}
	function MyGroup()
	{
		$this->load->model('profilemodel');
		$this->load->model('questionsmodel');
		$data['centerContent']=$this->profilemodel->getCenterContentMyGroup();
			$data['centerContent'].=$this->questionsmodel->getGroupScopeQuestions();
		$this->load->view('Skeleton',$data);
	}
	function AccountSettings()
	{
		$this->load->view('AccountSettingsView');
	}
}
