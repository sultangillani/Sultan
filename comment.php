<?php
    include 'functions.php';
        //Comment Settings
        function comment(){
            global $conn;
            $com_post_id = mysqli_real_escape_string($conn,htmlentities($_POST['com_post_id']));
            $fname = mysqli_real_escape_string($conn,htmlentities($_POST['firstname']));
            $adcom = mysqli_real_escape_string($conn,htmlentities($_POST['add_comment']));
            $author_ip = get_client_ip();
            $error = [];
            $msg = '';
            /*if(empty($fname)){
                echo $error[0] = '<span class="comment_error"> Please enter your first name</span><br />';
            }
            
            if(empty($adcom)){
                echo $error[1] = '<span class="comment_error"> Please fill out comment box</span>';
            }*/
            
            if(isset($fname) && isset($adcom)){
                if(!empty($fname) && !empty($adcom)){
                    $insert_com_query = "INSERT INTO `wp_comments` (`comment_post_ID`, `comment_author`, `comment_author_email`, `comment_author_url`, `comment_author_IP`, `comment_date`, `comment_date_gmt`, `comment_content`, `comment_karma`, `comment_approved`, `comment_agent`, `comment_type`, `comment_parent`, `user_id`) VALUES ('$com_post_id', '$fname', '', '', '$author_ip', NOW(), NOW(), '$adcom', '0', 'pending', '', '', '0', '0')";
                    mysqli_query($conn,$insert_com_query);
                    echo mysqli_error($conn);
                }
            }
        }
        
        $func = $_POST['action'];
        switch ($func) {
            case "comment":
            comment();
            break;
        }
        
        
    ?>