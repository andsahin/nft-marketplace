<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link href="<?php echo esc($frontendAssets); ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo esc($frontendAssets); ?>/plugins/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="<?php echo esc($frontendAssets); ?>/css/style.css" rel="stylesheet">
    <link href="<?php echo esc($frontendAssets); ?>/css/dev.css" rel="stylesheet">
    <script src="<?php echo esc($frontendAssets); ?>/plugins/jquery/jquery.min.js"></script>
    <title><?php echo esc($settings->title).' - Login'; ?></title>
</head>

<body>
    <div class="registration-content vh-100 d-flex justify-content-between flex-column">
        <!-- Header nav -->
        <div class="header-nav d-flex align-items-center justify-content-between">
            <!-- Logo -->
            <a href="<?php echo base_url(); ?>" class="header-nav_logo">
                <img src="<?php echo base_url($settings->logo_web); ?>">
            </a>
            <!-- Color change button --> 
        </div>


        <div class="my-4 offset-lg-3 offset-md-2 offset-sm-2 registration-inner">
            <?php if(isset($message)){ ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong><?php echo display('Success'); ?>!</strong> <?php echo esc($message); ?>
            </div>
            <?php } ?>
            <?php if(isset($exception)){ ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <strong><?php echo display('Exception'); ?>!</strong> <?php echo esc($exception); ?>
            </div>
            <?php } ?>
            <div class="mb-4">
                <h4 class="fw-semi-bold"><?php echo display('Log in'); ?></h4>
                <p><?php echo display('Please_login_to_continue'); ?></p>
            </div>
            <?php echo form_open('user/signin'); ?>
            <div class="general-login">
                <div class="mb-3">
                    <label for="email" class="form-label fw-semi-bold text-black mb-1"><?php echo display('Email'); ?></label> 
                    <?php echo form_input('email', set_value('email'), 'class="form-control" id="email" required="required" placeholder="name@example.com"') ?>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-semi-bold text-black mb-1"><?php echo display('Password'); ?></label>
                    <div class="position-relative"> 
                        <?php echo form_password('password', set_value('password'), 'class="form-control" id="password_login" required="required" placeholder="'.display("Password").'"') ?>

                        <span class="show-pass" id="password_toggle">

                            <i class="eye-change far fa-eye" id="eye_toggle"></i>

                        </span>

                    </div>
                </div> 
                
                <button type="submit" class="btn btn-primary w-100"><?php echo display('Continue'); ?></button> 
            </div>
            <?php echo form_close(); ?>
            <!-- Wallet login -->
             
            <p class="text-center mt-3 mb-0"><?php echo display('By_logging'); ?> <a href="<?php echo base_url('terms'); ?>" class="text-decoration-underline"><?php echo display('Terms_of_Use'); ?></a> <?php echo display('and'); ?> <a href="<?php echo base_url('privacy-policy'); ?>"
                    class="text-decoration-underline"><?php echo display('Privacy Policy'); ?></a></p>
            <p class="text-center mt-3 mb-0 fw-medium text-dark">
                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal"><?php echo display('Forgot_password?'); ?></a> <?php echo display('No_Account?'); ?>
                <a href="<?php echo base_url('signup'); ?>" class="text-decoration-underline">
                    <?php echo display('Sign_Up'); ?> &nbsp;
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-arrow-right">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </p> 
        </div> 
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <?php echo form_open('home/forgotPassword', 'class="forgotpass"'); ?>
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo display('Forgot_Password'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              
              <div class="modal-body">
               <?php echo form_input('email', set_value('email'), 'class="form-control form-control-bg" id="email" required="required" placeholder="name@example.com"') ?>              </div>
              <div class="modal-footer"> 
                <button type="submit" class="btn btn-primary"><?php echo display('Send_code'); ?></button>
              </div>
              
            </div>
            <?php echo form_close(); ?>
          </div>
        </div>



        <!-- Footer copy -->
        <div class="footer-copy text-dark text-center">
            <?php echo esc($settings->footer_text); ?>
        </div>
    </div> 


 
    <script src="<?php echo esc($frontendAssets); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo esc($frontendAssets); ?>/js/login.js"></script>
  

 
</body>

</html>