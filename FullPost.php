<?php 

require_once("includes/db.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");
$SearchQueryParameter = $_GET['id'];

Confirm_Login();
if(isset($_POST['Submit'])){
    $Name = $_POST['CommentName'];
    $Email =$_POST['CommentEmail'];
    $Comment =$_POST['CommenterThoughts'];

    
    //setting time for Warsaw Europe
    date_default_timezone_set("Europe/Warsaw");
    $currenttime = time();
    $displaycurrenttime = strftime("%A , %d-%B-%Y %H:%M:%S",$currenttime);

    // Sanitizing the data before publish to database
    if(empty($Name)||empty($Email)||empty($Comment)){
        $_SESSION['ErrorMessage']="Fill all fields";
        Redirect_to("FullPost.php?id=<?php echo $SearchQueryParameter?>");
    }elseif (strlen($Comment)>=501){
        $_SESSION['ErrorMessage']="Comment should have less than 500 characters";
        Redirect_to("FullPost.php?id=<?php echo $SearchQueryParameter?>");
    }else{
        //insert to DataBase 
        $sql = "INSERT INTO comments (datetime,name,email,comment,approvedby,status,post_id)";
        $sql .= "VALUES (:datetime,:name,:email,:comment,'pending','OFF',:postIdFromURL)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':datetime',$displaycurrenttime);
        $stmt->bindValue(':name',$Name);
        $stmt->bindValue(':email',$Email);
        $stmt->bindValue(':comment',$Comment);
        $stmt->bindValue(':postIdFromURL',$SearchQueryParameter);
        $Execute=$stmt->execute();

        if($Execute){
            $_SESSION['SuccessMessage']="Comment saved successfully with id: ".$ConnectingDB->lastInsertId();
            Redirect_to("FullPost.php?id=<?php echo $SearchQueryParameter?>");
        }else{
            $_SESSION['ErrorMessage']="Something went wrong!";
            Redirect_to("FullPost.php?id=<?php echo $SearchQueryParameter?>");
        }
    }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Blog</title>
    <script src="https://kit.fontawesome.com/4eb11aab35.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
<!-- NAVBAR-->
<div style="height:10px; background-color:#27aae1;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container bg-dark" >
        <a href="#" class="navbar-brand">Blog.COM</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapsecms">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarcollapsecms">
        <ul class="navbar-nav mr-auto">
            
            <li class="nav-item">
                <a href="Blog.php" class="nav-link">Home</a>
            </li>
            
            <li class="nav-item">
                <a href="Blog.php" class="nav-link">Blog</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Contact Us</a>
            </li>
            <li class="nav-item">
                <a href="categories.php" class="nav-link">Features</a>
            </li>
            <li class="nav-item">
                <a href="Posts.php" class="nav-link">Posts</a>
            </li>
            
        </ul>
        <ul class="navbar-nav ml-auto">
            <form class="form-inline " action="Blog.php">
                <div class="form-group">
                <input class="form-control t mr-2" type="text" name="Search" placeholder="Search here" value="" >
                <button class="btn btn-primary" name="searchbutton">Find</button>
                </div>
            </form>
        </ul>
        
</nav>
<div style="height:10px; background-color:#27aae1;"></div>
<!--  NAVBAREND-->
<!--  HEADER-->
<div class="container">
    <div class="row mt-4">
        <!--  Main Area-->
        
        <div class="col-sm-8" style="min-height:40px; ">
        
            <h1>Complete CMS Blog</h1>
            <h1 class="lead">this blog powered by PHP, Javascript and JQuery</h1>
            <?php echo ErrorMessage(); echo SuccessMessage();?>
            <?php
            global $ConnectingDB;
            if(isset($_GET["searchbutton"])) {
                $Search =$_GET['Search'];
                $sql = "SELECT * FROM posts WHERE
                category LIKE :search OR 
                post LIKE :search OR 
                title LIKE :search OR 
                author LIKE :search 
                ORDER BY id desc";
                $stmt = $ConnectingDB->prepare($sql);
                $stmt->bindValue(':search','%'.$Search.'%');
                $stmt->execute();
            }else{
                $PostIdFromURL = $_GET["id"];
                if(!isset($PostIdFromURL)){
                    $_SESSION['ErrorMessage']="Bad request";
                    Redirect_to("Blog.php");
                }
                $sql = "SELECT * FROM posts WHERE id='$PostIdFromURL' ORDER BY id desc";
                $stmt = $ConnectingDB->query($sql);
            }
            
            while($DataRows=$stmt->fetch()){
                $PostId = $DataRows['id'];
                $DateTime = $DataRows['datetime'];
                $PostTitle = $DataRows['title'];
                $Category = $DataRows['category'];
                $Author = $DataRows['author'];
                $Post = $DataRows['post'];
                $Image = $DataRows['image'];
            ?>

            <div class="card">
                <img src="uploads/<?php echo htmlentities($Image); ?>" style="max-height:450px;" class="img-fluid">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $PostTitle;?></h4>
                    <small class="text-muted" >Written by <?php echo $Author.": ".$DateTime;?></small>
                    <span style="float:right;" class="badge badge-dark text-light">
                    <?php 
                    global $ConnectingDB;
                    $sql = "SELECT COUNT(*) FROM comments WHERE post_id='$SearchQueryParameter'";
                    $stmt = $ConnectingDB->query($sql);
                    $TotalRows = $stmt->fetch();
                    $TotalComments = array_shift($TotalRows);
                    echo "Comments: ".$TotalComments;
                    ?>
                    </span>
                    <hr>
                    <p class="card-text">
                        <?php  echo $Post; ?>
                    </p>
                    <a href="Blog.php" style="float:right">
                        <button class="btn btn-info" type="submit" name="Submit">return >></button>
                    </a>
                </div>
            </div>
            <?php } ?>
            <div class="">
                <!-- comments part -->
            <form class="" action="FullPost.php?id=<?php echo $SearchQueryParameter?>" method="post">
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="h6 text-muted">Share your thoughts here below:</h5>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span> 
                            </div>
                        <input class="form-control" type="text" name="CommentName" placeholder="type here" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span> 
                            </div>
                        <input class="form-control" type="text" name="CommentEmail" placeholder="type here" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="CommenterThoughts"></textarea>
                    </div>
                    <div class="">
                        <button type="submit" name="Submit" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>
            <!-- comments part -->
            <!-- Fetch existing comments part -->
            <span class="FieldInfo">Comments:</span>
            <br>
            <br>
            <?php 
                global $ConnectingDB;
                $sql = "SELECT * FROM comments WHERE post_id='$SearchQueryParameter' AND status='ON'";
                $stmt = $ConnectingDB->query($sql);
                while($DataRows = $stmt->fetch()){
                    $CommentDate = $DataRows['datetime'];
                    $CommentName = $DataRows['name'];
                    $CommentContent = $DataRows['comment'];

                ?>
                <div>
                    
                    <div class="media CommentBlock">
                        <div class="media-body ml-2">
                            <h6 class="lead"><?php echo $CommentName;?></h6>
                            <p class=""><?php echo $CommentContent;?></p>
                            <p class="small"><?php echo $CommentDate;?></p>
                        </div>
                    </div>
                </div>
                <hr>
                <?php } ?>
            <!-- End of Fetch existing comments part -->
        </div>
        </div>
        <!--  Main Area End-->
        




        <!--  Side Area-->
        <div class="col-sm-4" style="min-height:40px; background:green">

        </div>
        <!--  Side Area End-->
    </div>
</div>
<!--  HEADER END-->
<br>



<!--  FOOTER-->

<footer class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="lead text-center">Theme By | Lukasz Iwon | <span id="year"></span> &copy; ---- All rights reserved</p>
            </div>
        </div>
    </div>
</footer>
<!--  FOOTER END-->
<div style="height:10px; background-color:#27aae1;"></div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
    $('#year').text(new Date().getFullYear());
</script>
</body>
</html>