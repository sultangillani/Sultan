<?php

$store_ids = implode(',',$search_page_arr);
$store_query = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores' AND `wp_terms`.`term_id` IN ($store_ids) GROUP BY `wp_terms`.`slug` ORDER BY `all_posts`.`ID` DESC";
$store_result = mysqli_query($conn,$store_query);

?>
<div class="filter stores">
    

    <h5>Stores</h5>
    <?php
    if(mysqli_num_rows($store_result) > 0){
        ?>
            <div class="fil-options ct cta stre">
                <?php
                    while($store_row = mysqli_fetch_assoc($store_result)){
                            $store_id = $store_row['id'];
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
        <?php
    }
    ?>
</div>