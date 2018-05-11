<?php include_once 'inc/header.php';?>

<section class="content-body">
    <div class="featurede container">
        <h3>Shop Today's Trending Deals and Save Big</h3>
            
        <div class="row">
            <div class="col-sm-4 col-xs-6 fries" style="background: url(img/left.jpg) no-repeat;">
                <div class="rgba">
                    <div class="row rg">
                        <div class="col-xs-3">
                          <a href="#" >
                            <img class="media-object" width="65" src="https://www.retailmenot.com/thumbs/logos/m/hotels.com-coupons.jpg?versionId=XEaSs1SVaCK8SvCml3mVTWiFc5JV0Mxs" alt="1" style="margin: 0 auto;">
                          </a>
                        </div><!--media-left-->
                        <div class="col-xs-9">
                            <h5 class="media-heading" style="color: white; font-size: 1.1em; font-weight: bold;">Buy 1 Get 1 50% Off</h5>
                            <span style="color: white; font-size: 0.9em;">Ruby Tuesday In-Store</span>
                        </div>
                    </div><!--media-->
                </div><!--rgba-->
            </div>
            
            <div class="col-sm-4 col-xs-6 fries" style="background: url(img/center.jpg) no-repeat;">
                <div class="rgba">
                    <div class="row rg">
                        <div class="col-xs-3">
                          <a href="#" >
                            <img class="media-object" width="65" src="https://www.retailmenot.com/thumbs/logos/m/hrblock.com-coupons.jpg?versionId=IrUNXY11ErvS5j7QnE7gkzYGyHHHhhvE" alt="1" style="margin: 0 auto;">
                          </a>
                        </div><!--media-left-->
                        <div class="col-xs-9">
                            <h5 class="media-heading" style="color: white; font-size: 1.1em; font-weight: bold;">Buy 1 Get 1 50% Off</h5>
                            <span style="color: white; font-size: 0.9em;">Ruby Tuesday In-Store</span>
                        </div>
                    </div><!--media-->
                </div><!--rgba-->
            </div>
            
            <div class="col-sm-4 col-xs-6 fries" style="background: url(img/right.jpg) no-repeat;">
                <div class="rgba">
                    <div class="row rg">
                        <div class="col-xs-3">
                          <a href="#" >
                            <img class="media-object" width="65" src="https://www.retailmenot.com/thumbs/logos/m/1800contacts.com-coupons.jpg?versionId=IESTHbmIaowCYb1PUByMA8269696sy5v" alt="1" style="margin: 0 auto;">
                          </a>
                        </div><!--media-left-->
                        <div class="col-xs-9">
                            <h5 class="media-heading" style="color: white; font-size: 1.1em; font-weight: bold;">Buy 1 Get 1 50% Off</h5>
                            <span style="color: white; font-size: 0.9em;">Ruby Tuesday In-Store</span>
                        </div>
                    </div><!--media-->
                </div><!--rgba-->
            </div>
            
        </div>
    </div>
</section>
<br /><br />

<section class="featured_thumb">
    <div class="container">
        <div class="row">
            <?php
            $sql = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` GROUP BY `wp_terms`.`term_id` ORDER BY `all_posts`.`post_date` DESC LIMIT 6";
            $sql_query = mysqli_query($conn,$sql);
                if(mysqli_num_rows($sql_query) > 0){
                    while($sql_row = mysqli_fetch_array($sql_query)){
                        $sql_id = $sql_row['ID'];
                        $sql_featured = $sql_row['post_featured_image'];
                        $sql_sel_image = $sql_row['select_img'];
                        $sql_sel_title = $sql_row['post_title'];
                        $sql_post_name = $sql_row['post_name'];
                        $sql_store_image_id = $sql_row['meta_value'];
                        $sql_guid = $sql_row['guid'];
                        $sql_des = $sql_row['post_content'];
                        $sql_code = $sql_row['coupon_code'];
                        $sql_code_type = $sql_row['coupon_code_type'];
                        
                        ?>
                        <div class="col-md-2 col-sm-4 col-xs-6 text-center b" id="store_coupon_<?php echo $sql_id; ?>">
                            <div class="thumbnail" style="border: 0px;" data-toggle="modal" data-target="#coupon_<?php echo $sql_id;?>">
                            <?php
                                
                                if($sql_sel_image == 'featured_image'){
                                    //Second condition
                                    if(!empty($sql_featured)){
                                        ?>
                                        <div class="img">
                                            <a href="<?php echo $sql_guid;?>" target="_blank"><img src="<?php echo $sql_featured;?>" alt="4" class="img-responsive"/></a>
                                        </div>
                                        <?php
                                    }else{
                                        $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $sql_store_image_id";
                                        $sub_sql_query = mysqli_query($conn,$sub_sql);
                                        $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                        $store_img_url = $sub_sql_row['guid'];
                                        ?>
                                        <div class="img">
                                            <a href="<?php echo $sql_guid;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                        </div>
                                        <?php
                                    }
                                    
                                }else if($sql_sel_image == 'store_image'){
                                    $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $sql_store_image_id";
                                    $sub_sql_query = mysqli_query($conn,$sub_sql);
                                    $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                    $store_img_url = $sub_sql_row['guid'];
                                    ?>
                                    <div class="img">
                                        <a href="<?php echo $sql_guid;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                    </div>
                                    <?php
                                }
                            ?>
                                <div class="caption">
                                    <p><a href="<?php echo $sql_guid;?>" target="_blank"><?php echo $sql_sel_title;?></a></p>
                                </div><!--Caption-->
                            </div>
                        </div>
                        <?php
                        
                        ?>
                        <!-- Modal  tabindex="-1" -->
                        <div class="modal fade" id="coupon_<?php echo $sql_id;?>">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel"><?php echo $sql_sel_title; ?></h4>
                              </div>
                              <div class="modal-body row">
                                
                                <div class="col-sm-2 col-xs-3 text-center mod_img">
                                    <?php
                                    if($sql_sel_image == 'featured_image'){
                                        //Second condition
                                        if(!empty($sql_featured)){
                                            ?>
                                                <a href="<?php echo $sql_guid;?>" target="_blank"><img src="<?php echo $sql_featured;?>" alt="4" class="img-responsive"/></a>
                                            <?php
                                        }else{
                                            $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $sql_store_image_id";
                                            $sub_sql_query = mysqli_query($conn,$sub_sql);
                                            $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                            $store_img_url = $sub_sql_row['guid'];
                                            ?>
                                                <a href="<?php echo $sql_guid;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                            <?php
                                        }
                                        
                                    }else if($sql_sel_image == 'store_image'){
                                        $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $sql_store_image_id";
                                        $sub_sql_query = mysqli_query($conn,$sub_sql);
                                        $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                        $store_img_url = $sub_sql_row['guid'];
                                        ?>
                                            <a href="<?php echo $sql_guid;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-7 col-xs-5 mod_des">
                                    <?php echo excerpt($sql_des,25);?>
                                </div>
                                <div class="col-sm-3 col-xs-4 mod_code">
                                    <?php
                                    if($sql_code_type == 'real_code'){
                                    ?>
                                        <input type="text" disabled="disabled" class="form-control codee_<?php echo $sql_id; ?>" value="<?php echo $sql_code; ?>"/>
                                    <?php
                                    }else if($sql_code == ''){
                                        echo "<span>No Coupon Code Required</span>";
                                    }else{
                                        echo "<span>$sql_code</span>";
                                    }
                                    ?>
                                    
                                </div>
                                
                              </div>
                              
                               <?php
                                    if($sql_code != 'No Coupon Code Required' && $sql_code != 'Deal Activated' && $sql_code != 'Coupon Activated'){
                                        ?>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary copy_<?php echo $sql_id; ?>">Copy Code</button>
                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                    function copyToClipboard(element) {
                                                        var $temp = $("<input>");
                                                        $("body").append($temp);
                                                        $temp.val($(element).val()).select();
                                                        document.execCommand("copy");
                                                        $temp.remove();
                                                    }
                                                    $('.copy_<?php echo $sql_id; ?>').click(function(){
                                                        copyToClipboard('.codee_<?php echo $sql_id; ?>');
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
                      
                      <?php
                    }
                }//No Coupon Code Required
                //clpr_coupon_code
            ?>
        </div>
    </div>
</section>

<section class="top-offers">
    <div class="container">
        <h3>Top Offers</h3>
        <?php
            $top_offer = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.*, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` GROUP BY `wp_terms`.`term_id` ORDER BY `all_posts`.`hits` DESC LIMIT 10";
            $top_offer_query = mysqli_query($conn,$top_offer);
            if(mysqli_num_rows($top_offer_query) > 0){
                while($top_offer_row = mysqli_fetch_array($top_offer_query)){
                    $to_id = $top_offer_row['ID'];
                    $to_title = $top_offer_row['post_title'];
                    $to_post_name = $top_offer_row['post_name'];
                    $to_content = $top_offer_row['post_content'];
                    $to_meta = $top_offer_row['meta_value'];
                    $to_sel_image = $top_offer_row['select_img'];
                    $to_guid = $top_offer_row['guid'];
                    $to_featured = $top_offer_row['post_featured_image'];
                    $to_hits = $top_offer_row['hits'];
                    $to_expire = $top_offer_row['expire_date'];
                    $to_code = $top_offer_row['coupon_code'];
                    $to_code_type = $top_offer_row['coupon_code_type'];
                    $to_btn = $top_offer_row['btn_name'];
                        
                    if($to_btn == ''){
                        $button_name = 'Get Deal';
                    }else{
                        $button_name = $to_btn;
                    }
                    ?>
                    <div class="post-contain-one">
                        <div class="row post-one poco_<?php echo $to_id;?>">
                            <div class="col-xs-2 post-img-one">
                                <?php
                                    if($to_sel_image == 'featured_image'){
                                        //Second condition
                                        if(!empty($to_featured)){
                                            ?>
                                                <a href="<?php echo $to_guid;?>" target="_blank"><img src="<?php echo $to_featured;?>" alt="4" class="img-responsive" data-toggle="modal" data-target="#copon_<?php echo $to_id;?>" /></a>
                                            <?php
                                        }else{
                                            $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $to_meta";
                                            $sub_sql_query = mysqli_query($conn,$sub_sql);
                                            $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                            $store_img_url = $sub_sql_row['guid'];
                                            ?>
                                                <a href="<?php echo $to_guid;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive" data-toggle="modal" data-target="#copon_<?php echo $to_id;?>" /></a>
                                            <?php
                                        }
                                        
                                    }else if($to_sel_image == 'store_image'){
                                        $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $to_meta";
                                        $sub_sql_query = mysqli_query($conn,$sub_sql);
                                        $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                        $store_img_url = $sub_sql_row['guid'];
                                        ?>
                                            <a href="<?php echo $to_guid;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive" data-toggle="modal" data-target="#copon_<?php echo $to_id;?>"/></a>
                                        <?php
                                    }
                                ?>
                            </div>
                            <div class="col-xs-10 post-mid">
                                
                                <div class="row post-mid-one">
                                    <div class="col-xs-8 to">
                                        <?php
                                        //coupont-type Values
                                        $coupon_type_query = "SELECT `wp_terms`.*,`wp_term_taxonomy`.*,`wp_term_relationships`.*,`all_posts`.* FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`all_posts` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` IN('coupon_type','stores') AND `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `all_posts`.`ID` = $to_id";
                                        $coupon_type_result = mysqli_query($conn,$coupon_type_query);
                                        if(mysqli_num_rows($coupon_type_result) > 0){
                                            while($coupon_type_row = mysqli_fetch_array($coupon_type_result)){
                                                $ct_tax = $coupon_type_row['taxonomy'];
                                                $ct_name = $coupon_type_row['name'];
                                                $ct_color = $coupon_type_row['type_color'];
                                                if($ct_tax == 'coupon_type'){
                                                    ?>
                                                        <span style="color: <?php echo $ct_color; ?>; font-weight:600;"><?php echo $ct_name; ?></span>
                                                    <?php
                                                }
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
                                        <h3 data-toggle="modal" data-target="#copon_<?php echo $to_id;?>">
                                            <a href="<?php echo $to_guid;?>" target="_blank"class="post-one-title"><?php echo $to_title?></a>
                                        </h3>
                                        <br />
                                        
                                        <?php
                                        if ($to_hits > 999 && $to_hits <= 999999) {
                                            $result = floor($to_hits / 1000) . 'K';
                                        } elseif ($to_hits > 999999) {
                                            $result = floor($to_hits / 1000000) . 'M';
                                        } else {
                                            $result = $to_hits;
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
                                        <?php if($to_hits > 0){?>
                                            <span><?php echo $result; ?> Viewed</span>
                                        <?php } ?>
                                    </div>
                                    <div class="col-xs-4 text-right">
                                        <span data-toggle="modal" data-target="#copon_<?php echo $to_id;?>" style="display:block;"><a href="<?php echo $to_guid;?>" target="_blank" class="btn btn-primary gd"><?php echo $button_name; ?></a></span>
                                    </div>
                                </div>
                            </div>
                        </div><!--poco-->
                        
                        <!-- Modal  tabindex="-1" -->
                        <div class="modal fade" id="copon_<?php echo $to_id;?>">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel"><?php echo $to_title; ?></h4>
                              </div>
                              <div class="modal-body row">
                                
                                <div class="col-sm-2 col-xs-3 text-center mod_img">
                                    <?php
                                    if($to_sel_image == 'featured_image'){
                                        //Second condition
                                        if(!empty($to_featured)){
                                            ?>
                                                <a href="<?php echo $to_guid;?>" target="_blank"><img src="<?php echo $to_featured;?>" alt="4" class="img-responsive"/></a>
                                            <?php
                                        }else{
                                            $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $to_meta";
                                            $sub_sql_query = mysqli_query($conn,$sub_sql);
                                            $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                            $store_img_url = $sub_sql_row['guid'];
                                            ?>
                                                <a href="<?php echo $to_guid;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                            <?php
                                        }
                                        
                                    }else if($to_sel_image == 'store_image'){
                                        $sub_sql = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`post_status` IN ('publish','inherit') AND `all_posts`.`ID` = $to_meta";
                                        $sub_sql_query = mysqli_query($conn,$sub_sql);
                                        $sub_sql_row = mysqli_fetch_array($sub_sql_query);
                                        $store_img_url = $sub_sql_row['guid'];
                                        ?>
                                            <a href="<?php echo $to_guid;?>" target="_blank"><img src="<?php echo $store_img_url;?>" alt="4" class="img-responsive"/></a>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="col-sm-7 col-xs-5 mod_des">
                                    <?php echo excerpt($to_content,25);?>
                                </div>
                                <div class="col-sm-3 col-xs-4 mod_code">
                                    <?php
                                    //SELECT * FROM `all_posts` WHERE `coupon_code` NOT LIKE '%Coupon%' AND `coupon_code` NOT LIKE '%Deal%' AND `coupon_code` != ''
                                    if($to_code_type == 'real_code'){
                                    ?>
                                        <input type="text" disabled="disabled" class="form-control codee_<?php echo $to_id; ?>" value="<?php echo $to_code; ?>"/>
                                    <?php
                                    }else if($to_code == ''){
                                        echo "<span>No Coupon Code Required</span>";
                                    }else{
                                        echo "<span>$to_code</span>";
                                    }
                                    ?>
                                    
                                </div>
                                
                              </div>
                              
                               <?php
                                    if($to_code != 'No Coupon Code Required' && $to_code != 'Deal Activated' && $to_code != 'Coupon Activated'){
                                        ?>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary copy_<?php echo $to_id; ?>">Copy Code</button>
                                            <script type="text/javascript">
                                                $(document).ready(function(){
                                                    function copyToClipboard(element) {
                                                        var $temp = $("<input>");
                                                        $("body").append($temp);
                                                        $temp.val($(element).val()).select();
                                                        document.execCommand("copy");
                                                        $temp.remove();
                                                    }
                                                    $('.copy_<?php echo $to_id; ?>').click(function(){
                                                        copyToClipboard('.codee_<?php echo $to_id; ?>');
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
                                        $tags_query = "SELECT `wp_terms`.`term_id`,`wp_term_taxonomy`.`term_id`,`wp_terms`.`name`,`wp_term_taxonomy`.`taxonomy`,`wp_term_relationships`.`object_id` FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_tag' AND `wp_term_relationships`.`object_id` = $to_id";
                                        $tags_result = mysqli_query($conn,$tags_query);
                                    ?>
                                    <div class="col-xs-12">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <?php
                                                if(mysqli_num_rows($tags_result) > 0){
                                            ?>
                                            <li role="presentation"><a href="#exclusions_<?php echo $to_id;?>" aria-controls="exclusions_<?php echo $to_id;?>" role="tab" data-toggle="tab">Exclusions</a></li>
                                            <?php
                                                }
                                            ?>
                                            <li role="presentation"><a href="#details_<?php echo $to_id;?>" aria-controls="details_<?php echo $to_id;?>" role="tab" data-toggle="tab">Details</a></li>
                                            <?php
                                            $comment_query_count = "SELECT * FROM `wp_comments` WHERE `comment_post_ID` = $to_id AND `comment_approved` = 'approved' ORDER BY `comment_ID` DESC";
                                            $comment_result_count = mysqli_query($conn,$comment_query_count);
                                            ?>
                                            <li role="presentation"><a href="#comments_<?php echo $to_id;?>" aria-controls="comments_<?php echo $to_id;?>" role="tab" data-toggle="tab"><?php if(mysqli_num_rows($comment_result_count) != 0){echo mysqli_num_rows($comment_result_count);}?> Comments</a></li>
                                        </ul>
                                        
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <?php
                                            if(mysqli_num_rows($tags_result) > 0){
                                            ?>
                                            <div role="tabpanel" class="tab-pane" id="exclusions_<?php echo $to_id;?>">
                                                <?php
                                                    $tags_query = "SELECT `wp_terms`.`term_id`,`wp_term_taxonomy`.`term_id`,`wp_terms`.`name`,`wp_term_taxonomy`.`taxonomy`,`wp_term_relationships`.`object_id` FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_tag' AND `wp_term_relationships`.`object_id` = $to_id";
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
                                            <div role="tabpanel" class="tab-pane" id="details_<?php echo $to_id;?>">
                                                <p><strong>Expires:</strong>&nbsp;&nbsp;<?php echo date_format(date_create($to_expire)," d | M | Y");?></p>
                                                <p><strong>Details:</strong>&nbsp;<?php echo $to_content; ?></p>    
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="comments_<?php echo $to_id;?>">
                                                <?php
                                                    $comment_query = "SELECT * FROM `wp_comments` WHERE `comment_post_ID` = $to_id AND `comment_approved` = 'approved' ORDER BY `comment_ID` DESC";
                                                    $comment_result = mysqli_query($conn,$comment_query);
                                                ?>
                                                <div class="msg"></div>
                                                <div class="comment-box">
                                                    
                                                    <form action="comment.php" method="post">
                                                        
                                                        <div class="form-group">
                                                            <label for="firstname">First Name(optional)</label>
                                                            <input type="text" class="form-control firstname" id="firstname" name="firstname" placeholder="First Name(optional)" value="<?php echo (isset($fname) && $com_post_id == $to_id ? $fname : '');?>"/>
                                                            <span class="comment_error"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="add_comment">Add a Comment*</label>
                                                            <textarea class="form-control add_comment" rows="3" id="add-comment" name="add_comment" placeholder="Add a Comment..."><?php echo (isset($adcom) && $com_post_id == $to_id ? $adcom : '');?></textarea>
                                                            <span class="comment_error"></span>
                                                        </div>
                                                        <input type="hidden" value="<?php echo $to_id; ?>" name="com_post_id" class="com_post_id" id="<?php echo path_url('/retail_pro');?>" />
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
        
        
    </div>
    
</section>

<section class="sci">
    <div class="container">
        <div class="sci_con">
            <?php
                $store_name_sql = "SELECT `wp_terms`.*,`wp_term_taxonomy`.*,`wp_term_relationships`.* FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores' GROUP BY `wp_terms`.`term_id` ORDER BY `wp_term_taxonomy`.`count` DESC LIMIT 35";
                $sn_query = mysqli_query($conn,$store_name_sql);
                if(mysqli_num_rows($sn_query) > 0){
            ?>
            <div class="row stores">
                <h2 class="sci_swi"><i class="fa fa fa-chevron-up chvrni"></i>Popular Stores</h2>
                <div class="col-xs-12 store-names">
                    
                    <ul class="">
                        <?php
                            while($sn_row = mysqli_fetch_array($sn_query)){
                            $sn_id = $sn_row['term_id'];
                            $sn_name = $sn_row['name'];
                            $sn_slug = $sn_row['slug'];
                        ?>
                            <li class="store_<?php echo $sn_id; ?>"> <a href="<?php echo path_url('/retail_pro'); ?>/stores/<?php echo $sn_slug; ?>" title="<?php echo $sn_slug; ?>" target="_blank"><?php echo $sn_name; ?></a> </li> 
                        <?php
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
                }
            ?>
            
            <?php
            //All Coupon category
            $coupon_category = "SELECT `wp_terms`.*,`wp_term_taxonomy`.*FROM `wp_terms`,`wp_term_taxonomy` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` IN('coupon_category') GROUP BY `wp_terms`.`term_id` ORDER BY `wp_term_taxonomy`.`count` DESC LIMIT 35";
            $cc_query = mysqli_query($conn,$coupon_category);
            if(mysqli_num_rows($cc_query) > 0){
            ?>
            <div class="row stores">
                <h2 class="sci_swi"><i class="fa fa fa-chevron-up chvrni"></i>Popular Categories</h2>
                <div class="col-xs-12 store-names">
                    <ul class="">
                        <?php
                        while($cc_row = mysqli_fetch_array($cc_query)){
                        $cc_id = $cc_row['term_id'];
                        $cc_name = $cc_row['name'];
                        $cc_slug = $cc_row['slug'];
                        ?>
                            <li class="coupon_category_<?php echo $cc_id; ?>"> <a href="<?php echo path_url('/retail_pro'); ?>/coupons-category/<?php echo $cc_slug;?>" title="<?php echo $cc_slug;?>" targe="_blank"><?php echo $cc_name;?></a> </li> 
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>


<?php include_once 'inc/footer.php';?>
