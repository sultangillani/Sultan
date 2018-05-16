<?php include_once 'inc/header.php';?>

<section class="coupons_section_one">
    <div id="conte" class="container">
        <h3>Accessories</h3>
        <div class="row">
            <?php
                $coup_cat_page = "SELECT `wp_terms`.*,`wp_term_taxonomy`.*,`wp_term_relationships`.* FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` IN('stores','coupon_category') AND `wp_terms`.`slug` = '$url[1]'";
                $coup_cat_query = mysqli_query($conn,$coup_cat_page);
                $coup_cat_row = mysqli_fetch_array($coup_cat_query);
                $store_name = $coup_cat_row['name'];
                $coup_cat_id = $coup_cat_row['term_id'];
                $store_des = $coup_cat_row['description'];
                $store_count = $coup_cat_row['count'];
                
                
                //Pagination
                $number_of_posts = 24;
                $page_id = 1;
                $all_posts_query = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('$url[1]')";
                $all_posts_run = mysqli_query($conn,$all_posts_query);
                $all_posts = mysqli_num_rows($all_posts_run);
                $total_pages = ceil($all_posts / $number_of_posts);
                $posts_starts_from = ($page_id - 1) * $number_of_posts;
            ?>
            <button class="act_sm_sidebar"><?php echo $store_count; ?> Offers</button>
            
            <div class="col-sm-3 sidebar">
                <?php include_once 'inc/sidebar.php'; ?>
            </div>
            
            <div class="small-screen-sidebar col-xs-12">
                <?php include_once 'inc/small_screen_sidebar.php';?>
            </div>
            
            <div class="col-sm-9 main-cont">
                <div class="row">
                    
                        <?php
                            //$store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('walmart-coupons') ORDER BY `wp_term_taxonomy`.`count` DESC LIMIT 0,10";
                            $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('$url[1]') ORDER BY `all_posts`.`hits` DESC LIMIT $posts_starts_from,$number_of_posts";
                            $store_coupons_query = mysqli_query($conn,$store_coupons);
                            $store_coupons_count = mysqli_num_rows($store_coupons_query);
                            if(mysqli_num_rows($store_coupons_query) > 0){
                                while($store_coupons_row = mysqli_fetch_array($store_coupons_query)){
                                $scq_id = $store_coupons_row['ID'];
                                $scq_title = $store_coupons_row['post_title'];
                                $scq_post_name = $store_coupons_row['post_name'];
                                $scq_content = $store_coupons_row['post_content'];
                                $scq_meta = $store_coupons_row['meta_value'];
                                $scq_sel_image = $store_coupons_row['select_img'];
                                $scq_guid = $store_coupons_row['guid'];
                                $scq_featured = $store_coupons_row['post_featured_image'];
                                $scq_hits = $store_coupons_row['hits'];
                                $scq_expire = $store_coupons_row['expire_date'];
                                $scq_code = $store_coupons_row['coupon_code'];
                                $scq_code_type = $store_coupons_row['coupon_code_type'];
                                $scq_coupon_type = ucwords(str_ireplace(array('-'),array(' '),$store_coupons_row['coupon_type']));
                                $scq_coupon_type_color = $store_coupons_row['coupon_type_color'];
                                $scq_btn = $store_coupons_row['btn_name'];
                                
                                if($scq_btn == ''){
                                    $button_name = 'Get Deal';
                                }else{
                                    $button_name = $scq_btn;
                                }
                                ?>
                                    <div class="col-xs-4 coupon">
                                        <div class="thumbnail">
                                            <span class="rate"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                                            <img src="https://www.retailmenot.com/thumbs/logos/l/forever21.com-coupons.jpg?versionId=CIXaEUmIoDQI2fZeVzkgZp_TH5Upj5PU" alt="forever21">
                                            <div class="caption">
                                                <span style="color: <?php echo $scq_coupon_type_color; ?>; font-weight:600;"><?php echo $scq_coupon_type;?></span>
                                                <b><a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>"><?php echo excerpt($scq_title, 6); ?></a></b>
                                                <u><?php if($scq_hits > 0){ ?>
                                                    <?php echo $scq_hits; ?> uses today
                                                <?php } ?></u>
                                                
                                            </div>
                                            <div class="text-left">
                                                <span><a href="<?php echo $scq_guid;?>" target="_blank" class="btn btn-primary gd"  id="gd_<?php echo $scq_id; ?>" data="<?php echo $scq_code; ?>" ><?php echo $button_name;?></a></span>
                                            </div>
                                        </div>
                                    </div><!--coupon-->
                                <?php
                                }
                            }
                        ?>
                        
                    
                    
                    <!--<div class="col-xs-4 coupon">
                        <div class="thumbnail">
                            <span class="rate"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                            <img src="https://www.retailmenot.com/thumbs/logos/l/forever21.com-coupons.jpg?versionId=CIXaEUmIoDQI2fZeVzkgZp_TH5Upj5PU" alt="forever21">
                            <div class="caption">
                                <span style="color: #10b48a; font-weight:500;">Code</span>
                                <p>Extra 10% Off Sitewide</p>
                                <u>9.0k uses today</u>
                            </div>
                        </div>
                    </div>coupon-->
                    
                    
                    
                    
                    <div class="post-contain-one">
                        <div class="row post-one">
                            <div class="col-xs-2 post-img-one">
                                <a href=""><img class="img-responsive" src="https://www.retailmenot.com/thumbs/logos/l/internetandtv.att.com-coupons.jpg?versionId=_ODmb35r6kZ28npgXwMvI6Rwq1zHsacE"  alt="AT&amp;T TV + Internet"/></a>
                            </div>
                            <div class="col-xs-10 post-mid">
                                
                                <div class="row post-mid-one">
                                    <div class="col-xs-8 to">
                                        <span style="color: #602d6c; font-weight:600;">Sale</span>
                                        <span> <i>&#x2022;</i> AT&T TV + Internet</span>
                                    </div>
                                    <div class="col-xs-4 text-right r">
                                        <span class="rate"><i class="fa fa-star-o" aria-hidden="true"></i> <u>Save</u></span>
                                    </div>
                                </div>
                                
                                <div class="row post-mid-one">
                                    <div class="col-xs-8 t">
                                        <h3>
                                            <a href="" class="post-one-title">$400 Reward Card + TV &amp; Internet $65/Mo</a>
                                        </h3>
                                        <br />
                                        <span>Sponsored</span>
                                    </div>
                                    <div class="col-xs-4 text-right">
                                        <a href="" class="btn btn-primary gd">Get Deal</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!---pos_conatain_one-->
                    
                </div><!--row-->
                
                <div class="row pagin">
                    <div class="col-xs-12 text-center">
                        <a href=""><i class="fa fa-chevron-left"></i></a><span>1/5</span><a href=""><i class="fa fa-chevron-right"></i></a>
                        <br />
                        <p>102 results</p>
                    </div>
                </div>
            </div><!--main-cont-->
        </div>
        
        <br /><br />
        <div class="row rasf">
            <div class="col-xs-8 ra">
                <h5>Recommended Stores for Accessories</h5><br />
                <ul>
                    <li class=""> <a href="/view/forever21.com" title="forever21.com Coupon Codes">Forever 21</a> </li>
                    <li class=""> <a href="/view/jcpenney.com" title="jcpenney.com Coupon Codes">JCPenney</a> </li>
                    <li class=""> <a href="/view/macys.com" title="macys.com Coupon Codes">Macy's</a> </li>
                    <li class=""> <a href="/view/us.asos.com" title="us.asos.com Coupon Codes">ASOS</a> </li>
                    <li class=""> <a href="/view/bonton.com" title="bonton.com Coupon Codes">Bon Ton</a> </li>
                    <li class=""> <a href="/view/jomashop.com" title="jomashop.com Coupon Codes">Jomashop</a> </li>
                    <li class=""> <a href="/view/mvmtwatches.com" title="mvmtwatches.com Coupon Codes">MVMT Watches</a> </li>
                    <li class=""> <a href="/view/lids.com" title="lids.com Coupon Codes">Lids</a> </li>
                    <li class=""> <a href="/view/fossil.com" title="fossil.com Coupon Codes">Fossil</a> </li>
                    <li class=""> <a href="/view/coach.com" title="coach.com Coupon Codes">Coach</a> </li>
                    <li class=""> <a href="/view/zales.com" title="zales.com Coupon Codes">Zales Jewelry</a> </li>
                    <li class=""> <a href="/view/nordstromrack.com" title="nordstromrack.com Coupon Codes">Nordstrom Rack</a> </li>
                    <li class=""> <a href="/view/sunglasshut.com" title="sunglasshut.com Coupon Codes">Sunglass Hut</a> </li>
                    <li class=""> <a href="/view/danielwellington.com" title="danielwellington.com Coupon Codes">Daniel Wellington</a> </li>
                    <li class=""> <a href="/view/claires.com" title="claires.com Coupon Codes">Claire's</a> </li>
                </ul>
            </div>
            <div class="col-xs-4 sf">
                <h5>People Also Searched For</h5><br />
                <ul>
                    <li class=""> <a href="/coupons/clothing" title="Clothing Coupons">Clothing</a> </li>
                    <li class=""> <a href="/coupons/jewelry" title="Jewelry Coupons">Jewelry</a> </li>
                    <li class=""> <a href="/coupons/watches" title="Watches Coupons">Watches</a> </li>
                    <li class=""> <a href="/coupons/luggage" title="Luggage Coupons">Luggage</a> </li>
                    <li class=""> <a href="/coupons/bags" title="Bags Coupons">Bags</a> </li>
                    <li class=""> <a href="/coupons/ties" title="Ties Coupons">Ties</a> </li>
                    <li class=""> <a href="/coupons/lunchbox" title="Lunchbox Coupons">Lunchbox</a> </li>
                    <li class=""> <a href="/coupons/gloves" title="Gloves Coupons">Gloves</a> </li>
                    <li class=""> <a href="/coupons/headwear" title="Headwear Coupons">Headwear</a> </li>
                    <li class=""> <a href="/coupons/wallets" title="Wallets Coupons">Wallets</a> </li>
                </ul>
                
            </div>
        </div>
        
    </div>
</section>

<?php include_once 'inc/footer.php';?>
