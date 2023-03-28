<?php
    define("host","localhost");
    define("database", "lab9");
    define("user", "webuser");
    define("password","P@ssw0rd");

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $username = filter_input(INPUT_POST,"username",FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST,"password",FILTER_SANITIZE_STRING);
    }

    if ( !isset($username) || !isset($password) ){
        $output = "<p>INVALID DATA</p>";
        exit($output);
     }

  $connection = mysqli_connect(host, user, password, database);
  if(mysqli_connect_error() != null){
        $output = "<p>Unable to connect to database!</p>";
        exit($output);
  }

    $sql = "SELECT * FROM users WHERE users.username = ? and users.password = md5(?);";
    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) > 0){
        echo "<p>yay, you have an account, ",$username,".</p>";
    }else{
        echo "<p>Account for username and password combo for user ",$username," does not exist</p>";
    }
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
?>