<?php
require_once("includes/db.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <script src="https://kit.fontawesome.com/4eb11aab35.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
<!-- NAVBAR-->
<div style="height:10px; background-color:#27aae1;"></div>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container bg-dark" >
        <a href="#" class="navbar-brand">LUKASZIWON.COM</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapsecms">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarcollapsecms">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a href="Myprofile.php" class="nav-link text-success"><i class="fas fa-user"></i>My Profile</a>
            </li>
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="posts.php" class="nav-link">Posts</a>
            </li>
            <li class="nav-item">
                <a href="manageadmins.php" class="nav-link">Manage Admins</a>
            </li>
            <li class="nav-item">
                <a href="categories.php" class="nav-link">Categories</a>
            </li>
            <li class="nav-item">
                <a href="comments.php" class="nav-link">Comments</a>
            </li>
            <li class="nav-item">
                <a href="liveblog.php" class="nav-link">Live Blog</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a href="Logout.php" class="nav-link text-danger"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul>
        
</nav>
<div style="height:10px; background-color:#27aae1;"></div>
<!--  NAVBAREND-->
<!--  HEADER-->
<header class="bg-dark text-white py-5">
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fas fa-text-height" style="color:#27aae1; "></i>Django</h1>
            </div>
        </div>
    </div>
</header>
<!--  HEADER END-->
<br>


<section class="container py-2 mb-4">
    <div class="row" style="min-height:30px;">
        <div class="col-lg-12" style="min-height:400px;">
        <?php echo ErrorMessage(); echo SuccessMessage();?>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Nr</th>
                    <th>Name</th>
                    <th>DateTime</th>
                    <th>Comment</th>
                    <th>Action</th>
                    <th>Delete</th>
                    <th>Details</th>
                    
                </tr>
            
        <h2>Aprovved Comments</h2>
        <?php
            global $ConnectingDB;
            $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id DESC";
            $Execute = $ConnectingDB->query($sql);
            $SrNo=0;
            while($row=$Execute->fetch()){
                $CommentID = $row['id'];
                $DateTimeOfComment = $row['datetime'];
                $CommenterName = $row['name'];
                $CommentContent = $row['comment'];
                $CommentPostID = $row['post_id'];
                $SrNo++;
            

        ?>
        <tbody>
            <tr>
                <td> <?php echo $SrNo;?>      </td>
                <td>  <?php echo $CommenterName;?>      </td>
                <td> <?php echo $DateTimeOfComment;?>       </td>
                <td>  <?php echo $CommentContent;?>      </td>
                <td> <a class="btn btn-success" href="ApproveComment.php?id=<?php echo $CommentID;?>">Approve</a> </td>
                <td> <a class="btn btn-danger" href="DeleteComment.php?id=<?php echo $CommentID;?>">Delete</a> </td>
                <td>  <a class="btn btn-primary" href="FullPost.php?id=<?php echo $CommentPostID;?>" target="_blank">Live Preview</a> </td>
        </tbody>
        <?php } ?>
        </thead>
        </table>
        </div>
    </div>

</section>


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