<?php $uri = service('uri','<?php echo base_url(); ?>');?>
<div class="row d-flex justify-content-around"> 

    <div class="card col-lg-8">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?$title:null) ?></h6>
                </div>  
            </div>
        </div> 
        <div class="card-body"> 
            <div class="text-center mb-4">
                <img width="300px" height="300px" class="rounded" src="<?php echo base_url().esc($info->file); ?>">
            </div>
            <div class="table-responsive">
                <table class="table display table-bordered table-striped table-hover">
                    <?php 
                    if (!empty($info)){ ?>  
                    <tr>  
                        <th><?php echo display('Name'); ?> :</th>
                        <td> <?php echo esc($info->name); ?></td>
                    </tr>
                    <tr>  
                        <th><?php echo display('Category_name'); ?> :</th>
                        <td> <?php echo esc($info->cat_name); ?></td>
                    </tr>
                    <tr>  
                        <th><?php echo display('Collection_name'); ?> :</th>
                        <td> <?php echo esc($info->collection_title); ?></td>
                    </tr>
                    <tr>  
                        <th><?php echo display('Owner_name'); ?> :</th>
                        <td> <?php echo esc($info->f_name.' '.$info->l_name); ?></td>
                    </tr>
                    <tr>  
                        <th><?php echo display('Description'); ?> :</th>
                        <td> <?php echo esc($info->description); ?></td>
                    </tr>
                   
                    <tr>  
                        <th><?php echo display('Properties'); ?> :</th>
                        <td> <?php echo esc($info->properties); ?></td>
                    </tr>

                    <tr>  
                        <th><?php echo display('Token_standard'); ?> :</th>
                        <td> <?php echo esc($info->token_standard); ?></td>
                    </tr>

                    <tr>  
                        <th><?php echo display('Status'); ?> :</th>
                        <td> 
                            <?php   
                            $val =''; 
                            if($info->status == 0){

                              $val = '<div class="nftHtmlData_'.$info->id.'"><span class="btn btn-warning btn-md update-class_'.$info->id.' nftstatus_'.$info->id.'" id="detail_change_status" infoid="'.$info->id.'" infostatus="'.$info->status.'">'.display("Pending").' <i class="fas fa-angle-down" ></i></span></div>';

                            }else if($info->status == 1){

                              $val = '<div class="nftHtmlData_'.$info->id.'"><span class="btn btn-success btn-md update-class_'.$info->id.' nftstatus_'.$info->id.'" id="detail_change_status" infoid="'.$info->id.'" infostatus="'.$info->status.'">'.display("Active").' <i class="fas fa-angle-down"></i></span></div>';

                            }else if($info->status == 2){

                              $val = '<div class="nftHtmlData_'.$info->id.'"><span class="btn btn-danger btn-md update-class_'.$info->id.' nftstatus_'.$info->id.'" id="detail_change_status" infoid="'.$info->id.'" infostatus="'.$info->status.'">'.display("Suspend").' <i class="fas fa-angle-down"></i></span>';
                            }else{

                                $val = '<span class="btn btn-info">'.display("On sell").'</span></div>';
                            }
                            echo esc($val).' '.esc($info->suspend_msg);
                            ?>
                           
                        </td>
                    </tr>
                   
                    <tr class="suspend-msg-input d-none">  
                        <th><?php echo display('Suspend_message'); ?> :</th>
                        <td>
                            <?php echo form_open('backend/nft/changestatus/'.$info->id.'/2', 'class="suspend-form"'); ?>
                            <div>
                                <?php 
                                $data = array(
                                  'name'        => 'suspend_msg',
                                  'id'          => 'suspend_msg',
                                  'value'       => '',
                                  'rows'        => '3',
                                  'cols'        => '30',
                                  'style'       => 'width:80%',
                                );
                                echo form_textarea($data);
                                ?>
                            </div>
                            <div>
                                <input type="submit" name="submit" class="btn btn-info">  
                            </div> 
                            <?php echo form_close(); ?>
                        </td>
                    </tr>
                    <?php 
                    if($info->is_featured == 1){
                        $ckd = "checked";
                    }else{
                        $ckd = "";
                    }
                    ?>
                    <tr>  
                        <th><?php echo display('Is_featured'); ?> :</th>
                        <td> <input type="checkbox" id="is_featured" class="form-check" name="is_featured" value="<?php echo esc($info->id); ?>" <?php echo esc($ckd); ?> > </td>
                    </tr>

                    <tr>  
                        <th><?php echo display('Token_Id'); ?> :</th>
                        <td> <?php echo esc($info->token_id); ?></td>
                    </tr>

                    <tr>  
                        <th><?php echo display('Owner_wallet'); ?> :</th>
                        <td> <?php echo esc($info->owner_wallet); ?></td>
                    </tr>

                    <tr>  
                        <th><?php echo display('Contract_address'); ?> :</th>
                        <td> <?php echo esc($info->contract_address); ?></td>
                    </tr>

                    <tr>  
                        <th><?php echo display('Transcation_hash'); ?>:</th>
                        <td> <a target="_blank" href="<?php echo esc($network->explore_url.'/tx/'.$info->trx_hash); ?>"><?php echo esc($info->trx_hash); ?></a></td>
                    </tr>


                     
                    <?php  

                     }else{
                        echo "<span style='color: red'>".display('Please_set_your_wallet_address')."</span>";
                     } 

                     ?> 
                </table>  
            </div>
        </div> 
    </div>  
</div> 
<script src="<?php echo base_url("app/Modules/Nfts/Assets/Admin/js/custom.js") ?>"></script>