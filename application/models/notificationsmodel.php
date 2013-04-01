<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NotificationsModel extends CI_Model{

	function test(){

		echo "here is a notification!!!";
	}


	function createNotification($receiver_type,$receiver_id,$msg){
    	$sql="INSERT into
    	      NOTIFICATIONS(receiver_type,receiver_id,notif_msg)
    	      values(?,?,?)";
    	$query=$this->db->query($sql,array($receiver_type,$receiver_id,$msg));

	}


	function sqlUpdateNotificationStatus($notif_id,$user_id){
       $sql="INSERT into 
       		USER_NOTIFICATIONS(user_id,notif_id)
       		values(?,?)";
       $query=$this->db->query($sql,array($notif_id,$user_id));
		
	}

	function sqlFetchNotification($user_id){
		$sql='	SELECT 
					u.user_id,n.notif_id,n.receiver_type,n.notif_msg
				FROM 
					NOTIFICATIONS n,USERS u
				where
					(
					(n.receiver_type="u" AND n.receiver_id=u.user_id) OR
					(n.receiver_type="g" AND n.receiver_id = u.group_id)  OR
				        (n.receiver_type="t" AND n.receiver_id in (SELECT topic_id from TOPIC_FOLLOWERS where                          user_id=u.user_id)) 	
					) AND u.user_id=?
				group by u.user_id,n.notif_id';


		$query=$this->db->query($sql,array($user_id)); 
		$result=$query->result_array();
		$content='';
		foreach($result as $row){
			$content.='
			<div>
				'.$row['notif_msg'].'
			<div>';
			
		}
		return $content;
	}

	function sqlFetchNotificationCount($user_id){
		$sql='	SELECT 
				count(temp.temp_notif_id) as cnt
				from(SELECT 
						n.notif_id as temp_notif_id
					FROM 
					NOTIFICATIONS n,USERS u,USER_NOTIFICATIONS un
					where
					(
					(n.receiver_type="u" AND n.receiver_id=u.user_id) OR
					(n.receiver_type="g" AND n.receiver_id = u.group_id)  OR
					(n.receiver_type="t" AND n.receiver_id in (SELECT topic_id from TOPIC_FOLLOWERS where                          user_id=u.user_id)) 	
					) AND
					n.notif_id!=un.notif_id 
					AND u.user_id=?
					group by u.user_id,n.notif_id) temp';

		$query=$this->db->query($sql,array($user_id)); 
		$content=0;
		if($row=$query->row_array()){
			$content=$row['cnt'];
		}
		return $content;
	}


}
?>