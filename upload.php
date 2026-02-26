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
                    echo "Your file size is too big!";
                }
            }
            else {
                echo "There was an error uploading this file!";
            }
        }
        else {
            echo "You cannot upload this type of file!";
        }   

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Upload</title>
</head>
<body>
    <form action="upload.php?id=<?= htmlspecialchars($articleid) ?>" method="POST" enctype="multipart/form-data">
        <input type="file" name="image">
        <button type="submit" name="submit">Upload</button>
    </form>
</body>
</html>