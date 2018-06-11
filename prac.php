<?php include_once 'functions.php';?>
<!DOCTYPE html>
<html class="no-js no-svg">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="profile" href="http://gmpg.org/xfn/11">
<!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">-->
<link href="<?php echo path_url('/retail_pro');?>/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo path_url('/retail_pro');?>/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo path_url('/retail_pro');?>/style/style.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="<?php echo path_url('/retail_pro');?>/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo path_url('/retail_pro');?>/angular.min.js"></script>

<style type="text/css">
    .thumbnail:hover > .img{
        box-shadow: 0px 0px 10px #b0b0b0;
    }
</style>
<?php
    heads();
?>
</head>
<?php
    error_reporting(0);
?>
<body ng-app="myapp" ng-controller="usercontroller">
    <div class="overlayyy"></div>
    <?php
        $term_query = "SELECT `wp_terms`.*,`wp_term_taxonomy`.* FROM `wp_terms`,`wp_term_taxonomy` WHERE `wp_terms`.`slug` = '$url[1]' AND `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores'";
        $term_result = mysqli_query($conn,$term_query);
        $trem_row = mysqli_fetch_assoc($term_result);
        $term_id = $trem_row['term_id'];
        
        $data = new query();
        $ip = get_client_ip();
        if(isset($_POST['search'])){
            if(!empty($_POST['search'])){
                $searcher = mysqli_real_escape_string($conn,htmlentities($_POST['search']));
                $searcher_slug = strtolower(str_ireplace(' ','-',$searcher));
                $query_recent_sel = $data->select($conn,'*','wp_recent',"WHERE `recent`='$searcher' AND `ipaddr`='$ip'");
                $searcher = trim($searcher);
                
                $search_store_array = [];
                if(isset($_POST['search']) && !empty($_POST['search'])){
                    $search_sql = "SELECT `wp_term_relationships`.*,`wp_term_taxonomy`.*,`wp_terms`.* FROM `wp_term_relationships`,`wp_term_taxonomy`,`wp_terms` WHERE `wp_term_taxonomy`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` IN('stores','coupon_category') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_terms`.`name` = '$searcher' GROUP BY `wp_terms`.`name`";
                    $search_query = mysqli_query($conn,$search_sql);
                    if(mysqli_num_rows($search_query) > 0){
                        while($search_row = mysqli_fetch_assoc($search_query)){
                            $search_store_name = $search_row['name'];
                            $search_store_slug = $search_row['slug'];
                            $search_slug_tax = $search_row['taxonomy'];
                            if($search_slug_tax == 'stores'){
                                $location_path = path_url('/retail_pro'). "/stores/$search_store_slug"; 
                                header('Location: ' . $location_path);
                            }else if($search_slug_tax == 'coupon_category'){
                                $location_path = path_url('/retail_pro'). "/coupons-category/$search_store_slug"; 
                                header('Location: ' . $location_path);
                            }
                        }
                    }else{
                        $location_path = path_url('/retail_pro'). "/search/$searcher_slug"; 
                        header('Location: ' . $location_path);
                    }
                }
                //Last Option 
                
                
                
                if(mysqli_num_rows($query_recent_sel) > 0){
                    
                }else{
                    $insert_recent = $data->insert($conn,'wp_recent',"recent,recent_slug, ipaddr, recent_url","'$searcher','$searcher_slug','$ip','$location_path'","");
                } 
            }
        }
    ?>
    <input type="hidden" value="<?php echo path_url('/retail_pro');?>" class="kbc_uri" placeholder="<?php echo $url[1]; ?>" title="<?php echo $term_id; ?>"/>
    <header id="head" class="main_header">
       <div id="cont" class="container">
            <div class="row search-with-logo">
                <div class="col-sm-3 logo">
                    <a href=""><img src="<?php echo path_url('/retail_pro');?>/img/ret_logo.png" class="img-responsive"/></a>
                </div>
                <div class="search col-xs-offset-2 col-sm-offset-0 col-xs-8 col-sm-5">
                    <form action="" method="post" class="" role="search">
                        <div class="input-group">
                            <span class="input-group-addon fa fa-search"></span>
                            <input type="text" class="form-control foc" name="search" autocomplete="off" id="inputGroupSuccess1" placeholder="Search on RetailMeNot" aria-describedby="inputGroupSuccess1Status">
                        </div>
                    </form>
                    <div class="free">
                        <div class="row visible-xs top_form">
                            <div class="col-xs-1 back"><i class="fa fa-arrow-left"></i></div>
                            <div class="col-xs-10 top_form_in">
                                <form action="" method="post" class="" role="search">
                                    <input type="text" class="form-control foce" autocomplete="off" name="search" id="inputGroupSuccess2" placeholder="Search on RetailMeNot"/>
                                </form>
                            </div>
                            <div class="col-xs-1 cross"><i class="fa fa-remove"></i></div>
                        </div>
                        <div class="basic">
                            <?php
                                
                                
                                $fetch_recent = $data->select($conn,'*','wp_recent',"WHERE `ipaddr`='$ip' ORDER BY id DESC LIMIT 5");
                                if(mysqli_num_rows($fetch_recent) > 0){
                                    ?>
                                    <h4>Recent</h4>
                                    <ul>
                                    <?php
                                    while($fetch_recent_row = mysqli_fetch_array($fetch_recent)){
                                        $recent_name = $fetch_recent_row['recent'];
                                        $recent_slug = strtolower($fetch_recent_row['recent_slug']);
                                        $recent_url = $fetch_recent_row['recent_url'];
                                        ?>
                                        <li><a href="<?php echo $recent_url; ?>"><?php echo $recent_name; ?></a></li> 
                                        <?php
                                    }
                                    ?>
                                    </ul>
                                    <hr />
                                    <?php
                                }
                            ?>
                           
                       
                        
                        
                            <h4>Popular at Retailmenot</h4>
                            <ul>
                               <li><a href="">Online Codes</a></li> 
                               <li><a href="">In Store Codes</a></li> 
                               <li><a href="">Cash Back Offers</a></li> 
                               <li><a href="">Gift Card Deals</a></li>
                            </ul>
                            <hr />
                        </div>
                        <div class="ws">
                            <h4>Stores</h4>
                            <ul>
                               <li><a href="">Amazon</a></li> 
                               <li><a href="">FlipKart</a></li> 
                               <li><a href="">Samsung</a></li> 
                               <li><a href="">Daraz</a></li>
                            </ul>
                            <hr />
                            
                            <h4>Categories</h4>
                            <ul>
                               <li><a href="">flat</a></li> 
                               <li><a href="">corner</a></li> 
                               <li><a href="">spider</a></li> 
                               <li><a href="">cloth</a></li>
                            </ul>
                            <hr />
                            
                            <h4>Brand</h4>
                            <ul>
                               <li><a href="">Khadi</a></li> 
                               <li><a href="">JJ</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 login hidden-xs">
                   <ul>
                        <li><a href="" class="btn btn-primary">
                            <i class="fa fa-user-circle-o"></i> <span><b>Log In / Sign up</b> <br /> $0.00 Cash Back</span>
                        </a></li>
                        <li><a href="" style="padding: 13.5px;"><i class="fa fa-shopping-cart"></i></a></li>
                   </ul>
                </div>
            </div>
            <br class="hidden-xs" />
            <div class="row hidden-xs">
                <nav class="navbar navbar-default text-center">
                    <div class="container">
                      <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav">
                              <li class="active"><a href="#"> Home<span class="sr-only">(current)</span></a></li>
                              <li><a href="#" id="nav_store" class="nav_store nav_hide">Stores</a></li>
                              <li><a href="#" id="nav_category" class="nav_category nav_hide">Categories</a></li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </div><!-- /.container-fluid -->
                  </nav>
            </div>
       </div>
       
        <div class="menu-container visible-xs">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Menu</a></li>
                    <li><a data-toggle="tab" href="#menu1">Account</a></li>  
                </ul>
                <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <ul class="">
                                <li class="active"><a href="#"> Home<span class="sr-only">(current)</span></a></li>
                                <li><a href="#">Stores</a></li>
                                <li><a href="#">Categories</a></li>
                            </ul>
                                
                        </div>
                        <div id="menu1" class="tab-pane fade">
                                <ul>
                                    <li><a href="" class="btn btn-primary">
                                        <i class="fa fa-user-circle-o"></i> <span><b>Log In / Sign up</b> <br /> $0.00 Cash Back</span>
                                    </a></li>
                                    <li><a href=""><i class="fa fa-shopping-cart"></i></a></li>
                               </ul>
                        </div>
                </div>
        </div>
        <div class="overlay"></div>
        <button type="button" class="hamburger is-closed visible-xs" data-toggle="offcanvas">
            <span class="hamb-top"></span>
            <span class="hamb-middle"></span>
            <span class="hamb-bottom"></span>
        </button>
    </header>

    <?php
        /*$search_store_array = [];
        if(isset($_POST['search']) && !empty($_POST['search'])){
            $search = mysqli_real_escape_string($conn,htmlentities($_POST['search']));
            $search_sql = "SELECT `wp_term_relationships`.*,`wp_term_taxonomy`.*,`wp_terms`.* FROM `wp_term_relationships`,`wp_term_taxonomy`,`wp_terms` WHERE `wp_term_taxonomy`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_terms`.`name` = '$search' GROUP BY `wp_terms`.`name`";
            $search_query = mysqli_query($conn,$search_sql);
            if(mysqli_num_rows($search_query) > 0){
                while($search_row = mysqli_fetch_assoc($search_query)){
                    $search_term_name = $search_row['name'];
                    array_push($search_store_array,$search_term_name);
                }
            }
            var_dump($search_store_array);
        }*/
    ?>
    <div class="overla"></div>
    <div class="container dynamic_category_switch">
        <div class="dynamic_category row">
            <div class="sub_side col-xs-4"></div>
            <div class="sub_shop col-xs-8"></div>

        </div>
    </div>
    
<?php
    include_once 'inc/footer.php';
?>