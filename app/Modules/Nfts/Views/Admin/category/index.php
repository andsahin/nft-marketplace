<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?esc($title):null) ?></h6> 
                    </div>
                     
                    <a class="btn btn-info float-right" href="<?php echo base_url('backend/nft/add_category'); ?>"><?php echo display('Create_New_Category'); ?></a> 
                </div>
            </div>            
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table  table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th ><?php echo display('sl_no'); ?></th>
                                <th ><?php echo display('Logo'); ?></th>
                                <th><?php echo display('Category_name'); ?></th>
                                <th><?php echo display('Description'); ?></th> 
                                <th><?php echo display('status'); ?></th>
                                <th class="text-center"><?php echo display('action'); ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($categories)) ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($categories as $value) { ?>
                            <tr>
                                <td><?php echo esc($sl++); ?></td> 
                                <td width="200"><img width="100" class="rounded img-thumbnail" src="<?php if($value->logo){echo base_url().$value->logo; }else{echo base_url('/public/uploads/no.png'); } ?>"> </td>
                                <td><?php echo esc($value->cat_name); ?></td>
                                <td><?php echo esc($value->description); ?></td> 
                                <td><?php echo ((esc($value->status==1))?display('active'):display('inactive')); ?></td>
                                <td class="text-center"> 
                                    <a href="<?php echo base_url("backend/nft/update_category/$value->id") ?>" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Update"><i class="fas fa-edit" aria-hidden="true"></i></a>
                                    <a href="<?php echo base_url("backend/nft/delete/$value->id"); ?>" onclick="return confirm('Are you sure you want to delete this item?');" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            <?php } ?> 
                        </tbody>
                    </table>
                </div>
                    <?php  
                    echo htmlspecialchars_decode($pager); 
                    ?>
                </div>
        </div>
    </div>
</div>

 