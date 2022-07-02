<?php $uri = service('uri','<?php echo base_url(); ?>');?>
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
                   
                <table id="example" class="table display table-bordered table-striped table-hover">
                    <thead>
                        <tr> 
                            <th><?php echo display('sl_no') ?></th>
                            <th><?php echo display('name') ?></th>
                            <th><?php echo display('status') ?></th>
                            <th><?php echo display('action') ?></th>
                        </tr>
                    </thead>    
                    <tbody>
                        <?php if (!empty($apis)) ?>
                        <?php $sl = 1; ?>
                        <?php foreach ($apis as $value) { ?>
                        <tr>
                            <td><?php echo esc($sl++); ?></td> 
                            <td><?php echo esc($value->name); ?></td>
                            <td><?php echo (($value->status==1)?display('active'):display('inactive')); ?></td>
                            <td>
                                <a href="<?php echo base_url("backend/externalapi/external_api_setup/$value->id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo display('Setup'); ?></a>
                            </td>
                        </tr>
                        <?php } ?>  
                    </tbody>
                </table>
                <?php echo htmlspecialchars_decode($pager) ?>
            </div> 
        </div>
    </div>
</div>