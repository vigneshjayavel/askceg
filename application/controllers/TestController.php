<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestController extends CI_Controller {

	function index(){

		$this->load->view('TestView');

	}


    function testNo($user_id,$follower_id=2){
      $sql = "insert into USER_FOLLOWERS(user_id,follower) values(?,?)";
      $status=$this->db->query($sql,array($user_id,$follower_id));
      if($status==-1){
        $this->load->library('klib');
        $userData=$this->klib->getUserData($follower_id);
        $emailData['to']=$userData['email_id'];
        $emailData['subject']=$userData['user_name'].' followed you!';
        $emailData['message']=$userData['user_name'].' followed you!';
        $this->klib->generateNotifications($user_id,'u',$userData['user_name'].' followed you!');
        echo "asas ".$userData['email_id'];
      }
    }

	function notifMarkup(){
		$data['centerContent']='
	
		<div class="">
				<div class="notificationsDiv">
					<ul class="nav">
						<li></li>
						<li></li>
						<li></li>
						<li></li>
						<li></li>
					</ul>
				</div>
			</div>


		';
		$this->load->view('TestView',$data);
	}
	function testNotif(){
		$this->load->model('notificationsmodel');
		echo $this->notificationsmodel->sqlFetchNotification('1');
		echo $this->notificationsmodel->sqlFetchNotificationCount('1');
	}


	function time(){//todo
		$this->load->library('klib');
		print_r($this->klib->processTime(1364729876));
	}
	function testNotifs(){

		$this->load->model('notificationsmodel');

    	echo $this->notificationsmodel->test();

	}

	function testFb(){
		$data['centerContent']='<input type="submit" id="testerButton" onClick="checkForPermissions();"/>
          ';
		$this->load->view('Skeleton',$data);
	}
	function mail(){


		$config = Array(
	        'smtp_user' => 'saktnea2013@gmail.com',
	        'smtp_pass' => 'subbuvishali',
	        'protocol'=>'smtp',
			'smtp_host'=>'ssl://smtp.googlemail.com',
			'smtp_port'=>'465',
			'smtp_timeout'=>'30',  
			'charset'=>'utf-8',   
	        'mailtype' => 'html',
			'newline'=>"\r\n"
	    );
		$emailData['to']='dgr8geek@gmail.com';
		$emailData['subject']='aasasas';
		$emailData['message']='asasasadasdasd';
		
		$CI =& get_instance();
	    $CI->load->library('email', $config);
	    $CI->email->from('saktnea2013@gmail.com', "TNEA 2013");
	    $CI->email->to($emailData['to']);
	    $CI->email->subject("This is the sub");
	    $CI->email->message("message@@@");
		$CI->email->send();	
		echo "mail sent";

	}
    function createbatch(){
    	$this->load->model('testmodel');

    	$this->testmodel->createbatch();
		
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
		
		//$query=array('data' => $categoryId."-".$topicUrl."-".$set);
		$resultLength=count($query);
		if($resultLength!=0){
			echo json_encode(array("data"=>$query));
		}
		else{
			echo $query;
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
	function time1(){
		 $date = new DateTime(date('Y-m-d H:i:s AM'), new DateTimeZone('GMT'));
$date->setTimezone(new DateTimeZone('IST'));

echo $date->format('Y-m-d H:i:s');
}


function Upload($topic_id){
   $this->data['centerContent']='
   <script src="'.base_url().'assets/js/jquery.form.js"></script>
   <style type="text/css">
   .preview
{
width:200px;
border:solid 1px #dedede;
padding:10px;
}
#preview
{
color:#cc0000;
font-size:12px
}
</style>
   <form id="imageform" method="post" enctype="multipart/form-data" action="'.base_url().'TestController/SaveImg/'.urlencode($topic_id).'">
Upload your image <input type="file" name="photoimg" id="photoimg" />
</form>
<div id="preview">
</div>
   ';
$this->load->view('Skeleton',$this->data);

}

function SaveImg($topic_id){
	$topic_id=urldecode($topic_id);
	$CI=&get_instance();
	$sql="select posted_by from TOPIC where topic_id=?";
	$query=$this->db->query($sql,array($topic_id));
	if($row=$query->row_array()){
         if($row['posted_by']!=$CI->session->userdata('user_id'))
         	return 'you dont permission to view this page';

	
	if(ENVIRONMENT=='cloud')
		$path = "/assets/img/topics/";
	else
		$path = "/ask/assets/img/topics/";

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
					$actual_image_name = $topic_id.".jpg";
					$tmp = $_FILES['photoimg']['tmp_name'];
					if(move_uploaded_file($tmp, $_SERVER['DOCUMENT_ROOT'].$path.$actual_image_name))
					{
						echo "<img src='".$path.$actual_image_name."' class='preview'>";
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