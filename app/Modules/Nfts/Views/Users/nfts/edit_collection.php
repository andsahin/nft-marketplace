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
                    <?php echo form_open_multipart(); ?>
                   
                        <div class="mb-4"> 
                            <div class="align-items-start profile-pic-wrapper">
                                <div class="pic-holder">
                                    <!-- uploaded pic shown here -->
                                    <?php if($info->logo_image){
                                        echo '<img id="profilePic" class="pic" src="'.base_url().esc($info->logo_image).'">';
                                    }else{ 
                                        echo '<img id="profilePic" class="pic" src="'.$frontendAssets.'/img/placeholder.png">';
                                    }?>
                                    <input class="uploadProfileInput" type="file" name="profile_img" id="profileBanner" accept="image/*" />

                                    <label for="profileBanner" class="upload-file-block">
                                        <div class="text-center">
                                            <div class="mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
                            <p class="fw-medium small mb-3"><?php echo display('Collection_logo_recommended'); ?></p>
                        </div>
                        

                        <div class="mb-4">
                            <label for="col_name" class="form-label fw-semi-bold text-black mb-1"><?php echo display('Collection_Title'); ?> <span class="text-danger">*</span></label>

                            <input name="col_name" value="<?php echo esc($info->title); ?>" type="text" class="form-control" id="collectionName" placeholder="<?php echo display('Collection_Title'); ?>" required="required">
                            <span class="collection-name-check"></span>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label fw-semi-bold text-black mb-1"><?php echo display('Collection_URL'); ?></label> 

                            <div class="input-group-form">
                                <span class="input-group-form__text"><?php echo base_url('collection').'/'; ?></span>
                                <input name="slug" value="<?php echo esc($info->slug); ?>" type="text" class="form-control" id="collectionSlug" placeholder="">

                            </div>
                            <span class="collection-slug-check"></span>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlTextarea1" class="form-label fw-semi-bold text-black mb-1"><?php echo display('Collection_Description'); ?></label> 

                            <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="5" placeholder="<?php echo display('Write_your_collection_description'); ?>"><?php echo esc($info->description); ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label fw-semi-bold text-black mb-1"><?php echo display('Collection_Category'); ?> <span class="text-danger">*</span></label>
                             
                            <?php 
                            $attr  = [
                                'class' => 'form-select',
                                'id' => 'category', 
                                'required' => 'required', 
                            ];
                            $op[''] = display('Select_Category');
                            if(isset($categories)){
                                foreach ($categories as $key => $category) {
                                    $op[$category->id] = esc($category->cat_name);
                                }
                            }
                            
                            echo form_dropdown('category', $op, set_value('category', esc($info->category_id)), $attr); 
                            ?>
                        </div>

                        <div class="mb-4">
                            <label for="exampleFormControlInput1" class="form-label fw-semi-bold text-black mb-1"><?php echo display('Blockchain_Network'); ?></label>
                            <?php 
                            $attr2  = [
                                'class' => 'form-select',
                                'id' => 'category', 
                                'disabled' => 'disabled', 
                            ]; 
                             $op2 = [];
                            if(isset($blockchain)){
                               $op2[$blockchain->id] = esc($blockchain->network_name); 
                            } 
                             
                             
                            echo form_dropdown('blockchain', $op2, set_value('blockchain',1), $attr2); 
                            ?>
                        </div>

                        <div class="mb-4"> 
                            <div class="align-items-start profile-pic-wrapper">
                                <div class="pic-holder banner-pic">
                                    <!-- uploaded pic shown here -->
                                     <?php if($info->banner_image){
                                        echo '<img id="profilePic" class="pic" src="'.base_url().esc($info->banner_image).'">';
                                    }else{ 
                                        echo '<img id="profilePic" class="pic" src="'.$frontendAssets.'/img/placeholder.png">';
                                    }?>
                                     
                                    <input class="uploadProfileInput" type="file" name="banner_img" id="profileBanner2" accept="image/*" /> 
                                    <label for="profileBanner2" class="upload-file-block">
                                        <div class="text-center">
                                            <div class="mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
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
                             <p class="fw-medium small mb-3"><?php echo display('Collection_banner_recommended'); ?></p>
                        </div> 
                        <button type="submit" class="btn btn-dark w-100 btn-profile mt-4"><?php echo display('update'); ?></button> 
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>