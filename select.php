<?php
    require("connection.php");

    $query = "SELECT * FROM articles LIMIT 5";

    $result = mysqli_query($con, $query);

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

    <h1>What are you looking for?</h1>

    <div class="header">

        <div class="action_box2">
            <a class="normal_link" href="create.php">
                <span id="action_create">Create article</span>
            </a>
        </div>    


    </div>
    

    <?php 

        while ($values = mysqli_fetch_assoc($result)) {
            echo "<div class='article_box'>";
                echo "<h2><a href='article.php?id=" . $values["id"] . "'>" . $values["title"] . "</a></h2>";
                echo "<div class='article_text article_margin_left'>" . $values["content"] . "</div>";
            echo "</div>";
        }

    ?>

</body>
</html>