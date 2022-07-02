 
"use strict";  
$("document").ready(function() {
    $("#v-pills-Home-tab").trigger('click');
});

var base_url = $("#base_url").val(); 

// Page content load
"use strict"; 
$(document).on('click', '#v-pills-Home-tab', function(event) {
    event.preventDefault();
    var inputval = { 'csrf_test_name': get_csrf_hash };
    $.ajax({
        url: base_url + "/backend/home/home_list",
        type: "POST",
        data: inputval,
        success: function (res) { 
            $("#v-pills-Home").html(res); 
        }
    });
});

"use strict"; 
$(document).on('click', '#v-pills-About-tab', function(event) {
    event.preventDefault();
    var inputval = { 'csrf_test_name': get_csrf_hash };
    $.ajax({
        url: base_url + "/backend/about/about_list",
        type: "POST",
        data: inputval,
        success: function (res) {  
            $("#v-pills-About").html(res); 

        }
    });
});

"use strict"; 
$(document).on('click','#v-pills-Contact-tab',function(event) {
    event.preventDefault();
    var inputval = { 'csrf_test_name': get_csrf_hash };
    $.ajax({
        url: base_url + "/backend/contact/contact_list",
        type: "POST",
        data: inputval,
        success: function (res) { 
            $("#v-pills-Contact").html(res); 
        }
    });
});
 
"use strict"; 
$(document).on('click','#v-pills-Terms-tab',function(event) {
    var inputval = { 'csrf_test_name': get_csrf_hash };

    $.ajax({
        url: base_url + "/backend/terms/terms_list",
        type: "POST",
        data: inputval,
        success: function (res) {
            $("#v-pills-Terms").html(res);
        }
    });
});

"use strict"; 
$(document).on('click','#v-pills-Privacy-tab',function(event) {
    var base_url = $("#base_url").val();
    var inputval = { 'csrf_test_name': get_csrf_hash };

    $.ajax({
        url: base_url + "/backend/privacy/privacy_list",
        type: "POST",
        data: inputval,
        success: function (res) {
            $("#v-pills-Privacy").html(res);
        }
    });
});

"use strict"; 
$(document).on('click','#v-pills-FAQ-tab',function(event) {
    var base_url = $("#base_url").val();
    var inputval = { 'csrf_test_name': get_csrf_hash };

    $.ajax({
        url: base_url + "/backend/faq/faq_list",
        type: "POST",
        data: inputval,
        success: function (res) {
            $("#v-pills-FAQ").html(res);
        }
    });
});

"use strict"; 
$(document).on('click','#v-pills-Social-tab',function(event) {
    var base_url = $("#base_url").val();
    var inputval = { 'csrf_test_name': get_csrf_hash };

    $.ajax({
        url: base_url + "/backend/social/social_list",
        type: "POST",
        data: inputval,
        success: function (res) {
            $("#v-pills-Social").html(res);
        }
    });
});
 