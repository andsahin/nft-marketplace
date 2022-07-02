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
                              <a href="" class="action-item"><i class="ti-reload"></i></a>
                        </div>
                    </div>
                </div>
            </div> 
                      
            <div class="card-body"> 
                <div class="col-lg-12">

                    <div class="border_preview">
                        <div>
                            
                            <p class="text-danger text-center"><?php echo display('Please_get_your_network_information_from'); ?> <a target="_blank" href="https://academy.binance.com/en/articles/connecting-metamask-to-binance-smart-chain"><?php echo display('Binance_academy'); ?></a> <?php echo display('or'); ?> <a target="_blank" href="https://docs.binance.org/smart-chain/developer/rpc.html"><?php echo display('Binance_document'); ?></a> </p>
                            
                        </div>
                    <?php echo form_open_multipart(base_url("backend/nft/add_network")) ?> 
                        <div class="form-group row">
                            <label for="network_name" class="col-sm-3 col-form-label"><?php echo display('Network_Name'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input name="network_name" value="<?php echo set_value('network_name'); ?>" class="form-control" type="text" id="network_name" autocomplete="off" required>
                            </div>  
                        </div> 
                        <div class="form-group row">
                            <label for="chain_id" class="col-sm-3 col-form-label"><?php echo display('Chain_Id'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input name="chain_id" value="<?php echo set_value('chain_id'); ?>" class="form-control" type="text" id="chain_id" autocomplete="off" required>
                            </div>
                            
                        </div> 
                        <div class="form-group row">
                            <label for="currency_symbol" class="col-sm-3 col-form-label"><?php echo display('Currency_Symbol'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input name="currency_symbol" value="<?php echo set_value('currency_symbol'); ?>" class="form-control" type="text" id="currency_symbol" autocomplete="off" required>
                            </div>
                            
                        </div> 
                        <div class="form-group row">
                            <label for="rpc_url" class="col-sm-3 col-form-label"><?php echo display('RPC_Url'); ?><i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input name="rpc_url" value="<?php echo set_value('rpc_url'); ?>" class="form-control" type="text" id="rpc_url" autocomplete="off" >
                            </div>
                            
                        </div> 


                        <div class="form-group row">
                            <label for="explorer_url" class="col-sm-3 col-form-label"><?php echo display('Blockchain_Explorer_URL'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input name="explorer_url" value="<?php echo set_value('explorer_url'); ?>" class="form-control" type="text" id="explorer_url" autocomplete="off" >
                            </div>
                            
                        </div> 


                        <div class="form-group row">
                            <label for="server_ip" class="col-sm-3 col-form-label"><?php echo display('Server_IP'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input name="server_ip" value="<?php echo set_value('server_ip'); ?>" class="form-control" type="text" id="server_ip" placeholder="168.68.101.9" autocomplete="off" >
                            </div>
                            
                        </div> 


                        <div class="form-group row">
                            <label for="port" class="col-sm-3 col-form-label"><?php echo display('Port'); ?> <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input name="port" value="<?php echo set_value('port'); ?>" class="form-control" type="text" id="port" placeholder="8282" autocomplete="off" >
                            </div>
                            
                        </div> 

                      
                        <div class="row" align='center'>
                            <div class="col-sm-8 col-sm-offset-3">
                                <a href="<?php echo base_url('admin'); ?>" class="btn btn-primary  w-md m-b-5"><?php echo display("cancel") ?></a>
                                <button type="submit" class="btn btn-success  w-md m-b-5"><?php echo display("save") ?></button>
                            </div>
                        </div>
                    <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>