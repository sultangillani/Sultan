<?php include_once '../functions.php';?>
<?php
session_start();


?>
<!DOCTYPE html>
<html class="no-js no-svg">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="profile" href="http://gmpg.org/xfn/11">
<!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">-->
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="adminCss/style.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="../jquery.min.js"></script>
<script type="text/javascript" src="../angular.min.js"></script>
<?php head();?>
</head>

<body ng-app="myapp">
    <div id="wrapper">
    <?php if($page_name != 'login.php'){ ?>
    <header id="head" class="main_header">
        <nav class="navbar navbar-fixed-top navbar-inverse ad-nav">
            <div class="container-fluid">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><img src="../img/logo.png"/></a>
              </div>
          
              <!-- Collect the nav links, forms, and other content for toggling -->
              <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="profile.php">Welcome <i class="fa fa-user"></i> <?php echo ucfirst($_SESSION['username']); ?></a></li>                    
                    <li><a href="add-post.php"><i class="fa fa-plus-square"></i> Add Post</a></li>
                    <?php if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){ ?>
                        <li><a href="add-user.php"><i class="fa fa-user-plus"></i> Add User</a></li>
                    <?php } ?>
                    
                    <li><a href="profile.php"><i class="fa fa-user"></i> Profile</a></li>
                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>                
                </ul>
              </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
          </nav>
    </header>
    
    <?php
    }
    ?>