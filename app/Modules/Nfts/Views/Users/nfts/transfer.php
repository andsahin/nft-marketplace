
<div class="py-5">
    <div class="container">
        <h4 class="fw-bold my-4"><?php echo display('Transfer_Item'); ?></h4>

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

         
        
        <div class="tab-content" id="myTabContent">
        <span class="text-danger te"><?php echo display('Transfer_fees'); ?> (<?php echo (isset($fees)) ? $fees->fees : ''; ?>) + <?php echo display('Gas_fees_will_be_deducted_from_your_wallet'); ?></span><br> 
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="auction-tab">
                 <?php echo form_open("user/assets/transfer/{$nftInfo->id}/{$nftInfo->token_id}/{$nftInfo->contract_address}", 'id="list_for_sale_form"'); ?>
                <div class="row">
                    <div class="col-md-7">  
                        <div class="mb-4">

                            <label for="exampleFormControlInput1" class="form-label fw-semi-bold text-black mb-1"><?php echo display('To_Wallet'); ?></label>

                            <div class="g-3 row"> 
                                <div class="col-md-12">
                                    <input type="text" name="towallet" class="form-control" id="towallet" placeholder="Ex: 0x.........">
                                </div>
                            </div>

                        </div>
  
                         <div class="mb-4"> 
                            <div class="">
                                <button type="submit" class="btn btn-primary"><?php echo display('Transfer'); ?></button>
                            </div>

                        </div>  
                       
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
            
 
        </div>
        
    </div>
</div>
 