<?php
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";
    $dbname = "ecs417";

    // check if user is logged in
    session_start();

    if (!isset($_SESSION["loggedIn"])) {
        header("Location: login.php");
        exit();
    }

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // get the comment ID to delete
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id =  $_POST['postID'];

        // connect to the database
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "DELETE FROM blogs WHERE blogId='$id' ";

        if ($conn->query($sql) === TRUE) {
            //redirect back to current page to display new comment
            header("Location: {$_SERVER['HTTP_REFERER']}");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
    }
?>