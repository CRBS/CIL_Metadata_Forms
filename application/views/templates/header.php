<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="/css/bootstrap.min.css" media="screen">
    
    <link rel="stylesheet" href="/css/custom.css?<?php echo uniqid(); ?>">
    <link rel="stylesheet" href="/css/ccdb.css">
    <link rel="stylesheet" href="/css/jquery-ui.css">
    <link rel="stylesheet" href="/css/cil.css">
     <script src="/js/jquery.min.js"></script> 
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/custom.js"></script>
    <link rel="icon" href="/pix/favicon.ico" type="image/x-icon" />
    <script src="/js/cil_input_autocomplete.js?<?php echo uniqid(); ?>" type="text/javascript"></script>
    <script src="/js/jquery-1.12.4.js"></script> 
    <script src="/js/jquery-ui.js"></script>
    
    
    <!-----Date picker-------->
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
  </head>


  <body>
   <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-159943048-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-159943048-1');
    </script>  
      
    <div class="row">
        <div class="col-md-12">
            <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
              <div class="container">
                <?php 
                    $homeUrl = "/cdeep3m";
                    if(isset($username)) 
                        $homeUrl = "/home";
                                            
                 ?>
                  <a href="<?php echo$homeUrl; ?>" target="_self"><img width="40" src="/pix/logo2.png"></a>
                  <a href="<?php echo$homeUrl; ?>" class="navbar-brand">&nbsp;<?php echo $title; ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                  <ul class="navbar-nav">
                    <!---------Navbar----------------------> 
                    
                    <li class="nav-item active">
                        &nbsp;&nbsp;&nbsp;
                    </li>
                    
                    <?php
                    if(!isset($username))
                    {
                    ?>
                        <li class="nav-item">
                          <a class="nav-link" href="/home/about_us">About us</a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="/home/gallery">Gallery</a>
                        </li>
                    <?php
                    }
                    ?>
                    <li class="nav-item">
                      <a class="nav-link" href="/home/pre_trained_models">Pre-trained models</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/home/faq">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/CRBS/cdeep3m2" target="_self">Open source</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/home/terms">Terms</a>
                    </li>
                    <?php
                    if(isset($username))
                    {
                    ?>
                    <li class="nav-item">
                      <a class="nav-link" href="/home/my_account">My Account</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="/home/process_history">Process History</a>
                    </li>
                    <?php
                    }
                    ?>
                    <!---------End Navbar------------------>
                  </ul>
                   
                </div>
                  
                <?php
                    if(!isset($try_login)  && isset($image_id))
                    {
                ?>
                  <span style="color:white"><?php if(isset($username)) echo $username.":"; ?></span>&nbsp;&nbsp;<a href="/login/signout/<?php echo $image_id?>" target="_self">Log out</a>
                <?php
                    }
                    else if(!isset($try_login)  && isset($tag))
                    {
                ?>
                  <span style="color:white"><?php if(isset($username)) echo $username.":"; ?></span>&nbsp;&nbsp;<a href="/login/signout_tag/<?php echo $tag; ?>" target="_self">Log out</a>
                <?php
                    }
                    else if(isset($username)) 
                    {
                 ?>
                   <span style="color:white"><?php if(isset($username)) echo $username.":"; ?></span>&nbsp;&nbsp;<a href="/login/signout_home" target="_self">Log out</a>
                  <?php
                    }
                    else if(isset($my_account)) 
                    {
                    ?>
                    <a href="/home" target="_self">My account</a>
                    <?php
                    }
                    else
                    {
                    ?>
                    <a href="/home" target="_self">Sign in</a>
                    <?php
                    }
                    ?>
                </div> 
              </div>
            
            </div> 
    </div>
    