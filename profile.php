<?php 
require_once("config.php");
if(!isset($_SESSION['email'])){
    header("location:index.php");
}
$s = mysqli_fetch_array(mysqli_query($al, "SELECT * FROM students WHERE email='".$_SESSION['email']."'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $s['name'];?></title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <?php require("banner.php");?>
    <br>
    <div align="center">
        <div id="box">
            <span class="formHeading">Welcome &nbsp;<?php echo $s['name'];?></span><br>
            <img src="Profile_pics/<?php echo $s['picture'];?>" height="100" width="100"/>
            <br>
           <br>
           <table border="0" cellpadding="5" cellspacing="5">
            <tr>
                <td class="labels">Name:</td>
                <td class="labels" style="color:mediumturquoise"><?php echo $s['name'];?></td>
            </tr>
            <tr>
                <td class="labels">Date of Birth:</td>
                <td class="labels" style="color:mediumturquoise;"><?php echo $s['dob'];?></td>
            </tr>
            <tr>
                <td class="labels">Email ID:</td>
                <td class="labels" style="color:mediumturquoise;"><?php echo $s['email'];?></td>
            </tr>
            <tr>
                <td class="labels">Address:</td>
                <td class="labels" style="color:mediumturquoise;"><?php echo $s['address'];?></td>
            </tr>
            <tr>
                <td class="labels">Date of Registration:</td>
                <td class="labels" style="color:mediumturquoise;"><?php echo $s['date'];?></td>
            </tr>
</table>
<input type="button" value="EDIT" onClick="window.location='edit.php'"/>
<input type="button" value="HOME" onClick="window.location='home.php'"/>
</div>
</div>
<div id="footer" align="center">&copy; Copyright Priyanka-2022 | Designed &amp; Developed by Priyanka
</body>
</html>