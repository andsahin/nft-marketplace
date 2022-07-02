
<?php $this->uri = service('uri','<?php echo base_url(); ?>');?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 lobipanel-parent-sortable ui-sortable" data-lobipanel-child-inner-id="5lmZlfyErQ">
        
        <!-- alert message -->
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?php echo display('Check_your_email'); ?> 
            </div>  

        <div class="panel panel-bd lobidrag lobipanel lobipanel-sortable" data-inner-id="5lmZlfyErQ" data-index="0">
            <div class="panel-heading ui-sortable-handle">
                <div class="panel-title max-width-calc">
                    <h4><?php echo display('change_verify')?></h4>
                </div>
            </div>

            <?php 

            ?>

            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
                        <div class="border_preview">
                            <div class="table-responsive">
                                <?php 
                                    $att = array('name'=>'verify','id'=>'verify');
                                    echo form_open('#',$att);
                                    echo form_hidden('id',$this->uri->getSegment(4));
                                ?>
                                <table class="table">
                                    <tbody>

                                        <tr>
                                            <th><?php echo display('enter_verify_code');?></th>
                                            <td><input class="form-control" type="text" name="code" id="code"></td>
                                        </tr>

                                    </tbody>
                                </table>
                                <?php echo form_close();?>
                            </div>
                            <div class="text-right">
                                <button type="button" id="profile_confirm_btn" class="btn btn-success w-md m-b-5"><?php echo display('confirm');?></button>
                                <a href="<?php echo base_url('customer/profile/edit_profile')?>"  class="btn btn-danger w-md m-b-5"><?php echo display('cancle');?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script src="<?php echo base_url("app/Modules/User/Assets/Customer/js/custom.js?v=1.1") ?>" type="text/javascript"></script>