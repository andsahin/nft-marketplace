<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="panel-title">
                    <h6 class="fs-17 font-weight-600 mb-0"><?php echo (!empty($title)?$title:null) ?></h6>
                </div>
            </div> 
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header" align="center">  
                                <div class="card-header-menu">
                                    <i class="fa fa-bars"></i>
                                </div>
                                <img src="<?php echo base_url((!empty($user->image)?esc($user->image):'/public/assets/images/icons/user.png')) ?>" alt="User Image" heigt="200" >
                            </div> 
                            <div class="card-content" align="center">
                                <div class="card-content-member">
                                    <h4 class="m-t-0"><?php echo esc($user->fullname) ?> (<?php echo esc($user->user_level) ?>)</h4> 
                                </div> 
                            </div>
                            <div class="card-content"> 
                                <div class="card-content-summary">
                                    <p><?php echo esc($user->about) ?></p>
                                </div>
                            </div> 
                            <div class="card-content container"> 
                                <dl class="dl-horizontal">
                                    <dt><?php echo display('email'); ?> </dt> <dd><?php echo esc($user->email) ?></dd>
                                    <dt><?php echo display('IP_Address'); ?> </dt> <dd><?php echo esc($user->ip_address) ?></dd>
                                    <dt><?php echo display('Last_Login'); ?> </dt> <dd><?php echo esc($user->last_login) ?></dd>
                                    <dt><?php echo display('Last_Logout'); ?> </dt> <dd><?php echo esc($user->last_logout) ?></dd>
                                </dl> 
                            </div> 
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>

 