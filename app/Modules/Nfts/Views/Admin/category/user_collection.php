<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?esc($title):null) ?></h6> 
                    </div>
                   
                     <a class="btn btn-info float-right" href="<?php echo base_url('backend/nft/add_collection'); ?>"><?php echo display('Create_New_Collection'); ?></a> 
                </div>
            </div>          
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th ><?php echo display('sl_no') ?></th>
                                <th><?php echo display('Logo') ?></th>
                                <th><?php echo display('Collection_name' )?></th>
                                <th><?php echo display('Description') ?></th> 
                                <th><?php echo display('User_Name') ?></th>  
                                <th class="text-center"><?php echo display('action') ?></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($collections)) ?>
                            <?php $sl = 1; ?>
                            <?php foreach ($collections as $value) { ?>
                            <tr>
                                <td><?php echo esc($sl++); ?></td> 
                                <td width="200"> <img width="100" class="rounded img-thumbnail" src="<?php if($value->logo_image){echo base_url().$value->logo_image; }else{echo base_url('/public/uploads/no.png'); } ?>"> </td>
                                <td><?php echo esc($value->title); ?></td>
                                <td><?php echo esc($value->description); ?></td> 
                                <td><?php echo esc($value->f_name).' '.esc($value->l_name); ?></td> 
                                <td class="text-center">
                                    <a title="Update" class="btn btn-info btn-sm" href="<?php echo base_url('backend/nft/update_collection/'.$value->id); ?>"><i class="fas fa-edit"></i></a>   
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

 