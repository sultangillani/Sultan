<?php include_once 'functions.php';

global $url;
if($url[0] == '' || $url[0] == 'index'){
    include_once 'front.php';
}
else if($url[0] == 'coupons-category'){
    
    include_once 'coupons-category.php';
    
}else if($url[0] == 'coupon'){
    
    include_once 'coupon.php';
    
}else if($url[0] == 'stores'){
    
    include_once 'stores.php';
    
}else if($url[0] == 'blog'){
    
    include_once 'blog.php';
    
}else if($url[0] == 'departments' ){
    
    include_once 'departments.php';
    
}else if(($url[0] == 'blog') && $url[1] == 'blog-category'){
    
    include_once 'blog-category.php';
    
}else if($url[0] == 'search'){
    if($url[1] == ''){
        $home_url = path_url('/retail_pro');
        header('Location: '.$home_url);
    }else{
        include_once 'search.php';
    }
}




?>



