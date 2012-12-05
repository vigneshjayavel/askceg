<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProfileController extends CI_Controller {

	
	function index()
	{
		$this->load->model('ProfileModel');
		$data['centerContent']=$this->ProfileModel->getCenterContent();
		$this->load->view('Skeleton',$data);
		
	}
	function MyProfile()
	{
		$this->load->model('ProfileModel');
		$data['centerContent']=$this->ProfileModel->getCenterContentMyProfile();
		$this->load->view('Skeleton',$data);
	}
	function MyGroup()
	{
		$this->load->model('ProfileModel');
		$data['centerContent']=$this->ProfileModel->getCenterContentMyGroup();
		$this->load->view('Skeleton',$data);
	}
	function AccountSettings()
	{
		$this->load->view('AccountSettingsView');
	}
}
