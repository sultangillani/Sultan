<?php

include 'functions.php';

function populer(){
    error_reporting(0);
    global $conn;
    $url = mysqli_real_escape_string($conn,htmlentities($_POST['usp'])); //Store Name
    $store_id = mysqli_real_escape_string($conn,htmlentities($_POST['store_id'])); //Store Id
    //For id
    $check_id = array_unique($_POST['check_id']);
    unset($check_id[0]);
    array_push($check_id,$store_id);
    
    $checked = array_unique($_POST['checked']);
    $discount = array_unique($_POST['dt']);
    $categories = array_unique($_POST['cat']);
    $gd_arr = array_unique($_POST['gd_arr']);
    $gd_arr_id = array_unique($_POST['gd_arr_id']);
    
    $number_of_posts = 10;
    $page_id = $_POST['page_id'];
    if($page_id <= 0){
        $page_id = 1;
    }
    ?>
    
    <!-- Modal -->
    <div class="modal fade" id="store_modal_<?php echo $store_id; ?>" role="dialog" aria-labelledby="myModalLabel">
        <?php
            $store_page = "SELECT `wp_terms`.*,`wp_term_taxonomy`.*,`wp_term_relationships`.* FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_terms`.`slug` = '$url'";
            $store_page_query = mysqli_query($conn,$store_page);
            $store_page_row = mysqli_fetch_array($store_page_query);
            $store_name = $store_page_row['name'];
            $store_id = $store_page_row['term_id'];
            $store_des = $store_page_row['description'];
        ?>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $store_name; ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php
                            $store_modal_img = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.`taxonomy`, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_value` = `all_posts`.`ID` AND `wp_terms`.`term_id` = $store_id GROUP BY `wp_terms`.`term_id`";
                            $store_modal_query = mysqli_query($conn,$store_modal_img);
                            $store_modal_row = mysqli_fetch_assoc($store_modal_query);
                            $store_modal_guid = $store_modal_row['guid'];
                            $store_modal_id = $store_modal_row['ID'];
                        ?>
                        <div class="col-xs-3 store_modal_img">
                            <img src="<?php echo $store_modal_guid; ?>" alt="store_modal_<?php echo $store_modal_row['ID']; ?>" class="img-responsive"/>
                        </div>
                        <div class="col-xs-9 store_modal_cont">
                            <div class="subs_msg">
                                
                            </div>
                            <?php echo $store_des; ?>
                            <i class="fa fa-arrow-circle-down"></i><br />
                            <b>For latest updates and info of this store please Subscribe this store.</b><br />
                            <div class="input-group">
                                <span class="input-group-addon" id="email-addon1"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control store_subs_email" placeholder="Email" aria-describedby="email-addon1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary store_subs">Send</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        
        $(document).ready(function(){
            function validateEmail(email) {
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                return emailReg.test(email);
            }
            
            
            $('.store_subs').click(function(){
                var store_subs_email = $('.store_subs_email').val();
                var store_subs_id = <?php echo $store_id; ?>;
                var pathname = $('.kbc_uri').val();
                pathname = pathname + '/filter.php';
                if (validateEmail(store_subs_email)) {
                    $.ajax({
                        method: 'POST',
                        url: pathname,
                        data: {action: 'store_subscribtion', store_subs_email: store_subs_email, store_subs_id: store_subs_id},
                        success: function(result){
                            $('.subs_msg').html(result);
                            $('.store_subs_email').val('');
                        }
                    });
                }else{
                    var invalid_error = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Your email is Incorrect.</div>';
                    $('.subs_msg').html(invalid_error);
                }
                
                setTimeout(function(){
                    $('.subs_msg .alert').fadeOut(); 
                },2000);
            });    
        });
    </script>
    
    <?php
    //$all_posts_query = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('$url')";
    
    
    $stre_img = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.`taxonomy`, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_value` = `all_posts`.`ID` AND `wp_terms`.`slug` = '$url' GROUP BY `wp_terms`.`term_id`";
    $stre_query = mysqli_query($conn,$stre_img);
    $stre_row = mysqli_fetch_array($stre_query);
    $stre_name = $stre_row['name'];
    $stre_guid = $stre_row['guid'];
    ?>
    <div class="small_store_imgz">
        <div class="st_img">
            <?php
                $stre_url = "SELECT `wp_clpr_storesmeta`.* FROM `wp_clpr_storesmeta` WHERE `wp_clpr_storesmeta`.`meta_key` = 'clpr_store_url' AND `wp_clpr_storesmeta`.`stores_id` = $store_id";
                $stre_url_q = mysqli_query($conn,$stre_url);
                $stre_url_row = mysqli_fetch_array($stre_url_q);
                $stre_permalink = $stre_url_row['meta_value'];
            ?>
            <a href="<?php echo $stre_permalink; ?>"><img src="<?php echo $stre_guid; ?>" alt="<?php echo $store_name; ?>" class="img-responsive"/></a>
        </div>
        <div class="st_fav">
            <h3 class="store_title"><?php echo $store_name;?></h3>
            <a href=""><i class="fa fa-heart"></i> <span>Add Favorite</span></a>
        </div>
    </div>
    
    
    <h3 class="store_title"><?php echo $stre_name;?></h3>
    <ul class="nav nav-tabs big_post" role="tablist">
        <li class="sort">Sort by: </li>
        <li role="presentation" class="active"><a href="#popularity" aria-controls="popularity" role="tab" data-toggle="tab">Popularity</a></li>
        <li role="presentation"><a href="#newest" aria-controls="newest" role="tab" data-toggle="tab">Newest</a></li>
        <li role="presentation"><a href="#ending" aria-controls="ending" role="tab" data-toggle="tab">Ending</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="popularity">
            
            <?php
            $dt = implode(',',$discount);
            $dt = str_ireplace(',',"','",$dt);
            
            //Ct
            $ct = implode(',',$checked);
            $ct = str_ireplace(',',"','",$ct);
            
            //Cat
            $cat = implode(',',$categories);
            $cat = str_ireplace(',',"','",$cat);
            
    
            $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` = '$url'";
            if(!empty($categories)){
                $stor_john_arr = [];
                $cat_john_arr = [];
                $stor_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` = '$url'";
                $stor_john = mysqli_query($conn,$stor_coupons);
                if(mysqli_num_rows($stor_john) > 0){
                    while($stor_john_row = mysqli_fetch_assoc($stor_john)){
                        $stor_john_id = $stor_john_row['ID'];
                        array_push($stor_john_arr,$stor_john_id);
                    }
                }
                //$stor_john_arr_id = implode(',',$stor_john_arr);
                $cat_coupons = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' AND `wp_terms`.`slug` IN('$cat')";
                $cat_john = mysqli_query($conn,$cat_coupons);
                if(mysqli_num_rows($cat_john) > 0){
                    while($cat_john_row = mysqli_fetch_assoc($cat_john)){
                        $cat_john_id = $cat_john_row['ID'];
                        array_push($cat_john_arr,$cat_john_id);
                    }
                }
                
                $store_coupons_arr = array_intersect($stor_john_arr,$cat_john_arr);
                $store_coupons_arr_imp = implode(',', $store_coupons_arr);
                
                $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` = '$url' AND `all_posts`.`ID` IN($store_coupons_arr_imp)";
            }
            
            if(count($checked) > 0){
                
                $store_coupons .= "AND `all_posts`.`coupon_type` IN('".$ct."')";            
            }
            if(count($discount) > 0){
                $store_coupons .= "AND `all_posts`.`discount_type` IN('".$dt."')";
            }
            
            $all_posts_run = mysqli_query($conn,$store_coupons);
            $all_posts = mysqli_num_rows($all_posts_run);
            $total_pages = ceil($all_posts / $number_of_posts);
            $posts_starts_from = ($page_id - 1) * $number_of_posts;
            
            $store_coupons .= "ORDER BY `all_posts`.`hits` DESC, `all_posts`.`ID` DESC LIMIT $posts_starts_from,$number_of_posts";
            
            $store_coupons_query = mysqli_query($conn,$store_coupons);
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
                                            <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"class="post-one-title"><?php echo $scq_title?></a>
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
                                    <div class="col-xs-4 text-right">
                                        <span data-toggle="modal" data-target="#copon_<?php echo $scq_id;?>" style="display:block;"><a href="<?php echo $scq_guid;?>" target="_blank" class="btn btn-primary gd" id="gd_<?php echo $scq_id; ?>" data="<?php echo $scq_code; ?>" ><?php echo $button_name;?></a></span>
                                    </div>
                                </div>
                            </div>
                        </div><!--poco-->
                        
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
                                                <a href="<?php echo $scq_guid;?>" target="_blank"><img src="<?php echo $scq_featured;?>" alt="4" class="img-responsive"/></a>
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
        </div><!--popularity-->
        
        <div role="tabpanel" class="tab-pane" id="newest">
            <?php
            $dt = implode(',',$discount);
            $dt = str_ireplace(',',"','",$dt);
            
            //Ct
            $ct = implode(',',$checked);
            $ct = str_ireplace(',',"','",$ct);
            
            //Cat
            $cat = implode(',',$categories);
            $cat = str_ireplace(',',"','",$cat);
            
    
            $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` = '$url'";
            if(!empty($categories)){
                $stor_john_arr = [];
                $cat_john_arr = [];
                $stor_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` = '$url'";
                $stor_john = mysqli_query($conn,$stor_coupons);
                if(mysqli_num_rows($stor_john) > 0){
                    while($stor_john_row = mysqli_fetch_assoc($stor_john)){
                        $stor_john_id = $stor_john_row['ID'];
                        array_push($stor_john_arr,$stor_john_id);
                    }
                }
                echo '<br />';
                //$stor_john_arr_id = implode(',',$stor_john_arr);
                $cat_coupons = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' AND `wp_terms`.`slug` IN('$cat')";
                $cat_john = mysqli_query($conn,$cat_coupons);
                if(mysqli_num_rows($cat_john) > 0){
                    while($cat_john_row = mysqli_fetch_assoc($cat_john)){
                        $cat_john_id = $cat_john_row['ID'];
                        array_push($cat_john_arr,$cat_john_id);
                    }
                }
                
                $store_coupons_arr = array_intersect($stor_john_arr,$cat_john_arr);
                $store_coupons_arr_imp = implode(',', $store_coupons_arr);
                
                $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` = '$url' AND `all_posts`.`ID` IN($store_coupons_arr_imp)";
            }
            
            if(count($checked) > 0){
                
                $store_coupons .= "AND `all_posts`.`coupon_type` IN('".$ct."')";            
            }
            if(count($discount) > 0){
                $store_coupons .= "AND `all_posts`.`discount_type` IN('".$dt."')";
            }
            
            $store_coupons .= "ORDER BY `all_posts`.`post_date` DESC, `all_posts`.`ID` DESC LIMIT $posts_starts_from,$number_of_posts";
            
            $store_coupons_query = mysqli_query($conn,$store_coupons);
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
                                            <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"class="post-one-title"><?php echo $scq_title?></a>
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
                                    <div class="col-xs-4 text-right">
                                        <span data-toggle="modal" data-target="#copone_<?php echo $scq_id;?>" style="display:block;"><a href="<?php echo $scq_guid;?>" target="_blank" class="btn btn-primary gd" id="gd_<?php echo $scq_id; ?>" data="<?php echo $scq_code; ?>" ><?php echo $button_name;?></a></span>
                                    </div>
                                </div>
                            </div>
                        </div><!--poco-->
                        
                        <!-- Modal  tabindex="-1" -->
                        <div class="modal fade" id="copone_<?php echo $scq_id;?>">
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
                                            <a href="<?php echo $scq_guid;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
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
                                            <li role="presentation"><a href="#exclusionss_<?php echo $scq_id;?>" aria-controls="exclusionss_<?php echo $scq_id;?>" role="tab" data-toggle="tab">Exclusions</a></li>
                                            <?php
                                                }
                                            ?>
                                            <li role="presentation"><a href="#detailss_<?php echo $scq_id;?>" aria-controls="detailss_<?php echo $scq_id;?>" role="tab" data-toggle="tab">Details</a></li>
                                            <?php
                                            $comment_query_count = "SELECT * FROM `wp_comments` WHERE `comment_post_ID` = $scq_id AND `comment_approved` = 'approved' ORDER BY `comment_ID` DESC";
                                            $comment_result_count = mysqli_query($conn,$comment_query_count);
                                            ?>
                                            <li role="presentation"><a href="#commentss_<?php echo $scq_id;?>" aria-controls="commentss_<?php echo $scq_id;?>" role="tab" data-toggle="tab"><?php if(mysqli_num_rows($comment_result_count) != 0){echo mysqli_num_rows($comment_result_count);}?> Comments</a></li>
                                        </ul>
                                        
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <?php
                                            if(mysqli_num_rows($tags_result) > 0){
                                            ?>
                                            <div role="tabpanel" class="tab-pane" id="exclusionss_<?php echo $scq_id;?>">
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
                                            <div role="tabpanel" class="tab-pane" id="detailss_<?php echo $scq_id;?>">
                                                <p><strong>Expires:</strong>&nbsp;&nbsp;<?php echo date_format(date_create($scq_expire)," d | M | Y");?></p>
                                                <p><strong>Details:</strong>&nbsp;<?php echo $scq_content; ?></p>    
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="commentss_<?php echo $scq_id;?>">
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
        </div><!---newest--->
        
        <div role="tabpanel" class="tab-pane" id="ending">
            <?php
                $dt = implode(',',$discount);
                $dt = str_ireplace(',',"','",$dt);
                
                //Ct
                $ct = implode(',',$checked);
                $ct = str_ireplace(',',"','",$ct);
                //Cat
                $cat = implode(',',$categories);
                $cat = str_ireplace(',',"','",$cat);
                
        
                $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` = '$url'";
                if(!empty($categories)){
                    $stor_john_arr = [];
                    $cat_john_arr = [];
                    $stor_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` = '$url'";
                    $stor_john = mysqli_query($conn,$stor_coupons);
                    if(mysqli_num_rows($stor_john) > 0){
                        while($stor_john_row = mysqli_fetch_assoc($stor_john)){
                            $stor_john_id = $stor_john_row['ID'];
                            array_push($stor_john_arr,$stor_john_id);
                        }
                    }
                    echo '<br />';
                    //$stor_john_arr_id = implode(',',$stor_john_arr);
                    $cat_coupons = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' AND `wp_terms`.`slug` IN('$cat')";
                    $cat_john = mysqli_query($conn,$cat_coupons);
                    if(mysqli_num_rows($cat_john) > 0){
                        while($cat_john_row = mysqli_fetch_assoc($cat_john)){
                            $cat_john_id = $cat_john_row['ID'];
                            array_push($cat_john_arr,$cat_john_id);
                        }
                    }
                    
                    $store_coupons_arr = array_intersect($stor_john_arr,$cat_john_arr);
                    $store_coupons_arr_imp = implode(',', $store_coupons_arr);
                    
                    $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` = '$url' AND `all_posts`.`ID` IN($store_coupons_arr_imp)";
                }
                
                if(count($checked) > 0){
                    
                    $store_coupons .= "AND `all_posts`.`coupon_type` IN('".$ct."')";            
                }
                if(count($discount) > 0){
                    $store_coupons .= "AND `all_posts`.`discount_type` IN('".$dt."')";
                }
                
                $store_coupons .= "ORDER BY `all_posts`.`expire_date` ASC, `all_posts`.`ID` DESC LIMIT $posts_starts_from,$number_of_posts";
                
                $store_coupons_query = mysqli_query($conn,$store_coupons);
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
                                                    <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"class="post-one-title"><?php echo $scq_title?></a>
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
                                            <div class="col-xs-4 text-right">
                                                <span data-toggle="modal" data-target="#coponer_<?php echo $scq_id;?>" style="display:block;"><a href="<?php echo $scq_guid;?>" target="_blank" class="btn btn-primary gd" id="gd_<?php echo $scq_id; ?>" data="<?php echo $scq_code; ?>" ><?php echo $button_name;?></a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--poco-->
                                
                                <!-- Modal  tabindex="-1" -->
                                <div class="modal fade" id="coponer_<?php echo $scq_id;?>">
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
                                                    <a href="<?php echo $scq_guid;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
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
                                                    <li role="presentation"><a href="#exclusionsss_<?php echo $scq_id;?>" aria-controls="exclusionsss_<?php echo $scq_id;?>" role="tab" data-toggle="tab">Exclusions</a></li>
                                                    <?php
                                                        }
                                                    ?>
                                                    <li role="presentation"><a href="#detailsss_<?php echo $scq_id;?>" aria-controls="detailsss_<?php echo $scq_id;?>" role="tab" data-toggle="tab">Details</a></li>
                                                    <?php
                                                    $comment_query_count = "SELECT * FROM `wp_comments` WHERE `comment_post_ID` = $scq_id AND `comment_approved` = 'approved' ORDER BY `comment_ID` DESC";
                                                    $comment_result_count = mysqli_query($conn,$comment_query_count);
                                                    ?>
                                                    <li role="presentation"><a href="#commentsss_<?php echo $scq_id;?>" aria-controls="commentsss_<?php echo $scq_id;?>" role="tab" data-toggle="tab"><?php if(mysqli_num_rows($comment_result_count) != 0){echo mysqli_num_rows($comment_result_count);}?> Comments</a></li>
                                                </ul>
                                                
                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    <?php
                                                    if(mysqli_num_rows($tags_result) > 0){
                                                    ?>
                                                    <div role="tabpanel" class="tab-pane" id="exclusionsss_<?php echo $scq_id;?>">
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
                                                    <div role="tabpanel" class="tab-pane" id="detailsss_<?php echo $scq_id;?>">
                                                        <p><strong>Expires:</strong>&nbsp;&nbsp;<?php echo date_format(date_create($scq_expire)," d | M | Y");?></p>
                                                        <p><strong>Details:</strong>&nbsp;<?php echo $scq_content; ?></p>    
                                                    </div>
                                                    <div role="tabpanel" class="tab-pane" id="commentsss_<?php echo $scq_id;?>">
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
                }else{
                    ?>
                    <h1>No Coupons are Available</h1>
                    <?php
                }
            ?>
        </div><!---ending--->
    </div><!--tab-content-->
    
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
    </div>
    
    
    <script type="text/javascript">
        $(document).ready(function(){
            $('.tabsi_tog').click(function(){
                $(this).next('.tabsi').stop().slideToggle();
                $(this).children('i').toggleClass("chvrn");
            });
            
            $('.nav-tabs').each(function(){
                $(this).children('li').first().addClass('active');    
            });
            $('.tab-content').each(function(){
                $(this).children('.tab-pane').first().addClass('active');    
            });
            
            
            //Comment Data
            $(".com-sub").click(function(){
                var com_post_id = $(this).parent().children('.com_post_id').val();
                var firstname = $(this).parent().children().children('.firstname').val();
                var add_comment = $(this).parent().children().children('.add_comment').val();
                if (firstname == '') {
                    $(this).parent().children().children('.firstname').next().text('Please enter your first name');
                }else{
                    $(this).parent().children().children('.firstname').next().text('');
                }
                
                if (add_comment == '') {
                    $(this).parent().children().children('.add_comment').next().text('Please fill out comment box');
                }else{
                    $(this).parent().children().children('.add_comment').next().text('');
                }
                
                if (add_comment != '' && firstname != '') {
                    var pathname = $(this).parent().children('.com_post_id').attr('id'); // Returns path only
                    pathname = pathname + '/comment.php';
                    
                    $.ajax({
                        method: 'POST',
                        url: pathname,
                        data: {action: 'comment',com_post_id: com_post_id, firstname:firstname, add_comment:add_comment},
                        success: function(result){
                            $('.msg').html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Your Comment is successfully posted and waiting for an approval');
                            $('.msg').addClass('alert alert-success alert-dismissible');
                        }
                    });
                    $(this).parent().children().children('.firstname').val('');
                    $(this).parent().children().children('.add_comment').val('');
                }
                
            });
            
            $('.post-one-details').each(function(){
                var com_len = $(this).find('.comm').length;
                $(this).find('.comm:eq(4)').nextAll('.comm').hide();
                $(this).find('#hide_comm').hide();
                if (com_len > 5) {
                    $(this).find('#show_comm').show();
                }else{
                    $(this).find('#show_comm').hide();
                }
                $(this).find('#show_comm').click(function(){
                    $(this).hide();
                    $(this).parent().children('.client-comments').find('.comm:eq(4)').nextAll('.comm').show();
                    $(this).parent().find('#hide_comm').show();
                    $(this).parent().children('.client-comments').css({'height':'500px','overflow-y':'scroll'});
                });
                $(this).find('#hide_comm').click(function(){
                    $(this).hide();
                    $(this).parent().children('.client-comments').find('.comm:eq(4)').nextAll('.comm').hide();
                    $(this).parent().find('#show_comm').show();
                    $(this).parent().children('.client-comments').css({'height':'auto','overflow-y':'hidden'});
                });
                
            });
            
            var pathname = $('.kbc_uri').val();
            var us = $('.kbc_uri').attr('placeholder');
            var ct = [];
            var dt = [];
            var cat = [];
            var gd_arr = [];
            
            <?php
            foreach($checked as $check){
                ?>
                ct.push('<?php echo $check;?>');
                <?php
            }
            ?>
            
            <?php
            foreach($discount as $dt){
                ?>
                dt.push('<?php echo $dt;?>');
                <?php
            }
            ?>
            
            <?php
            foreach($categories as $cat){
                ?>
                cat.push('<?php echo $cat;?>');
                <?php
            }
            ?>
            
            
            
            //Code in button
            
            <?php
                $gd_arr = array_unique($_POST['gd_arr']);
                foreach($gd_arr as $gd_id){
                    ?>
                    gd_arr.push('<?php echo $gd_id; ?>');
                    <?php
                }
            ?>
            
            for(var v = 0; v < gd_arr.length; v++){
                var data_txt = $(gd_arr[v]).attr('data');
                $('#popularity,#newest,#ending').find(gd_arr[v]).each(function(){
                    $(this).text(data_txt);
                    $(this).css({'color': '#4a4a4a', 'background': '#f5f4f4', 'border': '1px solid #e5e5e5'});
                });
            }
            
            var pathname = $('.kbc_uri').val();
            pathname = pathname + '/filter.php';
            var us = $('.kbc_uri').attr('placeholder');
            var store_id = $('.kbc_uri').attr('title');
            var gd_arr_id = [];
            
            $('.gd').click(function(){
                var data_text = $(this).attr('data');
                var gd_id = '#' + $(this).attr('id');
                gd_arr_id.push(gd_id);
                gd_arr.push(gd_id);
                $('#popularity,#newest,#ending').find(gd_id).each(function(){
                    $(this).text(data_text);
                    $(this).css({'color': '#4a4a4a', 'background': '#f5f4f4', 'border': '1px solid #e5e5e5'});
                });
            });
            
            $('.next_btn').click(function(){
                var page_id = <?php echo $page_id; ?>;
                var total_posts = <?php echo $all_posts; ?>;
                page_id = page_id + 1;
                pathname = pathname + '/filter.php';
                $.ajax({
                    method: 'POST',
                    url: pathname,
                    data: {action: 'populer', page_id: page_id, usp:us, total_posts: total_posts, checked: ct, dt: dt, cat: cat, gd_arr: gd_arr},
                    success: function(result){
                        $('.top-offers').html(result);
                    }
                });
                
            });
            
            $('.prev_btn').click(function(){
                var page_id = <?php echo $page_id; ?>;
                var total_posts = <?php echo $all_posts; ?>;
                page_id = page_id - 1;
                pathname = pathname + '/filter.php';
                $.ajax({
                    method: 'POST',
                    url: pathname,
                    data: {action: 'populer', page_id: page_id, usp:us, total_posts: total_posts, checked: ct, dt: dt, cat: cat, gd_arr: gd_arr},
                    success: function(result){
                        $('.top-offers').html(result);
                    }
                });
                
            });
            
        });
        
    </script>
    <?php
}


function store_subscribtion(){
    global $conn;
    $store_subs_email = mysqli_real_escape_string($conn,htmlentities($_POST['store_subs_email']));
    $store_subs_id = $_POST['store_subs_id'];
    
    $store_subs_sel = "SELECT * FROM `add_favourite` WHERE `email` = '$store_subs_email' AND `store_id` = $store_subs_id";
    $store_subs_sel_query = mysqli_query($conn,$store_subs_sel);
    if(mysqli_num_rows($store_subs_sel_query) > 0){
        ?>
            <div class="alert alert-info alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Your email already exists.
            </div>
        <?php
    }else{
        $ip_address = get_client_ip();
        $store_subs_ins = "INSERT INTO `add_favourite`(`store_id`, `email`, `ip_address`) VALUES ($store_subs_id,'$store_subs_email','$ip_address')";
        if(empty($store_subs_email)){
            ?>
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Please Fill the email field!
            </div>
            <?php
        }else{
            mysqli_query($conn,$store_subs_ins);
            ?>
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Your email has heen successfully submitted.
            </div>
            <script type="text/javascript">
                $('.st_fav a').children('i').addClass('heart');
                $('.st_fav a').children('span').text('Faved!');
            </script>
            <?php
        }
    }
}

function coupons_category(){
    error_reporting(0);
    global $conn;
    $url = mysqli_real_escape_string($conn,htmlentities($_POST['usp'])); //Store Name
    $store_id = mysqli_real_escape_string($conn,htmlentities($_POST['store_id'])); //Store Id
    //For id
    $check_id = array_unique($_POST['check_id']);
    unset($check_id[0]);
    array_push($check_id,$store_id);
    
    $checked = array_unique($_POST['checked']);
    $discount = array_unique($_POST['dt']);
    $categories = array_unique($_POST['cat']);
    $gd_arr = array_unique($_POST['gd_arr']);
    $gd_arr_id = array_unique($_POST['gd_arr_id']);
    
    $number_of_posts = 24;
    $page_id = $_POST['page_id'];
    if($page_id <= 0){
        $page_id = 1;
    }
    ?>
    
    <?php
        //$store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('walmart-coupons') ORDER BY `wp_term_taxonomy`.`count` DESC LIMIT 0,10";
        $dt = implode(',',$discount);
        $dt = str_ireplace(',',"','",$dt);
        
        //Ct
        $ct = implode(',',$checked);
        $ct = str_ireplace(',',"','",$ct);
        
        //Cat
        $cat = implode(',',$categories);
        $cat = str_ireplace(',',"','",$cat);
        

        $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('$url')";
        if(!empty($categories)){
            $stor_john_arr = [];
            $cat_john_arr = [];
            $stor_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('$url')";
            $stor_john = mysqli_query($conn,$stor_coupons);
            if(mysqli_num_rows($stor_john) > 0){
                while($stor_john_row = mysqli_fetch_assoc($stor_john)){
                    $stor_john_id = $stor_john_row['ID'];
                    array_push($stor_john_arr,$stor_john_id);
                }
            }
            
            //$stor_john_arr_id = implode(',',$stor_john_arr);
            $cat_coupons = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_terms`.`slug` IN('$cat')";
            $cat_john = mysqli_query($conn,$cat_coupons);
            if(mysqli_num_rows($cat_john) > 0){
                while($cat_john_row = mysqli_fetch_assoc($cat_john)){
                    $cat_john_id = $cat_john_row['ID'];
                    array_push($cat_john_arr,$cat_john_id);
                }
            }
            
            $store_coupons_arr = array_intersect($stor_john_arr,$cat_john_arr);
            $store_coupons_arr_imp = implode(',', $store_coupons_arr);
            
            $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('$url') AND `all_posts`.`ID` IN($store_coupons_arr_imp)";
        }
        
        if(count($checked) > 0){
            
            $store_coupons .= "AND `all_posts`.`coupon_type` IN('".$ct."')";            
        }
        if(count($discount) > 0){
            $store_coupons .= "AND `all_posts`.`discount_type` IN('".$dt."')";
        }
        
        $all_posts_run = mysqli_query($conn,$store_coupons);
        $all_posts = mysqli_num_rows($all_posts_run);
        $total_pages = ceil($all_posts / $number_of_posts);
        $posts_starts_from = ($page_id - 1) * $number_of_posts;
        
        $store_coupons .= "ORDER BY `all_posts`.`hits` DESC, `all_posts`.`ID` DESC LIMIT $posts_starts_from,$number_of_posts";
        
        $store_coupons_query = mysqli_query($conn,$store_coupons);
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
                <div class="col-xs-4 coupon">
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
                            <b><a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"><?php echo excerpt($scq_title, 6); ?></a></b>
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
                                        <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"class="post-one-title"><?php echo $scq_title?></a>
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
                                <div class="col-xs-4 text-right">
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
    
    <script type="text/javascript">
        var pathname = $('.kbc_uri').val();
        var us = $('.kbc_uri').attr('placeholder');
        var ct = [];
        var dt = [];
        var cat = [];
        var gd_arr = [];
        
        <?php
        foreach($checked as $check){
            ?>
            ct.push('<?php echo $check;?>');
            <?php
        }
        ?>
        
        <?php
        foreach($discount as $dt){
            ?>
            dt.push('<?php echo $dt;?>');
            <?php
        }
        ?>
        
        <?php
        foreach($categories as $cat){
            ?>
            cat.push('<?php echo $cat;?>');
            <?php
        }
        ?>
        
        //Code in button
        
        <?php
            $gd_arr = array_unique($_POST['gd_arr']);
            foreach($gd_arr as $gd_id){
                ?>
                gd_arr.push('<?php echo $gd_id; ?>');
                <?php
            }
        ?>
        
        for(var v = 0; v < gd_arr.length; v++){
            var data_txt = $(gd_arr[v]).attr('data');
            $('.main-cont').find(gd_arr[v]).each(function(){
                $(this).text(data_txt);
                $(this).css({'color': '#4a4a4a', 'background': '#f5f4f4', 'border': '1px solid #e5e5e5'});
            });
        }
        
        var pathname = $('.kbc_uri').val();
        pathname = pathname + '/filter.php';
        var us = $('.kbc_uri').attr('placeholder');
        var store_id = $('.kbc_uri').attr('title');
        var gd_arr_id = [];
        
        $('.gd').click(function(){
            var data_text = $(this).attr('data');
            var gd_id = '#' + $(this).attr('id');
            gd_arr_id.push(gd_id);
            gd_arr.push(gd_id);
            $('.main-cont').find(gd_id).each(function(){
                $(this).text(data_text);
                $(this).css({'color': '#4a4a4a', 'background': '#f5f4f4', 'border': '1px solid #e5e5e5'});
            });
        });
        
        $('.next_btn').click(function(){
            var page_id = <?php echo $page_id; ?>;
            var total_posts = <?php echo $all_posts; ?>;
            page_id = page_id + 1;
            pathname = pathname + '/filter.php';
            $.ajax({
                method: 'POST',
                url: pathname,
                data: {action: 'coupons_category', page_id: page_id, usp:us, total_posts: total_posts, checked: ct, dt: dt, cat: cat, gd_arr: gd_arr},
                success: function(result){
                    $('.main-cont').html(result);
                }
            });
            
        });
        
        $('.prev_btn').click(function(){
            var page_id = <?php echo $page_id; ?>;
            var total_posts = <?php echo $all_posts; ?>;
            page_id = page_id - 1;
            pathname = pathname + '/filter.php';
            $.ajax({
                method: 'POST',
                url: pathname,
                data: {action: 'coupons_category', page_id: page_id, usp:us, total_posts: total_posts, checked: ct, dt: dt, cat: cat, gd_arr: gd_arr},
                success: function(result){
                    $('.main-cont').html(result);
                }
            });
            
        });
    </script>
    
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
    </div>
    <?php
}



function search_page(){
    
    error_reporting(0);
    global $conn;
    $url = mysqli_real_escape_string($conn,htmlentities($_POST['usp'])); //Store Name
    $store_id = mysqli_real_escape_string($conn,htmlentities($_POST['store_id'])); //Store Id
    //For id
    $check_id = array_unique($_POST['check_id']);
    unset($check_id[0]);
    array_push($check_id,$store_id);
    
    $checked = array_unique($_POST['checked']);
    $discount = array_unique($_POST['dt']);
    $categories = array_unique($_POST['cat']);
    $store = array_unique($_POST['store']);
    $gd_arr = array_unique($_POST['gd_arr']);
    $gd_arr_id = array_unique($_POST['gd_arr_id']);
    
    $number_of_posts = 10;
    
    $page_id = $_POST['page_id'];
    if($page_id <= 0){
        $page_id = 1;
    }
    
    
    $dt = implode(',',$discount);
    $dt = str_ireplace(',',"','",$dt);
    
    //Ct
    $ct = implode(',',$checked);
    $ct = str_ireplace(',',"','",$ct);
    
    //Cat
    $cat = implode(',',$categories);
    $cat = str_ireplace(',',"','",$cat);
    
    //store
    $str = implode(',',$store);
    $str = str_ireplace(',',"','",$str);
    

    $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `all_posts`.`post_title` LIKE '%$url%'";
    if(!empty($categories) || !empty($store) || (!empty($categories) && !empty($store)) ){
        $stor_john_arr = [];
        $cat_john_arr = [];
        $stor_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `all_posts`.`post_title` LIKE '%$url%' AND `wp_terms`.`slug` IN('$str')";
        $stor_john = mysqli_query($conn,$stor_coupons);
        if(mysqli_num_rows($stor_john) > 0){
            while($stor_john_row = mysqli_fetch_assoc($stor_john)){
                $stor_john_id = $stor_john_row['ID'];
                array_push($stor_john_arr,$stor_john_id);
            }
        }
        //$stor_john_arr_id = implode(',',$stor_john_arr);
        $cat_coupons = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' AND `wp_terms`.`slug` IN('$cat') AND `all_posts`.`post_title` LIKE '%$url%'";
        $cat_john = mysqli_query($conn,$cat_coupons);
        if(mysqli_num_rows($cat_john) > 0){
            while($cat_john_row = mysqli_fetch_assoc($cat_john)){
                $cat_john_id = $cat_john_row['ID'];
                array_push($cat_john_arr,$cat_john_id);
            }
        }
        
        if(!empty($categories) && !empty($store)){
            $store_coupons_arr = array_intersect($stor_john_arr,$cat_john_arr);
            $store_coupons_arr_imp = implode(',', $store_coupons_arr);   
        }else if(!empty($categories)){
            $store_coupons_arr = $cat_john_arr;
            $store_coupons_arr_imp = implode(',', $store_coupons_arr);   
        }else if(!empty($store)){
            $store_coupons_arr = $stor_john_arr;
            $store_coupons_arr_imp = implode(',', $store_coupons_arr);
        }
        
        $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `all_posts`.`post_title` LIKE '%$url%' AND `all_posts`.`ID` IN($store_coupons_arr_imp)";
    }
    
    if(count($checked) > 0){
        
        $store_coupons .= "AND `all_posts`.`coupon_type` IN('".$ct."')";            
    }
    if(count($discount) > 0){
        $store_coupons .= "AND `all_posts`.`discount_type` IN('".$dt."')";
    }
    
    $all_posts_run = mysqli_query($conn,$store_coupons);
    $all_posts = mysqli_num_rows($all_posts_run);
    $total_pages = ceil($all_posts / $number_of_posts);
    $posts_starts_from = ($page_id - 1) * $number_of_posts;
    
    $store_coupons .= "ORDER BY `all_posts`.`hits` DESC, `all_posts`.`ID` DESC LIMIT $posts_starts_from, $number_of_posts";
    
    $store_coupons_query = mysqli_query($conn,$store_coupons);
    
    ?>
    <h3 class="store_title">You are Searching for "<?php echo str_ireplace('-',' ',$url);?>" </h3>
    <?php
    if(mysqli_num_rows($store_coupons_query) > 0){
        while($search_post_row = mysqli_fetch_array($store_coupons_query)){
            $search_post_id = $search_post_row['ID'];
            $search_post_title = $search_post_row['post_title'];
            $search_post_post_name = $search_post_row['post_name'];
            $search_post_content = $search_post_row['post_content'];
            $search_post_meta = $search_post_row['meta_value'];
            $search_post_sel_image = $search_post_row['select_img'];
            $search_post_guid = $search_post_row['guid'];
            $search_post_featured = $search_post_row['post_featured_image'];
            $search_post_hits = $search_post_row['hits'];
            $search_post_expire = $search_post_row['expire_date'];
            $search_post_code = $search_post_row['coupon_code'];
            $search_post_code_type = $search_post_row['coupon_code_type'];
            $search_post_coupon_type = ucwords(str_ireplace(array('-'),array(' '),$search_post_row['coupon_type']));
            $search_post_coupon_type_color = $search_post_row['coupon_type_color'];
            $search_post_btn = $search_post_row['btn_name'];
            
            if($search_post_btn == ''){
                $button_name = 'Get Deal';
            }else{
                $button_name = $search_post_btn;
            }
            ?>
            <div class="post-contain-one">
                <div class="row post-one poco_<?php echo $search_post_id;?>">
                    <div class="col-xs-2 post-img-one">
                        <?php
                            if($search_post_sel_image == 'featured_image'){
                                //Second condition
                                if(!empty($search_post_featured)){
                                    ?>
                                        <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $search_post_post_name;?>" target="_blank"><img src="<?php echo $search_post_featured;?>" alt="4" class="img-responsive"/></a>
                                    <?php
                                }else{
                                    $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $search_post_meta";
                                    $sub_sql_query = mysqli_query($conn,$sub_sql);
                                    $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                    $store_img_url = $sub_sql_row['guid'];
                                    ?>
                                        <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $search_post_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                    <?php
                                }
                                
                            }else if($search_post_sel_image == 'store_image'){
                                $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $search_post_meta";
                                $sub_sql_query = mysqli_query($conn,$sub_sql);
                                $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                $store_img_url = $sub_sql_row['guid'];
                                ?>
                                    <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $search_post_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                <?php
                            }
                        ?>
                    </div>
                    <div class="col-xs-10 post-mid">
                        
                        <div class="row post-mid-one">
                            <div class="col-xs-8 to">
                                <span style="color: <?php echo $search_post_coupon_type_color; ?>; font-weight:600;"><?php echo $search_post_coupon_type; ?></span>
                                <?php
                                //coupont-type Values
                                $coupon_type_query = "SELECT `wp_terms`.*,`wp_term_taxonomy`.*,`wp_term_relationships`.*,`all_posts`.* FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`all_posts` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` IN('coupon_type','stores') AND `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `all_posts`.`ID` = $search_post_id";
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
                                <h3 data-toggle="modal">
                                    <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $search_post_post_name;?>" target="_blank"class="post-one-title"><?php echo $search_post_title?></a>
                                </h3>
                                <br />
                                
                                <?php
                                if ($search_post_hits > 999 && $search_post_hits <= 999999) {
                                    $result = floor($search_post_hits / 1000) . 'K';
                                } elseif ($search_post_hits > 999999) {
                                    $result = floor($search_post_hits / 1000000) . 'M';
                                } else {
                                    $result = $search_post_hits;
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
                                <?php if($search_post_hits > 0){?>
                                    <span><?php echo $result; ?> Viewed</span>
                                <?php } ?>
                            </div>
                            <div class="col-xs-4 text-right">
                                <span data-toggle="modal" data-target="#copon_<?php echo $search_post_id;?>" style="display:block;"><a href="<?php echo $search_post_guid;?>" target="_blank" class="btn btn-primary gd"  id="gd_<?php echo $search_post_id; ?>" data="<?php echo $search_post_code; ?>" ><?php echo $button_name;?></a></span>
                            </div>
                        </div>
                    </div>
                </div><!--poco-->
                
                <!-- Modal  tabindex="-1" -->
                <div class="modal fade" id="copon_<?php echo $search_post_id;?>">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?php echo $search_post_title; ?></h4>
                      </div>
                      <div class="modal-body row">
                        
                        <div class="col-sm-2 col-xs-3 text-center mod_img">
                            <?php
                            if($search_post_sel_image == 'featured_image'){
                                //Second condition
                                if(!empty($search_post_featured)){
                                    ?>
                                        <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $search_post_post_name;?>" target="_blank"><img src="<?php echo $search_post_featured;?>" alt="4" class="img-responsive"/></a>
                                    <?php
                                }else{
                                    $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $search_post_meta";
                                    $sub_sql_query = mysqli_query($conn,$sub_sql);
                                    $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                    $store_img_url = $sub_sql_row['guid'];
                                    ?>
                                        <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $search_post_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                    <?php
                                }
                                
                            }else if($search_post_sel_image == 'store_image'){
                                $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $search_post_meta";
                                $sub_sql_query = mysqli_query($conn,$sub_sql);
                                $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                $store_img_url = $sub_sql_row['guid'];
                                ?>
                                    <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $search_post_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="col-sm-7 col-xs-5 mod_des">
                            <?php echo excerpt($search_post_content,25);?>
                        </div>
                        <div class="col-sm-3 col-xs-4 mod_code">
                            <?php
                            //SELECT * FROM `all_posts` WHERE `coupon_code` NOT LIKE '%Coupon%' AND `coupon_code` NOT LIKE '%Deal%' AND `coupon_code` != ''
                            if($search_post_code_type == 'real_code'){
                            ?>
                                <input type="text" disabled="disabled" class="form-control codee_<?php echo $search_post_id; ?>" value="<?php echo $search_post_code; ?>"/>
                            <?php
                            }else if($search_post_code == ''){
                                echo "<span>No Coupon Code Required</span>";
                            }else{
                                echo "<span>$search_post_code</span>";
                            }
                            ?>
                            
                        </div>
                        
                      </div>
                      
                       <?php
                            if($search_post_code != 'No Coupon Code Required' && $search_post_code != 'Deal Activated' && $search_post_code != 'Coupon Activated'){
                                ?>
                                <div class="modal-footer">
                                    <button class="btn btn-primary copy_<?php echo $search_post_id; ?>">Copy Code</button>
                                    <script type="text/javascript">
                                        $(document).ready(function(){
                                            function copyToClipboard(element) {
                                                var $temp = $("<input>");
                                                $("body").append($temp);
                                                $temp.val($(element).val()).select();
                                                document.execCommand("copy");
                                                $temp.remove();
                                            }
                                            $('.copy_<?php echo $search_post_id; ?>').click(function(){
                                                copyToClipboard('.codee_<?php echo $search_post_id; ?>');
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
                
                <div class="row post-one-details">
                    <div class="col-xs-12">
                        <a class="tabsi_tog">Show Details <i class="fa fa-chevron-up chvrn"></i></a>
                        
                        <div class="row tabsi">
                            <?php
                                $tags_query = "SELECT `wp_terms`.`term_id`,`wp_term_taxonomy`.`term_id`,`wp_terms`.`name`,`wp_term_taxonomy`.`taxonomy`,`wp_term_relationships`.`object_id` FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_tag' AND `wp_term_relationships`.`object_id` = $search_post_id";
                                $tags_result = mysqli_query($conn,$tags_query);
                            ?>
                            <div class="col-xs-12">
                                <ul class="nav nav-tabs" role="tablist">
                                    <?php
                                        if(mysqli_num_rows($tags_result) > 0){
                                    ?>
                                    <li role="presentation"><a href="#exclusions_<?php echo $search_post_id;?>" aria-controls="exclusions_<?php echo $search_post_id;?>" role="tab" data-toggle="tab">Exclusions</a></li>
                                    <?php
                                        }
                                    ?>
                                    <li role="presentation"><a href="#details_<?php echo $search_post_id;?>" aria-controls="details_<?php echo $search_post_id;?>" role="tab" data-toggle="tab">Details</a></li>
                                    <?php
                                    $comment_query_count = "SELECT * FROM `wp_comments` WHERE `comment_post_ID` = $search_post_id AND `comment_approved` = 'approved' ORDER BY `comment_ID` DESC";
                                    $comment_result_count = mysqli_query($conn,$comment_query_count);
                                    ?>
                                    <li role="presentation"><a href="#comments_<?php echo $search_post_id;?>" aria-controls="comments_<?php echo $search_post_id;?>" role="tab" data-toggle="tab"><?php if(mysqli_num_rows($comment_result_count) != 0){echo mysqli_num_rows($comment_result_count);}?> Comments</a></li>
                                </ul>
                                
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php
                                    if(mysqli_num_rows($tags_result) > 0){
                                    ?>
                                    <div role="tabpanel" class="tab-pane" id="exclusions_<?php echo $search_post_id;?>">
                                        <?php
                                            $tags_query = "SELECT `wp_terms`.`term_id`,`wp_term_taxonomy`.`term_id`,`wp_terms`.`name`,`wp_term_taxonomy`.`taxonomy`,`wp_term_relationships`.`object_id` FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_tag' AND `wp_term_relationships`.`object_id` = $search_post_id";
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
                                    <div role="tabpanel" class="tab-pane" id="details_<?php echo $search_post_id;?>">
                                        <p><strong>Expires:</strong>&nbsp;&nbsp;<?php echo date_format(date_create($search_post_expire)," d | M | Y");?></p>
                                        <p><strong>Details:</strong>&nbsp;<?php echo $search_post_content; ?></p>    
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="comments_<?php echo $search_post_id;?>">
                                        <?php
                                            $comment_query = "SELECT * FROM `wp_comments` WHERE `comment_post_ID` = $search_post_id AND `comment_approved` = 'approved' ORDER BY `comment_ID` DESC";
                                            $comment_result = mysqli_query($conn,$comment_query);
                                        ?>
                                        <div class="msg"></div>
                                        <div class="comment-box">
                                            
                                            <form action="comment.php" method="post">
                                                
                                                <div class="form-group">
                                                    <label for="firstname">First Name(optional)</label>
                                                    <input type="text" class="form-control firstname" id="firstname" name="firstname" placeholder="First Name(optional)" value="<?php echo (isset($fname) && $com_post_id == $search_post_id ? $fname : '');?>"/>
                                                    <span class="comment_error"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label for="add_comment">Add a Comment*</label>
                                                    <textarea class="form-control add_comment" rows="3" id="add-comment" name="add_comment" placeholder="Add a Comment..."><?php echo (isset($adcom) && $com_post_id == $search_post_id ? $adcom : '');?></textarea>
                                                    <span class="comment_error"></span>
                                                </div>
                                                <input type="hidden" value="<?php echo $search_post_id; ?>" name="com_post_id" class="com_post_id" id="<?php echo path_url('/retail_pro');?>"/>
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
        ?>
        <script type="text/javascript">
            
            $('.tabsi_tog').click(function(){
                $(this).next('.tabsi').stop().slideToggle();
                $(this).children('i').toggleClass("chvrn");
            });
            
            $('.nav-tabs').each(function(){
                $(this).children('li').first().addClass('active');    
            });
            $('.tab-content').each(function(){
                $(this).children('.tab-pane').first().addClass('active');    
            });
            
            
            //Comment Data
            $(".com-sub").click(function(){
                var com_post_id = $(this).parent().children('.com_post_id').val();
                var firstname = $(this).parent().children().children('.firstname').val();
                var add_comment = $(this).parent().children().children('.add_comment').val();
                if (firstname == '') {
                    $(this).parent().children().children('.firstname').next().text('Please enter your first name');
                }else{
                    $(this).parent().children().children('.firstname').next().text('');
                }
                
                if (add_comment == '') {
                    $(this).parent().children().children('.add_comment').next().text('Please fill out comment box');
                }else{
                    $(this).parent().children().children('.add_comment').next().text('');
                }
                
                if (add_comment != '' && firstname != '') {
                    var pathname = $(this).parent().children('.com_post_id').attr('id'); // Returns path only
                    pathname = pathname + '/comment.php';
                    
                    $.ajax({
                        method: 'POST',
                        url: pathname,
                        data: {action: 'comment',com_post_id: com_post_id, firstname:firstname, add_comment:add_comment},
                        success: function(result){
                            $('.msg').html('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Your Comment is successfully posted and waiting for an approval');
                            $('.msg').addClass('alert alert-success alert-dismissible');
                        }
                    });
                    $(this).parent().children().children('.firstname').val('');
                    $(this).parent().children().children('.add_comment').val('');
                }
                
            });
            
            $('.post-one-details').each(function(){
                var com_len = $(this).find('.comm').length;
                $(this).find('.comm:eq(4)').nextAll('.comm').hide();
                $(this).find('#hide_comm').hide();
                if (com_len > 5) {
                    $(this).find('#show_comm').show();
                }else{
                    $(this).find('#show_comm').hide();
                }
                $(this).find('#show_comm').click(function(){
                    $(this).hide();
                    $(this).parent().children('.client-comments').find('.comm:eq(4)').nextAll('.comm').show();
                    $(this).parent().find('#hide_comm').show();
                    $(this).parent().children('.client-comments').css({'height':'500px','overflow-y':'scroll'});
                });
                $(this).find('#hide_comm').click(function(){
                    $(this).hide();
                    $(this).parent().children('.client-comments').find('.comm:eq(4)').nextAll('.comm').hide();
                    $(this).parent().find('#show_comm').show();
                    $(this).parent().children('.client-comments').css({'height':'auto','overflow-y':'hidden'});
                });
                
            });
            
            
            var pathname = $('.kbc_uri').val();
            var us = $('.kbc_uri').attr('placeholder');
            var store = [];
            var ct = [];
            var dt = [];
            var cat = [];
            var gd_arr = [];
            
            <?php
            foreach($store as $stre){
                ?>
                store.push('<?php echo $stre;?>');
                <?php
            }
            ?>
            
            <?php
            foreach($checked as $check){
                ?>
                ct.push('<?php echo $check;?>');
                <?php
            }
            ?>
            
            <?php
            foreach($discount as $dt){
                ?>
                dt.push('<?php echo $dt;?>');
                <?php
            }
            ?>
            
            <?php
            foreach($categories as $cat){
                ?>
                cat.push('<?php echo $cat;?>');
                <?php
            }
            ?>
            
            //Code in button
            
            <?php
                $gd_arr = array_unique($_POST['gd_arr']);
                foreach($gd_arr as $gd_id){
                    ?>
                    gd_arr.push('<?php echo $gd_id; ?>');
                    <?php
                }
            ?>
            
            for(var v = 0; v < gd_arr.length; v++){
                var data_txt = $(gd_arr[v]).attr('data');
                $('.main-cont').find(gd_arr[v]).each(function(){
                    $(this).text(data_txt);
                    $(this).css({'color': '#4a4a4a', 'background': '#f5f4f4', 'border': '1px solid #e5e5e5'});
                });
            }
            
            var pathname = $('.kbc_uri').val();
            pathname = pathname + '/filter.php';
            var us = $('.kbc_uri').attr('placeholder');
            var store_id = $('.kbc_uri').attr('title');
            var gd_arr_id = [];
            
            $('.gd').click(function(){
                var data_text = $(this).attr('data');
                var gd_id = '#' + $(this).attr('id');
                gd_arr_id.push(gd_id);
                gd_arr.push(gd_id);
                $('.top-offers').find(gd_id).each(function(){
                    $(this).text(data_text);
                    $(this).css({'color': '#4a4a4a', 'background': '#f5f4f4', 'border': '1px solid #e5e5e5'});
                });
            });
            
            $('.next_btn').click(function(){
                var page_id = <?php echo $page_id; ?>;
                var total_posts = <?php echo $all_posts; ?>;
                page_id = page_id + 1;
                pathname = pathname + '/filter.php';
                $.ajax({
                    method: 'POST',
                    url: pathname,
                    data: {action: 'search_page', page_id: page_id, usp:us, total_posts: total_posts, checked: ct, dt: dt, cat: cat, store: store, gd_arr: gd_arr},
                    success: function(result){
                        $('.top-offers').html(result);
                    }
                });
                
            });
            
            $('.prev_btn').click(function(){
                var page_id = <?php echo $page_id; ?>;
                var total_posts = <?php echo $all_posts; ?>;
                page_id = page_id - 1;
                pathname = pathname + '/filter.php';
                $.ajax({
                    method: 'POST',
                    url: pathname,
                    data: {action: 'search_page', page_id: page_id, usp:us, total_posts: total_posts, checked: ct, dt: dt, cat: cat, store: store, gd_arr: gd_arr},
                    success: function(result){
                        $('.top-offers').html(result);
                    }
                });
                
            });
        </script>
        
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
        </div>
        
        <?php
    }
    
    function filter_changes($query){
        global $conn;
        $arr_store_id = [];
        $arr_cat_id = [];
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $id = $row['term_id'];
                $tax = $row['taxonomy'];
                if($tax == 'stores'){
                    array_push($arr_store_id,$id);
                }else if($tax == 'coupon_category'){
                    array_push($arr_cat_id,$id);
                }
            }
        }
        $arr_store_id = array_unique($arr_store_id);
        $arr_cat_id = array_unique($arr_cat_id);
        return [$arr_store_id,$arr_cat_id];
        
    }
    $filter = filter_changes("SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores','coupon_category') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `all_posts`.`post_title` LIKE '%$url%' AND `all_posts`.`ID` IN($store_coupons_arr_imp)");
    $arr_store_id = $filter[0];
    $arr_cat_id = $filter[1];
    
    $arr_store_id = implode(',',$arr_store_id);
    $arr_cat_id = implode(',',$arr_cat_id);

    ?>
    
    <script type="text/javascript">
        var arr_store_id = '<?php echo $arr_store_id;?>';
        var arr_cat_id = '<?php echo $arr_cat_id; ?>';
        
        alert(arr_store_id + ' | ' + arr_cat_id);
    </script>
    
    <?php
}

$func = $_POST['action'];
    switch ($func) {
        case "populer":
        populer();
        break;
        
        case "store_subscribtion":
        store_subscribtion();
        break;
        
        case "coupons_category":
        coupons_category();
        break;
        
        case "search_page":
        search_page();
        break;
    }


?>