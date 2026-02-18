<?php

    require("connection.php");

    if(isset($_POST["submit"])) {
        // var_dump($_POST);
        $username = $_POST["username"];
        $password = $_POST["password"];
        $query = "SELECT admins.username, admins.password FROM admins WHERE admins.username = '" . $username  . "'" . "AND admins.password = '" . $password . "'";

        $result = mysqli_query($con, $query);


        if (mysqli_num_rows($result) == 0) {
            echo "<p id='error'>Incorrect username or password</p>";
        }
        else {
            $result_array = mysqli_fetch_assoc($result);

            echo "<p id='test'>Matched rows: " . mysqli_num_rows($result) . "</p>";
            echo "<p id='test'>Returned value: " . $result_array["username"] . "</p>";
            echo "<p id='test'>Returned value: " . $result_array["password"] . "</p>";

            header("Location: select.php");
        }

        
        mysqli_close($con);
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>MyWiki</title>
</head>
<body>

    <h1>Your own Wiki</h1>

    <form method="POST" action="">

        <div>
            <input type="text" placeholder="Username..." name="username"><br>
            <input type="password" placeholder="Password..." name="password"><br>
            <input type="submit" name="submit" value="Log in">
        </div>

    </form>

</body>
</html>