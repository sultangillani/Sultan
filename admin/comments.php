<?php include_once 'inc/header.php';?>
    <?php
        //Delete
        if(isset($_GET['del'])){
            $del_id = $_GET['del'];
            $del_check_query = "SELECT * FROM `comments` WHERE `id` = '$del_id'";
            $del_check_run = mysqli_query($conn, $del_check_query);
            if(mysqli_num_rows($del_check_run)){
                $del_query = "DELETE FROM `comments` WHERE `id` = $del_id";
                if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
                    if(mysqli_query($conn,$del_query)){
                        $msg = "Comment has been deleted";
                    }else{
                        $error = "Comments has not been deleted";
                    }
                }
            }else{
                header('Location: index.php');
            }
        }
        $session_username = $_SESSION['username'];
        
        //Approve
        if(isset($_GET['approve'])){
            $approve_id = $_GET['approve'];
            $approve_check_query = "SELECT * FROM `comments` WHERE `id` = '$approve_id'";
            $approve_check_run = mysqli_query($conn, $approve_check_query);
            if(mysqli_num_rows($approve_check_run)){
                $approve_query = "UPDATE `comments` SET `status`='approve' WHERE `comments`.`id` = $approve_id";
                if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
                    if(mysqli_query($conn,$approve_query)){
                        $msg = "Comment has been Approved Successfully";
                    }else{
                        $error = "Approved Error!";
                    }
                }
            }else{
                header('Location: index.php');
            }
        }
        
        
        
        //Unapprove
        if(isset($_GET['unapprove'])){
            $unapprove_id = $_GET['unapprove'];
            $unapprove_check_query = "SELECT * FROM `comments` WHERE `id` = '$unapprove_id'";
            $unapprove_check_run = mysqli_query($conn, $unapprove_check_query);
            if(mysqli_num_rows($unapprove_check_run)){
                $unapprove_query = "UPDATE `comments` SET `status`='pending' WHERE `comments`.`id` = $unapprove_id";
                if(isset($_SESSION['username']) && $_SESSION['role'] == 'admin'){
                    if(mysqli_query($conn,$unapprove_query)){
                        $msg = "Comments has been Unapproved Successfully";
                    }else{
                        $error = "Unapproved Error!";
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
                    $bulk_del_query = "DELETE FROM `comments` WHERE `comments`.`id` = $user_id";
                    mysqli_query($conn,$bulk_del_query);
                    
                }else if($bulk_option == 'approve'){
                    $bulk_author_query = "UPDATE `comments` SET `status`='approve' WHERE `comments`.`id` = $user_id";
                    mysqli_query($conn,$bulk_author_query);
                    
                }else if($bulk_option == 'pending'){
                    $bulk_admin_query = "UPDATE `comments` SET `status`='pending' WHERE `comments`.`id` = $user_id";
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
                    <h1><i class="fa fa-comments"></i> Comments <small>View All Comments</small></h1>
                    <hr />
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer"></i> Dashbord</a></li>
                        <li class="active"><i class="fa fa-comments"></i> Comments</li>
                    </ol><!-- /.breadcrumb -->
                    
                    <?php
                    
                        if(isset($_GET['reply'])){
                            $reply_id = $_GET['reply'];
                            $reply_check_query = "SELECT * FROM `comments` WHERE `post_id` = '$reply_id'";
                            $reply_check_run = mysqli_query($conn, $reply_check_query);
                            if(mysqli_num_rows($reply_check_run) > 0){
                                if(isset($_POST['reply'])){
                                    $comment_data = $_POST['comment'];
                                    if(empty($comment_data)){
                                        $comment_error = "Must fill this field";
                                    }else{
                                        $get_user_data = "SELECT * FROM `users` WHERE `username` = '$session_username'";
                                        $get_user_run = mysqli_query($conn, $get_user_data);
                                        $get_user_row = mysqli_fetch_array($get_user_run);
                                        $date = date('Y-m-d',time());
                                        $first_name = $get_user_row['first_name'];
                                        $last_name = $get_user_row['last_name'];
                                        $full_name = "$first_name $last_name";
                                        $email = $get_user_row['email'];
                                        $image = $get_user_row['image'];
                                        $insert_comment_query = "INSERT INTO `comments` (date,name,username,post_id,email,image,comment,status) VALUES ('$date','$full_name','$session_username','$reply_id','$email','$image','$comment_data','approve')";
                                        
                                        if($insert_comment_run = mysqli_query($conn, $insert_comment_query)){
                                            $comment_msg = "Comment has been successfully submitted";
                                            header('Location: comments.php');
                                        }else{
                                            $comment_error = "Comment has not been submitted";
                                        }
                                    }
                                }    
                    ?>          
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="comment">Comment:</label>
                                            <?php
                                                if(isset($comment_error)){
                                                    ?>
                                                    <span class="pull-right" style="color: red;"><?php echo $comment_error; ?></span>
                                                    <?php
                                                }else if(isset($comment_msg)){
                                                    ?>
                                                    <span class="pull-right" style="color: green;"><?php echo $comment_msg; ?></span>
                                                    <?php
                                                }
                                            ?>
                                            <br /><br />
                                            <textarea name="comment" id="comment" class="form-control" cols="35" rows="10" placeholder="Your Comment Here"></textarea><br />
                                            <input type="submit" name="reply" class="btn btn-primary"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                    <?php 
                            }
                        }
                    ?>
                    <hr />
                    <?php
                    $query = "SELECT * FROM `comments` ORDER BY id DESC";
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
                                       <option value="approve">Approve</option>
                                       <option value="pending">Unapprove</option>
                                   </select>
                               </div><!-- /.form-group -->
                           </div><!-- /.col-xs-8 -->
                           
                           <div class="col-xs-8">
                               <input type="submit" class="btn btn-success" value="Apply"/>
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
                                       <th>Username</th>
                                       <th>Comment</th>
                                       <th>Status</th>
                                       <th>Approve</th>
                                       <th>Unapprove</th>
                                       <th>Reply</th>
                                       <th>Delete</th>
                                   </tr>
                               </thead>
                               <tbody>
                                   <?php
                                       while($row = mysqli_fetch_array($run)){
                                           $id = $row['id'];
                                           $username = $row['username'];
                                           $comment = $row['comment'];
                                           $post_id = $row['post_id'];                                           
                                           $status = $row['status'];
                                           $date = date("d M Y",strtotime($row['date']));
                                   ?>
                                           <tr>
                                               <td><input type="checkbox" class="checkboxes" name="checkboxes[]" value="<?php echo $id; ?>"/></td>
                                               <td><?php echo $id; ?></td>
                                               <td><?php echo $date; ?></td>
                                               <td><?php echo $username; ?></td>
                                               <td><?php echo $comment; ?></td>
                                               <td style="color: <?php if($status == 'approve'){echo "green";}else if($status == 'pending'){echo "red";} ?>;" ><?php echo ucfirst($status); ?></td>
                                               <td><a href="comments.php?approve=<?php echo $id;?>">Approve</a></td>
                                               <td><a href="comments.php?unapprove=<?php echo $id;?>">Unapprove</a></td>
                                               <td><a href="comments.php?reply=<?php echo $post_id;?>"><i class="fa fa-reply"></i></a></td>
                                               <td><a href="comments.php?del=<?php echo $id;?>"><i class="fa fa-times"></i></a></td>
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
