var temp
window.fbAsyncInit = function () {
    FB.init({
        appId: FBConfig.appId, // App ID
        channelUrl: CI.base_url+'channel.html', // Channel File
        status: true, // check login status
        cookie: true, // enable cookies to allow the server to access the session
        xfbml: true // parse XFBML
    });
    console.log('inside fbAsyncInit')
    temp = $('.fbLoginStatus');

    function fblogin() { //requesting permission for K! app from user
        FB.login(
            function (response) {
                if (response.authResponse) {
                    FB.api('/me', function (info) {
                        login(response, info);
                    });

                } else {}
            }, //callback ends 
            {
                scope: 'user_about_me,user_interests,user_likes,user_birthday,user_education_history,email,offline_access,publish_stream,status_update,user_location,friends_location,publish_actions,friends_activities,friends_interests,friends_likes'
            }
        ); //FB.login ends
    }

    
    //custom func
    function verify(response) { //k! app connected with user..
        console.log(response.status)
        if (response.status === 'connected') {
            var uid = response.authResponse.userID;
            var accessToken = response.authResponse.accessToken;
            login(response);
        } else if (response.status === 'not_authorized') { // user logged in not connected with k! app
            temp.html("<img src="+CI.base_url+"assets/img/btns/fbLoginRegister.png>");
            temp.unbind("click").click(function () {
                temp.html("<img src="+CI.base_url+"assets/img/btns/fbLoading.gif>");
                fblogin();
            });
        } else { //User not logged in facebook 1-->check whether user has logged in with our 'normal login' 2-->wait for user to click on either of the login. 

            temp.html("<img src="+CI.base_url+"assets/img/btns/fbLoginRegister.png>");
            temp.unbind("click").click(function () {
                temp.html("<img src="+CI.base_url+"assets/img/btns/fbLoading.gif>");
                fblogin();
            });
        }
    }//verify ends
    FB.getLoginStatus(verify);
    FB.Event.subscribe('auth.statusChange', verify);
};//fbAsynInit ends

//func to check for extend permissions
function checkForPermissions() { //requesting permission for K! app from user
    FB.getLoginStatus(
        function (response) {
            if (response.authResponse) {
                //check for og actions publish extended permission
                FB.api('/me/permissions', function(perms_response) {

                    // if publish_actions access already exists, we're good to go
                    if(perms_response['data'][0]['publish_actions']) {
                        console.log('permissions are already granted.');
                        console.log(perms_response)
                        //callback(true);
                    // photo access does not exist, so show an auth dialog
                    } else {

                        // get publish_actions permissions
                        console.log('requesting permission...');
                        FB.login(function(response) {
                            if(response.authResponse) {
                                console.log('permission granted');
                                //callback(true);
                            } else {
                                console.log('permission request failed');
                                //callback(false);
                            }
                        },{scope : 'publish_actions'});
                    }
                });//extended permissions check ends

            } else {

            }
        } //callback ends 
    ); //FB.getLoginStatus ends
}//checkForPermissions ends
                

//custom func
function login(response) { //logs in if old user, create account for new user..

    var temp = $('.fbLoginStatus');
    var at = response.authResponse.accessToken;
    FB.api(
        {
            method: 'fql.query',
            query: 'select uid, name, email, sex,pic_big,pic_small from user where uid=me()'
        },

        function (rows) { // send the response to verify completion of profile/signup user.
            $.post(CI.base_url+"AuthControllerAsk/dofbcheck", {
                'access_token': at,
                'uid': rows[0].uid,
                'email': rows[0].email,
                'sex': rows[0].sex,
                'pic_big': rows[0].pic_big,
                'pic': rows[0].pic_small,
                'name': rows[0].name
            },

            function (data) {

                if(data=="2"){
                    console.log(data + " : already registered, profile is complete");
                        temp.html("<img src="+CI.base_url+"assets/img/btns/fbLogout.png>");
                        temp.unbind("click").click(function () {
                            FB.logout(function (response) {
                                $.post(CI.base_url+"AuthControllerAsk/destroySession", {},function (data){
                                    window.location=CI.base_url+'HomeController';
                                });//$.post ends
                            });
                        });
                }
                else if(data=="4"){
                    console.log(data + " : already registered, incomplete profile");
                    window.location=CI.base_url+'AuthControllerAsk/profile';
                }
                else if(data=="3"){
                    console.log(data + " : new user, incomplete profile");
                    window.location=CI.base_url+'AuthControllerAsk/profile';
                }
                else{
                    console.log(data)
                }
                $('#normalLoginButton').hide();
                $('#registerModal').modal('hide');
                
                
            });//$.post ends
        }//callback of FB.api ends
    );//FB.api ends



}//login ends
   