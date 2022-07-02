<div class="row">

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-success card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="fas fa-user"></i>
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted"><?php echo display('Active_Users'); ?></p>
                <h3 class="card-title fs-18 font-weight-bold"><?php echo ($activeUsers ? esc($activeUsers):'0'); ?>
                    <small><?php echo display('Person'); ?></small>
                </h3>
            </div>

            <div class="card-footer p-3">
                <div class="stats">
                    <i class="fas fa-user text-success mr-2"></i>
                    <a href="<?php echo base_url('backend/customers/customer_list')?>" class="warning-link"><?php echo display('See_All_User'); ?></a>
                </div>
            </div>

        </div>
    </div>
     
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-info card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="hvr-buzz-out fab fa-elementor"></i>
                   
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted"><?php echo display('Total_NFTs'); ?></p>
                <h3 class="card-title fs-18 font-weight-bold"><?php echo esc($info['nfts']->total);?>
                </h3>
            </div>
            <div class="card-footer p-3">
                <div class="stats">
                   <i class="hvr-buzz-out fab fa-elementor text-success mr-2"></i>
                    <a href="<?php echo base_url('backend/nft/list'); ?>" class="warning-link"><?php echo display('See_All_NFT'); ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-danger card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="hvr-buzz-out fas fa-dolly"></i>
                   
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted"><?php echo display('Total_List_for_Sale');?></p>
                <h3 class="card-title fs-18 font-weight-bold"><?php echo esc($info['list']->total);?>
                </h3>
            </div>
            <div class="card-footer p-3">
                <div class="stats">
                    
                </div>
            </div>
        </div>
    </div>

    

</div>

<div class="row">

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-success card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="hvr-buzz-out fab fa-wpforms"></i>
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted"><?php echo display('Total_Sell'); ?></p>
                <h3 class="card-title fs-18 font-weight-bold"><?php echo esc($info['sell']->total); ?>
                     
                </h3>
            </div>

            <div class="card-footer p-3">
                <div class="stats">
                     
                </div>
            </div>

        </div>
    </div>
     
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-info card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="hvr-buzz-out fas fa-hand-holding-usd"></i>
                   
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted"><?php echo display('Total_Earned_Fees'); ?></p>
                <h3 class="card-title fs-18 font-weight-bold"><?php echo (isset($earned_fees)) ? esc($earned_fees->earned_fees).' '.SYMBOL : '0.00 '.SYMBOL; ?>
                </h3>
            </div>
            <div class="card-footer p-3">
                <div class="stats">
                    
                </div>
            </div>
        </div>
    </div>

   

    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-warning card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="fas fa-user"></i>
                   
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted"><?php echo display('Inactive_Users'); ?></p>
                <h3 class="card-title fs-18 font-weight-bold"><?php echo ($inactiveUsers ? esc($inactiveUsers) : '0'); ?>
                </h3>
            </div>
            <div class="card-footer p-3">
                <div class="stats">
                   <i class="fas fa-user text-success mr-2"></i>
                    <a href="<?php echo base_url('backend/customers/customer_list'); ?>" class="warning-link"><?php echo display('Inactive_Total_User'); ?></a>
                </div>
            </div>
        </div>
    </div>
    
</div>



 
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <div class="row">
                    <h2 class="col-md-10 fs-18 font-weight-bold mb-0"><?php echo display('Monthly_NFTs_minted_reports'); ?></h2>
                 
                    <div class="col-md-2"> 
                        <select class="form-control basic-single" name="nfts_year" id="nfts_year">                                        
                        <?php 
                            $years      =  date("Y", strtotime("-5 year"));
                            $years_now  =  date("Y");
                            for($i = $years_now; $i>=$years; $i--)
                                echo "<option value='".esc($i)."'>".esc($i)."</option>";
                        ?>                                                   
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="barChart" height="160"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                     
                     
                        <h6 class="fs-17 font-weight-600 mb-0"><?php echo display('Yearly_NFTs_Report'); ?></h6>
                     
                       
                  
                    <div class="text-right">
                         
                        <select class="form-control basic-single" name="pie_year" id="pie_year">                                        
                        <?php 
                            $years      =  date("Y", strtotime("-5 year"));
                            $years_now  =  date("Y");

                            for($i = $years_now; $i>=$years; $i--)
                                echo "<option value='".esc($i)."'>".esc($i)."</option>";
                        ?>                                                   
                        </select>
                        
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="pieChart" height="310"></canvas>
            </div>
        </div>
    </div> 
</div>


 

<!-- Modal body load from ajax start-->
<div class="modal fade modal-success" id="newModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
   <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><?php echo display('profile');?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <table>
                <tr><td><strong><?php echo display('name');?> : </strong></td> <td id="name"></td></tr>
                <tr><td><strong><?php echo display('email');?> : </strong></td> <td id="email"></td></tr>
                <tr><td><strong><?php echo display('mobile');?> : </strong></td> <td id="phone"></td></tr>
                <tr><td><strong><?php echo display('user_id');?> : </strong></td> <td id="user_id"></td></tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo display('Close'); ?></button>
        </div>
    </div><!-- /.modal-content -->
  </div>
</div>
<!-- Modal body load from ajax end-->

<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/jszip.min.js"></script>

<script src="<?php echo base_url()?>/public/assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/buttons.colVis.min.js"></script>
<script src="<?php echo base_url()?>/public/assets/plugins/datatables/data-bootstrap4.active.js"></script>  
<script src="<?php echo base_url("public/assets/plugins/chartJs/Chart.min.js") ?>"></script> 

<script src="<?php echo base_url("app/Modules/Auth/Assets/Admin/js/custom.js?v=1.1") ?>" type="text/javascript"></script>



 




