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
                <div class="row">
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <?php echo form_open_multipart(base_url("backend/setting/smsemail_templateform/$template->id")) ?>
                <?php echo form_hidden('id', esc($template->id)) ?>
                    <div class="form-group row">
                        <label for="headline_en" class="col-sm-3 col-form-label">Type</label>
                        <div class="col-sm-9">
                            <h2 class="text-capitalize"><?php echo htmlspecialchars($template->sms_or_email) ?></h2>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="headline_en" class="col-sm-3 col-form-label"><?php echo display('Template_name'); ?></label>
                        <div class="col-sm-9">
                            <h2 class="text-capitalize"><?php echo htmlspecialchars($template->template_name) ?></h2>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="subject_en" class="col-sm-3 col-form-label"><?php echo display('Template_Subject'); ?><i class="text-danger">*</i></label>
                        <div class="col-sm-9 ">
                            <input name="subject_en" value="<?php echo htmlspecialchars($template->subject_en) ?>" class="form-control" placeholder="" type="text" id="subject_en">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="template_en" class="col-sm-3 col-form-label"><?php echo display('Template'); ?> <i class="text-danger">*</i></label>
                        <div class="col-sm-9">
                            <textarea name="template_en" class="form-control editor" placeholder="" type="text" id="template_en"><?php echo htmlspecialchars($template->template_en) ?></textarea>
                        </div>
                    </div>
                    
                    <div class="row" align="center">
                        <div class="col-sm-12 col-sm-offset-3">
                            <a href="<?php echo base_url('backend/setting/smsemail_template'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                            <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo esc($template->id) ? display("update"):display("create") ?></button>
                        </div>
                    </div>
                <?php echo form_close() ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 col-md-offset-1">
                    <div class="form-group row">
                        <p><?php echo display('Use_these_text_on_message_template_where_you_want_to_use_this_type_of_data_in_your_message'); ?>.</p>
                        <ul>
                            <li>%fullname%</li>
                            <li>%amount%</li>
                            <li>%balance%</li>
                            <li>%new_balance%</li>
                            <li>%receiver_id%</li>
                            <li>%user_id%</li>
                            <li>%stage%</li>
                            <li>%date%</li>
                            <li>%verify_code%</li>
                        </ul>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>