<?php

    require('connection.php');

    $articleid = $_GET["id"];

    if (isset($_POST["submit"])) {
        $file = $_FILES['image'];

        $fileName = $_FILES["image"]["name"];
        $fileTmpName = $_FILES["image"]["tmp_name"];
        $fileSize = $_FILES["image"]["size"];
        $fileError = $_FILES["image"]["error"];
        $fileType = $_FILES["image"]["type"];

        $fileExt = explode(".", $fileName);

        $fileActualExt = strtolower(end($fileExt));

        $allowed = ["jpg", "jpeg", "png"];

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {
                    $fileDestination = "uploads/" . $fileName;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    $stmt = $con->prepare("INSERT INTO article_images (article_id, file_path) VALUES(?, ?)");
                    $stmt->bind_param("is", $articleid, $fileName);
                    $stmt->execute();

                    header("Location: edit.php?id=" . $articleid);
                }
                else {
                    echo "<span id='error'>Your file size is too big!</span>";
                }
            }
            else {
                echo "<span id='error'>There was an error uploading this file!</span>";
            }
        }
        else {
            echo "<span id='error'>You cannot upload this type of file!</span>";
        }   
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>
        Upload
    </title>
</head>
<body>
    <form class="upload_form" action="upload.php?id=<?= htmlspecialchars($articleid) ?>" method="POST" enctype="multipart/form-data">
        <div class="header">
            <h1>
                Uploading a file
            </h1>
        </div>
        <input id="input_image" type="file" name="image">

        <div class="action_box2">
            <button type="submit" id="action_upload" name="submit">
                Upload
            </button>

            <a class="normal_link" href="select.php">
                <span id="action_return">
                    &larr; Return
                </span>
            </a>
        </div>
    </form>
</body>
</html>