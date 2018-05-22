<?php
if($url[0] == 'search'){
    $store_coupons_arr_imp = $search_postss_arr;
    
    function filter_changes($query){
        global $conn;
        $arr_store_id = [];
        $arr_cat_id = [];
        $coupon_type = [];
        $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $id = $row['term_id'];
                $tax = $row['taxonomy'];
                $couptype = $row['coupon_type'];
                if($tax == 'stores'){
                    array_push($arr_store_id,$id);
                }else if($tax == 'coupon_category'){
                    array_push($arr_cat_id,$id);
                }
                array_push($coupon_type,$couptype);
            }
        }
        $arr_store_id = array_unique($arr_store_id);
        $arr_cat_id = array_unique($arr_cat_id);
        $coupon_type = array_unique($coupon_type);
        return [$arr_store_id,$arr_cat_id,$coupon_type];
    }
    
    if(!empty($checked) && !empty($store_coupons_arr_imp)){
        $filter = filter_changes("SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores','coupon_category') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `all_posts`.`post_title` LIKE '%$url%' AND `all_posts`.`ID` IN($store_coupons_arr_imp) AND `all_posts`.`coupon_type` IN('$ct')");
    }else if(!empty($store_coupons_arr_imp)){
        $filter = filter_changes("SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores','coupon_category') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `all_posts`.`post_title` LIKE '%$url%' AND `all_posts`.`ID` IN($store_coupons_arr_imp)");
    }else if(!empty($checked)){
        $filter = filter_changes("SELECT `all_posts`.*,`wp_terms`.*,`wp_term_taxonomy`.* FROM `all_posts`,`wp_terms`,`wp_term_taxonomy`,`wp_term_relationships` WHERE `wp_term_relationships`.`object_id` = `all_posts`.`ID` AND `all_posts`.`post_status` = 'publish' AND `wp_term_taxonomy`.`taxonomy` IN('stores','coupon_category') AND `wp_term_relationships`.`term_taxonomy_id` = `wp_terms`.`term_id` AND `wp_term_taxonomy`.`term_id` = `wp_terms`.`term_id` AND `all_posts`.`post_title` LIKE '%$url%' AND `all_posts`.`coupon_type` IN('$ct')");
    }
    
    $arr_store_id = $filter[0];
    $arr_cat_id = $filter[1];
    $coupon_type = $filter[2];
    
    
    $arr_store_id = implode(',',$arr_store_id);
    $arr_cat_id = implode(',',$arr_cat_id);
    $coupon_type = implode(',',$coupon_type);
    
    $arr_store_id = '#st' . str_ireplace(',',',#st',$arr_store_id);
    $arr_cat_id = '#st' . str_ireplace(',',',#st',$arr_cat_id);
    $coupon_type = '#ct_' . str_ireplace(',',',#ct_',$coupon_type);
    ?>
    
    <script type="text/javascript">
        
        var arr_store_id = '<?php echo $arr_store_id;?>';
        var arr_cat_id = '<?php echo $arr_cat_id; ?>';
        var coupon_type = "<?php echo $coupon_type; ?>";
        
        var filter_count = $('.ct span').find('input[type="checkbox"]:checked').length;
        filter_count = filter_count / 2;
        $('.ct span').click(function(){
            
            setTimeout(function(){
                if (filter_count > 0) {
                    $('.ct span').find('input[type="checkbox"]').css('display','none');
                    $('.ct span').find('.boxx').css('display','inline-block');
                    
                    //Store
                    $(arr_store_id).find('input[type="checkbox"]').css('display','inline-block');
                    $(arr_store_id).find('.boxx').css('display','none');
                    
                    //cat
                    $(arr_cat_id).find('input[type="checkbox"]').css('display','inline-block');
                    $(arr_cat_id).find('.boxx').css('display','none');
                    
                    //coupon_type
                    $(coupon_type).find('input[type="checkbox"]').css('display','inline-block');
                    $(coupon_type).find('.boxx').css('display','none');
                    
                }else{
                    $('.ct span').find('input[type="checkbox"]').css('display','inline-block');
                    $('.ct span').find('.boxx').css('display','none');
                }
                
            },1000);
            
            
            setTimeout(function(){
                if ($('.ct span').find('input[type="checkbox"]:checked').length > 0) {
                    $('.ct span').find('input[type="checkbox"]').attr('disabled','disabled');
                    for(var st = 0; st < arr_store_id.length; st++){
                        $(arr_store_id[st]).find('input[type="checkbox"]').removeAttr('disabled');
                        alert(arr_store_id[st]);
                    }
                }
                
            },1000);
        });
        
        $('.reset').click(function(){
            $('.ct span').find('input[type="checkbox"]').css('display','inline-block');
            $('.ct span').find('.boxx').css('display','none');
        });
        
    </script>
<?php
var_dump($store_coupons_arr_imp);


}
?>