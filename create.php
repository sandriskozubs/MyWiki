<?php

    session_start();

    require("connection.php");
    require("auth.php");

    $error = "";

    if (isset($_POST["submit"])) {

        $title = trim($_POST["title"]); 
        $content = trim($_POST["content"]); 
        $created_at = date("Y-m-d");

        if ($title === "" || $content === "") { 
            $error .= "<p class='error'><b>!!</b> Title and content cannot be empty</p>"; 
        }
        else {
            $stmt = $con->prepare("INSERT INTO articles (title, content, created_at) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $content, $created_at);

            if (!$stmt->execute()) {
                $error = "Error: " . $stmt->error;
            } else {
                header("Location: select.php");
                exit;
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Create</title>
</head>
<body>
    <h1>Rakstu veidošana</h1>

    <?php
        if (!empty($error)) {
            echo $error;
        }
    ?>

    <form method="POST">
        <div class="fields_box2">
            <input 
                required
                type="text" 
                class="input_field" 
                name="title" 
                placeholder="Virsraksts..." 
                value="<?= htmlspecialchars($title ?? '') ?>"
            >

            <textarea
                required 
                id="input_content" 
                placeholder="Šis raksts ir par..." 
                name="content" 
                rows="6" 
                cols="100" 
            ><?= htmlspecialchars($content ?? '') ?></textarea>

            <div class="action_box2">
                <input 
                    type="submit" 
                    id="action_save" 
                    name="submit" 
                    value="Saglabāt"
                >

                <a class="normal_link" href="select.php">
                    <span id="action_return">
                        &larr; Atgriezties
                    </span>
                </a>
            </div>
        </div>
    </form>
</body>
</html>