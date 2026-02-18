<?php

    require("connection.php");

    if (isset($_POST["submit"])) {

        $title = $_POST["title"];
        $content = $_POST["content"];

        $query = "INSERT INTO articles (title, content, created_at) 
        VALUES ('" . $_POST["title"] . "', '" . $_POST["content"] . "', '" . date("Y-m-d") . "');";

        mysqli_query($con, $query);

        header("Location: select.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Creating</title>
</head>
<body>

    <h1>Creating an article</h1>

    <form method="POST">
        <input type="text" name="title" placeholder="Title..."><br>
        <textarea id="article_content" name="content" rows="4" cols="50"></textarea>
        <br>


        <div class="action_box">
        <input type="submit" id="action_save" name="submit" value="Save">

        <a class="normal_link" href="select.php">
            <span id="action_return">
                <- Return
            </span>
        </a>
        </div>
    </form>

</body>
</html>