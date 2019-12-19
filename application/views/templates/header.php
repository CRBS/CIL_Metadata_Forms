<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="/css/bootstrap.min.css" media="screen">
    
    <link rel="stylesheet" href="/css/custom.css">
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
  </head>
  <body>
    <div class="row">
        <div class="col-md-12">
            <div class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
              <div class="container">
                  <a href="/home" target="_self"><img width="40" src="/pix/logo2.png"></a>
                  <a href="/home" class="navbar-brand">&nbsp;<?php echo $title; ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                  <ul class="navbar-nav">
                    <!---------Navbar----------------------> 
                    
                    <li class="nav-item active">
                        &nbsp;&nbsp;&nbsp;
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">About us</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Gallery</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Pre-trained models</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://github.com/CRBS/cdeep3m" target="_self">Open source</a>
                    </li>
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
                    else
                    {
                    ?>
                    <a href="/home" target="_self">Log in</a>
                    <?php
                    }
                    ?>
                </div> 
              </div>
            
            </div> 
    </div>
    