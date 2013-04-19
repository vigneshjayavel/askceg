<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NotificationsController extends CI_Controller {

	public function getNewNotificationsCount($user_id)
	{	
		$this->load->model('notificationsmodel');
		$notifObj['count']=	$this->notificationsmodel->sqlFetchNotificationCount($user_id);
		echo json_encode($notifObj);
	}


	public function getNewNotifications()
	{	

		$this->load->model('notificationsmodel');
		
		$userId=$this->session->userdata('user_id');
		$content=$this->notificationsmodel->sqlFetchNotifications($userId,'unread');
		$data['centerContent']='<h4>Your recent notifications</h4>'.$content;
		
		$this->load->view('Skeleton',$data);
	}

	public function updateNotificationReadStatus($notif_id){
		$user_id=$this->session->userdata('user_id');
		$this->load->model('notificationsmodel');
		$this->notificationsmodel->sqlUpdateNotificationStatus($notif_id,$user_id);
		echo json_encode(array('status'=>1));
	}
}
