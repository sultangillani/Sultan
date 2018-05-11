<?php
    include_once 'inc/header.php';
    
    if(isset($_GET['post_id'])){
        $post_id = $_GET['post_id'];
        
        //Views Query
        $views_query = "UPDATE `posts` SET `views` = views + 1 WHERE `posts`.`id` = $post_id";
        mysqli_query($conn, $views_query);
        
        //Single Post Data
        $query = "SELECT * FROM posts WHERE status = 'publish' and id = $post_id";
        $run = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($run) > 0){
            $row = mysqli_fetch_array($run);
            $id = $row['id'];
            
            $date = getdate(strtotime($row['date']));
            $day = $date['mday'];
            $month = $date['month'];
            $year = $date['year'];
            
            $title = $row['title'];
            $author = $row['author'];
            $author_image = $row['author_image'];
            $image = $row['image'];
            $categories = $row['categories'];
            $tags = $row['tags'];
            $post_data = $row['post_data'];
            $views = $row['views'];
            $status = $row['status'];
            
        }else{
            header('Location: index.php');
        }
    }
?>
    <div class="jumbotron head-img">
        <div class="container">
            <div id="details" class="animated fadeInLeft">
                <h1>Custom <span>Post</span></h1>
                <p>Here is your Single Post Content Page.</p>
            </div>
        </div>
        <img src="img/head.jpg" alt="Top Image"/>
    </div>
    
    <section ng-controller="usercontroller" class="content-body">
        
        <div class="container">
            <div class="row">
                <div class="col-md-8 content">
                    <div class="post">
                        <div class="row">
                            
                            <div class="col-md-2 post-date">
                                <div class="day"><?php echo $day;?></div>
                                <div class="month"><?php echo $month;?></div>
                                <div class="year"><?php echo $year;?></div>
                            </div><!-- /post-date -->
                            
                            <div class="col-md-8 post-title">
                                <a href="post.php?post_id=<?php echo $id; ?>"><h2><?php echo $title;?></h2></a>
                                <p>Written by: <span><?php echo $author;?></span></p>
                            </div><!-- /post-title -->
                            
                            <div class="col-md-2 profile-picture">
                                <img src="<?php echo 'img/' . $author_image;?>" alt="gallery2" class="img-circle"/>
                            </div><!-- /post-picture -->
                            
                        </div><!-- /row -->
                        
                        <a href="post.php?post_id=<?php echo $id; ?>"><img src="<?php echo 'img/' . $image;?>" alt="b"/></a>
                        <div class="desc"><?php echo $post_data;?></div>
                        <div class="bottom">
                            <span class="first"><i class="fa fa-folder"></i> <a href=""><?php echo $categories;?></a></span> |
                            <span class="second"><i class="fa fa-comment"></i>  <a href="">Comment</a></span>
                        </div>
                    </div><!-- /post -->
                    
                    <div class="related-posts">
                        <h2>Related Posts</h2>
                        <hr />
                        <div class="row">
                            
                            <?php
                                $r_query = "SELECT * FROM posts WHERE status = 'publish' AND title LIKE '%$title%' LIMIT 3";
                                $r_run = mysqli_query($conn, $r_query);
                                while( $r_row = mysqli_fetch_array($r_run) ){
                                    $r_id = $r_row['id'];
                                    $r_title = $r_row['title'];
                                    $r_image = $r_row['image'];
                            ?>
                            <div class="col-sm-4">
                                <a href="post.php?post_id=<?php echo $r_id; ?>">
                                    <img src="<?php echo 'img/' . $r_image;?>" alt="product1"/>
                                    <h4><?php echo $r_title;?></h4>
                                </a>
                            </div><!-- /col-sm-4 -->
                            <?php
                                }
                            ?>
                            
                        </div><!-- /row -->
                    </div><!-- /related-posts -->
                   
                    <div class="author">
                        <h2>Author Info</h2><hr />
                        <div class="row">
                            <div class="col-sm-3"><img src="<?php echo 'img/' . $author_image;?>" alt="gallery2" class="img-circle" /></div>
                            <div class="col-sm-9">
                                <h4><?php echo ucfirst($author);?></h4>
                                <?php
                                    $author_new = strtolower($author);
                                    $bio_query = "SELECT * FROM users WHERE username = '$author_new'";
                                    $bio_run = mysqli_query($conn, $bio_query);
                                    if(mysqli_num_rows($bio_run) > 0){
                                        $bio_row = mysqli_fetch_array($bio_run);
                                ?>
                                        <p><?php echo $bio_row['details'];?></p>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                        $c_query = "SELECT * FROM comments WHERE status = 'approve' AND post_id = $post_id ORDER BY id DESC";
                        $c_run = mysqli_query($conn,$c_query);
                        if(mysqli_num_rows($c_run) > 0){
                    ?>
                            <div class="comment">
                                <h2>Comments</h2>
                                <?php
                                while($c_row = mysqli_fetch_array($c_run)){
                                    $c_id = $c_row['id'];    
                                    $c_image = $c_row['image'];
                                    $c_name = $c_row['name'];
                                    $c_username = $c_row['username'];
                                    $c_comment = $c_row['comment'];  
                                ?>
                                    <hr />
                                    <div class="row single-comment">
                                        <div class="col-sm-3 s">
                                            <img src="<?php echo 'img/' .  $c_image; ?>" alt="<?php echo ucfirst($c_name) . ' Comment';?>" class="img-circle"/>
                                        </div><!-- /s -->
                                        <div class="col-sm-9 c">
                                            <h4><?php echo ucfirst($c_name); ?></h4>
                                            <p><?php echo $c_comment; ?></p>                                
                                        </div><!-- /c -->
                                    </div><!-- /single-commen -->
                                <?php
                                }
                                ?>
                            </div><!-- /comment -->
                    <?php
                        }
                    ?>
                    
                    <?php
                        if(isset($_POST['submit'])){
                            $cs_name = $_POST['name'];
                            $cs_email = $_POST['email'];
                            $cs_website = $_POST['website'];
                            $cs_comment = $_POST['comment'];
                            $cs_date = date("Y-m-d",time());
                            if(!empty($cs_name) && !empty($cs_email) && !empty($cs_comment)){
                                $cs_query = "INSERT INTO `comments` (`id`, `date`, `name`, `username`, `post_id`, `email`, `website`, `image`, `comment`, `status`) VALUES (NULL, '$cs_date', '$cs_name', 'user', '$post_id', '$cs_email', '$cs_website', 'http://localhost/series/retailmenot/img/gallery2.jpg', '$cs_comment', 'pending')";
                                if(mysqli_query($conn, $cs_query)){
                                    $msg = "Comment Submitted and waiting for an approval.";
                                        $cs_name = "";
                                        $cs_email = "";
                                        $cs_website = "";
                                        $cs_comment = "";
                                }else{
                                    $error_msg = "Comment has not been Submitted.";
                                }
                                
                            }else{
                                $error_msg = "All (*) Fields are required";
                            }
                        }
                    ?>
                    <div class="comment-box">
                        <div class="row">
                            <div class="col-xs-12">
                                <h3></h3>
                                <form action="" method="post">
                                
                                    <div class="form-group">
                                        <label for="full-name">Full Name:* </label>
                                        <input type="text" class="form-control" value="<?php if(isset($cs_name)){ echo $cs_name; } ?>" id="full-name" name="name" placeholder="Full Name"/>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email">Email Address:* </label>
                                        <input type="text" class="form-control" value="<?php if(isset($cs_email)){ echo $cs_email; } ?>" id="email" name="email" placeholder="Email Address:"/>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="website">Website: </label>
                                        <input type="text" class="form-control" value="<?php if(isset($cs_website)){ echo $cs_website; } ?>" id="website" name="website" placeholder="Website"/>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="comment">Comment:* </label>
                                        <textarea class="form-control" id="comment" name="comment" cols="30" rows="10" placeholder="Comment"><?php if(isset($cs_comment)){ echo $cs_comment; } ?></textarea>
                                    </div>
                                    
                                    <input type="submit" name="submit" value="Submit Comment" class="btn btn-primary"/>
                                    <?php
                                        if(isset($error_msg)){
                                            ?>
                                            <span class="pull-right" style="color: red;"><?php echo $error_msg;?></span>
                                            <?php
                                        }else if(isset($msg)){
                                            ?>
                                            <span class="pull-right" style="color: #00b000;"><?php echo $msg;?></span>
                                            <?php
                                        }
                                    ?>
                                    
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- /content -->
                
                <div class="col-md-4 sidebar">
                    <?php include_once 'inc/sidebar.php'; ?>
                </div><!-- /sidebar -->
                
            </div><!-- /row -->
        </div><!-- /container -->
        
    </section><!-- /content-body -->

<?php
    include_once 'inc/footer.php';
?>