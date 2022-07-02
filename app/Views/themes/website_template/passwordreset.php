  
<div class="profile-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <h2 class="fw-bold mb-5">
                    <span><?php echo "$title"; ?></span>
                   
                </h2>
                <div class="row">
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
                    <?php echo form_open_multipart("", ""); ?>
                    <div class="col-md-9">
                       

                        <div class="mb-4">
                            <label for="nft-title" class="form-label fw-semi-bold text-black mb-1"><?php echo display('verification_code') ?></label>
                             
                            <input class="form-control" name="verificationcode" id="verificationcode" placeholder="<?php echo display('verification_code') ?>" type="text" autocomplete="off" required>
                        </div>


                        <div class="mb-4">
                            <label for="nft-title" class="form-label fw-semi-bold text-black mb-1"><?php echo display('new_password') ?></label>
                             
                            <input class="form-control" name="newpassword" id="pass" placeholder="<?php echo display('new_password') ?>" type="password" autocomplete="off" required>
                        </div>


                        <div class="mb-4">
                            <label for="nft-title" class="form-label fw-semi-bold text-black mb-1"><?php echo display('conf_password') ?></label>
                             
                            <input class="form-control" name="r_pass" id="r_pass" placeholder="<?php echo display('conf_password') ?>" type="password" autocomplete="off" required>
                        </div>
                          
                        <button type="submit" class="btn btn-dark w-100 btn-profile mt-4"><?php echo display('Reset'); ?></button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
 
        
