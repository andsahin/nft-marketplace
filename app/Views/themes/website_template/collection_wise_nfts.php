        <div class="container">
            <!-- Start profile cover -->
            <div class="profile-cover">
                <div class="profile-cover-img-wrapper">
                    <?php if($collectionInfo->banner_image){ ?>
                        <img class="profile-cover-img" src="<?php echo base_url().esc($collectionInfo->banner_image); ?>" alt="Image Description">
                    <?php }else{ ?>
                        <img class="profile-cover-img" src="<?php echo esc($frontendAssets); ?>/img/header-bg-02.png" alt="Image Description">
                    <?php } ?>
                </div>
            </div>
            <!-- /.End of profile cover -->
            <!-- Start profile header -->
            <div class="text-center mb-5">
                <div class="profile-cover-avatar">
                    <?php if($collectionInfo->logo_image){ ?>
                        <img class="avatar-img" src="<?php echo base_url().esc($collectionInfo->logo_image); ?>" alt="banner-image">
                    <?php }else{ ?>
                        <img class="avatar-img" src="<?php echo esc($frontendAssets); ?>/img/avatar/01.gif" alt="logo-image">
                    <?php } ?>
                     
                </div>

                <div class="d-flex align-items-center justify-content-center mb-3">
                    <h1 class="page-header-title mb-0"><?php echo esc($collectionInfo->title); ?></h1>

                    <?php if($collectionInfo->status == 1){ ?>
                    <!-- Verification icon -->
                    <div aria-hidden="true" class="verification-icon-wrap ms-2" data-bs-toggle="tooltip"
                        data-bs-placement="right" title="Verified">
                        <svg class="verification-icon" fill="none" viewBox="0 0 30 30">
                            <path class="verification-icon-background"
                                d="M13.474 2.80108C14.2729 1.85822 15.7271 1.85822 16.526 2.80108L17.4886 3.9373C17.9785 4.51548 18.753 4.76715 19.4892 4.58733L20.9358 4.23394C22.1363 3.94069 23.3128 4.79547 23.4049 6.0278L23.5158 7.51286C23.5723 8.26854 24.051 8.92742 24.7522 9.21463L26.1303 9.77906C27.2739 10.2474 27.7233 11.6305 27.0734 12.6816L26.2903 13.9482C25.8918 14.5928 25.8918 15.4072 26.2903 16.0518L27.0734 17.3184C27.7233 18.3695 27.2739 19.7526 26.1303 20.2209L24.7522 20.7854C24.051 21.0726 23.5723 21.7315 23.5158 22.4871L23.4049 23.9722C23.3128 25.2045 22.1363 26.0593 20.9358 25.7661L19.4892 25.4127C18.753 25.2328 17.9785 25.4845 17.4886 26.0627L16.526 27.1989C15.7271 28.1418 14.2729 28.1418 13.474 27.1989L12.5114 26.0627C12.0215 25.4845 11.247 25.2328 10.5108 25.4127L9.06418 25.7661C7.86371 26.0593 6.6872 25.2045 6.59513 23.9722L6.48419 22.4871C6.42773 21.7315 5.94903 21.0726 5.24777 20.7854L3.86969 20.2209C2.72612 19.7526 2.27673 18.3695 2.9266 17.3184L3.70973 16.0518C4.10824 15.4072 4.10824 14.5928 3.70973 13.9482L2.9266 12.6816C2.27673 11.6305 2.72612 10.2474 3.86969 9.77906L5.24777 9.21463C5.94903 8.92742 6.42773 8.26854 6.48419 7.51286L6.59513 6.0278C6.6872 4.79547 7.86371 3.94069 9.06418 4.23394L10.5108 4.58733C11.247 4.76715 12.0215 4.51548 12.5114 3.9373L13.474 2.80108Z">
                            </path>
                            <path d="M13.5 17.625L10.875 15L10 15.875L13.5 19.375L21 11.875L20.125 11L13.5 17.625Z"
                                fill="white" stroke="white"></path>
                        </svg>
                    </div>
                    <?php } ?>
                </div>
                <div class="fw-medium"><?php echo display('Created_by'); ?> &nbsp;<a href="<?php echo base_url('nft').'/'.esc($ownerInfo->username); ?>"><?php echo esc($ownerInfo->f_name).' '.esc($ownerInfo->l_name); ?></a></div>


            <div class="bg-white p-4 mt-3 rounded-4">
                <div class="row">
                    <div class="col-lg-6">
                         <div class="read-more js-read-more" data-rm-words="60">
                            <p> 
                                <?php echo esc($collectionInfo->description); ?>
                            </p> 
                        </div>
                    </div>
                    <div class="col-lg-4 offset-lg-2">
                        <table class="table table-borderless table-sm text-start mb-0">
                            <tbody>
                                <tr>
                                    <td width="100"><?php echo display('Items'); ?></td>
                                     <td><div class="fw-bold fs-4 text-dark ms-2"><?php echo esc($totalItem); ?></div></td>
                                </tr>
                                <tr>
                                    <td><?php echo display('Owners'); ?></td>
                                     <td><div class="fw-bold fs-4 text-dark ms-2"><?php echo esc($nftOwner); ?></div></td>
                                </tr>
                                <tr>
                                    <td><?php echo display('Minimum_price'); ?></td>
                                     <td> <div class="fw-bold fs-4 text-dark ms-2"><?php echo number_format(esc($floorPrice->price), 3, '.', ','); ?></div></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                

               
 
            </div>
            <!-- /.End of profile header -->
 
            <ul class="nav custom-tabs nav-tabs align-items-center mb-5">
                <li class="nav-item">
                    <a class="nav-link active"><?php echo display('Items'); ?></a>
                </li>
                 
                <li class="nav-item ms-auto">
                    <div class="d-flex gap-2">



                        <div class="d-flex filter mb-2">
                            <div class="dropdown me-2 nav-scroller-dropdown">
                                <button class="btn btn-filter dropdown-toggle" type="button"
                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path
                                            d="M7.994 153.5c1.326 0 2.687 .3508 3.975 1.119L208 271.5v223.8c0 9.741-7.656 16.71-16.01 16.71c-2.688 0-5.449-.7212-8.05-2.303l-152.2-92.47C12.13 405.3 0 383.3 0 359.5v-197.7C0 156.1 3.817 153.5 7.994 153.5zM426.2 117.2c0 2.825-1.352 5.647-4.051 7.248L224 242.6L25.88 124.4C23.19 122.8 21.85 119.1 21.85 117.2c0-2.8 1.32-5.603 3.965-7.221l165.1-100.9C201.7 3.023 212.9 0 224 0s22.27 3.023 32.22 9.07l165.1 100.9C424.8 111.6 426.2 114.4 426.2 117.2zM440 153.5C444.2 153.5 448 156.1 448 161.8v197.7c0 23.75-12.12 45.75-31.78 57.69l-152.2 92.5C261.5 511.3 258.7 512 256 512C247.7 512 240 505 240 495.3V271.5l196-116.9C437.3 153.8 438.7 153.5 440 153.5z" />
                                    </svg>
                                    <?php echo display('Blockchain'); ?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                    <?php foreach ($networks as $key => $network) {
                                        echo '<li><a class="dropdown-item" href="#">'.esc($network->network_name).'</a></li>';
                                    } ?>
                                    
                                </ul>
                            </div>
                            <div class="dropdown me-2 nav-scroller-dropdown">
                                <button class="btn btn-filter dropdown-toggle" type="button"
                                    id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                   
                                        <path
                                            d="M384 32C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H384zM384 96H256V224H384V96zM384 288H256V416H384V288zM192 224V96H64V224H192zM64 416H192V288H64V416z" />
                                    </svg>
                                    <?php echo display('Category'); ?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <li><a class="dropdown-item" href="<?php echo base_url('all'); ?>"><?php echo display('All'); ?></a></li>
                                    <?php  foreach ($ctegories as $key => $cat) {
                                        echo '<li><a class="dropdown-item" href="'.base_url("category").'/'.esc($cat->slug).'">'.esc($cat->cat_name).'</a></li>';
                                    } ?>
                                    
                                </ul>
                            </div>
                            <div class="dropdown me-2 nav-scroller-dropdown">
                                <button class="btn btn-filter dropdown-toggle" type="button"
                                    id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                   
                                        <path
                                            d="M423.3 440.7c0 25.3-20.3 45.6-45.6 45.6s-45.8-20.3-45.8-45.6 20.6-45.8 45.8-45.8c25.4 0 45.6 20.5 45.6 45.8zm-253.9-45.8c-25.3 0-45.6 20.6-45.6 45.8s20.3 45.6 45.6 45.6 45.8-20.3 45.8-45.6-20.5-45.8-45.8-45.8zm291.7-270C158.9 124.9 81.9 112.1 0 25.7c34.4 51.7 53.3 148.9 373.1 144.2 333.3-5 130 86.1 70.8 188.9 186.7-166.7 319.4-233.9 17.2-233.9z" />
                                    </svg><?php echo display('Collections'); ?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                     
                                    <?php 
                                    foreach ($collections as $key => $collection) {
                                        if($collectionInfo->id != $collection->id) {  
                                    ?>
                                        <a class="dropdown-item" href="<?php echo base_url('collection/'.$collection->slug); ?>">
                                            <i class="bi-share-fill dropdown-item-icon"></i> <?php echo esc($collection->title); ?>
                                        </a> 
                                    <?php 
                                        }
                                    }

                                    ?>
                                </ul>
                            </div>
                           
                             
                        </div>
                    </div>
                </li>
            </ul>
            <div collect-id="<?php echo esc($collectionInfo->id); ?>" class="row g-3 item-wrap" id="ajax_collection_wise_nfts">
                
            </div>
            <?php if($totalItem > 20){
                echo '<button type="button" class="btn btn-outline-primary load-btn" id="loadmore_coll_nft">Load More</button>';
            } ?>
            
        </div>

        <br>
        <br>
        <br>


 