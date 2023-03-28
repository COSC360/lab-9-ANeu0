<?php

define("host","localhost");
define("database", "lab9");
define("user", "webuser");
define("password","P@ssw0rd");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstname = $_POST["firstname"];
  $lastname = $_POST["lastname"];
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];

  if ( !isset($firstname) || !isset($lastname) || !isset($username) || !isset($email) || !isset($password) ){
     $output = "<p>INVALID DATA</p>";
    exit($output);
  }
  $connection = mysqli_connect(host, user, password, database);
  if(mysqli_connect_error() != null){
        $output = "<p>Unable to connect to database!</p>";
        exit($output);
  }

    $sql = "SELECT * FROM users WHERE users.email = ? OR users.username = ?";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) > 0){
        echo "<p>User already exists with this name and/or email</p>";
        echo "<a href='lab9-1.html'>Return to user entry</a>";
    }else{

    $sql = "INSERT INTO users (`username`,`firstName`,`lastName`,`email`,`password`) VALUES (?,?,?,?,md5(?))";
    $stmt = mysqli_prepare($connection, $sql);
     mysqli_stmt_bind_param($stmt, "sssss", $username, $firstname, $lastname,  $email, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<p>Account for user ",$username," has been created</p>";
   }

}
?>
