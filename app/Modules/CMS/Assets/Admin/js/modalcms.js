 
"use strict";
var base_url = $("#base_url").val();

/************************* Home js *******************************/
/* action -update */
"use strict"; 
$('#homeform').on('submit', function(event){
    event.preventDefault();

    var fd                  = new FormData();
    var article_id          = $("input[name=article_id]").val();
    var headline_en         = $("#headline_en").val();
    var article1_en         = $("#article1_en").val();
    var article2_en         = $("#article2_en").val();
    var article_image       = $("#article_image")[0].files[0];


    fd.append('article_id', article_id);
    fd.append('headline_en', headline_en);
    fd.append('article1_en', article1_en);
    fd.append('article2_en', article2_en);
    fd.append('article_image', article_image);
    fd.append('csrf_test_name', get_csrf_hash);

    $.ajax({
        url: base_url + "/backend/home/home_update",
        type: "POST",
        data: fd,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (res) {
            if(res.message !== undefined){
                sweetAlert('success','Update Success');
            }else if (res.exception !== undefined){
                sweetAlert('error',res.exception);                  
            }else{
                var msg = '';
                $.each(res.filter, function(key,val){
                    msg+=val;
                });
                sweetAlert('error',msg);
            }
        }
    });
});

/************************* About js *******************************/
// action -Update
"use strict"; 
$('#aboutform').on('submit', function(event){
    event.preventDefault();
    var inputval = $("#aboutform").serialize();
    $.ajax({
        url: base_url + "/backend/about/about_update",
        type: "POST",
        data: inputval,
        dataType: "json",
        success: function (res) {
            if(res.message !== undefined){
                sweetAlert('success','Update Success');
            }else if (res.exception !== undefined){
                sweetAlert('error',res.exception);                  
            }else{
                var msg = '';
                $.each(res.filter, function(key,val){
                    msg+=val;
                });
                sweetAlert('error',msg);
            }
        }
    });
});

/************************* Contract js *******************************/
"use strict"; 
$('#contactform').on('submit', function(event){
    event.preventDefault();
    var inputval = $("#contactform").serialize();
    $.ajax({
        url: base_url + "/backend/contact/contact_update",
        type: "POST",
        data: inputval,
        dataType: "json",
        success: function (res) {
            if(res.message !== undefined){
                sweetAlert('success','Update Success');
            }else if (res.exception !== undefined){
                sweetAlert('error',res.exception);                  
            }else{
                var msg = '';
                $.each(res.filter, function(key,val){
                    msg+=val;
                });
                sweetAlert('error',msg);
                
            }
        }
    });
});

/************************* Terms js *******************************/
"use strict"; 
$('#termsform').on('submit', function(event){
    event.preventDefault();
    var inputval = $("#termsform").serialize();
    $.ajax({
        url: base_url + "/backend/terms/terms_update",
        type: "POST",
        data: inputval,
        dataType: "json",
        success: function (res) {
            if(res.message !== undefined){
                sweetAlert('success','Update Success');
            }else if (res.exception !== undefined){
                sweetAlert('error',res.exception);                  
            }else{
                var msg = '';
                $.each(res.filter, function(key,val){
                    msg+=val;
                });
                sweetAlert('error',msg);
                
            }
        }
    });
});

/************************* Privacy policy js *******************************/
"use strict"; 
$(document).on('submit','#privacyform',function(event) { 
 
    event.preventDefault();
    var inputval = $("#privacyform").serialize();
    $.ajax({
        url: base_url + "/backend/privacy/privacy_update",
        type: "POST",
        data: inputval,
        dataType: "json",
        success: function (res) {
            if(res.message !== undefined){
                sweetAlert('success','Update Success');
            }else if (res.exception !== undefined){
                sweetAlert('error',res.exception);                  
            }else{
                var msg = '';
                $.each(res.filter, function(key,val){
                    msg+=val;
                });
                sweetAlert('error',msg);
                
            }
        }
    });
});

/************************* FAQ js *******************************/
"use strict"; 
$(document).on('submit','#faqform', function(event) { 
 
    event.preventDefault(); 

    var fd = new FormData();
    var article_id          = $("input[name=article_id]").val();
    var headline_en         = $("#headline_en").val();
    var article1_en         = $("#article1_en").val();

    fd.append('article_id', article_id);
    fd.append('headline_en', headline_en);
    fd.append('article1_en', article1_en);
    fd.append('csrf_test_name', get_csrf_hash);

    $.ajax({
        url: base_url + "/backend/faq/faq_update",
        type: "POST",
        data: fd,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (res) {
            if(res.message !== undefined){
                sweetAlert('success','Update Success');
            }else if (res.exception !== undefined){
                sweetAlert('error',res.exception);                  
            }else{
                var msg = '';
                $.each(res.filter, function(key,val){
                    msg+=val;
                });
                sweetAlert('error',msg);
                
            }
        }
    });
});


"use strict"; 
$('#faqaddform').on('submit', (event)=> { 
 
    event.preventDefault(); 
     
    var fd = new FormData(); 
    var headline_en         = $("#headline_en").val();
    var article1_en         = $("#article1_en").val(); 
     
    fd.append('headline_en', headline_en);
    fd.append('article1_en', article1_en);
    fd.append('csrf_test_name', get_csrf_hash);

    $.ajax({
        url: base_url + "/backend/faq/faq_save",
        type: "POST",
        data: fd,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (res) {
            if(res.message !== undefined){
                sweetAlert('success','Successfully added'); 
            }else if (res.exception !== undefined){
                sweetAlert('error',res.exception);                  
            }else{
                var msg = '';
                $.each(res.filter, function(key,val){
                    msg+=val;
                });
                sweetAlert('error',msg);
                
            }
        }
    });
});

/************************* Social Link js *******************************/
"use strict"; 
$('#socialform').on('submit', function(event){
    event.preventDefault();
    var inputval = $("#socialform").serialize();
    $.ajax({
        url: base_url + "/backend/social/social_update",
        type: "POST",
        data: inputval,
        dataType: "json",
        success: function (res) {
            if(res.message !== undefined){
                sweetAlert('success','Update Success');
            }else if (res.exception !== undefined){
                sweetAlert('error',res.exception);                  
            }else{
                var msg = '';
                $.each(res.filter, function(key,val){
                    msg+=val;
                });
                sweetAlert('error',msg);
            }
        }
    });
}); 

(function ($) {
    "use strict";
    if($('.editorabount').length && $.fn.summernote){
        $('.editorabount').summernote({
            height: 400,
            minHeight: null,
            maxHeight: null,
            focus: true
        });
    }
}(jQuery));


(function ($) {
    "use strict";
    if($('.editorterms').length && $.fn.summernote){
        $('.editorterms').summernote({
            height: 400,
            minHeight: null,
            maxHeight: null,
            focus: true
        });
    }
}(jQuery));


(function ($) {
    "use strict";
    if($('.editorprivacy').length && $.fn.summernote){
        $('.editorprivacy').summernote({
            height: 400,
            minHeight: null,
            maxHeight: null,
            focus: true
        });
    }
}(jQuery));
 