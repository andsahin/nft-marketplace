        <div class="container">
            <!-- Start profile cover -->
            <div class="profile-cover">
                <div class="profile-cover-img-wrapper">
                    <?php if($userInfo->banner_image){ ?>
                        <img class="profile-cover-img" src="<?php echo base_url().esc($userInfo->banner_image); ?>" alt="Image Description">
                    <?php }else{ ?>
                        <img class="profile-cover-img" src="<?php echo esc($frontendAssets); ?>/img/header-bg-02.png" alt="Image Description">
                    <?php } ?>
                </div>
            </div>
            <!-- End of profile cover -->


            <!-- Start profile header -->
            <div class="text-center mb-5">
                <div class="profile-cover-avatar">
                    <?php if($userInfo->image){ ?>
                        <img class="avatar-img" src="<?php echo base_url('/public/uploads/dashboard/new').'/'.$userInfo->image; ?>" alt="banner-image">
                    <?php }else{ ?>
                        <img class="avatar-img" src="<?php echo esc($frontendAssets); ?>/img/avatar/defult.jpg" alt="logo-image">
                    <?php } ?>
                     
                </div>

                <div class="d-flex align-items-center justify-content-center mb-3">
                    <?php if($userInfo->status == 1){ ?>
                    <!-- Verification icon -->
                    <div aria-hidden="true" class="verification-icon-wrap ms-2" data-bs-toggle="tooltip"
                        data-bs-placement="right" title="Verified">
                         <i class="fa-circle-check fa-solid fs-3 me-2 text-success"></i>
                    </div>
                    <?php } ?>
                    <h1 class="page-header-title mb-0"><?php echo esc($userInfo->f_name).' '.esc($userInfo->l_name); ?></h1> 
                </div>
                <div class="fw-medium"><a href="#"><?php echo esc($userInfo->username); ?></a></div>

                

                <div class="row justify-content-center">
                    <div class="col-md-7">
                        <div class="read-more js-read-more" data-rm-words="60">
                            <p> 
                                <?php echo esc($userInfo->bio); ?>
                            </p> 
                        </div> 

                    </div>
                </div>
 
            </div> 
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
            <ul class="nav custom-tabs nav-tabs align-items-center mb-5">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($tab == 'created')? 'active' : '' ?>" href="<?php echo base_url('user/dashboard?my=created'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-file-plus me-1">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="12" y1="18" x2="12" y2="12"></line>
                            <line x1="9" y1="15" x2="15" y2="15"></line>
                        </svg> <?php echo display('Created_NFT'); ?> 
                        <span class="ms-2"><?php echo esc($totalCreated); ?></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo empty($tab) ? 'active' : '' ?>" href="<?php echo base_url('user/dashboard'); ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-shopping-cart me-1">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg> <?php echo display('Collected_NFT'); ?>
                        <span class="ms-2"><?php echo esc($totalCollected); ?></span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link <?php echo ($tab == 'favorite')? 'active' : '' ?>" href="<?php echo base_url('user/dashboard?my=favorite'); ?>">

                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-heart me-1">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                            </path>
                        </svg> <?php echo display('My_Favourite'); ?>
                        <span class="ms-2"><?php echo esc($totalFav); ?></span>
                    </a>
                </li>
               
            </ul>
            <div class="tab-content">
                 
                <div class="row g-3 item-wrap" id="nftdata" mytab="<?php echo esc($tab); ?>">
                      
                </div>

                 
            </div>
 
            <?php if($totalCollected > $limit){
                echo '<button type="button" class="btn btn-outline-primary load-btn" id="loadmorenft">Load More'.esc($total).'</button>';
            } ?>
            
        </div>

        <br>
        <br>
        <br>



 