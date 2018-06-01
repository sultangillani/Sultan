<?php include_once 'inc/header.php'; ?>

<section class="coupons_section_one single_coupon_all">
    <div id="conte" class="container">
        <div class="col-sm-9 main-cont main-containerrr">
            <section class="top-offers">
                
                <?php
                    $single_coupon_query = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_term_taxonomy`.`taxonomy` IN ('stores','coupon_tag','coupon_category') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `all_posts`.`ID` = `wp_term_relationships`.`object_id` AND `all_posts`.`post_name` IN ('$url[1]') GROUP BY `all_posts`.`post_name`";
                    $single_coupon_result = mysqli_query($conn,$single_coupon_query);
                    if(mysqli_num_rows($single_coupon_result) > 0){
                        while($single_coupon_row = mysqli_fetch_assoc($single_coupon_result)){
                            $single_coupon_id = $single_coupon_row['ID'];
                            $single_coupon_title = $single_coupon_row['post_title'];
                            $single_coupon_post_name = $single_coupon_row['post_name'];
                            $single_coupon_content = $single_coupon_row['post_content'];
                            //Meta Value
                            $cat_meta_query = "SELECT `wp_term_relationships`.*,`wp_term_taxonomy`.*,`wp_clpr_storesmeta`.* FROM `wp_term_relationships`,`wp_term_taxonomy`,`wp_clpr_storesmeta` WHERE `object_id` = $single_coupon_id AND `wp_term_taxonomy`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_clpr_storesmeta`.`stores_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_clpr_storesmeta`.`meta_key` = 'clpr_store_image_id'";
                            $cat_meta_result = mysqli_query($conn,$cat_meta_query);
                            if(mysqli_num_rows($cat_meta_result) > 0){
                                $cat_meta_row = mysqli_fetch_assoc($cat_meta_result);
                                $single_coupon_meta = $cat_meta_row['meta_value'];
                            }
                            
                            $single_coupon_sel_image = $single_coupon_row['select_img'];
                            $single_coupon_guid = $single_coupon_row['guid'];
                            $single_coupon_featured = $single_coupon_row['post_featured_image'];
                            $single_coupon_hits = $single_coupon_row['hits'];
                            $single_coupon_expire = $single_coupon_row['expire_date'];
                            $single_coupon_store = $single_coupon_row['name'];
                            $single_coupon_store_slug = $single_coupon_row['slug'];
                            $single_coupon_code = $single_coupon_row['coupon_code'];
                            $single_coupon_code_type = $single_coupon_row['coupon_code_type'];
                            $single_coupon_coupon_type = ucwords(str_ireplace(array('-'),array(' '),$single_coupon_row['coupon_type']));
                            $single_coupon_coupon_type_color = $single_coupon_row['coupon_type_color'];
                            $single_coupon_btn = $single_coupon_row['btn_name'];
                            if($single_coupon_btn == ''){
                                $button_name = 'Get Deal';
                            }else{
                                $button_name = $single_coupon_btn;
                            }
                            
                            $ipadrress = get_client_ip();
                            
                            ?>
                            
                            <!---title--->
                            
                            <div class="row single_coupon">
                                <div class="single_coupon_title col-xs-12">
                                    <h3 class="col-xs-10"><?php echo $single_coupon_title; ?></h3>
                                    <span class="col-xs-2 rate"><i class="fa fa-star-o" aria-hidden="true"></i> <u>Save</u></span>
                                </div>
                                
                                <div class="single_coupon_content col-xs-12">
                                    <div class="row">
                                        <div class="col-xs-2 single_coupon_img">
                                            <?php
                                                if($single_coupon_sel_image == 'featured_image'){
                                                    //Second condition
                                                    if(!empty($single_coupon_featured)){
                                                        ?>
                                                            <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $single_coupon_post_name;?>" target="_blank"><img src="<?php echo $single_coupon_featured;?>" alt="4" class="img-responsive"/></a>
                                                        <?php
                                                    }else{
                                                        $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $single_coupon_meta";
                                                        $sub_sql_query = mysqli_query($conn,$sub_sql);
                                                        $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                                        $store_img_url = $sub_sql_row['guid'];
                                                        ?>
                                                            <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $single_coupon_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                                        <?php
                                                    }
                                                    
                                                }else if($single_coupon_sel_image == 'store_image'){
                                                    $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $single_coupon_meta";
                                                    $sub_sql_query = mysqli_query($conn,$sub_sql);
                                                    $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                                    $store_img_url = $sub_sql_row['guid'];
                                                    ?>
                                                        <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $single_coupon_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                                    <?php
                                                }
                                            ?>
                                        </div>
                                        
                                        <div class="col-xs-10 single_coupon_text">
                                            <span style="color: <?php echo $single_coupon_coupon_type_color; ?>; font-weight:600;"><?php echo $single_coupon_coupon_type; ?></span>
                                            <?php
                                            //coupont-type Values
                                            $coupon_type_query = "SELECT `wp_terms`.*,`wp_term_taxonomy`.*,`wp_term_relationships`.*,`all_posts`.* FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`all_posts` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` IN('coupon_type','stores') AND `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `all_posts`.`ID` = $single_coupon_id";
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
                                            <br /><br />
                                            <p><?php echo $single_coupon_content; ?></p><br />
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="single_coupon_info col-xs-12">
                                    <?php
                                        if ($single_coupon_hits > 999 && $single_coupon_hits <= 999999) {
                                            $result = floor($single_coupon_hits / 1000) . 'K';
                                        } elseif ($single_coupon_hits > 999999) {
                                            $result = floor($single_coupon_hits / 1000000) . 'M';
                                        } else {
                                            $result = $single_coupon_hits;
                                        }
                                    ?>
                                    
                                    <p class="fir" ><i class="fa fa-calendar-times-o"></i>&nbsp;<?php echo date_format(date_create($single_coupon_expire)," d-M-Y");?></p>
                                    
                                    <p>
                                        <?php if($single_coupon_hits > 0){ ?>
                                            <i class="fa fa-eye"></i>&nbsp; <?php echo $result; ?> Views
                                        <?php } ?>
                                    </p>
                                    <p>
                                        <i class="fa fa-home"></i>&nbsp; <a href="<?php echo path_url('/retail_pro');?>/stores/<?php echo $single_coupon_store_slug; ?>" target="_blank" ><?php echo $single_coupon_store; ?></a>
                                    </p>
                                </div>
                                
                                <div class="col-xs-12 buttler pull-right">
                                    <span data-toggle="modal" data-target="#coponer_<?php echo $single_coupon_id;?>"><a href="<?php echo $single_coupon_guid;?>" target="_blank" class="btn btn-primary gd" id="gd_<?php echo $single_coupon_id; ?>" data="<?php echo $single_coupon_code; ?>"><?php echo $button_name;?></a></span>
                                </div>
                            </div>
                            <br />
                            <div class="row single_coupon">
                                <div class="single_coupon_title col-xs-12">
                                    <h3 class="col-xs-12 rinf">Related Information</h3>
                                </div>
                                <hr />
                                
                                <div class="row single_post_tags">
                                    <div class="col-xs-12 store_category">
                                        <?php
                                            $category_query = "SELECT `wp_terms`.*,`wp_term_taxonomy`.*,`wp_term_relationships`.* FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' AND `wp_term_relationships`.`object_id` = $single_coupon_id";
                                            $category_result = mysqli_query($conn,$category_query);
                                            if(mysqli_num_rows($category_result) > 0){
                                                ?>
                                                <p><i class="fa fa-folder-open"></i>&nbsp;&nbsp;<strong>Categories: </strong>&nbsp;
                                                <?php
                                                $i=1;
                                                while($category_row = mysqli_fetch_array($category_result)){
                                                    $category_name = $category_row['name'];
                                                    $category_slug = $category_row['slug'];
                                                    $category_id = $category_row['term_id'];
                                                    if($i < mysqli_num_rows($category_result)){
                                                    ?>
                                                        <a href="<?php echo path_url('/retail_pro');?>/coupons-category/<?php echo $category_slug; ?>"><?php echo $category_name; ?></a>,
                                                    <?php
                                                        $i++;
                                                    }else{
                                                    ?>
                                                        <a href="<?php echo path_url('/retail_pro');?>/coupons-category/<?php echo $category_slug; ?>"><?php echo $category_name; ?></a>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                                </p>
                                            <?php
                                            }
                                        ?>
                                    </div>
                                    
                                    <div class="col-xs-12">
                                        <?php
                                            $tags_query = "SELECT `wp_terms`.*,`wp_term_taxonomy`.*,`wp_term_relationships`.* FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_tag' AND `wp_term_relationships`.`object_id` = $single_coupon_id";
                                            $tags_result = mysqli_query($conn,$tags_query);
                                            if(mysqli_num_rows($tags_result) > 0){
                                                ?>
                                                <p class="store_tags"><i class="fa fa-tags"></i>&nbsp;&nbsp;<strong>Tags: </strong>&nbsp;
                                                <?php
                                                $i=1;
                                                while($tags_row = mysqli_fetch_array($tags_result)){
                                                    $tags_name = $tags_row['name'];
                                                    $tags_slug = $tags_row['slug'];
                                                    $tags_id = $tags_row['term_id'];
                                                    if($i < mysqli_num_rows($tags_result)){
                                                    ?>
                                                        <a href="<?php echo path_url('/retail_pro');?>/tags/<?php echo $tags_slug; ?>"><?php echo $tags_name; ?></a>,
                                                    <?php
                                                        $i++;
                                                    }else{
                                                    ?>
                                                        <a href="<?php echo path_url('/retail_pro');?>/tags/<?php echo $tags_slug; ?>"><?php echo $tags_name; ?></a>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                                </p>
                                            <?php
                                            }
                                        ?>  
                                    </div>
                                    
                                </div>
                                
                            </div>
                            
                            <br />
                            
                            <div class="row single_coupon">
                                <div class="single_coupon_title col-xs-12">
                                    <h3 class="col-xs-12 rinf">Reviews</h3>
                                </div>
                                <hr />
                                <?php
                                    $comment_query = "SELECT * FROM `wp_comments` WHERE `comment_post_ID` = $single_coupon_id AND `comment_approved` = 'approved' ORDER BY `comment_ID` DESC";
                                    $comment_result = mysqli_query($conn,$comment_query);
                                ?>
                                
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
                            <br />
                            <div class="row single_coupon">
                                <div class="single_coupon_title col-xs-12">
                                    <h3 class="col-xs-12 rinf">Post a Comment</h3>
                                </div>
                                <hr />
                                
                                <div class="msg"></div>
                                <div class="comment-box">
                                    
                                    <form action="comment.php" method="post">
                                        
                                        <div class="form-group">
                                            <label for="firstname">First Name(optional)</label>
                                            <input type="text" class="form-control firstname" id="firstname" name="firstname" placeholder="First Name(optional)" value="<?php echo (isset($fname) && $com_post_id == $single_coupon_id ? $fname : '');?>"/>
                                            <span class="comment_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="add_comment">Add a Comment*</label>
                                            <textarea class="form-control add_comment" rows="3" id="add-comment" name="add_comment" placeholder="Add a Comment..."><?php echo (isset($adcom) && $com_post_id == $single_coupon_id ? $adcom : '');?></textarea>
                                            <span class="comment_error"></span>
                                        </div>
                                        <input type="hidden" value="<?php echo $single_coupon_id; ?>" name="com_post_id" class="com_post_id" id="<?php echo path_url('/retail_pro');?>"/>
                                        <input type="button" name="com_submit" value="Post Comment" class="com-sub"/>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Modal  tabindex="-1" -->
                           
                            <div class="modal fade" id="coponer_<?php echo $single_coupon_id;?>">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                          <h4 class="modal-title" id="myModalLabel"><?php echo $single_coupon_title; ?></h4>
                                        </div>
                                        <div class="modal-body row">
                                          
                                            <div class="col-sm-2 col-xs-3 text-center mod_img">
                                                <?php
                                                if($single_coupon_sel_image == 'featured_image'){
                                                    //Second condition
                                                    if(!empty($single_coupon_featured)){
                                                        ?>
                                                            <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $single_coupon_post_name;?>" target="_blank"><img src="<?php echo $single_coupon_featured;?>" alt="4" class="img-responsive"/></a>
                                                        <?php
                                                    }else{
                                                        $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $single_coupon_meta";
                                                        $sub_sql_query = mysqli_query($conn,$sub_sql);
                                                        $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                                        $store_img_url = $sub_sql_row['guid'];
                                                        ?>
                                                            <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $single_coupon_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                                        <?php
                                                    }
                                                    
                                                }else if($single_coupon_sel_image == 'store_image'){
                                                    $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $single_coupon_meta";
                                                    $sub_sql_query = mysqli_query($conn,$sub_sql);
                                                    $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                                    $store_img_url = $sub_sql_row['guid'];
                                                    ?>
                                                        <a href="<?php echo path_url('/retail_pro');?>/coupon/<?php echo $single_coupon_post_name;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="col-sm-7 col-xs-5 mod_des">
                                                <?php echo excerpt($single_coupon_content,25);?>
                                            </div>
                                            <div class="col-sm-3 col-xs-4 mod_code">
                                                <?php
                                                //SELECT * FROM `all_posts` WHERE `coupon_code` NOT LIKE '%Coupon%' AND `coupon_code` NOT LIKE '%Deal%' AND `coupon_code` != ''
                                                if($single_coupon_code_type == 'real_code'){
                                                ?>
                                                    <input type="text" disabled="disabled" class="form-control codee_<?php echo $single_coupon_id; ?>" value="<?php echo $single_coupon_code; ?>"/>
                                                <?php
                                                }else if($single_coupon_code == ''){
                                                    echo "<span>No Coupon Code Required</span>";
                                                }else{
                                                    echo "<span>$single_coupon_code</span>";
                                                }
                                                ?>
                                                
                                            </div>
                                          
                                        </div>
                                        
                                         <?php
                                              if($single_coupon_code != 'No Coupon Code Required' && $single_coupon_code != 'Deal Activated' && $single_coupon_code != 'Coupon Activated'){
                                                  ?>
                                                  
                                                  <div class="modal-footer">
                                                      <button class="btn btn-primary copy_<?php echo $single_coupon_id; ?>">Copy Code</button>
                                                      <script type="text/javascript">
                                                          $(document).ready(function(){
                                                              function copyToClipboard(element) {
                                                                  var $temp = $("<input>");
                                                                  $("body").append($temp);
                                                                  $temp.val($(element).val()).select();
                                                                  document.execCommand("copy");
                                                                  $temp.remove();
                                                              }
                                                              $('.copy_<?php echo $single_coupon_id; ?>').click(function(){
                                                                  copyToClipboard('.codee_<?php echo $single_coupon_id; ?>');
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
                            
                            <script type="text/javascript">
                                $('.rate i').click(function(){
                                    $(this).toggleClass('star');
                                    if ($(this).hasClass('star')) {
                                        <?php
                                            //To be continued
                                            //$save_post = "INSERT INTO `post_favourite`(`post_id`, `ip_address`, `user`) VALUES ()";
                                        ?>
                                    }
                                });
                                
                                $('.gd').click(function(){
                                    var data_text = $(this).attr('data');
                                    var gd_id = '#' + $(this).attr('id');
                                    $('.single_coupon_all').find(gd_id).each(function(){
                                        $(this).text(data_text);
                                        $(this).css({'color': '#4a4a4a', 'background': '#f5f4f4', 'border': '1px solid #e5e5e5'});
                                    });
                                });
                                
                            </script>
                            
                            
                            <?php
                        }
                    }
                ?>
                
            </section>
        </div>
        <div class="col-sm-3 single_coupon_sidebar">
            
        </div>
    </div>
</section>
<?php include_once 'inc/footer.php'; ?>