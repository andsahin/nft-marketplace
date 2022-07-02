        <link rel="stylesheet" href="<?php echo esc($frontendAssets); ?>/plugins/Magnific-Popup/magnific-popup.css">
        <div class="section-pd pt-5">
            <div class="container">
                <?php if(isset($message)){ ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong><?php echo display('Success'); ?>!</strong> <?php echo esc($message); ?>
                    </div>
                <?php } ?>
                <?php if(isset($exception)){ ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong><?php echo display('Exception'); ?>!</strong> <?php echo esc($exception); ?>
                    </div>
                <?php } ?>
                <div class="row">

                     <!-- NFT image info -->
                    <div class="col-md-6"> 
                        <div class="position-relative">
                             <button type="button" class="btn btn-outline-primary d-fav-item position-absolute rounded-circle" nftId="<?php echo esc($nftInfo->nftId); ?>">
                                <svg class="like-icon_<?php echo esc($nftInfo->nftId); ?> <?php if($favourite==1) {echo "like-active";} ?>" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            </button>
                        <?php 
                        $fileExtension = pathinfo($nftInfo->file, PATHINFO_EXTENSION); 
                        if ($fileExtension == 'mp4' || $fileExtension == 'webm') { ?>
                            <a class="item-img position-relative overflow-hidden d-block">
                                <video loop="true" autoplay="autoplay" muted> <source src="<?php echo base_url().'/'.$nftInfo->file; ?>" type="video/mp4"> </video>
                            </a>
                       <?php      
                        }else if($fileExtension == 'mp3'){  ?>
                            <a class="item-img position-relative overflow-hidden d-block">
                                <audio controls src="<?php echo base_url().'/'.$nftInfo->file; ?>">   </audio>
                            </a>
                        <?php 
                        }else{
                        ?> 
                        <a class="sticky-bar image-popup-no-margins" href="<?php echo base_url().'/'.$nftInfo->file; ?>">
                            <img src="<?php echo base_url().'/'.$nftInfo->file; ?>" class="img-fluid rounded-3" alt="">
                        </a>
                        <?php } ?>

                        </div>
                    </div> 
                    
                    <div class="col-md-6 mt-4 pt-2 mt-sm-0 pt-sm-0">

                        <div class="ms-lg-5">
                            <div class="item-header title-heading mb-3">
                                <div class="item-collection__info d-flex align-items-center justify-content-between">
                                    <div class="item-collection-detail">
                                        <a href="<?php echo base_url().'/collection/'.$nftInfo->collection_slug ?>" class="item-collection-link mb-1 d-flex align-items-center">
                                            <span><?php echo esc($nftInfo->collection_title); ?></span>
                                            <?php  if($nftInfo->status == 1){ ?>
                                                <svg class="VerifiedIconreact__StyledSvg-sc-50keu7-0 csAGsJ ms-2"
                                                    fill="none" viewBox="0 0 30 30">
                                                    <path class="VerifiedIcon--background"
                                                        d="M13.474 2.80108C14.2729 1.85822 15.7271 1.85822 16.526 2.80108L17.4886 3.9373C17.9785 4.51548 18.753 4.76715 19.4892 4.58733L20.9358 4.23394C22.1363 3.94069 23.3128 4.79547 23.4049 6.0278L23.5158 7.51286C23.5723 8.26854 24.051 8.92742 24.7522 9.21463L26.1303 9.77906C27.2739 10.2474 27.7233 11.6305 27.0734 12.6816L26.2903 13.9482C25.8918 14.5928 25.8918 15.4072 26.2903 16.0518L27.0734 17.3184C27.7233 18.3695 27.2739 19.7526 26.1303 20.2209L24.7522 20.7854C24.051 21.0726 23.5723 21.7315 23.5158 22.4871L23.4049 23.9722C23.3128 25.2045 22.1363 26.0593 20.9358 25.7661L19.4892 25.4127C18.753 25.2328 17.9785 25.4845 17.4886 26.0627L16.526 27.1989C15.7271 28.1418 14.2729 28.1418 13.474 27.1989L12.5114 26.0627C12.0215 25.4845 11.247 25.2328 10.5108 25.4127L9.06418 25.7661C7.86371 26.0593 6.6872 25.2045 6.59513 23.9722L6.48419 22.4871C6.42773 21.7315 5.94903 21.0726 5.24777 20.7854L3.86969 20.2209C2.72612 19.7526 2.27673 18.3695 2.9266 17.3184L3.70973 16.0518C4.10824 15.4072 4.10824 14.5928 3.70973 13.9482L2.9266 12.6816C2.27673 11.6305 2.72612 10.2474 3.86969 9.77906L5.24777 9.21463C5.94903 8.92742 6.42773 8.26854 6.48419 7.51286L6.59513 6.0278C6.6872 4.79547 7.86371 3.94069 9.06418 4.23394L10.5108 4.58733C11.247 4.76715 12.0215 4.51548 12.5114 3.9373L13.474 2.80108Z">
                                                    </path>
                                                    <path
                                                        d="M13.5 17.625L10.875 15L10 15.875L13.5 19.375L21 11.875L20.125 11L13.5 17.625Z"
                                                        fill="white" stroke="white"></path>
                                                </svg>
                                            <?php } ?>
                                        </a>
                                        <h4 class="item-title h3 fw-semi-bold mb-0"><?php echo esc($nftInfo->name).' #'.esc($nftInfo->token_id); ?></h4>
                                    </div> 
                                </div>
                            </div>


                            <div class="item-counts d-flex align-items-center">
                                <div class=""><?php echo display('Owner'); ?> <a href="<?php echo base_url('nft').'/'.$nftInfo->username; ?>"><?php echo esc($nftInfo->f_name).' '.esc($nftInfo->l_name); ?></a></div> 
                            </div>
                            <div class="timer-container position-relative mt-3"> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6><?php echo display('Price'); ?></h6>
                                        <h2 class="mb-0 fw-bold"><?php echo number_format(esc($nftInfo->price), 6, '.', ',') .' '.SYMBOL; ?></h2> 
                                    </div>
                                    <div class="col-md-6"> 
                                        <?php if(isset($nftInfo->listing_id) && isset($nftInfo->start_date)){ ?>
                                        <h6><?php echo display('Auction_ends_in'); ?></h6>
                                        <div id="countdown">
                                            <ul class="list-unstyled m-0 d-flex">
                                                <li><span id="days"></span>
                                                    <!-- days -->
                                                </li>
                                                <li><span id="hours"></span>
                                                    <!-- Hours -->
                                                </li>
                                                <li><span id="minutes"></span>
                                                    <!-- Minutes -->
                                                </li>
                                                <li><span id="seconds"></span>
                                                    <!-- Seconds -->
                                                </li>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                    </div>

                                    <?php   
                                    $startAuction   = isset($nftInfo->start_date) ? $nftInfo->start_date : 0;
                                    $endAuction     = isset($nftInfo->end_date) ? $nftInfo->end_date : 0; 
                                    ?>
                                    <span class="start-auction" start_auction="<?php echo esc($startAuction); ?>"></span>
                                    <span class="end-auction" end_auction="<?php echo esc($endAuction); ?>"></span>
                                    <div class="col-12 mt-4 pt-2"> 
                                    <?php   
                                    if($userId != $nftInfo->user_id){

                                        if($nftInfo->auction_type == 'Fix'){

                                            if($isUser){  
                                    ?> 
                                             
                                            <a href="javascript:;" class="btn btn-l btn-pills btn-outline-primary me-2 bid-btn buynow-btn" min_price="<?php echo (!empty($nftInfo->min_price)) ? $nftInfo->min_price : 0;  ?>" buyurl="<?php echo base_url("user/asset/buy/{$nftInfo->token_id}/{$nftInfo->nftId}/{$nftInfo->contract_address}"); ?>">

                                                <i class="mdi mdi-gavel fs-5 me-2"></i><?php echo display('Buy_Now'); ?>
                                            </a>
                                            <div class="balance-msg">
                                                
                                            </div>
                                             
                                             
                                    <?php  
                                            }else{  
                                    ?> 
                                            <a href="<?php echo base_url('user/signin'); ?>" class="btn btn-l btn-pills btn-outline-primary me-2 bid-btn"><i class="mdi mdi-gavel fs-5 me-2"></i><?php echo display('Buy_Now'); ?></a>


                                    <?php

                                            }

                                        }else if($nftInfo->auction_type == 'Bid') {

                                    
                                            if($isUser){   
                                    ?> 
                                                <a class="btn btn-l btn-pills btn-outline-primary me-2 bid-btn" data-bs-toggle="modal" data-bs-target="#makeOffer"><i class="mdi mdi-gavel fs-5 me-2"></i><?php echo display('Make_offer'); ?></a>

                                    <?php   }else{ ?>

                                                <a href="<?php echo base_url('user/signin'); ?>" class="btn btn-l btn-pills btn-outline-primary me-2 bid-btn"><i class="mdi mdi-gavel fs-5 me-2"></i><?php echo display('Make_offer'); ?></a>

                                    <?php   } 

                                        }

                                    } else if($nftInfo->is_verified == 1 && !isset($nftInfo->listing_id)) {  ?>
                                        
                                        <a href='<?php echo base_url("user/asset/sale/{$nftInfo->token_id}/{$nftInfo->nftId}/{$nftInfo->contract_address}"); ?>' class="btn btn-l btn-pills btn-outline-primary me-2 bid-btn"><i class="mdi mdi-gavel fs-5 me-2"></i><?php echo display('List_for_Sell'); ?></a>

                                        <a href='<?php echo base_url("user/assets/transfer/{$nftInfo->nftId}/{$nftInfo->token_id}/{$nftInfo->contract_address}"); ?>' class="btn btn-l btn-pills btn-outline-primary me-2 bid-btn"><i class="mdi mdi-gavel fs-5 me-2"></i><?php echo display('Transfer'); ?></a>
  

                                    <?php
                                    }
                                    ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4 pt-2">
                                <div class="col-12">
                                    <ul class="nav nav-tabs border-bottom" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="detail-tab" data-bs-toggle="tab"
                                                data-bs-target="#detailItem" type="button" role="tab"
                                                aria-controls="detailItem" aria-selected="true"><?php echo display('Details'); ?></button>
                                        </li>

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="bids-tab" data-bs-toggle="tab"
                                                data-bs-target="#bids" type="button" role="tab" aria-controls="bids"
                                                aria-selected="false"><?php echo display('Bids'); ?></button>
                                        </li>  

                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="info-tab" data-bs-toggle="tab"
                                                data-bs-target="#info" type="button" role="tab" aria-controls="info"
                                                aria-selected="false"><?php echo display('Blockchain_Info'); ?></button>
                                        </li> 
                                    </ul>

                                    <div class="tab-content mt-4 pt-2" id="myTabContent">
                                        <div class="tab-pane fade show active" id="detailItem" role="tabpanel"
                                            aria-labelledby="detail-tab">
                                            <div class="read-more js-read-more" data-rm-words="25">
                                                <p class="nft-details">
                                                    <?php echo esc($nftInfo->description); ?>
                                                </p>
                                            </div> 
  
                                            <div class="row mt-0 g-4">
                                                <!-- Properties -->
                                                <div class="col-md-12">
                                                    <h6 class="mb-3 fw-semi-bold"><?php echo display('Characteristics'); ?></h6>
                                                    
                                                    <div class="row g-2">
                                                        <?php 

                                                        $properties = json_decode($nftInfo->properties); 
                                                        if ($properties != FALSE) { 
 
                                                            foreach ($properties as $key => $property) { 
                                                        ?>
                                                            <div class="col-auto">
                                                                <div class="property-card bg-white"> 
                                                                    <h6><?php echo esc($key); ?></h6>
                                                                    <small><?php echo esc($property); ?></small>
                                                                </div>
                                                            </div>
                                                        <?php 
                                                            } 
                                                        }else{ 
                                                            
                                                            echo "<span>".display('Empty')."</span>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>


                                                <!-- Owner -->
                                                <div class="col-md-4">
                                                    <h6 class="mb-3 fw-semi-bold"><?php echo display('Owner'); ?></h6>
                                                    <div class="creators creator-primary d-flex align-items-center">
                                                        <div class="position-relative">
                                                            <?php if($nftInfo->user_image){ ?>
                                                                <img src="<?php echo base_url('public/uploads/dashboard/new').'/'.$nftInfo->user_image; ?>" class="avatar avatar-md-sm shadow-md rounded-pill" alt="user_image">
                                                            <?php }else{  ?>
                                                                <img src="<?php echo base_url('public/uploads/dashboard/user.png'); ?>" class="avatar avatar-md-sm shadow-md rounded-pill" alt="user_image">
                                                            <?php 
                                                            } ?>
                                                            <span class="verified text-primary">
                                                                <i class="mdi mdi-check-decagram"></i>
                                                            </span>
                                                        </div>
                                                        <div class="ms-3">
                                                            <h6 class="mb-0 fw-semi-bold"><a href="<?php echo base_url('nft').'/'.$nftInfo->username; ?>"
                                                                    class="text-dark name"><?php echo esc($nftInfo->f_name).' '.esc($nftInfo->l_name); ?></a></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Category -->
                                                <div class="col-md-4">
                                                    <h6 class="mb-3 fw-semi-bold"><?php echo display('Category'); ?></h6>
                                                    <a href="<?php echo base_url('category').'/'.$nftInfo->cat_slug; ?>" type="button" class="category-btn"><span class="">🌈<?php echo esc($nftInfo->cat_name); ?> </span></a>
                                                </div>
                                                <!-- Blockchain -->
                                                <div class="col-md-4">
                                                    <h6 class="mb-3 fw-semi-bold"><?php echo display('Blockchain_Network'); ?></h6>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <?php  
                                                            if($nftInfo->blockchain_id == 1){ 
                                                                echo '<img src="'.$frontendAssets.'/img/ethereum.svg" alt="Ethereum_logo">' ;
                                                            }else{
                                                               echo '<img src="'.$frontendAssets.'/img/bnb.png" width="35" alt="Ethereum_logo">' ; 
                                                            }
                                                            ?> 
                                                        </div>
                                                        <div class="flex-grow-1 ms-2 fw-semi-bold text-dark">
                                                            <?php if($nftInfo->blockchain_id == 1){ echo 'Ethereum'; }else{ echo 'BSC'; } ?> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="bids" role="tabpanel" aria-labelledby="bids-tab">
                                            <?php  
                                            if(!empty($bid_info)){
                                            foreach ($bid_info as $key => $bidInfo) { 
                                            ?>
                                            <div class="creators creator-primary d-flex align-items-center">
                                                <div class="position-relative">
                                                    <img src="<?php echo base_url('public/uploads/dashboard/user.png'); ?>"
                                                        class="avatar avatar-md-sm shadow-md rounded-pill" alt="">
                                                </div>

                                                <div class="ms-3">
                                                    <h6 class="mb-0"><?php echo number_format($bidInfo->bid_amount, 6, '.',',').' '.SYMBOL; ?> <span class="text-muted">by</span> <a
                                                            href="creator-profile.html"
                                                            class="text-dark name"><?php echo esc($bidInfo->f_name).' '.esc($bidInfo->l_name); ?></a></h6>
                                                    <small class="text-muted"><?php echo date('d-m-Y H:i:sa', strtotime($bidInfo->bid_start_at)); ?></small>
                                                </div>
                                            </div>
                                            <?php } 
                                            }else{
                                               echo "<span>".display('Empty')."</span>"; 
                                            }
                                            ?>
                                        </div>
 
                                        <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">
                                            <div class="table-responsive">
                                                 <table class="table table-hover table-bordered">
                                                    <tbody> 
                                                        <tr>
                                                            <th><?php echo display('Contract'); ?></th>
                                                            <td><a target="_blank" href="<?php echo esc($networks->explore_url)."/address/".esc($nftInfo->contract_address); ?>"><?php echo substr(esc($nftInfo->contract_address), 0, 5) . '...' . substr(esc($nftInfo->contract_address), -5); ?></a></td> 
                                                        </tr>
                                                        <tr>
                                                            <th><?php echo display('Token_Id'); ?></th>
                                                            <td><?php echo esc($nftInfo->token_id); ?></td> 
                                                        </tr>
                                                        <tr>
                                                            <th><?php echo display('Token_Standard'); ?></th>
                                                            <td><?php echo esc($nftInfo->token_standard); ?></td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div> 
                                        </div>   

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
 
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
        </div>
        <div class="container">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                 
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo display('NFT_Activity'); ?>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('Event'); ?></th>
                                            <th><?php echo display('Price'); ?></th>
                                            <th><?php echo display('From'); ?></th>
                                            <th><?php echo display('To'); ?></th>
                                            <th><?php echo display('Date'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        foreach ($activities as $key => $activity) {   

                                            if($activity['type'] == 'Bid'){
                                                $type = 'Offer';
                                                $amount = isset($activity['bid_amount']) ? $activity['bid_amount'] : 0; 
                                            }else if($activity['type'] == 'List'){
                                                if($activity['list_status'] == 0){
                                                   $type = 'Listing'; 
                                                }else if($activity['list_status'] == 1){
                                                    $type = 'Sell'; 
                                                }else if($activity['list_status'] == 3){
                                                    $type = 'Listing Canceled'; 
                                                } 
                                                $amount = isset($activity['min_price']) ? $activity['min_price'] : 0;
                                            }else{ 
                                                $type = $activity['type'];
                                                $amount = 0;
                                            }

                                            ?>
                                        <tr>
                                            <td><?php echo esc($type); ?></td>
                                            <td><?php echo esc($amount).' '.SYMBOL; ?></td>
                                            <td><?php echo esc($activity['from']); ?></td>
                                            <td><?php  ?></td>
                                            <td><?php echo date('d-m-Y H:i:sa', strtotime($activity['created_at'])); ?></td>
                                        </tr> 
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div> 
                        </div>
                    </div>
                </div> 
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <?php echo display('NFT_Listings'); ?>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th><?php echo display('Event'); ?></th>
                                            <th><?php echo display('Price'); ?></th>
                                            <th><?php echo display('From'); ?></th>
                                            <th><?php echo display('To'); ?></th>
                                            <th><?php echo display('Date'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        
                                        foreach ($listings as $key => $listing) {  

                                            if($listing->status == 0){
                                                $type = 'Listing'; 
                                            }else if($listing->status == 1){
                                                $type = 'Listing Success'; 
                                            }else if($listing->status == 2){
                                                $type = 'Listing Expired'; 
                                            }else if($listing->status == 3){
                                                $type = 'Listing Canceled'; 
                                            } 
                                            ?>
                                        <tr>
                                            <td><?php echo esc($type); ?></td>
                                            <td><?php echo esc($listing->min_price).' '.SYMBOL; ?></td>
                                            <td><?php echo esc($listing->f_name).' '.esc($listing->l_name); ?></td>
                                            <td><?php  ?></td>
                                            <td><?php echo date('d-m-Y H:i:sa', strtotime($listing->created_at)); ?></td>
                                        </tr> 
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- This collection more NFTs -->
        <div class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col">
                        <div class="section-title text-center mb-4 pb-2">
                            <h4 class="title mb-4"><?php echo display('More_NFTs_From_This_Collection'); ?></h4>
                        </div>
                    </div>
                    <!--end col-->
                </div>

                <div class="row g-3 item-wrap">
                    <?php  foreach ($moreNftsFromCollection as $key => $moreNfts) {  ?>
                    <div class="col-md-3">
                        <div class="card nft-items nft-primary rounded-7 border-0 overflow-hidden mb-1 p-4">
                            
                            <div class="nft-image rounded-7 position-relative">
                                <?php 
                                $fileExtension = pathinfo($moreNfts->file, PATHINFO_EXTENSION); 
                                if ($fileExtension == 'mp4' || $fileExtension == 'webm') { ?>
                                    <a href="<?php echo base_url('nft/asset/details/'.$moreNfts->token_id.'/'.$moreNfts->nftId.'/'.$moreNfts->contract_address); ?>" class="item-img position-relative overflow-hidden d-block">
                                        <video loop="true" autoplay="autoplay" muted> <source src="<?php echo base_url().'/'.$moreNfts->file; ?>" type="video/mp4"> </video>
                                    </a>
                               <?php      
                                }else if($fileExtension == 'mp3'){  ?>
                                    <a href="<?php echo base_url('nft/asset/details/'.$moreNfts->token_id.'/'.$moreNfts->nftId.'/'.$moreNfts->contract_address); ?>" class="item-img position-relative overflow-hidden d-block">
                                        <audio controls src="<?php echo base_url().'/'.$moreNfts->file; ?>">   </audio>
                                    </a>
                                <?php 
                                }else{
                                ?> 
                                    <a href="<?php echo base_url('nft/asset/details/'.$moreNfts->token_id.'/'.$moreNfts->nftId.'/'.$moreNfts->contract_address); ?>" class="item-img position-relative overflow-hidden d-block"><img src="<?php echo base_url().$moreNfts->file; ?>" class="img-fluid" alt="">
                                    </a>
                                <?php } ?>
                                  
                               
                                <div class="position-absolute top-0 end-0 m-2">
                                    <a href="item-detail-one.html" class="btn btn-pills btn-icon"><i
                                            class="uil uil-shopping-cart-alt"></i></a>
                                </div>
                                <div class="m-2 nft-time-counter position-absolute px-3 rounded-pill title-dark">
                                    <i class="uil uil-clock"></i> <small id="auction-item-1" class="fw-bold"><?php echo esc($moreNfts->auctionDateTime); ?></small>
                                </div>
                            </div>
                            <div class="card-body content position-relative mt-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="img-group">
                                        <?php foreach($moreNfts->favorite3img as $key=>$image){  ?>
                                        <a href="" class="user-avatar <?php if ($key > 0) echo 'ms-n3';  ?>">
                                            <?php  
                                            if($image->image){ ?>
                                                <img src="<?php echo base_url('public/uploads/dashboard/new')."/".$image->image ?>" alt="user"
                                                class="avatar avatar-sm-sm img-thumbnail border-0 shadow-sm rounded-circle">
                                            <?php }else{  ?>
                                                <img src="<?php echo base_url('public/uploads/dashboard/user.png') ?>" class="avatar avatar-md-sm shadow-md rounded-pill" alt="">
                                            <?php } ?>
                                        </a>
                                        <?php } ?> 
                                    </div>
                                    <span class="like-btn">
                                        <button class="like-wrap text-muted d-flex align-items-center fw-semi-bold favorite_item" nftId="<?php echo esc($moreNfts->nftId); ?>" favoriteVal="<?php echo esc($moreNfts->favoriteVal); ?>">

                                            <svg class="like-icon_<?php echo esc($moreNfts->nftId); ?> <?php if($moreNfts->favoriteActive==1) {echo "like-active";} ?>" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart">
                                                <path
                                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                                </path>
                                            </svg>
                                            <span class="like-number_<?php echo esc($moreNfts->nftId); ?> ms-1"><?php echo esc($moreNfts->favoriteVal); ?></span>
                                        </button>
                                    </span>
                                </div>
                                <a href="<?php echo base_url('nft/asset/details/'.$moreNfts->token_id.'/'.$moreNfts->nftId.'/'.$moreNfts->contract_address); ?>"
                                    class="d-block fw-semi-bold h6 text-dark text-truncate title"><?php echo esc($moreNfts->name .' #'.$moreNfts->token_id); ?></a>
                                <div class="d-flex justify-content-between mt-2">
                                    <small class="rate fw-semi-bold text-primary"><?php echo number_format(esc($moreNfts->price), 5).' '.SYMBOL; ?></small> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <!-- Modal For Make Offer -->
        <div class="modal fade" id="makeOffer" tabindex="-1" aria-labelledby="makeOfferLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                 
                <div class="modal-content">
                    <div class="modal-header px-4 px-xl-5 py-3">
                        <h5 class="modal-title" id="makeOfferLabel"><?php echo display('Make_an_offer'); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> 
                    <div class="modal-body p-4 p-xl-5">
                        <input type="hidden" name="nftId" id="nft_id" value="<?php echo esc($nftInfo->nftId); ?>">
                        <input type="hidden" name="token_id" id="token_id" value="<?php echo esc($nftInfo->token_id); ?>">
                        <input type="hidden" name="listing_id" id="listing_id" value="<?php echo esc($nftInfo->listing_id); ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label fw-semi-bold text-black mb-1"><?php echo display('Price'); ?></label>
                            <div class="input-group">
                                <span class="input-group-text"><?php echo SYMBOL; ?></span>
                                <input name="offer-amount" id="offer-amount" type="text" class="form-control form-border" autocomplete="off" aria-label="Amount" placeholder="Amount" minimum_price="<?php echo (!empty($nftInfo->price)) ? $nftInfo->price : 0;  ?>" mybalance="<?php  if(isset($acInfo)){echo esc($acInfo);}; ?>">
                                
                                <span class="input-group-text">$0.00</span>
                            </div>
                            <span class="error-amount text-danger"></span>
                            <small class="d-block fw-medium mt-1 text-end"><?php echo display('Available'); ?>: <?php  if(isset($acInfo)){ echo esc($acInfo.' '.SYMBOL); } ?></small>
                        </div>
                        
                    </div>
                    
                    <div class="modal-footer px-4 px-xl-5 py-3">
                        <button type="button" id="makeoffersubmit" class="btn btn-primary my-submitclass"><?php echo display('Make_Offer'); ?></button> 
                      </div>
                </div>
                 
            </div>
        </div>
        








 