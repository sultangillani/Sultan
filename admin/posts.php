<?php include_once 'inc/header.php';?>

    <?php
        $session_username = $_SESSION['username'];
        
        if(isset($_GET['del'])){
            $del_id = $_GET['del'];
            if($_SESSION['role'] == 'admin'){
                $del_check_query = "SELECT * FROM `posts` WHERE `id` = '$del_id'";
                $del_check_run = mysqli_query($conn, $del_check_query);
            }else if($_SESSION['role'] == 'author'){
                $del_check_query = "SELECT * FROM `posts` WHERE `id` = '$del_id' and `author` = '$session_username'";
                $del_check_run = mysqli_query($conn, $del_check_query);
            }
            
                if(mysqli_num_rows($del_check_run)){
                    $del_query = "DELETE FROM `posts` WHERE `id` = $del_id";
                    if(mysqli_query($conn,$del_query)){
                        $msg = "Post has been deleted";
                    }else{
                        $error = "Post has not been deleted";
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
                    $bulk_del_query = "DELETE FROM `posts` WHERE `posts`.`id` = $user_id";
                    mysqli_query($conn,$bulk_del_query);
                    
                }else if($bulk_option == 'draft'){
                    $bulk_author_query = "UPDATE `posts` SET status='draft' WHERE `posts`.`id` = $user_id";
                    mysqli_query($conn,$bulk_author_query);
                    
                }else if($bulk_option == 'publish'){
                    $bulk_admin_query = "UPDATE `posts` SET status='publish' WHERE `posts`.`id` = $user_id";
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
                    <h1><i class="fa fa-file-text"></i> Posts <small>View All Posts</small></h1>
                    <hr />
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer"></i> Dashbord</a></li>
                        <li class="active"><i class="fa fa-file-text"></i> Posts</li>
                    </ol><!-- /.breadcrumb -->
                    
                    <?php
                    if($_SESSION['role'] == 'admin'){
                        $query = "SELECT * FROM `posts` ORDER BY id DESC";
                        $run = mysqli_query($conn, $query);
                    }else if($_SESSION['role'] == 'author'){
                        //$session_username
                        $query="SELECT * FROM `posts` WHERE `author` = '$session_username' ORDER BY id DESC";
                        $run = mysqli_query($conn, $query);
                    }
                    
                    if(mysqli_num_rows($run) > 0){
                    ?>
                    <form action="" method="POST">
                        <div class="row">
                           <div class="col-xs-4">
                               <div class="form-group">
                                   <select name="bulk-options" id="" class="form-control">
                                       <option value=""></option>
                                       <option value="delete">Delete</option>
                                       <option value="publish">Publish</option>
                                       <option value="draft">Draft</option>
                                   </select>
                               </div><!-- /.form-group -->
                           </div><!-- /.col-xs-8 -->
                           
                           <div class="col-xs-8">
                               <input type="submit" class="btn btn-success" value="Apply"/>
                               <a href="add-post.php" class="btn btn-primary">Add New</a>
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
                                       <th>Title</th>
                                       <th>Author</th>
                                       <th>Image</th>
                                       <th>Categories</th>
                                       <th>Views</th>
                                       <th>Status</th>
                                       <th>Edit</th>
                                       <th>Delete</th>
                                       
                                   </tr>
                               </thead>
                               <tbody>
                                   <?php
                                       while($row = mysqli_fetch_array($run)){
                                           $id = $row['id'];
                                           $title = ucfirst($row['title']);
                                           $author = $row['author'];
                                           $views = ucfirst($row['views']);
                                           $image = $row['image'];
                                           $date = date("d M Y",strtotime($row['date']));
                                           $categories = $row['categories'];
                                           $status = $row['status'];
                                   ?>
                                           <tr>
                                               <td><input type="checkbox" class="checkboxes" name="checkboxes[]" value="<?php echo $id; ?>"/></td>
                                               <td><?php echo $id; ?></td>
                                               <td><?php echo $date; ?></td>
                                               <td><?php echo $title; ?></td>
                                               <td><?php echo $author; ?></td>
                                               <td><img src="../img/<?php echo $image; ?>" alt="download" width="50px"/></td>
                                               <td><?php echo $categories; ?></td>
                                               <td><?php echo $views; ?></td>
                                               <td style="color: <?php if($status == 'publish'){echo "green";}else if($status == 'draft'){echo "red";} ?>;" ><?php echo ucfirst($status); ?></td>
                                               <td><a href="edit-post.php?edit=<?php echo $id;?>"><i class="fa fa-pencil"></i></a></td>
                                               <td><a href="posts.php?del=<?php echo $id;?>"><i class="fa fa-times"></i></a></td>
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
                           <center><h2>No Posts Available Now</h2></center>
                           <?php
                       }
                       ?>
                    </form>
                </div><!-- /.col-md-9 -->
            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.admin-main -->
    
<?php include_once 'inc/footer.php';?>
