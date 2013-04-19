<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HomeModel extends CI_Model{

	function getNewsfeed(){

		$sql='SELECT 
					u.user_id,n.notif_id,n.notif_msg
				FROM 
					NOTIFICATIONS n,USERS u
				where
					(n.receiver_type="u" AND n.receiver_id=u.user_id)
					OR
					(n.receiver_type="g" AND n.receiver_id = u.group_id)  
					OR
				    (n.receiver_type="t" AND n.receiver_id in (SELECT topic_id from TOPIC_FOLLOWERS where user_id=u.user_id)) 	
				group by u.user_id,n.notif_id
				having	un.user_id=?';
		$query=$this->db->query($sql,array($user_id)); 
		$result=$query->result_array();
		$content='
		<div id="notificationsWrapper">
			<div class="notificationsDiv">
				<ul class="nav">
		';
		$i=1;
		foreach($result as $row){
			$content.='
			<li>
				<span> <a href="#">'.$row['notif_msg'].'</a></span>
				<span data-notif_id='.$row['notif_id'].' class="notificationReadStatus pull-right icon-check"></span>
			</li>';
			
		}

	}


}


?>