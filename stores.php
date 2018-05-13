<?php include_once 'inc/header.php';?>

<?php
    global $url;
    
?>
<section class="coupons_section_one">
    <div id="conte" class="container">
        
        <div class="row">
            <?php
                $store_page = "SELECT `wp_terms`.*,`wp_term_taxonomy`.*,`wp_term_relationships`.* FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` IN('stores') AND `wp_terms`.`slug` = '$url[1]'";
                $store_page_query = mysqli_query($conn,$store_page);
                $store_page_row = mysqli_fetch_array($store_page_query);
                $store_name = $store_page_row['name'];
                $store_id = $store_page_row['term_id'];
                $store_des = $store_page_row['description'];
            ?>
            <button class="act_sm_sidebar">Filter 20,575 Offers</button>
            
            <div class="col-sm-3 sidebar">
                <?php include_once 'inc/sidebar.php'; ?>
            </div>
            
            <div class="small-screen-sidebar col-xs-12">
                <?php include_once 'inc/small_screen_sidebar.php';?>
            </div>
            
            <div class="col-sm-9 main-cont main-containerrr">
                <section class="top-offers">
                    
                    <!-- Modal -->
                    <div class="modal fade" id="store_modal_<?php echo $store_id; ?>" role="dialog" aria-labelledby="myModalLabel">
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
                        /*<div class="alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Success!</strong> Indicates a successful or positive action.
                        </div>*/
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
                        $number_of_posts = 10;
                        $page_id = 1;
                        $all_posts_query = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('$url[1]')";
                        $all_posts_run = mysqli_query($conn,$all_posts_query);
                        $all_posts = mysqli_num_rows($all_posts_run);
                        $total_pages = ceil($all_posts / $number_of_posts);
                        $posts_starts_from = ($page_id - 1) * $number_of_posts;
                        
                        $stre_img = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.`taxonomy`, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_value` = `all_posts`.`ID` AND `wp_terms`.`term_id` = $store_id GROUP BY `wp_terms`.`term_id`";
                        $stre_query = mysqli_query($conn,$stre_img);
                        $stre_row = mysqli_fetch_array($stre_query);
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
                            <a href="" data-toggle="modal" data-target="#store_modal_<?php echo $store_id; ?>"><i class="fa fa-heart"></i> <span>Add Favorite</span></a>
                        </div>
                    </div>
                    
                    
                    <h3 class="store_title"><?php echo $store_name;?></h3>
                    <ul class="nav nav-tabs big_post" role="tablist">
                        <li class="sort">Sort by: </li>
                        <li role="presentation" class="active"><a href="#popularity" aria-controls="popularity" role="tab" data-toggle="tab">Popularity</a></li>
                        <li role="presentation"><a href="#newest" aria-controls="newest" role="tab" data-toggle="tab">Newest</a></li>
                        <li role="presentation"><a href="#ending" aria-controls="ending" role="tab" data-toggle="tab">Ending</a></li>
                    </ul>
                    <div class="tab-content">
                        
                        
                        <div role="tabpanel" class="tab-pane active" id="popularity">
                            <?php
                            //$store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('walmart-coupons') ORDER BY `wp_term_taxonomy`.`count` DESC LIMIT 0,10";
                            $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('$url[1]') ORDER BY `all_posts`.`hits` DESC LIMIT $posts_starts_from,$number_of_posts";
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
                                                    <h3 data-toggle="modal">
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
                                                    <span data-toggle="modal" data-target="#copon_<?php echo $scq_id;?>" style="display:block;"><a href="<?php echo $scq_guid;?>" target="_blank" class="btn btn-primary gd"  id="gd_<?php echo $scq_id; ?>" data="<?php echo $scq_code; ?>" ><?php echo $button_name;?></a></span>
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
                            }else{
                                ?>
                                <h1>No Coupons are Available</h1>
                                <?php
                            }
                            ?>
                        </div><!---popularity--->
                        
                        
                        
                        <div role="tabpanel" class="tab-pane" id="newest">
                            <?php
                            //$store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('walmart-coupons') ORDER BY `wp_term_taxonomy`.`count` DESC LIMIT 0,10";
                            $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('$url[1]') ORDER BY `all_posts`.`post_date` DESC LIMIT $posts_starts_from,$number_of_posts";
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
                            }else{
                                ?>
                                <h1>No Coupons are Available</h1>
                                <?php
                            }
                            ?>
                        </div><!---newest--->
                        
                        <div role="tabpanel" class="tab-pane" id="ending">
                            <?php
                            $store_coupons = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_terms`.`slug` IN('$url[1]') ORDER BY `all_posts`.`expire_date` ASC, `all_posts`.`ID` DESC LIMIT $posts_starts_from,$number_of_posts";
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
                                                                    <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $scq_post_name;?>" target="_blank"><img src="<?php echo $scq_featured;?>" alt="4" class="img-responsive" /></a>
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
                                                            <span data-toggle="modal" data-target="#coponer_<?php echo $scq_id;?>" style="display:block;"><a href="<?php echo $scq_guid;?>" target="_blank" class="btn btn-primary gd" id="gd_<?php echo $scq_id; ?>" data="<?php echo $scq_code; ?>"><?php echo $button_name;?></a></span>
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
                        
                    </div><!---tab content--->
                    
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
                                var pathname = $('.kbc_uri').val();
                                var us = $('.kbc_uri').attr('placeholder');
                                
                                $('.next_btn').click(function(){
                                    var page_id = <?php echo $page_id; ?>;
                                    var total_posts = <?php echo $all_posts; ?>;
                                    page_id = page_id + 1;
                                    pathname = pathname + '/filter.php';
                                    $.ajax({
                                        method: 'POST',
                                        url: pathname,
                                        data: {action: 'populer', page_id: page_id, usp:us, total_posts: total_posts},
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
                                        data: {action: 'populer', page_id: page_id, usp: us, total_posts: total_posts},
                                        success: function(result){
                                            $('.top-offers').html(result);
                                        }
                                    });
                                });
                                
                            });
                        </script>
                        
                    </div>
                    
                </section>
                
                
            </div><!--main-cont-->
        </div>
        
        <br /><br />
        <div class="row rasf">
            <div class="col-xs-4 pav">
                <h5>People also viewed</h5><br />
                <ul class="list list-links list-multicol">
                    <li class=""> <a href="/view/dominos.com">Domino's</a> </li>
                    <li class=""> <a href="/view/pizzahut.com">Pizza Hut</a> </li>
                    <li class=""> <a href="/view/mcdonalds.com">McDonald's</a> </li>
                    <li class=""> <a href="/view/littlecaesars.com">Little Caesars Pizza</a> </li>
                    <li class=""> <a href="/view/papamurphys.com">Papa Murphy</a> </li>
                    <li class=""> <a href="/view/hungryhowies.com">Hungry Howie's</a> </li>
                    <li class=""> <a href="/view/marcos.com">Marco's Pizza</a> </li>
                    <li class=""> <a href="/view/donatos.com">Donatos</a> </li>
                    <li class=""> <a href="/view/subway.com">Subway</a> </li>
                    <li class=""> <a href="/view/kfc.com">KFC</a> </li>
                </ul>
            </div>
            <div class="col-xs-4 cfss">
                <h5>Coupons for similar stores</h5>
                <ul class="list list-multicol list-links list-overflow">
                    <li class=""> <a href="/view/grubhub.com">GrubHub Promo Codes</a> </li>
                    <li class=""> <a href="/view/pizzahut.com.au">Pizza Hut Australia Coupons</a> </li>
                    <li class=""> <a href="/view/bk.com">Burger King Coupons</a> </li>
                    <li class=""> <a href="/view/arbys.com">Arbys Coupons</a> </li>
                    <li class=""> <a href="/view/dominos.co.uk">Domino's UK Coupons</a> </li>
                </ul>
            </div>
            <div class="col-xs-4 cps">
                <h5>Coupons for popular stores</h5><br />
                <ul class="">
                    <li class=""> <a href="/view/kohls.com" >Kohl's</a> </li>
                    <li class=""> <a href="/view/ubereats.com">UberEATS</a> </li>
                    <li class=""> <a href="/view/jcpenney.com">JCPenney</a> </li>
                    <li class=""> <a href="/view/uber.com">Uber</a> </li>
                    <li class=""> <a href="/view/bedbathandbeyond.com" >Bed Bath And Beyond</a> </li>
                    <li class=""> <a href="/view/amazon.com">Amazon</a> </li>
                    <li class=""> <a href="/view/bathandbodyworks.com" >Bath &amp; Body Works</a> </li>
                    <li class=""> <a href="/view/lyft.com">Lyft</a> </li>
                    <li class=""> <a href="/view/dominos.com.au" >Domino's Australia</a> </li>
                    <li class=""> <a href="/view/postmates.com">Postmates</a> </li>
                    <li class=""> <a href="/view/target.com">Target</a> </li>
                    <li class=""> <a href="/view/macys.com">Macy's</a> </li>
                    <li class=""> <a href="/view/honeybaked.com" >HoneyBaked Ham</a> </li>
                    <li class=""> <a href="/view/payless.com">Payless ShoeSource</a> </li>
                </ul>
                
            </div>
        </div>
        
    </div>
</section>

<?php include_once 'inc/footer.php';?>
