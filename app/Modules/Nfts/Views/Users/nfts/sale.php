
<div class="py-5">
    <div class="container">
        <h4 class="fw-bold my-4"><?php echo display('List_item_for_sale'); ?></h4>

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

         
         

        <ul class="nav nav-tabs mb-5" id="myTab" role="tablist">
            <?php 
            if($selling_types[0]->status == 1){
            ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="auction-tab" data-bs-toggle="tab"
                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                    aria-selected="true"><?php echo display('Auction'); ?></button>
            </li>
            <?php 
            } 

            if($selling_types[1]->status == 1){  
            ?>

            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo ($selling_types[0]->status == 0) ? 'active' : ''; ?>" id="fixedprice-tab" data-bs-toggle="tab" data-bs-target="#profile"
                    type="button" role="tab" aria-controls="profile"
                    aria-selected="false"><?php echo display('Fixed_Price'); ?></button>
            </li>
            <?php } ?>

        </ul>

        <div class="tab-content" id="myTabContent">
        <span class="text-danger te"><?php echo display('Gas_fees_will_be_deducted_from_your_wallet'); ?></span><br>
            <!-- 2nd tab -->
            <?php 
            if($selling_types[0]->status == 1){
            ?>
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="auction-tab">
                 <?php echo form_open("user/asset/sale/{$nftInfo->token_id}/{$nftInfo->id}/{$nftInfo->contract_address}", 'id="list_for_sale_form"'); ?>
                <div class="row">
                    <div class="col-md-7"> 
                        <input type="hidden" name="sale_type" value="Bid">
                        <input type="hidden" name="start_date" value="" class="start_date">
                        <input type="hidden" name="end_date" value="" class="end_date">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1"
                                class="form-label fw-semi-bold text-black mb-1"><?php echo display('Starting_Price'); ?></label>
                            <div class="g-3 row">
                                <div class="col-md-4">
                                    <select class="form-select" aria-label="Default select example" disabled>
                                        <option selected><?php echo SYMBOL; ?></option> 
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="price" class="form-control" id="amount" placeholder="<?php echo display('Amount'); ?>">
                                </div>
                            </div>
                        </div>
 

                        <div class="mb-4">
                            <label for="exampleFormControlInput1"
                                class="form-label fw-semi-bold text-black mb-1"><?php echo display('Duration'); ?></label>
                            <div class="dropdown">
                                <input type="text" name="duration" value="" class="form-control dropdown-toggle" id="duration-calnader"> 
                            </div>
                        </div> 
 
                         <div class="mb-4"> 
                            <div class="">
                                <button type="submit" class="btn btn-primary"><?php echo display('Complete_listing'); ?></button>
                            </div> 
                        </div>  
                    </div>

                    <div class="col-md-3 offset-md-1">
                        <label class="form-label fw-semi-bold text-black mb-1"><?php echo display('Preview'); ?></label>
                        <div class="card nft-items nft-primary rounded-7 border-0 overflow-hidden mb-1 p-4">
                            <div class="nft-image rounded-7 position-relative">
                                <a class="item-img position-relative overflow-hidden d-block">
                                    <img
                                        src="<?php echo base_url().'/'.$nftInfo->file; ?>" class="img-fluid" alt=""></a>
                            </div>
                            <div class="card-body content position-relative"> 
                                <a class="d-block fw-semi-bold h6 text-dark text-truncate title"><?php echo esc($nftInfo->name).' #'.esc($nftInfo->token_id); ?></a>
                                 
                            </div>
                        </div>
                    </div> 
                </div>
                <?php echo form_close(); ?>
            </div> 
            <?php } ?>

            <!-- 2nd tab -->
            <?php
            if($selling_types[1]->status == 1){  
            ?>
            <div class="tab-pane fade <?php echo ($selling_types[0]->status == 0) ? 'show active' : ''; ?>" id="profile" role="tabpanel" aria-labelledby="fixedprice-tab"> 
                <?php echo form_open("user/asset/sale/{$nftInfo->token_id}/{$nftInfo->id}/{$nftInfo->contract_address}", 'id="list_for_sale_form"'); ?>
                <div class="row">
                    <div class="col-md-7"> 
                        <input type="hidden" name="sale_type" value="Fix">
                        <input type="hidden" name="start_date" value="" class="start_date">
                        <input type="hidden" name="end_date" value="" class="end_date">
                        <div class="mb-4">
                            <label for="exampleFormControlInput1"
                                class="form-label fw-semi-bold text-black mb-1"><?php echo display('Price'); ?></label>
                            <div class="g-3 row">
                                <div class="col-md-4">
                                    <select class="form-select" aria-label="Default select example" disabled>
                                        <option selected><?php echo SYMBOL; ?></option> 
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="price" class="form-control" id="amount" placeholder="<?php echo display('Amount'); ?>">
                                </div>
                            </div>
                        </div>
 

                        <div class="mb-4">
                            <label for="exampleFormControlInput1"
                                class="form-label fw-semi-bold text-black mb-1"><?php echo display('Duration'); ?></label>
                            <div class="dropdown">
                                <input type="text" name="duration" value="" class="form-control dropdown-toggle" id="duration-calnader2"> 
                            </div>
                        </div>  
                       
                        <button type="submit" class="btn btn-primary"><?php echo display('Complete_listing'); ?></button>
                    </div>

                    <div class="col-md-3 offset-md-1">
                        <label class="form-label fw-semi-bold text-black mb-1"><?php echo display('Preview'); ?></label>
                        <div class="card nft-items nft-primary rounded-7 border-0 overflow-hidden mb-1 p-4">
                            <div class="nft-image rounded-7 position-relative">
                                <a class="item-img position-relative overflow-hidden d-block">
                                    <img src="<?php echo base_url().'/'.$nftInfo->file; ?>" class="img-fluid" alt=""></a>
                            </div>
                            <div class="card-body content position-relative"> 
                                <a class="d-block fw-semi-bold h6 text-dark text-truncate title"><?php echo esc($nftInfo->name).' #'.esc($nftInfo->token_id); ?></a>
                                 
                            </div>
                        </div>
                    </div> 
                </div>
                <?php echo form_close(); ?>
            </div>
            <?php } ?>
        </div>
        
    </div>
</div>
 