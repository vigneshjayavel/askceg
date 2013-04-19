<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NotificationsModel extends CI_Model{

	function test(){

		echo "here is a notification!!!";
	}

	function notify(){

		//user following another user
			//get the target user's id
			//inser a record for that user id(notify them)

		//user asking a question in a topic
			//get the topic id to whic the qs is posted
			//get the users belonging to that topic
			//notify them

		//user answering a question
			//get the userids of users who are following/created that qs
			//notify them

		//user following a question another user created
			//get the userid of the creator
			//notify him

		//user joining a group
			//get usersid belonging to that group
			//notify them


	}

	function sqlcreateMasterNotifications($receiver_id,$receiver_type,$notif_msg)
{		
		//insert master record
		$sql='INSERT INTO 
			  NOTIFICATIONS(receiver_id,receiver_type,notif_msg) 
			  values(?,?,?)';
		$query=$this->db->query($sql,array($receiver_id,$receiver_type,$notif_msg));
		//get the id of the last inserted record with the msg (assumed unique)
		$sql='Select notif_id from NOTIFICATIONS where notif_msg=?';
		$query=$this->db->query($sql,array($user_id)); 
		$row=$query->row_array();
		$latest_notif_id=$row['notif_id'];
		//join tables and filter only the records which has the notif_id as the latest master notif record's id
		//insert those records into the child table (these are the unread notifs)
		$sql='	INSERT 
				  USER_NOTIFICATIONS 
				  (
				user_id,notif_id
				  )
				SELECT 
					u.user_id,n.notif_id
				FROM 
					NOTIFICATIONS n,USERS u
				where
					(n.receiver_type="u" AND n.receiver_id=u.user_id)
					OR
					(n.receiver_type="g" AND n.receiver_id = u.group_id)  
					OR
				    (n.receiver_type="t" AND n.receiver_id in (SELECT topic_id from TOPIC_FOLLOWERS where user_id=u.user_id)) 	
					AND
					n.notif_id=?
				group by u.user_id,n.notif_id';
		$query=$this->db->query($sql,array($notif_id));		
		
	}

	function sqlcreateEnduserNotifications(){
    	$sql='	INSERT 
				  USER_NOTIFICATIONS 
				  (
				user_id, notif_id,notif_msg
				  )
				SELECT 
					u.user_id,n.notif_id,n.notif_msg
				FROM 
					NOTIFICATIONS n,USERS u
				where
					(n.receiver_type="u" AND n.receiver_id=u.user_id)
					OR
					(n.receiver_type="g" AND n.receiver_id = u.group_id)  
					OR
				    (n.receiver_type="t" AND n.receiver_id in (SELECT topic_id from TOPIC_FOLLOWERS where user_id=u.user_id)) 	
					AND
					n.notif_id=?
				group by u.user_id,n.notif_id';
			
		/*sample
		SELECT 
					u.user_id,n.notif_id,n.notif_msg
				FROM 
					NOTIFICATIONS n 
                                        JOIN USERS u
                                        join USER_NOTIFICATIONS un
				ON  
					(
					(n.receiver_type="u" AND n.receiver_id=u.user_id) OR
					(n.receiver_type="g" AND n.receiver_id = u.group_id)  OR
				        (n.receiver_type="t" AND n.receiver_id in (SELECT topic_id from TOPIC_FOLLOWERS where                          user_id=u.user_id)) 	
					)  AND un.notif_id!=n.notif_id group by u.user_id,n.notif_id
                                        
*/
    	$query=$this->db->query($sql,array($receiver_type,$receiver_id,$msg));

	}


	function sqlUpdateNotificationStatus($notif_id,$user_id){
       $sql='UPDATE 
       		USER_NOTIFICATIONS SET new=0  
       		where user_id=? AND notif_id=?';
       $query=$this->db->query($sql,array($user_id,$notif_id));
		
	}

	function sqlFetchNotifications($user_id,$unread=null){
		/*
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
		*/
		/*
		$sql='	SELECT 
					u.user_id,n.notif_id,n.receiver_type,n.notif_msg
				FROM 
					NOTIFICATIONS n,USERS u,USER_NOTIFICATIONS un
				where
					(
					(n.receiver_type="u" AND n.receiver_id=u.user_id) OR
					(n.receiver_type="g" AND n.receiver_id = u.group_id)  OR
				        (n.receiver_type="t" AND n.receiver_id in (SELECT topic_id from TOPIC_FOLLOWERS where                          user_id=u.user_id)) 	
					) AND 
  				u.user_id=? 
				group by u.user_id,n.notif_id';
		*/
		$sql='	SELECT 
						un.notif_id,n.notif_msg 
					FROM 
					USER_NOTIFICATIONS un,NOTIFICATIONS n
					where
					un.notif_id=n.notif_id and 
					un.user_id=? and un.new=1';

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
		$content.='
				</ul>
			</div>
		</div>
		';
		return $content;
	}

	function sqlFetchNotificationCount($user_id){
		$sql='	SELECT 
						notif_id
					FROM 
					USER_NOTIFICATIONS un
					where
					un.user_id=?';

		$result=$this->db->query($sql,array($user_id)); 
		$content=0;
		return $result->num_rows();
		

		/*
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
		*/
	}


}
?>