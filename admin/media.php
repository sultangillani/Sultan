<?php include_once 'inc/header.php';?>
    <div class="admin-main">
        <div class="container-fluid body-sections">
            <div class="row">
                <div class="col-md-3 admin-sidebar">
                    
                    <?php include_once 'inc/sidebar.php';?>
                    
                </div><!-- /.col-md-3 -->
                
                <div class="col-md-9 admin-content">
                    <h1><i class="fa fa-database"></i> Media <small>Add or View Media Files</small></h1>
                    <hr />
                    <ol class="breadcrumb">
                        <li><a href="index.php"><i class="fa fa-tachometer"></i> Dashbord</a></li>
                        <li class="active"><i class="fa fa-database"></i> Media</li>
                    </ol><!-- /.breadcrumb -->
                    
                    <?php
                        if(isset($_POST['submit'])){
                            if( count($_FILES['media']) > 0 ){
                                for($i = 0; $i < count($_FILES['media']['name']); $i++ ){
                                    $image = $_FILES['media']['name'][$i];
                                    $tmp_name = $_FILES['media']['tmp_name'][$i];
                                    
                                    $query = "INSERT INTO `media` (image) VALUES('$image')";
                                    if(mysqli_query($conn,$query)){
                                        $path = "../img/$image";
                                        move_uploaded_file($tmp_name, $path);
                                        header('Location: media.php');
                                    }
                                    
                                }
                            }
                            
                        }
                    ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-4 col-xs-8">
                                <input type="file" name="media[]" required multiple/>
                            </div>
                            <div class="col-sm-4 col-xs-4">
                                <input type="submit" name="submit" value="Add Media" class="btn btn-primary btn-sm"/>
                            </div>
                        </div>
                    </form><hr />
                    
                    <div class="row">
                        <?php
                            $get_query = "SELECT * FROM `media` ORDER BY id DESC";
                            $get_run = mysqli_query($conn, $get_query);
                            if(mysqli_num_rows($get_run) > 0){
                                while($get_row = mysqli_fetch_array($get_run)){
                                    $get_image = $get_row['image'];
                        ?>
                            
                                    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-6 thumb">
                                        <a href="#" class="thumbnail">
                                            <img src="media/<?php echo $get_image;?>" alt="" style="width: 100px; height: 100px"/> 
                                        </a>
                                    </div>
                        <?php
                                }
                            }else{
                                echo "<center><h2>No Media is Found.</h2></center>";
                            }
                        ?>
                    </div>
                </div><!-- /.col-md-9 -->
            
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div><!-- /.admin-main -->
    
<?php include_once 'inc/footer.php';?>
