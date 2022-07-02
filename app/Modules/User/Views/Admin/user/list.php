<?php $security = \Config\Services::security();
helper('form');
?>

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
                            <a href="#" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                
                <?php echo form_open('#',array('id'=>'ajaxusertableform','name'=>'ajaxusertableform')); ?>

                <div class="table-responsive">
                    <table id="ajaxtable" class="table  table-bordered table-striped table-hover">
                       <thead>
                            <tr> 
                                <th><?php echo display('sl_no') ?></th> 
                                <th><?php echo display('fullname') ?></th>
                                <th><?php echo display('username') ?></th>
                                <th><?php echo display('email') ?></th> 
                                <th width="320px"><?php echo display('Wallet_address') ?></th> 
                                <th><?php echo display('action') ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                             
                        </tbody>
                      
                    </table> 
                </div>
                <?php echo form_close(); ?>
            </div> 
        </div>
    </div>
</div>

<script src="<?php echo base_url("public/assets/plugins/datatables/dataTables.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/dataTables.bootstrap4.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/dataTables.responsive.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/responsive.bootstrap4.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/dataTables.buttons.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/buttons.bootstrap4.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/jszip.min.js") ?>"></script>

<script src="<?php echo base_url("public/assets/plugins/datatables/pdfmake.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/vfs_fonts.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/buttons.html5.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/buttons.print.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/buttons.colVis.min.js") ?>"></script>
<script src="<?php echo base_url("public/assets/plugins/datatables/data-bootstrap4.active.js") ?>"></script>
<script src="<?php echo base_url("app/Modules/User/Assets/Admin/js/custom.js") ?>"></script>