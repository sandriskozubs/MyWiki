<?php

    require("connection.php");

    if(isset($_POST["submit"])) {
        // var_dump($_POST);
        $username = $_POST["username"];
        $password = $_POST["password"];
        $query = "SELECT username, password FROM admins WHERE username = '" . $username  . "'" . "AND password = '" . $password . "'";

        $result = mysqli_query($con, $query);


        if (mysqli_num_rows($result) == 0) {
            echo "<p id='error'><b>!!</b> Incorrect username or password</p>";
        }
        else {
            $result_array = mysqli_fetch_assoc($result);

            echo "<p id='test'>Matched rows: " . mysqli_num_rows($result) . "</p>";
            echo "<p id='test'>Returned value: " . $result_array["username"] . "</p>";
            echo "<p id='test'>Returned value: " . $result_array["password"] . "</p>";

            header("Location: select.php");
            exit;
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

        <div class="login_box">
            <input type="text" id="input_field" placeholder="Username..." name="username">
            <input type="password" id="input_field" placeholder="Password..." name="password">
            <input type="submit" id="action_login" name="submit" value="Log in">
        </div>

    </form>

</body>
</html>