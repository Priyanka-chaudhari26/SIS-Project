<?php
require_once("config.php");
// User cannot access login page again until he's logout for that we need to control session
// session is set when user successfully login then it will redirect to home.php
if(isset($_SESSION['email'])){
    header("location:home.php"); //If user bychance comes to index.php even if he's logged in then we will redirect it to home.php
}
if(!empty($_POST)){
    $email= mysqli_real_escape_string($al, $_POST['email']);
    $pass= mysqli_real_escape_string($al, sha1($_POST['password']));
    $sql= mysqli_query($al, "SELECT * FROM students WHERE email='".$email."' AND password='".$pass."'");
    if(mysqli_num_rows($sql)== 1){
        //if true redirect to home page
        //before that we need to create session (for that session start is req which is already mentioned in config file)
        $_SESSION['email'] = $_POST['email'];
        //Now redirect it
        header("location:home.php");
    }
    else{
        $msg= "Incorrect credentials";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information System</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
    <?php require("banner.php");?>
    <br/>
    <div align="center">
        <div id="box">
            <span class="formHeading">Student Login</span>
            <br/><br/>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>"> <!--It means data will be submitted on same page-->
            <table border="0" cellpadding="5" cellspacing="5">
                <tr>
                    <td align="center" colspan="2" style="color: red; font-size:20px;"><?php 
                    if(isset($msg)) {
                         echo $msg;} ?></td>
                </tr>
                <tr>
                    <td class="labels">Email:</td>
                    <td><input type="email" name="email" placeholder="Enter your email" size="20" required/></td>
                </tr>
                <tr>
                    <td class="labels">Password:</td>
                    <td><input type="password" name="password" placeholder="Enter your password" size="20" required/></td>
                </tr>
                <tr>
                    <td class="labels" colspan="2" align="center"><button type="submit" value="Login">Login</button</td>
                </tr>
                <tr>
                    <td align="center" colspan="2" class="text">New user?<a href="registration.php" class="link"> Register here</a></td>
                </tr>
            </table>
            </form>
        </div>  
    </div>
    <div id="footer" >
        &copy; Copyright Priyanka Chaudhari | 2022 
    </div>
</body>
</html>