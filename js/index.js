$(document).ready(function(){
    $(document).keypress(function(e){
        if (e.which == 13){
            if($('#loginform').is(":visible")){
                $("#loginbutton").click();
            }
            else if($('#signupform').is(":visible")){
                $("#signupbutton").click();
            }
        }
    });
 
    $('#signup').click(function(event){
        event.preventDefault();
        $('#loginform').slideUp();
        $('#signupform').slideDown();
        $('#myalert').slideUp();
        $('#signform')[0].reset();
    });
 
    $('#login').click(function(event){
        event.preventDefault();
        $('#loginform').slideDown();
        $('#signupform').slideUp();
        $('#myalert').slideUp();
        $('#logform')[0].reset();
    });
 
    $(document).on('click', '#signupbutton', function(){
        if($('#susername').val()!='' && $('#spassword').val()!=''){
            $('#signtext').text('Signing up...');
            $('#myalert').slideUp();
            var signform = $('#signform').serialize();
            $.ajax({
                method: 'POST',
                url: 'php/register.php',
                data: signform,
                success:function(data){
                    setTimeout(function(){
                    $('#myalert').slideDown();
                    $('#alerttext').html(data);
                    $('#signtext').text('Sign up');
                    $('#signform')[0].reset();
                    }, 2000);
                } 
            });
        }
        else{
            alert('Please input both fields to Sign Up');
        }
    });
 
    $(document).on('click', '#loginbutton', function(){
        if($('#username').val()!='' && $('#password').val()!=''){
            $('#logtext').text('Logging in...');
            $('#myalert').slideUp();
            var logform = $('#logform').serialize();
            setTimeout(function(){
                $.ajax({
                    method: 'POST',
                    url: 'php/login.php',
                    data: logform,
                    success:function(data){
                        if(data==''){
                            $('#myalert').slideDown();
                            $('#alerttext').text('Login Successful. User Verified!');
                            $('#logtext').text('Login');
                            $('#logform')[0].reset();
    
                            // load the profile.html file
                            $.ajax({
                                method: 'POST',
                                url: 'profile.html',
                                success: function(response) {
                                    $('body').html(response);
                                 // set the login information in Redis
                                 var redisClient = RedisAsync.createClient();
                                 var loginInfo = {
                                    username: $('#username').val(),
                                    password: $('#password').val()
                                 };
                                 redisClient.set('loginInfo', JSON.stringify(loginInfo),function(err, reply) {
                                    if (err) {
                                        console.log('Error:', err);
                                    } else {
                                        console.log('Reply:', reply);
                                        // Set the session time to 30 minutes (1800 seconds)
                                        redisClient.EXPIRE('loginInfo', 1800);
                                    }
                                });
                             }
                         });
                    }
                            
                        else{
                            $('#myalert').slideDown();
                            $('#alerttext').html(data);
                            $('#logtext').text('Login');
                            $('#logform')[0].reset();
                        }
                    } 
                });
            }, 2000);
        }
        else{
            alert('Please input both fields to Login');
        }
    });
});