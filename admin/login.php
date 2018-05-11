<?php include_once 'inc/header.php';?>


<?php
    if(isset($_POST['submit'])){
        $username = mysqli_real_escape_string($conn,htmlentities(strtolower($_POST['username'])));
        $password = mysqli_real_escape_string($conn,htmlentities($_POST['password']));
        
        $check_username_query = "SELECT * FROM `users` WHERE username = '$username'";
        $check_username_run = mysqli_query($conn, $check_username_query);
        if(mysqli_num_rows($check_username_run) > 0){
            $row = mysqli_fetch_array($check_username_run);
            
            $db_username = $row['username'];
            $db_password = $row['password'];
            $db_role = $row['role'];
            $db_author_image = $row['image'];
            
            $password = crypt($password,$db_password);
            
            if($username == $db_username && $password == $db_password){
                header('Location: index.php');
                $_SESSION['username'] = $db_username;
                $_SESSION['role'] = $db_role;
                $_SESSION['author_image'] = $db_author_image;
                
            }else{
                $error = "Invalid Information";
            }
            
        }else{
            $error = "Invalid Information";
        }
    }
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 login">
                <!-- Begin # Login Form -->
                <form class="form-signin animated shake" action="" method="post">
                    <h2 class="form-signin-heading">Sultan Login</h2>
                    <label for="inputEmail" class="sr-only">Username</label>
                    <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Username" required autofocus>
                    <br />
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
                    <div class="checkbox">
                        <label>
                            <?php
                                if(isset($error)){
                                    echo $error;
                                }
                            ?>
                        </label>
                      <!--<label>
                        <input type="checkbox" value="remember-me"> Remember me
                      </label>-->
                    </div>
                    <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="Sign In"/>
                </form>
                <!-- End # Login Form -->
            </div>
        </div>
    </div>
</section>

<?php include_once 'inc/footer.php';?>
