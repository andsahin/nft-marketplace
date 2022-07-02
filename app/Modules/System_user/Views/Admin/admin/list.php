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
                            <a href=" " class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table  table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th ><?php echo display('sl_no') ?></th>
                                <th><?php echo display('image') ?></th>
                                <th><?php echo display('fullname') ?></th>
                                <th><?php echo display('last_login') ?></th>
                                <th><?php echo display('last_logout') ?></th>
                                <th><?php echo display('ip_address') ?></th>
                                <th><?php echo display('status') ?></th>
                                <th><?php echo display('action') ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($admin)) ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($admin as $value) { ?>
                            <tr>
                                <td><?php echo esc($sl++); ?></td>
                                <td><img src="<?php echo base_url(!empty($value->image)?$value->image:'public/assets/images/icons/user.png'); ?>" alt="Image" height="64" ></td>
                                <td><?php echo esc($value->fullname); ?></td>
                                <td><?php echo esc($value->last_login); ?></td>
                                <td><?php echo esc($value->last_logout); ?></td>
                                <td><?php echo esc($value->ip_address); ?></td>
                                <td><?php echo ((esc($value->status==1))?display('active'):display('inactive')); ?></td>
                                <td>
                                    <?php if (esc($value->is_admin) == 1) { ?>
                                    <button class="btn btn-info btn-sm" title="<?php echo display('admin') ?>"><?php echo display('admin') ?></button>
                                    <?php } else { ?> 
                                    <button class="btn btn-info btn-sm" title="<?php echo display('sub_admin') ?>"><?php echo display('sub_admin') ?></button> <br><br>
                                    <a href="<?php echo base_url("backend/account/admin_information/$value->id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                    <a href="<?php echo base_url("backend/admin/delete/$value->id") ?>" onclick="return confirm('<?php echo display("are_you_sure") ?>')" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="right" title="Delete "><i class="far fa-trash-alt" aria-hidden="true"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?> 
                        </tbody>
                    </table>
                </div>
                    <?php echo htmlspecialchars_decode($pager); ?>
                </div>
        </div>
    </div>
</div>

 