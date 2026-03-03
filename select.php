<?php
    
    session_start();

    require("connection.php");
    require("auth.php");

    $stmt = $con->prepare("SELECT id, title, content FROM articles LIMIT 5");

    $stmt->execute();
    $result = $stmt->get_result();

    $search_result = "";

        if (isset($_GET["search_field"])) {
            $keyword = trim($_GET["search_field"]);

            if ($keyword === "") {
                $search_result = "";
            }
            else {
                $keyword = "%" . $keyword . "%";

                $stmt = $con->prepare("SELECT id, title FROM articles WHERE content LIKE ?");
                $stmt->bind_param("s", $keyword);

                $stmt->execute();
                $search_result = $stmt->get_result();
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

        <div id="logout">
            <a class="normal_link" href="logout.php">
                <span id="action_logout">Logout</span>
            </a>
        </div>

        <div class="header">
            <h1>What are you looking for?</h1>
        </div>

        <form method="GET" action="select.php">
            <div class="search_field">
                <input type="text" class="input_field" name="search_field" placeholder="An article about..."> 
                <input type="submit" id="search_button" value="&#8594;">
            </div>
        </form>

    <div class="action_line">
        <a class="normal_link" href="create.php">
            <span id="action_create">Create article</span>
        </a>  
    </div>

    <div class="results_box">
        <?php
            if ($search_result) {
                if ($search_result->num_rows > 0) {
                    echo "Search results:";
                    while ($found_result = $search_result->fetch_assoc()) {
        ?>
                        <a href="article.php?id=<?php echo htmlspecialchars($found_result["id"]); ?>">
                            <?= htmlspecialchars($found_result["title"]) ?>
                        </a>
        <?php
                    }
                }
                else {
                    echo "No articles found";
                }
            }
        ?>
    </div>

    <?php

        if ($result->num_rows == 0) {
            echo "<p>No articles yet. Create one!</p>";
        }

    ?>
    
    <div class="article_box">
        <hr>
        <?php
        
            while ($row = $result->fetch_assoc()) {
                echo "<div class='article_box'>";
                    echo "<h2><a href='article.php?id=" . htmlspecialchars($row["id"]) . "'>" . htmlspecialchars($row["title"]) . "</a></h2>";
                    $full_content = $row["content"];
                    if (mb_strlen($full_content) > 250) { // Checks if the full text is bigger than 250 characters
                        $preview_content = mb_substr($row["content"], 0, 250) . "..."; // Creates the preview text
                        echo "<div class='article_content'>" . nl2br(htmlspecialchars($preview_content)) . "</div>";
                    }
                    else {
                        echo "<div class='article_content'>" . nl2br(htmlspecialchars($full_content)) . "</div>";
                    }
                    
                echo "</div>";
            }
            
        ?>
        <hr>
    </div>
</body>
</html>