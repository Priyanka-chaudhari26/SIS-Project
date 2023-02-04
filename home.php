<!-- home is private page login and register is public page -->
<!-- User cannot access login page again until he's logout -->
<?php
require_once("config.php");
// if user somehow access home page without login then will be redirected to login page
if(!isset($_SESSION['email'])){
    header("location:index.php"); 
}
$s= mysqli_fetch_array(mysqli_query($al, "SELECT * FROM students WHERE email='".$_SESSION['email']."'"));
// now we can use $s and column name to display info of particular record.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $s['name']; ?></title> <!-- It will display name of student in the title section -->
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
    <?php require("banner.php");?>
    <br/>
    <div align="center">
        <div id="box">
            <span class="formHeading">Welcome <?php echo $s['name']; ?></span>
            <br/><br/>
            <img src="Profile_pics/<?php echo $s['picture'];?>" height="150" width="150" />
            <br/><br/>
            <input type="button" value="My Profile" onclick="window.location='profile.php'"/>
            <input type="button" value="Change Password" onclick="window.location='changePassword.php'"/>
            <input type="button" value="Delete Account" onclick="window.location='deleteAccount .php'"/>
        </div>  
    </div>
    <div id="footer" >
        &copy; Cop yright Priyanka Chaudhari | 2022 
    </div>
</body>
</html>