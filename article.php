<?php 

    require("connection.php");

    $articleid = $_GET["id"]; 
    // echo $articleid;

    $stmt = $con->prepare("SELECT * FROM articles WHERE id = ?");
    $stmt->bind_param("i", $articleid);

    $stmt->execute();

    $result = $stmt->get_result();

    $article = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title><?= htmlspecialchars($article["title"]); ?></title>
</head>
<body>

    <div class="article_container">

        <?php 

            if (!$article) {
                echo "Article not found!";
            }
            else {
                echo "<div class='article_box'>";
                    echo "<h2>" . htmlspecialchars($article["title"]) . "</h2>";
                    echo "<div class='article_text article_margin_left'>" . nl2br(htmlspecialchars($article["content"])) . "</div>";
                echo "</div>";
            }
            
        ?>

        <div class="action_box">
            <a class="normal_link" href="select.php">
                <span id="action_return">
                    <- Return
                </span>
            </a>

            <a class="normal_link" href="edit.php?id=<?= $articleid; ?>">
                <span id="action_edit">
                    Edit
                </span>
            </a>

            <a class="normal_link" href="delete.php?id=<?= $articleid; ?>">
                <span id="action_delete">
                    Delete
                </span>
            </a>
        </div>
    </div>

</body>
</html>