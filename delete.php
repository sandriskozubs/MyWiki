<?php

    require("connection.php");

    $articleid = $_GET["id"];

    $query = "SELECT title, content FROM articles WHERE id = " . $articleid;

    $result = mysqli_query($con, $query);

    $values = mysqli_fetch_assoc($result);

    if (isset($_POST["submit"])) {
        $query = "DELETE FROM articles WHERE id = " . $articleid;
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
    <title>Editing</title>
</head>
<body>
    
    <h1>Deleting an article</h1>

    <p id="error">Do you really want to delete this article:</p>
    <span class="delete_title" id="error">'<b><?php echo $values["title"]; ?></b>' ?</span>

    <form method="POST" action="">
        
        <div class="action_box2">
            <input type="submit" id="action_delete" name="submit" value="Delete">

            <a class="normal_link" href="article.php?id=<?php echo $articleid; ?>">
                <span id="action_return">
                    <- Return
                </span>
            </a>
        </div>

    </form>
</body>
</html>