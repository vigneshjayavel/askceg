<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NewsfeedModel extends CI_Model{


	function getTimeline($user_id){
		$sql='SELECT 
					u.user_id,n.notif_id,n.notif_msg,n.timestamp
				FROM 
					NOTIFICATIONS n,USERS u
				where
					(n.receiver_type="u" AND n.receiver_id=u.user_id)
					OR
					(n.receiver_type="g" AND n.receiver_id = u.group_id)  
					OR
				    (n.receiver_type="t" AND n.receiver_id in (SELECT topic_id from TOPIC_FOLLOWERS where user_id=u.user_id)) 	
				group by u.user_id,n.notif_id 
				having	u.user_id=?
				order by n.notif_id desc';
		$query=$this->db->query($sql,array($user_id)); 
		$result=$query->result_array();
		$content='
		<div id="notificationsWrapper">
			<div class="notificationsDiv">
				<ul class="nav">
		';
		$i=1;
		$this->load->library('klib');
		foreach($result as $row){
			$timeObj=$this->klib->processTime($row['timestamp']);
			$content.='
			<li>
				<span> <a href="#">'.$row['notif_msg'].'</a></span>
				&nbsp;<span class="timeElapsed">'.$timeObj['timeElapsed'].' ago..</span>
			</li>';
			
		}

		$content.='
				</ul>
			</div>
		</div>
		';
		return $content;
		
	}

	function getNewsfeed($user_id){

		$sql='SELECT 
					u.user_id,n.notif_id,n.notif_msg,n.timestamp
				FROM 
					NOTIFICATIONS n,USERS u
				where
					(n.receiver_type="u" AND n.receiver_id=u.user_id)
					OR
					(n.receiver_type="g" AND n.receiver_id = u.group_id)  
					OR
				    (n.receiver_type="t" AND n.receiver_id in (SELECT topic_id from TOPIC_FOLLOWERS where user_id=u.user_id)) 	
				group by u.user_id,n.notif_id 
				having	u.user_id=?
				order by n.notif_id desc';
		$query=$this->db->query($sql,array($user_id)); 
		$result=$query->result_array();
		$content='
		<div id="notificationsWrapper">
			<div class="notificationsDiv">
				<ul class="nav">
		';
		$i=1;
		$this->load->library('klib');
		foreach($result as $row){
			$timeObj=$this->klib->processTime($row['timestamp']);
			$content.='
			<li>
				<span> <a href="#">'.$row['notif_msg'].'</a></span>
				&nbsp;<span class="timeElapsed">'.$timeObj['timeElapsed'].' ago..</span>
			</li>';
			
		}

		$content.='
				</ul>
			</div>
		</div>
		';
		return $content;

	}


}


?>