<?php $uri = service('uri','<?php echo base_url(); ?>');?>
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
            <div class="table-responsive">   
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr> 
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('headline_en') ?></th>
                            <th><?php echo display('category') ?></th>
                            <th><?php echo display('action') ?></th> 
                        </tr>
                    </thead>    
                    <tbody>
                        <?php if (!empty($article)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($article as $value) { ?>
                        <tr>
                            <td><?php echo esc($sl++); ?></td> 
                            <td><?php echo esc($value->headline_en); ?></td>
                            <td><?php 
                            $db=  db_connect();
                            $qu=$db->table("web_category");
                            $cat_name_en = $qu->select("cat_name_en")
                                    ->where('cat_id', $value->cat_id)
                                    ->get()->getRow()->cat_name_en;
                            echo esc($cat_name_en);
                            ?></td>
                            <td>
                                <button type="button" class="btn btn-success mb-2 mr-1 edit-contact" data-article="<?php echo esc($value->article_id) ?>" data-toggle="modal" data-target=".bd-example-modal-xl"><i class="fas fa-edit" aria-hidden="true"></i></button>
                            </td>
                        </tr>
                        <?php } ?>  
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</div>
<script src="<?php echo base_url("app/Modules/CMS/Assets/Admin/js/modalpopcms.js") ?>"></script>
 