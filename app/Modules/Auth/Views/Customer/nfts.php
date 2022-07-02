 

<?php 
if(count($userNfts) > 0){
    foreach ($userNfts as $key => $nft) {    
?>
    <div class="col-sm-6 col-md-4 col-lg-3 myfvt"> 
        <div class="card nft-items nft-primary rounded-7 border-0 overflow-hidden mb-1 p-4"> 
            <div class="nft-image rounded-7 position-relative">

                <?php 
                $fileExtension = pathinfo($nft->file, PATHINFO_EXTENSION); 
                if ($fileExtension == 'mp4' || $fileExtension == 'webm') { ?>

                    <a href="<?php echo base_url('nft/asset/details/'.$nft->token_id.'/'.$nft->nftId.'/'.$nft->contract_address); ?>" class="item-img position-relative overflow-hidden d-block">
                        <video loop="true" autoplay="autoplay" muted> <source src="<?php echo base_url().'/'.esc($nft->file); ?>" type="video/mp4"> </video>
                    </a>

               <?php      

                }else if($fileExtension == 'mp3'){  ?>

                    <a href="<?php echo base_url('nft/asset/details/'.$nft->token_id.'/'.$nft->nftId.'/'.$nft->contract_address); ?>" class="item-img position-relative overflow-hidden d-block">
                        <audio controls src="<?php echo base_url().'/'.esc($nft->file); ?>">   </audio>
                    </a>

                <?php 

                }else{

                ?> 
                <a href="<?php echo base_url('nft/asset/details/'.$nft->token_id.'/'.$nft->nftId.'/'.$nft->contract_address); ?>" class="item-img position-relative overflow-hidden d-block"><img src="<?php echo base_url().$nft->file; ?>" class="img-fluid" alt=""></a>
            <?php } ?> 
              
            </div>
            <p class="d-none"> id="detailslink_<?php echo esc($nft->nftId); ?>"><?php echo base_url("nft/asset/details/{$nft->token_id}/{$nft->nftId}/{$nft->contract_address}"); ?></p>  

            <div class="card-body content position-relative mt-3"> 

                <span><?php echo esc($nft->collection_title); ?></span><br>

                <small><?php echo ($nft->is_verified == 1) ? "Verified" : "Unverified"; ?></small>

                <a href="<?php echo base_url('nft/asset/details/'.$nft->token_id.'/'.$nft->nftId.'/'.$nft->contract_address); ?>" class="d-block fw-semi-bold h6 text-dark text-truncate title">
                    <?php 
                    if(strlen($nft->name) > 10)
                    { 
                        echo esc(substr($nft->name, 0, 10)).'.. #'. esc($nft->token_id); 
                    }
                    else{ 
                        echo esc($nft->name).' #'. esc($nft->token_id); 
                    }  
                    ?> 
                </a> 


                <div class="d-flex justify-content-between mb-2">
                    <?php if($mytab !== 'favorite' && $nft->token_id != null){ ?>

                        <div class="dropdown">
                            <button class="btn-more dropdown-toggle" type="button"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-more-horizontal">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="19" cy="12" r="1"></circle>
                                    <circle cx="5" cy="12" r="1"></circle>
                                </svg>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                <?php if($nft->is_verified == 1 && $nft->status != 3){   ?>

                                    <li> 
                                        <a class="dropdown-item" href="<?php echo base_url('user/asset/sale/'.$nft->token_id.'/'.$nft->nftId.'/'.$nft->contract_address); ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="me-2 feather feather-user">
                                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="12" cy="7" r="4"></circle>
                                            </svg>
                                            <span><?php echo display('Sell'); ?></span>
                                        </a>
                                    </li>

                                    <li> 
                                        <a class="dropdown-item" href="<?php echo base_url('user/assets/transfer/'.$nft->nftId.'/'.$nft->token_id.'/'.$nft->contract_address); ?>"> <i class="fa fa-arrow-right-arrow-left"></i> <span><?php echo display('Transfer'); ?></span>
                                        </a>
                                    </li>

                                <?php } ?>

                                <li>
                                    <a class="dropdown-item" href="javascript:;" id="copy_details_link" copyid="<?php echo esc($nft->nftId); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-link-2 me-2">
                                            <path
                                                d="M15 7h3a5 5 0 0 1 5 5 5 5 0 0 1-5 5h-3m-6 0H6a5 5 0 0 1-5-5 5 5 0 0 1 5-5h3">
                                            </path>
                                            <line x1="8" y1="12" x2="16" y2="12"></line>
                                        </svg>
                                        <span><?php echo display('Copy_link'); ?><span id="copysuccess_<?php echo esc($nft->nftId); ?>"></span></span>
                                    </a>
                                </li>

                               
                                <li>
                                    <a class="dropdown-item" href="<?php echo base_url("user/mynft_update/{$nft->token_id}/{$nft->nftId}/$nft->contract_address"); ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit-3 me-2">
                                            <path d="M12 20h9"></path>
                                            <path
                                                d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z">
                                            </path>
                                        </svg>
                                        <span><?php echo display('edit'); ?></span>
                                    </a>
                                </li> 
                            </ul>

                        </div>

                    <?php }else{

                        echo '<div class="dropdown"></div>';
                        
                    } ?>

                    <span class="like-btn">
                        <button class="like-wrap text-muted d-flex align-items-center fw-semi-bold favorite_item" id="favorite_item" nftId="<?php echo esc($nft->nftId); ?>" favoriteVal="<?php echo esc($nft->favoriteVal); ?>">
                            <svg class="like-icon" xmlns="http://www.w3.org/2000/svg" width="14"
                                height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-heart">
                                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"> </path>
                            </svg>
                            <span class="like-number_<?php echo esc($nft->nftId); ?> ms-1"><?php echo esc($nft->favoriteVal); ?></span>
                        </button>
                    </span>
                   
                </div>
                
                 
            </div>

        </div>
    </div>
<?php 
    }
}else{ 
?>
<div class="row g-3 item-wrap" id="ajax_all_nfts"> 
    <div class="card">
        <div class="align-items-center card-body d-flex ji justify-content-center empty-tag">
            <blockquote class="blockquote mb-0">
              <h4 class="text-center text-primary"><?php echo display('Data_not_found'); ?></h4>
               
            </blockquote>
        </div>
    </div>  
</div>
<?php } ?>

 