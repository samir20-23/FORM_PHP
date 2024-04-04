<?php
$login=$loginFailed= $fill="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  include "controls.php";

  if (!empty($_POST["email"]) && !empty($_POST["password"])) {

    if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {

     
      function filter($data){
      $data =trim($data);
      $data = htmlspecialchars($data);
      $data = stripslashes($data);
      return $data ;
      }
      $email = filter($_POST["email"]);
      $password =filter( $_POST["password"]);

      try {
        $connect = new PDO("mysql:host=localhost;dbname=$dbname",$user, $pass);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $connect->query("SELECT email, password FROM $tbname");
        $select = $statement->fetchAll(PDO::FETCH_COLUMN);

        foreach ($select as $k) {
          if ($email == $k) {
            $login= "login successfull";
            echo '<div style="display: flex; justify-content: center; align-items: center;"><img src="imgs/check.gif" width="300px" ></div>
          ';
          }
        }
      } catch (Exception $e) {
        $loginFailed="login failed! <div style='display: flex; justify-content: center; align-items: center;'><img src='imgs/giphy.gif' width='300px' ></div>" . $e->getMessage();
      }
    } else {
      $fill="please enter a valid email";
    }
  } else {
    echo "don't leave empty inputs";
  }
}
