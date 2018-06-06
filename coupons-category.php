<?php include_once 'inc/header.php';?>

<section class="coupons_section_one">
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
    <div id="conte" class="container">
        <h3><?php echo $store_name; ?></h3>
        <div class="row">
            
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
                            $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('$url[1]') ORDER BY `all_posts`.`hits` DESC, `all_posts`.`ID` DESC LIMIT $posts_starts_from,$number_of_posts";
                            $store_coupons_query = mysqli_query($conn,$store_coupons);
                            $store_coupons_count = mysqli_num_rows($store_coupons_query);
                            if(mysqli_num_rows($store_coupons_query) > 0){
                                while($store_coupons_row = mysqli_fetch_array($store_coupons_query)){
                                $scq_id = $store_coupons_row['ID'];
                                $scq_title = $store_coupons_row['post_title'];
                                $scq_post_name = $store_coupons_row['post_name'];
                                $scq_content = $store_coupons_row['post_content'];
                                
                                
                                //Meta Value
                                $cat_meta_query = "SELECT `wp_term_relationships`.*,`wp_term_taxonomy`.*,`wp_clpr_storesmeta`.* FROM `wp_term_relationships`,`wp_term_taxonomy`,`wp_clpr_storesmeta` WHERE `object_id` = $scq_id AND `wp_term_taxonomy`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_clpr_storesmeta`.`stores_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_clpr_storesmeta`.`meta_key` = 'clpr_store_image_id'";
                                $cat_meta_result = mysqli_query($conn,$cat_meta_query);
                                if(mysqli_num_rows($cat_meta_result) > 0){
                                    $cat_meta_row = mysqli_fetch_assoc($cat_meta_result);
                                    $scq_meta = $cat_meta_row['meta_value'];
                                }
                                
                                
                                
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
                                    <div class="col-xs-4 coupon cat_coupr_<?php echo $scq_id; ?>">
                                        <div class="thumbnail">
                                            <span class="rate"><i class="fa fa-star-o" aria-hidden="true"></i></span>
                                            <?php
                                                /**/if($scq_sel_image == 'featured_image'){
                                                    //Second condition
                                                    if(!empty($scq_featured)){
                                                        ?>
                                                            <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"><img src="<?php echo $scq_featured;?>" alt="4" class="img-responsive"/></a>
                                                        <?php
                                                    }else{
                                                        $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $scq_meta";
                                                        $sub_sql_query = mysqli_query($conn,$sub_sql);
                                                        $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                                        $store_img_url = $sub_sql_row['guid'];
                                                        ?>
                                                            <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                                        <?php
                                                    }
                                                    
                                                }else if($scq_sel_image == 'store_image'){
                                                    $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $scq_meta";
                                                    $sub_sql_query = mysqli_query($conn,$sub_sql);
                                                    $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                                    $store_img_url = $sub_sql_row['guid'];
                                                    ?>
                                                        <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                                    <?php
                                                }
                                            ?>
                                            <div class="caption">
                                                <span style="color: <?php echo $scq_coupon_type_color; ?>; font-weight:600;"><?php echo $scq_coupon_type;?></span>
                                                <b><a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank" ><?php echo excerpt($scq_title, 6); ?></a></b>
                                                <?php
                                                if ($scq_hits > 999 && $scq_hits <= 999999) {
                                                    $result = floor($scq_hits / 1000) . 'K';
                                                } elseif ($scq_hits > 999999) {
                                                    $result = floor($scq_hits / 1000000) . 'M';
                                                } else {
                                                    $result = $scq_hits;
                                                }
                                                ?>
                                                
                                                <u><?php if($result > 0){ ?>
                                                    <?php echo $result; ?> uses today
                                                <?php } ?></u>
                                                
                                            </div>
                                            <div class="text-left">
                                                <span data-toggle="modal" data-target="#copon_<?php echo $scq_id;?>" ><a href="<?php echo $scq_guid;?>" target="_blank" class="btn btn-primary gd"  id="gd_<?php echo $scq_id; ?>" data="<?php echo $scq_code; ?>" ><?php echo $button_name;?></a></span>
                                            </div>
                                        </div>
                                    </div><!--coupon-->
                                    
                                    <!-- Modal  tabindex="-1" -->
                                    <div class="modal fade" id="copon_<?php echo $scq_id;?>">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel"><?php echo $scq_title; ?></h4>
                                          </div>
                                          <div class="modal-body row">
                                            
                                            <div class="col-sm-2 col-xs-3 text-center mod_img">
                                                <?php
                                                if($scq_sel_image == 'featured_image'){
                                                    //Second condition
                                                    if(!empty($scq_featured)){
                                                        ?>
                                                            <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"><img src="<?php echo $scq_featured;?>" alt="4" class="img-responsive"/></a>
                                                        <?php
                                                    }else{
                                                        $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $scq_meta";
                                                        $sub_sql_query = mysqli_query($conn,$sub_sql);
                                                        $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                                        $store_img_url = $sub_sql_row['guid'];
                                                        ?>
                                                            <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                                        <?php
                                                    }
                                                    
                                                }else if($scq_sel_image == 'store_image'){
                                                    $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $scq_meta";
                                                    $sub_sql_query = mysqli_query($conn,$sub_sql);
                                                    $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                                    $store_img_url = $sub_sql_row['guid'];
                                                    ?>
                                                        <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="col-sm-7 col-xs-5 mod_des">
                                                <?php echo excerpt($scq_content,25);?>
                                            </div>
                                            <div class="col-sm-3 col-xs-4 mod_code">
                                                <?php
                                                //SELECT * FROM `all_posts` WHERE `coupon_code` NOT LIKE '%Coupon%' AND `coupon_code` NOT LIKE '%Deal%' AND `coupon_code` != ''
                                                if($scq_code_type == 'real_code'){
                                                ?>
                                                    <input type="text" disabled="disabled" class="form-control codee_<?php echo $scq_id; ?>" value="<?php echo $scq_code; ?>"/>
                                                <?php
                                                }else if($scq_code == ''){
                                                    echo "<span>No Coupon Code Required</span>";
                                                }else{
                                                    echo "<span>$scq_code</span>";
                                                }
                                                ?>
                                                
                                            </div>
                                            
                                          </div>
                                          
                                           <?php
                                                if($scq_code != 'No Coupon Code Required' && $scq_code != 'Deal Activated' && $scq_code != 'Coupon Activated'){
                                                    ?>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-primary copy_<?php echo $scq_id; ?>">Copy Code</button>
                                                        <script type="text/javascript">
                                                            $(document).ready(function(){
                                                                function copyToClipboard(element) {
                                                                    var $temp = $("<input>");
                                                                    $("body").append($temp);
                                                                    $temp.val($(element).val()).select();
                                                                    document.execCommand("copy");
                                                                    $temp.remove();
                                                                }
                                                                $('.copy_<?php echo $scq_id; ?>').click(function(){
                                                                    copyToClipboard('.codee_<?php echo $scq_id; ?>');
                                                                });
                                                            });
                                                            
                                                        </script>
                                                    </div>
                                                    <?php
                                                }
                                            ?>
                                            
                                        </div>
                                      </div>
                                    </div>
                                    <!--end of modal-->
                                    
                                    <div class="post-contain-one">
                                        <div class="row post-one poco_<?php echo $scq_id;?>">
                                            <div class="col-xs-2 post-img-one">
                                                <?php
                                                    if($scq_sel_image == 'featured_image'){
                                                        //Second condition
                                                        if(!empty($scq_featured)){
                                                            ?>
                                                                <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"><img src="<?php echo $scq_featured;?>" alt="4" class="img-responsive"/></a>
                                                            <?php
                                                        }else{
                                                            $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $scq_meta";
                                                            $sub_sql_query = mysqli_query($conn,$sub_sql);
                                                            $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                                            $store_img_url = $sub_sql_row['guid'];
                                                            ?>
                                                                <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                                            <?php
                                                        }
                                                        
                                                    }else if($scq_sel_image == 'store_image'){
                                                        $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $scq_meta";
                                                        $sub_sql_query = mysqli_query($conn,$sub_sql);
                                                        $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                                        $store_img_url = $sub_sql_row['guid'];
                                                        ?>
                                                            <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                                        <?php
                                                    }
                                                ?>
                                            </div>
                                            <div class="col-xs-10 post-mid">
                                                
                                                <div class="row post-mid-one">
                                                    <div class="col-xs-8 to">
                                                        <span style="color: <?php echo $scq_coupon_type_color; ?>; font-weight:600;"><?php echo $scq_coupon_type; ?></span>
                                                        <?php
                                                        //coupont-type Values
                                                        $coupon_type_query = "SELECT `wp_terms`.*,`wp_term_taxonomy`.*,`wp_term_relationships`.*,`all_posts`.* FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`all_posts` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` IN('coupon_type','stores') AND `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `all_posts`.`ID` = $scq_id";
                                                        $coupon_type_result = mysqli_query($conn,$coupon_type_query);
                                                        if(mysqli_num_rows($coupon_type_result) > 0){
                                                            while($coupon_type_row = mysqli_fetch_array($coupon_type_result)){
                                                                $ct_tax = $coupon_type_row['taxonomy'];
                                                                $ct_name = $coupon_type_row['name'];
                                                                if($ct_tax == 'stores'){
                                                                    ?>
                                                                        <span> <i>&#x2022;</i> <?php echo $ct_name; ?></span>
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        
                                                        
                                                    </div>
                                                    <div class="col-xs-4 text-right r">
                                                        <span class="rate"><i class="fa fa-star-o" aria-hidden="true"></i> <u>Save</u></span>
                                                    </div>
                                                </div>
                                                
                                                <div class="row post-mid-one">
                                                    <div class="col-xs-8 t">
                                                        <h3>
                                                            <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank" class="post-one-title"><?php echo $scq_title?></a>
                                                        </h3>
                                                        <br />
                                                        
                                                        <?php
                                                        if ($scq_hits > 999 && $scq_hits <= 999999) {
                                                            $result = floor($scq_hits / 1000) . 'K';
                                                        } elseif ($scq_hits > 999999) {
                                                            $result = floor($scq_hits / 1000000) . 'M';
                                                        } else {
                                                            $result = $scq_hits;
                                                        }
                                                        /*
                                                            display: block;
                                                            width: 90%;
                                                            padding: 0;
                                                            height: auto;
                                                            background: none;
                                                            border: 0;
                                                            margin: 0 auto;
                                                        */
                                                        ?>
                                                        <?php if($scq_hits > 0){?>
                                                            <span><?php echo $result; ?> Viewed</span>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="col-xs-4 buttler">
                                                        <span data-toggle="modal" data-target="#copon_<?php echo $scq_id;?>" style="display:block;"><a href="<?php echo $scq_guid;?>" target="_blank" class="btn btn-primary gd" id="gd_<?php echo $scq_id; ?>" data="<?php echo $scq_code; ?>" ><?php echo $button_name;?></a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--poco-->
                                        
                                        
                                        <div class="row post-one-details">
                                            <div class="col-xs-12">
                                                <a class="tabsi_tog">Show Details <i class="fa fa-chevron-up chvrn"></i></a>
                                                
                                                <div class="row tabsi">
                                                    <?php
                                                        $tags_query = "SELECT `wp_terms`.`term_id`,`wp_term_taxonomy`.`term_id`,`wp_terms`.`name`,`wp_term_taxonomy`.`taxonomy`,`wp_term_relationships`.`object_id` FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_tag' AND `wp_term_relationships`.`object_id` = $scq_id";
                                                        $tags_result = mysqli_query($conn,$tags_query);
                                                    ?>
                                                    <div class="col-xs-12">
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            <?php
                                                                if(mysqli_num_rows($tags_result) > 0){
                                                            ?>
                                                            <li role="presentation"><a href="#exclusions_<?php echo $scq_id;?>" aria-controls="exclusions_<?php echo $scq_id;?>" role="tab" data-toggle="tab">Exclusions</a></li>
                                                            <?php
                                                                }
                                                            ?>
                                                            <li role="presentation"><a href="#details_<?php echo $scq_id;?>" aria-controls="details_<?php echo $scq_id;?>" role="tab" data-toggle="tab">Details</a></li>
                                                            <?php
                                                            $comment_query_count = "SELECT * FROM `wp_comments` WHERE `comment_post_ID` = $scq_id AND `comment_approved` = 'approved' ORDER BY `comment_ID` DESC";
                                                            $comment_result_count = mysqli_query($conn,$comment_query_count);
                                                            ?>
                                                            <li role="presentation"><a href="#comments_<?php echo $scq_id;?>" aria-controls="comments_<?php echo $scq_id;?>" role="tab" data-toggle="tab"><?php if(mysqli_num_rows($comment_result_count) != 0){echo mysqli_num_rows($comment_result_count);}?> Comments</a></li>
                                                        </ul>
                                                        
                                                        <!-- Tab panes -->
                                                        <div class="tab-content">
                                                            <?php
                                                            if(mysqli_num_rows($tags_result) > 0){
                                                            ?>
                                                            <div role="tabpanel" class="tab-pane" id="exclusions_<?php echo $scq_id;?>">
                                                                <?php
                                                                    $tags_query = "SELECT `wp_terms`.`term_id`,`wp_term_taxonomy`.`term_id`,`wp_terms`.`name`,`wp_term_taxonomy`.`taxonomy`,`wp_term_relationships`.`object_id` FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_tag' AND `wp_term_relationships`.`object_id` = $scq_id";
                                                                    $tags_result = mysqli_query($conn,$tags_query);
                                                                    if(mysqli_num_rows($tags_result) > 0){
                                                                ?>
                                                                        <p class="store_tags"><strong>Tags:</strong>
                                                                        <?php
                                                                        $i=1;
                                                                        while($tags_row = mysqli_fetch_array($tags_result)){
                                                                            $tags_name = $tags_row['name'];
                                                                            $tags_id = $tags_row['term_id'];
                                                                            if($i < mysqli_num_rows($tags_result)){
                                                                            ?>
                                                                                <a href="http://localhost/series/retail_pro/tags.php?tag=<?php echo $tags_id; ?>"><?php echo $tags_name; ?></a>,
                                                                            <?php
                                                                                $i++;
                                                                            }else{
                                                                            ?>
                                                                                <a href="http://localhost/series/retail_pro/tags.php?tag=<?php echo $tags_id; ?>"><?php echo $tags_name; ?></a>
                                                                            <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                        </p>
                                                                <?php
                                                                    }
                                                                ?>  
                                                            </div>
                                                            <?php
                                                            }
                                                            ?>
                                                            <div role="tabpanel" class="tab-pane" id="details_<?php echo $scq_id;?>">
                                                                <p><strong>Expires:</strong>&nbsp;&nbsp;<?php echo date_format(date_create($scq_expire)," d | M | Y");?></p>
                                                                <p><strong>Details:</strong>&nbsp;<?php echo $scq_content; ?></p>    
                                                            </div>
                                                            <div role="tabpanel" class="tab-pane" id="comments_<?php echo $scq_id;?>">
                                                                <?php
                                                                    $comment_query = "SELECT * FROM `wp_comments` WHERE `comment_post_ID` = $scq_id AND `comment_approved` = 'approved' ORDER BY `comment_ID` DESC";
                                                                    $comment_result = mysqli_query($conn,$comment_query);
                                                                ?>
                                                                <div class="msg"></div>
                                                                <div class="comment-box">
                                                                    
                                                                    <form action="comment.php" method="post">
                                                                        
                                                                        <div class="form-group">
                                                                            <label for="firstname">First Name(optional)</label>
                                                                            <input type="text" class="form-control firstname" id="firstname" name="firstname" placeholder="First Name(optional)" value="<?php echo (isset($fname) && $com_post_id == $scq_id ? $fname : '');?>"/>
                                                                            <span class="comment_error"></span>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="add_comment">Add a Comment*</label>
                                                                            <textarea class="form-control add_comment" rows="3" id="add-comment" name="add_comment" placeholder="Add a Comment..."><?php echo (isset($adcom) && $com_post_id == $scq_id ? $adcom : '');?></textarea>
                                                                            <span class="comment_error"></span>
                                                                        </div>
                                                                        <input type="hidden" value="<?php echo $scq_id; ?>" name="com_post_id" class="com_post_id" id="<?php echo path_url('/retail_pro');?>"/>
                                                                        <input type="button" name="com_submit" value="Post Comment" class="com-sub"/>
                                                                    </form>
                                                                </div>
                                                                <div class="client-comments">
                                                                    <?php
                                                                        if(mysqli_num_rows($comment_result) > 0){
                                                                            while($comment_row = mysqli_fetch_array($comment_result)){
                                                                                $comment_id = $comment_row['comment_ID'];
                                                                                $comment_author = $comment_row['comment_author'];
                                                                                $comment_content = $comment_row['comment_content'];
                                                                                ?>
                                                                                    <div class="comm row">
                                                                                        <div class="col-xs-1 icon">
                                                                                            <i class="fa fa-comment"></i>
                                                                                        </div>
                                                                                        
                                                                                        <div class="col-xs-11 com-right comment_<?php echo $comment_id; ?>">
                                                                                            <div class="com-text"><?php echo $comment_content; ?></div>
                                                                                            <span class="by">by <u><?php echo $comment_author; ?></u></span>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php
                                                                            }
                                                                        }
                                                                    ?>
                                                                </div>
                                                                
                                                                <a href="" class="all_comm_bt" id="show_comm">Show All Comments</a>
                                                                <a href="" class="all_comm_bt" id="hide_comm">Show Less Comments</a>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!---pos_conatain_one-->
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
                    
                </div><!--row-->
                
                <div class="row pagin">
                    <div class="col-xs-12 text-center">
                        
                        <?php
                        if($page_id <= 1){
                            ?>
                            <u><i class="fa fa-chevron-left"></i></u>
                            <?php
                        }else{
                        ?>
                            <button class="prev_btn"><i class="fa fa-chevron-left"></i></button>
                        <?php
                        }
                        ?>
                        <span><?php echo $page_id; ?>/<?php echo $total_pages; ?></span>
                        
                        <?php
                        if($page_id >= $total_pages){
                            ?>
                            <u><i class="fa fa-chevron-right"></i></u>
                            <?php
                        }else{
                        ?>
                            <button class="next_btn"><i class="fa fa-chevron-right"></i></button>
                        <?php
                        }
                        ?>
                        <br />
                        <p><?php echo $all_posts; ?> results</p>
                    </div>
                    
                    <script type="text/javascript">
                        $(document).ready(function(){
                            
                            //Filters
                            var ct = [];
                            var dt = [];
                            var cat = [];
                            var check_id = [0];
                            var pathname = $('.kbc_uri').val();
                            var us = $('.kbc_uri').attr('placeholder');
                            var store_id = $('.kbc_uri').attr('title');
                            
                            var gd_arr = [];
                            
                            $('.gd').click(function(){
                                
                                var data_text = $(this).attr('data');
                                var gd_id = '#' + $(this).attr('id');
                                gd_arr.push(gd_id);
                                $('.main-cont').find(gd_id).each(function(){
                                    $(this).text(data_text);
                                    $(this).css({'color': '#4a4a4a', 'background': '#f5f4f4', 'border': '1px solid #e5e5e5'});
                                });
                            });
                            
                            $('.ct input[type="checkbox"]').each(function(){
                                
                               
                                $(this).click(function(){
                                    
                                    
                                    if ($(this).attr('name') == 'ct') { //CT
                                        var ri = $(this).val();
                                        var ind = ct.indexOf(ri);
                                        if ($(this).prop("checked")) {
                                            ct.push(ri);
                                        }else{
                                            ct.splice(ind,1);
                                        }
                                    }else if ($(this).attr('name') == 'dt') { //DT
                                        var ri = $(this).val();
                                        var ind = dt.indexOf(ri);
                                        if ($(this).prop("checked")) {
                                            dt.push(ri);
                                        }else{
                                            dt.splice(ind,1);
                                        }
                                    }else if ($(this).attr('name') == 'store') { //Cat
                                        var ri = $(this).val();
                                        var ind = cat.indexOf(ri);
                                        if ($(this).prop("checked")) {
                                            cat.push(ri);
                                        }else{
                                            cat.splice(ind,1);
                                        }
                                    }
                                    
                                    $('.overlayyy').css('display','block');
                                    
                                    pathname = pathname + '/filter.php';
                                    $.ajax({
                                        method: 'POST',
                                        url: pathname,
                                        data: {action: 'coupons_category', checked: ct, dt: dt,cat: cat, check_id: check_id, usp: us, store_id:store_id, gd_arr: gd_arr},
                                        success: function(result){
                                            $('.main-cont').html(result);
                                        }
                                    });
                                    
                                });
                                
                            });
                            
                            $('.reset').click(function(){
                                
                                $('.overlayyy').css('display','block');
                                
                                ct = [];
                                dt= [];
                                cat = [];
                                $('.ct input[type="checkbox"]').each(function(){
                                    $(this).prop("checked",false);
                                });
                                pathname = pathname + '/filter.php';
                                $.ajax({
                                    method: 'POST',
                                    url: pathname,
                                    data: {action: 'coupons_category', checked: ct, dt: dt,cat: cat, check_id: check_id, usp: us, store_id:store_id, gd_arr: gd_arr},
                                    success: function(result){
                                        $('.main-cont').html(result);
                                        $('.fil_app > u').text('No ');
                                    }
                                });
                            });
                            
                            $('.next_btn').click(function(){
                                
                                $('.overlayyy').css('display','block');
                                
                                var page_id = <?php echo $page_id; ?>;
                                var total_posts = <?php echo $all_posts; ?>;
                                page_id = page_id + 1;
                                pathname = pathname + '/filter.php';
                                $.ajax({
                                    method: 'POST',
                                    url: pathname,
                                    data: {action: 'coupons_category', page_id: page_id, usp:us, total_posts: total_posts, gd_arr: gd_arr},
                                    success: function(result){
                                        $('.main-cont').html(result);
                                    }
                                });
                            });
                            
                            $('.prev_btn').click(function(){
                                
                                $('.overlayyy').css('display','block');
                                
                                var page_id = <?php echo $page_id; ?>;
                                var total_posts = <?php echo $all_posts; ?>;
                                page_id = page_id - 1;
                                pathname = pathname + '/filter.php';
                                $.ajax({
                                    method: 'POST',
                                    url: pathname,
                                    data: {action: 'coupons_category', page_id: page_id, usp: us, total_posts: total_posts, gd_arr: gd_arr},
                                    success: function(result){
                                        $('.main-cont').html(result);
                                    }
                                });
                            });
                            
                        });
                    </script>
                    
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
