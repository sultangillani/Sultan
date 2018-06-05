<?php include_once 'functions.php';

global $url;
if($url[0] == '' || $url[0] == 'index'){
    include_once 'front.php';
}
else if($url[0] == 'coupons-category'){
    
    if($url[1] == ''){
        $home_url = path_url('/retail_pro');
        header('Location: '.$home_url);
    }else{
        include_once 'coupons-category.php';
    }
    
}else if($url[0] == 'coupon'){
    
    include_once 'coupon.php';
    
}else if($url[0] == 'stores'){
    
    if($url[1] == ''){
        $home_url = path_url('/retail_pro');
        header('Location: '.$home_url);
    }else{
        include_once 'stores.php';
    }
    
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
}else if($url[0] == 'tags'){
    if($url[1] == ''){
        $home_url = path_url('/retail_pro');
        header('Location: '.$home_url);
    }else{
        include_once 'tags.php';
    }
}

/*else if($url[0] == 'prac'){
    if($url[1] == ''){
        $home_url = path_url('/retail_pro');
        header('Location: '.$home_url);
    }else{
        include_once 'prac.php';
    }
}*/




?>



