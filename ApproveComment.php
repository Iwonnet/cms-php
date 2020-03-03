<?php
require_once("includes/db.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

if(isset($_GET["id"])){
    $SearchQueryParameter=$_GET['id'];
    global $ConnectingDB;
    $Admin = $_SESSION['Aname'];
    $sql = "UPDATE comments SET status='ON', approvedby='$Admin' WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if($Execute){
        $_SESSION["SuccessMessage"]="Comment Approved Successfully!";
        Redirect_to("Comments.php");
    }else{
        $_SESSION["ErrorMessage"]="Something went wrong!";
        Redirect_to("Comments.php");
    }
}


?>