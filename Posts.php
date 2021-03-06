<?php 
require_once("includes/db.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");
Confirm_Login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Posts</title>
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
                <a href="Posts.php" class="nav-link">Posts</a>
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
                <a href="Blog.php" class="nav-link">Live Blog</a>
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
            <div class="col-md-12 ">
                <h1><i class="fab fa-microblog" style="color:#27aae1; "></i>Blog Posts</h1>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 mb-1">
                <a href="AddNewPost.php" class="btn btn-primary btn-block">
                    <i class="fas fa-edit"></i>New
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 mb-1">
                <a href="Categories.php" class="btn btn-info btn-block">
                    <i class="fas fa-folder-plus"></i>New Category
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 mb-1">
                <a href="Admins.php" class="btn btn-warning btn-block">
                    <i class="fas fa-user-plus"></i>Add New Admin
                </a>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4 mb-1">
                <a href="Admins.php" class="btn btn-success btn-block">
                    <i class="fas fa-check"></i>Approve Comments
                </a>
            </div>
        </div>
    </div>
</header>
<!--  HEADER END-->

<!--  Main Area -->
<section class="container py-2 mb-4">
<?php echo ErrorMessage(); echo SuccessMessage();?>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>#Nr</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Dat & Time</th>
                    <th>Author</th>
                    <th>Banner</th>
                    <th>Comments</th>
                    <th>Action</th>
                    <th>Live Preview</th>
                </tr>
                </thead>
                <?php 
                global $ConnectingDB;
                $sql = "SELECT * FROM posts";
                $stmt = $ConnectingDB->query($sql);
                while($DataRows=$stmt->fetch()){
                    $Id = $DataRows["id"];
                    $DateTime =$DataRows["datetime"];
                    $PostTitle = $DataRows["title"];
                    $Category = $DataRows["category"];
                    $Admin = $DataRows["author"];
                    $Image = $DataRows["image"];
                    $PostText = $DataRows["post"];

                
                ?>
                <tbody>
                <tr>
                    <td><?php echo "#".$Id." "; ?></td>
                    <td class="table-danger"><?php if(strlen($PostTitle)>5) {$PostTitle=substr($PostTitle,0,5).' ...';} echo $PostTitle; ?></td>
                    <td><?php echo $Category; ?></td>
                    <td class="table-success"><?php echo $DateTime; ?></td>
                    <td class="table-primary"><?php echo $Admin; ?></td>
                    <td><img src="uploads/<?php echo $Image; ?>" height="50px;"></td>
                    <td>Comments</td>
                    <td>
                        <a href="EditPosts.php?id=<?php echo $Id;?>" ><span class="btn btn-warning">Edit</span></a>
                        <a href="DeletePost.php?id=<?php echo $Id;?>" ><span class="btn btn-danger">Delete</span></a>
                    </td>
                    <td><a href="FullPost.php?id=<?php echo $Id;?>" ><span class="btn btn-primary">Live Preview</span></a></td>
                <?php } ?>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<!--  Main Area END-->


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