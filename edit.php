 <?php 
require_once("config.php");
if(!isset($_SESSION['email'])){
    header("location:index.php");
}
if(!empty($_POST)){
    $hash_key = sha1(microtime()); //microtime will give time-stamp and wo unique rahega instead of md5
    // hash_key will be cipher text consisting of timestamp
    if($_FILES["dp"]["error"]>0){
        $msg= "File upload error";
    }
    
        $file_name = $_FILES["dp"]["name"]; //name or size or loc 
        $upload_dir = "Profile_pics";
        $extension= end(explode(".",$file_name));
        $file_id= md5($_POST['email']).".".$extension;
        // we will be using email to uniquely identify file and encrypt it with md5
        // condition to upload only image format not docx or pdf
        if($extension == 'webp'  || $extension == 'WEBP'|| $extension == 'JPEG' || $extension == 'jpeg' || $extension == 'PNG' || $extension == 'png' || $extension == 'jpg' || $extension == 'JPG' || $extension == 'bmp'|| $extension == 'BMP' || $extension == 'gif' || $extension == 'GIF'){
            
            // file is updated in profile_pics folder from website. Now we have to update it in db.
            // $sql=mysqli_query($al,"INSERT INTO students(hash_key,name,dob,address,email,password,picture,time,date,agent,ip) VALUES('".$hash_key."',
            // '".mysqli_real_escape_string($al,$_POST['name'])."',
            // '".mysqli_real_escape_string($al,$_POST['address'])."',
            // '".mysqli_real_escape_string($al,$_POST['email'])."',
            // '".mysqli_real_escape_string($al,sha1($_POST['password']))."',
            // '".mysqli_real_escape_string($al,$file_id)."',
            // '".time()."',
            // '".date('d-m-y')."',
            // '".$_SERVER['HTTP_USER_AGENT']."',
            // '".$_SERVER['REMOTE_ADDR']."')");
            
            // if($sql){
                $msg= "Successfully updated Profile Picture";
            // }
            // else{
            //     $msg= "Update error";
            // }


            //SQL INJECTION PROTECTION
            // mysqli_real_escape_string($al,$_POST['email']) for email. same for other fields as well.
            
        }
        else{
            $msg= "Wrong file uploaded!";
        }

    
    $sql= mysqli_query($al,"UPDATE students SET 
            name= '".mysqli_real_escape_string($al,$_POST['name'])."',
            address= '".mysqli_real_escape_string($al,$_POST['address'])."',  
            dob ='".mysqli_real_escape_string($al,$_POST['dob'])."',picture='".mysqli_real_escape_string($al,$file_id)."' 
            WHERE email='".$_SESSION['email']."'");
    if($sql){
                move_uploaded_file($_FILES["dp"]["name"],$upload_dir."/".$file_id);
                $msg= "Sucessfully Updated Profile!";
    }
    else{
                $msg= "Try again!";
    }
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
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/6b326a02a1.js" crossorigin="anonymous"></script> -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>
<body>
    <?php require("banner.php");?>
    <br>
    <div align="center">
        <div id="box">
            <br/>
            <span class="formHeading">Welcome &nbsp;<?php echo $s['name'];?></span><br/>
            <br/>
            <h2 class="heading" style="color: mediumaquamarine; font-family:'Raleway', sans-serif; font-size: '20px'; padding-bottom: 0px">Update Profile</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">

            
            <!-- <i class="fa-light fa-user-pen"></i> -->
            <!-- <i class="bi bi-person-up"></i> -->
            <!-- <i class="fa-solid fa-user-pen"></i> -->
            <!-- <span class="material-symbols-outlined">edit</span> -->
            <br>
           <br>
           <table border="0" cellpadding="5" cellspacing="5">
           <tr>
                <td align="center" colspan="2" style="color: lightgreen; font-size:20px;"><?php if(isset($msg)){echo $msg;}?>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="2">
                    
                <img src="./Profile_pics/<?php echo $s['picture'];?>" height="150" width="150" />
                </td>
            </tr>
            <tr>
                <td align="center" colspan="2">
                    <div class="flex-container">
                        <h2 class="item1" style="color: rgb(224, 45, 224); font-family:'Raleway', sans-serif; font-size: '10px'; align-items:center">Update Profile Picture:</h2> 
                        <input type="file" name="dp" id="selectedFile" style="display: none;" />
                        <input type="button" style="border-radius:40%; background-color: lightgreen; padding:5px; transition: 0.7s;" value="Upload" onclick="document.getElementById('selectedFile').click();"  />
                        <!-- <button type="submit" onclick="document.getElementById('selectedFile').click();">Upload</button> -->
                    </div>
                
                </td>
            </tr>
            <tr>
                <td class="labels">Name:</td>
                <td style="color:mediumturquoise"><input type="name" name="name" value="<?php echo $s['name'];?>"  required/></td>
                
            </tr>
            <tr>
                <td class="labels">Date of Birth:</td>
                <td class="dob" style="color:mediumturquoise;"><input type="date" name="dob" value="<?php echo $s['dob'];?>" size="20" required/></td>
            </tr>
            <tr>
                <td class="labels">Email ID:</td>
                <td style="color:mediumturquoise;"><input type="email" name="email" value="<?php echo $s['email'];?>" size="30" readonly disabled/></td>
            </tr>
            <tr>
                <td class="labels">Address:</td>
                <td style="color:mediumturquoise; width:60px"><textarea name="address" placeholder="Enter Permanent Address" required> <?php echo $s['address'];?></textarea></td>
            </tr>
            <tr>
                <td class="labels" colspan="2" align="center"><button type="submit" value="UPDATE" onClick="return confirm('Are you sure?')">UPDATE</button</td>

            </tr>
</table>
<input type="button" value="BACK" onClick="window.location='profile.php'"/>
<input type="button" value="HOME" onClick="window.location='home.php'"/>
</form>
<br/>
<br/>
</div>
<br/>
<br/>
</div>
<div class="footer-class">
    <div id="footer" >
        &copy; Copyright Priyanka Chaudhari | 2022 
    </div>
    </div>

<!-- <div id="footer" align="center">&copy; Copyright Priyanka-2022 | Designed &amp; Developed by Priyanka -->
</body>
</html> 
