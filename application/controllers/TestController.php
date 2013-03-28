<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestController extends CI_Controller {

	function index(){

		$this->load->view('TestView');

	}
  /*
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    echo $url;
}
	function mail(){
		$mailData['to']='dgr8geek@gmail.com';
		$mailData['subject']='This is a test mail';
		$mailData['message']='tesssssst';
		$this->load->library('klib');
		$this->klib->sendMail($mailData);
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
		$categoryId=$this->input->post('categoryId');
		$topicUrl=$this->input->post('topicUrl');
		$groupScope=$this->input->post('groupScope');
		//$questionUrl=$this->input->post('questionUrl');
     	//echo json_encode(array('data' => $category_id." ".$topic_url." ".$question_url));
		$query = $this->questionsmodel->sqlReadQuestions($categoryId,$topicUrl,null,$groupScope,$set); 
		
		//$query=array('data' => $categoryId."-".$topicUrl."-".$questionUrl);
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
function paginate(){
	$this->data['centerContent']="testing";
	$this->data['paginationrequired']="true";
	$this->data['paginationtype']="question";
	$this->data['categoryId']="";
	$this->data['topicUrl']='ibatch';
	$this->data['questionurl']="";
    
$this->load->view('Skeleton',$this->data);
}

}