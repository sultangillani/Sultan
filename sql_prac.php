<?php include_once 'inc/header.php';?>

<?php
/*
`wp_posts`.`ID`,
`wp_posts`.`post_title`,
`wp_terms`.`name`,
`wp_terms`.`term_id`,
`wp_term_taxonomy`.`taxonomy`,
`wp_clpr_storesmeta`.`meta_key`,
`wp_clpr_storesmeta`.`meta_value` 
*/

//http://promocodess.com
//http://localhost/series/retail_pro
//`post_status` = 'inherit'

//http://promocodess.com/?page_id=2

//UPDATE `all_posts` SET `guid` = REPLACE(`guid`, 'http://www.promocodess.com', 'http://localhost/series/retail_pro') WHERE `post_status` != 'inherit' AND `post_type` = 'coupon'

$store_cat_arr = [];
$store_cat_sql = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_terms`.`slug` = 'treds-coupons' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'stores' ORDER BY `all_posts`.`ID` DESC";
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
    echo $cat_sql = "SELECT `all_posts`.*,`wp_term_relationships`.*,`wp_terms`.*, `wp_term_taxonomy`.* FROM `all_posts`,`wp_term_relationships`,`wp_terms`,`wp_term_taxonomy` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`taxonomy` = 'coupon_category' AND `wp_term_relationships`.`object_id` IN ($store_cat_ids) GROUP BY `wp_terms`.`slug` ORDER BY `all_posts`.`ID` DESC";
    $cat_query = mysqli_query($conn,$cat_sql);
    if(mysqli_num_rows($cat_query) > 0){
        while($cat_row = mysqli_fetch_assoc($cat_query)){
            
        }
    }
}
?>







<?php include_once 'inc/footer.php';?>