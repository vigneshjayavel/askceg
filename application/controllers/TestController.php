<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestController extends CI_Controller {

	function index(){

		$this->load->view('TestView');

	}


	function somePageThatHasQuestions(){
		
		$this->data['centerContent']="testing";
		$this->data['paginationrequired']="true";
		$this->data['paginationtype']="question";
	    
		$this->load->view('Skeleton',$this->data);
	}


	function somePageThatHasAnswersForAQuestion(){
		
		$this->data['centerContent']="testing";
		$this->data['paginationrequired']="true";
		$this->data['paginationtype']="answer";
		$this->data['questionId']="someQuestionId";//to get answers for that question and paginate
	    
		$this->load->view('Skeleton',$this->data);
	}
	
	public function api_getQuestionsMarkup(){ 
		$this->load->model('questionsmodel');
		$set=$this->input->post('set');

		$query = $this->questionsmodel->sqlReadQuestions(null,null,null,null,$set); 
		
		$resultLength=count($query);
		if($resultLength!=0){
			echo json_encode(array("data"=>$query));
		}
		else{
			echo null;
		}	 
	} 


	public function view(){
		$this->load->model('questionsmodel');
		
		$data['centerContent']=$this->questionsmodel->sqlReadQuestions(null,null,null,null,null);
		$this->load->view('Skeleton',$data);
	}

	function test(){
	}
   	
   	function convert(){
		$this->load->model('questionsmodel');
		$data['centerContent']=$this->questionsmodel->convert();
		$this->load->view('Skeleton',$this->data);
	}

	function testData($q_id){
		echo "This is test!! ".$q_id;
	}
	function time(){
		 $date = new DateTime(date('Y-m-d H:i:s AM'), new DateTimeZone('GMT'));
$date->setTimezone(new DateTimeZone('IST'));

echo $date->format('Y-m-d H:i:s');
}


function Upload(){
   $this->data['centerContent']='<form id="imageform" method="post" enctype="multipart/form-data" action="'.base_url().'TestController/SaveImg">
Upload image <input type="file" name="photoimg" id="photoimg" />
</form>

<div id="preview">
</div>';
$this->load->view('Skeleton',$this->data);

}

function SaveImg(){
	$path = base_url()."uploads/";

$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
$name = $_FILES['photoimg']['name'];
$size = $_FILES['photoimg']['size'];
if(strlen($name))
{
list($txt, $ext) = explode(".", $name);
if(in_array($ext,$valid_formats))
{
if($size<(1024*1024)) // Image size max 1 MB
{
$actual_image_name = time().$session_id.".".$ext;
$tmp = $_FILES['photoimg']['tmp_name'];
if(move_uploaded_file($tmp, $path.$actual_image_name))
{
mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");
echo "<img src='uploads/".$actual_image_name."' class='preview'>";
}
else
echo "failed";
}
else
echo "Image file size max 1 MB"; 
}
else
echo "Invalid file format.."; 
}
else
echo "Please select image..!";
exit;
}
}
<<<<<<< HEAD
function paginate(){
	$this->data['centerContent']="testing";
	$this->data['paginationrequired']="true";
	$this->data['paginationtype']="question";
	$this->data['categoryid']=null;
	$this->data['topicurl']='ibatch';
	//$this->data['question']
    
$this->load->view('Skeleton',$this->data);
}
=======

>>>>>>> 90329e206ffb9a1744609c1bf748f7d6f43bc08e

}