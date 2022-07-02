<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Bdtask">
    <title><?php echo  esc($settings->title) ?> - <?php echo (!empty($title) ? esc($title) : null) ?></title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url() . $settings->favicon ?>">
    <!--Global Styles(used by all pages)-->

    <link href="<?php echo base_url("public/assets/plugins/bootstrap/css/bootstrap.min.css") ?>" rel="stylesheet">
    <link href="<?php echo base_url("public/assets/plugins/metisMenu/metisMenu.min.css") ?>" rel="stylesheet">
    <link href="<?php echo base_url("public/assets/plugins/fontawesome/css/all.min.css") ?>" rel="stylesheet">
    

    <link href="<?php echo base_url("public/assets/plugins/datatables/dataTables.bootstrap4.min.css") ?>"
        rel="stylesheet">

    <link href="<?php echo base_url("public/assets/plugins/datatables/responsive.bootstrap4.min.css") ?>"
        rel="stylesheet">
    <link href="<?php echo base_url("public/assets/plugins/datatables/buttons.bootstrap4.min.css") ?>" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans:ital,wght@0,100;0,300;0,400;0,500;0,700;0,800;0,900;1,100;1,300;1,400;1,500;1,700;1,800;1,900&family=Nunito+Sans:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <link href="<?php echo base_url("public/assets/dist/css/style.css?v=1") ?>" rel="stylesheet">
    <link href="<?php echo base_url("public/assets/css/custom.css?v=2") ?>" rel="stylesheet">
    <link href="<?php echo base_url("public/assets/plugins/select2/dist/css/select2.min.css") ?>" rel="stylesheet">
    <link href="<?php echo base_url("public/assets/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css") ?>"
        rel="stylesheet">
 
    <!-- Sweet alert 2 --> 
    <script src="<?php echo base_url('public/assets/plugins/sweetalert2/dist/sweetalert2.min.js')?>" type="text/javascript"></script> 
    <link href="<?php echo base_url('public/assets/plugins/sweetalert2/dist/sweetalert2.min.css')?>" rel="stylesheet">
    <!-- Sweet alert 2 -->

    <script src="<?php echo base_url("public/assets/plugins/jQuery/jquery.min.js") ?>"></script>

    <input type="hidden" name="base_url" id="base_url" value="<?php echo esc(base_url()); ?>">
    <input type="hidden" name="segment" id="segment" value="<?php echo esc($uri->setSilent()->getSegment(2)); ?>">
    <input type="hidden" name="language" id="language" value="<?php echo esc($settings->language); ?>">
    <script type="text/javascript">
        var get_csrf_hash  = '<?php echo csrf_hash(); ?>';
        var csrf_token   = '<?php echo csrf_token(); ?>';
    </script>
</head>