<?php $uri = service('uri','<?php echo base_url(); ?>');?>

<div class="row d-flex justify-content-around">  
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display('NFT_Selling_Type'); ?></h6>
                    </div>
                    <div class="text-right">
                        <div class="actions">
                             
                        </div>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display table-bordered table-striped table-hover text-center">
                        <tr>
                            <th><?php echo display('Id'); ?></th>
                            <th><?php echo display('Type'); ?></th>
                            <th><?php echo display('Status'); ?></th> 
                        </tr>
                        <?php 
                        if($selling_types){ 
                            foreach ($selling_types as $key => $value) { 
                        ?>
                        <tr> 
                            <td><?php echo esc($value->type_id); ?></td>
                            <td><?php echo esc($value->type); ?></td>
                            <td>
                                <?php 
                                if($value->status == 1){
                                    echo "<div class='typestatus_".$value->type_id."'><span class='btn btn-success btn-md' onclick='selling_typestatus(".$value->type_id.", ".$value->status.")'>Active <i class='fas fa-angle-down'></i></span></div>";
                                }else{
                                    echo "<div class='typestatus_".$value->type_id."'><span class='btn btn-warning btn-md' onclick='selling_typestatus(".$value->type_id.", ".$value->status.")'>Deactive <i class='fas fa-angle-down'></i></span></div>";
                                }
                                ?>
                                    
                            </td> 
                        </tr>
                        
                        <?php
                        } 

                        }else{
                            echo "<span>".display('Not Found')."</span>";
                        } ?> 
                    </table>  
                </div>
                 
            </div>
        </div>

    </div>
</div> 
<script src="<?php echo base_url("app/Modules/Nfts/Assets/Admin/js/custom.js") ?>"></script>
 
 
 