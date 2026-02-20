<?php
    require("connection.php");

    $stmt = $con->prepare("SELECT * FROM articles LIMIT 5");

    $stmt->execute();

    $result = $stmt->get_result();

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

        if ($result->num_rows == 0) {
            echo "<p>No articles yet. Create one!</p>";
        }

        while ($row = $result->fetch_assoc()) {
            echo "<div class='article_box'>";
                echo "<h2><a href='article.php?id=" . $row["id"] . "'>" . htmlspecialchars($row["title"]) . "</a></h2>";
                $full_content = $row["content"];
                if (mb_strlen($full_content) > 200) { // Checks if the full text is bigger thatn 200 characters
                    $preview_content = mb_substr($row["content"], 0, 200) . "..."; // Creates the preview text
                    echo "<div class='article_text article_margin_left'>" . nl2br(htmlspecialchars($preview_content)) . "</div>";
                }
                else {
                    echo "<div class='article_text article_margin_left'>" . htmlspecialchars($full_content) . "</div>";
                }
                
            echo "</div>";
        }
        
    ?>
</body>
</html>