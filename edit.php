<?php

    require("connection.php");

    $articleid = $_GET["id"];

    $query = "SELECT title, content FROM articles WHERE id = " . $articleid;

    $result = mysqli_query($con, $query);

    $values = mysqli_fetch_assoc($result);

    if (isset($_POST["submit"])) {

        $title = $_POST["title"]; 
        $content = $_POST["content"]; 
        $updated_at = date("Y-m-d");

        $stmt = $con->prepare("UPDATE articles SET title = ?, content = ?, updated_at = ? WHERE id = " . $articleid);
        $stmt->bind_param("sss", $title, $content, $updated_at);

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

    <form method="POST" action="">
    
        <input type="text" name="title" placeholder="Title..." value="<?php echo $values["title"] ?>"><br>
        
        <textarea 
            id="" 
            name="content" 
            placeholder="This article contains..." 
            rows="4" cols="50"><?php echo $values["content"] ?></textarea><br>
        
        <div class="action_box2">
            <input type="submit" id="action_save" name="submit" value="Save">

            <a class="normal_link" href="article.php?id=<?php echo $articleid; ?>">
                <span id="action_return">
                    <- Return
                </span>
            </a>
        </div>

    </form>
</body>
</html>