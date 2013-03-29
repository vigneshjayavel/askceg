<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SearchController extends CI_Controller {

	public $data=array();

	public function __construct()
	{
	        parent::__construct();
			$this->data['page']="search";
	}
	
	
	function index()
	{
		
		
	}
	function SearchQuestion()
	{
		$this->load->model('SearchModel');
		$this->data['centerContent']=$this->SearchModel->getCenterContentSearchQuestion();
		$this->load->view('Skeleton',$this->data);
		
	}

	function SearchDiscussion()
	{
		$this->load->model('SearchModel');
		$this->data['centerContent']=$this->SearchModel->getCenterContentSearchDiscussion();
		$this->load->view('Skeleton',$this->data);
		
	}

	function ajaxSearch(){

		$searchQuery=$this->input->post('query');
		$this->load->model('searchmodel');
		$temp=$this->searchmodel->sqlReturnSearchResult($searchQuery);

		echo $temp;
	} 

	function search($searchQuery){

		$this->load->model('SearchModel');
		$this->data['centerContent']='<h3>Advanced search - Coming soon!! Hope you find the answer for <b>'.urldecode($searchQuery).'</b> then!</h3>';
		$this->load->view('Skeleton',$this->data);
		
	}

}
