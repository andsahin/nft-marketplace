<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url() . $settings->favicon; ?>">
    <title><?php echo esc($settings->title); ?></title> 

    <link href="https://fonts.googleapis.com/css2?family=Caladea:ital,wght@0,400;0,700;1,400;1,700&family=EB+Garamond:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
  
 <!-- Bootstrap CSS -->
    <link href="<?php echo esc($frontendAssets); ?>/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo esc($frontendAssets); ?>/plugins/OwlCarousel2/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo esc($frontendAssets); ?>/plugins/OwlCarousel2/css/owl.theme.default.min.css">
    <link href="<?php echo esc($frontendAssets); ?>/plugins/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="<?php echo esc($frontendAssets); ?>/css/style.css" rel="stylesheet">
    <script src="<?php echo esc($frontendAssets); ?>/plugins/jquery/jquery.min.js"></script>

        <!-- Datepicker js & css -->
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo esc($frontendAssets) ?>/css/daterangepicker.css" />  
    <script type="text/javascript" src="<?php echo esc($frontendAssets) ?>/js/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo esc($frontendAssets) ?>/js/daterangepicker.js"></script>
    <link href="<?php echo esc($frontendAssets); ?>/css/dev.css" rel="stylesheet">
    <link href="<?php echo esc($frontendAssets); ?>/css/animate.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>/public/assets/plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
     
    <span id="siteuri" mybaseuri="<?php echo base_url(); ?>"></span>
    
    <script type="text/javascript">
        var get_csrf_hash  = '<?php echo csrf_hash(); ?>';
        var csrf_token   = '<?php echo csrf_token(); ?>'; 
    </script>
</head>

<body> 
    <!--Navbar-->
    <nav class="navbar navbar-expand-xl navbar-bg-white">
    <div class="container-fluid">
        <!-- Navbar brand -->
        <a class="navbar-brand" href="<?php echo base_url(); ?>">
            <img src="<?php echo base_url() . $settings->logo_web ?>">
        </a> 

        <div class="search-wrap d-none d-md-block">
            <div class="position-relative d-none d-md-block">

                <input class="form-control me-2 h-auto-search" type="search" placeholder="<?php echo display('Search_your_nfts'); ?>.." aria-label="Search">

                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-search searchIcon">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </div>
            <div class="header-searching">
               
            </div>
        </div>
  
        <div class="collapse navbar-collapse navbar-custom-collapse ms-auto" id="navbarSupportedContent">
            <!-- Navbar collapse header -->
            <div class="navbar-collapse-header">
                <div class="align-items-center row">
                    <div class="col-6 collapse-brand">
                        <a href="<?php echo base_url(); ?>">
                            <img src="<?php echo base_url() . $settings->logo_web; ?>">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#navbar-collapse" aria-expanded="true" aria-label="Toggle navigation">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <ul class="navbar-nav">
                
                  
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('nfts/create'); ?>"><?php echo display('Create_your_NFT'); ?></a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo display('Search'); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo base_url('all'); ?>"><?php echo display('All_NFTs'); ?></a></li>
                        <?php foreach ($categories as $key => $category) {
                             echo '<li><a class="dropdown-item" href="'.base_url("category").'/'.esc($category->slug).'">'.esc($category->cat_name).'</a></li>';
                        } ?>
                        
                    </ul>
                </li> 

                <?php if (!$session->userdata('isUser') && !$session->userdata('isAdmin')){ ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url('user/signin'); ?>" class="nav-link btn-registration">
                            <button type="button" class="btn btn-registration"><?php echo display('Sign_in'); ?></button>
                        </a>
                    </li>

                <?php }elseif($session->userdata('isAdmin')){ ?>

                    <li class="nav-item">
                        <a href="<?php echo base_url('backend/home'); ?>" class="nav-link btn-registration">
                            <button type="button" class="btn btn-registration"><?php echo display('Dashboard'); ?></button>
                        </a>
                    </li>
                <?php
                }else{ ?>
                <li class="nav-item dropdown d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo display('Account'); ?>
                    </a>
                    
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo base_url('user/dashboard'); ?>"><?php echo display('My_NFTs'); ?></a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url('user/dashboard?my=favorite'); ?>"><?php echo display('Favorites'); ?></a></li> 
                        <li><a class="dropdown-item" href="<?php echo base_url('user/my-collection'); ?>"><?php echo display('My_Collections'); ?></a></li>
                        <li><a class="dropdown-item" href="<?php echo base_url('user/settings'); ?>"><?php echo display('Profile'); ?></a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?php echo base_url('logout'); ?>"><?php echo display('logout'); ?></a></li>
                    </ul>

                </li>
                <?php } ?>
            </ul> 
        </div>
        <ul class="navbar-nav d-flex flex-row navbar-custom">
            <?php  
         
            if ($session->userdata('isUser')){ ?>
            <li class="nav-item dropdown d-none d-sm-flex">
                <a class="dropdown-toggle header-icon nav-link" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php  
                    if(isset($userInfo->image)){ 
                    ?>
                        <img src="<?php echo base_url().'/public/uploads/dashboard/new/'.$userInfo->image; ?>" class="profile-image rounded-circle" alt="<?php echo esc($userInfo->f_name).' '.esc($userInfo->l_name); ?>">
                    <?php }else{ ?>
                        <img src="<?php echo base_url().'/public/uploads/dashboard/no-picture.jpg'; ?>" class="profile-image rounded-circle" alt="<?php echo esc($userInfo->f_name).' '.esc($userInfo->l_name); ?>">
                    <?php } ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('user/dashboard'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="me-2 feather feather-grid"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            <span><?php echo display('My_NFTs'); ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('user/settings'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="me-2 feather feather-user">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            <span><?php echo display('Profile'); ?></span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('user/dashboard?my=favorite'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="me-2 feather feather-heart">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                </path>
                            </svg>
                            <span><?php echo display('Favourites'); ?></span>
                        </a>
                    </li> 
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('user/my-collection'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="me-2 feather feather-shopping-bag">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            <span><?php echo display('My_Collections'); ?></span>
                        </a>
                    </li>
                    
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('logout'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="me-2 feather feather-log-out">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            <span><?php echo display('logout'); ?></span>
                        </a>
                    </li>
                </ul>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link">
                    
                </a>
            </li>
            
            <li class="nav-item">
                <!-- Navbar toggler -->
                <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </li>
        </ul>
    </div>
    </nav>
        