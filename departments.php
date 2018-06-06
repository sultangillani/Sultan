<?php include_once 'inc/header.php';?>

<section class="department_categories">
    <div class="deca_heading">
        <div id="conte" class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Browse Top Categories</h2>
                </div>
            </div>
        </div><!---conte--->
    </div><!---deca_heading--->
    <div class="department_cats">
        <div id="conte" class="container">
            <?php
                $department_sql = "SELECT `wp_terms`.*,`wp_term_taxonomy`.*,`wp_term_relationships`.* FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` IN ('coupon_category') GROUP BY `wp_terms`.`term_id`";
                $department_query = mysqli_query($conn,$department_sql);
                if(mysqli_num_rows($department_query) > 0){
                    ?>
                        <div class="row cat_boxes">
                            <?php
                            while($department_row = mysqli_fetch_assoc($department_query)){
                                $department_id = $department_row['term_id'];
                                $department_name = $department_row['name'];
                                $department_slug = $department_row['slug'];
                                $department_tax = $department_row['taxonomy'];
                                $department_term_icon = $department_row['term_icon'];
                                $department_term_type = $department_row['term_type'];
                                ?>
                                <div class="col-sm-2 col-xs-3 cat cat_<?php echo $department_slug;?>">
                                    <div class="cat_box">
                                        <a href="<?php echo path_url('/retail_pro');?>/coupons-category/<?php echo $department_slug; ?>" target="_blank">
                                            <i class="<?php echo $department_term_icon;?>"></i>
                                            <span><?php echo $department_name;?></span>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <input type="button" class="btn btn-link load_more_dep" value="Load More"/>
                    <?php
                }
            ?>
            <!---<div class="row cat_boxes">
                <div class="col-sm-2 col-xs-3 cat">
                    <div class="cat_box">
                        <a href="">
                            <i class="fa fa-clock-o"></i>
                            <span>Accessories</span>
                        </a>
                    </div>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <div class="cat_box">
                        <a href="">
                            <i class="fa fa-car"></i>
                            <span>Automotive</span>
                        </a>
                    </div>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <div class="cat_box">
                        <a href="">
                            <i class="fa fa-child"></i>
                            <span>Baby</span>
                        </a>
                    </div>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <div class="cat_box">
                        <a href="">
                            <i class="glyphicon glyphicon-eye-open"></i>
                            <span>Beauty</span>
                        </a>
                    </div>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <div class="cat_box">
                        <a href="">
                            <i class="fa fa-book"></i>
                            <span>Books</span>
                        </a>
                    </div>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <div class="cat_box">
                        <a href="">
                            <i class="fa fa-heartbeat"></i>
                            <span>Health</span>
                        </a>
                    </div>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <div class="cat_box">
                        <a href="">
                            <i class="fa fa-heartbeat"></i>
                            <span>Health</span>
                        </a>
                    </div>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <div class="cat_box">
                        <a href="">
                            <i class="fa fa-heartbeat"></i>
                            <span>Health</span>
                        </a>
                    </div>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <div class="cat_box">
                        <a href="">
                            <i class="fa fa-heartbeat"></i>
                            <span>Health</span>
                        </a>
                    </div>
                </div>
                
                
            </div>--->
            
            <!---stores--->
            <hr />
            <h3>Browse Popular Stores</h3>
            <div class="row store_boxes">
                
                <div class="col-sm-2 col-xs-3 cat">
                    <a href="">
                        <div class="cat_box store_box">
                            <img src="https://www.retailmenot.com/thumbs/logos/m/papajohns.com-coupons.jpg?versionId=Dvba8s5Sw4lbbUyGwuttsv2DV0JsoEBs" alt="" class=""/>
                        </div>
                    </a>
                    
                    <a href="">Kohl's</a>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <a href="">
                        <div class="cat_box store_box">
                            <img src="https://www.retailmenot.com/thumbs/logos/m/target.com-coupons.jpg?versionId=_6o_SHwYxr9V5oI0q0OuF0PsYCcvHoHY" alt="" class=""/>
                        </div>
                    </a>
                    
                    <a href="">Kohl's</a>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <a href="">
                        <div class="cat_box store_box">
                            <img src="https://www.retailmenot.com/thumbs/logos/m/amazon.com-coupons.jpg?versionId=mVqAivOAlDgN5imml2AWDbTUqDc7KqEE" alt="" class=""/>
                        </div>
                    </a>
                    
                    <a href="">Kohl's</a>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <a href="">
                        <div class="cat_box store_box">
                            <img src="https://www.retailmenot.com/thumbs/logos/m/pizzahut.com-coupons.jpg?versionId=jmda5dm0aYqawq.Js4N1G.5OP6euNVKj" alt="" class=""/>
                        </div>
                    </a>
                    
                    <a href="">Kohl's</a>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <a href="">
                        <div class="cat_box store_box">
                            <img src="https://www.retailmenot.com/thumbs/logos/m/macys.com-coupons.jpg?versionId=TnUYtciXTj0ZkUVBhcg368zV5i9Yb4oP" alt="" class=""/>
                        </div>
                    </a>
                    
                    <a href="">Kohl's</a>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <a href="">
                        <div class="cat_box store_box">
                            <img src="https://www.retailmenot.com/thumbs/logos/m/victoriassecret.com-coupons.jpg?versionId=M7SV7p90yJ931arrRqcXdV7xXLAsNwAJ" alt="" class=""/>
                        </div>
                    </a>
                    
                    <a href="">Kohl's</a>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <a href="">
                        <div class="cat_box store_box">
                            <img src="https://www.retailmenot.com/thumbs/logos/m/jcpenney.com-coupons.jpg?versionId=yCeAQLs2pt988hy2ZVPZcHIzGHM24YvO" alt="" class=""/>
                        </div>
                    </a>
                    
                    <a href="">Kohl's</a>
                </div>
                
                <div class="col-sm-2 col-xs-3 cat">
                    <a href="">
                        <div class="cat_box store_box">
                            <img src="https://www.retailmenot.com/thumbs/logos/m/kohls.com-coupons.jpg?versionId=w8swZM_JucsI.K_f68fZci4ma8UP52uo" alt="" class=""/>
                        </div>
                    </a>
                    
                    <a href="">Kohl's</a>
                </div>
            </div>
        </div><!---conte--->
    </div><!---department_cats--->
    
    
</section>
<?php include_once 'inc/footer.php';?>