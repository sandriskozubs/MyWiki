<?php 

    require("connection.php");

    $articleid = $_GET["id"]; 

    function parseImages ($text) {

        // Alignment and width: {img:url|left|200}
        $text = preg_replace_callback (
            '/\{img:(.*?)\|(left|right|center)\|(.*?)\}/',
            function($m) {
                $src = preg_match('/^https?:\/\//', $m[1]) ? $m[1] : "uploads/" . $m[1];
                return '<img src="' . $src . '" style="float:' . $m[2] . ';" width="' . $m[3] . '" alt="">';
            },
            $text
        );

        // Width only: {img:url|200}
        $text = preg_replace_callback (
            '/\{img:(.*?)\|(.*?)\}/',
            function($m) {
                $src = preg_match('/^https?:\/\//', $m[1]) ? $m[1] : "uploads/" . $m[1];
                return '<img src="' . $src . '" width="' . $m[2] . '" alt="">';
            },
            $text
        );

        // Basic image: {img:url}
        $text = preg_replace_callback (
            '/\{img:(.*?)\}/',
            function($m) {
                $src = preg_match('/^https?:\/\//', $m[1]) ? $m[1] : "uploads/" . $m[1];
                return '<img src="' . $src . '" alt="">';
            },
            $text
        );

        return $text;
    }

    $stmt = $con->prepare("SELECT title, content, created_at, updated_at FROM articles WHERE id = ?");

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
        ?>
                <div class='article_box'>
                    <h2>
                        <?= htmlspecialchars($article["title"]) ?>
                    </h2>

                    <div class="article_info">
                        Created at: <?= $article["created_at"] ?>
                        <br>
                        <?php 
                            if ($article["updated_at"] == "") {
                                echo "";
                            }
                            else {
                                echo "Updated at: " . $article["updated_at"];
                            }
                        ?>
                    </div>

                    <div class='article_content'>
                        <?= nl2br(parseImages($article["content"])) ?>
                    </div>
                </div>
        <?php
            }
        ?>

        <div class="action_box">
            <a class="normal_link" href="select.php">
                <span id="action_return">
                    &larr; Return
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