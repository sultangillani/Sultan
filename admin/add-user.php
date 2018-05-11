<?php include_once 'inc/header.php';?>
    
    <div class="admin-main">
        <div class="container-fluid body-sections">
            <div class="row">
                <div class="col-md-3 admin-sidebar">
                    
                    <?php include_once 'inc/sidebar.php';?>
                    
                </div><!-- /.col-md-3 -->
                
                <div class="col-md-9 admin-content">
                    <h1><i class="fa fa-user-plus"></i> Add User <small>Add New Users</small></h1>
                    <hr />
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer"></i> Dashbord</a></li>
                        <li class="active"><i class="fa fa-user-plus"></i> Add New User</li>
                    </ol><!-- /.breadcrumb -->
                    <?php
                        if(isset($_POST['submit'])){
                            $first_name = mysqli_real_escape_string($conn,htmlentities($_POST['first-name']));
                            $last_name = mysqli_real_escape_string($conn,htmlentities($_POST['last-name']));
                            $username = mysqli_real_escape_string($conn,htmlentities(strtolower($_POST['username'])));
                            $username_trim = str_ireplace(' ','',$username);
                            $email = mysqli_real_escape_string($conn,htmlentities(strtolower($_POST['email'])));
                            $password = mysqli_real_escape_string($conn,htmlentities($_POST['password']));
                            $role = $_POST['role'];
                            $image_name = $_FILES['image']['name'];
                            $image_tmp = $_FILES['image']['tmp_name'];
                            $date = date('Y-m-d',time());
                            
                            $check_query = "SELECT * FROM users WHERE username = '$username' or email = '$email'";
                            $check_run = mysqli_query($conn,$check_query);
                            
                            $salt_query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                            $salt_run = mysqli_query($conn,$salt_query);
                            $salt_row = mysqli_fetch_array($salt_run);
                            $salt = $salt_row['salt'];
                            
                            $password = crypt($password ,$salt);
                            
                            
                            if(empty($first_name) || empty($last_name) || empty($username) || empty($email) || empty($password) || empty($image_name) ){
                                $error = "All (*) fields are requied";
                            }elseif($username != $username_trim){
                                $error = "Don't use spaces in username";
                            }elseif(mysqli_num_rows($check_run) > 0){
                                $error = "username or email already exists";
                            }else{
                                $insert_query = "INSERT INTO `users` (`id`, `date`, `first_name`, `last_name`, `username`, `email`, `image`, `password`, `role`) VALUES (NULL, '$date', '$first_name', '$last_name', '$username', '$email', '$image_name', '$password', '$role')";
                                if(mysqli_query($conn,$insert_query)){
                                    $msg = "User has been Added successfully";
                                    move_uploaded_file($image_tmp,"../img/$image_name");
                                    $image_check = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                                    $image_run = mysqli_query($conn,$image_check);
                                    $image_row = mysqli_fetch_array($image_run);
                                    
                                    $check_image = $image_row['image'];
                                    
                                    $first_name = "";
                                    $last_name = "";
                                    $username = "";
                                    $email = "";
                                    
                                }else{
                                    $error = "User has not been Added";
                                }
                            }
                        }
                    ?>
                    <div class="row add-user">
                        <div class="col-md-8">
                            <form action="" method="post" enctype="multipart/form-data">
                                
                                <div class="form-group">
                                    <label for="first-name">First Name:*</label>
                                    <?php
                                    if(isset($error)){
                                        ?>
                                        <span class="pull-right" style="color: red;"><?php echo $error; ?></span>
                                        <?php
                                    }else if(isset($msg)){
                                        ?>
                                        <span class="pull-right" style="color: green;"><?php echo $msg; ?></span>
                                        <?php
                                    }
                                    ?>
                                    <input type="text" class="form-control" id="first-name" value="<?php if(isset($first_name)){ echo $first_name; }?>" placeholder="First Name" name="first-name"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="last-name">Last Name:*</label>
                                    <input type="text" class="form-control" id="last-name" value="<?php if(isset($last_name)){ echo $last_name; }?>" placeholder="Last Name" name="last-name"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="username">Username:*</label>
                                    <input type="text" class="form-control" id="username" value="<?php if(isset($username)){ echo $username; }?>" placeholder="Username" name="username"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email:*</label>
                                    <input type="text" class="form-control" id="email" value="<?php if(isset($email)){ echo $email; }?>" placeholder="Email Address" name="email"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password:*</label>
                                    <input type="password" class="form-control" id="password" value="" placeholder="Password" name="password"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="role">Role:*</label>
                                    <select class="form-control" id="role" name="role">
                                        <option value="author">Author</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="image">Profile Picture:*</label>
                                    <input type="file" id="image" name="image"/>
                                </div>
                                
                                <input type="submit" name="submit" value="Add User" class="btn btn-primary"/>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <?php
                                if(isset($check_image)){
                                    ?>
                                    <img src="../img/<?php echo $check_image; ?>" alt="" width="100%" />
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                    
                </div><!-- /.col-md-9 -->
            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.admin-main -->
    
<?php include_once 'inc/footer.php';?>
