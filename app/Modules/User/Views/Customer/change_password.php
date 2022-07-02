<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="panel-title">
                    <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?$title:null) ?></h6>            
                </div>
            </div>
            <div class="card-body">
                <div class="border_preview">

                <?php echo form_open_multipart(base_url("customer/profile/change_save")) ?>
                
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label><?php echo display("enter_old_password") ?><span class="text-danger"> *</span></label>
                            <input type="password" class="form-control" value="<?php echo (isset($set_old->old_pass)?esc($set_old->old_pass):'');?>" name="old_pass" placeholder="<?php echo display("enter_old_password") ?>">
                        </div>

                        <div class="form-group col-lg-12">
                            <label><?php echo display("enter_new_password") ?><span class="text-danger"> *</span></label>
                            <input type="password"  class="form-control" value="<?php echo (isset($set_old->new_pass)?esc($set_old->new_pass):'');?>" name="new_pass" placeholder="<?php echo display("enter_new_password") ?>">
                        </div>

                        <div class="form-group col-lg-12">
                            <label><?php echo display("enter_confirm_password") ?><span class="text-danger"> *</span></label>
                            <input type="password"  class="form-control" name="confirm_pass" value="<?php echo (isset($set_old->confirm_pass)?esc($set_old->confirm_pass):'');?>" placeholder="<?php echo display("enter_confirm_password") ?>">
                        </div>

                        
                    </div> 

                    <div>
                        <button type="submit" class="btn btn-success"><?php echo display("change") ?></button>
                    </div>
                <?php echo form_close() ?>
            </div>

            </div>
        </div>
    </div>
</div>

 