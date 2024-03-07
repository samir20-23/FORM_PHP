
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="FORM.css">
</head>
<body>

<?php
function filterdata($data){
  $data = htmlspecialchars($data);
  $data = stripslashes($data);
  $data = trim($data);
  return $data;
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $dbname = filterdata($_POST['dbname']);
  $tbname = filterdata($_POST['tbname']);
  $c1 = filterdata($_POST['c1']);
  $c2 = filterdata($_POST['c2']);
  $c3 = filterdata($_POST['c3']);
  $c4 = filterdata($_POST['c4']);

  $v1 = filterdata($_POST['v1']);
  $v2 = filterdata($_POST['v2']);
  $v3 = filterdata($_POST['v3']);
  $username = "SAMIR";
  $password = "samir123";
  try{
    $con = new PDO("mysql:host=localhost", $username, $password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //createDatabase
    $creatDataBase = "CREATE DATABASE IF NOT EXISTS   $dbname";
    $con->exec($creatDataBase);
     $con->exec("USE $dbname");
    //creatTable
        
        $creatTable = "CREATE TABLE IF NOT EXISTS $tbname(
          $c1 INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          $c2 VARCHAR (30) NOT NULL,
          $c3 VARCHAR (30) NOT NULL,
          $c4 VARCHAR (30) NOT NULL )";
           $con->exec($creatTable);
        
       //insert data values columents
       $insert = $con->prepare("INSERT INTO $tbname( $c2 , $c3 , $c4) VALUES(:v1,:v2,:v3)");
       $insert->bindParam(':v1',$v1);
       $insert->bindParam(':v2',$v2);
       $insert->bindParam(':v3',$v3);
       $insert->execute();

      //create list
       echo "<table>";
       echo "<tr><th>$c1</th><th>$c2</th><th>$c3</th><th>$c4</th></tr>";
       //class list
 class MySelect extends RecursiveIteratorIterator{
       function __construct($const){
        parent::__construct($const , self::LEAVES_ONLY);
       }
       function current(){
        return "<td>".parent::current()."</td>";

       }
       function beginChildren(){
        echo "<tr>";
       }
       function endChildren(){
        echo "</tr>"."\n";
       }
       }
//select data 
 $select = $con->prepare("SELECT $c1,$c2,$c3,$c4 FROM $tbname");
$select->execute();

$select->setFetchMode(PDO::FETCH_ASSOC);
foreach(new MySelect(new RecursiveArrayIterator($select->fetchAll()))as $key => $value){
  echo $value;
}


      //conect
  echo "<p>* connect *</p>";
echo "</table>";


  } catch (PDOException $e) {
    echo "<span>* note connec *</span>t"."\n".$e->getMessage();
  }
  
} 
?>