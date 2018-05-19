<?php include_once 'inc/header.php'; ?>
    <section class="coupons_section_one">
        <div id="conte" class="container">   
            <?php
                $search_page_arr = [];
                $search_postss_arr = [];
                $search_page_query = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `all_posts`.`post_title` LIKE '%$url[1]%' GROUP BY `all_posts`.`post_title`";
                $search_page_result = mysqli_query($conn,$search_page_query);
                
                if(mysqli_num_rows($search_page_result) > 0){
                    while($search_page_row = mysqli_fetch_assoc($search_page_result)){
                        $search_page_id = $search_page_row['ID'];
                        $search_page_term_id = $search_page_row['term_id'];
                        $search_page_term_taxonomy = $search_page_row['taxonomy'];
                        
                        //terms
                        array_push($search_page_arr,$search_page_term_id);
                        $search_page_arr = array_unique($search_page_arr);
                        
                        //Posts
                        array_push($search_postss_arr,$search_page_id);
                        $search_postss_arr = array_unique($search_postss_arr);
                        
                    }
                }
            ?>
            <button class="act_sm_sidebar">Hell No</button>
            <div class="col-sm-3 sidebar">
                <?php include_once 'inc/search_sidebar.php'; ?>
            </div>
            
            <div class="small-screen-sidebar col-xs-12">
                <?php include_once 'inc/small_screen_search_sidebar.php'; ?>
            </div>
            <div class="col-sm-9 main-cont main-containerrr">
                <section class="top-offers">
                    
                    <h3 class="store_title">You are Searching for "<?php echo str_ireplace('-',' ',$url[1]);?>"</h3>
                    <?php
                        
                        $number_of_posts = 10;
                        $page_id = 1;
                        $all_posts_query = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `all_posts`.`post_title` LIKE '%$url[1]%'";
                        $all_posts_run = mysqli_query($conn,$all_posts_query);
                        $all_posts = mysqli_num_rows($all_posts_run);
                        $total_pages = ceil($all_posts / $number_of_posts);
                        $posts_starts_from = ($page_id - 1) * $number_of_posts;
                        
                        $search_post_query = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `all_posts`.`post_title` LIKE '%$url[1]%' GROUP BY `all_posts`.`post_title` ORDER BY `all_posts`.`hits` DESC LIMIT $posts_starts_from, $number_of_posts";
                        $search_post_result = mysqli_query($conn,$search_post_query);
                        if(mysqli_num_rows($search_post_result) > 0){
                            while($search_post_row = mysqli_fetch_assoc($search_post_result)){
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
                        }
                    ?>
                </section>
            </div>
        </div>
    </section>
<?php include_once 'inc/footer.php'; ?>