<?php

require_once("includes/db.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");
$SearchQueryParameter = $_GET['id'];
Confirm_Login();
if(isset($_POST['Submit'])){
    //Superglobals
    $PostTitle = $_POST['PostTitle'];
    $Category = $_POST['Category'];
    $Image = $_FILES['Image']["name"];
    $PostText = $_POST['PostDescription'];
    $Target = "uploads/".basename($_FILES['Image']["name"]);

    $Admin = "Lukasz";
    //setting time for Warsaw Europe
    date_default_timezone_set("Europe/Warsaw");
    $currenttime = time();
    $displaycurrenttime = strftime("%A , %d-%B-%Y %H:%M:%S",$currenttime);

    // Sanitizing the data before publish to database
    if(empty($PostTitle)){
        $_SESSION['ErrorMessage']="Title cant be empty";
        Redirect_to("Posts.php");
    }elseif (strlen($PostTitle)<3 && strlen($PostTitle)>999){
        $_SESSION['ErrorMessage']="Post sholud have more than 3 and less than 1000 letters";
        Redirect_to("Posts.php");
    }
    // elseif (strlen($Category)>=3 && strlen($Category)<=49){
    //     $_SESSION['SuccessMessage']="Success";
    //     Redirect_to("Categories.php");
    // if(!empty($_FILES['$Image']['name'])){
    //     $sql = "UPDATE posts
    //              SET datetime='$displaycurrenttime',title='$PostTitle', category='$Category',image='$Image',post='$PostText' 
    //              WHERE id='$SearchQueryParameter' ";
    // }
    elseif (strlen($PostTitle)>=3 && strlen($PostTitle)<=49){
        //insert to DataBase 
        $sql = "UPDATE posts
                 SET datetime='$displaycurrenttime',title='$PostTitle', category='$Category',image='$Image',post='$PostText' 
                 WHERE id='$SearchQueryParameter' ";
        $Execute = $ConnectingDB->query($sql);
        move_uploaded_file($_FILES['Image']["tmp_name"],$Target);

        // var_dump($Execute);
        if($Execute){
            $_SESSION['SuccessMessage']="Saved to Database successfully with id: ".$ConnectingDB->lastInsertId();
            Redirect_to("Posts.php");
        }else{
            $_SESSION['ErrorMessage']="Something went wrong!";
            Redirect_to("Posts.php");
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Edit Posts</title>
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
<!--  NAVBAR END-->
<!--  HEADER-->
<header class="bg-dark text-white py-5">
    <div class="container ">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fas fa-edit" style="color:#27aae1; "></i>Add New Post</h1>
            </div>
        </div>
    </div>
</header>
<!--  HEADER END-->

<!--  Main area-->
<section class="container py-2 mb-4" style="min-height:500px;">
    <div class="row" >
        <div class="offset-lg-1 col-lg-10" >

        <?php echo ErrorMessage(); echo SuccessMessage();
        
        global $ConnectingDB;
        
        $sql = "SELECT * FROM posts WHERE id='$SearchQueryParameter'";
        $stmt = $ConnectingDB->query($sql);
        while($DataRows=$stmt->fetch()){
            $TitleToBeUpdated = $DataRows['title'];
            $CategoryToBeUpdated = $DataRows['category'];
            $ImageToUpdate = $DataRows['image'];
            $PostToUpdate = $DataRows['post'];
        }


        ?>
        <!--  Aby dodać pliki i zapisywać trzeba dodać parametr enctype -->
        <form class="" action="EditPosts.php?id=<?php echo $SearchQueryParameter;?>" method="post" enctype="multipart/form-data">
            <div class="card bg-secondary text-light">
                <!-- <div class="card-header">
                    <h1>Add New Post</h1>
                </div> -->
                <div class="card-body bg-dark">
                    <div class="form-group">
                        <label for="title" class="text-warning">Post title:</label>
                        <input class="form-control" type="text" name="PostTitle" id="title" placeholder="Type title here">
                    </div>
                    <div class="form-group">
                        <span class="FieldInfo text-warning" >Existing Category:</span>
                        <?php echo $CategoryToBeUpdated;?>
                        <br>
                        <label for="title" class="text-warning">Choose Category:</label>
                        <select class="form-control" id="CategoryTitle" name="Category">
                            <?php 
                            global $ConnectingDB;
                            $sql = "SELECT * FROM category";
                            $stmt = $ConnectingDB->query($sql);
                            while($DateRows = $stmt->fetch()){
                                $Id = $DateRows["id"];
                                $CategoryName = $DateRows["title"];
                            
                            echo "<option>".$CategoryName."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-1">
                        
                        <div class="custom-file">
                            <input class="custom-file-input" type="File" name="Image" id="ImageSelect" value="">
                            <label for="ImageSelect" class="custom-file-label">Select Image</label>
                            
                        </div>
                        <img class="mb-1" src="uploads/<?php echo $ImageToUpdate;?>" width="170px">
                    </div>
                    <div class="form-group">
                    <label for="Post" class="text-warning">Post:</label>
                    <textarea class="form-control" id="Post" name="PostDescription" rows="8" cols="80">
                        <?php echo $PostToUpdate;?>
                    </textarea>
                    </div>
                    <div class="row" >
                        <div class="col-lg-6 mb-2">
                            <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
                        </div>
                        <div class="col-lg-6 mb-2">
                            <button type="submit" name="Submit" class="btn btn-success btn-block"><i class="fas fa-check"></i>Publish</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
        </div>
    </div>

</section>



<!--  Main area END-->

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