<?php
require_once("includes/db.php");
require_once("includes/Functions.php");
require_once("includes/Sessions.php");

if(isset($_GET["id"])){
    $SearchQueryParameter=$_GET['id'];
    global $ConnectingDB;
    $Admin = $_SESSION['Aname'];
    $sql = "DELETE FROM comments WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if($Execute){
        $_SESSION["SuccessMessage"]="Comment Deleted Successfully!";
        Redirect_to("Comments.php");
    }else{
        $_SESSION["ErrorMessage"]="Something went wrong!";
        Redirect_to("Comments.php");
    }
}


?>