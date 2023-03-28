<?php
    define("host","localhost");
    define("database", "lab9");
    define("user", "webuser");
    define("password","P@ssw0rd");

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $SearchName = filter_input(INPUT_POST, "username",FILTER_SANITIZE_STRING);
        

        if(!isset($SearchName)){
             $output = "<p>Unable to find user!</p>";
             exit($output);    
        }

        $connection = mysqli_connect(host, user, password, database);
        if(mysqli_connect_error() != null){
        $output = "<p>Unable to connect to database!</p>";
            exit($output);
        }

        $sql = "SELECT * FROM users WHERE username LIKE ?";
        $stmt = mysqli_prepare($connection, $sql);
        $SearchName = '%'.$SearchName.'%';
        mysqli_stmt_bind_param($stmt, 's', $SearchName);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_row($result)) {
            $hasNulls = false;
            foreach ($row as $value) {
                if ($value === null) {
                    $hasNulls=true;
                    continue;
                }
            }
            if(!$hasNulls){
                echo "<fieldset>
                <legend>User ",$row[0],"</legend>
                <table>
                <tr>
                <td>First Name:</td>
                <td>",$row[1],"</td>
                </tr>
                <tr>
                <td>Last Name:</td>
                <td>",$row[2],"</td>
                </tr>
                <tr>
                <td>Email:</td>
                <td>",$row[3],"</td>
                </tr>
                </table>
                </fieldset>";
                }
            }
        }
        else{
            $output = "<p>No results found!</p>";
            exit($output);
        }
            mysqli_stmt_close($stmt);
    mysqli_close($connection);
}

?>
