<link href="<?php echo base_url("public/assets/plugins/Semantic/semantic.min.css") ?>" rel="stylesheet">
<link href="<?php echo base_url("app/Modules/Setting/Assets/Admin/css/custom.css?v=1.1") ?>" rel="stylesheet" type="text/css" />
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
                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="border_preview">
                        <?php echo form_open_multipart(base_url('backend/setting/app_setting'),'class="form-inner"') ?>
                            <?php echo form_hidden('setting_id',esc($setting->setting_id)) ?>

                            <div class="form-group row">
                                <label for="title" class="col-sm-3 col-form-label"><?php echo display('application_title') ?> <i class="text-danger">*</i></label>
                                <div class="col-sm-9">
                                    <input name="title" type="text" class="form-control" id="title" placeholder="<?php echo display('application_title') ?>" value="<?php echo esc($setting->title) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-sm-3 col-form-label"><?php echo display('address') ?></label>
                                <div class="col-sm-9">
                                    <input name="description" type="text" class="form-control" id="description" placeholder="<?php echo display('address') ?>"  value="<?php echo htmlspecialchars_decode($setting->description) ?>">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label"><?php echo display('email')?></label>
                                <div class="col-sm-9">
                                    <input name="email" type="text" class="form-control" id="email" placeholder="<?php echo display('email')?>"  value="<?php echo esc($setting->email) ?>">
                                </div>
                            </div>
 
                            <div class="form-group row">
                                <label for="phone" class="col-sm-3 col-form-label"><?php echo display('phone') ?></label>
                                <div class="col-sm-9">
                                    <input name="phone" type="text" class="form-control" id="phone" placeholder="<?php echo display('phone') ?>"  value="<?php echo esc($setting->phone) ?>" >
                                </div>
                            </div>
                             
                            <?php if(!empty($setting->favicon)) {  ?>
                            <div class="form-group row">
                                <label for="faviconPreview" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <img src="<?php echo base_url(esc($setting->favicon)) ?>" alt="Favicon" class="img-thumbnail" />
                                </div>
                            </div>
                            <?php } ?>

                            <div class="form-group row">
                                <label for="favicon" class="col-sm-3 col-form-label"><?php echo display('favicon') ?> </label>
                                <div class="col-sm-9">
                                    <input type="file" name="favicon" id="favicon">
                                    <input type="hidden" name="old_favicon" value="<?php echo esc($setting->favicon) ?>">
                                   <div class="text-danger">32x32 px(jpg, jpeg, png, gif, ico)</div>
                                </div>
                            </div>


                          
                            <?php if(!empty($setting->logo)) {  ?>
                            <div class="form-group row">
                                <label for="logoPreview" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <img src="<?php echo base_url(esc($setting->logo)) ?>" alt="Picture" class="img-thumbnail" />
                                </div>
                            </div>
                            <?php } ?>

                            <div class="form-group row">
                                <label for="logo" class="col-sm-3 col-form-label"><?php echo display('dashboard_logo') ?></label>
                                <div class="col-sm-9">
                                    <input type="file" name="logo" id="logo">
                                    <input type="hidden" name="old_logo" value="<?php echo esc($setting->logo) ?>">
                                    <div class="text-danger">184x42 px(jpg, jpeg, png, gif, ico)</div>
                                </div>
                            </div>


                            
                            <?php if(!empty($setting->logo_web)) {  ?>
                            <div class="form-group row">
                                <label for="logoPreview" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <img src="<?php echo base_url(esc($setting->logo_web)) ?>" alt="Picture" class="img-thumbnail" />
                                </div>
                            </div>
                            <?php } ?>

                            <div class="form-group row">
                                <label for="logo_web" class="col-sm-3 col-form-label"><?php echo display('logo_web') ?></label>
                                <div class="col-sm-9">
                                    <input type="file" name="logo_web" id="logo_web">
                                    <input type="hidden" name="old_web_logo" value="<?php echo esc($setting->logo_web) ?>">
                                    <div class="text-danger">163x50 px(jpg, jpeg, png, gif, ico)</div>
                                </div>
                            </div>

                            <?php if(!empty($setting->header_bg_img)) {  ?>
                            <div class="form-group row">
                                <label for="logoPreview" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <img width="200px" src="<?php echo base_url(esc($setting->header_bg_img)) ?>" alt="Picture" class="img-thumbnail" />
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group row">
                                <label for="header_bg_img" class="col-sm-3 col-form-label"><?php echo display('Header_Background_Img') ?></label>
                                <div class="col-sm-9">
                                    <input type="file" name="header_bg_img" id="header_bg_img">
                                    <input type="hidden" name="old_header_bg_img" value="<?php echo esc($setting->header_bg_img) ?>">
                                    <div class="text-danger">1968x462 px (jpg, png)</div>
                                </div>
                            </div>

                            <?php if(!empty($setting->footer_bg_img)) {  ?>
                            <div class="form-group row">
                                <label for="logoPreview" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <img width="200px" src="<?php echo base_url(esc($setting->footer_bg_img)) ?>" alt="Picture" class="img-thumbnail" />
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group row">
                                <label for="footer_bg_img" class="col-sm-3 col-form-label"><?php echo display('Footer_Background_Img') ?></label>
                                <div class="col-sm-9">
                                    <input type="file" name="footer_bg_img" id="footer_bg_img">
                                    <input type="hidden" name="old_footer_bg_img" value="<?php echo esc($setting->footer_bg_img) ?>">
                                    <div class="text-danger">1920x900 px (jpg, png)</div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="footer_text" class="col-sm-3 col-form-label"><?php echo display('language') ?></label>
                                <div class="col-sm-9">
                                    <?php echo  form_dropdown('language',esc($languageList),esc($setting->language), 'class="form-control"') ?>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="time_zone" class="col-sm-3 col-form-label"><?php echo display('time_zone') ?>  <i class="text-danger">*</i></label>
                                <div class="col-sm-9">
                                    <select id="time_zone" name="time_zone" class="form-control">
                                        <option value=""><?php echo display('select_option') ?></option>
                                        <?php foreach (timezone_identifiers_list() as $value) { ?>
                                            <option value="<?php echo esc($value) ?>" <?php echo (($setting->time_zone==$value)?'selected':null) ?>><?php echo esc($value) ?></option>";
                                        <?php } ?>
                                    </select>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="left_to_right" class="col-sm-3 col-form-label"><?php echo display('admin_align') ?></label>
                                <div class="col-sm-9">
                                    <?php echo  form_dropdown('site_align', array('LTR' => display('left_to_right'), 'RTL' => display('right_to_left')) ,esc($setting->site_align), 'class="form-control"') ?>
                                </div>
                            </div> 

                            <div class="form-group row">
                                <label for="office_time" class="col-sm-3 col-form-label"><?php echo display('office_time') ?></label>
                                <div class="col-sm-9">
                                    <textarea name="office_time" class="form-control"  placeholder="<?php echo display('office_time') ?>" maxlength="255" rows="7"><?php echo esc($setting->office_time) ?></textarea>
                                </div>
                            </div>  

                            <div class="form-group row">
                                <label for="latitude" class="col-sm-3 col-form-label"><?php echo display('latitudelongitude') ?></label>
                                <div class="col-sm-9">
                                    <input name="latitude" type="text" class="form-control" id="latitude" placeholder="<?php echo display('latitudelongitude') ?>"  value="<?php echo esc($setting->latitude) ?>" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="footer_text" class="col-sm-3 col-form-label"><?php echo display('footer_text') ?></label>
                                <div class="col-sm-9">
                                    <textarea name="footer_text" class="form-control"  placeholder="Footer Text" maxlength="140" rows="7"><?php echo esc($setting->footer_text) ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row" align="center">
                                <div class="col-sm-offset-3 col-sm-12">
                                    <div class="ui buttons">
                                        <button type="reset" class="ui button"><?php echo display('reset') ?></button>
                                        <div class="or"></div>
                                        <button class="ui positive button"><?php echo display('save') ?></button>
                                    </div>
                                </div>
                            </div>
                        <?php echo form_close() ?>

                        <div class="settingWrapper">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                <label class="col-form-label "><?php echo display('For_Daily_Auction_Close'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="copyed1" value="curl --request GET <?php echo base_url('nft/today_auction_close');?>" readonly>
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary copy1" type="button"><?php echo display('Copy'); ?></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-form-label col-sm-6">
                                    <label class="col-form-label "><?php echo display('For_Token_Id_Update'); ?></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="copyed2" value="curl --request GET <?php echo base_url("get_token_info"); ?>" readonly>
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary copy2" type="button"><?php echo display('Copy'); ?></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php echo display('cornjob_msg'); ?>
                        </div>

                    </div>
                    <div class="col-md-3"></div>
                 </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url("app/Modules/Setting/Assets/Admin/js/custom.js?v=1.1") ?>" type="text/javascript"></script>