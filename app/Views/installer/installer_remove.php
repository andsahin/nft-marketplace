<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo esc($title);?></title>

        <!-- Bootstrap -->
       <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        
        <link href="<?php echo base_url();?>/public/assets/installer/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url();?>/public/assets/installer/css/installer.css" rel="stylesheet">
    </head>
    <body>
        <div class="page-wrapper">
            <div class="content-wrapper">
                <div class="container"> 
                    <!-- begin of row -->
                    <div class="row"> 
                        <div class="box px-sm-15"> 
                            <div class="page-content">
                                <div class="outer-container">

                                    <?php 
                                    $error_msg = session('error_msg');
                                    if(isset($error_msg) && !empty($error_msg)){ ?>

                                    <div class="alert alert-dismissable bg-exception btn-warning">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <?php echo esc($error_msg); ?>
                                    </div> 

                                    <?php }?>
                                    

                                    <div class="box-inner">
                                        <div class="inner">
                                            <img src="<?php echo base_url()?>/assets/installer/img/001-trash-bin.png" alt="">
                                            <h4><?php echo htmlspecialchars('Please delete installer to run your application'); ?></h4>
                                        </div>
                                        <div class="text-right">
                                            <a href="<?php echo base_url()?>/remove_installer" class="btn btn-danger btn-block"><?php echo htmlspecialchars('Delete Now'); ?></a>
                                        </div>
                                        <div class="text-center bordered-area">
                                            <span>or</span>
                                        </div>
                                    </div>                            
                                    <div class="instruction">
                                        <h5 class="no-text"><?php echo htmlspecialchars('If you Dont have permission to delete the installer!'); ?></h5>
                                        <p class="text-success"><?php echo htmlspecialchars('Please go through the following steps.'); ?></p>
                                        <ul class="step-list">
                                            <li><span>1.</span> <?php echo htmlspecialchars('Go to the root folder of your server where placed all the files. ex: public_html'); ?>/</li>
                                            <li><span>2.</span> <?php echo htmlspecialchars('Delete the install folder.'); ?></li>
                                            <li><span>3.</span> <?php echo htmlspecialchars('Then refresh this page or click the button below.'); ?></li>
                                        </ul>
                                        <div class="text-right">
                                            <a href="<?php echo base_url()?>/installer" class="btn btn-refresh"><?php echo htmlspecialchars(''); ?><?php echo display('Refresh'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of page wrapper -->
                    <footer class="footer text-center">
                        <div class="container">
                            <div class="fText"><?php echo htmlspecialchars('Developed by'); ?><?php echo display('Developed_by'); ?> <a target="_blank" href="https://www.bdtask.com/"><?php echo htmlspecialchars('bdtask'); ?></a></div>
                        </div>
                    </footer>
                    <!-- End of footer -->
                </div> 
                
            </div>
        </div>
		
		<script src="<?php echo base_url()?>/public/assets/installer/js/jquery-3.6.0.min.js"></script>
		<script src="<?php echo base_url()?>/public/assets/installer/js/bootstrap.min.js"></script>
		
    </body>
</html>



