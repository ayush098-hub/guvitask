<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){
    
   $name=($_POST['username']); 
   $phone=($_POST['userphone']);
   $address=($_POST['useraddress']);
   $email = mysqli_real_escape_string($conn, $_POST['usermail']);
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);

   $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass'";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $error[] = 'user already exist';
   }
   elseif (strlen($phone)!=10) {
    $error[] = 'Please enter 10 digit mobile number';
   }
   
   else{
      if($pass != $cpass){
         $error[] = 'password not mathched!';
      }else{
         $insert = "INSERT INTO user_form(name,phone,email,address, password) VALUES('$name','$phone','$email','$address','$pass')";
         mysqli_query($conn, $insert);
         header('location:login_form.php');
      }
   }


$data='';
$filename="data.json";
if(is_file($filename)){
    $data=file_get_contents($filename);
} 
$json_arr=json_decode($data,true);

$json_arr[] = array("name"=> $_REQUEST['username'], "phone"=>$_REQUEST['userphone'],"Address"=>$_REQUEST['useraddress'],"Email"=>$_REQUEST['usermail'],"Password"=>$_REQUEST['password']);

file_put_contents($filename,json_encode($json_arr));

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
</head>
<body>
    
<div class="form-container">

   <form action="" method="post">
      <h3 class="title">register now</h3>
      <?php
         if(isset($error)){
            foreach($error as $error){
               echo '<span class="error-msg">'.$error.'</span>';
            }
         }

      ?>
      <input type="text" name="username" placeholder="enter your name" class="box" required>
      <input type="number" name="userphone" placeholder="enter your phone number" class="box" required>
      <input type="text" name="useraddress" placeholder="enter your address" class="box" required>
      <input type="email" name="usermail" placeholder="enter your email" class="box" required>
      <input type="password" name="password" placeholder="enter your password" class="box" required>
      <input type="password" name="cpassword" placeholder="confirm your password" class="box" required>
      
      <input type="submit" value="register now" class="form-btn" name="submit">
      <p>already have an account? <a href="login_form.php">login now!</a></p>
   </form>

</div>

</body>
</html>