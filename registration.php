<?php 
require_once("config.php");
if(!empty($_POST)){
    // $name=$_POST['query']
    $hash_key = sha1(microtime()); //microtime will give time-stamp and wo unique rahega instead of md5
    // hash_key will be cipher text consisting of timestamp
    if($_FILES["dp"]["error"]>0){
        $msg= "File upload error";
    }
    else{
        $file_name = $_FILES["dp"]["name"]; //name or size or loc 
        $upload_dir = "Profile_pics";
        $extension= end(explode(".",$file_name));
        // now how will we identify unique profile_pics or user?
        $file_id= md5($_POST['email']).".".$extension;
        // we will be using email to uniquely identify file and encrypt it with md5
        // condition to upload only image format not docx or pdf
        if($extension == 'webp'  || $extension == 'WEBP'|| $extension == 'JPEG' || $extension == 'jpeg' || $extension == 'PNG' || $extension == 'png' || $extension == 'jpg' || $extension == 'JPG' || $extension == 'bmp'|| $extension == 'BMP' || $extension == 'gif' || $extension == 'GIF'){
            
            // file website se profile_pics folder mai gayi but ab hume file upload krna hai db mai.
            $sql=mysqli_query($al,"INSERT INTO students(hash_key,name,dob,address,email,password,picture,time,date,agent,ip) VALUES('".$hash_key."',
            '".mysqli_real_escape_string($al,$_POST['name'])."',
            '".mysqli_real_escape_string($al,$_POST['dob'])."',
            '".mysqli_real_escape_string($al,$_POST['address'])."',
            '".mysqli_real_escape_string($al,$_POST['email'])."',
            '".mysqli_real_escape_string($al,sha1($_POST['password']))."',
            '".mysqli_real_escape_string($al,$file_id)."',
            '".time()."',
            '".date('d-m-y')."',
            '".$_SERVER['HTTP_USER_AGENT']."',
            '".$_SERVER['REMOTE_ADDR']."')");

            //SQL INJECTION PROTECTION
            // mysqli_real_escape_string($al,$_POST['email']) for email. same for other fields as well.
            if($sql){
                move_uploaded_file($_FILES["dp"]["tmp_name"],$upload_dir."/".$file_id);
                $msg= "Sucessfully Registered!";
            }
            else{
                $msg= "Account already exists!";
            }
        }
        else{
            $msg= "Wrong file uploaded!";
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information System | registration</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>
<body>
    <?php require("banner.php");?>
    <br/>
    <div align="center">
        <div id="box">
            <span class="formHeading">New Registration</span>
            <br/><br/>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data"> <!--It means data will be submitted on same page-->
            <table border="0" cellpadding="5" cellspacing="5">
                <tr>
                    <td align="center" colspan="2" style="color: lightgreen; font-size:20px;"><?php 
                    if(isset($msg)) {
                         echo $msg;} ?></td>
                </tr>
                <tr>
                    <td class="labels">Name :</td>
                    <td><input type="name" name="name" placeholder="Enter your name" size="20" required/></td>
                </tr>
                <tr>
                    <td class="labels">Date of Birth :</td>
                    <td><input class="dob" type="date" name="dob" size="20" required/></td>
                </tr>
                <tr>
                    <td class="labels">Email :</td>
                    <td><input type="email" name="email" placeholder="Enter your email" size="20" required/></td>
                </tr>
                <tr>
                    <td class="labels">Password :</td>
                    <td><input type="password" name="p1" placeholder="Enter your password" size="20" required/></td>
                </tr>
                <tr>
                    <td class="labels">Confirm Password :</td>
                    <td><input type="password" name="p2" placeholder="Confirm password" size="20" required/></td>
                </tr>
                <tr>
                    <td class="labels">Address :</td>
                    <td><textarea name="address" placeholder="Enter Permanent address" size="20" required></textarea></td>
                </tr>
                <tr>
                    <td class="labels">Profile picture :</td>
                    <td><input name="dp" type= "file" required/></td>
                </tr>
                <tr>
                    <td class="labels" colspan="2" align="center"><button type="submit" value="Login">Register</button</td>
                </tr>
                <tr>
                    <td align="center" colspan="2" class="text">Already Registered?<a href="index.php" class="link"> Login here</a></td>
                </tr>
            </table>
            </form>
        </div>  
    </div>
    <br/>
    <br/>
    <br/>
    <br/>
    <div class="footer-class">
    <div id="footer" >
        &copy; Copyright Priyanka Chaudhari | 2022 
    </div>
    </div>
</body>
</html>