
<div class="small_side_top">
    <div class="row">
        <div class="col-xs-7 text-right">
            <b>Refine Results</b>
        </div>
        <div class="col-xs-5 text-right">
            <a href="" class="small_side_cancel">Cancel</a>
        </div>
    </div>
</div><!---small_side_top--->

<div class="small_side_result fil_app">
    <u>No </u>
    Filter Applied
</div><!---small_side_result--->
<br /> <br />

<div class="small_side_opt">
    <?php
        $store_ids = implode(',',$search_page_arr);
        $store_query = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_terms`.`term_id` IN ($store_ids) GROUP BY `wp_terms`.`slug` ORDER BY `all_posts`.`ID` DESC";
        $store_result = mysqli_query($conn,$store_query);
        
        $search_posts_id = implode(',',$search_postss_arr);
        
        if(mysqli_num_rows($store_result) > 0){    
            ?>
                <div class="small_filter small_stores">
                    <div class="pan row">
                        <h5 class="col-xs-7">Stores</h5>
                        <div class="col-xs-5 text-right">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="pan_body">
                        <div class="fil-options ct">
                            <?php
                                while($store_row = mysqli_fetch_assoc($store_result)){
                                        $store_id = $store_row['ID'];
                                        $store_name = $store_row['name'];
                                        $store_slug = $store_row['slug'];
                                    ?>
                                        <span><input type="checkbox" name="store" value="<?php echo $store_slug; ?>" id="dis-<?php echo $store_slug; ?>" ng-model="dis<?php echo str_ireplace('-','',$store_slug); ?>" ng-checked="dis<?php echo str_ireplace('-','',$store_slug); ?>" title="<?php echo $store_slug; ?>"/> <label for="dis-<?php echo $store_slug; ?>"><?php echo $store_name; ?></label></span><br class="smethng" />
                                    <?php
                                }
                            ?>
                        </div>
                        <button class="show_all show_btn">Show all</button>
                        <button class="show_less show_btn">Show less</button>
                        <br /><br />
                    </div>
                </div>
            <?php
        }
    ?>
    
    
    
    <?php
        $coupty_sql = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `all_posts`.`ID` IN ($search_posts_id) AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` IN('stores','coupon_category') GROUP BY `all_posts`.`coupon_type` ORDER BY `all_posts`.`ID` DESC";
        $coupty_query = mysqli_query($conn,$coupty_sql);
        if(mysqli_num_rows($coupty_query) > 0){
    ?>
    <div class="small_filter small_stores ">
        <div class="pan row">
            <h5 class="col-xs-7">Coupon Type</h5>
            <div class="col-xs-5 text-right">
                <i class="fa fa-chevron-down"></i>
            </div>
        </div>
        
        <div class="pan_body">
            <div class="fil-options ct">
                <?php
                while($coupty_row = mysqli_fetch_array($coupty_query)){
                    $coupty_slug = $coupty_row['coupon_type'];
                    $coupty_name = str_ireplace('-',' ',ucwords($coupty_slug));
                    
                ?>
                    <span><input type="checkbox" name="ct" value="<?php echo $coupty_slug; ?>" id="coup-<?php echo $coupty_slug; ?>" ng-model="coup<?php echo str_ireplace('-','',$coupty_slug); ?>" ng-checked="coup<?php echo str_ireplace('-','',$coupty_slug); ?>" title="<?php echo $coupty_slug; ?>"/> <label for="coup-<?php echo $coupty_slug; ?>"><?php echo $coupty_name; ?></label></span><br class="smethng"/>
                <?php
                }
                ?>
            </div>
            <button class="show_all show_btn">Show all</button>
            <button class="show_less show_btn">Show less</button>
            <br /><br />
        </div>
        
    </div>
    <?php
        }
    ?>
    
    
    <!--Discount Type-->
    
    <?php
        $discty_sql = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `all_posts`.`ID` IN ($search_posts_id) AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` IN('stores','coupon_category') GROUP BY `all_posts`.`discount_type` ORDER BY `all_posts`.`ID` DESC";
        $discy_query = mysqli_query($conn,$discty_sql);
        if(mysqli_num_rows($discy_query) > 0){
    ?>
    <div class="small_filter small_stores ">
        <div class="pan row">
            <h5 class="col-xs-7">Discount Type</h5>
            <div class="col-xs-5 text-right">
                <i class="fa fa-chevron-down"></i>
            </div>
        </div>
        
        <div class="pan_body">
            <div class="fil-options ct">
                <?php
                while($discy_row = mysqli_fetch_array($discy_query)){
                    $discy_slug = $discy_row['discount_type'];
                    $discy_name = str_ireplace('-',' ',ucwords($discy_slug));
                ?>
                    <span><input type="checkbox" name="dt" value="<?php echo $discy_slug; ?>" id="dis-<?php echo $discy_slug; ?>" ng-model="dis<?php echo str_ireplace('-','',$discy_slug); ?>" ng-checked="dis<?php echo str_ireplace('-','',$discy_slug); ?>" title="<?php echo $discy_slug; ?>"/> <label for="dis-<?php echo $discy_slug; ?>"><?php echo $discy_name; ?></label></span><br class="smethng" />
                <?php
                }
                ?>
            </div>
            <button class="show_all show_btn">Show all</button>
            <button class="show_less show_btn">Show less</button>
            <br /><br />
        </div>
        
    </div>
    <?php
        }
    ?>
    
</div>