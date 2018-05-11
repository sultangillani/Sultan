<?php include_once 'inc/header.php';?>

<?php
    $session_username = $_SESSION['username'];
    
    $query = "SELECT * FROM `users` WHERE `username` = '$session_username'";
    $run = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($run);
    
    $image = $row['image'];
    $date = date("d F Y",strtotime($row['date']));
    $id = $row['id'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $username = $row['username'];
    $email = $row['email'];
    $role = $row['role'];    
    $details = $row['details'];    
?>
    <div class="admin-main">
        <div class="container-fluid body-sections">
            <div class="row">
                <div class="col-md-3 admin-sidebar">
                    
                    <?php include_once 'inc/sidebar.php';?>
                    
                </div><!-- /.col-md-3 -->
                
                <div class="col-md-9 admin-content">
                    <h1><i class="fa fa-user"></i> Profile <small>Personal Details</small></h1>
                    <hr />
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer"></i> Dashbord</a></li>
                        <li class="active"><i class="fa fa-user"></i> Profile</li>
                    </ol><!-- /.breadcrumb -->
                    
                    <div class="row pro-img">
                        <center><div><img src="../img/<?php echo $image;?>" alt="Profile Picture" id="profile-picture"/></div></center><br />
                        <a href="edit-profile.php?edit=<?php echo $id; ?>" class="btn btn-primary pull-right">Edit Profile</a><br /><br /><br />
                        <center><h3>Profile Details</h3></center>
                        <br />
                        
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <td width="20%"><b>User ID:</b></td>
                                    <td width="30%"><?php echo $id;?></td>
                                    <td width="20%"><b>Signup Date:</b></td>
                                    <td width="30%"><?php echo $date;?></td>
                                </tr>
                                
                                <tr>
                                    <td width="20%"><b>First Name:</b></td>
                                    <td width="30%"><?php echo $first_name;?></td>
                                    <td width="20%"><b>Last Name:</b></td>
                                    <td width="30%"><?php echo $last_name;?></td>
                                </tr>
                                
                                <tr>
                                    <td width="20%"><b>Username:</b></td>
                                    <td width="30%"><?php echo $username;?></td>
                                    <td width="20%"><b>Email:</b></td>
                                    <td width="30%"><?php echo $email;?></td>
                                </tr>
                                
                                <tr>
                                    <td width="20%"><b>Role:</b></td>
                                    <td width="30%"><?php echo $role;?></td>
                                    <td width="20%"><b></b></td>
                                    <td width="30%"></td>
                                </tr>
                                
                            </table>
                        </div><!-- /.table-responsive -->
                        
                        <div class="row det">
                            <div class="col-lg-8 col-sm-12">
                                <b>Details:</b>
                                <div><?php echo $details;?></div>
                            </div>
                        </div><br />
                        
                    </div><!-- /.pro-img -->
                </div><!-- /.col-md-9 -->
            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.admin-main -->
    
<?php include_once 'inc/footer.php';?>
