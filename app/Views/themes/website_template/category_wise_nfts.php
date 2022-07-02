<div class="my-5">
    <div class="container">
        <!-- flex-wrap -->
        <div class="mb-4 filter-wrap d-flex">

            <div class="d-flex filter me-3">
                <div class="dropdown me-2">
                    <button class="btn btn-filter dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
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
                <div class="dropdown me-2">
                    <button class="btn btn-filter dropdown-toggle" type="button" id="dropdownMenuButton2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                           
                            <path
                                d="M384 32C419.3 32 448 60.65 448 96V416C448 451.3 419.3 480 384 480H64C28.65 480 0 451.3 0 416V96C0 60.65 28.65 32 64 32H384zM384 96H256V224H384V96zM384 288H256V416H384V288zM192 224V96H64V224H192zM64 416H192V288H64V416z" />
                        </svg>
                        <?php echo display('Category'); ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                        <li><a class="dropdown-item" href="<?php echo base_url('all'); ?>"><?php echo display('All'); ?></a></li>
                        <?php foreach ($actegories as $key => $category) {  ?>
                            <li><a class="dropdown-item" href="<?php echo base_url('category').'/'.$category->slug; ?>"><?php echo esc($category->cat_name); ?></a></li>
                        <?php } ?> 
                    </ul>
                </div>
                <div class="dropdown me-2">
                    <button class="btn btn-filter dropdown-toggle" type="button" id="dropdownMenuButton3"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                         
                            <path
                                d="M423.3 440.7c0 25.3-20.3 45.6-45.6 45.6s-45.8-20.3-45.8-45.6 20.6-45.8 45.8-45.8c25.4 0 45.6 20.5 45.6 45.8zm-253.9-45.8c-25.3 0-45.6 20.6-45.6 45.8s20.3 45.6 45.6 45.6 45.8-20.3 45.8-45.6-20.5-45.8-45.8-45.8zm291.7-270C158.9 124.9 81.9 112.1 0 25.7c34.4 51.7 53.3 148.9 373.1 144.2 333.3-5 130 86.1 70.8 188.9 186.7-166.7 319.4-233.9 17.2-233.9z" />
                        </svg><?php echo display('Collections'); ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                        <?php 
                         foreach ($collections as $key => $collection) { 
                            ?>
                                <a class="dropdown-item" href="<?php echo base_url('collection/'.$collection->slug); ?>">
                                    <i class="bi-share-fill dropdown-item-icon"></i> <?php echo esc($collection->title); ?>
                                </a> 
                            <?php  
                            }
                        ?>
                    </ul>
                </div> 
            </div> 
            
        </div>
        <div cat-id="<?php echo esc($categoryInfo->id); ?>" class="row g-3 item-wrap" id="ajax_category_wise_nfts">

            
             
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if($total > 20){
                    echo '<button type="button" class="btn btn-outline-primary load-btn" id="loadmore_cat_nfts">'.display("Load_More").'</button>';
                } ?>
                
            </div>
        </div>
    </div>
</div>