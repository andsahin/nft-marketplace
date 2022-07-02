
<?php $uri = service('uri','<?php echo base_url(); ?>');?>
<div class="row d-flex justify-content-around">  
  <div class="card col-lg-12">
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
    <div class="msg"></div> 
    <div class="text-danger"><?php echo display('Please'); ?> <a target="_blank" href="<?php echo base_url('/public/uploads/sol/sol.zip'); ?>"><?php echo display('download'); ?></a> <?php echo display('your_smart_contract_to_verify_in'); ?>  <?php echo (isset($network->network_name) ? esc($network->network_name) : 'your network'); ?>.</div>
    	<?php 
      if(empty($info)){
      echo form_open('#', 'id="contract_form"');  
      ?>
     	<div> 

   		 	<div class="form-group row"> 

          <div class="col-sm-6">

          	<label><?php echo display('Contract_Name'); ?> <i class="text-danger">*</i></label>
              <input name="contract_name" value="" class="form-control" type="text" id="contract_name" autocomplete="off" placeholder="<?php echo display('Contract_name'); ?>" required>

          </div> 

          <div class="col-sm-6">

          	<label><?php echo display('Token_Symbol'); ?> <i class="text-danger">*</i></label>
              <input name="contract_symbol" value="" class="form-control" type="text" id="contract_symbol" autocomplete="off" placeholder="<?php echo display('Token_symbol'); ?>" required>

          </div> 

        </div> 

        <div class="form-group row"> 

          <div class="col-sm-6">

            <label><?php echo display('Max_Supply'); ?> <i class="text-danger">*</i></label>

              <input name="max_supply" value="" class="form-control" type="text" id="max_supply" autocomplete="off" placeholder="Ex=1000000" required>

          </div>  

        </div> 
        <span class="deployedmsg text-danger"></span>
        <div class="form-group row"> 
        	 <div class="col-sm-6 aftersubmit">  
              <button type="submit" class="btn btn-success"><?php echo display('Deploy'); ?></button>
            </div> 
        </div> 
     		<div class="form-group row col-lg-12">
           
     		</div> 
     	</div>
      <?php 
      form_close();
      }else{ 
      ?>
      <div class="table-responsive">
        <table class="table display table-bordered table-striped table-hover">
          <thead>
            <tr>
              <td><?php echo display('Contract_Name'); ?></td>
              <td><?php echo display('Token_Symbol'); ?></td>
              <td><?php echo display('Max_Supply'); ?></td>
              <td><?php echo display('Contract_Address'); ?></td>
              <td><?php echo display('Transaction_Hash'); ?></td>
            </tr>
          </thead>
          <tbody>
            <td><?php echo esc($info->contract_name); ?></td>
            <td><?php echo esc($info->contract_symbol); ?></td>
            <td><?php echo esc($info->max_token_supply); ?></td>
            <td><?php echo esc($info->contract_address); ?> <a title="" target="_blank" href="<?php echo esc($network->explore_url).'/address/'.esc($info->contract_address); ?>"> <i class="fa fa-location-arrow"></i></a></td>
            <td><?php echo esc($info->tnx_hash); ?> <a title="" target="_blank" href="<?php echo esc($network->explore_url).'/tx/'.esc($info->tnx_hash); ?>"> <i class="fa fa-location-arrow"></i></a></td>
          </tbody>
        </table>
      </div>
      <?php } ?>
      <div class="text-danger"><?php echo display('contract_deploy_msg'); ?></div>
    </div> 

  </div>  
</div>
<script src="<?php echo base_url("app/Modules/Nfts/Assets/Admin/js/custom.js") ?>"></script>

 

 