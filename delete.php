<?php

    require("connection.php");

    $articleid = $_GET["id"];

    $stmt = $con->prepare("SELECT title, content FROM articles WHERE id = ?");

    $stmt->bind_param("i", $articleid);
    $stmt->execute();

    $result = $stmt->get_result();
    $article = $result->fetch_assoc();

    if (!$article) { 
        echo "<p>Article not found.</p>"; 
        exit;
    }

    if (isset($_POST["submit"])) {
        
        $stmt = $con->prepare("DELETE FROM articles WHERE id = ?");
        $stmt->bind_param("i", $articleid);
        
        $stmt->execute();

        header("Location: select.php");
        exit;
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
    <div>
        <h1>Deleting an article</h1>
    </div>

    <p id="error">
        Do you really want to delete this article:
    </p>
    
    <span class="delete_title" id="error">
        '<b>
            <?=  htmlspecialchars($article["title"]); ?>
        </b>' ?
    </span>

    <form method="POST" action="">
        
        <div class="action_box2">
            <input type="submit" id="action_delete" name="submit" value="Delete">

            <a class="normal_link" href="article.php?id=<?=  htmlspecialchars($articleid); ?>">
                <span id="action_return">
                    <- Return
                </span>
            </a>
        </div>

    </form>
</body>
</html>