<?php include_once 'inc/header.php';?>

<?php
$session_username = $_SESSION['username'];
$session_author_image = $_SESSION['author_image'];

?>
    <div class="admin-main">
        <div class="container-fluid body-sections">
            <div class="row">
                <div class="col-md-3 admin-sidebar">
                    
                    <?php include_once 'inc/sidebar.php';?>
                    
                </div><!-- /.col-md-3 -->
                
                <div class="col-md-9 admin-content">
                    <h1><i class="fa fa-plus-square"></i> Add Post <small>Add New Post</small></h1>
                    <hr />
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer"></i> Dashbord</a></li>
                        <li class="active"><i class="fa fa-plus-square"></i> Add Post</li>
                    </ol><!-- /.breadcrumb -->
                    
                    <?php
                        if(isset($_POST['submit'])){
                            $date = date('Y-m-d',time());
                            $title = mysqli_real_escape_string($conn,htmlentities($_POST['title']));
                            $post_data = mysqli_real_escape_string($conn,$_POST['post-data']);
                            $categories = $_POST['categories'];
                            $tags = mysqli_real_escape_string($conn,htmlentities($_POST['tags']));
                            $status = $_POST['status'];                            
                            $image = $_FILES['image']['name'];                            
                            $tmp_name= $_FILES['image']['tmp_name'];
                            
                            if(empty($title) || empty($post_data) || empty($tags) || empty($image)){
                                $error = "All (*) Fields are required";
                            }else{
                                $insert_query = "INSERT INTO `posts` (date,title,author,author_image,image,categories,tags,post_data,views,status) VALUES ('$date','$title','$session_username','$session_author_image','$image','$categories','$tags','$post_data','0','$status')";
                                if(mysqli_query($conn, $insert_query)){
                                    $msg = "Post has been Successfully Added!";
                                    $path = "img/$image";
                                    $title = "";
                                    $post_data = "";
                                    $tags = "";
                                    $status = "";
                                    $categories = ""; 
                                    if(move_uploaded_file($tmp_name, $path)){
                                        copy($path,"../$path");    
                                    }  
                                }else{
                                   $error = "Post has not been Added!" . mysqli_error($conn); 
                                }
                            }
                        }
                    ?>
                    
                    <div class="row add-post">
                        <div class="col-xs-12">
                            <form action="" method="post" enctype="multipart/form-data">
                                
                                <div class="form-group">
                                    <label for="title">Title:*</label>
                                    <?php
                                    if(isset($error)){
                                        echo '<span class="pull-right" style="color:red">' . $error . '</span>';
                                    }else if(isset($msg)){
                                        echo '<span class="pull-right" style="color:green">' . $msg . '</span>';
                                    }
                                    ?>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Type Post Title Here" value="<?php if(isset($title)){ echo $title; } ?>"/>
                                </div>
                                
                                <div class="form-group">
                                    <a href="media.php" class="btn btn-primary">Add Media</a>    
                                </div>
                                
                                <div class="form-group">
                                    <textarea name="post-data" id="textarea" rows="10" class="form-control"><?php if(isset($post_data)){ echo $post_data; } ?></textarea>
                                </div>
                                
                                <div class="row">
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="file">Post Image:*</label>
                                            <input type="file" name="image"/>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="categories">Categories:*</label>
                                            <select name="categories" id="categories" class="form-control">
                                                <?php
                                                    $cat_query = "SELECT * FROM `categories` ORDER BY id DESC";
                                                    $cat_run = mysqli_query($conn, $cat_query);
                                                    if(mysqli_num_rows($cat_run) > 0){
                                                        while($cat_row = mysqli_fetch_array($cat_run)){
                                                        $cat_id = $cat_row['id'];
                                                        $cat_name = $cat_row['category'];
                                                        
                                                ?>
                                                        <option value="<?php echo strtolower($cat_name); ?>" <?php if(isset($categories) && $categories == $cat_name){ echo 'selected';}?> > <?php echo ucfirst($cat_name); ?></option>
                                                        
                                                <?php
                                                        }
                                                    }else{
                                                        echo "<center><h6>No Categories are Found.</h6></center>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <div class="row">
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="tags">Tags:*</label>
                                            <input type="text" name="tags" id="tags" value="<?php if(isset($tags)){ echo $tags; } ?>" placeholder="Your Tags Here" class="form-control"/>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="status">Status:*</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="publish" <?php if(isset($status) && $status == 'publish'){ echo 'selected';}?> >Publish</option>
                                                <option value="draft" <?php if(isset($status) && $status == 'draft'){ echo 'selected';}?> >Draft</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" name="submit" value="Add Post" class="btn btn-primary"/>
                            </form>
                        </div>
                    </div>
                </div><!-- /.col-md-9 -->
            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.admin-main -->
    
<?php include_once 'inc/footer.php';?>
