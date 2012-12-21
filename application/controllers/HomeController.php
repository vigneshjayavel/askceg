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
		$this->load->model('HomeModel');
		$name=$this->session->userdata('user_name');
		$url=base_url()."assets/img/users/".$this->session->userdata('user_id').".jpg";
		$data['centerContent']='<div id="bio">
                    <img src="'.$url.'" height="40px" width="40px" alt="James" class="display-pic" />
                    <h2>Greetings '.$name.'!</h2>
                     </div>'.$this->HomeModel->getCenterContent();
		$this->load->view('Skeleton',$data);
		}
		
	}

	function getTickerContent($page=null){

		$this->load->model('HomeModel');
		echo $this->HomeModel->getTicker($page);


	}
	
}
