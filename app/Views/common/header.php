<?php $session = session();?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Vyshnavi Associates </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo site_url();?>assets/img/favicon.png" rel="icon">
  <link href="<?php echo site_url();?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo site_url();?>assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?php echo site_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo site_url();?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo site_url();?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="<?php echo site_url();?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?php echo site_url();?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?php echo site_url();?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?php echo site_url();?>assets/css/style.css" rel="stylesheet">

  <script src="<?php echo site_url();?>assets/js/jquery-3.6.3.min.js"></script>
  <script src="<?php echo site_url();?>assets/js/jquery.validate.min.js"></script>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container">
      <div class="header-container d-flex align-items-center justify-content-between">
        <div class="logo">
          <!-- <h1 class="text-light"><a href="index.html"><span>Vyshnavi Associates</span></a></h1> -->
          <!-- Uncomment below if you prefer to use an image logo -->
          <a href="<?php echo base_url();?>"><img src="<?php echo site_url();?>assets/img/logo-original.png" alt="" class="img-fluid"></a>
        </div>

        <nav id="navbar" class="navbar">
          <ul>
            <?php if ($session->loginId) {?>
              <li><a href="<?php echo base_url();?>/user-dashboard" class="nav-link scrollto" style="color: #10c796;font-size:18px;"><?php echo USER_TYPE_LIST[$session->userData['user_type']];?> Portal (<?php echo $session->userData['user_name'];?>)</a></li>
              
              <li><a class="nav-link scrollto" href="<?php echo base_url();?>/logout">Logout</a></li>
            <?php } else { ?>
            <li><a class="nav-link scrollto active" href="<?php echo base_url();?>#hero">Home</a></li>
            <li><a class="nav-link scrollto" href="<?php echo base_url();?>#about">About</a></li>
            <!-- <li><a class="nav-link scrollto" href="<?php echo base_url();?>#services">Client Registration</a></li> -->
            <li><a class="nav-link scrollto " href="<?php echo base_url();?>/employee-login">Employee</a></li>
            <li><a class="nav-link scrollto" href="<?php echo base_url();?>/assistant-login">Assistant</a></li>
            <li><a class="nav-link scrollto"  href="<?php echo base_url();?>/admin-login">Admin</a></li>
            <?php } ?>
          </ul>
          <i class="bi bi-list mobile-nav-toggle"></i>
        </nav><!-- .navbar -->

      </div><!-- End Header Container -->
    </div>
  </header><!-- End Header -->