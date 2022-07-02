<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?$title:null) ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>  
                     
            <div class="card-body">

                <?php echo form_open_multipart(base_url("backend/account/edit_profile")) ?>                    
                    <?php echo form_hidden('id',esc($user->id)) ?>
                    
                    <div class="form-group row">
                        <label for="firstname" class="col-sm-3 col-form-label"><?php echo display('firstname'); ?> <span class="text-danger"> *</span></label>
                        <div class="col-sm-9">
                            <input name="firstname" class="form-control" type="text" placeholder="<?php echo display('firstname'); ?>" id="firstname"  value="<?php echo esc($user->firstname) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lastname" class="col-sm-3 col-form-label"><?php echo display('lastname'); ?>*</label>
                        <div class="col-sm-9">
                            <input name="lastname" class="form-control" type="text" placeholder="<?php echo display('lastname'); ?>" id="lastname" value="<?php echo esc($user->lastname) ?>">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label"><?php echo display('email'); ?> <span class="text-danger"> *</span></label>
                        <div class="col-sm-9">
                            <input name="email" class="form-control" type="text" placeholder="<?php echo display('email'); ?>" id="email" value="<?php echo esc($user->email) ?>">
                        </div>
                    </div> 
                   

                    <div class="form-group row">
                        <label for="about" class="col-sm-3 col-form-label"><?php echo display('about'); ?></label>
                        <div class="col-sm-9">
                            <textarea name="about" placeholder="<?php echo display('about'); ?>" class="form-control" id="about"><?php echo htmlspecialchars_decode($user->about) ?></textarea>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="preview" class="col-sm-3 col-form-label"><?php echo display('Preview'); ?></label>
                        <div class="col-sm-9">
                            <img src="<?php echo base_url(!empty($user->image)?esc($user->image): base_url()."/public/assets/images/icons/user.png") ?>" class="img-thumbnail" width="125" height="100">
                        </div>
                        <input type="hidden" name="old_image" value="<?php echo esc($user->image) ?>">
                    </div> 

                    <div class="form-group row">
                        <label for="image" class="col-sm-3 col-form-label"><?php echo display('Image'); ?></label>
                        <div class="col-sm-9">
                            <input type="file" name="image" id="image" aria-describedby="fileHelp">
                            <small id="fileHelp" class="text-muted"></small>
                        </div>
                    </div> 

                    <div id="flip" class="form-group row">
                        <div class="col-sm-3"></div>
                        <a class="col-sm-9 text-danger" href="javascript:void(0)"><?php echo display('Click_to_change_password'); ?></a> 
                    </div>
                     
                    <div id="panel">
                        <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label"><?php echo display("password") ?> <span class="text-danger"> *</span></label>
                            <div class="col-sm-9">
                                <input name="password" class="form-control" type="password" placeholder="<?php echo display("password") ?>" id="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="conf_password" class="col-sm-3 col-form-label"><?php echo display("conf_password"); ?><span class="text-danger"> *</span></label>
                            <div class="col-sm-9">
                                <input name="conf_password" class="form-control" type="password" placeholder="<?php echo display("conf_password") ?>" id="conf_password">
                            </div>
                        </div>
                    </div>
         
                    <div class="form-group" align="center">
                        <a href="<?php echo base_url('backend/dashboard'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo esc($user->id) ? display("update"):display("create") ?></button>
                    </div>
                <?php echo form_close() ?>

            </div>
        </div>
    </div>
</div>

 <script src="<?php echo base_url("app/Modules/System_user/Assets/Admin/js/user.js") ?>"></script>
 