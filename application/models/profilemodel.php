<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProfileModel extends CI_Model{

	function getCenterContent(){


		return ' <form id="login" enctype="application/x-www-form-urlencoded" class="form-vertical login"
        accept-charset="utf-8" method="post" action="../models/Authmodel/authenticate" >
            <div class="control-group error">
                <label for="email" class="control-label required">Email address</label>
                <div class="controls">
                    <input type="text" name="email" id="login-email" data-title="Invalid email" value="" tabindex="1">
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label required">Password (
                    <a href="#" class="trigger-lightbox validate-resetpassword">forgot password</a>)</label>
                <div class="controls">
                    <input type="password" name="password" id="login-password" data-title="Invalid password" value="" tabindex="2">
                </div>
            </div>
            <div class="form-actions">
        <button name="submit" id="loginbutton" data-loading-text="logging in.." onclick="javascript:dologin();return false;" 
                tabindex="3" class="btn btn-primary">Log In</button>
                <button name="cancel" id="cancel" type="reset" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </form>
    ';

	}
     function loginForm(){
         $base_url=base_url();
        return ' <form id="login" enctype="application/x-www-form-urlencoded" class="form-vertical login"
        accept-charset="utf-8" method="post" action="'.$base_url.'AuthController/process_login">
            <div class="control-group error">
                <label for="email" class="control-label required">User id</label>
                <div class="controls">
                    <input type="text" name="user_id" id="user_id" data-title="Invalid email" value="" tabindex="1">
                </div>
            </div>
            <div class="control-group">
                <label for="password" class="control-label required">Password (
                    <a href="#" class="trigger-lightbox validate-resetpassword">forgot password</a>)</label>
                <div class="controls">
                    <input type="password" name="user_pass" id="user_pass" data-title="Invalid password" value="" tabindex="2">
                </div>
            </div>
            <div class="form-actions">
        <button name="submit" id="loginbutton" data-loading-text="logging in.." onclick="javascript:dologin();return false;" 
                tabindex="3" class="btn btn-primary">Log In</button>
                <button name="cancel" id="cancel" type="reset" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </form>
    ';



    }
	function getCenterContentMyProfile(){

	   return '<fieldset>
                 <label class="control-label" for="name">Your Name</label>
                  <div class="controls">
                  <input type="text" class="input-xlarge" name="name" id="name" value="vishnu jayvel">
                  
                  </div>
                  <br>
                 
                <label class="control-label" for="sex">Sex</label>
                  <div class="controls">
                  
                  <label class="radio">
                    <input type="radio" name="sex" id="sexRadios1" value="1" checked="">
                    Male
                  </label>
                  
                  <label class="radio">
                    <input type="radio" name="sex" id="sexRadios2" value="2">
                    Female
                  </label>
                  
                  <label class="radio">
                    <input type="radio" name="sex" id="sexRadios3" value="3">
                    Other
                  </label>
                  
                  
                  </div>
                 <br> 
                  <label class="control-label" for="email">Email Address</label>
                  <div class="controls">
                  <input type="text" class="input-xlarge" name="email" id="email" disabled="readonly" value="vishnuj81093@gmail.com">
                  </div>
                  <label class="controls checkbox">
                    <input id="shareemail" type="checkbox" checked="checked"> Show email to others
                  </label> 
                  
                <br>
                 <label class="control-label" for="phone">Phone Number</label>
                  <div class="controls">
                  <input type="text" class="input-xlarge" name="phone" id="phone" value="8220557222">
                   
                  </div>
                 <br>
                
                <label class="control-label" for="acctype">Account Type</label>
                  <div class="controls">
                  <select class="span3" id="acctype" onchange="changeform();">
                   <option value="coll" selected="selected">College Student</option>
                   <option value="school">School Student</option>
                   <option value="fac">Faculty</option>
                   <option value="corp">Corporate</option>
                  </select>   
                  
                   
                  </div>
                <br>
                  <div id="dynamic"><label class="control-label" for="institution">Your Institution</label>
                  <div class="controls">
                  
                  </div>
                <br>

                  <label class="control-label" for="degree">Your degree</label>
                  <div class="controls">
                  <select class="span3" id="degree">
                   <option value="1" selected="selected"> B.E </option><option value="2">B.A</option><option value="3">B.Arch</option><option value="4">B.Com</option><option value="5">B.Sc</option><option value="6">B.Tech</option><option value="7">BBA</option><option value="8">BCA</option><option value="9">DEEE</option><option value="10">Diploma</option><option value="11">Dual Degree</option><option value="12">Intermediate</option><option value="13">M.A</option><option value="14">M.E</option><option value="15">M.Sc</option><option value="16">M.Sc(Integrated)</option><option value="17">M.Tech</option><option value="18">MBA</option><option value="19">MCA</option><option value="20">MS</option><option value="21">Ph.D</option><option value="22">Other</option>   
                  </select>
                   
                  </div>
                 <br>

                  <label class="control-label" for="branch">Your Course</label>
                  <div class="controls">
                  <select class="span3" id="course">
                    <option value="1">Aeronautical Engineering</option><option value="2">Aerospace Engineering</option><option value="3">Agricultural &amp; Irrigation Engineering</option><option value="4">Aircraft Maintenance Engineering</option><option value="5">Animation</option><option value="6">Apparel technology</option><option value="7">Applied electronics</option><option value="8">Applied Mathematics</option><option value="9">Architecture</option><option value="10">Automobile Engineering</option><option value="11">Avionics</option><option value="12">Bio Informatics</option><option value="13">Bio Medical Engineering</option><option value="14">Biotechnology</option><option value="15">Ceramic Technology</option><option value="16">Charted Accountancy</option><option value="17">Chemical Engineering</option><option value="18">Chemistry</option><option value="19">Civil Engineering</option><option value="20">Communication Systems</option><option value="21" selected="selected">Computer Science &amp; Engineering</option><option value="22">Cryogenic Engineering</option><option value="23">Elecrical Engineering</option><option value="24">Electrical &amp; Electronics Engineering</option><option value="25">Electronic media</option><option value="26">Electronics &amp; Communication Engineering</option><option value="27">Electronics &amp; Instrumentation</option><option value="28">Embedded Systems</option><option value="29">Energy Engineering</option><option value="30">Engineering Design</option><option value="31">Engineering Physics</option><option value="32">English Literature</option><option value="33">Finance</option><option value="34">Fluid Mechanics</option><option value="35">Food Technology</option><option value="36">Geo Informatics</option><option value="37">Harbour Engineering </option><option value="38">High Voltage Engineering</option><option value="39">Hospitality Administration</option><option value="40">HR</option><option value="41">Humanities &amp; Social Sciences</option><option value="42">Industrial Engineering</option><option value="43">Information &amp; Communications Technology</option><option value="44">Information Technology</option><option value="45">Internal Combustion Engineering</option><option value="46">Logistics</option><option value="47">Manufacturing Engineering</option><option value="48">Marine Engineering</option><option value="49">Marketing</option><option value="50">Material Science </option><option value="51">Mathematics</option><option value="52">Mechanical Engineering</option><option value="53">Mechatronics</option><option value="54">Media Sciences</option><option value="55">Metallurgy</option><option value="56">Mining Engineering</option><option value="57">Nano Science and Technology</option><option value="58">Photonics </option><option value="59">Physics</option><option value="60">Printing Technology</option><option value="61">Production Engineering</option><option value="62">Remote Sensing</option><option value="63">Software Engineering</option><option value="64">Systems Engineering &amp; Operations Research</option><option value="65">Technology Managment</option><option value="66">Telecommunication Engineering</option><option value="67">Textile Technology</option><option value="68">Theoretical Computer Science</option><option value="69">Thermal</option><option value="70">Transportation Engineering</option><option value="71">VLSI Design</option><option value="72">Other</option>  
                  </select>   
                  
                  </div>
                <br>

                  <label class="control-label" for="year">Your Year Of Study</label>
                  <div class="controls">
                  <label class="radio">
                    <input type="radio" name="year" id="optionsRadios1" value="1">
                    1
                  </label>
                  <label class="radio">
                    <input type="radio" name="year" id="optionsRadios2" value="2" checked="checked">
                    2
                  </label>
                  <label class="radio">
                    <input type="radio" name="year" id="optionsRadios3" value="3">
                    3
                  </label>
                  <label class="radio">
                    <input type="radio" name="year" id="optionsRadios4" value="4">
                    4
                  </label>
                  <label class="radio">
                    <input type="radio" name="year" id="optionsRadios5" value="5">
                    5
                  </label>
                  
                  </div></div><!-- end of account type div. This is dynamic part of the form -->
                 <br>
                 <label class="controls checkbox">
                    <input id="shareprofile" type="checkbox" checked="checked"> Show profile to others
                  </label> 
                <br>
          
          <div class="alert fade in" id="form-err" style="display:none">
          <span id="form-err-text"></span>
            </div>
          
                <br>
                <label class="controls">
                  <button id="updateButton" class="btn btn-primary btn-large" data-loading-text="saving.." onclick="Javascript:verify();" type="button">Save</button>
                 <label>
                 </label></label></fieldset>';
    



	}
  

	function getCenterContentMyGroup(){
    $CI =& get_instance();
    $currentUserId=$CI->session->userdata('user_id');
    $groupId=$CI->session->userdata('group_id');

    
    $sql='select g.group_name,g.group_desc from GROUPS g where g.group_id=?';

$query=$this->db->query($sql,array($groupId));
       $row=$query->row_array();
      


		return '        <div class="well">
        
        <a href="#">
        <img class="thumbnail" height="200px" width="140px" src="'.base_url().'assets/img/group.jpg" alt="">
        </a>'.$row['group_name'].'
        <br>
        </div>
        <div class="well">
        group_desc
       '.$row['group_desc'].' 

        
        
        </div>
        
     
        <div class="well">
        group members photo
        </div>
        <div class="well">
        questions posted by the group members in the group scope
        </div>
         ';

	}



}