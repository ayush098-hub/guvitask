<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['usermail'])){
   header('location:login_form.php');
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
    
<div class="container">
   <div class="content">
      <h3>Welcome!</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem maxime necessitatibus itaque sit adipisci odit debitis temporibus aliquid nisi totam.</p>
      <p>your email : <span><?php echo $_SESSION['usermail']; ?></span></p>
<p>
    
<?php 

$mail=$_SESSION['usermail'];  
      
$sql="SELECT * FROM `user_form` WHERE email='$mail'";
$result=mysqli_query($conn,$sql);

$num=mysqli_num_rows($result);


if($num>0){
   while ($row=mysqli_fetch_assoc($result)) {
    $name1 = $row['name'];
    echo "<br>";
    $phone1 = $row['phone'];
    echo "<br>";
    $address1= $row['address'];
   }
    
}

if(isset($_POST['submit'])){
    
    $updatedname=($_POST['username']); 
    $updatedphone=($_POST['userphone']);
    $updatedaddress=($_POST['useraddress']);
    
    if (strlen($updatedphone)!=10) {
     $error[] = 'Please enter 10 digit mobile number';
    }
    else{
        //   $sql = "UPDATE `user_form` SET `name`='$updatedname', `phone`='$updatedphone' ,`address`='$updatedaddress' WHERE email='$mail';";
                  $sql = "UPDATE `user_form` SET `name`='$updatedname', `phone`='$updatedphone' ,`address`='$updatedaddress' WHERE email='$mail';";

          mysqli_query($conn, $sql);
          header('location:header.php');
          
       }  
 }



?>

</p>

<div class="form-container">

   <form action="" method="post">
      <h3 class="title">Update your Information</h3>
      <?php
         if(isset($error)){
            foreach($error as $error){
               echo '<span class="error-msg">'.$error.'</span>';
            }
         }
        

      ?>
      <input type="text" name="username" placeholder="enter your name" class="box" value=<?php echo $name1;?> >
      <input type="number" name="userphone" placeholder="enter your phone number" class="box" value=<?php echo $phone1;?> >
      <input type="text" name="useraddress" placeholder="enter your address" class="box" value=<?php echo $address1;?> >

      
      <input type="submit" value="Update Now" class="form-btn" name="submit">
     
   </form>

</div>
<a href="logout.php" class="logout">logout</a>
   </div>
</div>



</body>
</html>