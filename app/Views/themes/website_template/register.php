<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link href="<?php echo esc($frontendAssets); ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo esc($frontendAssets); ?>/css/style.css" rel="stylesheet">
    <link href="<?php echo esc($frontendAssets); ?>/plugins/fontawesome/css/all.min.css" rel="stylesheet">
    <title><?php echo esc($settings->title).' - '.display('Registration'); ?></title>
</head>

<body>    
    <div class="registration-content vh-100 d-flex justify-content-between flex-column">
        
        <div class="header-nav d-flex align-items-center justify-content-between">
            <!-- Logo -->
            <a href="<?php echo base_url(); ?>" class="header-logo_web">
                <img src="<?php echo base_url($settings->logo_web); ?>">
            </a>
            <!-- Color change button -->  
        </div>
              
                        
        <?php echo form_open('signup', 'id="registration-form"'); ?> 
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
                <h4 class="fw-semi-bold"><?php  echo display("Create_an_Account") ?></h4>
                <p><?php echo display("Register_with_your_email"); ?></p>
            </div>
            <input type="hidden" id="baseval" value="<?php echo base_url(); ?>">
            <div class="mb-4">
                <label for="username" class="form-label fw-semi-bold text-black mb-1"><?php echo display('Choose_User_Name'); ?>:</label> 
                <?php echo form_input('username', set_value('username'), 'class="form-control" autocomplete="off" id="username" placeholder="'.display('username').'"'); ?> 
                <div id="username-feedback" class="valid-feedback-username"></div>
            </div>

            <div class="mb-4">
                <label for="emailadderss" class="form-label fw-semi-bold text-black mb-1"><?php echo display('Enter_your_email_address'); ?>:</label> 
                <?php echo form_input('email', set_value('email'), 'class="form-control" autocomplete="off" id="emailadderss" placeholder="'.display('email').'"'); ?> 
                <div id="email-feedback" class="valid-feedback-email"></div>
            </div>
            
            
            <div class="mb-3">
                <label class="form-label fw-semi-bold text-black mb-1"><?php echo display('Enter_your_password'); ?>:</label>  
                <div class="position-relative"> 
                    <?php echo form_password('password', set_value('password'), 'class="form-control" id="password" autocomplete="new-pass" placeholder="'.display('password').'"'); ?>  
                </div>
            </div>
            

            <label class="form-label fw-semi-bold text-black mb-1"><?php echo display('Confirm_password'); ?>:</label>  
            <div class="mb-3">
                <?php echo form_password('conf_pass', set_value('conf_pass'), 'class="form-control" id="conf_pass" placeholder="'.display('Confirm_Password').'"'); ?>  
            </div> 

            <!-- Popover password -->
            <div id="popover-password">
                <p><span id="result"></span></p>
                <div class="progress mb-3">
                    <div id="password-strength" class="progress-bar" role="progressbar" aria-valuenow="40"
                        aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <ul class="list-unstyled">
                    <li class="">
                        <span class="low-upper-case">
                            <i class="fas fa-circle"></i>
                            &nbsp; <?php echo display('Lowercase'); ?> &amp; <?php echo display('Uppercase'); ?>
                        </span>
                    </li>
                    <li class="">
                        <span class="one-number">
                            <i class="fas fa-circle"></i>
                            &nbsp; <?php echo display('Number'); ?> (0-9)
                        </span>
                    </li>
                    <li class="">
                        <span class="one-special-char">
                            <i class="fas fa-circle"></i>
                            &nbsp; <?php echo display('Special_Character'); ?> (!@#$%^&*)
                        </span>
                    </li>
                    <li class="">
                        <span class="eight-character">
                            <i class="fas fa-circle"></i>
                            &nbsp; <?php echo display('Atleast_8_Character'); ?>
                        </span>
                    </li>
                </ul>
            </div>
 


            <div class="form-check mb-0">
                <input name="accept_terms" class="form-check-input" type="checkbox" value="1" id="flexCheckDefault">

                <label class="form-check-label" for="flexCheckDefault">
                    <?php echo display('iam_interested_register'); ?>
                </label>
            </div>
             
            <input type="submit" name="submit" value="Continue" class="btn btn-primary w-100 mt-3" id="reg-submit-btn"  disabled="disabled">



            <p class="text-center mt-3 mb-0"><?php echo display('by_logging_in_you_indicate_that_you_have_read_and_agree'); ?>
                <?php echo display('to_our'); ?> <a href="<?php echo base_url('terms'); ?>" class="text-decoration-underline"><?php echo display('Terms_of_Use'); ?></a> <?php echo display('and'); ?>  <a href="<?php echo base_url('privacy-policy'); ?>"
                    class="text-decoration-underline"><?php echo display('Privacy_Policy'); ?></a></p>
            <p class="text-center mt-3 mb-0 fw-medium text-dark">
                <?php echo display('Have_an_account?'); ?>
                <a href="<?php echo base_url('user/signin') ?>" class="text-decoration-underline">
                    <?php echo display('login'); ?>&nbsp;
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-arrow-right">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </a>
            </p>
        </div>
        <?php form_close(); ?>
        <!-- Footer -->
        <div class="footer-copy text-dark text-center">
            <?php echo esc($settings->footer_text); ?>
        </div>
    </div>

    <script src="<?php echo esc($frontendAssets); ?>/plugins/jquery/jquery.min.js"></script> 
    <script src="<?php echo esc($frontendAssets); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo esc($frontendAssets); ?>/js/login.js"></script>
      
</body>

</html>