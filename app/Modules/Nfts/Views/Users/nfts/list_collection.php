<div class="py-5">
    <div class="container">
        <div class="d-flex align-items-center flex-wrap justify-content-between border-bottom pb-2 mb-5">
            <h2 class="fw-semi-bold"><?php echo (!empty($title)) ?  esc($title) : null; ?></h2>
             
            <a href="<?php echo base_url('user/add-collection'); ?>" class="btn btn-primary"><?php echo display('Create_new_collection'); ?></a>
        </div>
        <div class="row g-4">
        <?php 
        if(count($collections) > 0){
        foreach ($collections as $key => $collection) { 
        ?> 
            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
                <div class="position-relative">
                    <a class="end-0 fs-5 me-3 mt-3 position-absolute text-white top-0 z-1" href="<?php echo base_url('user/edit-collection/'.$collection->id); ?>"><i class="fa fa-pen-to-square"></i></a>
                    <a href="<?php echo base_url('collection/'.$collection->slug); ?>" class="snip1336">
                        <?php  if($collection->banner_image){  ?>
                            <img src="<?php echo esc( base_url().$collection->banner_image ); ?>" alt="sample87" class="profile-bg"/>
                        <?php }else{ ?>
                            <img src="<?php echo esc($frontendAssets); ?>/img/header-bg-02.png" alt="sample87" class="profile-bg"/>
                        <?php } ?>
                        <figcaption>
                            <?php if($collection->logo_image){ ?>
                                <img src="<?php echo esc(base_url().$collection->logo_image); ?>" alt="profile-sample4" class="profile" />
                            <?php }else{ ?>
                                <img src="<?php echo esc($frontendAssets); ?>/img/avatar/01.gif" alt="profile-sample4" class="profile" />
                            <?php } ?>
                            <h5><?php echo esc($collection->title); ?></h5>
                            <span><?php echo ($collection->totalNfts) ? esc($collection->totalNfts).' Item' : ''; ?></span> 
                            <p><?php echo esc($collection->description); ?></p>
                        </figcaption>
                    </a>
                </div>
            </div>  
        <?php 
            } 
        }else{  ?>

            <div class="row g-3 item-wrap"> 
                <div class="card">
                    <div class="align-items-center card-body d-flex ji justify-content-center empty-tag">
                        <blockquote class="blockquote mb-0">
                          <h4 class="text-center text-primary"><?php echo display('Data_not_found'); ?></h4> 
                        </blockquote>
                    </div>
                </div>  
            </div>

        <?php
        } 
        if($total > $limit){
            echo esc($pager);
        } 
        ?>

         </div>
    </div>
</div>
