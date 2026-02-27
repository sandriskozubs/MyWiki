<?php

    require("connection.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (empty($username) || empty($password)) {
            echo "<p id='error'><b>!!</b> Dont leave the fields empty!</p>";
            mysqli_close($con);
        }
        else {
            $stmt = $con->prepare("SELECT username, password FROM admins WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                echo "<p id='error'><b>!!</b> Incorrect username or password</p>";
            }
            else {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row["password"]) && $row["username"] == $username) {
                    header("Location: select.php");
                    exit;
                }
                else {
                    echo "<p id='error'><b>!!</b> Incorrect username or password</p>";
                }
            }
            mysqli_close($con);
        }
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
    <div class="login_header">
        <h1>MyWiki</h1>
    </div>

    <div class="login_info">
        <span>Login to use MyWiki</span>
    </div>

    <form method="POST" action="">
        <div class="login_box">
            <input required type="text" id="input_field" placeholder="Username..." name="username">
            <input required type="password" id="input_field" placeholder="Password..." name="password">
            <input type="submit" id="action_login" name="submit" value="Login">
        </div>
    </form>
</body>
</html>