<?php

    require("connection.php");

    $articleid = $_GET["id"];

    $stmt = $con->prepare("SELECT title, content FROM articles WHERE id = ?");

    $stmt->bind_param("i", $articleid);
    $stmt->execute();

    $result = $stmt->get_result();
    $article = $result->fetch_assoc();

    if (isset($_POST["submit"])) {

        $title = $_POST["title"]; 
        $content = $_POST["content"]; 
        $updated_at = date("Y-m-d");

        $stmt = $con->prepare("UPDATE articles SET title = ?, content = ?, updated_at = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $content, $updated_at, $articleid);

        if (!$stmt->execute()) { 
            echo "Error: " . $stmt->error; 
        }

        header("Location: article.php?id=" . $articleid);
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
    <h1>Editing an article</h1>
    
    <?php
        
        if (!$article) { 
            echo "Article not found!"; 
            exit; 
        }

    ?>

    <form method="POST" action="">
        <div class="fields_box">
            <input type="text" id="input_field" name="title" placeholder="Title..." value="<?= htmlspecialchars($article["title"]) ?>">

            <div>
                <a class="normal_link" href=<?="upload.php?id=" . htmlspecialchars($articleid) ?>>
                    <span id="action_upload">
                        Upload an image
                    </span>
                </a>
            </div>

            <textarea 
                id="input_content" 
                name="content" 
                placeholder="This article contains..." 
                rows="6" cols="100"><?= htmlspecialchars($article["content"]) ?></textarea>
            
            <div class="action_box2">
                <input type="submit" id="action_save" name="submit" value="Save">

                <a class="normal_link" href="article.php?id=<?php echo $articleid; ?>">
                    <span id="action_return">
                        <- Return
                    </span>
                </a>
            </div>
        </div>
    </form>
</body>
</html>