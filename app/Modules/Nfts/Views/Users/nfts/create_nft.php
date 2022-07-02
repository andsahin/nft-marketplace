<div class="profile-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="border rounded-5 p-3 p-sm-5">
                <h2 class="fw-bold mb-5">
                    <span><?php echo esc($title); ?></span>
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
                    <?php echo form_open_multipart("", ""); ?>
                    
                       
                        <div class="mb-4">
                            <label for="nft-title" class="form-label fw-semi-bold text-black mb-1"><?php echo display('NFT_Title'); ?></label>
                            <input type="text" name="item_name" class="form-control" id="item_name" placeholder="<?php echo display('NFT_Title'); ?>" required="required">
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semi-bold text-black mb-1"><?php echo display('NFT_Description'); ?></label>
                             
                            <textarea class="form-control" name="description" id="description" rows="5" placeholder="<?php echo display('Write_your_item_description'); ?>"></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2 align-items-center">
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
                            <div id="form-placeholder"></div>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label fw-semi-bold text-black mb-1"><?php echo display('NFT_Collection'); ?></label>
                            <p class="fw-medium small mb-1"> 
                            </p>
                         
                            <?php  
                            $att = ["class"=>"form-control", "id"=>"collections", "required"=>"required"]; 
                            $op = array();
                            foreach ($collections as $key => $colVal) {
                                $op[$colVal->id] = esc($colVal->title);  
                            }
                            echo form_dropdown('collection', $op, '', $att)
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
                            </label>
                            
                            <div class="profile-pic-wrapper upload-file">
                                <div class="pic-holder pic-holder-banner">
                                    <!-- uploaded pic shown here -->
                                    <img id="profilePic" class="pic" src="<?php echo esc($frontendAssets); ?>/img/placeholder.png">

                                    <input class="uploadProfileInput" type="file" name="nft_file" id="nft_file"/>

                                    <label for="nft_file" class="upload-file-block">
                                        <div class="text-center">
                                            <div class="mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-camera">
                                                    <path
                                                        d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z">
                                                    </path>
                                                    <circle cx="12" cy="13" r="4"></circle>
                                                </svg>
                                            </div> 
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <p class="fw-medium small mt-1 small mb-3"><?php echo display('support_file'); ?></p> 
                        </div>
                         
                        <p class="fw-medium small mb-1"><span class="text-primary"><?php echo display('Note'); ?>: </span><?php echo display('gas_deducted'); ?>
                            </p>
                        <button type="submit" class="btn btn-dark w-100 btn-profile mt-4"><?php echo display('Create_your_NFT'); ?></button>
                    
                    <?php echo form_close(); ?>
               </div>
            </div>
        </div>
    </div>
</div>
 