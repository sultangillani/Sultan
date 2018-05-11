<?php include_once 'inc/header.php';?>


<?php
    $comment_tag_query = "SELECT * FROM `comments` WHERE `status` = 'pending'";
    $category_tag_query = "SELECT * FROM `categories`";
    $posts_tag_query = "SELECT * FROM `posts`";
    $users_tag_query = "SELECT * FROM `users`";

    $comment_tag_run = mysqli_query($conn, $comment_tag_query);
    $category_tag_run = mysqli_query($conn, $category_tag_query);
    $posts_tag_run = mysqli_query($conn, $posts_tag_query);
    $users_tag_run = mysqli_query($conn, $users_tag_query);
    
    $com_of_rows = mysqli_num_rows($comment_tag_run);
    $cat_of_rows = mysqli_num_rows($category_tag_run);
    $posts_of_rows = mysqli_num_rows($posts_tag_run);
    $users_of_rows = mysqli_num_rows($users_tag_run);

?>
    <div class="admin-main">
        <div class="container-fluid body-sections">
            <div class="row">
                <div class="col-md-3 admin-sidebar">
                    
                    <?php include_once 'inc/sidebar.php';?>
                    
                </div><!-- /.col-md-3 -->
                
                <div class="col-md-9 admin-content">
                    <h1><i class="fa fa-tachometer"></i> Dashbord <small>Statistics Overview</small></h1>
                    <hr />
                    <ol class="breadcrumb">
                        <li class="active"><i class="fa fa-tachometer"></i> Dashbord</li>
                    </ol><!-- /.breadcrumb -->
                    
                    <div class="row tag-boxes">
                        
                        <div class="col-md-6 col-lg-3">
                            
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    
                                    <div class="row">
                                        <div class="col-xs-3"><i class="fa fa-comments fa-4x"></i></div>
                                        <div class="col-xs-9">
                                            <div class="text-right huge"><?php echo $com_of_rows; ?></div>
                                            <div class="text-right">New Comments</div>                                            
                                        </div>
                                    </div><!-- /.row -->
                                    
                                </div><!-- /.panel-heading -->
                                
                                <a href="comments.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View All Comments</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div><!-- /.panel-footer -->
                                </a>
                            
                            </div><!-- /.panel-primary -->
                            
                        </div><!-- /.col-lg-3 -->
                        
                        <div class="col-md-6 col-lg-3">
                            
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    
                                    <div class="row">
                                        <div class="col-xs-3"><i class="fa fa-file-text fa-4x"></i></div>
                                        <div class="col-xs-9">
                                            <div class="text-right huge"><?php echo $posts_of_rows; ?></div>
                                            <div class="text-right">All Posts</div>                                            
                                        </div>
                                    </div><!-- /.row -->
                                    
                                </div><!-- /.panel-heading -->
                                
                                <a href="posts.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View All Posts</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div><!-- /.panel-footer -->
                                </a>
                            
                            </div><!-- /panel-red -->
                            
                        </div><!-- /.col-lg-3 -->
                        
                        <div class="col-md-6 col-lg-3">
                            
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    
                                    <div class="row">
                                        <div class="col-xs-3"><i class="fa fa-users fa-4x"></i></div>
                                        <div class="col-xs-9">
                                            <div class="text-right huge"><?php echo $users_of_rows; ?></div>
                                            <div class="text-right">All Users</div>                                            
                                        </div>
                                    </div><!-- /.row -->
                                    
                                </div><!-- /.panel-heading -->
                                
                                <a href="users.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View All Users</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div><!-- /.panel-footer -->
                                </a>
                            
                            </div><!-- /.panel-yellow -->
                            
                        </div><!-- /.col-lg-3 -->
                        
                        <div class="col-md-6 col-lg-3">
                            
                            <div class="panel panel-green">
                                <div class="panel-heading">
                                    
                                    <div class="row">
                                        <div class="col-xs-3"><i class="fa fa-folder-open fa-4x"></i></div>
                                        <div class="col-xs-9">
                                            <div class="text-right huge"><?php echo $cat_of_rows; ?></div>
                                            <div class="text-right">All Categories</div>                                            
                                        </div>
                                    </div><!-- /.row -->
                                    
                                </div><!-- /.panel-heading -->
                                
                                <a href="categories.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">All Categories</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div><!-- /.panel-footer -->
                                </a>
                            
                            </div><!-- /.panel-green -->
                            
                        </div><!-- /.col-lg-3 -->
                        
                    </div><!-- /.row -->
                    
                    <br />
                    
                    <?php
                        $get_users_query = "SELECT * FROM `users` ORDER BY id DESC LIMIT 5";
                        $get_users_run = mysqli_query($conn, $get_users_query);
                        if(mysqli_num_rows($get_users_run) > 0){
                            ?>
                            <h3>New Users</h3>
                            
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr #</th>
                                            <th>Date</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while($get_users_row = mysqli_fetch_array($get_users_run)){
                                            $users_id = $get_users_row['id'];
                                            $users_date = date('d M Y',strtotime($get_users_row['date']));
                                            $users_first_name = $get_users_row['first_name'];
                                            $users_last_name = $get_users_row['last_name'];
                                            $users_username = $get_users_row['username'];
                                            $users_role = $get_users_row['role'];                                            
                                            
                                            ?>
                                            <tr>
                                                <td><?php echo $users_id;?></td>
                                                <td><?php echo $users_date;?></td>
                                                <td><?php echo ucfirst($users_first_name . ' ' . $users_last_name); ?></td>
                                                <td><?php echo ucfirst($users_username);?></td>
                                                <td><?php echo ucfirst($users_role);?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <a href="users.php" class="btn btn-primary">View All Users</a>
                        
                        <hr />
                            <?php
                        }
                    ?>
                    
                    <?php
                        $get_posts_query = "SELECT * FROM `posts` ORDER BY id DESC LIMIT 5";
                        $get_posts_run = mysqli_query($conn, $get_posts_query);
                        if(mysqli_num_rows($get_posts_run) > 0){
                            ?>
                            <h3>New Posts</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sr #</th>
                                            <th>Date</th>
                                            <th>Post Title</th>
                                            <th>Category</th>
                                            <th>Views</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                        while($get_posts_row = mysqli_fetch_array($get_posts_run)){
                                            $posts_id = $get_posts_row['id'];
                                            $posts_date = date('d M Y',strtotime($get_posts_row['date']));
                                            $posts_title = $get_posts_row['title'];
                                            $posts_category = $get_posts_row['categories'];                                            
                                            $posts_views = $get_posts_row['views'];  
                                            ?>
                                            <tr>
                                                <td><?php echo $posts_id;?></td>
                                                <td><?php echo $posts_date;?></td>
                                                <td><?php echo ucfirst($posts_title); ?></td>
                                                <td><?php echo ucfirst($posts_category);?></td>
                                                <td><i class="fa fa-eye"></i> <?php echo $posts_views;?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <a href="posts.php" class="btn btn-primary">View All Posts</a>
                            <?php
                        }
                    ?>
                </div><!-- /.col-md-9 -->
            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.admin-main -->
    
<?php include_once 'inc/footer.php';?>
