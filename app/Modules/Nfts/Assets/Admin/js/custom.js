(function ($) {

    "use strict";

    var base_url = $("#base_url").val();
        
    if($('#ajaxusertableform_nft').length){ 
        var table;
        
        //datatables
        table = $('#ajaxtable_nft').DataTable({ 


            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [],        //Initial no order.
           
            "paging": true,
            "searching": true,
            dom: "<'row'<'col-sm-3'l><'col-sm-3'B><'col-sm-3'f>>tp", 
            dom: 'Bfrtip',
            "buttons": [
                {
                        extend: 'copy',
                        text: '<i class="far fa-copy"></i>',
                        titleAttr: 'Copy',
                        className: 'btn-success'
                    },
                            {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i>',
                        titleAttr: 'CSV',
                        className: 'btn-success'
                    },
                    {
                        extend: 'excel',
                         text: '<i class="far fa-file-excel"></i>',
                        titleAttr: 'Excel',
                        className: 'btn-success'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="far fa-file-pdf"></i>',
                        titleAttr: 'PDF',
                        className: 'btn-success'
                    },
                    {
                        extend: 'print',
                          text: '<i class="fa fa-print" aria-hidden="true"></i>',
                        titleAttr: 'Print',
                        className: 'btn-success'
                    }
        ],
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": base_url+'/backend/nft/ajax_list',
                "type": "POST",
                "data": ""
            },

             
            "columnDefs": [
            { 
                "targets": [ 0 ], //first column / numbering column
                "orderable": false, //set not orderable
            },
            ],
           "fnInitComplete": function (oSettings, response) {
          }

        });

        $.fn.dataTable.ext.errMode = 'none';
    }



    $(document).on("change", "#is_featured", function(){
        
        let value = $('#is_featured').val();
       
        if ($('#is_featured').is(":checked"))
        {
          
           var url = base_url+"/backend/nft/is_featured/"+value+"/check"; 
            $.ajax({
                url: url,
                type: 'GET', 
                success: function(res){
                    var result = JSON.parse(res); 
                    if(result.status == true){
                        sweetAlert('success', result.msg);
                    }
                }
            });
        }else{ 
            
            var url = base_url+"/backend/nft/is_featured"+value+"/uncheck"; 
           
            $.ajax({
                url: url,
                type: 'GET', 
                success: function(res){
                    var result = JSON.parse(res)
                   
                    if(result.status == true){
                        sweetAlert('success', result.msg);
                    }
                }
            });
        }

        
    });


    $(document).on("click", "#detail_change_status", function(){
        
        let val = $(this).attr("infostatus");
        let id  = $(this).attr("infoid");

        let optionData  = "";
        let bodyData    = [];
        bodyData[0] = "Pending";
        bodyData[1] = "Active";
        bodyData[2] = "Suspend";

        for(let i=0; i<=2;i++){
            optionData+= "<option value='"+i+"' "+(i==val?'selected':'null')+">"+(bodyData[i])+"</option>";
        }

       
        $('.nftHtmlData_'+id).html("");
        $('.nftHtmlData_'+id).html('<select id="change_val" valid="'+id+'" class"form-control">'+optionData+'</select>');
    });


    $(document).on("change", "#change_val", function(){

        let id  = $(this).attr("valid");
        var value = $("#change_val").val();
        if(value == 2){
            $(".suspend-msg-input").removeClass('d-none'); 
        }else{
          $(".suspend-msg-input").css('display','none'); 
        }

       
        if(value != 2){
            
            var url = base_url+"/backend/nft/changestatus/"+id+"/"+value;
            $.ajax({
                url: url,
                type: 'GET',
                data: {csrf_token : get_csrf_hash},
                success: function(res){
                    var result = JSON.parse(res)
                     
                    if(result.status === 'success'){
                        if(value == 1){
                           $('.nftHtmlData_'+id).html('<span id="detail_change_status" infoid="'+id+'" infostatus="'+value+'"class="btn btn-success btn-md ">Active <i class="fas fa-angle-down" ></i> </span>'); 
                           sweetAlert('success', 'Activate');
                        }else if(value == 0){
                            $('.nftHtmlData_'+id).html('<span id="detail_change_status" infoid="'+id+'" infostatus="'+value+'" class="btn btn-warning btn-md ">Pending <i class="fas fa-angle-down" ></i></span>');
                            sweetAlert('warning', 'Deactivate');
                        }
                     
                    }
                }
            });
        }

    });


    function readProfile(input) { 
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile_tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function readBanner(input) {
         
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#banner_tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile_img").change(function(){
        
        readProfile(this);
    });
    $("#banner_img").change(function(){
      
        readBanner(this);
    });


    function readProfile(input) { 
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#profile_tag').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#profile_img").change(function(){
            
        readProfile(this);
    });
    $("#banner_img").change(function(){
      
        readBanner(this);
    });


    $("#contract_form").on("submit", (event)=>{
        event.preventDefault(); 
        var inputval = $("#contract_form").serialize();
        $(".deployedmsg").text('Please wait for smart contract to deploy. (Estimated time: 1-2 minutes)');
        $(".aftersubmit").html('<button class="btn btn-success" disabled><i class="fa fa-spinner fa-spin"></i></button>');
        
        $.ajax({
            url: base_url + "/backend/nft/nft_setup_ajax",
            type: "POST",
            data: inputval,
            dataType: "json",
            success: function (res) {  
                 
                if(res.status === 'success'){

                    setTimeout( function() { 
                        $.ajax({
                            url: base_url + "/backend/nft/set_contract",
                            type: "POST",
                            data: inputval,
                            dataType: "json",
                            success: function (res2) {
                                $(".aftersubmit").html('<button type="submit" class="btn btn-success">Deploy</button>');  
                                location.reload();
                            } 
                        }); 
                    }, 10000);

                    
                }else{
                    $('#contract_form').trigger("reset");
                    $(".aftersubmit").html('<button type="submit" class="btn btn-success">Deploy</button>'); 

                    $('.msg').html('<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+res.message+'</div>');
                }
                
            }

        });
 
    });
 

}(jQuery));

var base_urls = $("#base_url").val();
"use strict";
function mfun(id, val) {
     
    
    let optionData  = "";
    let bodyData    = [];
    bodyData[0] = "Pending";
    bodyData[1] = "Verified";

    for(let i=0; i<=1;i++){
        optionData+= "<option value='"+i+"' "+(i==val?'selected':'null')+">"+(bodyData[i])+"</option>";
    }
 
    $('.nftHtmlData_'+id).html("");
    $('.nftHtmlData_'+id).html('<select id="change_val" onchange="changestatusFun('+id+')" class"form-control">'+optionData+'</select>');

}

"use strict";
function changestatusFun(id) {
    
    var value = $("#change_val").val(); 
    var url = base_urls+"/backend/nft/changestatus/"+id+"/"+value;
    
    $.ajax({
        url: url,
        type: 'GET', 
        success: function(res){
            var result = JSON.parse(res)
           
            if(result.status === 'success'){
                if(value == 1){
                   $('.nftHtmlData_'+id).html('<span onclick="mfun('+id+','+value+')" class="btn btn-success btn-md ">Verified <i class="fas fa-angle-down" ></i> </span>'); 
                   sweetAlert('success', 'Activate');
                }else if(value == 2){
                     $('.nftHtmlData_'+id).html('<span onclick="mfun('+id+','+value+')" class="btn btn-danger btn-md ">Suspend <i class="fas fa-angle-down" ></i></span>');
                }else if(value == 0){
                    $('.nftHtmlData_'+id).html('<span onclick="mfun('+id+','+value+')" class="btn btn-warning btn-md ">Pending <i class="fas fa-angle-down" ></i></span>');
                    sweetAlert('warning', 'Deactivate');
                }
             
            }
        }
    });
}


/* Type status change functions */
"use strict";
function typestatus(id, val) {
     
 
    let optionData  = "";
    let bodyData    = [];
    bodyData[0] = "Deactive";
    bodyData[1] = "Active"; 

    for(let i=0; i<=1;i++){
        optionData+= "<option value='"+i+"' "+(i==val?'selected':'null')+">"+(bodyData[i])+"</option>";
    }

 
    $('.typestatus_'+id).html("");
    $('.typestatus_'+id).html('<select id="change_val" onchange="typestatusChange('+id+')" class"form-control">'+optionData+'</select>');
}

"use strict";
function typestatusChange(id) {
     
    var value = $("#change_val").val();
    
 
    var url = base_urls+"/backend/nft/transfer_option_change/"+id+"/"+value;
    $.ajax({
        url: url,
        type: 'GET',
        data: {csrf_token : get_csrf_hash},
        success: function(res){
            var result = JSON.parse(res)
     
            if(result.status === 'success'){
                if(value == 1){
                   $('.typestatus_'+id).html('<span onclick="typestatus('+id+','+value+')" class="btn btn-success btn-md ">Active <i class="fas fa-angle-down" ></i> </span>'); 
                }else if(value == 0){
                    $('.typestatus_'+id).html('<span onclick="typestatus('+id+','+value+')" class="btn btn-warning btn-md ">Deactive <i class="fas fa-angle-down" ></i></span>');
                }
             
            }
        }
    });
}


/* Selling type status change option */
"use strict";
function selling_typestatus(id, val) {
  
 
    let optionData  = "";
    let bodyData    = [];
    bodyData[0] = "Deactive";
    bodyData[1] = "Active"; 

    for(let i=0; i<=1;i++){
        optionData+= "<option value='"+i+"' "+(i==val?'selected':'null')+">"+(bodyData[i])+"</option>";
    }

 
    $('.typestatus_'+id).html("");
    $('.typestatus_'+id).html('<select id="change_val" onchange="selling_typestatusChange('+id+')" class"form-control">'+optionData+'</select>');
}

"use strict";
function selling_typestatusChange(id) {
     
    var value = $("#change_val").val();
     
    var url = base_urls+"/backend/nft/typestatuschange/"+id+"/"+value;
    $.ajax({
        url: url,
        type: 'GET',
        data: {csrf_token : get_csrf_hash},
        success: function(res){
            var result = JSON.parse(res)
             
            if(result.status === 'success'){
                if(value == 1){
                   $('.typestatus_'+id).html('<span onclick="selling_typestatus('+id+','+value+')" class="btn btn-success btn-md ">Active <i class="fas fa-angle-down" ></i> </span>'); 
                    sweetAlert('success', 'Activate');

                    }else if(value == 0){
                    $('.typestatus_'+id).html('<span onclick="selling_typestatus('+id+','+value+')" class="btn btn-warning btn-md ">Deactive <i class="fas fa-angle-down" ></i></span>');
                    sweetAlert('warning', 'Deactivate');
                }
             
            }
        }
    });

}



/* A wallet reload function */
"use strict";
function reloadFunction(id) {
     

    $("#reload_"+id).html('<i class="fa fa-spinner fa-spin"></i>');
    let title = $(this).text();  
    var url = base_urls+"/backend/nft/wallet_reload/"+id;
    let postdata = {};
        postdata['id'] = id; 
        postdata[csrf_token] = get_csrf_hash;
     
    $.ajax({
        url: url, 
        type: 'post',
        dataType: 'json', 
        data: postdata,
        success: function(res) {
          
           if(res.status == 'success'){
            $('#balance_'+id).html(res.balance);
            $("#reload_"+id).html('<i class="fa fa-cog" aria-hidden="true"></i> Reload Balance');
           }else{
            $("#reload_"+id).html('<i class="fa fa-cog" aria-hidden="true"></i> Reload Balance');
           }  
        }, 
        error: function(xhr) {
            
          }            
    });

}; 