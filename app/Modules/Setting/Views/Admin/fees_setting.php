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
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="panel-body">
                    <div class="border_preview">
                    <?php 
                    echo form_open_multipart(base_url("backend/setting/fees_setting_save")) ?>
 
                        <div class="row"> 
                            <div class="form-group col-lg-4">
                                <label><?php echo display("select_level") ?> *</label>
                              
                                
                               <?php  
                               $att = ['class'=>'form-control', 'id'=>'fees_level'];
                               
                               $op = ['sale'=> 'Sale', 'transfer'=>'Transfer'];

                               echo form_dropdown('level', $op, set_value('level'), $att);
                               ?>

                            </div>

                            <div class="form-group col-lg-4">
                                <label><?php echo display('Fees'); ?> <span id="fees_system">%</span> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="fees" required >
                            </div> 
                        </div> 

                        <div>
                            <button type="submit" class="btn btn-success"><?php echo display("save") ?></button>
                        </div>
                         <?php echo form_close() ?>
                     </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?$title:null) ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="table-responsive">
                    <p class="text-success"><?php echo display('fees_msg'); ?> </p>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th><?php echo display('Level');?></th>
                                <th><?php echo display('fees');?></th>
                                <th><?php echo display('action');?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if(isset($fees_data)){ 
                                foreach ($fees_data as $key => $value) {  
                            ?>
                            <tr>
                                <td><?php echo esc($value->level);?></td>
                                <td class="text-right"><?php echo esc($value->fees);?> <?php echo ($value->level == 'transfer') ? SYMBOL : '% '.SYMBOL ?> </td>
                                <td>
                                    <a href="<?php echo base_url('backend/setting/delete_fees_setting/'.$value->id) ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url("app/Modules/Setting/Assets/Admin/js/custom.js?v=1.1") ?>" type="text/javascript"></script>

 