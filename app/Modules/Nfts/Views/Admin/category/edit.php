<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title) ? esc($title) : null) ?></h6>


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
                    <?php echo form_open_multipart(base_url("backend/nft/update_category/".$info->id)); ?> 
                        <div class="form-group row">
                            <label for="image" class="col-sm-3 col-form-label"><?php echo display('logo_image'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6"> 
                                <div class="text-left pro-img">
                                    <img class="text-center" src="<?php echo base_url().$info->logo; ?>" id="profile_tag" width="200px" />
                                </div>
                                <input type="file" name="logo" id="profile_img" aria-describedby="fileHelp"> <br>
                                <span class="every-cl-rd"><?php echo display('recommended_to'); ?> 350 x 350 px (png,jpg,gif,ico,jpeg).</span>
                            </div>  
                        </div> 
                        <div class="form-group row">
                            <label for="cat_name" class="col-sm-3 col-form-label"><?php echo display('Category_Name'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input name="cat_name" value="<?php echo esc($info->cat_name); ?>" class="form-control" type="text" id="cat_name" autocomplete="off" required>
                            </div> 
 
                        </div> 
                        <div class="form-group row">
                            <label for="description" class="col-sm-3 col-form-label"><?php echo display('Description'); ?> </label>
                            <div class="col-sm-6"> 
                                <?php 
                                $data = array(
                                  'name'        => 'description',
                                  'id'          => 'description',
                                  'class'       => 'form-control',
                                  'value'       => esc($info->description),
                                  'rows'        => '3',
                                  'cols'        => '30',
                                  'style'       => 'width:100%',
                                );
                                echo form_textarea($data);
                                ?>
                            </div>
                            
                        </div> 
                        <div class="form-group row">
                            <label for="currency_symbol" class="col-sm-3 col-form-label"><?php echo display('Status'); ?><i class="text-danger">*</i></label>
                            <div class="col-sm-6"> 
                                <?php
                                $att = [
                                  "id"=>"status",  
                                  "class"=>"form-control",   
                                  "required"=>"required",   
                                ];  
                                $options = [
                                    '1'  => 'Active',
                                    '0'    => 'Inactive', 
                                ]; 
                                echo form_dropdown('status', $options, esc($info->status), $att); 
                                ?>
                            </div>
                            
                        </div>  
                      
                        <div class="row" align='center'>
                            <div class="col-sm-8 col-sm-offset-3">
                                <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                                <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display("update") ?></button>
                            </div>
                        </div>
                    <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url("app/Modules/Nfts/Assets/Admin/js/custom.js") ?>"></script>
 