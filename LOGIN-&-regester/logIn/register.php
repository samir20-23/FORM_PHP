<?php


if ($_SERVER['REQUEST_METHOD'] == "POST") {
function filerdata($data)
{
  $data = htmlspecialchars($data);
  $data = stripslashes($data);
  $data = trim($data);
  return $data;
}
include "controls.php";
  if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmpass'])) {

    if (preg_match('/^[a-zA-Z0-9]{5,20}$/', $_POST['username']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && $_POST['confirmpass'] == $_POST['password']) {
      $username = filter_var($_POST['username']);
      $email = filerdata($_POST['email']);
      $password = filerdata($_POST['password']);
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      try { 
        $con = new PDO("mysql:host=localhost;dbname=$dbname",$user, $pass);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $select = $con->query("SELECT username , email , password FROM $tbname WHERE email='$email'");
        $slt = $select->fetch();
        if( $slt && $email == $slt["email"]){
          echo "change  email";
        }else{

       
        $insert = $con->prepare("INSERT INTO $tbname (username , email , password) VALUES(:username, :email ,:password)");
        $insert->bindParam(':username', $username);
        $insert->bindParam(':email', $email);
        $insert->bindParam(':password', $hashedPassword);
        $insert->execute();
        

  header("location:log_in.html");
  
 }

      } catch (PDOException $e) {
 
        echo "note connect <img src='imgs/giphy.gif' width='300px'>" . $e->getMessage();
      }
    } else {
      echo "confirmpassword is badd ";
    }
  } else {
    echo "<span>* FILL *</span>";
  }


  
}
