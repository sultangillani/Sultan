<?php include_once 'inc/header.php';?>
    <?php
        if(isset($_GET['del'])){
            $del_id = $_GET['del'];
            $del_check_query = "SELECT * FROM `users` WHERE `id` = '$del_id'";
            $del_check_run = mysqli_query($conn, $del_check_query);
            if(mysqli_num_rows($del_check_run)){
                $del_query = "DELETE FROM `users` WHERE `id` = $del_id";
                if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
                    if(mysqli_query($conn,$del_query)){
                        $msg = "User has been deleted";
                    }else{
                        $error = "User has not been deleted";
                    }
                }
            }else{
                header('Location: index.php');
            }
        }
        
        if(isset($_POST['checkboxes'])){
            $checkboxes = $_POST['checkboxes'];
            foreach($checkboxes as $user_id){
                $bulk_option = $_POST['bulk-options'];
                if($bulk_option == 'delete'){
                    $bulk_del_query = "DELETE FROM `users` WHERE `users`.`id` = $user_id";
                    mysqli_query($conn,$bulk_del_query);
                    
                }else if($bulk_option == 'author'){
                    $bulk_author_query = "UPDATE `users` SET role='author' WHERE `users`.`id` = $user_id";
                    mysqli_query($conn,$bulk_author_query);
                    
                }else if($bulk_option == 'admin'){
                    $bulk_admin_query = "UPDATE `users` SET role='admin' WHERE `users`.`id` = $user_id";
                    mysqli_query($conn,$bulk_admin_query);
                }
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
                    <h1><i class="fa fa-users"></i> Users <small>View All Users</small></h1>
                    <hr />
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer"></i> Dashbord</a></li>
                        <li class="active"><i class="fa fa-users"></i> Users</li>
                    </ol><!-- /.breadcrumb -->
                    
                    <?php
                    $query = "SELECT * FROM users ORDER BY id DESC";
                    $run = mysqli_query($conn, $query);
                    if(mysqli_num_rows($run) > 0){
                    ?>
                    <form action="" method="POST">
                        <div class="row">
                           <div class="col-xs-4">
                               <div class="form-group">
                                   <select name="bulk-options" id="" class="form-control">
                                       <option value=""></option>
                                       <option value="delete">Delete</option>
                                       <option value="author">Change to Author</option>
                                       <option value="admin">Change to Admin</option>
                                   </select>
                               </div><!-- /.form-group -->
                           </div><!-- /.col-xs-8 -->
                           
                           <div class="col-xs-8">
                               <input type="submit" class="btn btn-success" value="Apply"/>
                               <a href="add-user.php" class="btn btn-primary">Add New</a>
                           </div><!-- /.col-xs-8 -->
    
                        </div><!-- /.row -->
                        
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
                       <br /><br />
                       <div class="table-responsive">
                           <table class="table table-bordered">
                               <thead>
                                   <tr>
                                       <th><input type="checkbox" id="selectallboxes"/></th>
                                       <th>Sr #</th>
                                       <th>Date</th>
                                       <th>Name</th>
                                       <th>Username</th>
                                       <th>Email</th>
                                       <th>Image</th>
                                       <th>Password</th>
                                       <th>Role</th>
                                       <th>Edit</th>
                                       <th>Delete</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <?php
                                       while($row = mysqli_fetch_array($run)){
                                           $id = $row['id'];
                                           $first_name = ucfirst($row['first_name']);
                                           $last_name = ucfirst($row['last_name']);
                                           $email = $row['email'];
                                           $username = $row['username'];
                                           $password = $row['password'];
                                           $role = ucfirst($row['role']);
                                           $image = $row['image'];
                                           $date = date("d M Y",strtotime($row['date']));
                                   ?>
                                           <tr>
                                               <td><input type="checkbox" class="checkboxes" name="checkboxes[]" value="<?php echo $id; ?>"/></td>
                                               <td><?php echo $id; ?></td>
                                               <td><?php echo $date; ?></td>
                                               <td><?php echo $first_name . ' ' . $last_name; ?></td>
                                               <td><?php echo $username; ?></td>
                                               <td><?php echo $email; ?></td>
                                               <td><img src="../img/<?php echo $image; ?>" alt="download" width="50px"/></td>
                                               <td><?php echo $password; ?></td>
                                               <td><?php echo $role; ?></td>
                                               <td><a href="edit-user.php?edit=<?php echo $id;?>"><i class="fa fa-pencil"></i></a></td>
                                               <td><a href="users.php?del=<?php echo $id;?>"><i class="fa fa-times"></i></a></td>
                                           </tr>
                                   <?php
                                       }
                                   ?>
                               </tbody>
                           </table>
                       </div><!-- /.table-responsive -->
                       <?php
                       }else{
                           ?>
                           <center><h2>No Users Available Now</h2></center>
                           <?php
                       }
                       ?>
                    </form>
                </div><!-- /.col-md-9 -->
            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.admin-main -->
    
<?php include_once 'inc/footer.php';?>
