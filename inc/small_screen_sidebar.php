<!---small screen sidebar--->

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
    if($url[0] == 'stores.php' || $url[0] == 'stores'){
        
    }else{
        $coupon_cat_stores_arr = [];
        $coupon_cat_stores = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_terms`.`slug` = '$url[1]' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' ORDER BY `all_posts`.`ID` DESC";
        $coupon_cat_stores_query = mysqli_query($conn,$coupon_cat_stores);
        if(mysqli_num_rows($coupon_cat_stores_query) > 0){
            while($coupon_cat_stores_row = mysqli_fetch_assoc($coupon_cat_stores_query)){
                $coupon_cat_id = $coupon_cat_stores_row['ID'];
                array_push($coupon_cat_stores_arr, $coupon_cat_id);
            }
        }
        if(!empty($coupon_cat_stores_arr)){
            $coupon_store_ids = array_unique($coupon_cat_stores_arr);
            $coupon_store_ids = implode(',',$coupon_store_ids);
            $coupon_store_sql = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`object_id` IN ($coupon_store_ids) GROUP BY `wp_terms`.`slug` ORDER BY `all_posts`.`ID` DESC";
            $coupon_store_query = mysqli_query($conn,$coupon_store_sql);
            if(mysqli_num_rows($coupon_store_query) > 0){
        ?>
                <div class="small_filter small_stores ">
                    <div class="pan row">
                        <h5 class="col-xs-7">Top Stores</h5>
                        <div class="col-xs-5 text-right">
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="pan_body">
                        <!--<div class="input-group">
                            <span class="input-group-addon fa fa-search"></span>
                            <input type="text" class="form-control" name="store" id="store" placeholder="Type Store Name" />
                        </div>-->
                        
                        <div class="fil-options ct">
                            <?php
                                while($coupon_store_row = mysqli_fetch_array($coupon_store_query)){
                                    $coupon_store_slug = $coupon_store_row['slug'];
                                    $coupon_store_name = str_ireplace('-',' ',ucwords($coupon_store_slug));
                                ?>
                                    <span class="st<?php echo $coupon_store_slug; ?>"><div class="boxx"></div><input type="checkbox" name="store" value="<?php echo $coupon_store_slug; ?>" id="dis-<?php echo $coupon_store_slug; ?>" ng-model="dis<?php echo str_ireplace('-','',$coupon_store_slug); ?>" ng-checked="dis<?php echo str_ireplace('-','',$coupon_store_slug); ?>" title="<?php echo $coupon_store_slug; ?>"/> <label for="dis-<?php echo $coupon_store_slug; ?>"><?php echo $coupon_store_name; ?></label></span><br class="smethng" />
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
        }
    }
    ?>
    
    
    <?php
        $coupty_sql = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_terms`.`slug` = '$url[1]' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` IN('stores','coupon_category') GROUP BY `all_posts`.`coupon_type` ORDER BY `all_posts`.`ID` DESC";
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
                    <span class="ct_<?php echo $coupty_slug; ?>"><div class="boxx"></div><input type="checkbox" name="ct" value="<?php echo $coupty_slug; ?>" id="coup-<?php echo $coupty_slug; ?>" ng-model="coup<?php echo str_ireplace('-','',$coupty_slug); ?>" ng-checked="coup<?php echo str_ireplace('-','',$coupty_slug); ?>" title="<?php echo $coupty_slug; ?>"/> <label for="coup-<?php echo $coupty_slug; ?>"><?php echo $coupty_name; ?></label></span><br class="smethng"/>
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
        $discty_sql = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_terms`.`slug` = '$url[1]' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` IN('stores','coupon_category') GROUP BY `all_posts`.`discount_type` ORDER BY `all_posts`.`ID` DESC";
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
                    <span class="ct_<?php echo $discy_slug; ?>" ><div class="boxx"></div><input type="checkbox" name="dt" value="<?php echo $discy_slug; ?>" id="dis-<?php echo $discy_slug; ?>" ng-model="dis<?php echo str_ireplace('-','',$discy_slug); ?>" ng-checked="dis<?php echo str_ireplace('-','',$discy_slug); ?>" title="<?php echo $discy_slug; ?>"/> <label for="dis-<?php echo $discy_slug; ?>"><?php echo $discy_name; ?></label></span><br class="smethng" />
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
    
    
    
    <!--Category-->
    <?php
        $store_cat_arr = [];
        $store_cat_sql = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_terms`.`slug` = '$url[1]' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores' ORDER BY `all_posts`.`ID` DESC";
        $store_cat_query = mysqli_query($conn,$store_cat_sql);
        if(mysqli_num_rows($store_cat_query) > 0){
            while($store_cat_row = mysqli_fetch_assoc($store_cat_query)){
                $store_cat_id = $store_cat_row['ID'];
                array_push($store_cat_arr,$store_cat_id);
            }
        }
        
        if(!empty($store_cat_arr)){
            //implode(',',$store_cat_arr);
            $store_cat_ids = array_unique($store_cat_arr);
            $store_cat_ids = implode(',',$store_cat_ids);
            $cat_sql = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' AND `wp_term_relationships`.`object_id` IN ($store_cat_ids) GROUP BY `wp_terms`.`slug` ORDER BY `all_posts`.`ID` DESC";
            $cat_query = mysqli_query($conn,$cat_sql);
            
            if(mysqli_num_rows($cat_query) > 0){
            ?>
            <div class="small_filter small_stores ">
                <div class="pan row">
                    <h5 class="col-xs-7">Category</h5>
                    <div class="col-xs-5 text-right">
                        <i class="fa fa-chevron-down"></i>
                    </div>
                </div>
                
                <div class="pan_body">
                    <div class="fil-options ct">
                        <?php
                        while($cat_row = mysqli_fetch_array($cat_query)){
                            $cat_slug = $cat_row['slug'];
                            $cat_name = str_ireplace('-',' ',ucwords($cat_slug));
                        ?>
                            <span class="st<?php echo $cat_slug; ?>" ><div class="boxx"></div><input type="checkbox" name="cat" value="<?php echo $cat_slug; ?>" id="dis-<?php echo $cat_slug; ?>" ng-model="dis<?php echo str_ireplace('-','',$cat_slug); ?>" ng-checked="dis<?php echo str_ireplace('-','',$cat_slug); ?>" title="<?php echo $cat_slug; ?>"/> <label for="dis-<?php echo $cat_slug; ?>"><?php echo $cat_name; ?></label></span><br class="smethng" />
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
        }
    ?>
</div><!---small_side_opt--->

<div class="row small_clepp">
    
    <div class="col-xs-6 clear text-center">
        <button type="button" class="reset">Clear</button>
    </div><!---clear--->
    
    <div class="col-xs-6 apply text-center">
        <button type="button">Apply</button>
    </div><!---apply--->
    
</div>
    
<div class="row small_cat_des">
    <div class="cat_des">
        <h5><b><?php echo $store_name; ?></b></h5>
        <p><?php echo $store_des; ?></p>
    </div>
    <br /><br />
</div>
<div style="padding-bottom: 75px;"></div>
