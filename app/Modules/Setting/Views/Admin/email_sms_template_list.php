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
                            <a href="#" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr> 
                                <th><?php echo display('sl_no') ?></th>
                                <th><?php echo display('Type'); ?></th>
                                <th><?php echo display('Template_name'); ?></th>
                                <th><?php echo display('Template_EN_subject'); ?></th> 
                                <th><?php echo display('Template_EN'); ?></th>  
                                <th><?php echo display('Action'); ?></th>
                            </tr>
                        </thead>    
                        <tbody>
                            <?php if (!empty($template)) ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($template as $value) { ?>
                            <tr>
                                <td><?php echo esc($sl++); ?></td> 
                                <td><?php echo esc($value->sms_or_email); ?></td>
                                <td><?php echo esc($value->template_name); ?></td>
                                <td><?php echo esc($value->subject_en); ?></td> 
                                <td><?php echo esc($value->template_en); ?></td> 
                                <td>
                                    <a href="<?php echo base_url("backend/setting/smsemail_templateform/$value->id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            <?php } ?>  
                        </tbody>
                    </table>
                </div>
                <?php echo htmlspecialchars_decode($pager) ?>
            </div> 
        </div>
    </div>
</div>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/jszip.min.js"></script>

<script src="<?php echo base_url()?>/public/assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.colVis.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/data-bootstrap4.active.js"></script>