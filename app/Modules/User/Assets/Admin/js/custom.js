(function ($) {
    "use strict";
    var base_url = $("#base_url").val();
    
    if($('#ajaxusertableform').length){
        var table;
         
        //datatables
        table = $('#ajaxtable').DataTable({ 

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
                "url": base_url+'/user/ajax_list',
                "type": "POST",
                "data": {csrf_test_name:inputval}
            },

            //Set column definition initialisation properties.
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

    if($('#ajaxdeposittableform').length){
        var table;
        var ajaxdeposittableform = JSON.stringify($('#ajaxdeposittableform').serializeArray());
        var formdata          = $.parseJSON(ajaxdeposittableform);
        var inputname         = formdata[0]['name'];
        var inputval          = formdata[0]['value'];
        var user_id           = $('#user_id').val();

        //datatables
        table = $('#deposittable').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [],        //Initial no order.
            "pageLength": 7,   // Set Page Length
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
                "url": base_url+'/user/deposit_list/'+user_id,
                "type": "POST",
                "data": {csrf_test_name:inputval}
            },

            //Set column definition initialisation properties.
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
    if($('#transferreceivetableform').length){
        var table;
        var ajaxdeposittableform = JSON.stringify($('#ajaxdeposittableform').serializeArray());
        var formdata          = $.parseJSON(ajaxdeposittableform);
        var inputname         = formdata[0]['name'];
        var inputval          = formdata[0]['value'];
        var user_id           = $('#user_id').val();

        //datatables
        table = $('#transferreceivetable').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [],        //Initial no order.
            "pageLength": 7,   // Set Page Length 
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
                "url": base_url+'/user/transferreceive_list/'+user_id,
                "type": "POST",
                "data": {csrf_test_name:inputval}
            },

            //Set column definition initialisation properties.
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
    if($('#ajaxinvesttableform').length){
        var table;
        var ajaxinvesttableform = JSON.stringify($('#ajaxinvesttableform').serializeArray());
        var formdata          = $.parseJSON(ajaxinvesttableform);
        var inputname         = formdata[0]['name'];
        var inputval          = formdata[0]['value'];
        var user_id           = $('#user_id').val();

        //datatables
        table = $('#investable').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [],        //Initial no order.
            "pageLength": 7,   // Set Page Length 
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
                "url": base_url+'/user/investment_list/'+user_id,
                "type": "POST",
                "data": {csrf_test_name:inputval}
            },

            //Set column definition initialisation properties.
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
    if($('#ajaxwithdrawtableform').length){
        var table;
        var ajaxwithdrawtableform = JSON.stringify($('#ajaxwithdrawtableform').serializeArray());
        var formdata          = $.parseJSON(ajaxwithdrawtableform);
        var inputname         = formdata[0]['name'];
        var inputval          = formdata[0]['value'];
        var user_id           = $('#user_id').val();
        
        //datatables
        table = $('#withdrawtable').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [],        //Initial no order.
            "pageLength": 7,   // Set Page Length 
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
                "url": base_url+'/user/withdraw_list/'+user_id,
                "type": "POST",
                "data": {csrf_test_name:inputval}
            },

            //Set column definition initialisation properties.
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
    if($('#ajaxtransfertableform').length){
        var table;
        var ajaxtransfertableform = JSON.stringify($('#ajaxtransfertableform').serializeArray());
        var formdata          = $.parseJSON(ajaxtransfertableform);
        var inputname         = formdata[0]['name'];
        var inputval          = formdata[0]['value'];
        var user_id           = $('#user_id').val();
        
        //datatables
        table = $('#transfertable').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [],        //Initial no order.
            "pageLength": 7,   // Set Page Length 
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
                "url": base_url+'/user/transfer_list/'+user_id,
                "type": "POST",
                "data": {csrf_test_name:inputval}
            },

            //Set column definition initialisation properties.
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
     

 
    $(document).on("click", "#flip", function(){
        $(".panel").slideToggle("slow");
    });
  
}(jQuery));


    var base_urls = $("#base_url").val();
    "use strict";
    function reloadFunction(id) {
        
        $("#reload_"+id).html('<i class="fa fa-spinner fa-spin"></i>'); 
        let title = $(this).text(); 
       
        var url = base_urls+"/backend/users/wallet_reload/"+id;
        let postdata = {};
            postdata['id'] = id; 
            postdata[csrf_token] = get_csrf_hash;
            console.log(postdata);
        $.ajax({
            url: url, 
            type: 'post',
            dataType: 'json', 
            data: postdata,
            success: function(res) {
               console.log(res.status); 
               if(res.status == 'success'){
                $('#balance_'+id).html(res.balance);
                $("#reload_"+id).html('Get Balance');
               }else{
                $("#reload_"+id).html('Get Balance');
               }  
            }, 
            error: function(xhr) {
               console.log(xhr);
            }            
        });
    };