<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?esc($title):null) ?></h6>
                </div>
            </div>
        </div>            
        <div class="card-body">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="border_preview">
            <?php echo form_open_multipart('#', 'id="homeform"'); ?>
            <?php echo form_hidden('article_id', esc($article->article_id)) ?> 
                <div class="form-group row">
                    <label for="headline_en" class="col-sm-2 col-form-label"><?php echo display('HeadLine'); ?></label>
                    <div class="col-sm-10">
                        <input name="headline_en" value="<?php echo htmlspecialchars($article->headline_en) ?>" class="form-control" placeholder="<?php echo display('headline_en') ?>" type="text" id="headline_en">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="article1_en" class="col-sm-2 col-form-label"><?php echo display('Title'); ?></label>
                    <div class="col-sm-10">
                        <textarea name="article1_en" class="form-control editor" rows="5" placeholder="" type="text" id="article1_en"><?php echo htmlspecialchars($article->article1_en) ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="article2_en" class="col-sm-2 col-form-label"><?php echo display('Sub_Title'); ?></label>
                    <div class="col-sm-10">
                        <textarea id="article2_en" name="article2_en" class="form-control editor"  rows="5" placeholder="" type="text" id="article2_en"><?php echo htmlspecialchars($article->article2_en) ?></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="article_image" class="col-sm-2 col-form-label"><?php echo display('Banner_Background'); ?></label>
                    <div class="col-sm-10">
                        <input name="article_image" class="form-control" type="file" id="article_image">
                         <input type="hidden" name="article_image_old" value="<?php echo esc($article->article_image); ?>">
                         <?php if(!empty($article->article_image)) { ?>
                            <img src="<?php echo base_url().$article->article_image ?>" width="150">
                         <?php } ?>
                            <div class="text-danger">1349x896 px(jpg, jpeg, png)</div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-sm-12 col-sm-offset-3" align="center">
                        <button type="button" class="btn btn-primary w-md m-b-5" data-dismiss="modal"><?php echo display("close") ?></button>
                        <button type="submit" class="btn btn-success w-md m-b-5"><?php echo esc($article->article_id) ? display("update"):display("create") ?></button>
                    </div>
                </div>
            <?php echo form_close() ?>
            </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url("app/Modules/CMS/Assets/Admin/js/modalcms.js?v=13") ?>"></script>

 

