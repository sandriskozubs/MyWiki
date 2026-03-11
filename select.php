<?php
    
    session_start();

    require("connection.php");
    require("auth.php");
    require("pagination.php");

    $search_result = "";

    if (isset($_GET["search_field"])) {
        $keyword = trim($_GET["search_field"]);

        if ($keyword === "") {
            $search_result = "";
        }
        else {
            $keyword = "%" . $keyword . "%";

            $stmt = $con->prepare("SELECT id, title FROM articles WHERE content LIKE ?");
            $stmt->bind_param("s", $keyword);

            $stmt->execute();
            $search_result = $stmt->get_result();
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>MyWiki</title>
</head>
<body>

    <div id="logout">
        <a class="normal_link" href="logout.php">
            <span id="action_logout">Logout</span>
        </a>
    </div>

    <div class="header">
        <h1>What are you looking for?</h1>
    </div>

    <form method="GET">
        <div class="search_field">
            <input type="text" class="input_field" name="search_field" placeholder="An article about..."> 
            <input type="submit" id="search_button" value="&#8594;">
        </div>
    </form>

    <div class="action_line">
        <a class="normal_link" href="create.php">
            <span id="action_create">Create article</span>
        </a>  
    </div>

    <div class="results_box">
        <?php
            if ($search_result) {
                if ($search_result->num_rows > 0) {
                    echo "Search results:";
                    while ($found_result = $search_result->fetch_assoc()) {
        ?>
                        <a href="article.php?id=<?= htmlspecialchars($found_result["id"]) ?>">
                            <?= htmlspecialchars($found_result["title"]) ?>
                        </a>
        <?php
                    }
                }
                else {
                    echo "No articles found";
                }
            }
        ?>
    </div>

    <?php
        if (empty($articles)) {
            echo "<p>No articles yet. Create one!</p>";
        }
    ?>
    
    <div class="articles">
        <hr>
            <?php foreach ($articles as $article) { ?>
                <div class='article_box'>
                    <h2><a href='article.php?id=<?= htmlspecialchars($article["id"]) ?>'><?= htmlspecialchars($article["title"]) ?></a></h2>
                    <?php $full_content = $article["content"]; ?>
                    <?php if (mb_strlen($full_content) > 250) { // Checks if the full text is bigger than 250 characters ?>
                        <?php $preview_content = mb_substr($article["content"], 0, 250) . "..."; // Creates the preview text ?> 
                        <div class='article_content'><?= nl2br(htmlspecialchars($preview_content)) ?></div>
                    <?php } else { ?>
                        <div class='article_content'><?= nl2br(htmlspecialchars($full_content)) ?></div>
                    <?php } ?>
                </div>
            <?php } ?>
        <hr>
    </div>

    <div class="pages">

            <?php $search_query = isset($_GET["search_field"]) ? "&search_field=" . urlencode($_GET["search_field"]) : ""; ?>

            <?php if ($page > 1) {?>
                <a class="normal_link" href="select.php?page=<?= $page - 1 ?><?= $search_query ?>">
                    <span class="pages_buttons">&larr; Previous</span>
                </a>
            <?php } ?>

            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <a class="normal_link" href="select.php?page=<?= $i ?><?= $search_query ?>">
                    <span class="pages_buttons"><?= $i ?></span>
                </a>
            <?php } ?>

            <?php if ($page < $total_pages) {?>
                <a class="normal_link" href="select.php?page=<?= $page + 1 ?><?= $search_query ?>">
                    <span class="pages_buttons">Next &rarr;</span>
                </a>
            <?php } ?>
    </div>
</body>
</html>