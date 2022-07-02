<div class="profile-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="border rounded-5 p-3 p-sm-5">
                <h2 class="fw-bold mb-5">
                    <span><?php echo (!empty($title)) ? esc($title) : null; ?></span>

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-file-plus">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="12" y1="18" x2="12" y2="12"></line>
                        <line x1="9" y1="15" x2="15" y2="15"></line>
                    </svg>
                    
                </h2>
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
                    <?php echo form_open("user/mynft_update/{$info->token_id}/{$info->id}/{$info->contract_address}", ""); ?>
                    
                        
                        <div class="mb-4">
                            <label for="nft-title" class="form-label fw-semi-bold text-black mb-1"><?php echo display('NFT_Title'); ?></label>
                            <input type="text" name="item_name" value="<?php echo esc($info->name); ?>" class="form-control" id="item_name" placeholder="NFT title" required="required">
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semi-bold text-black mb-1"><?php echo display('NFT_Description'); ?></label> 
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="<?php echo display('Write_your_item_description'); ?>"><?php echo esc($info->description); ?></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2 justify-content-center">
                                <label for="exampleFormControlInput1"
                                        class="form-label fw-semi-bold text-black mb-0"><?php echo display('NFT_Characteristics'); ?></label> 
                                <button id="btn-add" type="button" class="btn btn-outline-primary p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-plus">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>

                            </div>
                            <?php 
                            if($info->properties){  
                            $properties = json_decode($info->properties);
                            if($properties){
                                $properties = $properties;
                            }else{
                                $properties = array();
                            }
                            foreach ($properties as $key => $property) { 
                            ?>
                                <div id="edited-properties">
                                    <div id="opt-row.0" class="form-group row align-items-end mb-3 g-1">
                                        <div class="col"> 
                                            <input value="<?php echo esc($key); ?>" type="text" class="form-control" id="opt-type.0" name="opt_type[]" placeholder="Ex: White" required="required">
                                        </div>
                                        <div class="col"> 
                                            <div class="input-group">
                                                <input value="<?php echo esc($property); ?>" type="text" class="form-control" id="opt-name.0" name="opt_val[]" placeholder="EX: 20%" required="required">
                                                <span class="input-group-text">@</span>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button delet-id="0" type="button" class="btn btn-danger deleteRow"><?php echo display('Delete'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            <?php  
                                } 
                            }
                            ?>

                            <div id="form-placeholder"></div>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label fw-semi-bold text-black mb-1"><?php echo display('Collection'); ?></label>
                            <p class="fw-medium small mb-1"><?php echo display('This_is_the_collection_where_your_item_will_appear'); ?>.
                            </p>
                         
                            <?php  
                            $att = ["class"=>"form-control", "id"=>"collections", "required"=>"required", "disabled"=>"disabled"]; 
                            $op = array();
                            foreach ($collections as $key => $colVal) {
                                $op[$colVal->id] = $colVal->title;  
                            }
                            echo form_dropdown('collection', $op, set_value('collection', esc($info->collection_id)), $att);
                            ?>
                        </div>
                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label fw-semi-bold text-black mb-1"><?php echo display('Blockchain_Network'); ?></label>
                            <select name="blockchain" class="form-select" aria-label="Default select example" disabled>
                               
                                    <option selected value="<?php echo esc($network->id); ?>"><?php echo esc($network->network_name); ?></option> 
                                 
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label fw-semi-bold text-black mb-1"><?php echo display('add_image_file'); ?> <span class="text-danger"> *</span>

                            <div class="profile-pic-wrapper upload-file">
                                <div class="pic-holder pic-holder-banner">
                                    <!-- uploaded pic shown here -->
                                    <?php if($info->file){ ?>
                                        <img id="profilePic" class="pic" src="<?php echo base_url().esc($info->file);     ?>">
                                    <?php }else{ ?>
                                        <img id="profilePic" class="pic" src="<?php echo esc($frontendAssets); ?>/img/placeholder.png">
                                    <?php } ?> 
                                </div> 
                            </div>
                            <p class="fw-medium small mt-1 small mb-3"><?php echo display('support_file'); ?></p>
                        </div>
                         
                        <button type="submit" class="btn btn-dark w-100 btn-profile mt-4"><?php echo display('update'); ?></button>
                 
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
 