    <?php

        const HOST = "localhost";
        const USERNAME = "root";
        const PASSWORD = "";
        const DB_NAME= "my_wiki1";
        
        $con = mysqli_connect(HOST, USERNAME, PASSWORD, DB_NAME);

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }