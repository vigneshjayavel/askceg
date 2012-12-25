<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TeacherModel extends CI_Model{


 function getGroupName($group_id){
      $sql='select group_name from GROUPS where group_id=?';
      $query=$this->db->query($sql,array($group_id));
       $row=$query->row_array();
       return $row['group_name'];

    }

function getTeacherProfile($user_id){
      

    
      $sql='select * from USERS u,TEACHER_DETAILS t where u.user_id=? and t.user_id=?';
      $query=$this->db->query($sql,array($user_id,$user_id));
      $row=$query->row_array();



      return '<div class="well">
      <table>
      <tr>
            <td>Name:
            </td>
            <td>'.$row['user_name'].'
            </td>
     
      </tr>
      </table>
      </div>
      

      <div class="well">
          <div class="ask-dp pull-right">
              <img src="'.base_url().'assets/img/users/'.$row['user_id'].'.jpg">
          </div>
           
            Department:<a href="'.base_url().'ProfileController/ViewGroupProfile/'.$row['user_id'].'">'.$this->getGroupName($row['group_id']).'</a>
     </div>
        
        


          <div class="well">
      classes handled:
      </div>
      <div class="well">
      graduated in:'.$row['graduated_at'].'
      </div>
      <div class="well">
      Field of interest:'.$row['field_of_interest'].'
      </div>


            
      ';

    }



    function getTeacherHandlingGroups($user_id){

    	return "to be done!!!";
      /*$sql='select group_id from teacher_handling_group where user_id=?';
    	$query=$this->db->query($sql,array($user_id));
			$result=$query->result_array();
			$markup='';
      
			foreach($result as $row){
			$markup.='<a href="'.base_url().'ProfileController/ViewGroupProfile/'.$row['group_id'].'">'.$this->getGroupName($row['group_id']).'</a><br>';

			}

			return $markup;*/
    }





}






    