<?php

    require("connection.php");

    $articleid = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

    if ($articleid <= 0) {
        echo "Invalid article ID.";
        exit;
    }

    // Gets article title and content
    $stmt = $con->prepare("SELECT title, content FROM articles WHERE id = ?");
    $stmt->bind_param("i", $articleid);
    $stmt->execute();
    $result = $stmt->get_result();
    $article = $result->fetch_assoc();

    if (!$article) { 
        echo "Article not found!"; 
        exit; 
    }

    if (isset($_POST["submit"])) {
        $title = $_POST["title"]; 
        $content = $_POST["content"]; 
        $updated_at = date("Y-m-d");

        if (empty($title) || empty($content)) {
            die("Title and content cannot be empty.");
        }

        $stmt = $con->prepare("UPDATE articles SET title = ?, content = ?, updated_at = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $content, $updated_at, $articleid);

        if (!$stmt->execute()) { 
            echo "Error: " . $stmt->error; 
        }
        else {
            header("Location: article.php?id=" . $articleid);
            exit;
        }
    }

    // Gets images
    $stmt = $con->prepare("SELECT file_path FROM article_images WHERE article_id = ?");
    $stmt->bind_param("i", $articleid);
    $stmt->execute();
    $images = $stmt->get_result();

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
    <div class="header">
        <h1>Editing an article</h1>
    </div>

    <form method="POST" action="">
        <div class="fields_box">

        <div class="edit_text_container">
            <input type="text" id="input_field" name="title" placeholder="Title..." value="<?= htmlspecialchars($article["title"]) ?>">

            <a class="normal_link" href="<?= "upload.php?id=" . htmlspecialchars($articleid) ?>">
                <span id="action_upload">Upload an image</span>
            </a>

            <textarea 
                id="input_content" 
                name="content" 
                placeholder="This article contains..." 
                rows="6" cols="100"><?= htmlspecialchars($article["content"]) ?></textarea>
            
            <div class="action_box2">
                <input type="submit" id="action_save" name="submit" value="Save">

                <a class="normal_link" href="article.php?id=<?= htmlspecialchars($articleid) ?>">
                    <span id="action_return">
                        &larr; Return
                    </span>
                </a>
            </div>
        </div>

            <!-- Outputs clickable images (images that are connected to the article) in the image panel -->
            <div class="image_panel">
                <?php if ($images->num_rows > 0): ?>
                    <div class="image_thumbnails">
                        <?php while ($img = $images->fetch_assoc()): ?>
                            <div class="thumbnail">
                                <img src="uploads/<?= htmlspecialchars($img["file_path"]); ?>" 
                                width="80" 
                                onclick='insertTag(<?= json_encode($img["file_path"]) ?>)'>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <script>
        function insertTag(filename) {
            const textarea = document.getElementById("input_content");
            const pos = textarea.selectionStart;
            const before = textarea.value.substring(0, pos);
            const after = textarea.value.substring(pos);
            textarea.value = before + "{img:" + filename + "}" + after;
            textarea.focus();
        }
    </script>
</body>
</html>