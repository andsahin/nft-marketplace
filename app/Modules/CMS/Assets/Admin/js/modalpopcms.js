
"use strict";
$(document).on('click', '#edit-home-page', function() {

    var article_id  = $(this).data("article");
    var inputval    = { 'csrf_test_name': get_csrf_hash, 'article_id': article_id };

    $.ajax({
        url: base_url + "/backend/home/info",
        type: "POST",
        data: inputval,
        success: function (res) {     
            $(".modal_content").html(res);
        }
    });

});

"use strict";
$(document).on('click','.edit-about',function(event) {
     
    var article_id = $(this).data("article");
    var inputval = { 'csrf_test_name': get_csrf_hash, 'article_id': article_id };

    $.ajax({
        url: base_url + "/backend/about/info",
        type: "POST",
        data: inputval,
        success: function (res) {

            $(".modal_content").html(res);
        }
    });
});


"use strict";
$(document).on('click','.edit-contact',function(event) { 
    var article_id = $(this).data("article");
    var inputval = { 'csrf_test_name': get_csrf_hash, 'article_id': article_id };

    $.ajax({
        url: base_url + "/backend/contact/info",
        type: "POST",
        data: inputval,
        success: function (res) { 
            $(".modal_content").html(res);
        }
    });
});

"use strict";
$(document).on('click','.edit-terms',function(event) { 
     
    var article_id = $(this).data("article");
    var inputval = { 'csrf_test_name': get_csrf_hash, 'article_id': article_id };

    $.ajax({
        url: base_url + "/backend/terms/info",
        type: "POST",
        data: inputval,
        success: function (res) {
 
            $(".modal_content").html(res);
        }
    });
});

"use strict";
$(document).on('click','.edit-privacy',function(event) { 
     
    var article_id = $(this).data("article");
    var inputval = { 'csrf_test_name': get_csrf_hash, 'article_id': article_id };

    $.ajax({
        url: base_url + "/backend/privacy/info",
        type: "POST",
        data: inputval,
        success: function (res) {
 
            $(".modal_content").html(res);
        }
    });
});

"use strict";
$(document).on('click','.edit-faq', function(event) {  
    var article_id = $(this).data("article");
    var inputval = { 'csrf_test_name': get_csrf_hash, 'article_id': article_id };

    $.ajax({
        url: base_url + "/backend/faq/info",
        type: "POST",
        data: inputval,
        success: function (res) {
 
            $(".modal_content").html(res);
        }
    });
});

// action - add
"use strict";
$('.add-faq').click(function() {

    var article_id = $(this).data("article");
    var inputval = { 'csrf_test_name': get_csrf_hash };

    $.ajax({
        url: base_url + "/backend/faq/add",
        type: "POST",
        data: inputval,
        success: function (res) {
 
            $(".modal_content").html(res);
        }
    });
});
 

"use strict";
$('.delete-faq').on('click', function(event){
    event.preventDefault();

    var article_id = $(this).data("article");
    var inputval = { 'csrf_test_name': get_csrf_hash, 'article_id': article_id };

    $.ajax({
        url: base_url + "/backend/faq/delete",
        type: "POST",
        data: inputval,
        dataType: "json",
        success: function (res) { 
            if (res === undefined || res.length == 0){
                sweetAlert('success','Deleted succssfully'); 
                $('#v-pills-FAQ-tab').trigger('click');                   
            }else{
                var msg = '';
                $.each(res, function(key,val){
                    msg+=val;
                });
                sweetAlert('error', 'Deleted succssfully');
            }

        }
    });
});

"use strict";
$(document).on('click','.edit-social', function(event) {  
     
    var id       = $(this).data("article");
    var inputval = { 'csrf_test_name': get_csrf_hash, 'id': id };

    $.ajax({
        url: base_url + "/backend/social/info",
        type: "POST",
        data: inputval,
        success: function (res) {
            $(".modal_content").html(res);
        }
    });
});