(function ($) {
"use strict";
    var base_url = $("#base_url").val();
  
    var segment = $("#segment").val();
    var language = $("#language").val();
  $('.copy1').on('click',function(){
        myFunction1();
    });
     function myFunction1() {
      var copyText = document.getElementById("copyed1");
      copyText.select();
      document.execCommand("Copy");
    }
    $('.copy2').on('click',function(){
        myFunction2();
    });
    function myFunction2() {
      var copyText = document.getElementById("copyed2");
      copyText.select();
      document.execCommand("Copy");
    }
    $("#gatewayname").on("change", function(event) {
        event.preventDefault();
        var gatewayname = $("#gatewayname").val();

        $.getJSON(base_url+'/internal_api/getemailsmsgateway', function(sms){

            var host     = "";
            var user     = "";
            var userid   = "";
            var api      = "";
            var password = "";

            if(sms.gatewayname=="budgetsms"){
                host    = sms.host;
                user    = sms.user;
                userid  = sms.userid;
                api     = sms.api;
            }
            if(sms.gatewayname=="infobip"){
                host    = sms.host;
                user    = sms.user;
                password= sms.password;
            }
            if(sms.gatewayname=="nexmo"){
                api     = sms.api;
                password= sms.password;
            }

            if (gatewayname==='budgetsms') {
                $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-sm-3 col-md-3 col-form-label'>"+lan['host'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9 '><input name='host' type='text' class='form-control' id='host' placeholder='"+lan['host'][language]+"' value='"+host+"' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-sm-3  col-form-label'>"+lan['username'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='user' type='text' class='form-control' id='user' placeholder='"+lan['username'][language]+"' value='"+user+"' required></div></div><div class='form-group row'><label for='userid' class='col-xs-3 col-sm-3 col-form-label'>"+lan['user_id'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='userid' type='text' class='form-control' id='userid' placeholder='"+lan['user_id'][language]+"' value='"+userid+"' required></div></div><div class='form-group row'><label for='api' class='col-xs-3 col-sm-3 col-form-label'>"+lan['apikey'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='api' type='text' class='form-control' id='api' placeholder='"+lan['apikey'][language]+"' value='"+api+"' required></div></div>");

            }else if(gatewayname==='infobip'){
               $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-sm-3 col-form-label'>"+lan['host'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='host' type='text' class='form-control' id='host' placeholder='"+lan['host'][language]+"' value='"+host+"' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-sm-3  col-form-label'>"+lan['username'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='user' type='text' class='form-control' id='user' placeholder='"+lan['username'][language]+"' value='"+user+"' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-sm-3 col-form-label'>"+lan['password'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='password' type='password' class='form-control' id='password' placeholder='"+lan['password'][language]+"' value='"+password+"' required></div></div>");

            }else if(gatewayname==='nexmo'){
               $( "#sms_field").html("<div class='form-group row'><label for='api' class='col-xs-3 col-sm-3 col-form-label'>"+lan['apikey'][language]+"<i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='api' type='text' class='form-control' id='api' placeholder='"+lan['apikey'][language]+"' value='"+api+"' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-sm-3  col-form-label'>"+lan['app_secret'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='password' type='password' class='form-control' id='password' placeholder='"+lan['password'][language]+"' value='"+password+"' required></div></div>");

            }else if(gatewayname==='twilio'){
                $( "#sms_field").html("<h3><a href='https://www.twilio.com'>Twilio</a> Is On Development</h3>"); 

            }
            else{
                $( "#sms_field").html("<h3>Nothing Found</h3>");

            }

        });
    });

    if($("#gatewayname").length){
        var gatewayname = $("#gatewayname").val();
        
        if(gatewayname){
            $.getJSON(base_url+'/internal_api/getemailsmsgateway', function(sms){

                var host     = "";
                var user     = "";
                var userid   = "";
                var api      = "";
                var password = "";

                if(sms.gatewayname=="budgetsms"){
                    host    = sms.host;
                    user    = sms.user;
                    userid  = sms.userid;
                    api     = sms.api;
                }
                if(sms.gatewayname=="infobip"){
                    host    = sms.host;
                    user    = sms.user;
                    password= sms.password;
                }
                if(sms.gatewayname=="nexmo"){
                    api     = sms.api;
                    password= sms.password;
                }

                if (gatewayname==='budgetsms') {
                    $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-sm-3 col-form-label'>"+lan['host'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='host' type='text' class='form-control' id='host' placeholder='"+lan['host'][language]+"' value='"+host+"' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-sm-3 col-form-label'>"+lan['username'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='user' type='text' class='form-control' id='user' placeholder='"+lan['username'][language]+"' value='"+user+"' required></div></div><div class='form-group row'><label for='userid' class='col-xs-3 col-sm-3 col-form-label'>"+lan['user_id'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='userid' type='text' class='form-control' id='userid' placeholder='"+lan['user_id'][language]+"' value='"+userid+"' required></div></div><div class='form-group row'><label for='api' class='col-xs-3 col-sm-3 col-form-label'>"+lan['apikey'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='api' type='text' class='form-control' id='api' placeholder='"+lan['apikey'][language]+"' value='"+api+"' required></div></div>");

                }else if(gatewayname==='infobip'){
                   $( "#sms_field").html("<div class='form-group row'><label for='host' class='col-xs-3 col-sm-3 col-form-label'>"+lan['host'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='host' type='text' class='form-control' id='host' placeholder='"+lan['host'][language]+"' value='"+host+"' required></div></div><div class='form-group row'><label for='user' class='col-xs-3 col-sm-3 col-form-label'>"+lan['username'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='user' type='text' class='form-control' id='user' placeholder='"+lan['username'][language]+"' value='"+user+"' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-sm-3 col-form-label'>"+lan['password'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='password' type='password' class='form-control' id='password' placeholder='"+lan['password'][language]+"' value='"+password+"' required></div></div>");

                }else if(gatewayname==='nexmo'){
                   $( "#sms_field").html("<div class='form-group row'><label for='api' class='col-xs-3 col-sm-3 col-form-label'>"+lan['apikey'][language]+"<i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='api' type='text' class='form-control' id='api' placeholder='"+lan['apikey'][language]+"' value='"+api+"' required></div></div><div class='form-group row'><label for='password' class='col-xs-3 col-sm-3 col-form-label'>"+lan['app_secret'][language]+" <i class='text-danger'>*</i></label><div class='col-xs-9 col-sm-9'><input name='password' type='password' class='form-control' id='password' placeholder='"+lan['password'][language]+"' value='"+password+"' required></div></div>");

                }else if(gatewayname==='twilio'){
                    $( "#sms_field").html("<h3><a href='https://www.twilio.com'>Twilio</a> Is On Development</h3>"); 

                }
                else{
                    $( "#sms_field").html("<h3>Nothing Found</h3>");

                }
            });
        }
    }

    $(document).on("change", "#fees_level", function(){
        let level = $(this).val();
        if(level == 'transfer'){
            $("#fees_system").text('Amount');
        }else{
            $("#fees_system").text('%');
        } 
    });

}(jQuery));