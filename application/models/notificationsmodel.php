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
       $query=$this->db->query($sql,array()($notif_id),$user_id);
		
	}

	function sqlFetchNotification($user_id){
		$sql='SELECT 
		 	  n.*
		 	  FROM 
		 	  NOTIFICATIONS n,TOPIC_FOLLOWERS t,
		 	  GROUPS g
		 	  where
		 	  ((receiver_type="u" AND receiver_id="'.$user_id.'") OR
		 	   (receiver_type="t" AND receiver_id in (SELECT topic_id from TOPIC_FOLLOWERS where user_id="'.$user_id.'")) OR
               (receiver_type="g" AND receiver_id in (SELECT group_id from GROUPS where user_id="'.$user_id.'")) )';












		 	  (t.user_id="'.$user_id.'" OR g.user_id="'.$user_id.'" OR 
		 	   n.receiver_id="'.$user_id.'") 
		 	  (n.receiver_id=t.topic_id OR n.receiver_id=g.group_id) AND
		 	  ((n.receiver_type="u" AND n.receiver_id="'.$user_id.'") OR
		 	  (n.receiver_type="t" AND n.receiver_id=t.topic_id) OR
		 	  (n.receiver_type="g" AND n.receiver_id=g.group_id))'
              ; 

	}


}
?>