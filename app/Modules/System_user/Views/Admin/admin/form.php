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
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <?php echo form_open_multipart(base_url("backend/account/admin_information/$admin->id")) ?>
                    
                    <?php echo form_hidden('id',esc($admin->id)) ?>
                    
                    <div class="form-group row">
                        <label for="firstname" class="col-sm-3 col-form-label"><?php echo display('firstname') ?><span class="text-danger"> *</span></label>
                        <div class="col-sm-9">
                            <input name="firstname" class="form-control" type="text" placeholder="<?php echo display('firstname') ?>" id="firstname"  value="<?php echo esc($admin->firstname) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lastname" class="col-sm-3 col-form-label"><?php echo display('lastname') ?><span class="text-danger"> *</span></label>
                        <div class="col-sm-9">
                            <input name="lastname" class="form-control" type="text" placeholder="<?php echo display('lastname') ?>" id="lastname" value="<?php echo esc($admin->lastname) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label"><?php echo display('email') ?><span class="text-danger"> *</span></label>
                        <div class="col-sm-9">
                            <input name="email" class="form-control" type="text" placeholder="<?php echo display('email') ?>" id="email" value="<?php echo esc($admin->email) ?>">
                        </div>
                    </div> 

                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label"><?php echo display('password') ?><span class="text-danger"> *</span></label>
                        <div class="col-sm-9">
                            <input name="password" class="form-control" type="password" placeholder="<?php echo display('password') ?>" id="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="conf_password" class="col-sm-3 col-form-label"><?php echo display("conf_password"); ?><span class="text-danger"> *</span></label>
                        <div class="col-sm-9">
                            <input name="conf_password" class="form-control" type="password" placeholder="Password" id="conf_password">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="about" class="col-sm-3 col-form-label"><?php echo display('about') ?></label>
                        <div class="col-sm-9">
                            <textarea name="about" placeholder="<?php echo display('about') ?>" class="form-control" id="about"><?php echo esc($admin->about) ?></textarea>
                        </div>
                    </div>

                    <div class="form-group row">

                        <?php if (!empty(esc($admin->image))) { ?>

                        <label for="preview" class="col-sm-3 col-form-label"><?php echo display('preview') ?></label> 
                        <div class="col-sm-9"> 
                            <img src="<?php echo base_url($admin->image) ?>" class="img-thumbnail" width="125" height="100">
                        </div>

                         <?php } ?>

                        <input type="hidden" name="old_image" value="<?php echo esc($admin->image) ?>">
                    </div> 

                    <div class="form-group row">
                        <label for="image" class="col-sm-3 col-form-label"><?php echo display('image') ?></label>
                        <div class="col-sm-9">
                            <input type="file" name="image" id="image" aria-describedby="fileHelp">
                            <small id="fileHelp" class="text-muted"></small>
                            <div class="text-danger">51x38 px(jpg, jpeg, png, gif, ico)</div>
                            </div>
                    </div> 

         
                    <div class="form-group row" >
                        <label for="status" class="col-sm-3 col-form-label"><?php echo display('status'); ?> *</label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <?php echo form_radio('status', '1', ((esc($admin->status)==1 || $admin->status==null)?true:false), 'id="status"'); ?><?php echo display('active') ?>
                            </label>
                            <label class="radio-inline">
                                <?php echo form_radio('status', '0', ((esc($admin->status)=="0")?true:false) , 'id="status"'); ?><?php echo display('inactive') ?>
                            </label> 
                        </div>
                    </div>
         
                    <div class="row" align="center">
                        <div class="col-sm-12 col-sm-offset-3">
                            <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" name="<?php echo ($admin->id) ? 'edit' : 'add'; ?>" class="btn btn-success  w-md m-b-5"><?php echo esc($admin->id)?display("update"):display("create") ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>

             </div>
        </div>
    </div>
</div>
 