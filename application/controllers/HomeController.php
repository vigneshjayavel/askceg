<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HomeController extends CI_Controller {
function HomeController()
	{
		parent::__construct();
	}
	
	function index()
	{//check for valid session
	    if ($this->session->userdata('logged_in') != TRUE)
	    {

	    	//redirect to controller/function if there's no valid session
	        redirect('AuthController/index');
	        //$this->load->view('login');
	    }
	    else
	    {
		$this->load->model('homemodel');
		$this->load->model('metamodel');
       	$data['metaContent']=$this->metamodel->getmeta("normal");
		$data['centerContent']=$this->homemodel->getHomePage();
        $data['paginationrequired']="false";
		$this->load->view('Skeleton',$data);
		}
		
	}
    function error(){
    	$this->load->model('metamodel');
       	$data['metaContent']=$this->metamodel->getmeta("normal");
		
    	$data['centerContent']='<div style="text-align:centre">404 page not found</div>';
    		$this->load->view('Skeleton',$data);

    }
	function getTickerContent($page=null){

		$this->load->model('HomeModel');
		echo $this->HomeModel->getTicker($page);


	}
	
}
