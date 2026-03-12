<?php 

    $result_limit = 3;

    $articles = [];

    $stmt = $con->prepare("SELECT COUNT(id) AS total from articles");
    $stmt->execute();

    $result = $stmt->get_result();

    $total_results = $result->fetch_assoc();

    $total_pages = ceil($total_results["total"] / $result_limit);

    $stmt->close();

    $page = "";

    if (isset($_GET["page"])) {
        $page = (int) $_GET["page"];
        $start_from = ($page - 1) * $result_limit;
        $stmt = $con->prepare("SELECT * FROM articles LIMIT ?, ?");
        $stmt->bind_param("ii", $start_from, $result_limit);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }
    }
    else {
        $page = 1;
        $start_from = 0;
        $stmt = $con->prepare("SELECT * FROM articles LIMIT ?, ?");
        $stmt->bind_param("ii", $start_from, $result_limit);
        $stmt->execute();

        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $articles[] = $row;
        }
    }