<?php include_once 'inc/header.php';?>
    
    <?php
        
        if(isset($_GET['edit'])){
            $edit_id = $_GET['edit'];
        }
        
        if(isset($_GET['del'])){
            $del_id = $_GET['del'];
            $del_query = "DELETE FROM `categories` WHERE `id` = $del_id";
            if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
                if(mysqli_query($conn,$del_query)){
                    $del_msg = "Category has been deleted";
                }else{
                    $del_error = "Category has not been deleted";
                }
            }
        }
        
        if(isset($_POST['submit'])){
            $cat_name = mysqli_real_escape_string($conn, htmlentities(strtolower($_POST['cat-name'])));
            if(!empty($cat_name)){
                $check_query = "SELECT * FROM `categories` WHERE `category` = '$cat_name'";
                $check_run = mysqli_query($conn, $check_query);
                
                if(mysqli_num_rows($check_run) > 0){
                    $error = "Category already exists";
                }else{
                    $insert_query = "INSERT INTO `categories` (`category`) VALUES ('$cat_name')";
                    if(mysqli_query($conn, $insert_query)){
                        $msg = "Category has been Added";
                    }else{
                        $error = "Category has not been Added";
                    }
                }
            }else{
                $error = "This Field is required";
            }
        }
        
        
        if(isset($_POST['update'])){
            $cat_name = mysqli_real_escape_string($conn, htmlentities(strtolower($_POST['cat-name'])));
            if(!empty($cat_name)){
                $check_query = "SELECT * FROM `categories` WHERE `category` = '$cat_name'";
                $check_run = mysqli_query($conn, $check_query);
                
                if(mysqli_num_rows($check_run) > 0){
                    $up_error = "Category already exists";
                }else{
                    $insert_query = "UPDATE `categories` SET `category` = '$cat_name' WHERE `id` = $edit_id";
                    if(mysqli_query($conn, $insert_query)){
                        $up_msg = "Category has been Updated";
                    }else{
                        $up_error = "Category has not been Updated";
                    }
                }
            }else{
                $error = "This Field is required";
            }
        }
    ?>
    <div class="admin-main">
        <div class="container-fluid body-sections">
            <div class="row">
                <div class="col-md-3 admin-sidebar">
                    
                    <?php include_once 'inc/sidebar.php';?>
                    
                </div><!-- /.col-md-3 -->
                
                <div class="col-md-9 admin-content">
                    <h1><i class="fa fa-folder-open"></i> Categories <small>Different Categories</small></h1>
                    <hr />
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer"></i> Dashbord</a></li>
                        <li class="active"><i class="fa fa-folder-open"></i> Categories</li>
                    </ol><!-- /.breadcrumb -->
                    
                    <div class="row categories">
                        
                        <div class="col-md-6">
                                
                            <form action="" method="post">
                                
                                <div class="form-group">
                                    <label for="category">Add Category:</label>
                                    <?php
                                        if(isset($msg)){
                                            echo '<span class="pull-right" style="color: green">'. $msg .'</span>';
                                        }else if(isset($error)){
                                            echo '<span class="pull-right" style="color: red">'. $error .'</span>';
                                        }
                                    ?>
                                    <input type="text" name="cat-name" id="category" class="form-control" placeholder="Category Name"/>
                                </div><!-- /.form-group -->
                                <input type="submit" class="btn btn-primary" value="Add Category" name="submit"/>
                                
                            </form><!-- /.form -->
                            <?php
                            if(isset($_GET['edit'])){
                                $edit_check_query = "SELECT * FROM `categories` WHERE `id` = '$edit_id'";
                                $edit_check_run = mysqli_query($conn, $edit_check_query);
                                if(mysqli_num_rows($edit_check_run) > 0){
                                $edit_row = mysqli_fetch_array($edit_check_run);
                                $up_category = $edit_row['category'];
                                
                            ?>
                            <hr />
                            
                            <form action="" method="post">
                                
                                <div class="form-group">
                                    <label for="category">Update Category:</label>
                                    <?php
                                        if(isset($up_msg)){
                                            echo '<span class="pull-right" style="color: green">'. $up_msg .'</span>';
                                        }else if(isset($up_error)){
                                            echo '<span class="pull-right" style="color: red">'. $up_error .'</span>';
                                        }
                                    ?>
                                    <input type="text" name="cat-name" value="<?php echo $up_category;?>" id="category" class="form-control" placeholder="Category Name"/>
                                </div><!-- /.form-group -->
                                <input type="submit" class="btn btn-primary" value="Update Category" name="update"/>
                                
                            </form><!-- /.form -->
                            <?php
                                }
                            }
                            ?>
                        </div><!-- /.col-md-6 -->
                        
                        <div class="col-md-6">
                            
                            <?php
                                $get_query = "SELECT * FROM `categories` ORDER BY id DESC";
                                $get_run = mysqli_query($conn, $get_query);
                                
                                if(mysqli_num_rows($get_run) > 0){
                                    if(isset($del_msg)){
                                        echo '<span class="pull-right" style="color: green">'. $del_msg .'</span>';
                                    }else if(isset($del_error)){
                                        echo '<span class="pull-right" style="color: red">'. $del_error .'</span>';
                                    }
                            ?><br /><br /><br />
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sr #</th>
                                            <th>Category Name</th>
                                            <th>Posts</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            while($get_row = mysqli_fetch_array($get_run)){
                                            $get_id = $get_row['id'];
                                            $get_category = $get_row['category'];
                                            //$post_count = "SELECT * FROM `posts` WHERE categories = $get_category";
                                        ?>
                                            <tr>
                                                <td><?php echo $get_id; ?></td>
                                                <td><?php echo ucfirst($get_category); ?></td>
                                                <td>12</td>
                                                <td><a href="categories.php?edit=<?php echo $get_id; ?>"><i class="fa fa-pencil"></i></a></td>
                                                <td><a href="categories.php?del=<?php echo $get_id; ?>"><i class="fa fa-times"></i></a></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                                }else{
                                    echo 'No Categories are Found';
                                }
                            ?>
                        </div><!-- /.col-md-6 -->
                        
                    </div><!-- /.row -->
                </div><!-- /.col-md-9 -->
            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.admin-main -->
    
<?php include_once 'inc/footer.php';?>
