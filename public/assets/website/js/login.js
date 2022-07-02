$(document).ready(function () {
	"use strict"; // Start of use strict
  
    let state = false;
     
    $(document).on("click", "#password_toggle", function(){

       
        if (state) {
            document.getElementById("password_login").setAttribute("type", "password");
            state = false;
        } else {
            document.getElementById("password_login").setAttribute("type", "text")
            state = true;
        }

    });
    
   
    let state1 = false;
    $(document).on("click", "#password_toggle", function(){

        if (state1) { 
            $(".eye-change").removeClass("fa-eye-slash");
            state1 = false;
        } else { 
            $(".eye-change").addClass("fa-eye-slash");
            state1 = true;
        }
        
    });
 


    let password 			= document.getElementById("password");
    let passwordStrength 	= document.getElementById("password-strength");
    let lowUpperCase 		= document.querySelector(".low-upper-case i");
    let number 				= document.querySelector(".one-number i");
    let specialChar 		= document.querySelector(".one-special-char i");
    let eightChar 			= document.querySelector(".eight-character i");

    $(document).on("keyup", "#password", function () {

        let pass 	= document.getElementById("password").value;
        var test 	= checkStrength(pass);

        if(test != 4){
            $("#reg-submit-btn").attr('disabled', 'disabled'); 
            document.getElementById("password").style.borderColor = '#f00';
        }else{
            $("#reg-submit-btn").removeAttr('disabled');
            document.getElementById("password").style.borderColor = '';
        } 

    });
      
    function checkStrength(password) {
        let strength = 0;

        //If password contains both lower and uppercase characters
        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) {
            strength += 1;
            console.log(strength);
            lowUpperCase.classList.remove('fa-circle');
            lowUpperCase.classList.add('fa-check');
            console.log(lowUpperCase);
        } else {
            lowUpperCase.classList.add('fa-circle');
            lowUpperCase.classList.remove('fa-check');
            
        }
        //If it has numbers and characters
        if (password.match(/([0-9])/)) {
            strength += 1;
            number.classList.remove('fa-circle');
            number.classList.add('fa-check');
        } else {
            number.classList.add('fa-circle');
            number.classList.remove('fa-check');
        }
        //If it has one special character
        if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) {
            strength += 1;
            specialChar.classList.remove('fa-circle');
            specialChar.classList.add('fa-check');
        } else {
            specialChar.classList.add('fa-circle');
            specialChar.classList.remove('fa-check');
        }
        //If password is greater than 7
        if (password.length > 7) {
            strength += 1;
            eightChar.classList.remove('fa-circle');
            eightChar.classList.add('fa-check');
        } else {
            eightChar.classList.add('fa-circle');
            eightChar.classList.remove('fa-check');
        }
        // If value is less than 2
        if (strength < 2) {
            passwordStrength.classList.remove('progress-bar-warning');
            passwordStrength.classList.remove('progress-bar-success');
            passwordStrength.classList.add('progress-bar-danger');
            passwordStrength.style = 'width: 33.333%';
        } else if (strength == 3) {
            passwordStrength.classList.remove('progress-bar-success');
            passwordStrength.classList.remove('progress-bar-danger');
            passwordStrength.classList.add('progress-bar-warning');
            passwordStrength.style = 'width: 66.666%';
        } else if (strength == 4) {
            passwordStrength.classList.remove('progress-bar-warning');
            passwordStrength.classList.remove('progress-bar-danger');
            passwordStrength.classList.add('progress-bar-success');
            passwordStrength.style = 'width: 100%';

            return strength;
        }
        return strength;
    }



    $("#emailadderss").on("keyup", function(){
        var email 		= $("#emailadderss").val();
        var baseUrl 	= $("#baseval").val();

        var regex 		= /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/; 
        var test 		= regex.test(email);
         
        var url = baseUrl+'/user/checkemail/'+email;
        
        if(test == true){ 
            $.ajax({
                url: url, 
                type:'GET',
                dataType: 'json', 
                contentType: 'application/json',
                success: function (data) { 
                    console.log(data)
                    if(data.status == 'success'){ 
                        $("#emailadderss").removeClass('is-invalid'); 
                        $("#emailadderss").addClass('is-valid');  
                        $(".valid-feedback-email").text(data.msg);  
                        $("#email-feedback").addClass(data.class);  
                        $("#email-feedback").removeClass('text-danger');  
                        if($('#pass').val()){
                            $("#reg-submit-btn").removeAttr('disabled');
                        }  
                    }else{
                        $(".valid-feedback-email").text(data.msg); 
                        $("#emailadderss").removeClass('is-valid'); 
                        $("#emailadderss").addClass('is-invalid');
                        $("#reg-submit-btn").attr('disabled', 'disabled');
                    }   
                }
            });
        }else{
            $("#emailadderss").addClass('is-invalid');
            $(".valid-feedback-email").text('Invalid email'); 
            $(".valid-feedback-email").addClass('text-danger');
            $("#reg-submit-btn").attr('disabled', 'disabled');
        }
 
    });


    $("#username").on("keyup", function(){
        var name 		= $("#username").val();
        var baseUrl 	= $("#baseval").val();

        var regex 		= /^[a-zA-Z0-9 ]+$/; 
        var test 		= regex.test(name);
         
        var url 		= baseUrl+'/user/check_username/'+name;
        
        if(test == true && name.length > 6){ 
            $.ajax({
                url: url, 
                type:'GET',
                dataType: 'json', 
                contentType: 'application/json',
                success: function (data) { 
                    console.log(data)
                    if(data.status == 'success'){ 
                        $("#username").removeClass('is-invalid'); 
                        $("#username").addClass('is-valid');  
                        $(".valid-feedback-username").text(data.msg);  
                        $("#username-feedback").addClass(data.class);  
                        $("#username-feedback").removeClass('text-danger');  
                        if($('#pass').val()){
                            $("#reg-submit-btn").removeAttr('disabled');
                        }  
                    }else{
                        $(".valid-feedback-username").text(data.msg);
                        $(".valid-feedback-username").addClass(data.class);  
                        $("#username").removeClass('is-valid'); 
                        $("#username").addClass('is-invalid');
                        $("#reg-submit-btn").attr('disabled', 'disabled');
                    }   
                }
            });
        }else{
            $("#username").addClass('is-invalid');
            $(".valid-feedback-username").text('Invalid username'); 
            $(".valid-feedback-username").addClass('text-danger'); 
            $("#reg-submit-btn").attr('disabled', 'disabled');
        }

    });

    // Password confirm check
    $('#conf_pass,#password').keyup(function() {
         
        if($('#password').val() != $('#conf_pass').val()) {
            $("#reg-submit-btn").attr('disabled', 'disabled');
           	document.getElementById("conf_pass").style.borderColor = '#f00';
            // Prevent form submission
            event.preventDefault();
            
        }else{      
         	document.getElementById("conf_pass").style.borderColor = 'unset';
            if($('#password').val()){
                $("#reg-submit-btn").removeAttr('disabled');
            } 
            // Prevent form submission
            event.preventDefault();
            
            

        }
    });


    let tblInfo = $("table tbody tr");
    tblInfo.click(function(){
        
        const email     = $(this).children().first().text();
        const password  = $(this).children().first().next().text();

        $("input[name=email]").val(email);
        $("input[name=password]").val(password);
        console.log(password)
    });

});