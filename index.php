<?php

    session_start();
    
    $error = "";

    require("connection.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        
        $username = $_POST["username"];
        $password = $_POST["password"];

        if (empty($username) || empty($password)) {
            $error .= "<p class='error'><b>!!</b> Dont leave any fields empty!</p>";
        }
        else {
            $stmt = $con->prepare("SELECT username, password FROM admins WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();

            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                $error .= "<p class='error'><b>!!</b> Incorrect username or password</p>";
            }
            else {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row["password"]) && $row["username"] == $username) {
                    $_SESSION["admin"] = $row["username"];
                    header("Location: select.php");
                    exit;
                }
                else {
                    $error .= "<p class='error'><b>!!</b> Incorrect username or password</p>";
                }
            }
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

    <?= $error ?>

    <div class="login_info">
        <span>Login to use MyWiki</span>
    </div>

    <form method="POST" action="">
        <div class="login_box">
            <input required type="text" class="input_field" placeholder="Username..." name="username">
            <input required type="password" class="input_field" placeholder="Password..." name="password">
            <input type="submit" id="action_login" name="submit" value="Login">
        </div>
    </form>
</body>
</html>