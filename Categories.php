<?php
require_once("includes/db.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

Confirm_Login();
if(isset($_POST['Submit'])){
    $Category = $_POST['CategoryTitle'];
    $Admin = $_SESSION["Aname"];
    //setting time for Warsaw Europe
    date_default_timezone_set("Europe/Warsaw");
    $currenttime = time();
    $displaycurrenttime = strftime("%A , %d-%B-%Y %H:%M:%S",$currenttime);

    // Sanitizing the data before publish to database
    if(empty($Category)){
        $_SESSION['ErrorMessage']="All fields must be filled out";
        Redirect_to("Categories.php");
    }elseif (strlen($Category)<3 && strlen($Category)>49){
        $_SESSION['ErrorMessage']="Category sholud have more than 3 and less than 50 letters";
        Redirect_to("Categories.php");
    }
    // elseif (strlen($Category)>=3 && strlen($Category)<=49){
    //     $_SESSION['SuccessMessage']="Success";
    //     Redirect_to("Categories.php");
    elseif (strlen($Category)>=3 && strlen($Category)<=49){
        //insert to DataBase 
        $sql = "INSERT INTO category (title,author,datetime)";
        $sql .= "VALUES (:categoryName,:adminName,:datetime)";
        $stmt = $ConnectingDB->prepare($sql);
        $stmt->bindValue(':categoryName',$Category);
        $stmt->bindValue(':adminName',$Admin);
        $stmt->bindValue(':datetime',$displaycurrenttime);
        $Execute=$stmt->execute();

        if($Execute){
            $_SESSION['SuccessMessage']="Saved to Database successfully with id: ".$ConnectingDB->lastInsertId();
            Redirect_to("Categories.php");
        }else{
            $_SESSION['ErrorMessage']="Something went wrong!";
            Redirect_to("Categories.php");
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Categories</title>
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
                <a href="Blog.php" class="nav-link">Live Blog</a>
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
                <h1><i class="fas fa-edit" style="color:#27aae1; "></i>Manage Categories</h1>
            </div>
        </div>
    </div>
</header>
<!--  HEADER END-->

<!--  Main area-->
<section class="container py-2 mb-4" style="min-height:500px;">
    <div class="row" >
        <div class="offset-lg-1 col-lg-10" >

        <?php echo ErrorMessage(); echo SuccessMessage();?>
        <form class="" action="Categories.php" method="post">
            <div class="card bg-secondary text-light">
                <div class="card-header">
                    <h1>Add New category</h1>
                </div>
                <div class="card-body bg-dark">
                    <div class="form-group">
                        <label for="title" class="text-warning">Category title:</label>
                        <input class="form-control" type="text" name="CategoryTitle" id="title" placeholder="Type title here">
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