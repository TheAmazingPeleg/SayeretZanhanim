<?php
	//ini_set("error_reporting", E_ALL);
	header('Content-Type: text/html; charset=utf-8');
	session_start();
	if(!isset($_COOKIE['uid'])){
		setcookie('uid', '', time() + (86400 * 2), "/");
	}
	include "includes/dbconnect.php";
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="ThemeMarch">
  <meta name="description" content="">
  <meta name="keywords" content="">
	<!-- Page Title -->
	<title>סיירת צנחנים</title>
    <!-- Favicon Icon -->
  <link rel="icon" href="assets/img/favicon.png">
	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="assets/css/plugins.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link id="theme" rel="stylesheet" href="assets/css/color/color-1.css">
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script type="text/javascript" src="assets/vendor/backward/html5shiv.js"></script>
  <script type="text/javascript" src="assets/vendor/backward/respond.min.js"></script>
  <![endif]-->
</head>

<body data-spy="scroll" data-target=".primary-nav" class="rtl">
  <!-- Preloader -->
  <div id="preloader">
    <div class="preloader-wave"></div>
    <div class="preloader-wave"></div>
    <div class="preloader-wave"></div>
    <div class="preloader-wave"></div>
    <div class="preloader-wave"></div>
  </div>
  <!-- Preloader -->
  <!-- Start Site Header -->
  <header class="site-header">
    <div class="header-wrap">
      <div class="container">
        <nav class="primary-nav">
          <div class='m-menu-btn'><span></span></div>
          <ul class="primary-nav-list">
            <li class="menu-item"><a href="/index.php#home" class="nav-link">ראשי</a></li>
            <li class="menu-item"><a href="/index.php#commander" class="nav-link">דבר המפקד</a></li>
            <li class="menu-item menu-item menu-item-has-children"><a href="#portfolio" class="nav-link">היחידה</a>
              <ul>
                <li class="menu-item"><a href="blog-right-sidebar.html">הסטוריה</a></li>
                <li class="menu-item"><a href="blog-left-sidebar.html">עיסוקי היחידה</a></li>
              </ul>
			</li>
            <li class="menu-item menu-item menu-item-has-children"><a href="#portfolio" class="nav-link">לוחם</a>
              <ul>
                <li class="menu-item"><a href="blog-right-sidebar.html">הכשרה</a></li>
                <li class="menu-item"><a href="blog-left-sidebar.html">תפקידים</a></li>
                <li class="menu-item"><a href="blog-left-sidebar.html">פני הלוחם</a></li>
              </ul>
			</li>
            <li class="menu-item"><a href="#price" class="nav-link">גלריה</a></li>
			<?php 
			if(isset($_COOKIE['uid'])){
				echo "<li class=\"menu-item\"><a href=\"panel.php\" class=\"nav-link\">איזור אישי</a></li>";
			}	
			?>
            <li class="menu-item"><a href="/login.php" class="nav-link"><?php 
			if(!isset($_COOKIE['uid'])){
				echo "איזור אישי";
			}else{
				echo "התנתק";
			}			
			?></a></li>
          </ul>
        </nav>
        <div class="site-branding">
          <!-- For Image Logo -->
          <a href="index.html" class="custom-logo-link">
            <img src="assets/img/logo.png" alt="" class="custom-logo">
          </a>
          <!-- For Site Title -->
          <!-- <span class="site-title">
          <a href="index.html">Stray</a>
          </span> -->
        </div>
      </div>
    </div><!-- .header-wrap -->
  </header>
  <!-- End Site Header -->
