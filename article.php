<?php 

    require("connection.php");

    $articleid = $_GET["id"]; 
    // echo $articleid;

    $query = "SELECT * FROM articles WHERE id = " . $articleid;

    $result = mysqli_query($con, $query);

    $values = mysqli_fetch_assoc($result);

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title><?php echo $values["title"]; ?></title>
</head>
<body>
    
    <div class="article_container">

        <?php 
            
                echo "<div class='article_box'>";
                    echo "<h2>" . $values["title"] . "</h2>";
                    echo "<div class='article_text article_margin_left'>" . $values["content"] . "</div>";
                echo "</div>";

        ?>

        <div class="action_box">
            <a class="normal_link" href="select.php">
                <span id="action_return">
                    <- Return
                </span>
            </a>

            <a class="normal_link" href="edit.php?id=<?php echo $articleid; ?>">
                <span id="action_edit">
                    Edit
                </span>
            </a>

            <a class="normal_link" href="delete.php?id=<?php echo $articleid; ?>">
                <span id="action_delete">
                    Delete
                </span>
            </a>
        </div>
    </div>

</body>
</html>