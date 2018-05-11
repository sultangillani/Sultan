<?php
    include_once 'inc/header.php';
?>
    <div class="jumbotron head-img">
        <div class="container">
            <div id="details" class="animated fadeInLeft">
                <h1>Contact <span>Us</span></h1>
                <p>We are Availabel 24x7. So Feel Free to Contact Us.</p>
            </div>
        </div>
        <img src="img/head.jpg" alt="Top Image"/>
    </div>
    
    <section ng-controller="usercontroller" class="content-body">
        
        <div class="container">
            <div class="row">
                <div class="col-md-8 content">
                    <div class="row">
                        <div class="col-md-12 map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d115765.99429970614!2d67.06682832649714!3d24.942719630202575!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x3eb3388923ede0c9%3A0x305b161d349bba39!2sGulshan-e-Noor%2C+Suparco+Road%2C+Karachi!3m2!1d24.942736!2d67.1368691!5e0!3m2!1sen!2s!4v1520117907085" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                        <div class="col-md-12 contact-form">
                            
                            <?php
                                if(isset($_POST['submit'])){
                                    $name = mysqli_real_escape_string($conn,htmlentities($_POST['full-name']));
                                    $email = mysqli_real_escape_string($conn,htmlentities($_POST['email']));
                                    $website = mysqli_real_escape_string($conn,htmlentities($_POST['website']));
                                    $comment = mysqli_real_escape_string($conn,htmlentities($_POST['comment']));
                                    
                                    $to = "sultangilani13@gmail.com";
                                    $header = "$name<$email>";
                                    $subject = "Message From $name";
                                    
                                    echo $message = "Name: $name \n\n Email: $email \n\n website: $website \n\n Message:\n $comment \n\n";
                                    /**/if(empty($name) || empty($email) || empty($website) || empty($comment)){
                                        $error = "All (*) fields are required to fill.";
                                    }else{
                                        if(mail($to,$subject,$message,$header)){
                                            $msg = "Message Has been Sent";
                                        }else{
                                            $error = "Message Has not been Sent";                                            
                                        }
                                    }
                                }
                            ?>
                            <h2>Contact Form</h2>
                            <hr />
                            <form class="" action="" method="post">
                                
                                <div class="form-group">
                                    <label for="full-name">Full Name:* </label>
                                    <?php
                                        if(isset($error)){
                                            echo '<span class="pull-right" style="color:red">' . $error . '</span>';
                                        }else if(isset($msg)){
                                            echo '<span class="pull-right" style="color:green">' . $msg . '</span>';
                                        }
                                    ?>
                                    <input type="text" class="form-control" id="full-name" value="<?php if(isset($name)){echo $name;}?>" name="full-name" placeholder="Full Name"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email:* </label>
                                    <input type="text" class="form-control" id="email" value="<?php if(isset($email)){echo $email;}?>" name="email" placeholder="Email"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="website">Website: </label>
                                    <input type="text" class="form-control" id="website" value="<?php if(isset($website)){echo $website;}?>" name="website" placeholder="Website"/>
                                </div>
                                
                                <div class="form-group">
                                    <label for="comment">Message:* </label>
                                    <textarea class="form-control" id="comment" name="comment" cols="30" rows="10" placeholder="Message"><?php if(isset($comment)){echo $comment;}?></textarea>
                                </div>
                                
                                <input type="submit" name="submit" value="submit" class="btn btn-primary"/>
                                
                            </form>
                        </div>
                    </div>
                    
                </div><!-- /content -->
                
                <div class="col-md-4 sidebar">
                    <?php include_once 'inc/sidebar.php'; ?>
                </div><!-- /sidebar -->
                
            </div><!-- /row -->
        </div><!-- /container -->
        
    </section><!-- /content-body -->

<?php
    include_once 'inc/footer.php';
?>