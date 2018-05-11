<?php
//https://www.youtube.com/watch?v=AlpV2TztTrc&list=PLXFM4wDu-CQa2DjmfU2aOqBKWHI0Q_wpk
//https://daneden.github.io/animate.css/

//Include
include_once 'admin/inc/db.php';
ob_start();
$page_name = basename($_SERVER['PHP_SELF']);
/****************************User FrontEnd*******************************/
//Pagination
function heads(){
    global $page_name;
    
    if($page_name == 'blog.php'){
        ?>
            <style type="text/css">
                body{
                    
                }
            </style>
        <?php
    }
    
    if($page_name == '' || $page_name == 'index.php' || $page_name == 'blog.php' || $page_name == 'blog-category.php' || $page_name == 'author.php' || $page_name == 'single.php'){
        ?>
            <style type="text/css">
                @media only screen and (max-width: 991px){
                    .container{
                        width: 100%;
                    }
                }
            </style>
        <?php
    }
    
    if($page_name = 'departments.php'){
        ?>
            <style type="text/css">
                hr{
                    border-color: #d3d3d3;
                    margin: 2em 8px;
                }
            </style>
        <?php
    }
    
    
    if($page_name == 'coupons.php' || $page_name == '' || $page_name == 'stores.php' || $page_name == 'departments.php'){
        ?>
        
        <script type="text/javascript">
            $(document).ready(function(){
                var pageY = $(this).width();
                if(pageY < 992){
                    $('#conte').removeClass('container');
                    $('#conte').addClass('container-fluid');
                }else{
                    $('#conte').addClass('container');
                    $('#conte').removeClass('container-fluid');
                }
                
                $(window).resize(function(){
                    var pageY = $(this).width();
                    if(pageY < 992){
                        $('#conte').removeClass('container');
                        $('#conte').addClass('container-fluid');
                    }else{
                        $('#conte').addClass('container');
                        $('#conte').removeClass('container-fluid');
                    }
                });
            });
        </script>
        
        <?php
    }
}


/****************************Admin BackEnd*******************************/

/*****Login*****/

function head(){
    
    global $page_name;
    
    if($page_name == 'login.php'){
        ?>
        
        <style type="text/css">
            html{
                height: 100%;
            }
            body{
                height: 100%;
                background: linear-gradient(#690065,#001c69) !important;
                background: -o-linear-gradient(#690065,#001c69) !important;
                background: -moz-linear-gradient(#690065,#001c69) !important;
                background: -webkit-linear-gradient(#690065,#001c69) !important;
            }
        </style>
        <?php
    }else if($page_name != 'login.php'){
        if(!isset($_SESSION['username'])){
            header('Location: login.php');
        }
        //if not equal to login.php
        if($page_name == 'users.php' || $page_name == 'add-user.php' || $page_name == 'edit-user.php' || $page_name == 'categories.php' || $page_name == 'comments.php'){
            if(isset($_SESSION['username']) && $_SESSION['role'] != 'admin'){
                header('Location: login.php');
            }
        }
        
    }
    
    
    if($page_name == 'profile.php'){
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
                $('body').attr('id','profile');    
            });
        </script>
        <?php
    }
 
}



class query
{
    public function select($con,$res,$tablename,$cond){
        $query ="SELECT $res FROM $tablename $cond";
        $mysql_res = mysqli_query($con,$query);
        return $mysql_res;
    }
    
    public function delete($con,$tablename,$cond){
        $query ="DELETE FROM $tablename $cond";
        $mysql_res = mysqli_query($con,$query);
        return $mysql_res;
    }

    public function insert($con,$tablename,$res,$val,$cond){
        $query ="INSERT INTO $tablename ($res) VALUES ($val) $cond";
        $mysql_res = mysqli_query($con,$query);
        return $mysql_res;
    }

    public function update($con,$tablename,$data,$cond_up){
        $query ="UPDATE $tablename SET $data $cond_up";
        $mysql_res = mysqli_query($con,$query);
        return $mysql_res;
    }
}

//ipAdress
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

//https://www.youtube.com/watch?v=W2DbVKa2Cpw

if(isset($_GET['p'])){
    $current_post_id = $_GET['p'];
    $redir_id = $_GET['p'];
    $redirect_query = "SELECT * FROM `all_posts` WHERE `ID` = $redir_id";
    $redirect_result = mysqli_query($conn,$redirect_query);
    if(mysqli_num_rows($redirect_result) > 0){
        $redirect_row = mysqli_fetch_array($redirect_result);
        $red_id = $redirect_row['ID'];
        $aff_url = $redirect_row['affiliate_link'];
        header('Location: '. $aff_url);
        
        $red_hits = $redirect_row['hits'];
        $hits_query = "UPDATE `all_posts` SET `all_posts`.`hits` = $red_hits + 1 WHERE `all_posts`.`ID` = $redir_id";
        mysqli_query($conn,$hits_query);
    }
}


function excerpt($str,$words){
    $content_arr = str_word_count(strip_tags($str), 1);
    foreach($content_arr as $key => $content){
        if($key < $words){
            echo $content . ' ';
        }
    }
    echo '...';
}



function show_coupon($coup_id, $page_id,$start = 0,$limit = 10){
    //['cat_id' => 111,'product_id' => 7, 'name' => 'vig'],
    return $limit;
    $products = [];
    $coup_query = "";
    
}
if(isset($_GET['url'])){
    $url = $_GET['url'];
    $url = explode('/',$url);
}


function path_url($folder){
    $path = $_SERVER['REQUEST_URI'];
    $path_pos = strpos($path,$folder);
    return substr($path,0,$path_pos) . $folder;
}

?>


