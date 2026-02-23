<?php

    require("connection.php");

    $stmt = $con->prepare("SELECT * FROM articles LIMIT 5");

    $stmt->execute();
    $result = $stmt->get_result();

    $search_result = "";

    if (isset($_GET["search"])) {
        $keyword = "%" . $_GET["search"] . "%";
        $stmt = $con->prepare("SELECT * FROM articles WHERE content LIKE ?");

        $stmt->bind_param("s", $keyword);
        $stmt->execute();

        $search_result = $stmt->get_result();
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

    <h1>What are you looking for?</h1>

    <div class="search_field">
        <form method="GET" action="select.php">
            <input type="text" id="input_field" name="search" placeholder="A article about..."> 
        </form>
    </div>

    <br>

    <div class="header">
        <div class="action_box2">
            <a class="normal_link" href="create.php">
                <span id="action_create">Create article</span>
            </a>
        </div>    
    </div>

    <div class="results_box">
        <?php
        
            if ($search_result) {   
                if ($search_result->num_rows > 0) {
                    echo "Search results:";
                    while ($found_result = $search_result->fetch_assoc()) {
        ?>
                        <a href="article.php?id=<?php echo htmlspecialchars($found_result["id"]); ?>"><?= htmlspecialchars($found_result["title"]) ?></a>
                        <hr>
        <?php
                    }
                }
            };
        ?>
    </div>

    <?php

        if ($result->num_rows == 0) {
            echo "<p>No articles yet. Create one!</p>";
        }

    ?>
    
    <div class="article_box">
        <?php
            while ($row = $result->fetch_assoc()) {
                echo "<div class='article_box'>";
                    echo "<h2><a href='article.php?id=" . $row["id"] . "'>" . htmlspecialchars($row["title"]) . "</a></h2>";
                    $full_content = $row["content"];
                    if (mb_strlen($full_content) > 200) { // Checks if the full text is bigger thatn 200 characters
                        $preview_content = mb_substr($row["content"], 0, 250) . "..."; // Creates the preview text
                        echo "<div class='article_text article_margin_left'>" . nl2br(htmlspecialchars($preview_content)) . "</div>";
                    }
                    else {
                        echo "<div class='article_text article_margin_left'>" . htmlspecialchars($full_content) . "</div>";
                    }
                    
                echo "</div>";
            }
            
        ?>
    </div>
</body>
</html>