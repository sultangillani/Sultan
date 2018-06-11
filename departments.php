<?php include_once 'inc/header.php';?>

<section class="department_categories">
    <div class="deca_heading">
        <div id="conte" class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h2>Browse Top Categories</h2>
                </div>
            </div>
        </div><!---conte--->
    </div><!---deca_heading--->
    <div class="department_cats">
        <div id="conte" class="container">
            <?php
                $department_sql = "SELECT `wp_terms`.*,`wp_term_taxonomy`.*,`wp_term_relationships`.* FROM `wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_terms`.`term_id` = `wp_term_taxonomy`.`term_taxonomy_id` AND `wp_terms`.`term_id` = `wp_term_relationships`.`term_taxonomy_id` AND `wp_term_taxonomy`.`taxonomy` IN ('coupon_category') GROUP BY `wp_terms`.`term_id`";
                $department_query = mysqli_query($conn,$department_sql);
                if(mysqli_num_rows($department_query) > 0){
                    ?>
                        <div class="row cat_boxes">
                            <?php
                            while($department_row = mysqli_fetch_assoc($department_query)){
                                $department_id = $department_row['term_id'];
                                $department_name = $department_row['name'];
                                $department_slug = $department_row['slug'];
                                $department_tax = $department_row['taxonomy'];
                                $department_term_icon = $department_row['term_icon'];
                                $department_term_type = $department_row['term_type'];
                                ?>
                                <div class="col-sm-2 col-xs-3 cat cat_<?php echo $department_slug;?>">
                                    <div class="cat_box">
                                        <a href="<?php echo path_url('/retail_pro');?>/coupons-category/<?php echo $department_slug; ?>" target="_blank">
                                            <i class="<?php echo $department_term_icon;?>"></i>
                                            <span><?php echo $department_name;?></span>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <input type="button" class="btn btn-link load_more_dep load_btn" value="Load More Categories"/>
                        <input type="button" class="btn btn-link show_less_dep load_btn" value="Show Less Categories"/>
                        
                    <?php
                }
            ?>
            
            <?php
            $store_query = "SELECT `wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.*,`wp_clpr_storesmeta`.* FROM `wp_term_relationships`,`wp_terms`,`wp_term_taxonomy`,`wp_clpr_storesmeta` WHERE `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_clpr_storesmeta`.`meta_key` = 'clpr_store_image_id' AND `wp_terms`.`term_id` = `wp_clpr_storesmeta`.`stores_id` GROUP BY `wp_terms`.`term_id` ORDER BY `wp_term_taxonomy`.`count` DESC";
            $store_result = mysqli_query($conn,$store_query);
            if(mysqli_num_rows($store_result) > 0){
                ?>
                <hr />
                <h3>Browse Popular Stores</h3>
                <div class="row store_boxes">
                    <?php
                    while($store_row = mysqli_fetch_assoc($store_result)){
                        $store_meta_value = $store_row['meta_value'];
                        $store_id = $store_row['term_id'];
                        $store_name = $store_row['name'];
                        $store_slug = $store_row['slug'];
                        $store_taxonomy = $store_row['taxonomy'];
                        
                        //term_image
                        $term_image = "SELECT `all_posts`.* FROM `all_posts` WHERE `all_posts`.`ID` = '$store_meta_value'";
                        $term_image_query = mysqli_query($conn,$term_image);
                        if(mysqli_num_rows($term_image_query) > 0){
                            $term_image_row = mysqli_fetch_assoc($term_image_query);
                            $store_image = $term_image_row['guid'];
                        }
                        
                        ?>
                            <div class="col-sm-2 col-xs-3 cat store_bx_<?php echo $store_id; ?>">
                                <a href="<?php echo path_url('/retail_pro'); ?>/stores/<?php echo $store_slug; ?>" target="_blank">
                                    <div class="cat_box store_box">
                                        <img src="<?php echo $store_image; ?>" alt="<?php echo $store_slug; ?>" class=""/>
                                    </div>
                                </a>
                                
                                <a href=""><?php echo $store_name; ?></a>
                            </div>
                        <?php
                    }
                    ?>
                </div>
                <input type="button" class="btn btn-link load_more_de load_btn" value="Load More Stores"/>
                <input type="button" class="btn btn-link show_less_de load_btn" value="Show Less Stores"/>
                <?php
            }
            ?>
            
            
        </div><!---conte--->
    </div><!---department_cats--->
    
    
</section>
<?php include_once 'inc/footer.php';?>