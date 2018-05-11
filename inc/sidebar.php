
<?php
    global $url;
    if($url[0] == 'stores.php' || $url[0] == 'stores'){
    
    $stre_img = "SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.`taxonomy`, `wp_clpr_storesmeta`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships`,`wp_clpr_storesmeta` WHERE `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_key`= 'clpr_store_image_id' AND `wp_clpr_storesmeta`.`stores_id` = `wp_terms`.`term_id` AND `wp_clpr_storesmeta`.`meta_value` = `all_posts`.`ID` AND `wp_terms`.`term_id` = $store_id GROUP BY `wp_terms`.`term_id`";
    $stre_query = mysqli_query($conn,$stre_img);
    $stre_row = mysqli_fetch_array($stre_query);
    $stre_guid = $stre_row['guid'];
    
    //store_img_url
    $stre_url = "SELECT `wp_clpr_storesmeta`.* FROM `wp_clpr_storesmeta` WHERE `wp_clpr_storesmeta`.`meta_key` = 'clpr_store_url' AND `wp_clpr_storesmeta`.`stores_id` = $store_id";
    $stre_url_q = mysqli_query($conn,$stre_url);
    $stre_url_row = mysqli_fetch_array($stre_url_q);
    $stre_permalink = $stre_url_row['meta_value'];
    
?>
<div class="filter">
    <div class="store_imgz">
        <div class="st_img">
            <a href="<?php echo $stre_permalink;?>"><img src="<?php echo $stre_guid;?>" alt="<?php echo $store_name; ?>" class="img-responsive"/></a>
        </div>
        <div class="st_fav">
            <a href=""><i class="fa fa-heart-o"></i> <span>Add Favorite</span></a>
        </div>
    </div>
</div> <br /><br />
<?php
}
?>
<h4>32 Offers Available</h4>
<span class="fil_app"><u></u> Filter Applied</span>
<a href="" class="reset">Reset All</a>
<br /><br /><br />

<div class="filter stores">
    <?php
    if($url[0] == 'stores.php' || $url[0] == 'stores'){
        
    }else{
    ?>
    <h5>Top Stores</h5>
    <div class="input-group">
        <span class="input-group-addon fa fa-search"></span>
        <input type="text" class="form-control" name="store" id="store" placeholder="Type Store Name" />
    </div>
    
    <div class="fil-options stre">
        <span><input type="checkbox" name="stores[]" value="forever21" id="leb-1" ng-model="leb1" ng-checked="leb1"/> <label for="leb-1">Forever21</label></span><br/>
        <span><input type="checkbox" name="stores[]" value="forever21" id="leb-2" ng-model="leb2" ng-checked="leb2"/> <label for="leb-2">Forever21</label></span><br/>
        <span><input type="checkbox" name="stores[]" value="forever21" id="leb-3" ng-model="leb3" ng-checked="leb3"/> <label for="leb-3">Forever21</label></span><br/>
        <span><input type="checkbox" name="stores[]" value="forever21" id="leb-4" ng-model="leb4" ng-checked="leb4"/> <label for="leb-4">Forever21</label></span><br/>
        <span><input type="checkbox" name="stores[]" value="forever21" id="leb-5" ng-model="leb5" ng-checked="leb5"/> <label for="leb-5">Forever21</label></span><br/>
    </div>
    <button class="show_all show_btn">Show all</button>
    <button class="show_less show_btn">Show less</button>
    <br /><br />
     <?php
    }
    ?>
    
    
    <?php
        $coupty_sql = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_terms`.`slug` = '$url[1]' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores' GROUP BY `all_posts`.`coupon_type` ORDER BY `all_posts`.`ID` DESC";
        $coupty_query = mysqli_query($conn,$coupty_sql);
        if(mysqli_num_rows($coupty_query) > 0){
    ?>
    <h5>Coupon Type</h5>
    <div class="fil-options ct cta">
            <?php
            while($coupty_row = mysqli_fetch_array($coupty_query)){
                $coupty_slug = $coupty_row['coupon_type'];
                $coupty_name = str_ireplace('-',' ',ucwords($coupty_slug));
                
            ?>
                <span><input type="checkbox" name="ct" value="<?php echo $coupty_slug; ?>" id="coup-<?php echo $coupty_slug; ?>" ng-model="coup<?php echo str_ireplace('-','',$coupty_slug); ?>" ng-checked="coup<?php echo str_ireplace('-','',$coupty_slug); ?>" title="<?php echo $coupty_slug; ?>"/> <label for="coup-<?php echo $coupty_slug; ?>"><?php echo $coupty_name; ?></label></span><br/>
            <?php
            }
            ?>
    </div>
    <button class="show_all show_btn">Show all</button>
    <button class="show_less show_btn">Show less</button>
    <br /><br />
    <?php
        }
    ?>
    
    <!--Discount Type-->
    
    <?php
        $discty_sql = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_terms`.`slug` = '$url[1]' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores' GROUP BY `all_posts`.`discount_type` ORDER BY `all_posts`.`ID` DESC";
        $discy_query = mysqli_query($conn,$discty_sql);
        if(mysqli_num_rows($discy_query) > 0){
    ?>
    <h5>Discount Type</h5>
    <div class="fil-options ct cta">
        <?php
        while($discy_row = mysqli_fetch_array($discy_query)){
            $discy_slug = $discy_row['discount_type'];
            $discy_name = str_ireplace('-',' ',ucwords($discy_slug));
        ?>
            <span><input type="checkbox" name="dt" value="<?php echo $discy_slug; ?>" id="dis-<?php echo $discy_slug; ?>" ng-model="dis<?php echo str_ireplace('-','',$discy_slug); ?>" ng-checked="dis<?php echo str_ireplace('-','',$discy_slug); ?>" title="<?php echo $discy_slug; ?>"/> <label for="dis-<?php echo $discy_slug; ?>"><?php echo $discy_name; ?></label></span><br/>
        <?php
        }
        ?>
    </div>
    <button class="show_all show_btn">Show all</button>
    <button class="show_less show_btn">Show less</button>
    <br /><br />
    <?php
        }
    ?>
    
    
    <!--Discount Type-->
    
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
    <h5>Category</h5>
    <div class="fil-options ct cta">
        <?php
        while($cat_row = mysqli_fetch_array($cat_query)){
            $cat_slug = $cat_row['slug'];
            $cat_name = str_ireplace('-',' ',ucwords($cat_slug));
        ?>
            <span><input type="checkbox" name="cat" value="<?php echo $cat_slug; ?>" id="dis-<?php echo $cat_slug; ?>" ng-model="dis<?php echo str_ireplace('-','',$cat_slug); ?>" ng-checked="dis<?php echo str_ireplace('-','',$cat_slug); ?>" title="<?php echo $cat_slug; ?>"/> <label for="dis-<?php echo $cat_slug; ?>"><?php echo $cat_name; ?></label></span><br/>
        <?php
        }
        ?>
    </div>
    <button class="show_all show_btn">Show all</button>
    <button class="show_less show_btn">Show less</button>
    <br /><br />
    <?php
        }
    }
    ?>
    
    <div class="cat_des">
        <h5><?php echo $store_name; ?></h5>
        <p><?php echo $store_des; ?></p>
    </div>
    <br /><br />
    
</div>

