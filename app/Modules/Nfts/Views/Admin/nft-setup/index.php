<?php $uri = service('uri','<?php echo base_url(); ?>');?>
  
<div class="row">
    <div class="col-md-6 col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display('Blockchain_Networks'); ?></h6>
                        <small><?php echo display('Only_Binance_Smart_Chain'); ?></small>
                    </div>
                    <div class="text-right">
                        <?php if (empty($networks)){ ?> 
                        <div class="actions">
                            <a class="btn btn-success btn-sm" href="<?php echo base_url('backend/nft/add_network'); ?>"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php echo display('Add_Network'); ?></a> 
                        </div>
                        <?php }else{ ?>
                        <div class="actions">
                            <a class="btn btn-success btn-sm" href="<?php echo base_url('backend/nft/update_network/'.$networks[0]->id); ?>"><i class="far fa-edit"></i> <?php echo display('update'); ?></a> 
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display table-bordered table-striped table-hover">
                        <?php if (!empty($networks)){ ?> 
                        <?php foreach ($networks as $value) { ?>
                        <tr>
                            <th><?php echo display('Network_Name'); ?></th>
                            <td><?php echo esc($value->network_name); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo display('Chain_ID'); ?></th>
                            <td><?php echo esc($value->chain_id); ?></td>
                        </tr>
                         <tr>
                            <th><?php echo display('Symbol'); ?></th>
                            <td><?php echo esc($value->currency_symbol); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo display('RPC'); ?></th>
                            <td><?php echo esc($value->rpc_url); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo display('Block_Explorer_URL'); ?></th>
                            <td><?php echo esc($value->explore_url); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo display('Server_IP'); ?></th>
                            <td><?php echo esc($value->server_ip); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo display('Port'); ?></th>
                            <td><?php echo esc($value->port); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo display('Status'); ?></th>
                            <td><?php echo (($value->status==1)?display('active'):display('inactive')); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                
                            </td> 
                        </tr>  
                        <?php 
                        } 
                    }else{
                       echo "<span class='text-danger'>".display('Not found')." </span>"; 
                   }  
                    ?>
                    </table>  
                </div>
                 
            </div>
        </div>

    </div>
    <div class="col-md-6 col-lg-6">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display('Admin_Wallet'); ?></h6>
                    </div>
                    <div class="text-right">
                        <?php if (empty($wallets)){ ?>
                        <div class="actions">
                            <a class="btn btn-success btn-sm" href="<?php echo base_url('backend/nft/wallet_import'); ?>"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php echo display('Import_Wallet'); ?></a> 
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display table-bordered table-striped table-hover">
                        <?php if (!empty($wallets)){ ?> 
                        <?php foreach ($wallets as $value) { ?>
                        <tr>
                            <th><?php echo display('Wallet_Address'); ?></th>
                            <td><?php echo esc($value->wallet_address); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo display('Balance'); ?> </th>
                            <td><span id="balance_<?php echo esc($value->awid); ?>"><?php echo number_format(esc($value->balance), 3,'.',','); ?> </span><?php echo ' '.SYMBOL; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo display('Status'); ?></th>
                            <td><?php echo (($value->status==1)?display('active'):display('inactive')); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <a href="javascript:;" onclick="reloadFunction('<?php echo esc($value->awid); ?>')" class="btn btn-success btn-sm" id="reload_<?php echo esc($value->awid); ?>" data-toggle="tooltip" data-placement="left" title="Update"><i class="fa fa-cog" aria-hidden="true"></i> <?php echo display('Reload_Balance'); ?></a>  
                            </td> 
                        </tr>  
                        <?php }

                         }else{
                            echo "<span class='text-danger'>".display('Not_found')."</span>";
                         } ?>
                    </table>  
                </div>
            </div>
        </div> 
    </div> 
</div> 
<script src="<?php echo base_url("app/Modules/Nfts/Assets/Admin/js/custom.js") ?>"></script>


 
 