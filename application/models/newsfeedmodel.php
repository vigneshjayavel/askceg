<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class NewsfeedModel extends CI_Model{

	function getTimeline(){

		return '
		<header id="timeline">
		 <h1 id="timeline">Vikki Jai</h1>
		</header>
		<ol id="timeline">

		  <li> 
		    <div class="time">Yesterday</div>
		    <span class="corner"></span>
		    <p>
		just had a lunch ...</p>
		  </li>

		  <li>
		    <div class="time">about an hour ago</div>
		    <span class="corner"></span>
		    <p>Information inside a table or a list needs to be displayed in such a way so it will be easier to read. Most of us will use the same method when we display information inside table or list. We usually choose two color for example grey and white and put them as background on each</p>
		  </li>

		  <li>
		    <div class="time">Monday</div>
		    <span class="corner"></span>
		    <p>Have a nice hot chocolate in the morning</p>
		  </li>

		  <li>
		    <div class="time">Yesterday</div>
		    <span class="corner"></span>
		    <p>HTML5 has become a hit today as its new elements and other new concept. What about the old elements? HTML5 has removed some old elements with some considerations. For example the presentational attribute such as background(for body element), bgcolor, align and border as they are better handled in CSS.
		    </p>
		  </li>

		  <li>
		    <div class="time">sunday</div>
		    <span class="corner"></span>
		    <p>Create HTML 5 And CSS3 Form<br/>
		create a form using html 5 new elements and css new styles.<br/>
		<a href="http://kangtanto.com/web-2/html5-web-2/create-html-5-and-css3-form">read more</a>
		</p>
		  </li>

		  <li>
		    <div class="time">Sunday</div>
		    <span class="corner"></span>
		    <p>Create a simple list using nth-of-type</p>
		  </li>

		  <li>
		    <div class="time">Sunday</div>
		    <span class="corner"></span>
		    <p>There are many new stuff on HTML5. Can\'t wait to learn canvas</p>
		  </li>

		  <li>
		    <div class="time">Sunday</div>
		    <span class="corner"></span>
		    <p>Better take a look at some example of best and fresh single
		web page <a href=\'http://kangtanto.com/web-2/inspirations-10-best-and-fresh-single-page-website\'>here</a></p>
		  </li>

		</ol>  

		';


	}

	function getTimeline1($user_id){
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