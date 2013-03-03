<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TestController extends CI_Controller {

	function index(){

		$this->load->view('TestView');

	}

	function dbTest($startIndex=null,$endIndex=null){

		if($startIndex==null && $endIndex==null){
			$sql = "SELECT 
			q.q_id,q.q_content
			FROM
			QUESTION q
			LIMIT 0,20";
		}
		else{
			$sql = "SELECT 
			q.q_id,q.q_content
			FROM
			QUESTION q
			LIMIT $startIndex,$endIndex ";
		}


		$query=$this->db->query($sql);
		$result='';
		$resultSet=$query->result_array();
		foreach($resultSet as $row){
			$result.='<div>'.$row['q_content'].'</div>';
		}
		echo $result;

	}

	function test(){
		$this->load->view('TestView');
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



function print123($qid){
	$this->load->model('questionsmodel');
		$data['centerContent']=$this->questionsmodel->printanswer($qid);
		$this->load->view('Skeleton',$this->data);


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
    
$this->load->view('Skeleton',$this->data);
}

}