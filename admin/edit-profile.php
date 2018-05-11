<?php include_once 'inc/header.php';?>
    <?php
    $session_username = $_SESSION['username'];
        if(isset($_GET['edit'])){
            $edit_id = $_GET['edit'];
            $edit_query = "SELECT * FROM users WHERE id = '$edit_id'";
            $edit_run = mysqli_query($conn, $edit_query);
            
            if(mysqli_num_rows($edit_run) > 0){
                $edit_row = mysqli_fetch_array($edit_run);
                $e_username = $edit_row['username'];
                if($e_username == $session_username){
                    $e_first_name = $edit_row['first_name'];
                    $e_last_name = $edit_row['last_name'];
                    $e_email = $edit_row['first_name'];
                    $e_image = $edit_row['image'];
                    $e_details = $edit_row['details'];
                }else{
                    header('Location: index.php');
                }
            }else{
                header('Location: index.php');
            }
        }else{
            header('Location: index.php');
        }
        
    ?>
    <div class="admin-main">
        <div class="container-fluid body-sections">
            <div class="row">
                <div class="col-md-3 admin-sidebar">
                    
                    <?php include_once 'inc/sidebar.php';?>
                    
                </div><!-- /.col-md-3 -->
                
                <div class="col-md-9 admin-content">
                    <h1><i class="fa fa-user"></i> Edit Profile <small>Edit Profile Details</small></h1>
                    <hr />
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer"></i> Dashbord</a></li>
                        <li class="active"><i class="fa fa-user"></i> Edit Profile</li>
                    </ol><!-- /.breadcrumb -->
                    <?php
                        if(isset($_POST['submit'])){
                            $first_name = mysqli_real_escape_string($conn,htmlentities($_POST['first-name']));
                            $last_name = mysqli_real_escape_string($conn,htmlentities($_POST['last-name']));
                            $password = mysqli_real_escape_string($conn,htmlentities($_POST['password']));
                            $details = mysqli_real_escape_string($conn,htmlentities($_POST['details']));
                            $image_name = $_FILES['image']['name'];
                            $image_tmp = $_FILES['image']['tmp_name'];
                                if(empty($image_name)){
                                    $image_name = $e_image;
                                }
                            $salt_query = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
                            $salt_run = mysqli_query($conn,$salt_query);
                            $salt_row = mysqli_fetch_array($salt_run);
                            $salt = $salt_row['salt'];
                            
                            $insert_password = crypt($password ,$salt);
                            
                            
                            if(empty($first_name) || empty($last_name) || empty($image_name) ){
                                $error = "All (*) fields are requied";
                            }else{
                                
                                $update_query = "UPDATE `users` SET `first_name`= '$first_name', `last_name`= '$last_name', `image`= '$image_name', `details`= '$details'";
                                if(!empty($image_name)){
                                    move_uploaded_file($image_tmp,"../img/$image_name");
                                }
                                if(!empty($password)){
                                    $update_query .= ", `password` = '$insert_password'";
                                }
                                
                                $update_query .= " WHERE `id` = $edit_id";
                                
                                if(mysqli_query($conn, $update_query)){
                                    $msg = "Profile has been updated";
                                    header("refresh: 1; url=edit-profile.php?edit=$edit_id");
                                }else{
                                    $error="Profile has not been updated";
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
                                    <input type="text" class="form-control" id="first-name" value="<?php  echo $e_first_name; ?>" placeholder="First Name" name="first-name"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="last-name">Last Name:*</label>
                                    <input type="text" class="form-control" id="last-name" value="<?php  echo $e_last_name; ?>" placeholder="Last Name" name="last-name"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="password">Password:*</label>
                                    <input type="password" class="form-control" id="password" value="" placeholder="Password" name="password"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="image">Profile Picture:*</label>
                                    <input type="file" id="image" name="image"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="details">Details:</label>
                                    <textarea id="details" name="details" placeholder="Details" cols="30" rows="10" class="form-control"><?php echo $e_details; ?></textarea>
                                </div>
                                
                                <input type="submit" name="submit" value="Update User" class="btn btn-primary"/>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <?php
                            
                                ?>
                                
                                <img src="../img/<?php echo $e_image; ?>" alt="" width="100%" style="border: 10px solid #fff; box-shadow: 0px 0px 15px #cac5c5;"/>
                                <?php
                            ?>
                        </div>
                    </div>
                    
                </div><!-- /.col-md-9 -->
            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.admin-main -->
    
<?php include_once 'inc/footer.php';?>
