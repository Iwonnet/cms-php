<?php
require_once("includes/db.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

if (isset($_POST["Submit"])){
    $Username=$_POST['Username'];
    $Password=$_POST['Password'];
    if(empty($Username)||empty($Password)){
        $_SESSION["ErrorMessage"]="All fields are required";
        Redirect_to("Login.php");

    }else {

        $Found_Account=Login_Attempt($Username,$Password);
        if($Found_Account){
            $_SESSION["User_ID"]=$Found_Account["id"];
            $_SESSION["User_name"]=$Found_Account["username"];
            $_SESSION["Aname"]=$Found_Account["aname"];
            $_SESSION["SuccessMessage"]="Welcome Admin! ".$_SESSION["User_name"];
            Redirect_to("Dashboard.php");
        }else{
            $_SESSION["ErrorMessage"]="Incorrect Username/Password";
            Redirect_to("Login.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Login</title>
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
                <h1></h1>
            </div>
        </div>
    </div>
</header>
<!--  HEADER END-->
<br>

<!--  Login Form-->
<section class="container py-2 mb-4">

    <div class="row">
    
        <div class="offset-sm-3 col-sm-6" style="min-height:350px;">
        <?php echo ErrorMessage(); echo SuccessMessage();?>
            <div class="card bg-secondary text-light">
                <div class="class-header">
                    <h4>Welcome!</h4>
                    </div>
                    <div class="card-body bg-dark">

                    
                    <form action="Login.php" class="" method="post">
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Username:</span></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-white bg-info"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" name="Username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Password:</span></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text text-white bg-info"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" name="Password">
                            </div>
                        </div>
                        <input type="submit" class="btn btn-info btn-block" name="Submit" value="login">
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
<!--  Login Form END-->
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