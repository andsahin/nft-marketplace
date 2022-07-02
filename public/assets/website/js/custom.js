$(document).ready(function () {
    "use strict"; // Start of use strict
 
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = dd + '/' + mm  + '/' + yyyy; 



    $(".navbar").each(function () {
        $(".search", this).on("click", function (e) {
            e.preventDefault();
            $(".top-search").slideToggle();
        });
    });
    
    $(".input-group-addon.close-search").on("click", function () {
        $(".top-search").slideUp();
    });



    // navbar add remove calss
    var header = $(".no-background");
    $(window).on('scroll', function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 1) {
            header.removeClass('no-background').addClass("topbar-bg");
        } else {
            header.removeClass("topbar-bg").addClass('no-background');
        }
    });
    // Navbar collapse hide
    $('.navbar-collapse .navbar-toggler').on('click', function () {
        $('.navbar-collapse').collapse('hide');
    });



    var base_url = $("#siteuri").attr('mybaseuri');

    $('.collection-card-carousel').owlCarousel({
        loop: true,
        margin: 20,
        dots: false,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    })
    
    // favorite item update javascripts start
    $('body').on('click','.favorite_item, .d-fav-item',function(){

        let base_uri = $("#siteuri").attr('mybaseuri');
       
        let thisItem    = $(this);
        let nftId       = $(this).attr('nftId');
        let favoriteVal = $(this).attr('favoriteVal');
        let url         = base_uri+"/favourite_items/"+nftId;

        $.ajax({
            url: url, 
            type:'GET',
            dataType: 'json', 
            contentType: 'application/json',
            success: function (data) { 
                if(data.value == 1){
                   favoriteVal++;
                 $(".like-number_"+nftId).text(favoriteVal);
                 thisItem.attr('favoriteVal',favoriteVal);
                 $(".like-icon_"+nftId).addClass("like-active");

                }else if(data.value == 0){
                    let currentVal = $(".like-number_"+nftId).text();
                    currentVal--;
                    $(".like-number_"+nftId).text(currentVal);
                    thisItem.attr('favoriteVal',currentVal);
                    $(".like-icon_"+nftId).removeClass("like-active");
                }else{
                    $(".like-number_"+nftId).text(Number(favoriteVal)); 
                    sweetAlert('warning', 'You are not logged in'); 
                }
            }
        });

    });
 // favorite item update javascripts end



        /** Auction js start */ 
        var startAuction = $(".start-auction").attr("start_auction");
        var endAuction = $(".end-auction").attr("end_auction");  
         
        const currentTime = new Date();
        const startTime = new Date(startAuction);
        const endTime = new Date(endAuction);
        var difference_start_end = endTime.getTime() - startTime.getTime();
        var difference_in_sec = difference_start_end / (1000);

        var difference_in_start_current = currentTime.getTime() - startTime.getTime();
        var difference_in_current_start_seceond = difference_in_start_current / (1000);

        var final_counter_time = (difference_in_sec - difference_in_current_start_seceond);
            
         
        var seconds = Math.floor(final_counter_time);
         
        function auctionTimer() {
          var days        = Math.floor(seconds/24/60/60);
          var hoursLeft   = Math.floor((seconds) - (days*86400));
          var hours       = Math.floor(hoursLeft/3600);
          var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
          var minutes     = Math.floor(minutesLeft/60);
          var remainingSeconds = seconds % 60;
          function pad(n) {
            return (n < 10 ? "0" + n : n);
          }
          
            document.getElementById("days").innerText = Math.floor(days),
            document.getElementById("hours").innerText = Math.floor(hours),
            document.getElementById("minutes").innerText = Math.floor(minutes),
            document.getElementById("seconds").innerText = Math.floor(remainingSeconds);
          if (seconds == 0) {
           
            clearInterval(countdownTimer);
            document.getElementById('countdown').innerHTML = "Completed";
            
          } else { 
            seconds--;
          }
        }

        if(seconds >= 0){
             
            
           setInterval(auctionTimer, 1000);  // per second check this 
        }
         /** Auction js start */ 




        function getUserNfts(l) {
            let base_uri = $("#siteuri").attr('mybaseuri'); 
            let tab = $("#nftdata").attr('mytab');  
            if(tab == ''){
                tab = null;
            }
            var grtUserNftsUrl = base_uri+"/user/getmynfts/"+l+"/"+tab; 
             
            $.ajax({
                url: grtUserNftsUrl, 
                type:'GET',
                dataType: 'json', 
                contentType: 'application/json',
                success: function (res) { 
                
                    $("#nftdata").html(res.data);  
                }
            });
        }
        getUserNfts(1);


        function getcollectionNfts(l) {
            let base_uri = $("#siteuri").attr('mybaseuri');
            let coll_id = $("#ajax_collection_wise_nfts").attr('collect-id');
            var grtCollNftsUrl = base_uri+"/ajax_coll_nfts/"+coll_id+"/"+l;  
            if(coll_id){
               $.ajax({
                    url: grtCollNftsUrl, 
                    type:'GET',
                    dataType: 'json', 
                    contentType: 'application/json',
                    success: function (res) {  
                        $("#ajax_collection_wise_nfts").html(res.data);  
                    }
                }); 
            }
            
        }
        getcollectionNfts(1);


        function getCategoryNfts(l) {
            let base_uri = $("#siteuri").attr('mybaseuri');
            let cat_id = $("#ajax_category_wise_nfts").attr('cat-id');
            var grtCollNftsUrl = base_uri+"/ajax_cat_nfts/"+cat_id+"/"+l;  
            if(cat_id){
               $.ajax({
                    url: grtCollNftsUrl, 
                    type:'GET',
                    dataType: 'json', 
                    contentType: 'application/json',
                    success: function (res) {  
                        $("#ajax_category_wise_nfts").html(res.data);  
                    }
                }); 
            }
            
        }
        getCategoryNfts(1);


        function getfrontUserNfts(l) {
            let base_uri = $("#siteuri").attr('mybaseuri');
            let userId = $("#ajax_user_wise_nfts").attr('user-id');
            var grtCollNftsUrl = base_uri+"/ajax_user_nfts/"+userId+"/"+l;  
            if(userId){
              $.ajax({
                    url: grtCollNftsUrl, 
                    type:'GET',
                    dataType: 'json', 
                    contentType: 'application/json',
                    success: function (res) {  
                        $("#ajax_user_wise_nfts").html(res.data);  
                    }
                });  
            }
            
        }
        getfrontUserNfts(1);

        

        let cat_id = 'no';
        let col_id = 'no';
        function getAllNfts(cat_id, col_id, l) {
            let base_uri = $("#siteuri").attr('mybaseuri');
            
            var grtCollNftsUrl = base_uri+"/ajax_all_nfts/"+cat_id+"/"+col_id+"/"+l;  
         
            $.ajax({
                url: grtCollNftsUrl, 
                type:'GET',
                dataType: 'json', 
                contentType: 'application/json',
                success: function (res) {  
                    $("#ajax_all_nfts").html(res.data);  
                }
            });
        }
        getAllNfts(cat_id, col_id, 1);

        $(".category-dropdown").on("click", function(){
            cat_id = $(this).attr('category-id'); 
            getAllNfts(cat_id, col_id, 1); 
        });

        $(".collection-dropdown").on("click", function(){ 
            col_id = $(this).attr('collection-id');
            getAllNfts(cat_id, col_id, 1);  
        });


        

        let page = 1;

        $("#load-more-all").on("click", function(){ 
            page = ++page; 
            getAllNfts(cat_id, col_id, page);
        });

        $("#loadmorenft").on("click", function(){ 
            page = ++page; 
            getUserNfts(page);
        });

         $("#loadmore_coll_nft").on("click", function(){ 
            page = ++page; 
            getcollectionNfts(page);
        });  

        $("#loadmore_cat_nfts").on("click", function(){ 
            page = ++page; 
            getCategoryNfts(page);
        }); 

        $("#loadmore_user_nfts").on("click", function(){ 
            page = ++page; 
            getfrontUserNfts(page);
        }); 
 

    //==============================================================//
    // ==============Profile page JS start==========================//
 

        // Copy Wallet 
        $("#copy-wallet, #copy-wallet-deposit").on("click", function(){

            

            var copyText = $("#mywallet").val(); 
            if(copyText == ''){
                var copyText = $("#wallet-for-deposit").text(); 
            } 

            $("#mywallet").select();
           
            let textArea = document.createElement("textarea");
            textArea.value = copyText; 
            
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select(); 
            return new Promise((res, rej) => {
                // here the magic happens 
                document.execCommand('copy') ? res() : rej();
                textArea.remove();
                var tooltip = document.getElementById("myTooltip");
                document.getElementById("mywallet").select();
                tooltip.innerHTML = "Copied"; 
                $("#copy-wallet-deposit").text("Copied"); 
                setTimeout(() => {
                    $("#copy-wallet-deposit").text("Copy address");
                }, 2000);
            });
  
        });

        

        
        $("#copy-wallet").on("mouseout", function(){
            var tooltip = document.getElementById("myTooltip");
            tooltip.innerHTML = "Copy to clipboard";
        });
        
        // Form Input Focus
        $(".input-group-form").on("click", function () {
            $(this).find('input').focus();
        }); 

        $(document).on("change", ".uploadProfileInput1, .uploadProfileInput", function () {
            var triggerInput = this;
            var currentImg = $(this).closest(".pic-holder").find(".pic").attr("src");
            var holder = $(this).closest(".pic-holder");
            var wrapper = $(this).closest(".profile-pic-wrapper");
            $(wrapper).find('[role="alert"]').remove();
            triggerInput.blur();
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) {
                return;
            }
            if (/^image/.test(files[0].type)) {
                // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function () {
                    $(holder).addClass("uploadInProgress");
                    $(holder).find(".pic").attr("src", this.result);
                    

                   
                };
            } else {
                $(wrapper).append(
                    '<div class="alert alert-danger d-inline-block p-2 small" role="alert">Please choose the valid image.</div>'
                );
                setTimeout(() => {
                    $(wrapper).find('role="alert"').remove();
                }, 3000);
            }
        }); 


        $(document).on("click", ".mybalance_reload", function(){
            let base_uri    = $("#siteuri").attr('mybaseuri');
            $(".mybalance_reload").html('<i class="fa fa-spinner fa-spin"></i>');
            let url         = base_uri+"/accounts/get_balance";
          
            $.ajax({
                url: url, 
                type:'GET',
                dataType: 'json', 
                contentType: 'application/json',
                success: function (res) {  
                 
                    if(res.status == 'success'){
                       $(".main-balance").text(res.balance); 
                       $(".mybalance_reload").text('Reload Balance'); 
                    }else{
                        $(".mybalance_reload").text('Reload Balance'); 
                    } 
                    
                }
            }); 


        });

    //====================End Profile js============================//
    // =============================================================//



    //==============================================================//
    //=================Details Page Js Start ====================//

    $(document).on("click", ".buynow-btn", function() {

        let buyurl       = $(this).attr('buyurl'); 
        let price       = $(this).attr('min_price'); 
        let base_uri    = $("#siteuri").attr('mybaseuri'); 
        let url         = base_uri+"/accounts/get_balance";
        $(".balance-msg").html('<i class="fa fa-spinner fa-spin"></i>');
        $.ajax({
            url: url, 
            type:'GET',
            dataType: 'json', 
            contentType: 'application/json',
            success: function (res) {   

                if(res.status == 'success'){
                    let fee      = (res.balance * 5) / 100;
                    let balance  = (res.balance - fee);
                    if(balance >= price){
                       $(".balance-msg").html('Are you sure buy this nft ? '+price+' ETH + gas will be deducted from your account <a href="'+buyurl+'">Click to confirm buy</a>');
                    
                     }else{
                         $(".balance-msg").text('Insufficient balance!');
                     }
                    
                }else{
                     
                } 
                
            }
        }); 

    });


    $('.image-popup-no-margins').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: false,
        fixedContentPos: true,
        mainClass: 'mfp-no-margins mfp-with-zoom',  
        image: {
            verticalFit: true
        },
        zoom: {
            enabled: true,
            duration: 300 
        }
    });


    //====================End Details Page Js============================//
    // =============================================================//



    //==============================================================//
    //=================Header Autocomplete Search====================//

        $(document).on("keyup", ".h-auto-search" , function(){
            let keyword = $(this).val();
             

            let base_uri = $("#siteuri").attr('mybaseuri');
            
            var Url = base_uri+"/search/"+keyword;  
              
            if(keyword.length > 2){ 
                $.ajax({
                    url: Url, 
                    type:'GET',
                    dataType: 'json', 
                    contentType: 'application/json',
                    success: function (res) {  
                        
                        $(".header-searching").addClass('suggestion-list'); 
                        if(res.data){
                           $(".header-searching").html(res.data);   
                       }else{
                            $(".header-searching").html('Empty');  
                       } 
                        
                    }
                }); 
            }else{
                $(".header-searching").html('');
                $(".header-searching").removeClass('suggestion-list'); 
            }
            
        });


    //====================End Search js============================//
    // =============================================================//



        $(document).on("click", "#copy_details_link", function(){
            let id = $(this).attr('copyid');
            let element_id = 'detailslink';
           

            var copyText = $("#detailslink_"+id).text(); 
           

            let textArea = document.createElement("textarea");
            textArea.value = copyText; 
            
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select(); 
            return new Promise((res, rej) => {
       
                document.execCommand('copy') ? res() : rej();
                textArea.remove();
                var tooltip = document.getElementById("copysuccess_"+id); 
                tooltip.innerHTML = "Copied";

                setTimeout(function () { 
                    tooltip.innerHTML = "";
                }, 3000); 
            });


        });


    //==============================================================//
    // ==============Collection add page JS start==========================//

    $(document).on("keyup", "#collectionName", function(){
      
         let collection = $("#collectionName").val();
         let base_uri = $("#siteuri").attr('mybaseuri');
         let url = base_uri+"/nfts/checkcollection/"+btoa(collection);

        if(collection.length > 5){ 
            $.ajax({
                url: url, 
                type:'GET',
                dataType: 'json', 
                contentType: 'application/json',
                success: function (res) {   
                    
                    if(res.status == 'success'){
                        $(".collection-name-check").removeClass('text-danger'); 
                        $(".collection-name-check").html('<i class="fa fa-check"></i> '+res.msg);  
                    }else{
                        $(".collection-name-check").addClass(res.class); 
                        $(".collection-name-check").html('<i class="fa fa-xmark"></i> '+res.msg);  
                    }
                     
                }
            });
        }else{
            $(".collection-name-check").addClass('text-danger'); 
            $(".collection-name-check").html('<i class="fa fa-xmark"></i> Please enter minimum 6 characters');  
        } 
    });

    $(document).on("keyup", "#collectionSlug", function(){
    
        let slug = $("#collectionSlug").val();
        let base_uri = $("#siteuri").attr('mybaseuri');
        let cleanSlug = clean_url(slug);
        $("#collectionSlug").val(cleanSlug);
         

        let url = base_uri+"/nfts/checkcollectionslug/"+btoa(slug);
       
        if(slug.length > 5){ 
            $.ajax({
                url: url, 
                type:'GET',
                dataType: 'json', 
                contentType: 'application/json',
                success: function (res) {  
                    
                    if(res.status == 'success'){
                        $(".collection-slug-check").removeClass('text-danger'); 
                        $(".collection-slug-check").html('<i class="fa fa-check"></i> '+res.msg);  
                    }else{
                        $(".collection-slug-check").addClass(res.class); 
                        $(".collection-slug-check").html('<i class="fa fa-xmark"></i> '+res.msg);  
                    }
                     
                }
            });
        }else{
            $(".collection-slug-check").addClass('text-danger'); 
            $(".collection-slug-check").html('<i class="fa fa-xmark"></i> Please enter minimum 6 characters');  
        } 
    });

    function clean_url(s) {
        return s.toString().normalize('NFD').replace(/[\u0300-\u036f]/g, "") //remove diacritics
            .toLowerCase()
            .replace(/\s+/g, '-') //spaces to dashes
            .replace(/&/g, '-and-') //ampersand to and
            .replace(/[^\w\-]+/g, '') //remove non-words
            .replace(/\-\-+/g, '-') //collapse multiple dashes 
    }
        
    //==============================================================//
    // ==============Create NFT page JS start==========================//

    $(document).on("change", "#nft_file", function () {
        var triggerInput = this;
        var currentImg = $(this).closest(".pic-holder").find(".pic").attr("src");
        var holder = $(this).closest(".pic-holder");
        var wrapper = $(this).closest(".profile-pic-wrapper");
        $(wrapper).find('[role="alert"]').remove();
        triggerInput.blur();
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) {
            return;
        } 
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function () {
                $(holder).addClass("uploadInProgress");
                $(holder).find(".pic").attr("src", this.result);  
            };
        
    });

    function appendUserRow(id, user) {
        var html = "<div id=\"opt-row." + id + "\" class=\"form-group row align-items-end mb-3 g-1\">\n" +
            "            <div class=\"col\">\n" +
            "                <input required type=\"text\" class=\"form-control\" id=\"opt-type." + id + "\" name=\"opt_type[]\" placeholder=\"Ex: White\" value=\"" + user.type + "\">\n" +
            "            </div>\n" +
            "            <div class=\"col\">\n" +
                "            <div class=\"input-group\">\n" +
                "                <input required type=\"text\" class=\"form-control\"  id=\"opt-name." + id + "\" name=\"opt_val[]\" placeholder=\"Ex: 20%\" value=\"" + user.name + "\">\n" +
                "                <span class=\"input-group-text\">@</span>\n" +
                "            </div>\n" +
            "            </div>\n" +
            "            <div class=\"col-auto\">\n" +
            "             <button delet-id="+id+" type=\"button\"  class=\"btn btn-danger deleteRow\">Delete</button>\n" +
            "            </div>\n" +
            "        </div>";
        $("#form-placeholder").append(html);
    }
 
    var count = 0;

    $(document).on("click", "#btn-add", function(){
        appendUserRow(count++, {
            type: "",
            name: "",
            email: "",
            no: ""
        })
    })
   

    $('body').on('click', '.deleteRow', function () {
        var id = $(this).attr('delet-id');
        
        var element = document.getElementById("opt-row." + id);
        element.parentNode.removeChild(element);

         $(this).remove();
    });


    function delRow(id) {
        var element = document.getElementById("opt-row." + id);
        element.parentNode.removeChild(element);
    }  
    //================================Create NFT page JS End==============//
    // ==================================================================//  
 


    //===================================================================//
    // ========================Make offer popup js start=================//  

    $(document).on("click", "#makeoffersubmit", function() {
          
        let amount     = $("#offer-amount").val();
        let nft_id     = $("#nft_id").val();
        let token_id     = $("#token_id").val();
        let listing_id     = $("#listing_id").val();

        if(amount == ''){
            $(".my-submitclass").attr("disabled", "disabled"); 
            $('.error-amount').text('Amount fieald is required');
        }


        let base_uri   = $("#siteuri").attr('mybaseuri');
        let url        = base_uri+'/nfts/biding';

        let inputdata               = {};
        inputdata[csrf_token]       = get_csrf_hash; 
        inputdata["amount"]         = amount; 
        inputdata["nft_id"]         = nft_id; 
        inputdata["token_id"]       = token_id; 
        inputdata["listing_id"]     = listing_id; 

        if(amount > 0){
            $.ajax({
                url: url, 
                type:'POST',
                dataType: 'json',  
                data: inputdata,
                success: function (res) {  
                    if(res.status == 'success'){
                        sweetAlertForEvery('success', 'Offer success', 'top-end');
                        setTimeout(function(){
                            location.reload();
                        }, 1500);
                        
                    }else{
                        $(".error-amount").text(res.msg);  
                        $(".my-submitclass").attr("disabled", "disabled");
                    } 
                     
                }
            }); 
        }
         
    });

    $(document).on("keyup", "#offer-amount", function() {
        let bidAmount = $("#offer-amount").val();
        let minAmount = $(this).attr("minimum_price");

        var regex  = /^\d{0,8}(?:\.\d{0,8}){0,1}$/;
        let isnum = regex.test(bidAmount);

        if(isnum === false){
 
            $(".error-amount").text("Please enter amount value!");
            $(".my-submitclass").attr("disabled", "disabled"); 

        }else{
              

            let mybalance = $(this).attr("mybalance");
            let fee = ((mybalance * 5) / 100);
            mybalance = (mybalance - fee);
              
            if(bidAmount <= minAmount || mybalance < bidAmount){ 
                if(mybalance < bidAmount){
                    $(".error-amount").text("Insufficient balance!");   
                    $(".my-submitclass").attr("disabled", "disabled");
                }else{
                    $(".error-amount").text("Make offer must be greater than minimum price ("+minAmount+")"); 
                    $(".my-submitclass").attr("disabled", "disabled");
                } 
            }else{
                $(".my-submitclass").removeAttr('disabled'); 
                $(".error-amount").text(""); 
            }

        }
    });

    //================================Make offer popup js end==============//
    // ==================================================================//


    $('#duration-calnader, #duration-calnader2').daterangepicker({
        "timePicker": false,
        "locale": {
            "direction": "ltr",
            "format": "DD/MM/YYYY HH:mm",
            "separator": " - ",
            "applyLabel": "Apply",
            "cancelLabel": "Cancel",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "Su",
                "Mo",
                "Tu",
                "We",
                "Th",
                "Fr",
                "Sa"
            ],
            "monthNames": [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ],
            "firstDay": 1
        }, 
        "alwaysShowCalendars": true, 
        "minDate": today
    }, function(start, end, label) {
         
    $(".start_date").val(dateformate(start));
    $(".end_date").val(dateformate(end));
    });

 

    $('#offer-duration').daterangepicker({
        "singleDatePicker": true,
        "locale": {
            "direction": "ltr",
            "format": "DD/MM/YYYY",
            "separator": " - ",
            "applyLabel": "Apply",
            "cancelLabel": "Cancel",
            "fromLabel": "From",
            "toLabel": "To",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "Su",
                "Mo",
                "Tu",
                "We",
                "Th",
                "Fr",
                "Sa"
            ],
            "monthNames": [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December"
            ],
            "firstDay": 1
        },
        "minDate": today
    }, function(start, end, label) {
      
    });

    function dateformate(a) {

        var today = new Date(a);
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today =  yyyy + '-' + mm  + '-' + dd ;
        return today;
    }
    

    //=======================================================//
    // =====================Sweet Alrt=======================// 

    function sweetAlert(icon, title) { 
        Swal.fire({
            title: title,
            position: 'bottom-end', 
            icon:  icon,
            width: 400, 
            timer: 1500,
            showConfirmButton: false,
            showClass: {
                popup: 'animate__animated animate__fadeInRight'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutRight'
            }
        })
    }

    function sweetAlertForEvery(icon, title, position) { 
        Swal.fire({
            title: title,
            position: position, 
            icon:  icon,
            width: 400, 
            timer: 1500,
            showConfirmButton: false,
            showClass: {
                popup: 'animate__animated animate__fadeInRight'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutRight'
            }
        })
    } 

});
