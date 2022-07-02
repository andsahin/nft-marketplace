<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?esc($title):null) ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                              <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="col-lg-12">
                    <div class="border_preview">
                        <p class="text-success text-center"><?php echo display('wallet_import_msg'); ?></p>
                    <?php echo form_open_multipart(base_url("backend/nft/wallet_import")) ?> 
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label"><?php echo display('Private_Key'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input name="private_key" value="" class="form-control" type="text" placeholder="<?php echo display('Enter_your_private_key'); ?>" id="name" autocomplete="off" required>
                            </div>
                            
                        </div>
                      
                        <div class="row" align='center'>
                            <div class="col-sm-8 col-sm-offset-3">
                                <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                                <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display("Import") ?></button>
                            </div>
                        </div>
                    <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
